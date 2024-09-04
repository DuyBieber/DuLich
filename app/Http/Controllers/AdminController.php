<?php

namespace App\Http\Controllers;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
    public function showdashboard(){
        if ($this->AuthLogin()) {
            return view('admin.home.home_admin'); // Trả về trang dashboard nếu đã đăng nhập
        } else {
            return $this->admin_login(); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
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
}
