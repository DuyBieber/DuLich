<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'tour_id',
        'rating',
        'comment',
        'admin_reply',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}