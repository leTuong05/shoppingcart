<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\Shopping\AccountController;
use App\Http\Controllers\Shopping\HomeController;
use App\Http\Controllers\Shopping\HomeController as ShoppingHomeController;
use App\Http\Controllers\Shopping\LocationController;
use App\Http\Controllers\Shopping\PaymentController;
use App\Http\Controllers\Shopping\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['as' => 'shopping.'], function() {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/blog-list', [HomeController::class, 'blogList'])->name('blog_list');
    Route::get('/blog-single', [HomeController::class, 'blogSingle'])->name('blog_single');

    Route::group(['prefix' => 'products', 'as' =>'products.'], function(){
        Route::get('/{product:slug}', [HomeController::class, 'productDetails'])->name('productDetails');
    });
    Route::get('/login', [HomeController::class, 'Login'])->name('login');
    Route::get('/contact', [HomeController::class, 'ContactUs'])->name('contact');
    Route::get('/logout', [AuthController::class, 'logOut'])->name('logout');
    Route::post('/login', [AuthController::class, 'logIn'])->name('login_post');

    Route::get('/login-fb', [FacebookController::class, 'loginFacebook'])->name('login_fb');
    Route::get('/callback', [FaceBookController::class, 'callbackFromFacebook'])->name('callback');

    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/register/verify/{code}', [AuthController::class, 'verify'])->name('verify');
    
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/checkout', [HomeController::class, 'Checkout'])->name('checkout');
        Route::get('/cart', [HomeController::class, 'Cart'])->name('cart');
        
        Route::group(['prefix' => 'favorites', 'as' => 'favorites.'], function(){
            Route::post('/store', [WishlistController::class, 'addToFavorite'])->name('addToFavorite');
            Route::post('/delete', [WishlistController::class, 'removeFromFavorite'])->name('removeFromFavorite');
        });

        Route::get('/add-to-cart/{id}', [HomeController::class,'addToCart'])->name('add_to_cart');
        Route::patch('update-cart', [HomeController::class, 'update'])->name('update_cart');
        Route::delete('remove-from-cart', [HomeController::class, 'remove'])->name('remove_from_cart');
        
        Route::post('/districts', [LocationController::class, 'getDistricts'])->name('getDistricts');
        Route::post('/wards', [LocationController::class, 'getWards'])->name('getWards');
        
        Route::group(['prefix' => 'payments', 'as' => 'payments.'], function() {
            Route::post('/cod', [PaymentController::class, 'cod'])->name('cod');
            Route::post('/online', [PaymentController::class, 'create'])->name('vnpaycreate');
            Route::get('/online/vnpayreturn', [PaymentController::class, 'return'])->name('vnpayreturn');
        });

        Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function() {
            Route::get('/', [AccountController::class, 'index'])->name('index');
            Route::post('/update', [AccountController::class, 'update'])->name('update');
        });
    });

});
