<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\GalleryContronler;
use App\Http\Controllers\ToursController;



//trang chu
Route::get('/trang-chu',[HomeController::class,'index'])->name('home');
Route::get('/tour/{slug}',[TourController::class,'tour'])->name('tour');
Route::get('/chi-tiet-tour/{slug}',[TourController::class,'detail_tour'])->name('detail-tour');
//admin
Route::get('/login',[AdminController::class,'admin_login'])->name('admin_login');
Route::get('/dashboard',[AdminController::class,'showdashboard'])->name('admin_dashboard');
Route::post('/admin-dashboard',[AdminController::class,'dashboard']);
Route::get('/login',[AdminController::class,'logoutdashboard']);
//Categories
Route::resource('categories',CategoriesController::class);
//Tours
Route::resource('tours',ToursController::class);
//Gallery
Route::resource('gallery',GalleryContronler::class);
//Blog
Route::resource('blogs',BlogController::class);






