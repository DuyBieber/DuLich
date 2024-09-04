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
}
