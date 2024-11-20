<?php
// app/Mail/PasswordResetMail.php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PasswordResetMail extends Mailable
{
    public $resetLink;

    // O construtor recebe o link de redefinição de senha
    public function __construct($resetLink)
    {
        $this->resetLink = $resetLink;
    }

    // Configura o e-mail
    public function build()
    {
        return $this->subject('Password Reset Link')  // Define o assunto do e-mail
                    ->view('auth.reset')
                    ->with(['resetLink' => $this->resetLink]);  // Passa o link para a view
    }
}
