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

Route::get('payment/{name}/{price}', function($name,$price) {
    if (!Auth::check()) {
        session(['redirect_to_payment' => true, 'payment_info' => ['name' => $name, 'price' => $price]]);
        return redirect()->route('google-auth');
    }
    $paymentInfo = session('payment_info', ['name' => $name, 'price' => $price]);
    return app(\App\Http\Controllers\Payment\PayPalController::class)->handlePayment(new Illuminate\Http\Request($paymentInfo));
})->name('payment');
Route::get('payment/success', [\App\Http\Controllers\Payment\PayPalController::class,'paymentSuccess'])->name('payment.success');
Route::get('payment/cancel', [\App\Http\Controllers\Payment\PayPalController::class,'paymentCancel'])->name('payment.cancel');

// Route::get('auth/facebook',[\App\Http\Controllers\User\AuthController::class,'redirectFacebook'])->name('facebook-auth');
// Route::get('auth/facebook/callback',[\App\Http\Controllers\User\AuthController::class,'callbackFacebook'])->name('facebook-auth');

Route::prefix('admin')->group(function(){
    Route::get('login',[\App\Http\Controllers\Admin\AuthController::class,'index'])->name('admin.index.login');
    Route::post('login',[\App\Http\Controllers\Admin\AuthController::class,'login'])->name('admin.login');
    Route::middleware('admin')->group(function() {
        Route::get('dashboard',[\App\Http\Controllers\Admin\DashboardController::class,'index'])->name('admin.dashboard');
        Route::post('logout',[\App\Http\Controllers\Admin\AuthController::class,'logout'])->name('admin.logout');
    });
});
Route::prefix('client')->group(function(){
    Route::get('dashboard',[\App\Http\Controllers\User\DashboardController::class,'index'])->name('user.dashboard');
});