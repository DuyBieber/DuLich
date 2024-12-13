<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartureDate extends Model
{
    use HasFactory;

    protected $table = 'departure_dates';
    protected $fillable = [
        'tour_id',
        'departure_date',
        'feature',
        'price',
        'available_seats',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
   // Trong model DepartureDate
public function priceDetails()
{
    return $this->hasMany(TourPriceDetail::class, 'departure_date_id');
}

}
