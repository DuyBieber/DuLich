<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\GalleryContronler;
use App\Http\Controllers\ToursController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\TourTypeController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\TourPriceDetailController;
use App\Http\Controllers\DepartureDateController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;

//trang chu
Route::get('/trang-chu',[HomeController::class,'index'])->name('home');
Route::get('/booking',[BookingController::class,'index']);

Route::get('/chi-tiet-tour/{slug}',[ToursController::class,'detail_tour'])->name('detail-tour');


//admin
Route::get('/login_admin',[AdminController::class,'admin_login'])->name('admin_login');

Route::get('/dashboard',[AdminController::class,'showdashboard'])->name('admin_dashboard');
Route::post('/admin-dashboard',[AdminController::class,'dashboard']);
Route::get('/login_admin',[AdminController::class,'logoutdashboard'])->name('login_admin');
//Categories
Route::resource('categories',CategoriesController::class);
Route::get('/tour/{slug}', [ToursController::class, 'showByCategory'])->name('tour');
Route::get('/tour/type/{slug}', [ToursController::class, 'showByTourType'])->name('tour.type');
Route::get('/tour-theo-danh-muc/{slug}', [ToursController::class, 'showByCategory'])->name('tour.by.category');

//TourType
Route::resource('tour_types',TourTypeController::class);
//Tours

//Gallery
Route::resource('gallery',GalleryContronler::class);
//Blog
Route::resource('blogs',BlogController::class);

//Itinre
Route::resource('itineraries', ItineraryController::class);
//slider
Route::resource('sliders', SliderController::class);
//customer
Route::resource('customers',CustomerController::class);
//fronend
Route::resource('locations', LocationController::class);
//
Route::resource('bookings', BookingController::class);
Route::post('/bookings/{id}/confirm', [BookingController::class, 'confirmStatus'])->name('bookings.confirm');
Route::post('/add-checkout-booking-ajax', [BookingController::class, 'addCheckoutBookingAjax']);
Route::post('/add-checkout-booking-other-ajax', [BookingController::class, 'addCheckoutBookingOtherAjax'])->name('booking.addOther');

Route::get('/show-checkout-booking/fixed/{id}', [BookingController::class, 'showCheckoutFixedBooking'])->name('booking.fixed');
Route::get('/show-checkout-booking/other/{tourId}/{departureDateId}', [BookingController::class, 'showCheckoutOtherBooking'])->name('booking.other');

Route::resource('tour_price_details', TourPriceDetailController::class);


Route::resource('departure-dates', DepartureDateController::class);

Route::get('/login', [CustomerController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerController::class, 'login'])->name('customer.login');

Route::get('/register', [CustomerController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [CustomerController::class, 'store'])->name('customer.store');

// Đăng xuất
Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');


Route::get('/api/departure-dates/{tourId}', [DepartureDateController::class, 'getDepartureDates']);



Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
//coupon
Route::resource('coupons',CouponController::class);
Route::post('/check-coupon', [CouponController::class, 'checkCoupon'])->name('check.coupon');
Route::get('/payment/{id}', [BookingController::class, 'showPaymentPage'])->name('payment.show');
//cong thanh toan
Route::post('/vnpay_payment',[BookingController::class,'vnpayPayment'])->name('vnpay.payment');

Route::put('/payment/update', [BookingController::class, 'updatePayment'])->name('payment.update');
Route::get('/payment_success', [BookingController::class, 'PaymentSuccessVNpay'])->name('payment.success');
Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
Route::post('/momo_payment',[BookingController::class,'momoPayment'])->name('momo.payment');
Route::post('/payments/{id}/update-status', [PaymentController::class, 'updatePaymentStatus'])->name('payments.updateStatus');
Route::get('/my-bookings', [BookingController::class,'myBookings'])->name('my.bookings');
Route::get('/booking-detail/{id}',[BookingController::class,'bookingDetail'])->name('booking.detail');
Route::get('/tours/location/{id}', [ToursController::class, 'getToursByLocation'])->name('tours.location');

Route::get('/tours/search', [ToursController::class, 'search'])->name('tours.search');


Route::resource('tours', ToursController::class)->except(['show']);
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::delete('/booking/cancel/{id}', [BookingController::class, 'cancelBooking'])->name('booking.cancel');
Route::get('/customer/profile', [CustomerController::class, 'showProfile'])->name('customer.profile');
Route::get('/customer/profile/edit', [CustomerController::class, 'editProfile'])->name('customer.profile.edit');
Route::post('/customer/profile/update', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::put('/edit-comment/{id}', [ReviewController::class, 'update'])->name('review.update');
Route::delete('/delete-comment/{id}', [ReviewController::class, 'destroy'])->name('review.delete');
Route::delete('/reviews/admin/{id}', [ReviewController::class, 'destroyForAdmin'])->name('reviews.destroy.admin');


Route::post('/reviews/{id}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');
Route::get('/admin/statistics', [AdminController::class, 'getStatistics'])->name('admin.statistics');
Route::get('/get-tour-types/{categoryId}', [ToursController::class, 'getTourTypesByCategory']);
Route::get('/admin/bookings-by-date', [AdminController::class, 'getBookingsByDate']);
Route::get('/admin/bookings/export', [AdminController::class, 'exportBookings'])->name('bookings.export');
Route::get('/customer/coupons', [CustomerController::class, 'showCouponsForCustomer'])->name('customer.coupons');
Route::post('/customer/add-coupon/{coupon}', [CouponController::class, 'assignCouponToCustomer'])->name('customer.add-coupon');

Route::get('/customer/wallet', [CustomerController::class, 'showWallet'])->name('customer.wallet');
Route::post('/customer/redeem-coupon/{couponId}', [CustomerController::class, 'redeemCoupon']);
Route::post('/customer/delete-coupon/{id}', [CustomerController::class, 'deleteCoupon'])->name('customer.delete.coupon');
Route::post('/check-duplicate-booking', [BookingController::class, 'checkDuplicateBooking']);
Route::get('/get-price-details', [DepartureDateController::class, 'getPriceDetails'])->name('getPriceDetails');
//Quên mật khẩu của khách hàng
// Hiển thị form nhập email để yêu cầu đặt lại mật khẩu
Route::get('/forgot-password', [CustomerController::class, 'showForgotPasswordForm'])->name('customer.forgotPasswordForm');

// Xử lý gửi liên kết đặt lại mật khẩu
Route::post('/forgot-password', [CustomerController::class, 'sendResetLink'])->name('customer.sendResetLink');

// Hiển thị form đặt lại mật khẩu với token
Route::get('/reset-password/{token}', [CustomerController::class, 'resetPassword'])->name('customer.resetPasswordForm');

// Lưu mật khẩu mới
Route::post('/reset-password', [CustomerController::class, 'saveNewPassword'])->name('customer.saveNewPassword');


Route::post('/apply-coupon', [BookingController::class, 'applyCoupon'])->name('payment.applyCoupon');
Route::post('/admin/cancel-booking/{id}', [BookingController::class, 'cancelBookingByAdmin'])->name('admin.cancelBooking');
Route::get('/checkout/{id}', [BookingController::class, 'checkout'])->name('booking.checkout');
Route::get('/admin/profile', [AdminController::class, 'showProfileAdmin'])->name('profile_admin');
Route::get('/admin/profile/edit', [AdminController::class, 'editProfileAdmin'])->name('admin.profile.edit');
Route::post('/admin/profile/update', [AdminController::class, 'updateProfileAdmin'])->name('admin.profile.update');
Route::get('/forgot-password-admin', [AdminController::class, 'showForgotPasswordFormAdmin'])->name('admin.forgotPasswordForm');

// Xử lý gửi liên kết đặt lại mật khẩu
Route::post('/forgot-password-admin', [AdminController::class, 'sendResetLinkAdmin'])->name('admin.sendResetLink');

// Hiển thị form đặt lại mật khẩu với token
Route::get('/reset-password-admin/{token}', [AdminController::class, 'resetPasswordAdmin'])->name('admin.resetPasswordForm');

// Lưu mật khẩu mới
Route::post('/reset-password-admin', [AdminController::class, 'saveNewPasswordAdmin'])->name('admin.saveNewPassword');