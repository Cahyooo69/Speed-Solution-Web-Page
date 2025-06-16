<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ChatController;

// Public pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/outlet', [OutletController::class, 'index'])->name('outlet');
Route::get('/promo', [PromoController::class, 'index'])->name('promo');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');
Route::get('/produk', [ProductController::class, 'index'])->name('produk');

// Authentication routes - hanya untuk guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// Logout route - hanya untuk authenticated user
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// API routes untuk Vue.js
Route::prefix('api')->group(function () {
    // Public API routes
    Route::get('/outlets', [OutletController::class, 'apiOutlets']);
    Route::get('/outlets/{region}', [OutletController::class, 'getOutletsByRegion']);
    Route::post('/outlets/nearest', [OutletController::class, 'findNearestOutlet']);
    
    Route::get('/products', [ProductController::class, 'apiProducts']);
    Route::get('/products/categories', [ProductController::class, 'getCategories']);
    Route::get('/products/analyze', [ProductController::class, 'analyzeCategories']);
    
    Route::get('/promo', [PromoController::class, 'apiPromo']);
    Route::get('/promo/active', [PromoController::class, 'getActivePromos']);
    Route::get('/tentang', [TentangController::class, 'apiTentang']);
    Route::get('/home/services', [HomeController::class, 'apiServices']);
    Route::get('/home/testimonials', [HomeController::class, 'apiTestimonials']);
    
    // Authentication API routes
    Route::get('/auth/check', [LoginController::class, 'checkAuth']);
    Route::get('/login', [LoginController::class, 'apiLogin']);
    Route::post('/login', [LoginController::class, 'apiLoginSubmit']);
    Route::get('/register', [RegisterController::class, 'apiRegister']);
    Route::post('/register', [RegisterController::class, 'apiRegisterSubmit']);
    
    // Logout API route - untuk axios call
    Route::post('/logout', [LoginController::class, 'logout']);
    
    // Protected API routes
    Route::middleware('auth')->group(function () {
        Route::delete('/products/cache', [ProductController::class, 'clearCache']);
        Route::get('/register/stats', [RegisterController::class, 'getStats']);
    });
    
    // Public chat routes
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::get('/chat/session', [ChatController::class, 'generateSessionId']);
    Route::get('/chat/user-session', [ChatController::class, 'getUserChatSession']);
    Route::get('/chat/user-history', [ChatController::class, 'getUserChatHistory']);
    Route::get('/chat/session/{sessionId}/messages', [ChatController::class, 'getUserMessages']);
    
    // Admin chat routes (protected)
    Route::middleware('admin')->prefix('admin/chat')->group(function () {
        Route::get('/sessions', [ChatController::class, 'getAdminSessions']);
        Route::get('/sessions/{sessionId}/messages', [ChatController::class, 'getSessionMessages']);
        Route::post('/reply', [ChatController::class, 'sendReply']);
    });
});

// Admin chat page (protected)
Route::middleware('admin')->group(function () {
    Route::get('/admin/chat', [ChatController::class, 'adminIndex'])->name('admin.chat');
    Route::get('/admin/dashboard', [ChatController::class, 'adminIndex'])->name('admin.dashboard');
});

// Test route for chat
Route::get('/chat-test', function () {
    return view('chat-test');
});

// Simple chat test route
Route::get('/simple-chat-test', function () {
    return view('simple-chat-test');
});

// Debug chat test route
Route::get('/debug-chat', function () {
    return view('debug-chat');
});

// Chat debug route
Route::get('/chat-debug', function () {
    return view('chat-debug');
});

// Chat history test route
Route::get('/chat-history-test', function () {
    return view('chat-history-test');
});

// Admin reply test route
Route::get('/admin-reply-test', function () {
    return view('admin-reply-test');
});

// User chat test route
Route::get('/user-chat-test', function () {
    return view('user-chat-test');
});