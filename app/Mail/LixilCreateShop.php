<?php

namespace App\Mail;

use App\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LixilCreateShop extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var $data
     */
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = env('MAIL_FROM_ADDRESS');
        return $this
            ->from(
                $email,
                "LIXIL簡易見積りシステム")
            ->subject('店舗管理画面のご案内')
            ->view('Estimate.manage.mail.lixil_create_shop');
    }
}
