<?php

namespace App\Mail;

use App\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShopContactToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Shop
     */
    public $shop;

    /**
     * @var array
     */
    public $data;

    /**
     * Create a new message instance.
     *
     * @param Shop $shop ショップモデル
     * @param array $data 入力データを $request->all() で受け取ったもの
     * @return void
     */
    public function __construct(Shop $shop, array $data)
    {
        $this->shop = $shop;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	if ( \Schema::hasColumn('shops', 'shop_type') === false ){
	        return $this
	        ->from(
	            $this->shop->{config('const.db.shops.EMAIL')},
	            "PATTOリクシル マド本舗 " . $this->shop->{config('const.db.shops.NAME')})
	            ->subject('【マド本舗】お問い合わせありがとうございました。')
	            ->view('mado.mail.shop_contact_to_customer');
	    } else {
	        return $this
	        ->from(
	            $this->shop->{config('const.db.shops.EMAIL')},
	            "LIXIL簡易見積りシステム " . $this->shop->{config('const.db.shops.NAME')})
	            ->subject('【LIXIL簡易見積りシステム】お問い合わせありがとうございました。')
	            ->view('mado.mail.shop_contact_to_customer');
        }
    }
}
