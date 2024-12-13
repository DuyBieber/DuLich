<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'coupon_name',
        'coupon_code',
        'coupon_quantity',
        'coupon_number',
        
    ];
    public function customers()
    {
        return $this->belongsToMany(Customer::class)
                    ->withPivot('assigned_at', 'is_redeemed')
                    ->withTimestamps();
    }
}
