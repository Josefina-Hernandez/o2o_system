<?php
namespace App\Facades;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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


    protected $key_html_cart;

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
        $id = $item['id'];
        // get the cart
        $cart = $this->getContent();

        // if the item is already in the cart we will just update it
        if ($cart->has($id)) {
            $this->update($id, $item);
        } else {
            $item[$this->sort_cart] = count($cart) + 1;
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
            return (int)$item['price'] * (int)$item['quantity'];
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
        $pdf = \PDF::loadView('tostem.front.cart.index', ['pdf'=> 1, 'html_cart' => $this->session->get($this->key_html_cart)])
            ->setOption('viewport-size', '1366x1024')
            ->setOption('enable-javascript', false)
            ->setOption('orientation', 'Landscape');
        return $pdf;
    }

}
