<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    protected $table = 'tours';
    protected $fillable = [
        'title_tours',
        'slug_tours',
        'description',
        'price',
        'vehicle',
        'departure_date',
        'return_date',
        'tour_code',
        'tour_time',
        'image',
        'tour_from',
        'tour_to',
        'quantity',
    ];
    protected $primaryKey = 'id';

    public function category(){
        return $this-> belongsTo(Category::class);
    }
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
