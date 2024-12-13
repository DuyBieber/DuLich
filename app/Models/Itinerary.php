<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $fillable = [
        'tour_id',
        'day',
        'img',
        'activity_description',
        'location',
        'start_time',
        'end_time',
    ];
    
    protected $dates = ['start_time', 'end_time'];
    public function tour()
{
    return $this->belongsTo(Tour::class);
}
}