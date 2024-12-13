<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Tour;
use App\Models\TourPriceDetail;
use App\Models\DepartureDate;
use App\Models\Booking; 
use App\Models\Coupon; 
use App\Models\Payments;
use App\Models\Customer;
use App\Mail\BookingConfirmationMail; 
use App\Mail\BookingConfirmed;
use App\Mail\PaymentSuccessConfirmationMail;
use App\Mail\BookingUpdateMail;
use App\Mail\CancelBookingConfirmed;
use App\Mail\AutocancelConfirmationMail;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
class BookingController extends Controller
{
 
    public function addCheckoutBookingAjax(Request $request)
{
    $request->validate([
        'booking_tour_id' => 'required|integer',
        'booking_tour_name' => 'required|string',
        'booking_tour_image' => 'required|string',
        'booking_tour_qty' => 'required|integer|min:1',
        'booking_tour_price' => 'required|numeric',
        'booking_tour_departure_date' => 'required|string',
    ]);

    // Kiểm tra nếu đã có booking với cùng ngày khởi hành cho bất kỳ tour nào khác
    $duplicateBooking = Booking::where('customer_id', session('customer_id'))
        ->where('departure_date_id', $request->booking_tour_departure_date)
        ->where('booking_status', 'Đã xác nhận')
        ->where('tour_id', '!=', $request->booking_tour_id)
        ->first();

    if ($duplicateBooking && !$request->has('force_add')) {
        return response()->json([
            'success' => false,
            'duplicate' => true,
            'message' => 'Bạn đã đặt tour khác với cùng ngày khởi hành đã chọn!'
        ]);
    }

    // Kiểm tra booking cho cùng tour
    $existingBooking = Booking::where('tour_id', $request->booking_tour_id)
        ->where('departure_date_id', $request->booking_tour_departure_date)
        ->where('booking_status', 'Đã xác nhận')
        ->first();

    if ($existingBooking && !$request->has('force_add')) {
        return response()->json([
            'success' => false,
            'duplicate' => true,
            'message' => 'Bạn đã đặt tour này với ngày khởi hành đã chọn!'
        ]);
    }
    $data = $request->all();
    $cart = Session::get('cart', []);
    $is_available = false;

    foreach ($cart as $key => $val) {
        if ($val['tour_id'] == $data['booking_tour_id']) {
            $cart[$key]['tour_qty'] += $data['booking_tour_qty'];
            $is_available = true;
            break;
        }
    }

    if (!$is_available) {
        $cart[] = [
            'session_id' => substr(md5(microtime()), rand(0, 26), 5),
            'tour_name' => $data['booking_tour_name'],
            'tour_id' => $data['booking_tour_id'],
            'tour_image' => $data['booking_tour_image'],
            'tour_qty' => $data['booking_tour_qty'],
            'tour_price' => $data['booking_tour_price'],
            'departure_date' => $data['booking_tour_departure_date'], // Lấy từ dữ liệu gửi lên
            'available_seats' => Session::get('available_seats'), // Lấy từ session
        ];
    }

    Session::put('cart', $cart);
    Session::save();

    return response()->json(['success' => true, 'message' => 'Đã đặt tour', 'cart' => $cart]);
}

    

public function addCheckoutBookingOtherAjax(Request $request)
{
    $request->validate([
        'booking_tour_id' => 'required|integer',
        'booking_tour_time' => 'required|integer',
        'booking_tour_qty' => 'required|integer|min:1',
        'booking_tour_price' => 'required|numeric',
        'booking_type' => 'required|string',
    ]);

    // Kiểm tra nếu đã có booking với cùng ngày khởi hành cho tour khác
    $duplicateBooking = Booking::where('customer_id', session('customer_id'))
        ->where('departure_date_id', $request->booking_tour_time)
        ->where('booking_status', 'Đã xác nhận')
        ->where('tour_id', '!=', $request->booking_tour_id)
        ->first();

    if ($duplicateBooking && !$request->has('force_add')) {
        return response()->json([
            'success' => false,
            'duplicate' => true,
            'message' => 'Bạn đã đặt tour khác với cùng ngày khởi hành đã chọn!'
        ]);
    }

    // Kiểm tra booking cho cùng tour
    $existingBooking = Booking::where('tour_id', $request->booking_tour_id)
        ->where('departure_date_id', $request->booking_tour_time)
        ->where('booking_status', 'Đã xác nhận')
        ->first();

    if ($existingBooking && !$request->has('force_add')) {
        return response()->json([
            'success' => false,
            'duplicate' => true,
            'message' => 'Bạn đã đặt tour này với ngày khởi hành đã chọn!'
        ]);
    }

    $data = $request->all();
    $cart = Session::get('cart', []);
    $is_available = false;

    if (!$is_available) {
        $cart[] = [
            'session_id' => substr(md5(microtime()), rand(0, 26), 5),
            'tour_id' => $data['booking_tour_id'],
            'tour_time' => $data['booking_tour_time'],
            'tour_qty' => $data['booking_tour_qty'],
            'tour_price' => $data['booking_tour_price'],
            'departure_date' => Session::get('departure_date'), // Lấy từ session
            'available_seats' => Session::get('available_seats'), // Lấy từ session
        ];
    }

    Session::put('cart', $cart);
    Session::save();

    return response()->json(['success' => true, 'message' => 'Đã đặt tour', 'cart' => $cart]);
}

    
public function showCheckoutFixedBooking($id)
{
    $tour = Tour::findOrFail($id);
    $departureDate = DepartureDate::where('tour_id', $tour->id)->first();

    if (!$departureDate) {
        return redirect()->back()->with('error', 'Không tìm thấy lịch trình khởi hành.');
    }

    $availableSeats = $departureDate->available_seats;
    if ($availableSeats == 0) {
        $alternativeDepartureDate = DepartureDate::where('tour_id', $tour->id)
            ->where('available_seats', '>', 0)
            ->first();

        if ($alternativeDepartureDate) {
            $departureDate = $alternativeDepartureDate;
            $availableSeats = $alternativeDepartureDate->available_seats;
        } else {
            return redirect()->back()->with('error', 'Không có lịch trình nào có chỗ trống.');
        }
    }

    $tourPriceDetail = TourPriceDetail::where('tour_id', $tour->id)
                        ->where('departure_date_id', $departureDate->id)
                        ->first();

    if (!$tourPriceDetail) {
        return redirect()->back()->with('error', 'Không tìm thấy bảng giá cho ngày khởi hành này.');
    }

    $customerId = Session::get('customer_id');
    $customer = Customer::findOrFail($customerId); 
    Session::put('customer_name', $customer->customer_name);
    Session::put('customer_email', $customer->customer_email);
    Session::put('customer_phone', $customer->customer_phone);
    Session::put('customer_address', $customer->customer_address);
    $coupons = Coupon::whereHas('customers', function ($query) use ($customerId) {
        $query->where('customer_id', $customerId)
              ->where('is_redeemed', 0); // Chỉ lấy mã giảm giá chưa sử dụng
    })->get();

    Session::put('departure_date', $departureDate->departure_date);
    Session::put('available_seats', $availableSeats);

    return view('pages.checkout.fixed_checkout_booking', compact('tour', 'tourPriceDetail', 'departureDate', 'availableSeats', 'coupons'));
}





public function showCheckoutOtherBooking($tourId, $departureDateId)
{
    $tour = Tour::findOrFail($tourId);
    $departureDate = DepartureDate::findOrFail($departureDateId);
    $tourPriceDetail = TourPriceDetail::where('tour_id', $tour->id)
                                       ->where('departure_date_id', $departureDate->id)
                                       ->first();
    $availableSeats = $departureDate->available_seats; // Lấy số chỗ từ trường available_seats
    $customerId = Session::get('customer_id');
    $customer = Customer::findOrFail($customerId); 
    Session::put('customer_name', $customer->customer_name);
    Session::put('customer_email', $customer->customer_email);
    Session::put('customer_phone', $customer->customer_phone);
    Session::put('customer_address', $customer->customer_address);
    $coupons = Coupon::whereHas('customers', function ($query) use ($customerId) {
        $query->where('customer_id', $customerId)
              ->where('is_redeemed', 0); // Chỉ lấy mã giảm giá chưa sử dụng
    })->get();
    
    // Lưu departureDate và availableSeats vào session
    Session::put('departure_date', $departureDate->departure_date);
    Session::put('available_seats', $availableSeats);

    return view('pages.checkout.other_checkout_booking', compact('tour', 'departureDate', 'tourPriceDetail', 'availableSeats','coupons'));
}



public function store(Request $request)
{
    // Validate input data
    $validatedData = $request->validate([
        'customer_id' => 'required|integer',
        'tour_id' => 'required|integer',
        'Name' => 'required|string|max:255',
        'Mail' => 'required|email',
        'Phone' => 'required|string|max:15',
        'AddressShow' => 'required|string|max:255',
        'Note' => 'nullable|string|max:255',
        'QAdult' => 'required|integer|min:1',
        'QChild' => 'nullable|integer|min:0',
        'QBaby' => 'nullable|integer|min:0',
        'QInfant' => 'nullable|integer|min:0',
        'slvisa' => 'nullable|integer|min:0',
        'slphongdon' => 'nullable|integer|min:0',
        'departure_date_id' => 'required|integer',
        'coupon_code' => 'nullable|string',
        'departure_date' => 'required|date',
    ]);
    
    // Kiểm tra nếu có booking đã được xác nhận cho khách hàng và tour này
    $existingBooking = Booking::where('tour_id', $validatedData['tour_id'])
    ->where('customer_id', $validatedData['customer_id'])
    ->where('departure_date_id', $validatedData['departure_date_id'])
    ->where('booking_status', '!=', 'Đã xác nhận')
    ->first();
    // Tìm chi tiết giá cho tour và ngày khởi hành đã chọn
    $tourPriceDetail = TourPriceDetail::where('tour_id', $validatedData['tour_id'])
        ->where('departure_date_id', $validatedData['departure_date_id'])
        ->first();

    if (!$tourPriceDetail) {
        return redirect()->back()->with('error', 'Không tìm thấy mức giá cho tour này.');
    }

    // Tính toán tổng giá
    $adults_total = $validatedData['QAdult'] * $tourPriceDetail->adult_price;
    $children_total = ($validatedData['QChild'] ?? 0) * $tourPriceDetail->child_price;
    $babies_total = ($validatedData['QBaby'] ?? 0) * $tourPriceDetail->baby_price;
    $infants_total = ($validatedData['QInfant'] ?? 0) * $tourPriceDetail->infant_price;
    $visa_total = ($validatedData['slvisa'] ?? 0) * $tourPriceDetail->foreign_surcharge;
    $single_room_total = ($validatedData['slphongdon'] ?? 0) * $tourPriceDetail->single_room_surcharge;

    $total_price = $adults_total + $children_total + $babies_total + $infants_total + $visa_total + $single_room_total;

    // Xử lý logic mã giảm giá
    $discount_percentage = 0;
    $coupon_id = null;
    if (!empty($validatedData['coupon_code'])) {
        $coupon = Coupon::where('coupon_code', $validatedData['coupon_code'])->first();

        if ($coupon) {
            // Kiểm tra nếu mã giảm giá đã được sử dụng bởi khách hàng cho bất kỳ booking nào chưa bị hủy
            $usedCoupon = DB::table('booking_coupon')
                ->where('customer_id', $validatedData['customer_id'])
                ->where('coupon_id', $coupon->id)
                ->exists();

            if ($usedCoupon) {
                return redirect()->back()->with('error', 'Bạn đã sử dụng mã giảm giá này rồi.');
            }

            // Kiểm tra số lượng mã giảm giá còn lại
            if ($coupon->coupon_quantity > 0) {
                $discount_percentage = $coupon->coupon_number;
                $coupon_id = $coupon->id;
                // Giảm số lượng mã giảm giá còn lại
                $coupon->coupon_quantity -= 1;
                $coupon->save();
            } else {
                return redirect()->back()->with('error', 'Mã giảm giá đã hết lượt sử dụng.');
            }
        } else {
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ.');
        }
    }

    $discount_amount = ($total_price * $discount_percentage) / 100;
    $total_price -= $discount_amount;
    $total_price = max(0, $total_price); // Đảm bảo tổng giá không âm

    // Tạo một booking mới nếu có booking đã xác nhận
    if ($existingBooking) {
        // Nếu đã có booking chưa xác nhận, cập nhật thông tin
        $existingBooking->update([
            'name' => $validatedData['Name'],
            'phone' => $validatedData['Phone'],
            'email' => $validatedData['Mail'],
            'address' => $validatedData['AddressShow'],
            'note' => $validatedData['Note'] ?? '',
            'adults' => $validatedData['QAdult'],
            'children' => $validatedData['QChild'] ?? 0,
            'babies' => $validatedData['QBaby'] ?? 0,
            'infants' => $validatedData['QInfant'] ?? 0,
            'visa_quantity' => $validatedData['slvisa'] ?? 0,
            'single_room_quantity' => $validatedData['slphongdon'] ?? 0,
            'total_price' => $total_price,
            'coupon_id' => $coupon_id,
            'booking_status' => 'Cần được xử lý',
        ]);
        $booking = $existingBooking;
    } else {
        // Nếu chưa có booking nào, tạo mới
        $booking = Booking::create([
            'tour_id' => $validatedData['tour_id'],
            'customer_id' => $validatedData['customer_id'],
            'name' => $validatedData['Name'],
            'phone' => $validatedData['Phone'],
            'email' => $validatedData['Mail'],
            'address' => $validatedData['AddressShow'],
            'note' => $validatedData['Note'] ?? '',
            'adults' => $validatedData['QAdult'],
            'children' => $validatedData['QChild'] ?? 0,
            'babies' => $validatedData['QBaby'] ?? 0,
            'infants' => $validatedData['QInfant'] ?? 0,
            'visa_quantity' => $validatedData['slvisa'] ?? 0,
            'single_room_quantity' => $validatedData['slphongdon'] ?? 0,
            'total_price' => $total_price,
            'coupon_id' => $coupon_id,
            'booking_status' => 'Cần được xử lý',
            'booking_code' => Str::random(10),
            'departure_date_id' => $validatedData['departure_date_id'],
        ]);
    }

    // Ghi lại thông tin mã coupon đã sử dụng vào bảng trung gian (nếu có)
    if ($coupon_id) {
        $coupon = Coupon::find($coupon_id);
    
        // Giảm số lượng mã giảm giá còn lại
        $coupon->coupon_quantity -= 1;
        $coupon->save();
    
        // Lưu thông tin mã coupon đã sử dụng vào bảng trung gian
        DB::table('coupon_customer')->updateOrInsert(
            ['customer_id' => $validatedData['customer_id'], 'coupon_id' => $coupon_id],
            ['is_redeemed' => true, 'assigned_at' => now()] // Đánh dấu mã giảm giá đã được sử dụng
        );
    
        // Lưu thông tin vào bảng booking_coupon
        DB::table('booking_coupon')->insert([
            'booking_id' => $booking->id,
            'customer_id' => $validatedData['customer_id'],
            'coupon_id' => $coupon_id,
            'used_at' => now(),
        ]);
    }

    // Giảm số chỗ ngồi còn lại dựa trên ngày khởi hành và tổng số hành khách
    $departureDate = DepartureDate::find($validatedData['departure_date_id']);
    if ($departureDate) {
        $departureDate->available_seats -= ($validatedData['QAdult'] + ($validatedData['QChild'] ?? 0));
        $departureDate->save();
    }

    // Gửi email xác nhận booking
    Mail::to($validatedData['Mail'])->send(new BookingConfirmationMail($booking));

    // Lưu thông tin booking và khách hàng vào session
    Session::put('tour_data', [
        'id' => $validatedData['tour_id'],
        'name' => $tourPriceDetail->tour->title_tours,
        'image' => $tourPriceDetail->tour->image,
        'times' => $tourPriceDetail->tour->tour_time,
        'tour_code' => $tourPriceDetail->tour->tour_code,
        'adult_price' => $tourPriceDetail->adult_price,
        'adults' => $validatedData['QAdult'],
        'children' => $validatedData['QChild'] ?? 0,
        'babies' => $validatedData['QBaby'] ?? 0,
        'infants' => $validatedData['QInfant'] ?? 0,
        'departure_date_id' => $validatedData['departure_date_id'],
        'departure_date' => $validatedData['departure_date'], 
    ]);

    Session::put('total_price', $total_price);
    Session::put('booking_id', $booking->id);
    Session::put('customer_info', [
        'Name' => $validatedData['Name'],
        'Mail' => $validatedData['Mail'],
        'Phone' => $validatedData['Phone'],
        'AddressShow' => $validatedData['AddressShow'],
        'Note' => $validatedData['Note'],
        'QAdult' => $validatedData['QAdult'],
        'QChild' => $validatedData['QChild'] ?? 0,
        'QBaby' => $validatedData['QBaby'] ?? 0,
        'QInfant' => $validatedData['QInfant'] ?? 0,
        'coupon_code' => $validatedData['coupon_code'],
        'slvisa' => $validatedData['slvisa'] ?? 0,
        'slphongdon' => $validatedData['slphongdon'] ?? 0,
        'total_price' => $total_price,
        'customer_id' => $validatedData['customer_id'],
    ]);

    // Chuyển hướng đến trang thanh toán
    return redirect()->route('payment.show', ['id' => $booking->id])->with('success', 'Đặt tour thành công! Mã giảm giá đã được áp dụng.');
}
    
    public function showPaymentPage($id) // Nhận ID booking từ route
    {
        // Lấy thông tin từ session
        $tourData = Session::get('tour_data');
        $customerInfo = Session::get('customer_info');
        
       
    
        // Lấy thông tin booking từ DB bằng ID đã nhận
        $booking = Booking::find($id);
    
        // Kiểm tra nếu không tìm thấy booking
        if (!$booking) {
            return redirect()->route('home')->with('error', 'Không tìm thấy thông tin đặt chỗ.');
        }
        $couponCode = $customerInfo['coupon_code'] ?? null;
$customerId = Session::get('customer_id');
$coupons = Coupon::whereHas('customers', function ($query) use ($customerId) {
    $query->where('customer_id', $customerId)
          ->where('is_redeemed', 0); // Chỉ lấy mã giảm giá chưa sử dụng
})->get();
        // Truyền booking ID vào view
        $bookingId = $booking->id;
    
        // Hiển thị trang thanh toán
        return view('pages.payments.show_payment', compact('tourData', 'customerInfo', 'booking', 'bookingId', 'couponCode', 'coupons'));
    }
    
    public function updatePayment(Request $request)
{
    // Validate dữ liệu
    $validatedData = $request->validate([
        'Name' => 'required|string|max:255',
        'Mail' => 'required|email',
        'Phone' => 'required|string|max:15',
        'AddressShow' => 'required|string',
        'Note' => 'nullable|string',
        'QAdult' => 'required|integer|min:1',
        'QChild' => 'nullable|integer|min:0',
        'QBaby' => 'nullable|integer|min:0',
        'QInfant' => 'nullable|integer|min:0',
        'slvisa' => 'nullable|integer|min:0',
        'slphongdon' => 'nullable|integer|min:0',
        'coupon_code' => 'nullable|string|max:10',
    ]);

    // Kiểm tra thông tin tour và khách hàng trong session
    if (!Session::has('tour_data') || !Session::has('customer_info')) {
        return redirect()->back()->with('error', 'Thông tin tour không đầy đủ.');
    }

    $tourData = Session::get('tour_data');
    $customerInfo = array_merge(Session::get('customer_info', []), $validatedData);

    // Tìm mức giá tương ứng với tour và ngày khởi hành
    $tourPriceDetail = TourPriceDetail::where('tour_id', $tourData['id'])
        ->where('departure_date_id', $tourData['departure_date_id'])
        ->first();

    if (!$tourPriceDetail) {
        return redirect()->back()->with('error', 'Không tìm thấy mức giá cho tour này.');
    }

    // Tính toán tổng tiền
    $total_price = ($customerInfo['QAdult'] * $tourPriceDetail->adult_price) +
                (($customerInfo['QChild'] ?? 0) * $tourPriceDetail->child_price) +
                (($customerInfo['QBaby'] ?? 0) * $tourPriceDetail->baby_price) +
                (($customerInfo['QInfant'] ?? 0) * $tourPriceDetail->infant_price) +
                (($customerInfo['slvisa'] ?? 0) * $tourPriceDetail->foreign_surcharge) +
                (($customerInfo['slphongdon'] ?? 0) * $tourPriceDetail->single_room_surcharge);

    // Kiểm tra mã giảm giá
    $coupon_id = null;
    $discount_percentage = 0;

    if (!empty($customerInfo['coupon_code'])) {
        $coupon = Coupon::where('coupon_code', $customerInfo['coupon_code'])->first();
    
        if ($coupon) {
            // Kiểm tra mã giảm giá trong bảng coupon_customer
            $customerCoupon = DB::table('coupon_customer')
                ->where('customer_id', Session::get('customer_id'))
                ->where('coupon_id', $coupon->id)
                ->where('is_redeemed', false) // Mã chưa được sử dụng
                ->first();
    
            if ($customerCoupon) {
                $discount_percentage = $coupon->coupon_number;
                $coupon_id = $coupon->id;
    
                // Đánh dấu mã giảm giá đã được sử dụng
                DB::table('coupon_customer')
                    ->where('customer_id', Session::get('customer_id'))
                    ->where('coupon_id', $coupon->id)
                    ->update(['is_redeemed' => true]);
            } else {
                return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã được sử dụng.');
            }
        } else {
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ.');
        }
    } else {
        // Giữ lại mã giảm giá cũ
        $bookingId = Session::get('booking_id');
        if ($bookingId) {
            $booking = Booking::find($bookingId);
            if ($booking && $booking->coupon_id) {
                $coupon = Coupon::find($booking->coupon_id);
                if ($coupon) {
                    $discount_percentage = $coupon->coupon_number;
                    $coupon_id = $coupon->id;
                }
            }
        }
    }
    
    // Tính toán tổng tiền sau khi áp dụng giảm giá
    $discount_amount = ($total_price * $discount_percentage) / 100;
    $total_price = max(0, $total_price - $discount_amount);
    $customerInfo['total_price'] = $total_price;

    // Lưu thông tin khách hàng vào session
    Session::put('customer_info', $customerInfo);

    // Lấy ID của booking từ session
    $bookingId = Session::get('booking_id');
    if (!$bookingId) {
        return redirect()->back()->with('error', 'Không tìm thấy thông tin booking.');
    }

    $booking = Booking::find($bookingId);
    if (!$booking) {
        return redirect()->back()->with('error', 'Booking không tồn tại.');
    }

    // Cập nhật thông tin booking
    $booking->update([
        'tour_id' => $tourData['id'],
        'name' => $customerInfo['Name'],
        'email' => $customerInfo['Mail'],
        'phone' => $customerInfo['Phone'],
        'address' => $customerInfo['AddressShow'],
        'note' => $customerInfo['Note'],
        'adults' => $customerInfo['QAdult'],
        'children' => $customerInfo['QChild'] ?? 0,
        'babies' => $customerInfo['QBaby'] ?? 0,
        'infants' => $customerInfo['QInfant'] ?? 0,
        'visa_quantity' => $customerInfo['slvisa'] ?? 0,
        'single_room_quantity' => $customerInfo['slphongdon'] ?? 0,
        'coupon_id' => $coupon_id, // Lưu coupon_id vào booking
        'total_price' => $total_price,
        'booking_status' => 'Cần được xử lý'
    ]);

    // Ghi thông tin mã coupon đã sử dụng vào bảng trung gian (nếu có)
    if ($coupon_id) {
        DB::table('booking_coupon')->updateOrInsert(
            ['booking_id' => $booking->id, 'customer_id' => $customerInfo['customer_id'], 'coupon_id' => $coupon_id],
            ['used_at' => now()]
        );
    }
    if ($coupon_id && isset($customerInfo['customer_id'])) {
        DB::table('coupon_customer')->updateOrInsert(
            ['customer_id' => $customerInfo['customer_id'], 'coupon_id' => $coupon_id],  // Điều kiện tìm kiếm bản ghi
            ['is_redeemed' => true, 'assigned_at' => now()]  // Cập nhật các trường
        );
    }
    Mail::to($customerInfo['Mail'])->send(new BookingUpdateMail($booking));
    Session::put('total_price', $total_price);

    return redirect()->route('payment.show', ['id' => $booking->id])
        ->with('success', 'Cập nhật thông tin thanh toán thành công!');
}

    
    public function vnpayPayment(Request $request)
    {
        // Lưu URL trang hiện tại vào session để trả về sau khi thanh toán thành công
        Session::put('url_previous', url()->current());

        // Lấy booking_id từ request
        $booking_id = $request->input('booking_id');

        // Kiểm tra xem booking_id có tồn tại không
        if (!$booking_id) {
            return redirect()->back()->with('error', 'Không tìm thấy booking_id.');
        }

        // Các biến và cấu hình của VNPay
        $code_cart = rand(00, 9999);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/payment_success"; // Đường dẫn trả về
        $vnp_TmnCode = "PAIIMRE3"; 
        $vnp_HashSecret = "138G0MHOH4ORBVTN31SVDSXKGK6CUVWM"; 

        // Lấy tổng tiền từ session
        $total_price = Session::get('total_price');

        if (!$total_price) {
            return redirect()->back()->with('error', 'Không tìm thấy tổng tiền để thanh toán.');
        }

        // Tổng tiền cần thanh toán
        $vnp_Amount = $total_price * 100;

        // Thông tin thanh toán
        $vnp_TxnRef = $code_cart; // Mã đơn hàng
        $vnp_OrderInfo = 'Thanh toán đơn hàng VNPay';
        $vnp_OrderType = 'Billpayment';
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        // Thông tin để lưu vào bảng payment
        Payments::create([
            'booking_id' => $booking_id,
            'payment_name' => 'Thanh toán qua VNPay',
            'payment_method' => 'VNPay',
            'status' => 'Đang chờ xử lý', // Trạng thái ban đầu
        ]);

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $hashdata = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        // Chuyển hướng đến trang thanh toán VNPay
        return redirect($vnp_Url);
    }
    public function PaymentSuccessVNpay(Request $request)
    {
        // Lấy booking_id từ Session
        $booking_id = Session::get('booking_id');
    
        // Lấy transaction_id từ phản hồi của VNPay
        $transaction_id = $request->vnp_TxnRef;
    
        // Kiểm tra phản hồi từ VNPay (vnp_ResponseCode = "00" nghĩa là thanh toán thành công)
        if ($request->vnp_ResponseCode == "00") {
            // Tìm bản ghi thanh toán dựa trên booking_id
            $payment = Payments::where('booking_id', $booking_id)->first();
            
            if ($payment) {
                // Nếu đã tồn tại, cập nhật thông tin
                $payment->update([
                    'transaction_id' => $transaction_id,
                    'payment_name' => 'Thanh toán thành công',
                    'payment_method' => 'VNPay',
                    'status' => 'Thành công',
                ]);
            } else {
                // Nếu chưa tồn tại, tạo bản ghi mới
                $payment = Payments::create([
                    'booking_id' => $booking_id,
                    'payment_name' => 'Thanh toán thành công',
                    'payment_method' => 'VNPay',
                    'transaction_id' => $transaction_id,
                    'status' => 'Thành công',
                ]);
            }
    
            // Gửi email xác nhận thanh toán
            $bookingDetails = Booking::find($booking_id);
            if ($bookingDetails) {
                Mail::to($bookingDetails->email)->send(new PaymentSuccessConfirmationMail($booking_id));
            }
    
            // Xóa URL khỏi session
            Session::forget('url_previous');
    
            // Trả về view thanh toán thành công
            return view('pages.payments.payment_success', [
                'booking_id' => $booking_id,
            ])->with('success', 'Thanh toán thành công!');
        } else {
            // Nếu thanh toán thất bại
            $urlPrevious = Session::get('url_previous', route('payment.show', ['id' => $booking_id]));
            Session::forget('url_previous');
            return redirect($urlPrevious)->with('error', 'Thanh toán thất bại, vui lòng thử lại.');
        }
    }
    
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    public function momoPayment(Request $request)
    {
        // Các thiết lập cần thiết
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $total_price = Session::get('total_price');
        $amount = $total_price ; // Sửa lại tỉ lệ với đơn vị tiền tệ
        $orderId = time() . "";
        $redirectUrl = "http://127.0.0.1:8000/payment_success"; // Địa chỉ callback khi thanh toán thành công
        $ipnUrl = "http://127.0.0.1:8000/payment"; // Địa chỉ IPN
        $extraData = "";
        $requestId = time() . "";
        $requestType = "captureWallet";

        // Tạo rawHash trước khi mã hóa
        $rawHash = "accessKey={$accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType={$requestType}";
        
        // Tạo chữ ký HMAC SHA256
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        // Chuẩn bị dữ liệu gửi đi
        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
        ];
        
        // Gửi yêu cầu đến MoMo API
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        // Chuyển hướng đến trang thanh toán của MoMo
        if (isset($jsonResult['payUrl'])) {
            return redirect()->to($jsonResult['payUrl']);
        }

        return redirect()->back()->with('error', 'Có lỗi xảy ra trong quá trình tạo yêu cầu thanh toán.');
    }
    public function momoPaymentSuccess(Request $request)
    {
        // Lấy booking_id từ Session
        $booking_id = Session::get('booking_id');

        // Lấy transaction_id từ phản hồi của MoMo
        $transaction_id = $request->orderId; // Mã đơn hàng từ MoMo
        
        // Kiểm tra phản hồi từ MoMo (phản hồi thành công)
        if ($request->resultCode == "0") {
            // Tìm bản ghi thanh toán dựa trên booking_id
            $payment = Payments::where('booking_id', $booking_id)->first();
            
            // Kiểm tra nếu tồn tại bản ghi
            if ($payment) {
                // Cập nhật trạng thái và mã giao dịch
                $payment->update([
                    'transaction_id' => $transaction_id, // Cập nhật mã giao dịch từ MoMo
                    'status' => 'Thành công',            // Cập nhật trạng thái thành công
                ]);
            }

            // Xóa URL khỏi session để tránh lỗi khi truy cập lại
            Session::forget('url_previous');

            // Trả về view thanh toán thành công
            return view('pages.payments.payment_success', [
                'booking_id' => $booking_id,
            ])->with('success', 'Thanh toán thành công!');
        } else {
            // Nếu thanh toán thất bại, chuyển hướng lại và hiển thị thông báo lỗi
            $urlPrevious = Session::get('url_previous', route('payment.show', ['id' => $booking_id]));
            Session::forget('url_previous');
            return redirect($urlPrevious)->with('error', 'Thanh toán thất bại, vui lòng thử lại.');
        }
    }
//admin
public function index()
{
    // Fetch all bookings with related customer, tour, and departure date data
    $bookings = Booking::with(['customer', 'tour', 'departureDate'])->paginate(10); // Use pagination if needed
    return view('admin.bookings.index', compact('bookings'));
}

    public function confirmStatus($id)
    {
        // Find the booking by ID
        $booking = Booking::findOrFail($id);

        // Update the booking status to "Đã xác nhận"
        $booking->update([
            'booking_status' => 'Đã xác nhận',
        ]);
        Mail::to($booking->email)->send(new BookingConfirmed($booking));
        // Return success response (you can modify this for AJAX response as well)
        return response()->json(['success' => 'Booking status updated to Đã xác nhận']);
    }
    public function show($id)
    {
        // Lấy thông tin booking cùng với thông tin khách hàng, tour và thanh toán
        $booking = Booking::with(['customer', 'tour', 'payments'])->findOrFail($id);

        // Trả về view với chi tiết booking
        return view('admin.bookings.show', compact('booking'));
    }
    public function myBookings()
    {
        // Lấy thông tin ID của người dùng từ session
        $customerId = Session::get('customer_id');
    
        // Kiểm tra xem người dùng có đăng nhập không
        if (!$customerId) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem thông tin đặt tour.');
        }
    
        // Lấy danh sách các booking của người dùng
        $bookings = Booking::where('customer_id', $customerId)
            ->with(['tour', 'departureDate','payments']) // Thêm mối quan hệ với departureDate
            ->get();
    
        // Trả về view với danh sách bookings
        return view('pages.booking.my_bookings', compact('bookings'));
    }
    
public function bookingDetail($id)
{
    // Tìm booking dựa trên ID
    $booking = Booking::with(['tour', 'departureDate'])->find($id); // Thêm 'departureDate' vào đây

    // Kiểm tra nếu không tìm thấy booking
    if (!$booking) {
        return redirect()->route('my.bookings')->with('error', 'Không tìm thấy thông tin đặt chỗ.');
    }

    // Trả về view với thông tin chi tiết booking
    return view('pages.booking.booking_detail', compact('booking'));
}

public function cancelBooking($id)
{
    // Tìm booking dựa trên ID
    $booking = Booking::find($id);

    // Kiểm tra nếu không tìm thấy booking
    if (!$booking) {
        return redirect()->route('my.bookings')->with('error', 'Không tìm thấy thông tin đặt chỗ.');
    }

    // Kiểm tra trạng thái của booking
    if ($booking->booking_status == 'Đã xác nhận') {
        // Tăng số ghế trống lại
        $departureDate = DepartureDate::find($booking->departure_date_id);
        if ($departureDate) {
            $departureDate->available_seats += ($booking->adults + $booking->children);
            $departureDate->save();
        }

        // Cập nhật trạng thái booking thành "Đã hủy"
        $booking->booking_status = 'Đã hủy';
        $booking->save();

        // Gửi email xác nhận hủy tour
        Mail::to($booking->email)->send(new CancelBookingConfirmed($booking));

        return redirect()->route('my.bookings')->with('success', 'Tour đã được hủy và email xác nhận đã được gửi.');
    }

    // Nếu booking có trạng thái "Cần được xử lý", cho phép hủy
    if ($booking->booking_status == 'Cần được xử lý') {
        // Tăng số ghế trống lại
        $departureDate = DepartureDate::find($booking->departure_date_id);
        if ($departureDate) {
            $departureDate->available_seats += ($booking->adults + $booking->children);
            $departureDate->save();
        }

        // Cập nhật trạng thái booking thành "Đã hủy"
        $booking->booking_status = 'Đã hủy';
        $booking->save();

        return redirect()->route('my.bookings')->with('success', 'Hủy tour thành công.');
    }

    // Nếu không thể hủy, hiển thị thông báo lỗi
    return redirect()->route('my.bookings')->with('error', 'Không thể hủy tour với trạng thái hiện tại.');
}
public function cancelBookingByAdmin($id)
{
    // Tìm booking dựa trên ID
    $booking = Booking::find($id);

    // Kiểm tra nếu không tìm thấy booking
    if (!$booking) {
        return response()->json(['message' => 'Không tìm thấy thông tin đặt chỗ.'], 404);
    }

    // Tăng số ghế trống lại
    $departureDate = DepartureDate::find($booking->departure_date_id);
    if ($departureDate) {
        $departureDate->available_seats += ($booking->adults + $booking->children);
        $departureDate->save();
    }

    // Cập nhật trạng thái booking thành "Đã hủy"
    $booking->booking_status = 'Đã hủy';
    $booking->save();

    // Gửi email thông báo hủy tour cho khách hàng
    Mail::to($booking->email)->send(new AutocancelConfirmationMail($booking));

    // Trả về thông báo thành công dưới dạng JSON
    return response()->json(['message' => 'Tour đã được hủy và email xác nhận đã được gửi cho khách hàng.']);
}

public function checkout($id)
{
    // Lấy ID khách hàng từ session
    $customerId = Session::get('customer_id');

    // Kiểm tra khách hàng đã đăng nhập
    if (!$customerId) {
        return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để tiếp tục.');
    }

    // Lấy thông tin booking theo ID và thuộc về khách hàng hiện tại
    $booking = Booking::where('id', $id)
        ->where('customer_id', $customerId)
        ->with(['tour', 'departureDate', 'payments', 'customer', 'coupon']) // Thêm 'customer' và 'coupon' để lấy thông tin đầy đủ
        ->first();

    // Kiểm tra nếu booking không tồn tại
    if (!$booking) {
        return redirect()->route('myBookings')->with('error', 'Không tìm thấy thông tin đặt chỗ của bạn.');
    }

    // Kiểm tra nếu không có khách hàng (customer)
    $customer = $booking->customer;
    if (!$customer) {
        return redirect()->route('myBookings')->with('error', 'Không tìm thấy thông tin khách hàng.');
    }

    // Lấy thông tin khách hàng (kiểm tra nếu tồn tại)
    $customerInfo = [
        'name' => $customer->customer_name ?? 'Chưa có tên khách hàng', // Lấy thông tin từ đối tượng customer
        'email' => $customer->customer_email ?? 'Chưa có email khách hàng', // Kiểm tra tồn tại email
        'phone' => $customer->customer_phone ?? 'Chưa có số điện thoại', // Kiểm tra tồn tại số điện thoại
    ];

    // Lấy danh sách các coupon của khách hàng
    $coupons = Coupon::whereHas('customers', function ($query) use ($customerId) {
        $query->where('customer_id', $customerId)
              ->where('coupon_quantity', '>', 0);
    })->get();

    // Kiểm tra nếu không có coupon trong booking
    $couponCode = $booking->coupon ? $booking->coupon->code : null;

    // Chuẩn bị dữ liệu truyền vào view
    $data = [
        'booking' => $booking,
        'tourData' => $booking->tour, // Dữ liệu tour từ booking
        'customerInfo' => $customerInfo,
        'couponCode' => $couponCode,
        'coupons' => $coupons,
    ];

    // Trả về view thanh toán
    return view('pages.checkout.checkout', $data);
}





public function destroy($id)
{
    $bookingModel = new Booking();

    // Gọi hàm deleteBooking để xóa booking
    if ($bookingModel->deleteBooking($id)) {
        return redirect()->route('bookings.index')->with('success', 'Booking đã được xóa thành công.');
    } else {
        return redirect()->route('bookings.index')->with('error', 'Không tìm thấy booking để xóa.');
    }
}



}





            
            
    
    

    

    

    

