<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Thanh Toán</title>
</head>
<body>
    <h1>Xác Nhận Thanh Toán Thành Công</h1>
    <p>Chào {{ $booking->name }},</p>
    <p>Cảm ơn bạn đã thanh toán cho tour của chúng tôi. Dưới đây là thông tin chi tiết:</p>
    <ul>
        <li><strong>Tour:</strong> {{ $booking->tour->title_tours }}</li>
        <li><strong>Tổng giá:</strong> {{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</li>
        <li><strong>Mã đặt tour:</strong> {{ $booking->booking_code }}</li>
    </ul>
    <p>Chúng tôi sẽ liên hệ với bạn để xác nhận và cung cấp thêm thông tin chi tiết về tour.</p>
    <p>Trân trọng,</p>
    <p>Đội ngũ hỗ trợ khách hàng</p>
</body>
</html>
