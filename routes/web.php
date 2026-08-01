<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/api/verify-email/{token}', [AuthController::class, 'verifyEmail']);

