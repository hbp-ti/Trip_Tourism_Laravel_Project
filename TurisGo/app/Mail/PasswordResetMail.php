<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PasswordResetMail extends Mailable
{
    public $resetLink;

    public function __construct($resetLink)
    {
        $this->resetLink = $resetLink;
    }

    public function build()
    {
        return $this->subject('Password Reset Request')
                    ->view('auth.password_email_reset');
    }
}
