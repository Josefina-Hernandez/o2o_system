<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 09/05/2019
 * Time: 11:17 AM
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShopContactToCustomerEstimate extends Mailable
{
	use Queueable, SerializesModels;

	protected $customer;
	protected  $shop;
	/**
	 * ShopContactToCustomerEstimate constructor.
	 * @param $customer
	 * @param $shop
	 */
	public function __construct($customer, $shop)
	{
		$this->customer = $customer;
		$this->shop = $shop;
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
							$this->shop[config('const.db.shops.EMAIL')],
							"PATTOリクシル マド本舗 " . $this->shop[config('const.db.shops.NAME')])
					->subject('【マド本舗】お問い合わせありがとうございました。')
					->view('Estimate.Front.emails.customer')
					->with(['customer' => $this->customer, 'shop' => $this->shop]);
		} else {
			return $this
					->from(
							$this->shop[config('const.db.shops.EMAIL')],
							"LIXIL簡易見積りシステム " . $this->shop[config('const.db.shops.NAME')])
					->subject('【LIXIL簡易見積りシステム】お問い合わせありがとうございました。')
					->view('Estimate.Front.emails.customer')
					->with(['customer' => $this->customer, 'shop' => $this->shop]);
		}
	}
}