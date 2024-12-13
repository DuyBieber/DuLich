<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận hủy tour</title>
</head>
<body>
    <h2>Xin chào {{  $booking->name}}</h2>

    <p>Chúng tôi xin xác nhận rằng tour của bạn đã được hủy thành công.</p>
    <p>Lý do bạn đã quá hạn thanh toán 7 ngày kể từ ngày đặt tour.</p>
    <p>Chi tiết tour</p>
    <p><strong>Tên tour:</strong> {{ $booking->tour->title_tours }}</p>
    <p><strong>Mã đặt chỗ:</strong> {{ $booking->booking_code }}</p>
    <p><strong>Ngày khởi hành:</strong> {{ \Carbon\Carbon::parse($booking->departureDate->departure_date)->format('d/m/Y') }}</p>
    <p>Nếu có thắc mắc, vui lòng liên hệ với chúng tôi qua email này.</p>

    <p>Trân trọng,<br>
    Đội ngũ hỗ trợ</p>
</body>
</html>
