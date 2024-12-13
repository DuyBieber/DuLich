<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMailAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $resetLink;

    /**
     * Tạo một phiên bản của thông điệp email.
     *
     * @param string $resetLink
     * @return void
     */
    public function __construct($resetLink)
    {
        $this->resetLink = $resetLink;
    }

    /**
     * Xây dựng nội dung email.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->from('phanduybieber@gmail.com', 'DUYTRAVEL')->subject('Liên kết đặt lại mật khẩu')
        ->view('pages.email.password-reset-admin')
        ->with(['resetLink' => $this->resetLink]);
    }
}
