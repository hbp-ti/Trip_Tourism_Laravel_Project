<?php

use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageUploadController;
use Illuminate\Support\Facades\Mail;

// Upload de imagens
Route::get('/upload', [ImageUploadController::class, 'showForm'])->name('upload.form');
Route::post('/upload', [ImageUploadController::class, 'handleUpload'])->name('upload.handle');
// Fim de upload de imagens

// Exemplo de página de upload de imagens, remover depois
Route::get('/exemploUpload', function () {
    return view('exemploUpload');
})->name("exemploUpload");

// Rotas com prefixo de idioma
Route::group(['prefix' => '{locale}', 'middleware' => 'setlocale'], function () {
    Route::get('/change-language/{new_locale}', [LanguageController::class, 'changeLanguage'])->name('language.change');
    // Página principal
    Route::get('/', function () {
        return view('homepage');
    })->name("homepage");

    // Rotas de autenticação
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

    // Outras rotas
    Route::get('/hotel', function () {
        return view('hoteldetails.hotel');
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
    })->name("payment1");

    Route::get('/payment2', function () {
        return view('payment.payment2');
    })->name("payment2");

    Route::get('/payment3', function () {
        return view('payment.payment3');
    })->name("payment3");

    Route::get('/tours', function () {
        return view('tours.tours');
    })->name("tours");

    Route::get('/hotels', function () {
        return view('hotel.hotel');
    })->name("hotels");

    Route::get('/tourDetail', function () {
        return view('tourDetail.tourDetail');
    })->name("tourDetail");

    Route::get('/tour', function () {
        return view('tour.tour');
    })->name("tour");
});
