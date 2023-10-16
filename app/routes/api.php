<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use \App\Http\Controllers\CartController;


// Login / Registration Routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// Some Authentication Routes
Route::middleware('auth:api')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('user', [AuthController::class, 'user']);

});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{product_id}', [ProductController::class, 'show']);
});

// Cart Routes
Route::group(['prefix' => 'cart', 'middleware' => 'auth:api'], function () {

    Route::post('/add/{product_id}', [CartController::class, 'addToCart']);
    Route::put('/update/{product_id}', [CartController::class, 'updateCartItem']);
    Route::delete('/remove/{product_id}', [CartController::class, 'removeFromCart']);
    Route::get('/', [CartController::class, 'getCartItems']);
});

