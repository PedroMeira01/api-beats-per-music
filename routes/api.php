<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\StoreController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::get('hello-world', function () {
    echo "Hello World";
});

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::controller(UserController::class)->group(function() {
	Route::post('/users', 'store');
});

Route::middleware('auth:sanctum')->group(function() {
	Route::controller(StoreController::class)->group(function() {
		Route::get('/stores', 'index');
		Route::post('/stores', 'store');
	});

	Route::controller(ProductController::class)->group(function() {
		Route::post('/products', 'store');
	});

	Route::controller(OrderController::class)->group(function() {
		Route::post('/orders', 'store');
	});
});


