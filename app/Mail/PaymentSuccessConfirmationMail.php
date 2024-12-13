<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct($booking_id)
    {
        // Tìm booking theo ID
        $this->booking = Booking::findOrFail($booking_id);
    }

    public function build()
    {
        return $this->from('phanduybieber@gmail.com', 'DUYTRAVEL')
                    ->subject('Xác nhận thanh toán')
                    ->view('pages.email.send_mail_payment')
                    ->with(['booking' => $this->booking]);
    }
}