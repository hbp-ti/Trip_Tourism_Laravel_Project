<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
})->name("homepage");

Route::get('/login', function () {
    return view('login.login');
})->name("login");

Route::get('/register', function () {
    return view('register.register');
})->name("register");

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