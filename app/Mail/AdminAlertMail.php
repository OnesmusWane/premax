<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param string               $alertSubject  Email subject line
     * @param string               $type          Badge label, e.g. "Contact Form"
     * @param array<array{label:string,value:string}> $rows  Detail rows rendered in the email body
     * @param string|null          $note          Optional longer text block (contact message body, order notes, etc.)
     */
    public function __construct(
        public readonly string  $alertSubject,
        public readonly string  $type,
        public readonly array   $rows,
        public readonly ?string $note = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->alertSubject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.admin.alert',
            text: 'mail.admin.alert-text',
        );
    }
}
