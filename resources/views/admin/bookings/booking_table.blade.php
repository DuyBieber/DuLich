@foreach($groupedBookings as $tourId => $bookings)
    <div class="tour-section">
        <h4><strong>Tour: {{ $bookings->first()->tour->title_tours }}</strong></h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách Hàng</th>
                    <th>Ngày Đặt</th>
                    <th>Tổng Giá</th>
                    <th>Số chỗ</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
    @foreach($bookings as $booking)
    <tr class="booking-row" onclick="toggleBookingDetailsRow(this)">
        <td>{{ $booking->id }}</td>
        <td>{{ $booking->customer->customer_name }}</td>
        <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
        <td>{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</td>
        <td>{{ $booking->adults + $booking->children + $booking->babies + $booking->infants }} chỗ</td>
        <td><button class="btn btn-info btn-sm">Xem chi tiết</button></td>
    </tr>
    <tr class="booking-details" style="display: none;">
        <td colspan="6">
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
        </td>
    </tr>
    @endforeach
</tbody>

        </table>
    </div>




@endforeach
