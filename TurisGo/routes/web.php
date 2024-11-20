<?php

use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('homepage');
})->name("homepage");



Route::prefix('auth')->name('auth.')->group(function() {
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('forgot', [AuthController::class, 'showForgotForm'])->name('forgot.form');
    Route::post('forgot', [AuthController::class, 'sendResetLink'])->name('forgot.submit');
    Route::get('reset/{token}', [AuthController::class, 'showResetForm'])->name('reset.form');
    Route::post('reset', [AuthController::class, 'resetPassword'])->name('reset.submit');
});


Route::get('/password/forgot', function () {
    return view('password.forgot');
})->name("forgotPass");

Route::get('/password/reset', function () {
    return view('password.reset');
})->name("resetPass");

Route::get('/about', function () {
    return view('aboutUs.aboutUs');
})->name("aboutUs");

Route::get('/contact', function () {
    return view('contact.contact');
})->name("contact");

Route::get('/profile', function () {
    return view('profile.profile');
})->name("profile");

Route::get('/cart', function () {
    return view('cart.cart');
})->name("profile");

Route::get('/payment1', function () {
    return view('payment.payment');
})->name("Payment 1");

Route::get('/cart', function () {
    return view('cart.cart');
})->name("profile");

Route::get('/tours', function () {
    return view('tours.tours');
})->name("tours");

Route::get('/change-language/{locale}', [LanguageController::class, 'changeLanguage'])->name('language.change');
