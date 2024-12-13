<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Locations;

class HomeController extends Controller
{public function index(Request $request)
    {
        $limit = $request->has('show_all') ? null : 6;
        $tours = Tour::with('departureDates')->take($limit)->get()->map(function($tour) {
            $tour->firstAvailableDepartureDate = $tour->departureDates->firstWhere('available_seats', '>', 0);
            return $tour;
        });
        $locations = Locations::orderBy('id', 'DESC')->get();
        return view('pages.home.home', compact('tours', 'locations'));
    }
    
    
}
