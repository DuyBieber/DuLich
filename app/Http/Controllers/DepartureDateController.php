<?php

namespace App\Http\Controllers;

use App\Models\DepartureDate;
use App\Models\Tour;
use App\Models\TourPriceDetail;
use Illuminate\Http\Request;

class DepartureDateController extends Controller
{
    // Hiển thị danh sách các ngày khởi hình
    public function index()
    {
        $departureDates = DepartureDate::with('tour')->get();
        return view('admin.departure-dates.index', compact('departureDates'));
    }

    // Hiển thị form tạo mới ngày khởi hình
    public function create()
    {
        $tours = Tour::all(); // Lấy tất cả các tour
        return view('admin.departure-dates.create', compact('tours'));
    }

    // Lưu ngày khởi hình mới
    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'departure_date' => 'required|date',
            'feature' => 'nullable|string',
            'price' => 'required|numeric',
            'available_seats' => 'required|integer',
        ]);

        DepartureDate::create($request->all());
        return redirect()->route('departure-dates.index')->with('success', 'Ngày khởi hình đã được tạo thành công!');
    }

    // Hiển thị form chỉnh sửa ngày khởi hình
    public function edit(DepartureDate $departureDate)
    {
        $tours = Tour::all(); // Lấy tất cả các tour
        return view('admin.departure-dates.edit', compact('departureDate', 'tours'));
    }

    // Cập nhật ngày khởi hình
    public function update(Request $request, DepartureDate $departureDate)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'departure_date' => 'required|date',
            'feature' => 'nullable|string',
            'price' => 'required|numeric',
            'available_seats' => 'required|integer',
        ]);

        $departureDate->update($request->all());
        return redirect()->route('departure-dates.index')->with('success', 'Ngày khởi hình đã được cập nhật thành công!');
    }

    // Xóa ngày khởi hình
    public function destroy(DepartureDate $departureDate)
    {
        $departureDate->delete();
        return redirect()->route('departure-dates.index')->with('success', 'Ngày khởi hình đã được xóa thành công!');
    }
    public function getDepartureDates($tourId)
{
    $departureDates = DepartureDate::where('tour_id', $tourId)->get();
    return response()->json($departureDates);
}
// Controller
public function getPriceDetails(Request $request)
{
    $departureDateId = $request->departure_date_id;
    $tourPriceDetail = TourPriceDetail::where('departure_date_id', $departureDateId)->first();

    if ($tourPriceDetail) {
        $html = view('pages.tour.price_details', compact('tourPriceDetail'))->render();
        return response()->json(['html' => $html]);
    }

    return response()->json(['html' => 'Không tìm thấy chi tiết giá.'], 404);
}

}
