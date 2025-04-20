<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SuccessController;
use App\Http\Controllers\Admin\DashboardController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // User routes
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
    // Booking routes
    Route::get('/booking', function () {
        return view('booking');
    })->name('booking');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

route::get('details' , [DetailsController::class, 'index']);
route::get('checkout' , [CheckoutController::class, 'index']);
route::get('succes' , [SuccessController::class, 'index']);