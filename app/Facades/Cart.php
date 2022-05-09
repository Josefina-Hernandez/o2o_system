<?php
namespace App\Facades;

use App\Http\Controllers\Tostem\Front\CartController;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Barryvdh\Snappy\Facades\SnappyPdf;
use LynX39\LaraPdfMerger\Facades\PdfMerger;

/**
 * Class Cart
 * @package Darryldecode\Cart
 */
class Cart
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
     * our object constructor
     * @param $session
     * @param $session_key
     * @param $key_html_cart
     */
    public function __construct($session, $session_key, $key_html_cart)
    {
        $this->session = $session;
        $this->sessionKey =  $session_key;
        $this->sessionKeyCartItems = $this->sessionKey . '_cart_items';
        $this->key_html_cart = $key_html_cart;
        $this->lang = str_replace('_', '-', app()->getLocale());
        $this->path_pdf = storage_path('tmp/myfile.pdf');
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
            $item[$this->sort_cart] = count($cart) + 1;
            $item['quantity'] = 1;
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
            foreach ($item[$this->lang]['data_options_selected'] as $option) {
                $amount += $option['amount'] * (int)$item['quantity'];
            }
            foreach ($item[$this->lang]['celling_code_option'] as $selling_op) {
                $amount += $selling_op['amount'] * (int)$item['quantity'];
            }

            return round($amount, 2);
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

    public function create_pdf_cart () {
        app('debugbar')->disable();
        $temp_file = storage_path('tmp/tmp.pdf');
        if (file_exists($temp_file)) {
            unlink($temp_file);
        }
        $file_name = Str::random(30);
        $path_pdf = storage_path('tmp/'.$file_name.'.pdf');
        if (file_exists($this->path_pdf)) {
            unlink($this->path_pdf);
        }
        $CartController = new CartController();
        $pdf = SnappyPdf::loadView('tostem.front.cart.index',
            [
                'pdf'=> 1
                , 'html_cart' => $this->session->get($this->key_html_cart)
                , 'input_value' => $CartController->generate_file_name('')
            ])
            ->setOption('viewport-size', '1366x1024')
            ->setOption('enable-javascript', false)
            ->setOption('orientation', 'Landscape')
        ->save($temp_file, true);
        $pdfMerger = PDFMerger::init(); //Initialize the merger
        $pdfMerger->addPDF($temp_file, 'all');
        $pdfMerger->addPDF(public_path('tostem/pdf/Warranty sample.pdf'), 'all');
        $pdfMerger->addPDF(public_path('tostem/pdf/TOSTEM show room introduction(sample).pdf'), 'all');
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
        $this->getContent()->each(function($item) use (&$items)
        {
            if (isset($item[$this->lang])) {
                $item_lang = $item[$this->lang];

                $tmp['id'] = $item['id'];
                // Item
                $tmp['featured_img'] = $item['featured_img'];

                //Series
                if ($item['ctg_id'] == 2) {
                    $tmp['series_display'] = $item_lang['spec1_name'] . " ". $item_lang['model']['model_name_display'] ;
                } else{
                    $tmp['series_display'] = $item_lang['product_name'] . " ". $item_lang['model']['model_name_display'];
                }

                //Size
                $tmp['height_selected'] = $item['height_selected'];
                $tmp['width_selected'] = $item['width_selected'];
                $unit = ' mm';
                $tmp['size'] = [];
                if ($item['width_selected'] != ''){
                    $tmp['size'][] = "Width: ". $item['width_selected'].$unit;
                }
                if ($item['height_selected'] != ''){
                    $tmp['size'][] = "Height: ". $item['height_selected'].$unit;
                }
                //Color
                $tmp['color_name'] = $item_lang['color_name'];

                //Description
                $tmp['description'] = $item_lang['description'];

                //Quantity
                $tmp['quantity'] = $item['quantity'];

                $tmp['options_display'] = [];
                foreach ($item_lang['data_options_selected'] as $option) {

                    $tmp_option = [];
                    //series
                    $tmp_option['series_name'] = $option['series_name'];
                    //Order no
                    $tmp_option['order_no'] = $option['order_no'];
                    //Unit Price
                    $tmp_option['unit_price'] = $option['amount'];

                    $tmp['options_display'][] = $tmp_option;
                }
                foreach ($item_lang['celling_code_option'] as $selling_op) {
                    //dd($item);
                    $tmp_option = [];
                    //series
                    $tmp_option['series_name'] = $selling_op['series_name'];
                    //Order no
                    //dd($selling_op);
                    $tmp_option['order_no'] = $selling_op['order_no'] ;
                    //Unit Price
                    $tmp_option['unit_price'] = $selling_op['amount'];

                    $tmp['options_display'][] = $tmp_option;
                }
                $items[] = $tmp;

            }

        });
        return $items;
    }
}
