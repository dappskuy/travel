<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SuccessController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TravelController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;

// Public routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

    // New booking routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{packageId}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Travel Categories Routes
    Route::get('/categories', [TravelController::class, 'categories'])->name('categories');
    Route::get('/categories/create', [TravelController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [TravelController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{id}/edit', [TravelController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{id}', [TravelController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [TravelController::class, 'deleteCategory'])->name('categories.delete');

    // Travel Packages Routes
    Route::get('/packages', [TravelController::class, 'packages'])->name('packages');
    Route::get('/packages/create', [TravelController::class, 'createPackage'])->name('packages.create');
    Route::post('/packages', [TravelController::class, 'storePackage'])->name('packages.store');
    Route::get('/packages/{id}/edit', [TravelController::class, 'editPackage'])->name('packages.edit');
    Route::put('/packages/{id}', [TravelController::class, 'updatePackage'])->name('packages.update');
    Route::delete('/packages/{id}', [TravelController::class, 'deletePackage'])->name('packages.delete');

    // Booking Management Routes
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::put('/bookings/{id}/payment-status', [AdminBookingController::class, 'updatePaymentStatus'])->name('bookings.update-payment-status');
    Route::put('/bookings/{id}/notes', [AdminBookingController::class, 'updateNotes'])->name('bookings.update-notes');
});

route::get('details' , [DetailsController::class, 'index']);
route::get('checkout' , [CheckoutController::class, 'index']);
route::get('succes' , [SuccessController::class, 'index']);