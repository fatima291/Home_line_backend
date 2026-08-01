<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminBookingController;
use App\Http\Controllers\Api\AdminServiceController;
use App\Http\Controllers\Api\AdminCustomerController;

// عام
Route::get('/services', [ServiceController::class, 'index']);

// العملاء
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/me', [AuthController::class, 'updateProfile']);
    Route::post('/me/avatar', [AuthController::class, 'uploadAvatar']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::post('/bookings/{id}/pay', [PaymentController::class, 'pay']);
    Route::get('/my-bookings', [BookingController::class, 'myBookings']);
    Route::put('/bookings/{id}', [BookingController::class, 'update']);
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel']);
});

// الإدمن
Route::post('/admin/register', [AdminAuthController::class, 'register']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::get('/me', [AdminAuthController::class, 'me']);

    Route::get('/bookings', [AdminBookingController::class, 'index']);
    Route::put('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus']);

    Route::post('/services', [AdminServiceController::class, 'store']);
    Route::put('/services/{id}', [AdminServiceController::class, 'update']);
    Route::delete('/services/{id}', [AdminServiceController::class, 'destroy']);

    Route::get('/customers', [AdminCustomerController::class, 'index']);
});