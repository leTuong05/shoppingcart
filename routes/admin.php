<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PrintController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('post_login');
    Route::get('/logout', [AuthController::class, 'logOut'])->name('logout');

    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::get('/products', [ProductController::class, 'index'])->name('product');
        Route::get('/delete-product/{id}', [ProductController::class, 'delete'])->name('delete_product');
        Route::get('/edit-product/{id}', [ProductController::class, 'showEditForm'])->name('edit_product');
        Route::get('/create-form-product', [ProductController::class, 'showCreateForm'])->name('create_form_product');
        Route::post('/create-product', [ProductController::class, 'create'])->name('create_product');
        Route::post('/update-product/{id}', [ProductController::class, 'update'])->name('update_product');
        Route::get('/search-product', [ProductController::class, 'search'])->name('search_product');


        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function() {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::post('/store', [CategoryController::class, 'store'])->name('store');
            Route::post('/update', [CategoryController::class, 'update'])->name('update');
            Route::post('/delete', [CategoryController::class, 'delete'])->name('delete');
        });
    
        Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function() {
            Route::get('/', [ContactController::class, 'index'])->name('index');
            Route::post('/store', [ContactController::class, 'store'])->name('store');
            Route::post('/update', [ContactController::class, 'update'])->name('update');
            Route::post('/delete', [ContactController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'slides', 'as' => 'slides.'], function(){
            Route::get('/', [SlideController::class, 'index'])->name('index');
            Route::post('/store', [SlideController::class, 'store'])->name('store');
            Route::post('/delete', [SlideController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'users', 'as' => 'users.'], function() {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/delete', [UserController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function() {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/order-deatail/{id}', [OrderController::class, 'orderDetail'])->name('cart_detail');
            Route::post('/delete', [OrderController::class, 'delete'])->name('delete');
            Route::post('/confirm', [OrderController::class, 'confirm'])->name('confirm');
            Route::get('/print/{id}', [PrintController::class, 'print'])->name('print');
        });

        Route::get('/bao-cao',[OrderController::class,'baoCao'])->name('baocao');
    });
});
