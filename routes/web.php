<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login',[\App\Http\Controllers\User\AuthController::class,'index'])->name('index.login');

Route::get('auth/google',[\App\Http\Controllers\User\AuthController::class,'redirect'])->name('google-auth');
Route::get('auth/google/callback',[\App\Http\Controllers\User\AuthController::class,'callbackGoogle'])->name('google-auth');

Route::get('payment', [\App\Http\Controllers\Payment\PayPalController::class,'handlePayment'])->name('payment');
Route::get('payment/success', [\App\Http\Controllers\Payment\PayPalController::class,'paymentSuccess'])->name('payment.success');
Route::get('payment/cancel', [\App\Http\Controllers\Payment\PayPalController::class,'paymentCancel'])->name('payment.cancel');

// Route::get('auth/facebook',[\App\Http\Controllers\User\AuthController::class,'redirectFacebook'])->name('facebook-auth');
// Route::get('auth/facebook/callback',[\App\Http\Controllers\User\AuthController::class,'callbackFacebook'])->name('facebook-auth');