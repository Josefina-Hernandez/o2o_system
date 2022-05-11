<?php
namespace App\Services;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Tostem\Mquotation;
use App\Models\Tostem\Tquotation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Barryvdh\Snappy\Facades\SnappyPdf;
use LynX39\LaraPdfMerger\Facades\PdfMerger;


/**
 * Class CartService
 */
class CartService
{

    /**
     * the item storage
     *
     * @var
     */
    public $session;

    /**
     * the session key use for the cart
     *
     * @var
     */
    protected $sessionKey;

    /**
     * the session key use to persist cart items
     *
     * @var
     */
    protected $sessionKeyCartItems;

    /**
     * the sort cart
     * sort item in cart
     * @var
     */
    public $sort_cart = 'sort_cart';

    /**
     * language of user uses
     * @var
     */
    protected $lang;

    /**
     * key get html cart to create pdf
     * @var
     */
    protected $key_html_cart;

    /**
     * path file pdf generate
     * @var
     */
    public $path_pdf;

    /**
     * key name gets file name session
     * @var
     */
    public $key_file_name;

    /**
     * our object constructor
     * @param $session
     * @param $session_key
     * @param $key_html_cart
     */


    public $button_click;

    public $ss_new_or_reform; //Add add popup status New/Reform hainp 20200922

    private $button_mail = null;

    private $button_pdf = null;

    public function __construct($session, $session_key, $key_html_cart)
    {
        $this->session = $session;
        $this->sessionKey =  $session_key;
        $this->sessionKeyCartItems = $this->sessionKey . '_cart_items';
        $this->key_html_cart = $key_html_cart;
        $this->lang = str_replace('_', '-', app()->getLocale());
        $this->path_pdf = storage_path('tmp/');
        $this->key_file_name = 'file_name_cart';
        $this->ss_new_or_reform = app('App\Http\Middleware\Tostem\Front\CheckSessionNewOrReform')::SS_NEW_OR_REFORM; //Add add popup status New/Reform hainp 20200922
    }

    /**
     * sets the session key
     *
     * @param string $sessionKey the session key or identifier
     * @return $this|bool
     * @throws \Exception
     */
    public function session($sessionKey)
    {
        if(!$sessionKey) throw new \Exception("Session key is required.");

        $this->sessionKey = $sessionKey;
        $this->sessionKeyCartItems = $this->sessionKey . '_cart_items';

        return $this;
    }

    /**
     * get an item on a cart by item ID
     *
     * @param $itemId
     * @return mixed
     */
    public function get_item($itemId)
    {
        return $this->getContent()->get($itemId);
    }

    /**
     * check if an item exists by item ID
     *
     * @param $itemId
     * @return bool
     */
    public function has($itemId)
    {
        return $this->getContent()->has($itemId);
    }

    /**
     * add item to the cart, it can be an array or multi dimensional array
     *
     * @param array $item
     * @return $this
     * @throws Exception
     */
    public function add($item)
    {

        // validate data
        $item = $this->validate($item);
        $id = Str::random(16);
        $item['id'] = $id;
        // get the cart
        $cart = $this->getContent();

        // if the item is already in the cart we will just update it
        if ($cart->has($id)) {
            $this->update($id, $item);
        } else {
            $item[$this->sort_cart] = $cart->max('sort_cart') + 1;
            $item['quantity'] = 1;
            $item['reference_no'] = ''; //Add BP_O2OQ-25 hainp 20210712
            $this->addRow($id, $item);
        }

        return $this;
    }

    /**
     * update a cart
     *
     * @param $id
     * @param $data
     *
     * the $data will be an associative array, you don't need to pass all the data, only the key value
     * of the item you want to update on it
     * @return bool
     */
    public function update($id, $data)
    {

        $cart = $this->getContent();

        $item = $cart->pull($id);

        foreach ($data as $key => $value) {
            if ($key == 'quantity') {
                $item['quantity'] = (int)$value;
            } else if ($key == 'reference_no') { //Add BP_O2OQ-7 hainp 20200701
                $item['reference_no'] = $value; //Add BP_O2OQ-7 hainp 20200701 //edit BP_O2OQ-25 antran 20210623
            } else {
                $item[$key] = $value;
            }
        }

        $cart->put($id, $item);

        $this->save($cart);

        return true;
    }

    /**
     * removes an item on cart by item ID
     *
     * @param $id
     * @return bool
     */
    public function remove($id)
    {
        $cart = $this->getContent();

        $cart->forget($id);

        $this->save($cart);

        return true;
    }

    /**
     * clear cart
     * @return bool
     */
    public function clear()
    {

        $this->session->put(
            $this->sessionKeyCartItems,
            array()
        );

        return true;
    }


    /**
     * get cart sub total
     * @return float
     */
    public function getSubTotal()
    {
        $cart = $this->getContent();
        $sum = $cart->sum(function ($item) {
            $amount = 0;
            if(isset($item[$this->lang])){
                    foreach ($item[$this->lang]['data_options_selected'] as $option) {
                        $amount += $option['amount'] * (int)$item['quantity'];
                    }
            }
            if(isset($item[$this->lang])){
                    foreach ($item[$this->lang]['celling_code_option'] as $selling_op) {
                        $amount += $selling_op['amount'] * (int)$item['quantity'];
                    }
            }
            // add new total priece option hidden on screen giesta
           if(isset($item[$this->lang])){
               if(isset($item[$this->lang]['hidden_option'])){
                    foreach ($item[$this->lang]['hidden_option'] as $option_hide_giestas) {
                         foreach ($option_hide_giestas as $option_hide_giesta){
                              $amount += $option_hide_giesta['amount'] * (int)$item['quantity'];
                         }
                   }
               }
           }
           //end  add new total priece option hidden on screen giesta


            // return round($amount, 2); //Remove BP_O2OQ-7 hainp 20200710
            return $amount; //Add BP_O2OQ-7 hainp 20200710
        });
        return $sum;

    }

    /**
     * the new total in which conditions are already applied
     *
     * @return float
     */
    public function getTotal()
    {
        $subTotal = $this->getSubTotal();

    }

    /**
     * get the cart
     *
     * @return Collection
     */
    public function getContent()
    {
        $cart = new Collection($this->session->get($this->sessionKeyCartItems));


        return $cart->sortBy($this->sort_cart);
    }

    /**
     * check if cart is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        $cart = new Collection($this->session->get($this->sessionKeyCartItems));

        return $cart->isEmpty();
    }

    /**
     * validate Item data
     *
     * @param $item
     * @return array $item;
     * @throws Exception
     */
    protected function validate($item)
    {
        $rules = array(
            'id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
            'reference_no' => 'required|numeric|min:1', //Add BP_O2OQ-7 hainp 20200701
            'name' => 'required',
        );

       /* $validator = CartItemValidator::make($item, $rules);

        if ($validator->fails()) {
            throw new Exception($validator->messages()->first());
        }*/

        return $item;
    }




    /**
     * add row to cart collection
     *
     * @param $id
     * @param $item
     * @return bool
     */
    protected function addRow($id, $item)
    {

        $cart = $this->getContent();

        $cart->put($id, new Collection($item));

        $this->save($cart);

        return true;
    }

    /**
     * save the cart
     *
     * @param $cart Collection
     */
    protected function save($cart)
    {
        $this->session->put($this->sessionKeyCartItems, $cart);
    }

    public function create_pdf_cart ($name_pdf) {
        app('debugbar')->disable();
        $temp_file = storage_path('tmp/'.Str::random(30).'.pdf');
        $path_pdf = storage_path('tmp/'.Str::random(30).'.pdf');

        $pdf = SnappyPdf::loadView('tostem.front.cart.index',
            [
                'html_cart' => $this->session->get($this->key_html_cart)
                , 'input_value' => $name_pdf
                , 'value_user_name' => $this->getUserName() //Add BP_O2OQ-4 hainp 20200605
            ])
            ->setOption('viewport-size', '1366x1024')
            ->setOption('enable-javascript', true)
            ->setOption('javascript-delay', 200)
            ->setOption('orientation', 'Landscape')
        ->save($temp_file, true);
        $pdfMerger = PDFMerger::init(); //Initialize the merger
        $pdfMerger->addPDF($temp_file, 'all');
        $pdfMerger->addPDF(public_path('tostem/pdf/Quotation remark_' . app()->getLocale() . '.pdf'), 'all');
        $pdfMerger->merge();
        $pdfMerger->save($path_pdf);
        chmod($path_pdf, 0755);
        chmod($temp_file, 0755);

        // Delete file generate
        if (file_exists($temp_file)) {
            unlink($temp_file);
        }

        return $path_pdf;
    }

    /**
     * get amount item the cart
     *
     */
    public function get_quantity_cart () {
        return count($this->get_cart_lang());
    }

    public function get_cart_lang () {
        $items = [];
        //Add Start BP_O2OQ-4 hainp 20200609
        $arr_def_value = [];
        $data_hardcode = DB::Select(config('sql_building.select.GET_CONFIG_DO_NOT_DISPLAY_DETAIL_CART'));
        if(count($data_hardcode) > 0) {
            foreach ($data_hardcode as $value) {
                $arr_def_value[] = $value->def_value;
            }
        }
        //Add End BP_O2OQ-4 hainp 20200609

        $this->getContent()->each(function($item) use (&$items, $arr_def_value) //Edit BP_O2OQ-4 hainp 20200609
        {
            if (isset($item[$this->lang])) {
                $item_lang = $item[$this->lang];

                $tmp['id'] = $item['id'];
                $tmp['ctg_id'] = $item['ctg_id'];
                $tmp['model_id'] = $item['model_id'];
                // Item
                $tmp['featured_img'] = $item['featured_img'];
                //display pitch list
                $tmp['display_pitch_list'] = $item['display_pitch_list'];
                //Series
                if ($item['ctg_id'] == 2) {
                    $tmp['series_display'] = $item_lang['spec1_name'] . " ". $item_lang['model']['model_name_display'] ;
                } else{
                    $tmp['series_display'] = $item_lang['product_name'] . " ". $item_lang['model']['model_name_display'];
                }
                //Size
                $unit = __('screen-cart.mm'); //Edit BP_O2OQ-7 hainp 20200727
                $tmp['size'] = [];
                if(isset($item_lang['is_fence']) && $item_lang['is_fence'] == true) {
                	$tmp['size'][] = $item_lang['fence']['f0'].$unit;
                } else {
                	if ($item['width_selected'] != ''){
	                    $tmp['size'][] = $item['width_selected'].$unit;
	                }
                }

                if ($item['height_selected'] != ''){
                    $tmp['size'][] = $item['height_selected'].$unit;
                }
                //Color
                $tmp['color_name'] = $item_lang['color_name'];

                //Description
                $tmp['description'] = $item_lang['description'];

                $tmp['louver_description_extra'] = '';
                if(count($item_lang['data_options_selected'])>0) {
                	if(isset($item_lang['data_options_selected'][0]['louver_description_extra'])) {
                		$tmp['louver_description_extra'] = $item_lang['data_options_selected'][0]['louver_description_extra'];
                	}
                }

                //Quantity
                $tmp['quantity'] = $item['quantity'];

                //Reference no
                $tmp['reference_no'] = $item['reference_no']; //Add BP_O2OQ-7 hainp 20200701

                $tmp['options_display'] = [];

                //exterior :fence type
                if(isset($item_lang['is_fence']) && $item_lang['is_fence'] == true && count($item_lang['data_options_selected']) > 0) {
                	$copy_data_option_selected = $item_lang['data_options_selected'];
                	foreach($item_lang['data_options_selected'] as $_key => $_value) {
                		if($_value['fence_type'] == 'PANEL') {
                			$w = sprintf('%04d', $_value['width']);
                			$h = sprintf('%04d', $_value['height']);
                			$w_replace = sprintf('%04d', $item_lang['fence']['f2']);
                			$copy_data_option_selected[$_key]['order_no'] = str_replace($w.$h, $w_replace.$h, $_value['order_no']);
                		}
                	}
                	$item_lang['data_options_selected'] = $copy_data_option_selected;
                }

                if($item['ctg_id'] == 3) {
                	//NOTE: sắp xếp lại thứ tự hiển thị nếu là ctg giesta
                	$results = array_merge($item_lang['data_options_selected'], $item_lang['celling_code_option']);
                	$results = array_merge($results, $item_lang['hidden_option']['frame']);
                	$results = array_merge($results, $item_lang['hidden_option']['side_panel']);
                	$results = array_merge($results, $item_lang['hidden_option']['sub_panel']);
                	$results = array_merge($results, $item_lang['hidden_option']['option_handle']);
                	$results = array_merge($results, $item_lang['hidden_option']['option_cylinder']);
                	$results = array_merge($results, $item_lang['hidden_option']['option_door_guard']);
                	$results = array_merge($results, $item_lang['hidden_option']['option_closer']);

                } else {
                	$results = array_merge($item_lang['data_options_selected'], $item_lang['celling_code_option']);
	                if (isset($item_lang['hidden_option']) &&  is_array($item_lang['hidden_option'])) {
	                    foreach ($item_lang['hidden_option'] as $_option) {
	                        if (count($_option) > 0) {
	                            $results = array_merge($results, $_option);
	                        }
	                    }
	                }
                }

                $subtotal = 0;
                foreach ($results as $option) {
                    //subtotal
                    $subtotal += $option['amount'];

                    $tmp_option = [];
                    //series
                    $tmp_option['series_name'] = $option['series_name'];
                    //Order no
                    $tmp_option['order_no'] = $option['order_no'];
                    //Unit Price
                    $tmp_option['unit_price'] = $option['amount'];



                    $tmp['options_display'][] = $tmp_option;

                }
                $tmp['subtotal'] = (float)(string)$subtotal;//Edit BP_O2OQ-7 hainp 202000710

                //Add Start BP_O2OQ-4 hainp 20200608
                if(in_array($item['product_id'], $arr_def_value)) {
                    $tmp['display_detail_cart'] = false;
                } else {
                    $tmp['display_detail_cart'] = true;
                }
                //Add End BP_O2OQ-4 hainp 20200608

                $tmp['product_id'] = $item['product_id']; //Add BP_O2OQ-7 hainp 20200701
                $tmp['size'] = implode('<br>x<br>', $tmp['size']); //Add BP_O2OQ-7 hainp 20200701

                $items[] = $tmp;

            }

        });
        return $items;
    }


    public function saveDbCart()
    {
        $this->Set_Value_ButtonClick();

        $data[config('const_db_tostem.db.m_quotation.column.QUOTATION_SESSION')] = session()->getId();
        $data[config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE')] = Carbon::now()->format('Ymd');
        $data[config('const_db_tostem.db.m_quotation.column.HTML_CART')] = $this->session->get($this->key_html_cart);
        $data[config('const_db_tostem.db.m_quotation.column.DATA_CART')] = $this->getContent();
        $data[config('const_db_tostem.db.m_quotation.column.NEW_OR_REFORM')] = (int) $this->session->get($this->ss_new_or_reform); //Add add popup status New/Reform hainp 20200922

        if($this->button_pdf   != null){
               $data[config('const_db_tostem.db.m_quotation.column.BUTTON_PDF')] = $this->button_pdf;
        }

        if($this->button_mail  != null){
               $data[config('const_db_tostem.db.m_quotation.column.BUTTON_MAIL')] = $this->button_mail;
        }

        if ($data[config('const_db_tostem.db.m_quotation.column.HTML_CART')] == null) {
            return '';
        }

        if (\Auth::check() && \Auth::user()->isEmployee()) {
            $data[config('const_db_tostem.db.m_quotation.column.QUOTATION_DEPARMENT')] = auth()->user()->m_mailaddress_id;
            $data[config('const_db_tostem.db.common_columns.column.ADD_USER_ID')] =  auth()->user()->id;
        } else {
            $data[config('const_db_tostem.db.m_quotation.column.QUOTATION_DEPARMENT')] = config('cart.m_mailAddress_default');
        }
        DB::unprepared('LOCK TABLES m_quotation READ');
        DB::beginTransaction();
        try {
            $dbQuotation = $this->DataMquotation ($data);
            $dbQuotation->fill($data);
            if ($dbQuotation->save()){
                $data['m_quotation_id'] = $dbQuotation->m_quotation_id;
                $this->InsertTquotation($data);
            };
            DB::commit();
        } catch (\Exception $e) {
            Log::info('saveDBCart Error: '.$e->getMessage());
            DB::rollBack();
            DB::unprepared('UNLOCK TABLES');
            return $this->generate_file_name('');
        }
        DB::unprepared('UNLOCK TABLES');

        $file_name = $this->getDepartmentCode('_');
        return $file_name.$dbQuotation->quotation_date.'_'.$dbQuotation->quotation_no;

    }

    public function getQuotationNo () {
        $quotation = $this->get_m_quotation ();
        if ($quotation != null) {
            $file_name = $this->getDepartmentCode('_');
            return $file_name.$quotation->quotation_date.'_'.$quotation->quotation_no;
        } else {
            return '';
        }
    }

    public function generate_file_name ($file_type) {
        $file_name = $this->getDepartmentCode('_');
        $file_name .= Carbon::now()->format('Ymd').$file_type;
        return $file_name;
    }

    public function getDepartmentCode ($prefix = '') {
        if(\Auth::check() && \Auth::user()->isEmployee()){
            $mail_address_id = auth()->user()->m_mailaddress_id;

        } else {
            $mail_address_id = config('cart.m_mailAddress_default');
        }
        $department_code = collect(\DB::select("
                -- Get department_code
                SELECT department_code
                FROM m_mailaddress
                WHERE id = $mail_address_id
            "))->first();
        $file_name = $department_code->department_code .$prefix;
        return $file_name;
    }

    /**
     * @param $data
     * @return Mquotation
     */
    public function DataMquotation (&$data) {
        $date =  $data[config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE')];
        $department = $data[config('const_db_tostem.db.m_quotation.column.QUOTATION_DEPARMENT')];
        $quotation = $this->get_m_quotation ();
        if ($quotation != null) {
            $dbQuotation = Mquotation::find($quotation->m_quotation_id);
        } else {
            $sql_check2 = "
                 -- select data
                SELECT *
                FROM m_quotation
                WHERE quotation_date = '$date'
                AND quotation_deparment = $department
            ";
            $quotation_2 = collect(\DB::select($sql_check2));
            if (count($quotation_2) > 0) {
                $quotation_2 = (int)$quotation_2->max('quotation_no');
                $data[config('const_db_tostem.db.m_quotation.column.QUOTATION_NO')] = sprintf('%04d',$quotation_2 + 1);
            } else {
                $data[config('const_db_tostem.db.m_quotation.column.QUOTATION_NO')] = sprintf('%04d', 1);
            }
            $dbQuotation = new Mquotation();
        }

        return $dbQuotation;
    }


    public function get_m_quotation () {
        if (\Auth::check() && \Auth::user()->isEmployee()) {
            $department = auth()->user()->m_mailaddress_id;
        } else {
            $department = config('cart.m_mailAddress_default');
        }
        $session_id =  session()->getId();
        $date =  Carbon::now()->format('Ymd');
        $sql = "
            -- select data
            SELECT *
            FROM m_quotation
            WHERE quotation_session = '$session_id'
            AND quotation_date = '$date'
            AND quotation_deparment = $department
        ";
        $quotation = collect(\DB::select($sql))->first();
        return $quotation;
    }


    public function InsertTquotation ($data) {

        //  dd($this->getContent());
        $this->beforeInsert($data);
        $items = $this->getContent();
        $data_insert = [];
        // $index = 1; //Remove BP_O2OQ-7 hainp 20200701
        $row_no = 1;
        foreach($items as $item)
        {
        	if(isset($item[$this->lang])) {
        		$item_lang = $item[$this->lang];
	            //$tmp['item'] = $item['featured_img'];
	            $items_insert = [];
	            $tmp = [];
	            $tmp['ref'] = $item['reference_no']; //Edit BP_O2OQ-7 hainp 20200701
	            $tmp['qty'] = $item['quantity'];
	            $tmp['color'] = $item_lang['color_name'];
	            $tmp['color_code'] = $item_lang['color_code'];
	            $tmp['m_quotation_id'] = $data['m_quotation_id'];
                $tmp['del_flg'] = 0;

	            if (\Auth::check() && \Auth::user()->isEmployee()) {
	                $tmp['quotation_user'] =  auth()->user()->id;
	            }

	            if($item['ctg_id'] == 3) {
	            	//NOTE: sắp xếp lại thứ tự hiển thị nếu là ctg giesta
	            	$results = $item_lang['celling_code_option'];
	            	$results = array_merge($results, $item_lang['hidden_option']['frame']);
	            	$results = array_merge($results, $item_lang['hidden_option']['side_panel']);
	            	$results = array_merge($results, $item_lang['hidden_option']['sub_panel']);
	            	$results = array_merge($results, $item_lang['hidden_option']['option_handle']);
	            	$results = array_merge($results, $item_lang['hidden_option']['option_cylinder']);
	            	$results = array_merge($results, $item_lang['hidden_option']['option_door_guard']);
	            	$results = array_merge($results, $item_lang['hidden_option']['option_closer']);

	            } else {
	            	$results = $item_lang['celling_code_option'];
	            }

	            //Nhóm main
	            foreach ($item_lang['data_options_selected'] as $key => $value) {
	                $tmp['design'] = $value['selling_code'];
	                $tmp['item']   = $row_no * 100;
	                $tmp['w']      = $value['width'];
	                $tmp['h']      = $value['height'];
                    $tmp['amount'] = $value['amount']; //Add BP_O2OQ-28 hoand 20210920

	                $items_insert[] = $tmp;
	                $row_no++;
	            }

	            //Nhóm option
	            if(count($results) > 0) {
	            	foreach ($results as $key => $option) {
		                $tmp['design'] = $option['selling_code'];
		                $tmp['item']   = $row_no * 100;
		                $tmp['w']      = intval(str_replace(',', '', $item['width_selected']));
		                $tmp['h']      = intval(str_replace(',', '', $item['height_selected']));
                        $tmp['amount'] = $option['amount']; //Add BP_O2OQ-28 hoand 20210920

		                $items_insert[] = $tmp;
		                $row_no++;
		            }
	            }


	            $data_insert = array_merge($data_insert, $items_insert);
	            // $index++; //Remove BP_O2OQ-7 hainp 20200701
        	}
        };

        Tquotation::insert($data_insert);
    }

    public function beforeInsert($data) {

        $m_quotation_id = $data['m_quotation_id'];
        //dd($m_quotation_id);
        $sql = "
            -- sql delete t_quotation
            DELETE FROM t_quotation
            WHERE m_quotation_id = $m_quotation_id
        ";

        \DB::delete($sql);
    }

    private function Set_Value_ButtonClick(){

         switch ($this->button_click){
           case 0:
               $this->button_mail = 'Send PDF mail';
               break;
           case 1:
                $this->button_pdf = 'PDF Download';
               break;

         }

    }

    //Add Start BP_O2OQ-4 hainp 20200605
    public function getUserName() {
        $name = $this->getUserNameByMailId();
        $quotation = $this->get_m_quotation();
        if ($name != null && $quotation != null) {
            return $name;
        } else {
            if(\Auth::check() && \Auth::user()->isEmployee()) {
                return '';
            }
            return null;
        }
    }

    public function getUserNameByMailId() {
        if(\Auth::check() && \Auth::user()->isEmployee()){
            $name = auth()->user()->name;
        } else {
            $mail_address_id = config('cart.m_mailAddress_default');
            try {
                $name = collect(\DB::select("
                    -- Get name
                    SELECT name
                    FROM users
                    WHERE m_mailaddress_id = $mail_address_id
                    AND del_flg = 0
                "))->first()->name;
            } catch (\Exception $e) {
                return null;
            }
        }
        return $name;
    }
    //Add End BP_O2OQ-4 hainp 20200605
    //Add Start BP_O2OQ-7 hainp 20200710
    public function getMaxDecimal() {
        $max_amount_decimal = 0;
        $data_hardcode = DB::Select(config('sql_building.select.MAX_DECIMAL_AMOUNT_SELLING_CODE_PRICE'));
        if(count($data_hardcode) > 0) {
            $max_amount_decimal = (int)$data_hardcode[0]->max_amount_decimal;
        }
        return $max_amount_decimal;
    }
    //Add End BP_O2OQ-7 hainp 20200710
}
