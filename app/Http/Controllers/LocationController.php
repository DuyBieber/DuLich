<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Locations::orderBy('id', 'DESC')->get();
        return view('admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tours = Tour::orderBy('id', 'DESC')->get(); // Lấy danh sách tour
        return view('admin.locations.create', compact('tours')); // Truyền danh sách tour vào view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $data = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required|max:220',
            'image' => 'required|image',
        ], [
            'name.required' => 'Yêu cầu nhập tên địa điểm',
            'description.required' => 'Yêu cầu nhập mô tả',
            'image.required' => 'Yêu cầu chọn hình ảnh',
        ]);

        if ($data->fails()) {
            return redirect()->back()
                ->withErrors($data)
                ->withInput();
        }

        $validatedData = $data->validated();

        // Tạo địa điểm mới
        $location = new Locations();
        $location->name = $validatedData['name'];
        $location->description = $validatedData['description'];

        // Xử lý hình ảnh
        if ($request->hasFile('image')) {
            $get_image = $request->file('image');
            $path = 'uploads/locations/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = pathinfo($get_name_image, PATHINFO_FILENAME);
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move(public_path($path), $new_image);
            $location->image = $new_image;
        }

        $location->save();

        // Nếu có tour_ids, liên kết tour với địa điểm
        if ($request->has('tour_ids')) {
            $location->tours()->attach($request->tour_ids); // Liên kết nhiều tour
        }

        return redirect()->route('locations.index')->with('success', 'Thêm địa điểm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $location = Locations::findOrFail($id);
        return view('admin.locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $location = Locations::findOrFail($id);
        $tours = Tour::orderBy('id', 'DESC')->get(); // Lấy danh sách tour
        return view('admin.locations.edit', compact('location', 'tours'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Xác thực dữ liệu đầu vào
        $data = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required|max:220',
            'image' => 'nullable|image',
        ], [
            'name.required' => 'Yêu cầu nhập tên địa điểm',
            'description.required' => 'Yêu cầu nhập mô tả',
            'image.image' => 'Hình ảnh không hợp lệ',
        ]);

        if ($data->fails()) {
            return redirect()->back()
                ->withErrors($data)
                ->withInput();
        }

        $validatedData = $data->validated();

        $location = Locations::findOrFail($id);
        $location->name = $validatedData['name'];
        $location->description = $validatedData['description'];

        // Xử lý hình ảnh
        if ($request->hasFile('image')) {
            $get_image = $request->file('image');
            $path = 'uploads/locations/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = pathinfo($get_name_image, PATHINFO_FILENAME);
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move(public_path($path), $new_image);
            $location->image = $new_image;
        }

        $location->save();

        // Cập nhật mối quan hệ với tour
        if ($request->has('tour_ids')) {
            $location->tours()->sync($request->tour_ids); // Cập nhật mối quan hệ
        }

        return redirect()->route('locations.index')->with('success', 'Cập nhật địa điểm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = Locations::findOrFail($id);
        $location->tours()->detach(); // Xóa mối quan hệ với các tour trước khi xóa địa điểm
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Xóa địa điểm thành công!');
    }
    

}
