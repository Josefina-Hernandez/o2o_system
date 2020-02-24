<?php

namespace App\Http\Controllers\Tostem\Front;

use App\Facades\Cart;
use Illuminate\Http\Request;
use App\Mail\CartPdfToCustomer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;



class CartController extends Controller
{

    protected $request;

    protected $session_key;

    protected $session;

    protected $cart;

    protected $key_html_cart;


    function __construct()
    {
        $this->session = app('session');
        $this->session_key = 'SS_CART';
        $this->key_html_cart = 'SS_HTML';
        $this->cart = new Cart($this->session, $this->session_key, $this->key_html_cart);

    }

    public function index(Request $request)
    {
        $Cart = $this->cart;
        if(request()->ajax())
        {

            $items = [];

            $Cart->getContent()->each(function($item) use (&$items)
            {
                $items[] = $item;
            });

            return response(array(
                'success' => true,
                'data' => $items,
                'message' => 'cart get items success'
            ),200,[]);
        }
        else
        {
            $Cart->clear();
            $items = config('cart.data-tmp');
            foreach ($items as $item) {
                $Cart->add($item);
            }

            return view('tostem.front.cart.index');
        }
    }

    public function add(Request $request)
    {

        $item = [
            'id' => '1',
            'image' => 'https://www.tostemthailand.com/wp-content/uploads/2018/01/9_Window4_Natural_Black.png',
            'series_name' => 'P7 Sliding Window',
            'series_description' => '4 panels on 2 tracks',
            'width' => 'Width 1900  mm',
            'height' => 'Height 1200 mm',
            'color' => 'black',
            'product_description' => 'With Insect Screen',
            'product_description2' => 'Glass Thickness 6mm',
            'price' => '12450',
            'quantity' => '2'
        ];

        $Cart = $this->cart;
        $Cart->add($item);

        return response(array(
            'success' => true,
            'data' => $item,
            'message' => "product added."
        ),201,[]);
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


    public function delete($id)
    {
        $Cart = $this->cart;

        $Cart->remove($id);

        return response(array(
            'success' => true,
            'data' => $id,
            'message' => "cart item {$id} removed."
        ),200,[]);
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
            ),
            'message' => "Get cart details success."
        ),200,[]);
    }

    public function mail (Request $request) {
        $data_req = $request->all();
        try {
            $pdf = $this->cart->create_pdf_cart();
        } catch (\Exception $e) {
            Log::info("CREATE PDF FAIL"."  :".$e->getMessage());
            return response(array(
                'status' => false,
                'message' => $e->getMessage()
            ),200,[]);
        }
        try {
            Mail::to($data_req['email'])->queue(new CartPdfToCustomer($pdf));
        } catch (\Exception $e) {
            Log::info("SEND MAIL FAIL to ".$data_req['email']." Error  :".$e->getMessage());
            return response(array(
                'status' => false,
                'message' => $e->getMessage()
            ),200,[]);
        }
        return response(array(
            'status' => 'OK',
            'message' => "success."
        ),200,[]);
    }

    public function downloadpdf (Request $request) {
        $ss_html = $this->key_html_cart;
        if(request()->ajax())
        {
            $data = $request->all();
            $request->session()->put($ss_html, $data['html']);
            return response(array(
                'success' => true,
                'message' => "Save Dom html success."
            ),200,[]);
        }
        $pdf = $this->cart->create_pdf_cart();
        return $pdf->download('invoice.pdf');
    }

    public function downloadcsv(Request $request)
    {
        $Cart = $this->cart;
        $items = [];
        $products = $Cart->getContent()->toArray();
        foreach ($products as $item) {
            unset($item[$Cart->sort_cart]);
            $items[] = $item;
        }

        //dd($items);
        $columns_head = [];
        $headers = array(
            'Content-Encoding: UTF-8',
            'Content-Type: application/csv; charset=UTF-8',
            "Content-Disposition" => "attachment; filename=product.csv",
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
    }
}
