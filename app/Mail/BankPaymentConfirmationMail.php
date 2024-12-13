<?php

namespace App\Mail;

use App\Models\Payments;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BankPaymentConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $booking;

    public function __construct(Payments $payment, Booking $booking)
    {
        $this->payment = $payment;
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->from('phanduybieber@gmail.com', 'DUYTRAVEL')
        ->subject('Xác nhận thanh toán qua ngân hàng')
                    ->view('pages.email.bank_payment_confirmation')
                    ->with([
                        'payment' => $this->payment,
                        'booking' => $this->booking,
                    ]);
    }
}
