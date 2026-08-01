<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $verifyUrl;

    public function __construct($customer)
    {
        $this->customer = $customer;
        $this->verifyUrl = url('/api/verify-email/' . $customer->verification_token);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'تفعيل حسابك - Home Line',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify',
        );
    }
}