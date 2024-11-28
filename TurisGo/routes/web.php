<?php

use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageUploadController;
use Illuminate\Support\Facades\Mail;

//upload de imagens
Route::get('/upload', [ImageUploadController::class, 'showForm'])->name('upload.form');

Route::post('/upload', [ImageUploadController::class, 'handleUpload'])->name('upload.handle');
//fim de upload de imagens

//exemplo de página de upload de imagens, remover depois
Route::get('/exemploUpload', function () {
    return view('exemploUpload');
})->name("exemploUpload");




Route::get('/', function () {
    return view('homepage');
})->name("homepage");

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('forgot', [AuthController::class, 'showForgotForm'])->name('forgot.form');
    Route::post('forgot', [AuthController::class, 'sendResetLink'])->name('forgot.submit');
    Route::get('reset/{token}/{email}', [AuthController::class, 'showResetForm'])->name('reset.form');
    Route::post('reset', [AuthController::class, 'resetPassword'])->name('reset.submit');
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.show');
        Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
        Route::get('/cart', [AuthController::class, 'showCart'])->name('cart.show');
        Route::post('/cart/{itemId}/add', [AuthController::class, 'addToCart'])->name('cart.add');
        Route::delete('/cart/{cartItemId}/remove', [AuthController::class, 'removeFromCart'])->name('cart.remove');
    });
});

Route::get('/hotel', function () {
    return view('hotelDetails.hotel');
})->name("hotel");

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

Route::get('/buyTicketTrain', function () {
    return view('buyTicketTrain.buyTicketTrain');
})->name("buyTicketTrain");


Route::get('/payment1', function () {
    return view('payment.payment1');
})->name("Payment 1");


Route::get('/tours', function () {
    return view('tours.tours');
})->name("tours");

Route::get('/tourDetail', function () {
    return view('tourDetail.tourDetail');
})->name("tourDetail");

Route::get('/change-language/{locale}', [LanguageController::class, 'changeLanguage'])->name('language.change');
