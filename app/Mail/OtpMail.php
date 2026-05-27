<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $code,
        public readonly string $name = 'there',
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Premax sign-in code: ' . $this->code,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.otp.html',
            text: 'mail.otp.text',
        );
    }
}
