<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShopInFirstEdit extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    public $data;
    public $shop;
    protected $mail;
    /**
     * Create a new message instance.
     * @param array $data
     * @param object $shop
     * @return void
     */

    public function __construct(array $data, $shop)
    {
        $this->data = $data;
        $this->shop = $shop;
        if (env('APP_ENV') == 'production') {
            $this->mail = [
                'akira.komiya@lixil.com',
                'yamagami@akagane.co.jp',
                'trangdm@vnitsolutions.com'
            ];
        } else {
            $this->mail = [
                'minhhq@vnitsolutions.com',
                'hunglm@vnitsolutions.com',
                'thanhtv@vnitsolutions.com'
            ];
        }


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
            ->bcc($this->mail)
            ->subject('【LIXIL簡易見積りシステム】登録完了のご連絡		')
            ->view('mado.mail.shop_info');
    }
}
