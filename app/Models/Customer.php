<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_password',
        'customer_phone',
        'customer_address',
    ];
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class)
                    ->withPivot('assigned_at', 'is_redeemed')
                    ->withTimestamps();
    }
}
