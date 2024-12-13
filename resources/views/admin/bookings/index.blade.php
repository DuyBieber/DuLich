@extends('admin_layout')
@section('admin_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Danh sách Booking</h3>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="table table-responsive">
        <table class="table table-striped" id="myTable">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên khách hàng</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tour</th>
                    <th scope="col">Ngày khởi hành</th>
                    <th scope="col">Số người lớn</th>
                    <th scope="col">Số trẻ em</th>
                    <th scope="col">Tổng giá</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Quản lý</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($bookings as $key => $booking)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $booking->name }}</td>
                    <td>{{ $booking->phone }}</td>
                    <td>{{ $booking->email }}</td>
                    <td>{{ $booking->tour ? $booking->tour->title_tours : 'Không có dữ liệu' }}</td> <!-- Updated -->
                    <td>
            @if($booking->departure_date_id && $booking->tour->departureDates->isNotEmpty())
                <span class="font-weight-bold">
                    {{ \Carbon\Carbon::parse($booking->tour->departureDates->firstWhere('id', $booking->departure_date_id)->departure_date)->format('d/m/Y') }}
                </span>
            @else
                <span class="font-weight-bold">Chưa xác định</span>
            @endif
        </td>
                    <td>{{ $booking->adults }}</td>
                    <td>{{ $booking->children }}</td>
                    <td>{{ number_format($booking->total_price, 0, ',', '.') }} vnd</td>
                    <td id="status-{{ $booking->id }}">
                        @if($booking->booking_status == 'Cần được xử lý')
                            <a href="javascript:void(0)" onclick="confirmBooking({{$booking->id}})" class="text-warning">
                                Chờ xác nhận
                            </a>
                        @elseif($booking->booking_status == 'Đã xác nhận')
                            <span class="text-success">Đã xác nhận</span>
                            
                        @else
                            <span class="text-danger">Hủy</span>
                        @endif
                    </td>
                    <td>
                    <a href="{{ route('bookings.show', [$booking->id]) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> <!-- Xem chi tiết -->
                     </a>
                        <form action="{{ route('bookings.destroy', [$booking->id]) }}" method="POST" style="display:inline;">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa không?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
</div>
<script>
    function confirmBooking(bookingId) {
        if (confirm('Bạn có chắc muốn xác nhận đơn này?')) {
            $.ajax({
                url: '/bookings/' + bookingId + '/confirm',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // Update the status in the view without refreshing
                    $('#status-' + bookingId).html('<span class="text-success">Đã xác nhận</span>');
                },
                error: function(xhr) {
                    alert('Đã xảy ra lỗi khi cập nhật trạng thái.');
                }
            });
        }
    }
</script>
@endsection
