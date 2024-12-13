@extends('layout')

@section('content')
<div class="container">
    <h2 class="booking-title">Các tour đã đặt của bạn</h2>
    @if ($bookings->isEmpty())
        <p class="no-bookings-message">Bạn chưa đặt tour nào.</p>
    @else
        <table class="table bookings-table">
            <thead>
                <tr class="table-header">
                    <th class="booking-code-header">Mã đặt chỗ</th>
                    <th class="tour-name-header">Tên tour</th>
                    <th class="departure-date-header">Ngày khởi hành</th>
                    <th class="total-price-header">Tổng giá</th>
                    <th class="status-header">Trạng thái</th>
                    <th class="actions-header">Hành động</th>
                    <th class="status-header">Thanh toán</th>
                    <th class="details-header">Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr class="booking-row">
                        <td class="booking-code">{{ $booking->booking_code }}</td>
                        <td class="tour-name">{{ $booking->tour->title_tours }}</td>
                        <td>
                            @if($booking->departureDate)
                                {{ \Carbon\Carbon::parse($booking->departureDate->departure_date)->format('d/m/Y') }}
                            @else
                                Chưa xác định
                            @endif
                        </td>
                        <td class="total-price">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</td>
                        <td class="status">{{ $booking->booking_status }}</td>
                        <td class="actions">
                            @if($booking->booking_status == 'Cần được xử lý' || $booking->booking_status == 'Đã xác nhận')
                                <button type="button" class="btn {{ $booking->booking_status == 'Cần được xử lý' ? 'btn-danger' : 'btn-warning' }} cancel-button" data-toggle="modal" data-target="#cancelModal" data-id="{{ $booking->id }}" data-status="{{ $booking->booking_status }}">
                                    {{ $booking->booking_status == 'Cần được xử lý' ? 'Hủy booking' : 'Hủy booking ' }}
                                </button>
                            @endif
                        </td>
                        <td class="payment-status">
    @if ($booking->payments->isEmpty()) <!-- Kiểm tra nếu chưa có thanh toán cho booking -->
        <a href="{{ route('booking.checkout', $booking->id) }}" class="btn btn-primary btn-sm">
            Thanh toán ngay ({{ $booking->id }})
        </a>
    @else
        <!-- Hiển thị trạng thái thanh toán nếu đã có -->
        @foreach ($booking->payments as $payment)
            <p>{{ $payment->status }}</p>
        @endforeach
    @endif
</td>


                        <td class="details">
                            <a href="{{ route('booking.detail', $booking->id) }}" class="btn btn-info detail-button">Xem chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Xác nhận hủy tour</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="cancelMessage">Bạn có chắc chắn muốn hủy tour?</p>
            </div>
            <div class="modal-footer">
                <form id="cancelForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
      document.addEventListener('DOMContentLoaded', function () {
         $('#cancelModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var bookingId = button.data('id');
            var bookingStatus = button.data('status');

            var modal = $(this);
            var cancelMessage = bookingStatus === 'Đã xác nhận'
               ? 'Tour của bạn đã được xác nhận. Nếu hủy, bạn chỉ nhận lại 70% số tiền đã đặt. Bạn có chắc chắn muốn hủy?'
               : 'Bạn có chắc chắn muốn hủy tour?';

            modal.find('#cancelMessage').text(cancelMessage);
            modal.find('#cancelForm').attr('action', '/booking/cancel/' + bookingId);
         });
      });
   </script>
@endsection
