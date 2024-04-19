<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login',[\App\Http\Controllers\User\AuthController::class,'index'])->name('index.login');
Route::post('logout',[\App\Http\Controllers\User\AuthController::class,'logout'])->name('logout');

Route::get('auth/google',[\App\Http\Controllers\User\AuthController::class,'redirect'])->name('google-auth');
Route::get('auth/google/callback',[\App\Http\Controllers\User\AuthController::class,'callbackGoogle'])->name('google-auth');

Route::get('payment', function() {
    if (!Auth::check()) {
        // Lưu thông tin vào session trước khi chuyển hướng
        session(['redirect_to_payment' => true, 'payment_info' => ['name' => 'turtle', 'price' => 10]]);
        return redirect()->route('google-auth');
    }
    $paymentInfo = session('payment_info', ['name' => null, 'price' => null]);
    return app(\App\Http\Controllers\Payment\PayPalController::class)->handlePayment(new Illuminate\Http\Request($paymentInfo));
})->name('payment');
Route::get('payment/success', [\App\Http\Controllers\Payment\PayPalController::class,'paymentSuccess'])->name('payment.success');
Route::get('payment/cancel', [\App\Http\Controllers\Payment\PayPalController::class,'paymentCancel'])->name('payment.cancel');

// Route::get('auth/facebook',[\App\Http\Controllers\User\AuthController::class,'redirectFacebook'])->name('facebook-auth');
// Route::get('auth/facebook/callback',[\App\Http\Controllers\User\AuthController::class,'callbackFacebook'])->name('facebook-auth');