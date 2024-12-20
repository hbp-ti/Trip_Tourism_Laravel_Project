<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
//Route::get('/upload', [ImageUploadController::class, 'showForm'])->name('upload.form');


//novo controlador de imagens
//é preciso meter FILESYSTEM_DISK=public no .env e fazer php artisan storage:link
use App\Http\Controllers\ImageController;

Route::post('/uploadImage', [ImageController::class, 'upload']);

Route::get('/imagem', function () {
    return view('imagem');
})->name("imagem");


Route::get('/exemploUpload', function () {
    return view('exemploUpload');
})->name("exemploUpload");

Route::get('/', function () {
    return redirect()->route('homepage', ['locale' => 'en']);
});


Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'showNotifications'])->name('notifications');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'updateNotification'])->name('update.notification');
    Route::delete('/notifications/{id}', [NotificationController::class, 'deleteNotification'])->name('delete.notification');
    Route::delete('/notification/delete-all', [NotificationController::class, 'deleteAllNotifications'])->name('delete.notifications');
});


Route::group(['prefix' => '{locale}', 'middleware' => 'setlocale'], function () {

    Route::get('/', function () {
        return view('homepage');
    })->name("homepage");
    Route::post('/upload', [ImageUploadController::class, 'handleUpload'])->name('upload.handle');
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
            Route::post('/profileUpdate', [AuthController::class, 'updateProfile'])->name('profile.update');
            Route::post('/profile/update-picture', [AuthController::class, 'updateProfilePicture'])->name('profile.update.picture');
            Route::post('/passwordUpdate', [AuthController::class, 'updatePassword'])->name('profile.updatePassword');
            Route::get('/cart', [AuthController::class, 'showCart'])->name('cart.show');
            Route::post('/cart/{itemId}/add', [AuthController::class, 'addToCart'])->name('cart.add');
            Route::delete('/cart/{cartItem}/remove', [AuthController::class, 'removeFromCart'])->name('cart.remove');
            Route::post('/review/{item_id}/add', [ReviewController::class, 'addReview'])->name('reviews.add');
            // Página principal de compra de tickets
            Route::get('/buyTicketTrain', [TrainController::class, 'stations'])->name('tickets');
            Route::post('/payment', [PaymentController::class, 'paymentPhases'])->name('payment');
        });
    });
    Route::get('/hotels', [HotelController::class, 'showHotels'])->name('hotels');
    Route::get('/hotel/{id}', [HotelController::class, 'showHotelDetails'])->name('hotel.hotel');
    Route::get('/tours', [TourController::class, 'showTours'])->name('tours');
    Route::get('/tour/{id}', [TourController::class, 'showTourDetails'])->name('tour.tour');



    Route::get('/tour', function () {
        return view('tour.tour');
    })->name("tour");

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

    // Buscar jornadas
    Route::post('/search-journeys', [TrainController::class, 'journeys'])->name('search.journeys');

    Route::get('/tourDetail', function () {
        return view('tourDetail.tourDetail');
    })->name("tourDetail");

    Route::get('/hotelDetail', function () {
        return view('hotelDetail.hotelDetail');
    })->name("hotelDetail");
});
