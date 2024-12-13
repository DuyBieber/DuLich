<?php


namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use App\Models\Customer; // Import mô hình Customer
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
{
    // Lấy tất cả bình luận với thông tin khách hàng và tour
    $reviews = Review::with(['customer', 'tour'])->get();

    return view('admin.reviews.index', compact('reviews'));
}

public function store(Request $request)
{
    $customerId = session('customer_id'); // Kiểm tra customer_id từ session
    $tourId = $request->input('tour_id');

    // Kiểm tra khách hàng đã đặt tour chưa
    $hasBooking = Booking::where('customer_id', $customerId)
        ->where('tour_id', $tourId)
        ->exists();

    if (!$hasBooking) {
        return response()->json(['error' => 'Bạn chưa đặt tour này, không thể bình luận.'], 403);
    }

    // Lưu đánh giá
    $review = Review::create([
        'customer_id' => $customerId,
        'tour_id' => $tourId,
        'rating' => $request->input('rating'),
        'comment' => $request->input('comment'),
        'admin_reply' => null, // Thiết lập giá trị mặc định
    ]);

    // Lấy thông tin khách hàng
    $customer = Customer::find($customerId);

    return response()->json([
        'success' => 'Đã lưu bình luận thành công!',
        'review' => [
            'id' => $review->id,
            'customer_name' => $customer->customer_name, // Tên khách hàng
            'rating' => $review->rating,
            'comment' => $review->comment,
            'admin_reply' => $review->admin_reply, // Thêm trường admin_reply
        ],
        'reviews' => Review::where('tour_id', $tourId)->with('customer')->get() // Trả về danh sách bình luận
    ]);
}

protected function authorizeReview($review)
{
    if (!$review || $review->customer_id !== session('customer_id')&& !session('admin_id')) {
        abort(403, 'Bạn không có quyền truy cập vào bình luận này.');
    }
}

// Sử dụng phương thức này trong `update` và `destroy` như sau:
public function update(Request $request, $id)
{
    $review = Review::findOrFail($id);
    $this->authorizeReview($review);

    $review->comment = $request->input('content');
    $review->save();

    return response()->json(['success' => 'Cập nhật bình luận thành công.']);
}

public function destroy($id)
{
    $review = Review::findOrFail($id);
    $this->authorizeReview($review);

    $review->delete();

    return response()->json(['success' => 'Xóa bình luận thành công.']);
}

public function destroyForAdmin($id){
    $review = Review::findOrFail($id);
    $this->authorizeReview($review);

    $review->delete();
    return  redirect()->route('reviews.index')->with('success', 'Bình luận đã được xóa bởi admin.');
}
public function reply(Request $request, $id)
{
    $request->validate([
        'admin_reply' => 'required|string|max:255',
    ]);

    $review = Review::findOrFail($id);
    $review->admin_reply = $request->input('admin_reply');
    $review->save();

    return redirect()->route('reviews.index')->with('success', 'Trả lời đã được lưu!');
}

}
