<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('register', [RegisterController::class, 'register']);
Route::post('resend-verification-email', [RegisterController::class, 'resendVerificationEmail']);
Route::post('email-verification/{token}', [RegisterController::class, 'verifyEmail']);

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);
