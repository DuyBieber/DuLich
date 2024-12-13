<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccess;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Password;
class CustomerController extends Controller
{
    // Hiển thị danh sách khách hàng
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customers.index', compact('customers'));
    }

    // Hiển thị form thêm khách hàng
    public function create()
    {
        return view('customers.create'); // Đường dẫn tới view thêm khách hàng
    }

    // Lưu khách hàng mới
   

    // Hiển thị form chỉnh sửa khách hàng
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer')); // Đường dẫn tới view chỉnh sửa khách hàng
    }

    // Cập nhật thông tin khách hàng
    public function update(Request $request, $id)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|string|email|max:255|unique:customers,customer_email,' . $id,
            'customer_phone' => 'required|string|max:15',
            'customer_address' => 'required|string|max:255',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->customer_name = $request->customer_name;
        $customer->customer_email = $request->customer_email;
        $customer->customer_phone = $request->customer_phone;
        $customer->customer_address = $request->customer_address;

        // Nếu mật khẩu được nhập thì mã hóa và cập nhật
        if ($request->filled('customer_password')) {
            $customer->customer_password = md5($request->customer_password);
        }

        $customer->save();

        // Chuyển hướng về danh sách khách hàng
        return redirect()->route('customers.index')->with('message', 'Thông tin khách hàng đã được cập nhật thành công!');
    }

    // Xóa khách hàng
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('message', 'Khách hàng đã được xóa thành công!');
    }

    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('pages.customers.register');
    }

    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('pages.customers.login');
    }

    // Hàm đăng ký (store)
    public function store(Request $request)
{
    // Validate dữ liệu đầu vào
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|string|email|max:255|unique:customers', 
        'customer_password' => [
            'required',
            'string',
            'min:6', // Tối thiểu 8 ký tự
            'regex:/[A-Z]/', // Ít nhất một chữ cái in hoa
            'regex:/[a-z]/', // Ít nhất một chữ cái thường
            'regex:/[0-9]/', // Ít nhất một chữ số
            'regex:/[@$!%*?&+]/', // Ít nhất một ký tự đặc biệt
            'confirmed', // Xác nhận mật khẩu
        ],
        'customer_phone' => [
            'required',
            'string',
            'max:10',
            'regex:/^0[0-9]{9}$/' 
        ],
        'customer_address' => 'required|string|max:255',
    ], [
        'customer_name.unique'=>'Tên này đã được đăng ký. Vui lòng sử dụng tên khác. ',
        'customer_email.unique' => 'Email này đã được đăng ký. Vui lòng sử dụng email khác.',
        'customer_phone.unique' => 'Số điện thoại này đã được đăng ký. Vui lòng sử dụng số khác.',
        'customer_password.regex' => 'Mật khẩu phải có ít nhất một chữ cái in hoa, một chữ cái thường, một số và một ký tự đặc biệt.',
        'customer_phone.regex' => 'Số điện thoại phải bắt đầu bằng 0 và có 10 ký tự.',
    ]);

    // Tạo mới khách hàng và mã hóa mật khẩu bằng MD5
    $customer = Customer::create([
        'customer_name' => $request->customer_name,
        'customer_email' => $request->customer_email,
        'customer_password' => md5($request->customer_password),
        'customer_phone' => $request->customer_phone,
        'customer_address' => $request->customer_address,
    ]);
    
    // Gửi email thông báo thành công
    Mail::to($customer->customer_email)->send(new RegistrationSuccess($customer));
    
    // Lưu thông tin khách hàng vào session
    Session::put('customer_id', $customer->id);
    Session::put('customer_name', $customer->customer_name);

    // Chuyển hướng về trang chủ
    return redirect()->route('home')->with('message', 'Đăng ký thành công!');
}


    // Hàm đăng nhập
    public function login(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'customer_email' => 'required|email',
            'customer_password' => 'required',
        ]);

        // Tìm khách hàng theo email và mật khẩu mã hóa MD5
        $customer = Customer::where('customer_email', $request->customer_email)
            ->where('customer_password', md5($request->customer_password))
            ->first();

        // Kiểm tra nếu đăng nhập thành công
        if ($customer) {
            // Lưu thông tin vào session
            Session::put('customer_id', $customer->id);
            Session::put('customer_name', $customer->customer_name);

            // Chuyển hướng về trang chủ
            return redirect()->route('home')->with('message', 'Đăng nhập thành công!');
        } else {
            // Thông tin đăng nhập không chính xác
            return redirect()->back()->with('error', 'Email hoặc mật khẩu không chính xác');
        }
    }

    // Hàm đăng xuất
    public function logout(Request $request)
    {
        // Xóa thông tin trong session
        Session::forget('customer_id');
        Session::forget('customer_name');

        // Chuyển hướng về trang chủ
        return redirect()->route('home')->with('message', 'Đăng xuất thành công');
    }
    public function showForgotPasswordForm()
{
    return view('pages.customers.forgot-password');
}
public function sendResetLink(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:customers,customer_email',
    ]);

    $email = $request->email;

    // Tạo token và lưu vào session
    $token = md5(uniqid(rand(), true));
    session()->put('password_reset_token', [
        'email' => $email,
        'token' => $token,
        'expires_at' => now()->addMinutes(30), // Token hết hạn sau 30 phút
    ]);

    $resetLink = route('customer.resetPasswordForm', ['token' => $token]);

    // Gửi email (cần tạo mail class PasswordResetMail)
    Mail::to($email)->send(new PasswordResetMail($resetLink));

    return back()->with('message', 'Liên kết đặt lại mật khẩu đã được gửi tới email của bạn!');
}
public function resetPassword($token)
{
    $passwordReset = session()->get('password_reset_token');

    if (!$passwordReset || $passwordReset['token'] !== $token || now()->greaterThan($passwordReset['expires_at'])) {
        return redirect()->route('customer.forgotPasswordForm')->withErrors('Token không hợp lệ hoặc đã hết hạn.');
    }

    // Nếu hợp lệ, hiển thị form đặt lại mật khẩu
    return view('pages.customers.reset-password', ['email' => $passwordReset['email']]);
}

public function showResetPasswordForm($token)
{
    return view('pages.customers.reset-password', compact('token'));
}
public function saveNewPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
    ]);

    // Cập nhật mật khẩu
    Customer::where('customer_email', $request->email)->update([
        'customer_password' => md5($request->password), // Mã hóa bằng MD5
    ]);

    // Xóa token trong session
    session()->forget('password_reset_token');

    return redirect()->route('login')->with('message', 'Mật khẩu của bạn đã được thay đổi thành công!');
}


    public function showProfile()
{
    // Kiểm tra nếu khách hàng đã đăng nhập
    if (!Session::has('customer_id')) {
        return redirect()->route('customer.login')->with('error', 'Bạn cần đăng nhập để xem trang cá nhân.');
    }

    // Lấy thông tin khách hàng từ session
    $customer = Customer::findOrFail(Session::get('customer_id'));

    return view('pages.customers.profile', compact('customer'));
}
public function editProfile()
{
    // Kiểm tra nếu khách hàng đã đăng nhập
    if (!Session::has('customer_id')) {
        return redirect()->route('customer.login')->with('error', 'Bạn cần đăng nhập để chỉnh sửa thông tin cá nhân.');
    }

    // Lấy thông tin khách hàng từ session
    $customer = Customer::findOrFail(Session::get('customer_id'));

    return view('pages.customers.edit-profile', compact('customer'));
}

// Cập nhật thông tin cá nhân
public function updateProfile(Request $request)
{
    // Kiểm tra nếu khách hàng đã đăng nhập
    if (!Session::has('customer_id')) {
        return redirect()->route('customer.login')->with('error', 'Bạn cần đăng nhập để cập nhật thông tin cá nhân.');
    }

    // Validate dữ liệu đầu vào
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|string|email|max:255|unique:customers,customer_email,' . Session::get('customer_id'),
        'customer_phone' => 'required|string|max:15',
        'customer_address' => 'required|string|max:255',
        'current_password' => 'required_with:customer_password', // Yêu cầu nhập mật khẩu hiện tại khi có mật khẩu mới
    ]);

    $customer = Customer::findOrFail(Session::get('customer_id'));

    // Nếu có yêu cầu đổi mật khẩu, kiểm tra mật khẩu hiện tại
    if ($request->filled('customer_password')) {
        if (md5($request->current_password) !== $customer->customer_password) {
            return redirect()->back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        // Mã hóa mật khẩu mới và lưu vào database
        $customer->customer_password = md5($request->customer_password);
    }

    // Cập nhật các thông tin khác
    $customer->customer_name = $request->customer_name;
    $customer->customer_email = $request->customer_email;
    $customer->customer_phone = $request->customer_phone;
    $customer->customer_address = $request->customer_address;

    $customer->save();

    return redirect()->route('customer.profile')->with('message', 'Cập nhật thông tin cá nhân thành công!');
}
public function showCouponsForCustomer()
{
    $coupons = Coupon::where('coupon_quantity', '>', 0)->orderBy('id', 'DESC')->get();
    return view('pages.coupons.show_coupons', compact('coupons'));
}
public function showWallet()
{
    // Lấy ID của customer từ session
    $customerId = Session::get('customer_id');

    // Kiểm tra xem có ID customer không
    if (!$customerId) {
        return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem ví coupon.');
    }

    // Tìm customer theo ID
    $customer = Customer::find($customerId);

    // Kiểm tra xem có tồn tại customer không
    if (!$customer) {
        return redirect()->route('home')->with('error', 'Không tìm thấy tài khoản của bạn.');
    }

    // Lấy danh sách các mã giảm giá của customer
    $coupons = $customer->coupons()->withPivot('assigned_at', 'is_redeemed')->get();

    // Lấy danh sách mã giảm giá từ session
    $sessionCoupons = Session::get('customer_coupons', []);

    return view('pages.customers.wallet', compact('coupons', 'sessionCoupons'));
}


public function redeemCoupon($couponId)
{
    $customerId = Session::get('customer_id');

    // Kiểm tra nếu không có customerId trong session
    if (!$customerId) {
        return response()->json(['success' => false, 'message' => 'Bạn cần đăng nhập để sử dụng mã giảm giá.']);
    }

    // Tìm mã giảm giá chưa sử dụng của khách hàng
    $coupon = Coupon::whereHas('customers', function ($query) use ($customerId, $couponId) {
        $query->where('customer_id', $customerId)
              ->where('coupon_id', $couponId)
              ->where('is_redeemed', false); // Mã giảm giá chưa được sử dụng
    })->first();

    if ($coupon) {
        // Đánh dấu mã giảm giá là đã sử dụng
        $coupon->customers()->updateExistingPivot($customerId, ['is_redeemed' => true]);

        // Giảm số lượng mã giảm giá
        $coupon->coupon_quantity -= 1;
        $coupon->save();

        return response()->json(['success' => true, 'message' => 'Bạn đã sử dụng mã giảm giá thành công.']);
    }

    return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ hoặc đã được sử dụng.']);
}


public function deleteCoupon($id)
{
    try {
        $customerId = Session::get('customer_id');
        
        // Xóa mã giảm giá khỏi bảng liên kết nếu mã thuộc về khách hàng
        DB::table('coupon_customer')
            ->where('customer_id', $customerId)
            ->where('coupon_id', $id)
            ->delete();
        
        // Cập nhật session để xóa mã giảm giá đã xóa
        $customerCoupons = Session::get('customer_coupons', []);
        
        $updatedCoupons = collect($customerCoupons)->filter(function ($coupon) use ($id) {
            return $coupon['id'] != $id;
        })->values()->toArray();

        Session::put('customer_coupons', $updatedCoupons);

        return response()->json(['success' => true, 'message' => 'Mã giảm giá đã được xóa khỏi ví.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra khi xóa mã giảm giá: ' . $e->getMessage()]);
    }
}








}
