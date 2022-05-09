<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\Tostem\Front\CartController;

class CartPdfToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $path_pdf;

    public $name_pdf;
    /**
     * Create a new message instance.
     * @param $path_pdf string path_url file pdf;
     * @param $name_pdf String
     * @return void
     */
    public function __construct($path_pdf, $name_pdf)
    {
        $this->path_pdf = $path_pdf;
        $this->name_pdf = $name_pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = env('MAIL_FROM_ADDRESS');
        $sender = __('mail.sender');
        $subject = __('mail.subjec_mail');
        return $this
            ->from(
                $email,
                $sender)
            ->subject($subject)
            ->view('tostem.front.mails.content-mail-pdf')
            ->attach($this->path_pdf, [
                'as' => $this->name_pdf.'.pdf',
                'mime' => 'application/pdf',
            ])
            ;

    }
}
