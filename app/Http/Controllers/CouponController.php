<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Coupon;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'DESC')->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $data = Validator::make($request->all(), [
            'coupon_name' => 'required|max:255',
            'coupon_code' => 'required|unique:coupons|max:255',
            'coupon_quantity' => 'required|integer|min:1', // Số lượng phải lớn hơn 0
            'coupon_number' => 'required|integer|min:1|max:100', // Phần trăm giảm phải từ 1 đến 100
        ], [
            'coupon_name.required' => 'Yêu cầu nhập tên coupon',
            'coupon_code.required' => 'Yêu cầu nhập mã coupon',
            'coupon_code.unique' => 'Mã coupon đã tồn tại.',
            'coupon_quantity.required' => 'Yêu cầu nhập số lượng mã',
            'coupon_quantity.integer' => 'Số lượng mã phải là số nguyên.',
            'coupon_quantity.min' => 'Số lượng mã phải lớn hơn 0.',
            'coupon_number.required' => 'Yêu cầu nhập % giảm coupon',
            'coupon_number.integer' => 'Phần trăm giảm phải là số nguyên.',
            'coupon_number.min' => 'Phần trăm giảm phải lớn hơn 0.',
            'coupon_number.max' => 'Phần trăm giảm không được vượt quá 100.',
        ]);
    
        if ($data->fails()) {
            return redirect()->back()
                ->withErrors($data)
                ->withInput();
        }
    
        // Lấy dữ liệu đã xác thực
        $validatedData = $data->validated();
    
        // Logic lưu dữ liệu
        $coupon = new Coupon();
        $coupon->coupon_name = $validatedData['coupon_name'];
        $coupon->coupon_code = $validatedData['coupon_code'];
        $coupon->coupon_quantity = $validatedData['coupon_quantity'];
        $coupon->coupon_number = $validatedData['coupon_number'];
        
        $coupon->save(); // Lưu mô hình vào cơ sở dữ liệu
    
        return redirect()->route('coupons.index')->with('success', 'Thêm coupon thành công!');
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate input data
        $data = Validator::make($request->all(), [
            'coupon_name' => 'required|max:255',
            'coupon_code' => 'required|unique:coupons,coupon_code,'.$id.'|max:255',
            'coupon_number' => 'required|integer',
            'coupon_quantity' => 'required|integer',
            
        ], [
            'coupon_name.required' => 'Yêu cầu nhập tên coupon',
            'coupon_code.required' => 'Yêu cầu nhập mã coupon',
            'coupon_quantity.required' => 'Yêu cầu nhập số lượng mã',
            'coupon_number.required' => 'Yêu cầu nhập % giảm',
            
        ]);

        if ($data->fails()) {
            return redirect()->back()
                ->withErrors($data)
                ->withInput();
        }

        // Get validated data
        $validatedData = $data->validated();

        // Find existing coupon
        $coupon = Coupon::findOrFail($id);
        $coupon->coupon_name = $validatedData['coupon_name'];
        $coupon->coupon_code = $validatedData['coupon_code'];
        $coupon->coupon_quantity = $validatedData['coupon_quantity'];
        $coupon->coupon_number = $validatedData['coupon_number'];
        $coupon->save(); // Save the model to the database

        return redirect()->route('coupons.index')->with('success', 'Cập nhật coupon thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Xóa coupon thành công!');
    }
    public function checkCoupon(Request $request)
{
    $couponCode = $request->input('code');
    $customerId = Session::get('customer_id'); // Lấy ID khách hàng từ session

    // Tìm mã giảm giá trong cơ sở dữ liệu
    $coupon = Coupon::where('coupon_code', $couponCode)->first();

    // Kiểm tra tính hợp lệ của mã
    if ($coupon) {
        // Kiểm tra xem mã đã được khách hàng sử dụng chưa (chưa đánh dấu đã sử dụng)
        $hasUsedCoupon = DB::table('coupon_customer')
            ->where('customer_id', $customerId)
            ->where('coupon_id', $coupon->id)
            ->where('is_redeemed', true) // Kiểm tra đã được sử dụng hay chưa
            ->exists();

        // Nếu đã sử dụng
        if ($hasUsedCoupon) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã sử dụng mã giảm giá này trước đó.',
            ]);
        }

        // Trả lại phần trăm giảm giá mà không giảm số lượng hoặc đánh dấu đã sử dụng
        return response()->json([
            'success' => true,
            'discount' => $coupon->coupon_number, // Phần trăm giảm giá
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Mã giảm giá không hợp lệ.',
    ]);
}

    
    
    
    

    

public function assignCouponToCustomer(Request $request, $couponId)
{
    $customerId = Session::get('customer_id');
    $coupon = Coupon::find($couponId);

    if (!$coupon) {
        return response()->json(['success' => false, 'message' => 'Mã giảm giá không tồn tại.']);
    }

    if ($coupon->coupon_quantity <= 0) {
        return response()->json(['success' => false, 'message' => 'Mã giảm giá đã hết.']);
    }

    $customer = Customer::findOrFail($customerId);

    if ($customer->coupons->contains($coupon->id)) {
        return response()->json(['success' => false, 'message' => 'Bạn đã sở hữu mã giảm giá này.']);
    }

    $customer->coupons()->attach($coupon->id, [
        'assigned_at' => now(),
        'is_redeemed' => false
    ]);

    $coupon->coupon_quantity -= 1;
    $coupon->save();

    return response()->json(['success' => true, 'message' => 'Thêm coupon vào ví thành công!']);
}


}
