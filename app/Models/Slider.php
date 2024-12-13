<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'slider_name', 'slider_image','slider_status','slider_desc',
        'tour_id', // Add this to allow saving the tour ID
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    protected $primaryKey = 'id';
 	protected $table = 'slider';
}
