<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận thanh toán</title>
</head>
<body>
    <h1>Cảm ơn bạn đã thanh toán!</h1>
    <p>Thông tin thanh toán của bạn đã được ghi nhận:</p>
    <ul>
        <li>Mã đặt chỗ: {{ $booking->booking_code }}</li> 
        <li>Tên thanh toán: {{ $payment->payment_name }}</li>
        <li>Phương thức thanh toán: {{ $payment->payment_method }}</li>
        <li>Trạng thái: {{ $payment->status }}</li>
    </ul>
    <p>Chúng tôi sẽ xử lý thanh toán của bạn ngay lập tức.</p>
</body>
</html>
