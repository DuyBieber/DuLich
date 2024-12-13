<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;  protected $fillable = ['tour_id', 'name', 'description', 'image'];

    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'location_tour', 'locations_id', 'tour_id');
    }
    
}
