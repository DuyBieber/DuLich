<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đặt Tour</title>
</head>
<body>
    <h1>Xác Nhận Đặt Tour</h1>
    <p>Chào {{ $booking->name }},</p>
    <p>Cảm ơn bạn đã đặt tour với chúng tôi. Dưới đây là thông tin chi tiết của bạn:</p>
    <ul>
        <li><strong>Tour:</strong> {{ $booking->tour->title_tours }}</li>
        <li><strong>Ngày khởi hành:</strong>{{ \Carbon\Carbon::parse($booking->departureDate->departure_date)->format('d/m/Y') }}</li>
        <li><strong>Tổng giá:</strong> {{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</li>
        <li><strong>Số lượng người lớn:</strong> {{ $booking->adults }}</li>
        <li><strong>Số lượng trẻ em:</strong> {{ $booking->children }}</li>
        <li><strong>Số lượng trẻ sơ sinh:</strong> {{ $booking->babies }}</li>
        <li><strong>Số lượng trẻ nhỏ:</strong> {{ $booking->infants }}</li>
        <li><strong>Số lượng phòng đơn:</strong> {{ $booking->single_room_quantity }}</li>
        <li><strong>Ghi chú:</strong> {{ $booking->note }}</li>
    </ul>
    <p>Cảm ơn bạn đặt tour ,chúng tôi đã tiếp nhận và xác nhận tour của bạn.</p>
    <p>Vui lòng chờ máy trong vài giờ tới nhân viên bên chúng tôi sẽ liện hệ để sắp xếp số phòng cho bạn.</p>
    <p>Trân trọng,</p>
    <p>Đội ngũ hỗ trợ khách hàng</p>
</body>
</html>
