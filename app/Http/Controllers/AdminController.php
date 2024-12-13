<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Exports\BookingsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMailAdmin;
use App\Models\Booking;
use App\Models\Admin;
session_start();
class AdminController extends Controller
{
    public function admin_login(){
        return view('admin.admin_login');
    }
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return true; // Người dùng đã đăng nhập
        } else {
            return false; // Người dùng chưa đăng nhập
        }
    }
   
    
    public function showProfileAdmin(){
        if (!Session::has('admin_id')) {
            return redirect()->route('admin_login')->with('error', 'Bạn cần đăng nhập để xem trang cá nhân.');
        }
        $admin = Admin::findOrFail(Session::get('admin_id'));
        return view('admin.profile.profileadmin', compact('admin'));
    }
    public function editProfileAdmin()
{
    // Kiểm tra nếu khách hàng đã đăng nhập
    if (!Session::has('admin_id')) {
        return redirect()->route('admin_login')->with('error', 'Bạn cần đăng nhập để chỉnh sửa thông tin cá nhân.');
    }

    // Lấy thông tin khách hàng từ session
    $admin = Admin::findOrFail(Session::get('admin_id'));
    Session::put('admin_id', $admin->admin_id);

    return view('admin.profile.edit-profile-admin', compact('admin'));
}
public function updateProfileAdmin(Request $request)
{
    // Kiểm tra nếu admin đã đăng nhập
    if (!Session::has('admin_id')) {
        return redirect()->route('admin_login')->with('error', 'Bạn cần đăng nhập để cập nhật thông tin cá nhân.');
    }

    // Validate dữ liệu đầu vào
    $request->validate([
        'admin_name' => 'required|string|max:255',
        'admin_email' => 'required|string|email|max:255|unique:tbl_admin,admin_email,' . Session::get('admin_id') . ',admin_id', // Thay 'id' thành 'admin_id'
        'admin_phone' => 'required|string|max:15',
        'admin_chucvu' => 'required|string|max:255',
        'current_password' => 'required_with:admin_password', // Yêu cầu nhập mật khẩu hiện tại khi có mật khẩu mới
    ]);

    $admin = Admin::findOrFail(Session::get('admin_id'));

    // Nếu có yêu cầu đổi mật khẩu, kiểm tra mật khẩu hiện tại
    if ($request->filled('admin_password')) {
        if (md5($request->current_password) !== $admin->admin_password) {
            return redirect()->back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        // Mã hóa mật khẩu mới và lưu vào database
        $admin->admin_password = md5($request->admin_password);
    }

    // Cập nhật các thông tin khác
    $admin->admin_name = $request->admin_name;
    $admin->admin_email = $request->admin_email;
    $admin->admin_phone = $request->admin_phone;
    $admin->admin_chucvu = $request->admin_chucvu;

    $admin->save();

    return redirect()->route('profile_admin')->with('message', 'Cập nhật thông tin cá nhân thành công!');
}

    public function showdashboard()
{
    if ($this->AuthLogin()) {
        // Thống kê tổng số booking và khách hàng
        $totalBookedTours = Booking::count();
        $totalCustomers = \App\Models\Customer::count();
        $tours = \App\Models\Tour::with('departureDates')->get(); 

        // Lấy các booking cần xử lý
        $pendingBookings = Booking::where('booking_status', 'Cần được xử lý')
            ->with('tour', 'customer')
            ->get();
            $pendingConfirmationBookings = Booking::whereIn('booking_status', ['Cần được xử lý', 'Đã xác nhận'])
            ->with('tour', 'customer', 'payments') // Tải các quan hệ cần thiết
            ->get();
        
        $overdueBookings = []; // Mảng lưu các booking quá hạn thanh toán
        
        foreach ($pendingConfirmationBookings as $booking) {
            foreach ($booking->payments as $payment) {
                $paymentDeadline = $payment->created_at->addDays(7); // Thêm 7 ngày vào ngày thanh toán
                
                // Kiểm tra nếu đã quá hạn và trạng thái chưa thanh toán
                if ($paymentDeadline->isPast() && $payment->status !== 'Đã thanh toán') {
                    $overdueBookings[] = $booking; // Thêm booking vào danh sách quá hạn
                    break; // Không cần kiểm tra các payment khác
                }
            }
        }
        
        // $overdueBookings chứa tất cả các booking quá hạn
        
    


        // Doanh thu theo tháng trong năm hiện tại
        $currentYear = Carbon::now()->year;
        $monthlyRevenue = Booking::selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->whereYear('created_at', $currentYear)
            ->where('booking_status', 'Đã xác nhận')
            ->groupBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        $monthlyRevenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyRevenueData[] = $monthlyRevenue[$i] ?? 0;
        }

        // Lấy dữ liệu bình luận
        $reviews = \App\Models\Review::with('customer', 'tour')->get();

        // Thống kê số booking theo ngày trong tháng hiện tại
        $dailyBookingStats = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as bookings_count')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->date => $item->bookings_count];
            })
            ->toArray();

        // Thống kê số booking trong ngày hôm nay
        $today = Carbon::today();
        $todayBookingsCount = Booking::whereDate('created_at', $today)->count();
        $todayBookings = Booking::with(['customer', 'tour', 'payments'])
            ->whereDate('created_at', $today)
            ->get();
        $groupedBookings = $todayBookings->groupBy('tour_id');

        return view('admin.home.home_admin', [
            'totalBookedTours' => $totalBookedTours,
            'totalCustomers' => $totalCustomers,
            'tours' => $tours,
            'pendingBookings' => $pendingBookings,
            'reviews' => $reviews,
            'monthlyRevenueData' => $monthlyRevenueData,
            'todayBookingsCount' => $todayBookingsCount,
            'todayBookings' => $todayBookings,
            'groupedBookings' => $groupedBookings,
            'pendingConfirmationBookings' => $pendingConfirmationBookings,
            'dailyBookingStats' => $dailyBookingStats, // Truyền thống kê booking theo ngày
            'overdueBookings' => $overdueBookings, // Thêm danh sách booking quá hạn
        ]);
    } else {
        return $this->admin_login();
    }
}


public function getBookingsByDate(Request $request)
{
    $date = $request->input('date', Carbon::today()->toDateString());
    $todayBookingsCount = Booking::whereDate('created_at', $date)->count();
    $todayBookings = Booking::with(['customer', 'tour', 'payments'])
        ->whereDate('created_at', $date)
        ->get();
    $groupedBookings = $todayBookings->groupBy('tour_id');

    // Render lại bảng booking
    $html = view('admin.bookings.booking_table', compact('groupedBookings'))->render();

    return response()->json([
        'todayBookingsCount' => $todayBookingsCount,
        'html' => $html,
    ]);
}
public function exportBookings(Request $request)
{
    $date = $request->input('date', Carbon::today()->toDateString());
    $fileName = 'bookings_' . $date . '.xlsx';

    return Excel::download(new BookingsExport($date), $fileName);
}

    public function dashboard(Request $request){
        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);

        // Lấy thông tin admin từ database
        $admin = DB::table('tbl_admin')
            ->where('admin_email', $admin_email)
            ->where('admin_password', $admin_password)
            ->first();

    
            if ($admin) {
                // Xác thực thành công
                Session::put('admin_name',$admin->admin_name);
                Session::put('admin_id',$admin->admin_id);
                return redirect()->route('admin_dashboard');
            } else {
                // Xác thực thất bại
                return redirect()->back()->with('error', 'Email hoặc mật khẩu không chính xác');
            }
    }
    public function logoutdashboard(){
        Session::put('admin_name',null);
                Session::put('admin_id',null);
        return view('admin.admin_login');
    }
    public function getStatistics()
{
    $totalBookedTours = Booking::count(); // Giả sử mỗi booking là một lần đặt tour
    $totalCustomers = \App\Models\Customer::count();

    return response()->json([
        'totalBookedTours' => $totalBookedTours,
        'totalCustomers' => $totalCustomers
    ]);
}
public function showForgotPasswordFormAdmin()
{
    return view('pages.admin.forgot-password-admin');
}
public function sendResetLinkAdmin(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:tbl_admin,admin_email',
    ]);

    $email = $request->email;

    // Tạo token và lưu vào session
    $token = md5(uniqid(rand(), true));
    session()->put('password_reset_token', [
        'email' => $email,
        'token' => $token,
        'expires_at' => now()->addMinutes(30), // Token hết hạn sau 30 phút
    ]);

    $resetLink = route('admin.resetPasswordForm', ['token' => $token]);

    // Gửi email (cần tạo mail class PasswordResetMail)
    Mail::to($email)->send(new PasswordResetMailAdmin($resetLink));

    return back()->with('message', 'Liên kết đặt lại mật khẩu đã được gửi tới email của bạn!');
}
public function resetPasswordAdmin($token)
{
    $passwordReset = session()->get('password_reset_token');

    if (!$passwordReset || $passwordReset['token'] !== $token || now()->greaterThan($passwordReset['expires_at'])) {
        return redirect()->route('admin.forgotPasswordForm')->withErrors('Token không hợp lệ hoặc đã hết hạn.');
    }

    // Nếu hợp lệ, hiển thị form đặt lại mật khẩu
    return view('pages.admin.reset-password-admin', ['email' => $passwordReset['email']]);
}
public function showResetPasswordFormAdmin($token)
{
    return view('pages.admin.reset-password-admin', compact('token'));
}
public function saveNewPasswordAdmin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
    ]);

    // Cập nhật mật khẩu
    Admin::where('admin_email', $request->email)->update([
        'admin_password' => md5($request->password), // Mã hóa bằng MD5
    ]);

    // Xóa token trong session
    session()->forget('password_reset_token');

    return redirect()->route('login_admin')->with('message', 'Mật khẩu của bạn đã được thay đổi thành công!');
}

}
