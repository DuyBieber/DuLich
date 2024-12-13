<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Đặt tên bảng nếu không phải là dạng số nhiều của tên model
    protected $table = 'categories';

    // Danh sách các thuộc tính có thể được gán hàng loạt
    protected $fillable = [
        'title',
        'description',
        'status',
        'image',
        'slug',
    ];

    // Nếu bạn không muốn sử dụng các cột timestamps, thêm thuộc tính này
    protected $primaryKey = 'id';
    public $timestamps = true;
    public function tourTypes()
    {
        return $this->belongsToMany(TourType::class, 'category_tour_type', 'category_id', 'tour_type_id');
    }
    public function tourCategories()
    {
        return $this->belongsToMany(Category::class, 'category_tour', 'tour_id', 'category_id');
    }
    public function tours() // Thêm phương thức này
    {
        return $this->belongsToMany(Tour::class, 'category_tour', 'category_id', 'tour_id');
    }
   
}
