<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tour;
use App\Models\Category;
use Illuminate\Support\Str;
class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tours = Tour::with('category')->orderBy('id', 'DESC')->get(); // Khởi tạo biến $tours
        return view('admin.tours.index', compact('tours')); // Sử dụng biến $tours
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('id','DESC')->get();
        return view('admin.tours.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'title_tours' => 'required|unique:tours|max:255',
            'description' => 'required|max:220',
            'category_id' =>'required',
            'quantity' =>'required',
            'price'=>'required',
            'vehicle' =>'required',
            'departure_date' =>'required',
            'return_date' =>'required',
            'tour_from' =>'required',
            'tour_to' =>'required',
            'tour_time' =>'required',
            'image' => 'required|image',
            'status'=>'required',
            
        ], [
            'title_tours.required' => 'Yêu cầu nhập tiêu đề',
            'title_tours.unique' => 'Tiêu đề đã có vui lòng nhập không trùng',
            'description.required' => 'Yêu cầu nhập mô tả',
            'category_id.required' => 'Yêu cầu chọn danh mục',
            'price.required'=>'Yêu cầu nhập giá',
            'quantity.required'=>'Yêu cầu nhập số lượng',
            'vehicle.required' => 'Yêu cầu nhập mô tả',
            'departure_date.required' => 'Yêu cầu nhập mô tả',
            'return_date.required' => 'Yêu cầu nhập mô tả',
            'tour_from.required' => 'Yêu cầu nhập mô tả',
            'tour_to.required' => 'Yêu cầu nhập mô tả',
            'tour_time.required' => 'Yêu cầu nhập mô tả',
            'status.required' => 'Yêu cầu nhập mô tả',
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
        $tour = new Tour();
        $tour->title_tours = $validatedData['title_tours'];
        $tour->description = $validatedData['description']; // Đảm bảo tên thuộc tính đúng
        $tour->category_id = $validatedData['category_id'];
        $tour->slug_tours = Str::slug($validatedData['title_tours']); // Tạo slug và lưu vào cột slug (nếu có)
        $tour->vehicle = $validatedData['vehicle'];
        $tour->price = $validatedData['price'];
        $tour->quantity = $validatedData['quantity'];
        $tour->departure_date = $validatedData['departure_date'];
        $tour->return_date = $validatedData['return_date'];
        $tour->tour_from = $validatedData['tour_from'];
        $tour->tour_to = $validatedData['tour_to'];
        $tour->tour_time = $validatedData['tour_time'];
        $tour->status = $validatedData['status'];
        $tour->tour_code= rand(0000, 9999);
        

    
        $get_image = $request->image;
        $path = 'public/uploads/tours/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image=current(explode('.',$get_name_image));
        $new_image=$name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path,$new_image);
    
        $tour->image= $new_image;
        $tour->save(); // Lưu mô hình vào cơ sở dữ liệu
        
    
        return redirect()->route('tours.index')->with('success', 'Cập nhật danh mục thành công!');
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
    $categories = Category::orderBy('id', 'DESC')->get();
    $tour = Tour::find($id);
    
    return view('admin.tours.edit', compact('tour', 'categories'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Validator::make($request->all(), [
            'title_tours' => 'required|max:255',
            'description' => 'required|max:220',
            'category_id' =>'required',
            'quantity' =>'required',
            'price'=>'required',
            'vehicle' =>'required',
            'departure_date' =>'required',
            'return_date' =>'required',
            'tour_from' =>'required',
            'tour_to' =>'required',
            'tour_time' =>'required',
            'status'=>'required',
            
        ], [
            'title_tours.required' => 'Yêu cầu nhập tiêu đề',
            'description.required' => 'Yêu cầu nhập mô tả',
            'category_id.required' => 'Yêu cầu chọn danh mục',
            'price.required'=>'Yêu cầu nhập giá',
            'quantity.required'=>'Yêu cầu nhập số lượng',
            'vehicle.required' => 'Yêu cầu nhập mô tả',
            'departure_date.required' => 'Yêu cầu nhập mô tả',
            'return_date.required' => 'Yêu cầu nhập mô tả',
            'tour_from.required' => 'Yêu cầu nhập mô tả',
            'tour_to.required' => 'Yêu cầu nhập mô tả',
            'tour_time.required' => 'Yêu cầu nhập mô tả',
            'status.required' => 'Yêu cầu nhập mô tả',
            
        ]);
    
        if ($data->fails()) {
            return redirect()->back()
                ->withErrors($data)
                ->withInput();
        }
    
        // Lấy dữ liệu đã xác thực
        $validatedData = $data->validated();
    
        // Logic lưu dữ liệu
        $tour = Tour::find($id);
        $tour->title_tours = $validatedData['title_tours'];
        $tour->description = $validatedData['description']; // Đảm bảo tên thuộc tính đúng
        $tour->category_id = $validatedData['category_id'];
        $tour->slug_tours = Str::slug($validatedData['title_tours']); // Tạo slug và lưu vào cột slug (nếu có)
        $tour->vehicle = $validatedData['vehicle'];
        $tour->price = $validatedData['price'];
        $tour->quantity = $validatedData['quantity'];
        $tour->departure_date = $validatedData['departure_date'];
        $tour->return_date = $validatedData['return_date'];
        $tour->tour_from = $validatedData['tour_from'];
        $tour->tour_to = $validatedData['tour_to'];
        $tour->tour_time = $validatedData['tour_time'];
        $tour->status = $validatedData['status'];
        $tour->tour_code= $tour->tour_code;
        

    
        if ($request->hasFile('image')) {
            $get_image = $request->file('image');
            $path = 'uploads/tours/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move(public_path($path), $new_image);
            $tour->image = $new_image;
        }
    
        
        $tour->save(); // Lưu mô hình vào cơ sở dữ liệu
        
    
        return redirect()->route('tours.index')->with('success', 'Cập nhật tour thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tours = Tour::find($id);
        $tours->delete();
        return redirect()->route(route:'tours.index');
    }
}
