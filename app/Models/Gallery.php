<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    /**
     * Mối quan hệ với mô hình Blog.
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }
 
}
