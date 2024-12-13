<?php

namespace App\Mail;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking; // Biến để chứa thông tin booking

    /**
     * Tạo một thể hiện mới của lớp BookingConfirmationMail.
     *
     * @param  Booking  $booking
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking; // Gán thông tin booking vào biến
    }

    /**
     * Thiết lập nội dung email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('phanduybieber@gmail.com', 'DUYTRAVEL') // Đổi tên người gửi
        ->subject('Xác nhận đặt tour')
                    ->view('pages.email.send_mail_booking'); // Tên view để hiển thị email
    }
}
