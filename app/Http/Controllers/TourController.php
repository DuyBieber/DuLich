<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function tour($slug){
        return view('pages.tour.tour');
    }
    public function detail_tour($slug){
        return view('pages.tour.details_tour');
    }
}
