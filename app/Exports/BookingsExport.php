<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingsExport implements FromCollection, WithHeadings
{
    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function collection()
    {
        return Booking::with(['customer', 'tour'])
            ->whereDate('created_at', $this->date)
            ->get()
            ->map(function ($booking) {
                // Tính tổng tiền thanh toán từ tất cả các khoản payments
                

                return [
                    'ID' => $booking->id,
                    'Khách Hàng' => $booking->customer->customer_name,
                    'Số điện thoại'=> $booking->customer->customer_phone,
                    'Email'=>$booking->customer->customer_email,
                    'Tour' => $booking->tour->title_tours,
                    'Ngày Đặt' => $booking->created_at->format('d/m/Y H:i'),
                    'Tổng Giá' => number_format($booking->total_price, 0, ',', '.') . ' vnd',
                    'Số chỗ' => $booking->adults + $booking->children + $booking->babies + $booking->infants,
                    'Phòng đơn' => $booking->single_room_quantity,
                    'Tổng tiền thanh toán' => number_format($booking->total_price, 0, ',', '.') . ' vnd',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Khách Hàng',
            'Số điện thoại',
            'Email',
            'Tour',
            'Ngày Đặt',
            'Tổng Giá',
            'Số chỗ',
            'Phòng đơn',
            'Tổng tiền thanh toán',
        ];
    }
}
