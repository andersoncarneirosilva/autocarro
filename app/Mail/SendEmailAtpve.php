<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailAtpve extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $pags;

    public function __construct($pags, $filePath)
    {
        //
        $this->pags = $pags;
        $this->filePath = $filePath;
        //dd($filePath);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitação ATPVe - ' . $this->pags['placa'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.send-email-atpve',
        );
    }

    public function build()
    {
        return $this->from( config('mail.from.address') )
                    ->subject('Contato do site')
                    ->view('emails.send-email-atpve')
                    ->with('data', $this->pags);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $fileName = $this->pags['placa'] . '.pdf'; // Nome do arquivo baseado na placa
        return [
            Attachment::fromPath($this->filePath)
                ->as($fileName) // Nomeia o anexo com a placa
                ->withMime('application/pdf'),
        ];
    }
}
