<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    protected $customer;
	protected $shop;

	/**
	 * OrderShipped constructor.
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
     * @return $this
     */
    public function build()
    {
    	if ( \Schema::hasColumn('shops', 'shop_type') === false ){
			return $this
					->from(
							$this->shop[config('const.db.shops.EMAIL')],
							"PATTOリクシル マド本舗 " . $this->shop[config('const.db.shops.NAME')])
					->subject('【マド本舗】お問い合わせがありました（' . $this->shop[config('const.db.shops.NAME')] . '）')
					->view('Estimate.Front.emails.orders')
					->with(['customer' => $this->customer, 'shop' => $this->shop]);
    	}else {
    		return $this
					->from(
							$this->shop[config('const.db.shops.EMAIL')],
							"LIXIL簡易見積りシステム " . $this->shop[config('const.db.shops.NAME')])
					->subject('【LIXIL簡易見積りシステム】お問い合わせがありました（' . $this->shop[config('const.db.shops.NAME')] . '）')
					->view('Estimate.Front.emails.orders')
					->with(['customer' => $this->customer, 'shop' => $this->shop]);
    	}

    }
}
