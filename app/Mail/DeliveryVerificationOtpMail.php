<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeliveryVerificationOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $OTP;

    public function __construct($OTP)
    {
        $this->OTP = $OTP;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Delivery verification Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.DeliveryVerificationOtpMail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

