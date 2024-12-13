<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourPriceDetail; // Model giá tour
use App\Models\Tour; // Model tour
use App\Models\DepartureDate; // Model ngày khởi hành
use Illuminate\Support\Facades\Validator;

class TourPriceDetailController extends Controller
{
    // Hiển thị danh sách giá tour
    public function index()
    {
        $priceDetails = TourPriceDetail::with('tour', 'departureDate')->orderBy('id', 'DESC')->get();
        return view('admin.tour_price_details.index', compact('priceDetails'));
    }

    // Hiển thị form tạo mới giá tour
    public function create()
    {
        $tours = Tour::all();
        
        // Lọc các lịch khởi hành chưa có giá chi tiết
        $departureDates = DepartureDate::whereDoesntHave('priceDetails')->get();
    
        return view('admin.tour_price_details.create', compact('tours', 'departureDates'));
    }
    

    // Lưu giá tour mới
    public function store(Request $request)
{
    $data = Validator::make($request->all(), [
        'tour_id' => 'required',
        'departure_date_id' => 'required', // Đã thêm validation
        'adult_price' => 'required|numeric',
        'child_price' => 'required|numeric',
        'infant_price' => 'required|numeric',
        'baby_price' => 'required|numeric',
        'foreign_surcharge' => 'nullable|numeric',
        'single_room_surcharge' => 'nullable|numeric',
    ]);

    if ($data->fails()) {
        return redirect()->back()
            ->withErrors($data)
            ->withInput();
    }

    $validatedData = $data->validated();

    // Logic lưu giá tour kèm ngày khởi hành
    TourPriceDetail::create($validatedData);

    return redirect()->route('tour_price_details.index')->with('success', 'Thêm giá tour thành công!');
}
    // Hiển thị form chỉnh sửa giá tour
    public function edit(string $id)
{
    $priceDetail = TourPriceDetail::with('tour', 'departureDate')->findOrFail($id);
    $tours = Tour::orderBy('id', 'DESC')->get();
    // Lấy danh sách ngày khởi hành chỉ cho tour đã chọn
    $departureDates = DepartureDate::where('tour_id', $priceDetail->tour_id)->orderBy('departure_date', 'ASC')->get();
    
    return view('admin.tour_price_details.edit', compact('priceDetail', 'tours', 'departureDates'));
}

    // Cập nhật giá tour
    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'departure_date_id' => 'required|exists:departure_dates,id',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'required|numeric|min:0',
            'infant_price' => 'nullable|numeric|min:0',
            'baby_price' => 'nullable|numeric|min:0',
            'foreign_surcharge' => 'nullable|numeric|min:0',
            'single_room_surcharge' => 'nullable|numeric|min:0',
        ], [
            'tour_id.required' => 'Vui lòng chọn tour.',
            'tour_id.exists' => 'Tour không tồn tại.',
            'departure_date_id.required' => 'Vui lòng chọn ngày khởi hành.',
            'departure_date_id.exists' => 'Ngày khởi hành không tồn tại.',
            'adult_price.required' => 'Vui lòng nhập giá cho người lớn.',
            'adult_price.numeric' => 'Giá người lớn phải là số.',
            'adult_price.min' => 'Giá người lớn phải lớn hơn hoặc bằng 0.',
            'child_price.required' => 'Vui lòng nhập giá cho trẻ em.',
            'child_price.numeric' => 'Giá trẻ em phải là số.',
            'child_price.min' => 'Giá trẻ em phải lớn hơn hoặc bằng 0.',
            'infant_price.numeric' => 'Giá em bé phải là số.',
            'infant_price.min' => 'Giá em bé phải lớn hơn hoặc bằng 0.',
            'baby_price.numeric' => 'Giá em bé nhỏ phải là số.',
            'baby_price.min' => 'Giá em bé nhỏ phải lớn hơn hoặc bằng 0.',
            'foreign_surcharge.numeric' => 'Phụ phí khách nước ngoài phải là số.',
            'foreign_surcharge.min' => 'Phụ phí khách nước ngoài phải lớn hơn hoặc bằng 0.',
            'single_room_surcharge.numeric' => 'Phụ phí phòng đơn phải là số.',
            'single_room_surcharge.min' => 'Phụ phí phòng đơn phải lớn hơn hoặc bằng 0.',
        ]);

        // Tìm giá tour theo ID
        $priceDetail = TourPriceDetail::findOrFail($id);

        // Cập nhật thông tin giá tour
        $priceDetail->update([
            'tour_id' => $request->input('tour_id'),
            'departure_date_id' => $request->input('departure_date_id'),
            'adult_price' => $request->input('adult_price'),
            'child_price' => $request->input('child_price'),
            'infant_price' => $request->input('infant_price'),
            'baby_price' => $request->input('baby_price'),
            'foreign_surcharge' => $request->input('foreign_surcharge'),
            'single_room_surcharge' => $request->input('single_room_surcharge'),
        ]);

        // Chuyển hướng và thông báo thành công
        return redirect()->route('tour_price_details.index')->with('success', 'Cập nhật giá tour thành công!');
    }



    // Xóa giá tour
    public function destroy(string $id)
    {
        $priceDetail = TourPriceDetail::find($id);
        $priceDetail->delete();
        return redirect()->route('tour_price_details.index')->with('success', 'Xóa giá tour thành công!');
    }
}
