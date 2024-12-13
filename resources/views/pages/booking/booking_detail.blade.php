@extends('layout')
@section('content')
<div class="container booking-details" style="width: 80%; max-width: 1200px; height: auto;">
    <h2 class="booking-details-title" style="padding: 15px;">Chi tiết đặt tour</h2>
    <table class="table table-striped booking-details-table" style="width: 100%; height: auto;">
        <tbody>
            <tr class="booking-details-row">
                <th class="booking-details-header" style="width: 20%;">Mã đặt chỗ:</th>
                <td class="booking-details-data" style="width: 80%;">{{ $booking->booking_code }}</td>
            </tr>
            <tr class="booking-details-row">
                <th class="booking-details-header" style="width: 20%;">Tên tour:</th>
                <td class="booking-details-data" style="width: 80%;">{{ $booking->tour->title_tours }}</td>
            </tr>
            <tr class="booking-details-row">
                <th class="booking-details-header" style="width: 20%;">Ngày khởi hành:</th>
                <td class="booking-details-data" style="width: 80%;">
                    @if($booking->departureDate)
                        {{ \Carbon\Carbon::parse($booking->departureDate->departure_date)->format('d/m/Y') }}
                    @else
                        Chưa xác định
                    @endif
                </td>
            </tr>
            <tr class="booking-details-row">
                <th class="booking-details-header" style="width: 20%;">Tổng giá:</th>
                <td class="booking-details-data" style="width: 80%;">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</td>
            </tr>
            <tr class="booking-details-row">
                <th class="booking-details-header" style="width: 20%;">Trạng thái:</th>
                <td class="booking-details-data" style="width: 80%;">{{ $booking->booking_status }}</td>
            </tr>
            <tr class="booking-details-row">
                <th class="booking-details-header" style="width: 20%;">Ghi chú:</th>
                <td class="booking-details-data" style="width: 80%;">{{ $booking->note ?? 'Không có ghi chú' }}</td>
            </tr>
            <tr class="booking-details-row">
                <th class="booking-details-header" style="width: 20%;">Số người lớn:</th>
                <td class="booking-details-data" style="width: 80%;">{{ $booking->adults }}</td>
            </tr>
            <tr class="booking-details-row">
                <th class="booking-details-header" style="width: 20%;">Số trẻ em:</th>
                <td class="booking-details-data" style="width: 80%;">{{ $booking->children }}</td>
            </tr>
            <tr class="booking-details-row">
                <th class="booking-details-header" style="width: 20%;">Số em bé:</th>
                <td class="booking-details-data" style="width: 80%;">{{ $booking->babies }}</td>
            </tr>
            <tr class="booking-details-row">
                <th class="booking-details-header" style="width: 20%;">Số trẻ sơ sinh:</th>
                <td class="booking-details-data" style="width: 80%;">{{ $booking->infants }}</td>
            </tr>
            <tr class="booking-details-row">
                <th class="booking-details-header" style="width: 20%;">Số visa:</th>
                <td class="booking-details-data" style="width: 80%;">{{ $booking->visa_quantity }}</td>
            </tr>
            <tr class="booking-details-row">
                <th class="booking-details-header" style="width: 20%;">Số phòng đơn:</th>
                <td class="booking-details-data" style="width: 80%;">{{ $booking->single_room_quantity }}</td>
            </tr>
        </tbody>
    </table>
    <a href="{{ route('my.bookings') }}" class="btn btn-primary booking-details-back-button" style="width: fit-content;">Quay lại danh sách đặt tour</a>
</div>
@endsection
