@extends('admin_layout')

@section('admin_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Chi Tiết Booking</h3>
    </div>
    <div class="card-body">
        <h5>Thông tin khách hàng</h5>
        <p>Tên: {{ $booking->name }}</p>
        <p>Số điện thoại: 0{{ $booking->phone }}</p>
        <p>Email: {{ $booking->email }}</p>
        <p>Tour: {{ $booking->tour->title_tours ?? 'Không có dữ liệu' }}</p>
        <p>Ngày khởi hành: 
@if($booking->tour && $booking->tour->departureDates->isNotEmpty())
    @foreach($booking->tour->departureDates as $departureDate)
        @if(is_string($departureDate->departure_date))
            {{ \Carbon\Carbon::parse($departureDate->departure_date)->format('d/m/Y') }}<br>
        @else
            {{ $departureDate->departure_date->format('d/m/Y') }}<br>
        @endif
    @endforeach
@else
    Chưa có ngày khởi hành
@endif
</p>

        <p>Tổng giá: {{ number_format($booking->total_price, 0, ',', '.') }} vnd</p>
        <p>Trạng thái: {{ $booking->booking_status }}</p>

        <h5>Thông tin thanh toán</h5>
        @if($booking->payments->isEmpty())
            <p>Chưa có thanh toán nào.</p>
        @else
            <ul class="list-group">
            
                @foreach ($booking->payments as $payment)
                    <li class="list-group-item">
                    <strong>Tổng giá:</strong> {{ number_format($booking->total_price, 0, ',', '.') }} vnd<br>
                        <strong>Phương thức:</strong> {{ $payment->payment_method }}<br>
                        <strong>Tên thanh toán:</strong> {{ $payment->payment_name }}<br>
                        <strong>Trạng thái:</strong> {{ $payment->status }}<br>

                        @if($payment->status == 'Đang chờ xử lý')
                            <a href="javascript:void(0)" onclick="updatePaymentStatus({{ $payment->id }})" class="btn btn-warning btn-sm">Cập nhật trạng thái</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="card-footer">
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Quay lại</a>

    </div>
</div>

<script>
    function updatePaymentStatus(paymentId) {
        if (confirm('Bạn có chắc muốn cập nhật trạng thái thanh toán này?')) {
            $.ajax({
                url: '/payments/' + paymentId + '/update-status', // Thay đổi URL cho phù hợp
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    alert('Cập nhật trạng thái thành công!');
                    location.reload(); // Tải lại trang để thấy sự thay đổi
                },
                error: function(xhr) {
                    alert('Đã xảy ra lỗi khi cập nhật trạng thái.');
                }
            });
        }
    }
</script>

@endsection
