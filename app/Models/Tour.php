<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    protected $table = 'tours';
    protected $fillable = [
        'title_tours',
        'slug_tours',
        'description',
        'price',
        'vehicle',
        'return_date',
        'tour_code',
        'tour_time',
        'image',
        'tour_from',
        'tour_to',
        'quantity',
        
    ];
    protected $primaryKey = 'id';
    protected $dates = ['departure_date', 'return_date'];

    // Hoặc sử dụng cast để chuyển đổi các thuộc tính cụ thể
    protected $casts = [
        'departure_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_tour', 'tour_id', 'category_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    // Thêm mối quan hệ với bảng itineraries
    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }
    public function tourTypes()
    {
        return $this->belongsToMany(TourType::class, 'tour_tour_type', 'tour_id', 'tour_type_id');
    }
public function locations()
    {
        return $this->belongsToMany(Locations::class, 'location_tour', 'tour_id', 'locations_id');
    }
public function priceDetails()
{
    return $this->hasOne(TourPriceDetail::class);
}
public function departureDates()
{
    return $this->hasMany(DepartureDate::class);
}
public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}
