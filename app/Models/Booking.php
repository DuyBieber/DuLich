<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'name',              // Thay 'full_name' thành 'name' để đồng bộ với controller
        'phone',             // Thêm trường cho số điện thoại
        'email',             // Thêm trường cho email
        'address',           // Thêm trường cho địa chỉ
        'tour_id',           // ID của tour
        'adults',            // Số lượng người lớn
        'children',          // Số lượng trẻ em
        'babies',            // Số lượng trẻ nhỏ
        'infants',           // Số lượng sơ sinh
        'note',              // Ghi chú
        'departure_date_id',
        'visa_quantity',     // Số lượng visa
       
        'single_room_quantity',  // Số lượng phòng đơn
        'total_price',       // Tổng giá
        'booking_status',
        'booking_code',    // Trạng thái đặt tour
    ];

    

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);  // Liên kết với model Customer
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
    public function payments()
{
    return $this->hasMany(Payments::class);
}
public function departureDate()
{
    return $this->belongsTo(DepartureDate::class);
}
public function deleteBooking($bookingId)
{
    // Tìm booking theo ID
    $booking = $this->find($bookingId);

    // Kiểm tra xem booking có tồn tại không
    if (!$booking) {
        return false;  // Nếu không tìm thấy booking, trả về false
    }

    // Xóa các bản ghi liên quan trong bảng Payments (nếu có)
    $booking->payments()->delete();

    // Xóa các bản ghi liên quan trong bảng BookingCoupon (nếu có)
    DB::table('booking_coupon')->where('booking_id', $booking->id)->delete();

    // Xóa booking
    $booking->delete();

    return true;  // Trả về true nếu xóa thành công
}
}

