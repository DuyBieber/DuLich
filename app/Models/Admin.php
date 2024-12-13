<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'tbl_admin';

    // Khóa chính
    protected $primaryKey = 'admin_id';

    // Các cột có thể được gán giá trị hàng loạt
    protected $fillable = [
        'admin_id',
        'admin_email',
        'admin_password',
        'admin_chucvu',
        'admin_phone',
    ];

    // Tắt timestamps nếu không sử dụng (created_at, updated_at)
    public $timestamps = false;
}
