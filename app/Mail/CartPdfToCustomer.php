<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use phpDocumentor\Reflection\Project;

class CartPdfToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdf;
    protected $shop;

    /**
     * Create a new message instance.
     * @param $pdf
     * @param $shop Project
     * @return void
     */
    public function __construct($pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = env('MAIL_FROM_ADDRESS');
       /* if($this->shop->email != "" && filter_var($this->shop->email, FILTER_VALIDATE_EMAIL)) {
            $email = $this->shop->{config('const.db.shops.EMAIL')};
        }*/
        return $this
            ->from(
                $email,
                'TOSTEM')
            ->subject('subject mail tostem')
            ->view('tostem.front.mails.content-mail-pdf')
            ->attachData($this->pdf->output(), 'filename.pdf')
            ;
    }
}
