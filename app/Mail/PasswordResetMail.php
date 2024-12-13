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
        return $this->from('phanduybieber@gmail.com', 'DUYTRAVEL')->subject('Liên kết đặt lại mật khẩu')
            ->view('pages.email.password-reset')
            ->with(['resetLink' => $this->resetLink]);
    }
}
