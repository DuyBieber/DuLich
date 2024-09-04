<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

use Illuminate\Support\Str;
class CategoriesController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id','DESC')->get();
        return view('admin.categories.index',data:compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $data = Validator::make($request->all(), [
        'title' => 'required|unique:categories|max:255',
        'description' => 'required|max:220',
        'image' => 'required|image',
        
    ], [
        'title.required' => 'Yêu cầu nhập tiêu đề',
        'description.required' => 'Yêu cầu nhập nội dung',
        'image.required' => 'Yêu cầu chọn hình ảnh',
        
    ]);

    if ($data->fails()) {
        return redirect()->back()
            ->withErrors($data)
            ->withInput();
    }

    // Lấy dữ liệu đã xác thực
    $validatedData = $data->validated();

    // Logic lưu dữ liệu
    $category = new Category();
    $category->title = $validatedData['title'];
    $category->description = $validatedData['description']; // Đảm bảo tên thuộc tính đúng
    $category->slug = Str::slug($validatedData['title']); // Tạo slug và lưu vào cột slug (nếu có)

    $get_image = $request->image;
    $path = 'public/uploads/categories/';
    $get_name_image = $get_image->getClientOriginalName();
    $name_image=current(explode('.',$get_name_image));
    $new_image=$name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
    $get_image->move($path,$new_image);

    $category->image= $new_image;
    $category->save(); // Lưu mô hình vào cơ sở dữ liệu

    return redirect()->route(route:'categories.index');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit',data:compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Validate input data
    $data = Validator::make($request->all(), [
        'title' => 'required|unique:categories,title,'.$id.'|max:255',
        'description' => 'required|max:220',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ], [
        'title.required' => 'Yêu cầu nhập tiêu đề',
        'description.required' => 'Yêu cầu nhập nội dung',
    ]);

    if ($data->fails()) {
        return redirect()->back()
            ->withErrors($data)
            ->withInput();
    }

    // Get validated data
    $validatedData = $data->validated();

    // Find existing category
    $category = Category::findOrFail($id);
    $category->title = $validatedData['title'];
    $category->description = $validatedData['description'];
    $category->slug = Str::slug($validatedData['title']);

    if ($request->hasFile('image')) {
        $get_image = $request->file('image');
        $path = 'uploads/categories/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.', $get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move(public_path($path), $new_image);
        $category->image = $new_image;
    }

    $category->save(); // Save the model to the database

    return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categories = Category::find($id);
        $categories->delete();
        return redirect()->route(route:'categories.index');
    }
}
