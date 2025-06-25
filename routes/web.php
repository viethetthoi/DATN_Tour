<?php

use App\Http\Controllers\admin\BookingAdminController;
use App\Http\Controllers\admin\CouponAdminController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\PromotionAdminController;
use App\Http\Controllers\admin\TourAdminController;
use App\Http\Controllers\admin\UserAdminController;
use App\Http\Controllers\admin\InvoiceController;

use App\Http\Controllers\BookedTourController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FavouriteTourController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PayMentController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\ThuCOntroller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/',[HomeController::class, 'viewHomePage'])->name('homepage');
Route::get('/about',[HomeController::class, 'viewAboutPage'])->name('aboutpage');
Route::get('/listtour',[TourController::class, 'viewListTour'])->name('tourpage');
Route::get('/detailtour/{id}',[TourController::class, 'detailTour'])->name('detailtourpage');
Route::get('/tour/du-lich-{domain}',[TourController::class, 'regionalTours'])->name('regionalTours');
Route::post('/checkout/{id}',[PayMentController::class, 'checkOut'])->name('checkoutpage');
Route::get('/login',[UserController::class, 'viewLoginPage'])->name('loginpage');
Route::get('/signup',[UserController::class, 'viewSignUpPage'])->name('signuppage');
Route::get('/forgot',[UserController::class, 'viewForgotPage'])->name('forgotpage');
Route::post('/forgot',[UserController::class, 'forgot'])->name('forgot');
Route::post('/register',[UserController::class, 'register'])->name('register');
Route::post('/login',[UserController::class, 'login'])->name('user-login');
Route::get('/logout',[UserController::class, 'logout'])->name('logout');
Route::get('activate-account/{token}',[UserController::class, 'activateAccount'])->name('activate.account');
Route::get('/auth/google',[LoginGoogleController::class, 'redirectToGoogle'] )->name('login-google');
Route::get('/auth/google/callback',[LoginGoogleController::class, 'handleGoogleCallback'] );
Route::post('/listtour', [TourController::class, 'searchTour'])->name('search');
Route::post('/search-tour', [TourController::class, 'fillterTour'])->name('search.tour');
Route::get('/profile-user',[UserController::class, 'profileUser'])->name('profile.user');
Route::post('/profile-user',[UserController::class, 'updateProfileUser'])->name('update-profile-user');
Route::post('/password-profile-user', [UserController::class, 'passwordProfileUser'])->name('password-profile');
Route::post('/avatar-profile-user', [UserController::class, 'avatarProfileUser'])->name('avatar-profile');
Route::post('/submit-booking', [PayMentController::class, 'createBooking'])->name('create-booking');
Route::get('/booking', [PayMentController::class, 'handlePaymentMomoCallback'])->name('handlePaymentMomoCallback');
Route::post('/create-momo-payment', [PayMentController::class, 'createMomoPayment'])->name('createMomoPayment');
Route::get('/start-end-date/{tourId}', [TourController::class, 'startDate'])->name('startDate');
Route::get('/favourite-tour', [FavouriteTourController::class, 'showAllTour'])->name('show.favourite');
Route::get('/favourite-tour/{userId}/{tourId}/toggle-favourite', [FavouriteTourController::class, 'addFavourite'])->name('favourite-tour-submit');
Route::get('/my-tours', [BookedTourController::class, 'showListMyTour'])->name('my.tours');
Route::post('/review-tours', [BookedTourController::class, 'reviewTour'])->name('reviewtours');
Route::get('/list-review-tours', [TourController::class, 'listreview'])->name('listreview');
Route::post('/cancel-tour', [BookedTourController::class, 'cancelTour'])->name('tour.cancel');

//admin
Route::get('/admin/dashboard',[DashboardController::class, 'show'])->name('dashboardpage');
Route::get('/admin-login',[UserAdminController::class, 'viewLogin'])->name('admin-view-login');
Route::post('/admin-login',[UserAdminController::class, 'login'])->name('admin-login');

Route::get('/admin-logout',[UserAdminController::class, 'logout'])->name('admin-logout');
Route::get('/admin/add-tour',[TourAdminController::class, 'viewAddTour'])->name('admin-page-add-tour');
Route::post('/admin/add-tour',[TourAdminController::class, 'addTour'])->name('admin-add-tour');

Route::get('/admin/delete-tour/{tourId}',[TourAdminController::class, 'deleteTour'])->name('admin-delete-tour');


Route::post('/admin/add-image-tour',[TourAdminController::class, 'addImageTour'])->name('admin-add-image-tour');
Route::post('/admin/add-timeline-tour',[TourAdminController::class, 'addTimeLineTour'])->name('admin-add-timeline-tour');
Route::post('/admin/add-date-tour',[TourAdminController::class, 'addDateTour'])->name('admin-add-date-tour');

Route::get('/admin/list-tour',[TourAdminController::class, 'viewListTour'])->name('admin-list-tour');

Route::get('/admin/edit-tour/{tourId}',[TourAdminController::class, 'viewEditTour'])->name('admin-edit-tour');
Route::post('/admin/edit-tour/{tourId}',[TourAdminController::class, 'editTour'])->name('admin-edit-submit-tour');

Route::get('/admin/edit-image-tour/{tourId}',[TourAdminController::class, 'viewEditImageTour'])->name('admin-edit-image-tour');
Route::post('/admin/edit-image-tour/{tourId}',[TourAdminController::class, 'editImageTour'])->name('admin-edit-submit-image-tour');

Route::get('/admin/edit-timeline-tour/{tourId}',[TourAdminController::class, 'viewEditTimeLineTour'])->name('admin-edit-timeline-tour');
Route::post('/admin/edit-timeline-tour/{tourId}',[TourAdminController::class, 'editTimeLineTour'])->name('admin-edit-submit-timeline-tour');

Route::get('/admin/edit-date-tour/{tourId}',[TourAdminController::class, 'viewEditDateTour'])->name('admin-edit-date-tour');
Route::post('/admin/edit-date-tour/{tourId}',[TourAdminController::class, 'editDateTour'])->name('admin-edit-submit-date-tour');

Route::get('/admin/list-user',[UserAdminController::class, 'viewListUser'])->name('admin-list-user');
Route::get('/admin/list-user/{userId}-{status}',[UserAdminController::class, 'updateStatustUser'])->name('admin-list-user-status');

Route::get('/admin/list-booking',[BookingAdminController::class, 'viewListBooking'])->name('admin-list-booking');
Route::get('/admin/list-booking/{bookingId}-{status}',[BookingAdminController::class, 'updateStatustPayment'])->name('admin-list-booking-payment');
Route::post('/admin/list-booking/status',[BookingAdminController::class, 'updateStatustBooking'])->name('admin-list-booking-status');

Route::get('/admin/list-promotion',[PromotionAdminController::class, 'viewListPromotion'])->name('admin-list-promotion');
Route::get('/admin/add-promotion',[PromotionAdminController::class, 'viewAddPromotion'])->name('admin-add-promotion');
Route::post('/admin/add-promotion',[PromotionAdminController::class, 'addPromotion'])->name('admin-add-submit-promotion');

Route::get('/admin/add-tour-promotion',[PromotionAdminController::class, 'viewAddTourPromotion'])->name('admin-add-tour-promotion');
Route::post('/admin/add-tour-promotion',[PromotionAdminController::class, 'addTourPromotion'])->name('admin-add-submit-tour-promotion');

Route::get('/admin/edit-promotion/{promotionId}',[PromotionAdminController::class, 'viewEditPromotion'])->name('admin-edit-promotion');
Route::post('/admin/edit-promotion/{promotionId}',[PromotionAdminController::class, 'editPromotion'])->name('admin-edit-submit-promotion');

Route::get('/admin/edit-tour-promotion/{promotionId}',[PromotionAdminController::class, 'viewEditTourPromotion'])->name('admin-edit-tour-promotion');
Route::post('/admin/edit-tour-promotion/{promotionId}',[PromotionAdminController::class, 'editTourPromotion'])->name('admin-edit-submit-tour-promotion');

Route::get('/admin/list-promotion/{promotionId}-{status}',[PromotionAdminController::class, 'updateStatusPromotion'])->name('admin-list-promotion-status');

Route::get('/admin/dashboard/annualRevenue',[DashboardController::class, 'annualRevenue'])->name('admin.dashboard.annualRevenue');

Route::get('/admin/list-coupon',[CouponAdminController::class, 'viewListCoupon'])->name('admin-list-coupon');
Route::get('/admin/list-coupon/{status}-{couponId}',[CouponAdminController::class, 'editStatusCoupon'])->name('admin-edit-status-coupon');
Route::get('/admin/add-coupon',[CouponAdminController::class, 'viewAddCoupon'])->name('admin-add-coupon');
Route::post('/admin/add-coupon',[CouponAdminController::class, 'addCoupon'])->name('admin-add-submit-coupon');
Route::get('/admin/edit-coupon/{couponId}',[CouponAdminController::class, 'viewEditCoupon'])->name('admin-edit-coupon');
Route::post('/admin/edit-coupon/{couponId}',[CouponAdminController::class, 'editCoupon'])->name('admin-edit-submit-coupon');

Route::get('/admin/email-{bookingId}',[InvoiceController::class, 'receiveEmail'])->name('admin-email');


Route::get('users/invoice', function () {
    return view('admin.email.invoice');
});