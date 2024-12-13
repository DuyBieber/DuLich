<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận thanh toán tại quầy</title>
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
    <p>Bạn vui lòng đi đến quầy thanh toán trong vòng 7 ngày khi tour.</p>

    <ul>
        <li> 106 Đường Hai Bà Trưng, Tân An, Ninh Kiều, Cần Thơ, Việt Nam</li>
        <li> 18E Đường Cộng Hòa (Republic Plaza), Phường 4, Quận Tân Bình, Hồ Chí Minh</li>
      
    </ul>
    <p>Chúng tôi sẽ xử lý thanh toán của bạn ngay khi nhận được thông báo!.</p>
    <p>Trong trường hợp bạn chưa thanh toán quá hạn 7 ngày sau khi đặt tour, chúng tôi sẽ hủy đặt tour của bạn !</p>
</body>
</html>
