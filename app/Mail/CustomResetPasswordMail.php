<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function build()
{
    return $this->from('suporte@alcecar.com.br', 'Alcecar') // Força o remetente do Zoho
                ->view('emails.custom-reset-password')
                ->subject('Redefina sua senha - Alcecar')
                ->with([
                    'url' => $this->url,
                ]);
}
}