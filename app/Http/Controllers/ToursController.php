<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tour;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\TourType;
use App\Models\Itinerary;
use App\Models\Gallery;
use App\Models\DepartureDate;
use App\Models\Locations;

class ToursController extends Controller
{
    // Hiển thị danh sách tour
    public function index()
    {
        $tours = Tour::with('categories', 'tourTypes', 'locations')->orderBy('id', 'DESC')->get();
        return view('admin.tours.index', compact('tours'));
    }
    
    // Hiển thị form tạo mới tour
    public function create()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        $tourTypesByCategory = [];
foreach ($categories as $category) {
    $tourTypesByCategory[$category->id] = $category->tourTypes; // Lưu các loại tour thuộc danh mục
}
        $locations = Locations::all(); // Lấy danh sách địa điểm
        return view('admin.tours.create', compact('categories', 'tourTypesByCategory', 'locations'));
    }
    
    // Lưu tour mới
   // Lưu tour mới
   public function store(Request $request)
   {
       // Validate the request data
       $data = Validator::make($request->all(), [
           'title_tours' => 'required|unique:tours|max:255',
           'description' => 'required|max:220',
           'tour_type_ids' => 'required|array',
           'category_ids' => 'required|array',
           'category_ids.*' => 'exists:categories,id', // Đảm bảo các ID danh mục hợp lệ
           'location_ids' => 'required|array',
           'location_ids.*' => 'exists:locations,id',
           'price' => 'required|numeric|min:0',
           'vehicle' => 'required',
           'tour_from' => 'required',
           'tour_to' => 'required',
           'tour_time' => 'required',
           'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
           'status' => 'required|boolean',
       ], [
           'required' => ':attribute là trường bắt buộc.',
           'exists' => ':attribute không tồn tại trong danh sách.',
       ]);
   
       if ($data->fails()) {
           return redirect()->back()
               ->withErrors($data)
               ->withInput();
       }
   
       $validatedData = $data->validated();
   
       // Logic lưu tour
       $tour = new Tour();
       $tour->title_tours = $validatedData['title_tours'];
       $tour->description = $validatedData['description'];
       $tour->slug_tours = Str::slug($validatedData['title_tours']);
       $tour->vehicle = $validatedData['vehicle'];
       $tour->price = $validatedData['price'];
       $tour->tour_from = $validatedData['tour_from'];
       $tour->tour_to = $validatedData['tour_to'];
       $tour->tour_time = $validatedData['tour_time'];
       $tour->status = $validatedData['status'];
       $tour->tour_code = rand(0000, 9999);
   
       // Xử lý hình ảnh
       if ($request->hasFile('image')) {
           $get_image = $request->file('image');
           $path = 'public/uploads/tours/';
           $get_name_image = $get_image->getClientOriginalName();
           $name_image = current(explode('.', $get_name_image));
           $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
           $get_image->move($path, $new_image);
           $tour->image = $new_image;
       }
   
       $tour->save();
   
       // Lưu các ID danh mục vào bảng trung gian
       if ($request->filled('category_ids')) {
           $tour->categories()->attach($validatedData['category_ids']); // Giả sử bạn đã thiết lập quan hệ many-to-many
       }
   
       // Lưu các ID loại tour vào bảng trung gian
       if ($request->filled('tour_type_ids')) {
           $tour->tourTypes()->attach($validatedData['tour_type_ids']);
       }
   
       // Lưu các ID địa điểm vào bảng trung gian
       if ($request->filled('location_ids')) {
           $tour->locations()->attach($validatedData['location_ids']);
       }
   
       return redirect()->route('tours.index')->with('success', 'Thêm tour thành công!');
   }
   

    
    
   
   public function edit($id)
   {
       $tour = Tour::with('categories', 'tourTypes', 'locations')->findOrFail($id);
       $categories = Category::all();
       
       // Gom nhóm loại tour theo danh mục
       $tourTypesByCategory = [];
       foreach ($categories as $category) {
           $tourTypesByCategory[$category->id] = $category->tourTypes;
       }
       
       $locations = Locations::all();
       
       // Lấy các ID đã chọn của danh mục, địa điểm, và loại tour
       $selectedCategoryIds = $tour->categories->pluck('id')->toArray();
       $selectedLocationIds = $tour->locations->pluck('id')->toArray();
       $selectedTourTypeIds = $tour->tourTypes->pluck('id')->toArray();
   
       return view('admin.tours.edit', compact('tour', 'categories', 'tourTypesByCategory', 'locations', 'selectedCategoryIds', 'selectedLocationIds', 'selectedTourTypeIds'));
   }
   
    public function update(Request $request, $id)
    {
        // Validate the request data
        $data = Validator::make($request->all(), [
            'title_tours' => 'required|max:255|unique:tours,title_tours,' . $id,
            'description' => 'required|max:220',
            'tour_type_ids' => 'required|array',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
            'location_ids' => 'required|array',
            'location_ids.*' => 'exists:locations,id',
            'price' => 'required|numeric|min:0',
            'vehicle' => 'required',
            'tour_from' => 'required',
            'tour_to' => 'required',
            'tour_time' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean',
        ], [
            'required' => ':attribute là trường bắt buộc.',
            'exists' => ':attribute không tồn tại trong danh sách.',
        ]);
    
        if ($data->fails()) {
            return redirect()->back()
                ->withErrors($data)
                ->withInput();
        }
    
        $validatedData = $data->validated();
    
        // Logic cập nhật tour
        $tour = Tour::findOrFail($id);
        $tour->title_tours = $validatedData['title_tours'];
        $tour->description = $validatedData['description'];
        $tour->slug_tours = Str::slug($validatedData['title_tours']);
        $tour->vehicle = $validatedData['vehicle'];
        $tour->price = $validatedData['price'];
        $tour->tour_from = $validatedData['tour_from'];
        $tour->tour_to = $validatedData['tour_to'];
        $tour->tour_time = $validatedData['tour_time'];
        $tour->status = $validatedData['status'];
    
        // Xử lý hình ảnh mới nếu có
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($tour->image) {
                $oldImagePath = public_path('uploads/tours/' . $tour->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $get_image = $request->file('image');
            $path = 'public/uploads/tours/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            $tour->image = $new_image;
        }
    
        $tour->save();
    
        // Cập nhật các ID danh mục vào bảng trung gian
        if ($request->filled('category_ids')) {
            $tour->categories()->sync($validatedData['category_ids']);
        }
    
        // Cập nhật các ID loại tour vào bảng trung gian
        if ($request->filled('tour_type_ids')) {
            $tour->tourTypes()->sync($validatedData['tour_type_ids']);
        }
    
        // Cập nhật các ID địa điểm vào bảng trung gian
        if ($request->filled('location_ids')) {
            $tour->locations()->sync($validatedData['location_ids']);
        }
    
        return redirect()->route('tours.index')->with('success', 'Cập nhật tour thành công!');
    }
    public function destroy(string $id)
    {
        $tours = Tour::find($id);
        $tours->delete();
        return redirect()->route('tours.index');
    }

    // Hiển thị thông tin tour theo slug
    public function detail_tour($slug)
    {
        // Lấy thông tin tour theo slug
        $tour = Tour::where('slug_tours', $slug)->firstOrFail();
        
        // Lấy lịch trình (itinerary) của tour
        $itinerary = Itinerary::where('tour_id', $tour->id)->get();
        
        // Lấy hình ảnh (gallery) của tour
        $gallery = Gallery::where('tour_id', $tour->id)->get();
        
        // Lấy dữ liệu ngày khởi hành
        $departureDates = DepartureDate::where('tour_id', $tour->id)->get();
    
        
        $categoryId = $tour->categories->pluck('id'); // Lấy danh sách category_id của tour
        $tourTypeId = $tour->tourTypes->pluck('id'); // Lấy danh sách tour_type_id của tour
        
        $relatedTours = Tour::whereHas('categories', function ($query) use ($categoryId) {
                $query->whereIn('categories.id', $categoryId);
            })
            ->whereHas('tourTypes', function ($query) use ($tourTypeId) {
                $query->whereIn('tour_types.id', $tourTypeId);
            })
            ->where('id', '!=', $tour->id) // Loại trừ tour hiện tại
            ->take(3) // Giới hạn 3 tour
            ->get();


        
        
    
        return view('pages.tour.details_tour', [
            'tour' => $tour,
            'itinerary' => $itinerary,
            'gallery' => $gallery,
            'departureDates' => $departureDates,
            'relatedTours' => $relatedTours, // Thêm biến relatedTours vào view
        ]);
    }
    
    // Hiển thị tour theo loại
    public function showByTourType($slug)
    {
        $tourType = TourType::where('slug', $slug)->firstOrFail();
        
        // Lấy các tour có loại tour tương ứng và loại bỏ các bản ghi trùng lặp
        $tours = $tourType->tours()->distinct()->get();
    
        return view('pages.tour.tour', compact('tours', 'tourType'));
    }
    

// Hiển thị theo danh mục tour
public function showByCategory($slug)
{
    $category = Category::where('slug', $slug)->firstOrFail(); // Lấy danh mục theo slug
    // Lấy các tour thuộc danh mục tương ứng
    $tours = $category->tours; // Sử dụng mối quan hệ nhiều-nhiều

    return view('pages.tour.tour_category', compact('tours', 'category'));
}



    // Hiển thị danh sách tour trên trang chính
    public function indexTour()
    {
        $tours = Tour::with('category')->orderBy('id', 'DESC')->get();
        return view('tour.index', compact('tours'));
    }
    public function getToursByLocation($id)
    {
        // Lấy danh sách các tour theo location ID
        $tours = Tour::whereHas('locations', function ($query) use ($id) {
            $query->where('locations.id', $id); // Sử dụng 'locations.id' để tránh xung đột
        })->get();
        $location = Locations::find($id);
        // Trả về một view với danh sách tour
        return view('pages.tour.tour_by_location', compact('tours','location'));
    }
    public function getTourTypesByCategory($categoryId)
{
    $tourTypes = TourType::whereHas('tours.categories', function ($query) use ($categoryId) {
        $query->where('categories.id', $categoryId);
    })->get();

    return response()->json($tourTypes);
}
    
    public function search(Request $request)
{
    $tourTypes = TourType::all();
    $locations = Locations::all();
    $categories = Category::all();

    $query = Tour::query();

    // Thêm điều kiện loại tour (nếu có)
    $tourTypeId = $request->input('tour-type');
    if ($tourTypeId) {
        $query->whereHas('tourTypes', function($q) use ($tourTypeId) {
            $q->where('tour_types.id', $tourTypeId);
        });
    }

    // Thêm điều kiện location_id (nếu có)
    $locationId = $request->input('location_id');
    if ($locationId) {
        $query->whereHas('locations', function($q) use ($locationId) {
            $q->where('locations.id', $locationId);
        });
    }

    // Thêm điều kiện danh mục (nếu có)
    $categoryId = $request->input('category_id');
    if ($categoryId) {
        $query->whereHas('categories', function($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }

    // Thêm điều kiện giá tour (nếu có)
    $priceMin = $request->input('price_min');
    if ($priceMin !== null) {
        $query->where('price', '>=', $priceMin);
    }
    
    $priceMax = $request->input('price_max');
    if ($priceMax !== null) {
        $query->where('price', '<=', $priceMax);
    }

    $keyword = $request->input('keyword');
    if ($keyword) {
        $query->where('title_tours', 'LIKE', '%' . $keyword . '%');
    }
    

    // Thực hiện truy vấn và lấy kết quả
    $tours = $query->get();

    return view('pages.tour.search_results', compact('tours', 'tourTypes', 'locations', 'categories'))
           ->with('message', $tours->isEmpty() ? 'Không tìm thấy tour nào phù hợp.' : null);
}

    
    
    

   
    
    
    
    

    
}
