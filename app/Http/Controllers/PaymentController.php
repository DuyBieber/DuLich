<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payments;
use App\Models\Booking;
use Illuminate\Support\Facades\Session;
use App\Mail\PaymentConfirmationMail;
use App\Mail\PaymentSuccessConfirmationMail;
use App\Mail\BankPaymentConfirmationMail;
use App\Mail\CodPaymentConfirmationMail;
 // Đảm bảo đã import class email
 // Import facade Mail

class PaymentController extends Controller
{
    public function store(Request $request)
{
    // Lấy booking_id từ Session
    $booking_id = Session::get('booking_id');

    // Xác thực dữ liệu
    $validatedData = $request->validate([
        'payment_name' => 'required|string',
        'payment_method' => 'required|string',
    ]);

    // Kiểm tra xem đã có thanh toán nào cho booking_id này chưa
    $existingPayment = Payments::where('booking_id', $booking_id)->first();

    if ($existingPayment) {
        // Cập nhật thông tin thanh toán
        $existingPayment->update([
            'payment_name' => $validatedData['payment_name'],
            'payment_method' => $validatedData['payment_method'],
            'status' => 'Đang chờ xử lý',
        ]);
        $payment = $existingPayment;
    } else {
        // Tạo mới nếu chưa có
        $payment = Payments::create([
            'booking_id' => $booking_id,
            'payment_name' => $validatedData['payment_name'],
            'payment_method' => $validatedData['payment_method'],
            'status' => 'Đang chờ xử lý',
        ]);
    }

    // Lấy thông tin booking
    $booking = Booking::find($booking_id);

    // Gửi email tùy theo phương thức thanh toán
    switch ($validatedData['payment_method']) {
        case 'Bank Transfer':
            Mail::to($booking->email)->send(new BankPaymentConfirmationMail($payment, $booking));
            break;
        case 'VNPay':
            Mail::to($booking->email)->send(new PaymentConfirmationMail($payment, $booking));
            break;
        case 'COD':
            Mail::to($booking->email)->send(new CodPaymentConfirmationMail($payment, $booking));
            break;
        default:
            throw new \Exception('Phương thức thanh toán không hợp lệ');
    }

    // Trả về view thành công
    return view('pages.payments.payment_success', [
        'booking_id' => $booking_id,
    ])->with('success', 'Thanh toán của bạn đang được xử lý!');
}

    public function updatePaymentStatus($id)
{
    // Tìm thanh toán theo ID
    $payment = Payments::find($id);

    if ($payment) {
        // Cập nhật trạng thái thanh toán
        $payment->update(['status' => 'Đã thanh toán']); // Hoặc trạng thái khác tùy ý

        // Gửi email xác nhận thanh toán thành công
        Mail::to($payment->booking->email)->send(new PaymentSuccessConfirmationMail($payment->booking->id));

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
}



}
