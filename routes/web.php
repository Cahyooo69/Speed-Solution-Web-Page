<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScrapeController;
use App\Http\Controllers\LandingController;

// Landing page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Auth routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register')->name('register.post');
    Route::post('/logout', 'logout')->name('logout');
});

// Public pages
Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/promo', 'promo')->name('promo');
Route::view('/outlet', 'outlet')->name('outlet');
Route::view('/produk', 'produk')->name('produk');

// Scrape route
Route::get('/scrape', [ScrapeController::class, 'scrape'])->name('scrape');

Route::get('/produk', [LandingController::class, 'showProduk'])->name('produk');
