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
        // Forçamos o remetente exatamente como configurado no SMTP do Zoho
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.custom-reset-password')
            ->subject('Redefina sua senha - Alcecar')
            ->with([
                'url' => $this->url,
            ]);
    }
}