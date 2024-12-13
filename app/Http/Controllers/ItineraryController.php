<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Tour;
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    // Hiển thị danh sách lịch trình
    public function index()
    {
        $itineraries = Itinerary::with('tour')->get();
        return view('admin.itineraries.index', compact('itineraries'));
    }

    // Hiển thị form tạo lịch trình mới
    public function create()
    {
        $tours = Tour::all(); // Lấy danh sách tour để hiển thị trong form
        return view('admin.itineraries.create', compact('tours'));
    }

    // Lưu lịch trình mới
    public function store(Request $request)
{
    // Validation dữ liệu đầu vào
    $request->validate([
        'tour_id' => 'required|exists:tours,id',
        'day' => 'required|integer|min:1',
        'location' => 'required|string',
        'activity_description' => 'required|string',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'img' => 'nullable|image'  // Thay đổi điều kiện validate cho trường img
    ]);

    // Khởi tạo tên hình ảnh
    $new_image = null;

    // Xử lý hình ảnh nếu có
    if ($request->hasFile('img')) {
        $get_image = $request->file('img');
        $path = 'public/uploads/itineraries/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.', $get_name_image));
        $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
        $get_image->move($path, $new_image);
    }

    // Tạo mới lịch trình với hoặc không có hình ảnh
    Itinerary::create([
        'tour_id' => $request->tour_id,
        'day' => $request->day,
        'location' => $request->location,
        'activity_description' => $request->activity_description,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'img' => $new_image  // Lưu tên ảnh vào cơ sở dữ liệu hoặc để null nếu không có hình
    ]);

    return redirect()->route('itineraries.index')->with('success', 'Thêm lịch trình thành công.');
}


    // Hiển thị form chỉnh sửa lịch trình
    public function edit(Itinerary $itinerary)
    {
        $tours = Tour::all(); // Lấy danh sách tour để hiển thị trong form
        return view('admin.itineraries.edit', compact('itinerary', 'tours'));
    }

    // Cập nhật lịch trình
    public function update(Request $request, Itinerary $itinerary)
{
    // Validation dữ liệu đầu vào
    $request->validate([
        'tour_id' => 'required|exists:tours,id',
        'day' => 'required|integer|min:1',
        'location' => 'required|string',
        'activity_description' => 'required|string',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'img' => 'nullable|image'  // Chỉ yêu cầu khi người dùng muốn cập nhật hình ảnh
    ]);

    // Nếu người dùng cập nhật ảnh mới
    if ($request->hasFile('img')) {
        $get_image = $request->file('img');
        $path = 'public/uploads/itineraries/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.', $get_name_image));
        $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
        $get_image->move($path, $new_image);

        // Xóa ảnh cũ nếu có (nếu cần thiết)
        if ($itinerary->img) {
            // Kiểm tra nếu file ảnh tồn tại
            $old_image_path = public_path('uploads/itineraries/' . $itinerary->img);
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }

        // Cập nhật ảnh mới
        $itinerary->img = $new_image;
    }

    // Cập nhật các trường khác
    $itinerary->update([
        'tour_id' => $request->tour_id,
        'day' => $request->day,
        'location' => $request->location,
        'activity_description' => $request->activity_description,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
    ]);

    return redirect()->route('itineraries.index')->with('success', 'Cập nhật lịch trình thành công.');
}


    // Xóa lịch trình
    public function destroy(Itinerary $itinerary)
    {
        $itinerary->delete();
        return redirect()->route('itineraries.index')->with('success', 'Xóa lịch trình thành công.');
    }
}
   
