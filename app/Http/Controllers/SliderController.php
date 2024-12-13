<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Slider;
use App\Models\Tour;

class SliderController extends Controller
{
    public function __construct()
    {
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::orderBy('id', 'DESC')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tours = Tour::all(); // Lấy tất cả các tour
    return view('admin.sliders.create', compact('tours'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'slider_name' => 'required|string|max:255',
            'slider_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slider_status' => 'required|boolean',
            'slider_desc' => 'nullable|string',
            'tour_id' => 'nullable|exists:tours,id',  // Thêm validation cho tour_id
        ]);
    
        // Lưu ảnh slider
        $image = $request->file('slider_image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/slider/'), $imageName);
    
        // Tạo mới Slider
        Slider::create([
            'slider_name' => $request->input('slider_name'),
            'slider_image' => $imageName,
            'slider_status' => $request->input('slider_status'),
            'slider_desc' => $request->input('slider_desc'),
            'tour_id' => $request->input('tour_id'),  // Lưu tour_id liên kết với slider
        ]);
    
        // Thông báo và chuyển hướng
        Session::flash('message', 'Slider added successfully.');
        return redirect()->route('sliders.create');
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        $tours = Tour::all();

    return view('admin.sliders.edit', compact('slider', 'tours'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
{
    $request->validate([
        'slider_name' => 'required|string|max:255',
        'slider_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'slider_status' => 'required|boolean',
        'slider_desc' => 'nullable|string',
        'tour_id' => 'nullable|exists:tours,id',  // Thêm validation cho tour_id, có thể null
    ]);

    // Cập nhật các trường slider
    $slider->slider_name = $request->input('slider_name');
    $slider->slider_status = $request->input('slider_status');
    $slider->slider_desc = $request->input('slider_desc');
    $slider->tour_id = $request->input('tour_id') ?? $slider->tour_id;  // Nếu không có tour_id mới, giữ nguyên giá trị cũ

    // Kiểm tra xem có ảnh mới không, nếu có thì thay thế ảnh cũ
    if ($request->hasFile('slider_image')) {
        $image = $request->file('slider_image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/slider'), $imageName);
        $slider->slider_image = $imageName;
    }

    // Lưu lại slider
    $slider->save();

    // Thông báo và chuyển hướng
    Session::flash('message', 'Slider updated successfully.');
    return redirect()->route('sliders.index');
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        Session::flash('message', 'Slider deleted successfully.');
        return redirect()->route('sliders.index');
    }
}
