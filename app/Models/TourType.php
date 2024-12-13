<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourType extends Model
{
    protected $fillable = [
        'type_name',
        'type_desc',
        'type_status',
        'category_id',
        
    ];

    protected $primaryKey = 'id';

    // Quan hệ với Tour: một loại tour có thể có nhiều tour
    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'tour_tour_type', 'tour_type_id', 'tour_id');
    }
public function categories()
{
    return $this->belongsToMany(Category::class, 'category_tour_type', 'tour_type_id', 'category_id');
}
    public function tourTypes()
{
    return $this->belongsToMany(TourType::class, 'category_tour_type', 'category_id', 'tour_type_id');
}
}

