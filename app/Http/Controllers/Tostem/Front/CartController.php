<?php

namespace App\Http\Controllers\Tostem\Front;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\ExcelService;
use App\Mail\CartPdfToCustomer;
use App\Models\Tostem\Quotation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;



class CartController extends Controller
{

    protected $request;

    protected $session_key;

    protected $session;

    protected $cart;

    protected $lang;

    protected $key_html_cart;
    
    

    function __construct()
    {
        $this->session = app('session');
        $this->session_key = 'SS_CART';
        $this->key_html_cart = 'SS_HTML';
        $this->cart = new CartService($this->session, $this->session_key, $this->key_html_cart);
        $this->lang = str_replace('_', '-', app()->getLocale());

    }

    public function index(Request $request)
    {
        $Cart = $this->cart;
        //dd($Cart->getContent());
        //$Cart->clear();
        if(request()->ajax()) {
            $items = $Cart->get_cart_lang();
            return response(array(
                'success' => true,
                'data' => $items,
                'message' => 'cart get items success'
            ),200,[]);

        } else {
            //dd($this->cart->getContent());
            return view('tostem.front.cart.index');
        }
    }

    public function add(Request $request)
    {
        $Cart = $this->cart;
        $Cart->add($request->all());

        return response(array(
            'success' => true,
            'message' => "product added."
        ),201,[]);
    }


    public function get_quantity_cart () {
        return $this->cart->get_quantity_cart();
    }

    public function update_quantity(Request $request)
    {
        $data_rq = $request->all();
        $id = $data_rq['id'];
        $Cart = $this->cart;
        $Cart->update($id, ['quantity' => $data_rq['quantity']]);
        $items = [];
        $Cart->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });
        return response(array(
            'success' => true,
            'data' => $items,
            'message' => "item Updated."
        ),201,[]);
    }

    //Add Start BP_O2OQ-7 hainp 20200701
    public function update_reference_no(Request $request)
    {
        $data_rq = $request->all();
        $id = $data_rq['id'];
        $Cart = $this->cart;
        $Cart->update($id, ['reference_no' => $data_rq['reference_no']]);
        $items = [];
        $Cart->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });
        return response(array(
            'success' => true,
            'data' => $items,
            'message' => "item Updated."
        ),201,[]);
    }
    //Add Start BP_O2OQ-7 hainp 20200701

    public function delete($id)
    {
        $Cart = $this->cart;

        $Cart->remove($id);

        return response(array(
            'success' => true,
            'data' => $id,
            'message' => "cart item {$id} removed."
        ),201,[]);
    }

    public function details()
    {
        $Cart = $this->cart;
        return response(array(
            'success' => true,
            'data' => array(
                'total_quantity' => 0,//\Cart::session($userId)->getTotalQuantity(),
                'sub_total' => $Cart->getSubTotal(), //\Cart::session($userId)->getSubTotal(),
                'total' => 0, //\Cart::session($userId)->getTotal(),
                'quotation_no' => $Cart->getQuotationNo(),
                'user_name' => $Cart->getUserName(),// Add BP_O2OQ-4 hainp 20200605
                'max_decimal' => $Cart->getMaxDecimal(),// Add BP_O2OQ-7 hainp 20200710
            ),
            'message' => "Get cart details success."
        ),201,[]);
    }

    public function createQuotation (Request $request) {
         
        try {
             
            $this->cart->button_click  =  $request->button_click;
            
            $file_name = $this->cart->saveDbCart();
            $request->session()->put($this->cart->key_file_name, $file_name);
            $user_name = $this->cart->getUserName(); //Add BP_O2OQ-4 hainp 20200608
            $max_decimal = $this->cart->getMaxDecimal();// Add BP_O2OQ-7 hainp 20200710
        } catch (\Exception $e) {
            Log::error('Save DbCart fails: '. $e->getMessage());
            return response(array(
                'status' => 'error',
                'error' => $e->getMessage()
            ), 201);
        }
        return response(array(
            'status' => 'success',
            'file_name' => $file_name,
            'user_name' => $user_name, //Add BP_O2OQ-4 hainp 20200608
            'max_decimal' => $max_decimal,// Add BP_O2OQ-7 hainp 20200710
        ),201,[]);
    }

    public function mail (Request $request) {
        $data_req = $request->all();
        $key_file_name = $this->cart->key_file_name;
        try {
            $name_pdf = $request->session()->get($key_file_name);
            $path_pdf = $this->cart->create_pdf_cart($name_pdf);
            //Save to DB

        } catch (\Exception $e) {
            Log::info("CREATE PDF FAIL"."  :".$e->getMessage());
            return response(array(
                'status' => 'Fails',
                'message' => $e->getMessage(),
                'messagepage' => trans('screen-cart.mes_email_send_error'),
            ),201,[]);
        }
        try {
            Mail::to($data_req['email'])->queue(new CartPdfToCustomer($path_pdf, $name_pdf));
        } catch (\Exception $e) {
            Log::info("SEND MAIL FAIL to ".$data_req['email']." Error  :".$e->getMessage());
            return response(array(
                'status' => 'Fails',
                'message' => $e->getMessage(),
                'messagepage' => trans('screen-cart.mes_email_send_error'),
            ),201,[]);
        }

        if (file_exists($path_pdf)) {
            unlink($path_pdf);
        }
        return response(array(
            'status' => 'OK',
            'message' => "success.",
            'messagepage' => trans('screen-cart.mes_send_success'),
        ),201,[]);
    }

    public function downloadpdf (Request $request) {
        $ss_html = $this->key_html_cart;
        $key_file_name = $this->cart->key_file_name;
        if(request()->ajax())
        {
            $data = $request->all();
            $request->session()->put($ss_html, $data['html']);
            return response(array(
                'success' => true,
                'message' => "Save Dom html success."
            ),201,[]);
        }
        $name_pdf = $request->session()->get($key_file_name);
        $path_pdf = $this->cart->create_pdf_cart($name_pdf);
        $name_pdf .= '.pdf';

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($name_pdf));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path_pdf));
        set_time_limit(0);
        @readfile($path_pdf);//"@" is an error control operator to suppress errors
        if (file_exists($path_pdf)) {
            unlink($path_pdf);
        }

    }

   /* public function downloadcsv(Request $request)
    {
        $Cart = $this->cart;
        $items = [];
        $products = config('cart.data-tmp');
        foreach ($products as $item) {
            unset($item[$Cart->sort_cart]);
            $items[] = $item;
        }

        //dd($items);
        $columns_head = [];
        $file_name = $this->cart->generate_file_name('.csv');
        $headers = array(
            'Content-Encoding: UTF-8',
            'Content-Type: application/csv; charset=UTF-8',
            "Content-Disposition" => "attachment; filename=$file_name",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        //echo "\xEF\xBB\xBF"; // add BOM
        $callback = function() use ($items, $columns_head)
        {
            $file = fopen('php://output', 'w');
            if(count($columns_head) > 0){
                fputcsv($file, $columns_head);
            }

            foreach($items as $review) {
                fputcsv($file, $review); //$review is array is not object
            }
            fclose($file);
        };
        return \Response::stream($callback, 200, $headers);
    }*/

    public function createFileCsv()
    {
        $Cart = $this->cart;
        $items = [];
        $products = [];
        foreach ($products as $item) {
            unset($item[$Cart->sort_cart]);
            $items[] = $item;
        }

        //dd($items);
        $columns_head = [];
        $file_name = Str::random(30);
        $path_file = storage_path('tmp/'.$file_name.'.csv');
        if (file_exists($path_file)) {
            unlink($path_file);
        }

        $file = fopen($path_file, 'w');
        if(count($columns_head) > 0){
            fputcsv($file, $columns_head);
        }

        foreach($items as $review) {
            fputcsv($file, $review); //$review is array is not object
        }
        fclose($file);
        chmod($path_file, 0755);
        return $path_file;
    }

    public function zipFilesAndDownload(Request $request)
    {
        $key_file_name = $this->cart->key_file_name;
        $m_quotation = $this->cart->get_m_quotation();
        $file_name = $request->session()->get($key_file_name);

        if ($m_quotation != null) {
            $param['m_quotation_id'] = $m_quotation->m_quotation_id;
            $excelService = new ExcelService('',new Quotation());
            $path_file_cvs = $excelService->_exportCsvPrivate($param);
        } else {
            $path_file_cvs = $this->createFileCsv();
        }

        $path_pdf = $this->cart->create_pdf_cart($file_name);

        $file_name_csv = $file_name.'.csv';
        $file_name_pdf = $file_name.'.pdf';

        $file_name_rd = Str::random(30);
        $path_file_zip = storage_path('tmp/'.$file_name_rd.'.zip');
        $file_name_zip = $file_name.'.zip';

        if (file_exists($path_file_zip)) {
            unlink($path_file_zip);
        }
        $zip = new \ZipArchive();
        //create the file and throw the error if unsuccessful
        if ($zip->open($path_file_zip, \ZIPARCHIVE::CREATE )!==TRUE) {
            exit("cannot open <$path_file_zip>\n");
        }
        //add each files of $file_name array to archive
        $zip->addFile($path_file_cvs,$file_name_csv);
        $zip->addFile($path_pdf,$file_name_pdf);
        $zip->close();
        chmod($path_file_zip, 0755);
        //then send the headers to force download the zip file
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"".$file_name_zip."\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($path_file_zip));
        ob_end_flush();
        @readfile($path_file_zip);

        if (file_exists($path_file_zip)) {
            unlink($path_file_zip);
        }
        if (file_exists($path_pdf)) {
            unlink($path_pdf);
        }
        if (file_exists($path_file)) {
            unlink($path_file);
        }
    }

    public function clearCart()
    {
    	$this->cart->clear();
    }

}
