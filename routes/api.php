<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\StoreController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResources([
    'users' => UserController::class,
    'stores' => StoreController::class,
    'products' => ProductController::class,
    'orders' => OrderController::class,
]);

Route::put('orders/{id}/cancel', [OrderController::class, 'cancel']);
Route::delete('delete-orders', [OrderController::class, 'deleteAllOrders']);
