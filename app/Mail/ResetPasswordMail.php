<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $resetUrl;

    public function __construct($customer)
    {
        $this->customer = $customer;
        // رابط يفتح صفحة الفرونت اند مباشرة، مع الرمز كـ query parameter
        $this->resetUrl = 'http://localhost/Homeline/html/reset-password.html?token=' . $customer->reset_token;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'إعادة تعيين كلمة المرور - Home Line',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reset-password',
        );
    }
}