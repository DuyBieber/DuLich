<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\TourType;
use App\Models\Category;
use Illuminate\Support\Str; // Import Str class for generating slugs

class TourTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tourTypes = TourType::orderBy('id', 'DESC')->get();
        return view('admin.tourtype.index', compact('tourTypes'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $categories = Category::orderBy('title', 'ASC')->get();
    return view('admin.tourtype.create', compact('categories'));
}
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $data = Validator::make($request->all(), [
            'type_name' => 'required|string|max:255|unique:tour_types,type_name', // Đảm bảo tên loại tour là duy nhất
            'type_desc' => 'nullable|string',
            'type_status' => 'nullable|boolean',
            'category_ids' => 'required|array', // Chấp nhận danh sách category
        ], [
            'type_name.required' => 'Yêu cầu nhập tên loại tour',
            'type_name.unique' => 'Tên loại tour đã tồn tại',
            'category_ids.required' => 'Yêu cầu chọn danh mục',
        ]);
    
        if ($data->fails()) {
            return redirect()->back()
                ->withErrors($data)
                ->withInput();
        }
    
        // Lấy dữ liệu đã xác thực
        $validatedData = $data->validated();
    
        // Logic lưu loại tour
        $tourType = new TourType();
        $tourType->type_name = $validatedData['type_name'];
        $tourType->type_desc = $validatedData['type_desc'];
        $tourType->slug = Str::slug($validatedData['type_name']); // Tạo slug và lưu vào cột slug
        $tourType->type_status = $request->has('type_status') ? 1 : 0; // Đặt trạng thái
    
        $tourType->save(); // Lưu mô hình vào cơ sở dữ liệu
    
        // Lưu danh mục liên kết
        $tourType->categories()->attach($validatedData['category_ids']);
    
        return redirect()->route('tour_types.index')->with('success', 'Loại tour đã được thêm thành công.');
    }
    
    
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $tourType = TourType::findOrFail($id);
    $categories = Category::orderBy('title', 'ASC')->get();
    $selectedCategories = $tourType->categories->pluck('id')->toArray(); // Lấy ID của các danh mục đã chọn

    return view('admin.tourtype.edit', compact('tourType', 'categories', 'selectedCategories'));
}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'type_name' => 'required|max:255',
        'type_desc' => 'nullable|max:500',
        'type_status' => 'nullable|boolean',
        'category_ids' => 'required|array',
    ]);

    $tourType = TourType::findOrFail($id);
    $tourType->update([
        'type_name' => $request->type_name,
        'type_desc' => $request->type_desc,
        'type_status' => $request->has('type_status') ? 1 : 0,
        'slug' => Str::slug($request->type_name),
    ]);

    $tourType->categories()->sync($request->category_ids);

    return redirect()->route('tour_types.index')->with('success', 'Loại tour đã được cập nhật thành công.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourType $tourType)
    {
        $tourType->delete();
        return redirect()->route('tour_types.index')->with('success', 'Loại tour đã được xóa thành công.');
    }
}
