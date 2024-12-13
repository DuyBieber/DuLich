<!DOCTYPE html>
<html>
<head>
    <title>Cập nhật thông tin đặt tour</title>
</head>
<body>
    <h1>Xin chào {{ $booking->name }}</h1>
    <p>Cảm ơn bạn đã cập nhật thông tin đặt tour của mình. Dưới đây là thông tin chi tiết:</p>
    
     <li><strong>Tour:</strong> {{ $booking->tour->title_tours }}</li>
        <li><strong>Ngày khởi hành:</strong> {{ \Carbon\Carbon::parse($booking->tour->departureDates->firstWhere('id', $booking->departure_date_id)->departure_date)->format('d/m/Y') }}</li>
        <li><strong>Tổng giá:</strong> {{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</li>
        <li><strong>Số lượng người lớn:</strong> {{ $booking->adults }}</li>
        <li><strong>Số lượng trẻ em:</strong> {{ $booking->children }}</li>
        <li><strong>Số lượng trẻ sơ sinh:</strong> {{ $booking->babies }}</li>
        <li><strong>Số lượng trẻ nhỏ:</strong> {{ $booking->infants }}</li>
        <li><strong>Ghi chú:</strong> {{ $booking->note }}</li>
    <p>Nếu bạn cần hỗ trợ thêm, vui lòng liên hệ với chúng tôi.</p>
    <p>Trân trọng,</p>
    <p>Đội ngũ hỗ trợ khách hàng</p>
</body>
</html>
