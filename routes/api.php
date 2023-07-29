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
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

// Cart Routes
Route::group(['prefix' => 'cart', 'middleware' => 'auth:api'], function () {

    Route::post('/add/{product_id}', [CartController::class, 'addToCart']);
    Route::put('/update/{product_id}', [CartController::class, 'addToCart']);
    Route::delete('/remove/{product_id}', [CartController::class, 'addToCart']);
    Route::get('/', [CartController::class, 'addToCart']);
});



