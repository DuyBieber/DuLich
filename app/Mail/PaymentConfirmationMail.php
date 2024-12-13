<?php

namespace App\Mail;

use App\Models\Payments;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $booking; // Thêm biến booking

    public function __construct(Payments $payment, Booking $booking)
    {
        $this->payment = $payment;
        $this->booking = $booking; // Gán booking vào biến
    }


    public function build()
    {
        return $this->from('phanduybieber@gmail.com', 'DUYTRAVEL')
        ->subject('Xác nhận thanh toán thành công')
                    ->view('pages.email.send_mail_payments') 
                    ->with([
                        'payment' => $this->payment,
                        'booking' => $this->booking,
                    ]);
    }
}
