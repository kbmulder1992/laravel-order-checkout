<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('cart', [CartController::class, 'show'])->name('cart.view');
Route::post('cart/{product:id}/add-item', [CartController::class, 'addItem'])->name('cart.add_item');
Route::post('cart/{product:id}/remove-item', [CartController::class, 'removeItem'])->name('cart.remove_item');
Route::post('cart/{coupon:id}/apply', [CartController::class, 'applyCoupon'])->name('cart.apply_coupon');
Route::post('cart/complete', [CartController::class, 'completeCheckout'])->name('cart.complete_checkout');

Route::post('login', [ApiAuthController::class, 'login'])->name('login.api');
Route::post('register',[ApiAuthController::class, 'register'])->name('register.api');
Route::post('logout', [ApiAuthController::class, 'logout'])->name('logout.api');
