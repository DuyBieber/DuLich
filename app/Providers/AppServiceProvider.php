<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Slider;
use App\Models\TourType; // Thêm mô hình TourType
use App\Models\Locations; // Thêm mô hình Location
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Chia sẻ $categories, $sliders, $tourTypes, và $locations với tất cả các view
        View::composer('*', function ($view) {
            $categories = Category::with('tourTypes')->get();
            
            // Lấy các slider đang hoạt động, đồng thời lấy thông tin tour liên quan
            $sliders = Slider::where('slider_status', 1)
                             ->with('tour') // Chạy eager load để lấy thông tin tour liên quan
                             ->orderBy('id', 'DESC')
                             ->get(); 

            $tourTypes = TourType::all(); // Lấy tất cả các loại tour
            $locations = Locations::all(); // Lấy tất cả các địa điểm

            // Chia sẻ các biến với tất cả các view
            $view->with('categories', $categories);
            $view->with('sliders', $sliders); // Chia sẻ các slider với tất cả các view
            $view->with('tourTypes', $tourTypes); // Chia sẻ các loại tour với tất cả các view
            $view->with('locations', $locations); // Chia sẻ các địa điểm với tất cả các view
        });
    }
}
