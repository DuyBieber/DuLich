<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking; // Biến để chứa thông tin booking

    /**
     * Tạo một thể hiện mới của lớp BookingUpdateMail.
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
        ->subject('Cập nhật thông tin đặt tour') // Tiêu đề email
                    ->view('pages.email.send_mail_booking_update'); // Tên view để hiển thị email
    }
}
