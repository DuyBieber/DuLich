@extends('admin_layout')

@section('admin_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0">Bảng Điều Khiển</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Bảng Điều Khiển</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Tổng Số Đơn Đặt Tour -->
            <div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h2 >Thống kê Booking theo ngày</h2>
            <p>Số booking hôm nay: <span id="todayBookingsCount">{{ $todayBookingsCount }}</span> 
    <button style="cursor: pointer;" onclick="toggleDailyBookings(this)" class="btn btn-primary">xem</button>
</p>
           
            <label for="bookingYear">Chọn năm:</label>
            <select id="bookingYear" class="form-control" style="width: 100px; display: inline-block;" onchange="updateDays()">
                @for($year = 2022; $year <= \Carbon\Carbon::now()->year; $year++)
                    <option value="{{ $year }}" {{ \Carbon\Carbon::now()->year == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>

            <label for="bookingMonth">Chọn tháng:</label>
            <select id="bookingMonth" class="form-control" style="width: 100px; display: inline-block;" onchange="updateDays()">
                @for($month = 1; $month <= 12; $month++)
                    <option value="{{ $month }}" {{ \Carbon\Carbon::now()->month == $month ? 'selected' : '' }}>{{ $month }}</option>
                @endfor
            </select>

            <label for="bookingDate">Chọn ngày:</label>
            <select id="bookingDate" class="form-control" style="width: 100px; display: inline-block;" onchange="fetchBookingsByDate()">
                <!-- Ngày sẽ được điền tự động bằng JavaScript -->
            </select>
            
            <a href="#" onclick="exportBookings()" class="btn btn-success mt-2">Xuất Excel</a>
        </div>
        
        <div id="bookingDetails" style="display: none;">
            <div class="card-body" id="bookingData">
                <!-- Nội dung các booking sẽ được AJAX cập nhật ở đây -->
                @include('admin.bookings.booking_table', ['groupedBookings' => $groupedBookings])
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="card shadow-sm mb-4 rounded">
        <div class="card-header d-flex justify-content-between align-items-center">
        <div class="mt-3">
                <h4>Danh Sách Đơn Đặt Cần Được Xử Lý</h4>
                @if($pendingBookings->isEmpty())
                    <p>Không có đơn đặt nào cần được xử lý.</p>
                @else
                    <table class="table table-bordered table-striped mt-2">
                        <thead>
                            <tr>
                                <th>Tên Tour</th>
                                <th>Tên Khách Hàng</th>
                                <th>Ngày Đặt</th>
                                <th>Trạng Thái</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingBookings as $booking)
                                <tr>
                                    <td>{{ $booking->tour->title_tours }}</td>
                                    <td>{{ $booking->customer->customer_name }}</td>
                                    <td>{{ $booking->created_at->format('d/m/Y') }}</td>
                                    <td id="status-{{ $booking->id }}">
                                        <span class="badge bg-warning">Cần Xử Lý</span>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" onclick="confirmBooking({{ $booking->id }})" class="text-muted">
                                            <i class="fas fa-check-circle"></i> Xác Nhận
                                        </a>

                                        <!-- Nếu có quyền hủy tour, thêm nút hủy -->
                                        @if($booking->canCancel)
                                            <a href="javascript:void(0);" onclick="cancelBooking({{ $booking->id }})" class="text-danger ml-2">
                                                <i class="fas fa-times-circle"></i> Hủy
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        
    </div>
</div>

<!-- Danh sách tour quá hạn cần hủy -->
<div class="col-lg-6">
    <div class="card shadow-sm mb-4 rounded">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Danh Sách Tour Quá Hạn Cần Hủy</h3>
        </div>
        <div class="card-body">
            @if(empty($overdueBookings))
                <p>Không có đơn đặt nào quá hạn.</p>
            @else
            <table class="table table-bordered table-striped mt-2">
        <thead>
            <tr>
                <th>Tên Tour</th>
                <th>Tên Khách Hàng</th>
                <th>Ngày Đặt</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($overdueBookings as $booking)
                <tr>
                    <td>{{ $booking->tour->title_tours }}</td>
                    <td>{{ $booking->customer->customer_name }}</td>
                    <td>{{ $booking->created_at->format('d/m/Y') }}</td>
                    <td id="status-{{ $booking->id }}">
                        <span class="badge bg-danger">Quá Hạn</span>
                    </td>
                    <td>
                        <!-- Nút hủy -->
                        <a href="javascript:void(0);" onclick="cancelBooking({{ $booking->id }})" 
                           id="cancel-button-{{ $booking->id }}" 
                           class="text-danger ml-2 disabled" 
                           disabled>
                            <i class="fas fa-times-circle"></i> Hủy
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
            @endif
        </div>
    </div>
</div>

<!-- Thông báo -->
<div id="toast" class="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; display: none;">
    <div class="toast show" style="min-width: 200px; background-color: #343a40; color: white; padding: 10px; border-radius: 5px;">
        <p id="toast-message" style="margin: 0;"></p>
    </div>
</div>


<!-- Toast Notification -->




            <!-- Tổng Số Khách Hàng -->
            
            <div class="col-lg-12">
                <div class="card shadow-sm mb-4 rounded">
                    <div class="card-header">
                        <h3 class="card-title">Thống Kê Doanh Thu Theo Tháng (Năm {{ \Carbon\Carbon::now()->year }})</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" style="width: 100%; height: 400px;"></canvas>
                    </div>
                </div>
            </div>
            <!-- Danh Sách Bình Luận Của Khách Hàng -->
            <div class="col-lg-12">
                <div class="card shadow-sm mb-4 rounded">
                    <div class="card-header border-0">
                        <h3 class="card-title">Danh Sách Bình Luận Của Khách Hàng</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        @if($reviews->isEmpty())
                            <p class="p-3">Chưa có bình luận nào từ khách hàng.</p>
                        @else
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Tên Khách Hàng</th>
                                        <th>Tên Tour</th>
                                        <th>Đánh Giá</th>
                                        <th>Bình Luận</th>
                                        <th>Phản Hồi Từ Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reviews as $review)
                                        <tr>
                                            <td>{{ $review->id }}</td>
                                            <td>{{ $review->customer ? $review->customer->customer_name : 'Khách hàng không xác định' }}</td>
                                            <td>{{ $review->tour ? $review->tour->title_tours : 'Tour không xác định' }}</td>
                                            <td>{{ str_repeat('⭐', $review->rating) }}</td>
                                            <td>{{ $review->comment }}</td>
                                            <td>
                                                @if($review->admin_reply)
                                                    {{ $review->admin_reply }}
                                                @else
                                                    <form action="{{ route('reviews.reply', $review->id) }}" method="POST" class="d-flex">
                                                        @csrf
                                                        <textarea name="admin_reply" rows="2" placeholder="Nhập câu trả lời..." class="form-control mr-2"></textarea>
                                                        <button type="submit" class="btn btn-primary btn-sm">Gửi</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Thống Kê Doanh Thu Theo Tháng -->

            <!-- Tổng Quan Về Tour -->

<script>
    function toggleBookingDetailsRow(row) {
        var nextRow = row.nextElementSibling;
        if (nextRow && nextRow.classList.contains('booking-details')) {
            nextRow.style.display = (nextRow.style.display === 'none' || nextRow.style.display === '') ? 'table-row' : 'none';
        }
    }

  
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
    function cancelBooking(bookingId) {
    if (confirm('Bạn có chắc chắn muốn hủy đơn đặt này không?')) {
        fetch(`/admin/cancel-booking/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ booking_id: bookingId })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Có lỗi xảy ra khi hủy booking.');
            }
            return response.json();
        })
        .then(data => {
            alert(data.message);
            location.reload(); // Làm mới trang sau khi hủy thành công
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Đã có lỗi xảy ra, vui lòng thử lại.');
        });
    }
}


</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        updateDays(); // Khởi tạo danh sách ngày ban đầu
    });

    function updateDays() {
        const year = document.getElementById('bookingYear').value;
        const month = document.getElementById('bookingMonth').value;
        const dateSelect = document.getElementById('bookingDate');
        const daysInMonth = new Date(year, month, 0).getDate(); // Lấy số ngày trong tháng

        // Xóa hết các tùy chọn hiện có
        dateSelect.innerHTML = '';

        // Tạo tùy chọn cho mỗi ngày trong tháng
        for (let day = 1; day <= daysInMonth; day++) {
            const option = document.createElement('option');
            option.value = `${year}-${month.padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            option.textContent = day;
            dateSelect.appendChild(option);
        }

        fetchBookingsByDate(); // Tải lại danh sách booking cho ngày đã chọn
    }

    function fetchBookingsByDate() {
        const selectedDate = document.getElementById('bookingDate').value;
        // Gọi AJAX để lấy danh sách booking theo ngày đã chọn
    }
</script></script>
<script>
    document.querySelectorAll('.booking-row').forEach(row => {
        row.addEventListener('click', () => {
            const detailsRow = row.nextElementSibling; // Lấy hàng chi tiết ngay sau hàng hiện tại
            detailsRow.style.display = detailsRow.style.display === 'none' ? 'table-row' : 'none'; // Toggle hiển thị
        });
    });
</script>
<script>
function toggleDailyBookings(button) {
    // Lấy phần tử chi tiết
    var detailsSection = document.getElementById('bookingDetails');

    // Kiểm tra và thay đổi hiển thị
    if (detailsSection.style.display === 'none' || detailsSection.style.display === '') {
        detailsSection.style.display = 'block'; // Hiển thị chi tiết
        button.textContent = 'Đóng'; // Đổi nhãn nút thành "Đóng"
    } else {
        detailsSection.style.display = 'none'; // Ẩn chi tiết
        button.textContent = 'Xem'; // Đổi nhãn nút thành "Xem"
    }
}

// Hàm để hiển thị thông báo
// Hàm để hiển thị thông báo
function showToast(message) {
    var toast = document.getElementById('toast');
    var toastMessage = document.getElementById('toast-message');
    toastMessage.textContent = message;
    toast.classList.add('show');  // Hiển thị thông báo

    // Ẩn thông báo sau 5 giây
    setTimeout(function() {
        toast.classList.remove('show');
    }, 5000);
}

// Kiểm tra xem có đơn đặt tour cần xác nhận hay không
function checkForPendingConfirmationBookings(bookings) {
    if (bookings.length > 0) {
        showToast("Có đơn đặt tour cần xác nhận!");
        
        // Bật các nút hành động xác nhận
        bookings.forEach(function(booking) {
            var confirmButton = document.getElementById('confirm-button-' + booking.id);
            if (confirmButton) {
                confirmButton.disabled = false; // Bật nút xác nhận
                confirmButton.classList.remove('disabled');
            }
        });
    }
}

// Kiểm tra xem có đơn đặt tour quá hạn hay không
function checkForOverdueBookings(bookings) {
    if (bookings.length > 0) {
        showToast("Có đơn đặt tour quá hạn cần hủy!");

        // Bật các nút hành động hủy
        bookings.forEach(function(booking) {
            var cancelButton = document.getElementById('cancel-button-' + booking.id);
            if (cancelButton) {
                cancelButton.disabled = false; // Bật nút hủy
                cancelButton.classList.remove('disabled'); // Gỡ bỏ class disabled
                document.getElementById('status-' + booking.id).innerHTML = '<span class="badge bg-danger">Quá Hạn</span>'; // Thay đổi trạng thái
            }
        });
    }
}

// Giả sử danh sách các booking cần xác nhận và quá hạn được truyền vào (ví dụ từ server)
var pendingConfirmationBookings = @json($pendingConfirmationBookings); // Dữ liệu danh sách booking cần xác nhận từ controller
var overdueBookings = @json($overdueBookings); // Dữ liệu booking quá hạn từ controller
checkForOverdueBookings(overdueBookings);// Dữ liệu danh sách booking quá hạn từ controller

checkForPendingConfirmationBookings(pendingConfirmationBookings);




    function fetchBookingsByDate() {
        const selectedDate = document.getElementById('bookingDate').value;

        // Gửi yêu cầu AJAX để lấy dữ liệu booking theo ngày
        fetch(`/admin/bookings-by-date?date=${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('todayBookingsCount').innerText = data.todayBookingsCount;
                document.getElementById('bookingData').innerHTML = data.html;
            })
            .catch(error => console.error('Lỗi khi tải dữ liệu booking:', error));
    }
    
</script>
<script>
    document.getElementById('loadMore').addEventListener('click', function() {
        // Hiện thêm bảng tour
        document.getElementById('additionalTours').style.display = 'block';
        // Ẩn nút "Xem Thêm" sau khi đã nhấn
        this.style.display = 'none';
    });
</script>

        </div>
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
                    // Cập nhật trạng thái trong view mà không cần tải lại trang
                    $('#status-' + bookingId).html('<span class="text-success">Đã xác nhận</span>');
                },
                error: function(xhr) {
                    alert('Đã xảy ra lỗi khi cập nhật trạng thái.');
                }
            });
        }
    }
</script>
<script>
    function exportBookings() {
        const selectedDate = document.getElementById('bookingDate').value;
        window.location.href = `/admin/bookings/export?date=${selectedDate}`;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 
                    'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                ],
                datasets: [{
                    label: 'Doanh Thu (VND)',
                    data: @json($monthlyRevenueData),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat().format(value) + ' VND';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return new Intl.NumberFormat().format(context.parsed.y) + ' VND';
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<!-- /.content -->
@endsection
