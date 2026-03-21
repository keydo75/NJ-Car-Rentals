<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationUrl;
    public $userName;
    public $appName;
    public $supportEmail;
    public $expiryHours;

    /**
     * Create a new message instance.
     */
    public function __construct($verificationUrl, $userName)
    {
        $this->verificationUrl = $verificationUrl;
        $this->userName = $userName;
        $this->appName = config('app.name', 'NJ Car Rentals');
        $this->supportEmail = config('mail.from.address', 'support@njcarrentals.com');
        $this->expiryHours = 24;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Verify Your Email - ' . config('app.name', 'NJ Car Rentals'))
            ->from(config('mail.from.address', 'noreply@njcarrentals.com'), config('mail.from.name', 'NJ Car Rentals'))
            ->view('emails.verify-email')
            ->text('emails.verify-email-text')
            ->with([
                'appName' => $this->appName,
                'supportEmail' => $this->supportEmail,
                'expiryHours' => $this->expiryHours,
            ]);
    }
}
