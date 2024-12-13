<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelBookingConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->from('phanduybieber@gmail.com', 'DUYTRAVEL') // Đổi tên người gửi
        ->subject('Xác nhận hủy booking')
                    ->view('pages.email.cancel_tour_mail_booking'); // Tên view để hiển thị email
    }
}
