<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Blog::orderBy('id','DESC')->get();
        return view('admin.blogs.index',data:compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'title' => 'required|unique:categories|max:255',
            'content' => 'required|string|max:10000',
            'image' => 'required|image',
            
        ], [
            'title.required' => 'Yêu cầu nhập tiêu đề',
            'content.required' => 'Yêu cầu nhập nội dung',
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
        $post = new Blog();
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content']; // Đảm bảo tên thuộc tính đúng
        $post->slug = Str::slug($validatedData['title']); // Tạo slug và lưu vào cột slug (nếu có)
    
        $get_image = $request->image;
        $path = 'public/uploads/blogs/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image=current(explode('.',$get_name_image));
        $new_image=$name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path,$new_image);
    
        $post->image= $new_image;
        $post->save(); // Lưu mô hình vào cơ sở dữ liệu
    
        return redirect()->route(route:'blogs.index');
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
        $post = Blog::find($id);
        return view('admin.blogs.edit',data:compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Validator::make($request->all(), [
            'title' => 'required|unique:categories|max:255',
            'content' => 'required|string|max:10000',
            'image' => 'required|image',
            
        ], [
            'title.required' => 'Yêu cầu nhập tiêu đề',
            'content.required' => 'Yêu cầu nhập nội dung',
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
        $post =  Blog::findOrFail($id);
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content']; // Đảm bảo tên thuộc tính đúng
        $post->slug = Str::slug($validatedData['title']); // Tạo slug và lưu vào cột slug (nếu có)
    
        if ($request->hasFile('image')) {
            $get_image = $request->file('image');
            $path = 'uploads/categories/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move(public_path($path), $new_image);
            $post->image = $new_image;
        }
    
    
      
        $post->save(); // Lưu mô hình vào cơ sở dữ liệu
    
        return redirect()->route(route:'blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
