<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Gallery;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class GalleryContronler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy tất cả hình ảnh từ cơ sở dữ liệu
        $galleries = Gallery::with('tour', 'blog')->get();
    
        return view('admin.galleries.index', compact('galleries'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $tours = Tour::all(); // Lấy tất cả các tour
    $blogs = Blog::all(); // Lấy tất cả các blog
    
    return view('admin.galleries.create', [
        'tours' => $tours,
        'blogs' => $blogs
    ]);
}

public function store(Request $request)
{
    $data = Validator::make($request->all(), [
        'title' => 'required|max:255',
        'image.*' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
        'type' => 'required', // Validate type
        'tour_id' => 'required_if:type,tour|nullable|exists:tours,id',
        'blog_id' => 'required_if:type,blog|nullable|exists:blogs,id',
    ], [
        'title.required' => 'Yêu cầu nhập tiêu đề',
        'image.*.required' => 'Yêu cầu chọn hình ảnh',
        'image.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif',
        'image.*.max' => 'Hình ảnh không được lớn hơn 2MB',
        'type.required' => 'Yêu cầu chọn loại nội dung',
        'tour_id.required_if' => 'Yêu cầu chọn tour khi loại nội dung là tour',
        'blog_id.required_if' => 'Yêu cầu chọn blog khi loại nội dung là blog',
    ]);

    if ($data->fails()) {
        return redirect()->back()
            ->withErrors($data)
            ->withInput();
    }

    $validatedData = $data->validated();
    
    if ($request->image) {
        foreach ($request->image as $gal) {
            $gallery = new Gallery();
            $gallery->title = $validatedData['title'];

            if ($request->type === 'tour') {
                $gallery->tour_id = $request->input('tour_id');
                $gallery->blog_id = null;
            } elseif ($request->type === 'blog') {
                $gallery->blog_id = $request->input('blog_id');
                $gallery->tour_id = null;
            }

            $get_image = $gal;
            $path = 'public/uploads/galleries/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            $gallery->image = $new_image;
            $gallery->save();
        }
    }

    return redirect()->back()->with('success', 'Hình ảnh đã được tải lên thành công.');
}

    

    public function edit($id)
{
    // Tìm hình ảnh theo ID
    $gallery = Gallery::find($id);

    if (!$gallery) {
        return redirect()->route('gallery.index')->with('error', 'Hình ảnh không tồn tại.');
    }

    // Tìm thông tin tour và blog tương ứng nếu có
    $tour = Tour::find($gallery->tour_id);
    $blog = Blog::find($gallery->blog_id);

    return view('admin.galleries.edit', compact('gallery', 'tour', 'blog'));
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
 

    


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Tìm gallery theo ID
        $gallery = Gallery::find($id);

        // Kiểm tra xem gallery có tồn tại không
        if (!$gallery) {
            return back()->with('error', 'Hình ảnh không tồn tại.');
        }

        // Xóa tệp hình ảnh từ hệ thống tập tin nếu có
        if ($gallery->image) {
            Storage::disk('public')->delete('uploads/galleries/' . $gallery->image);
        }

        // Xóa bản ghi trong cơ sở dữ liệu
        $gallery->delete();

        return back()->with('success', 'Hình ảnh đã được xóa thành công.');
    }

}
