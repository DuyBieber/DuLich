<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPriceDetail extends Model
{
    use HasFactory;
    protected $table = 'tour_price_details';

    protected $fillable = [
        'tour_id',
        'adult_price',
        'child_price',
        'infant_price',
        'baby_price',
        'foreign_surcharge',
        'single_room_surcharge',
        'departure_date_id',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    
    public function departureDate()
    {
        return $this->belongsTo(DepartureDate::class);
    }
}
