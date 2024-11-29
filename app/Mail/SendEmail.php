<?php

namespace App\Mail;

use App\Models\Adiantamento;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $pags;

    public function __construct($pags)
    {
        //
        $this->pags = $pags;

        //dd($pags);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Mails.send-email',
        );
    }

    public function build()
    {
        return $this->from( config('mail.from.address') )
                    ->subject('Contato do site')
                    ->view('Mails.send-email')
                    ->with('data', $this->pags);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            //Attachment::fromPath('public/storage/contracheques/contracheque-Anderson.pdf'),
        ];
    }
}
