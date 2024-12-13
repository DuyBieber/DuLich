<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function build()
    {
        return $this->from('phanduybieber@gmail.com', 'DUYTRAVEL')
            ->subject('Chúc mừng bạn đã đăng ký thành công!')
            ->view('pages.email.registration_success'); // Tạo view này
    }
}
