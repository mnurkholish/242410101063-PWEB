<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'home'])->name('home');
Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/kontak', 'kontak')->name('kontak');

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings', [DashboardController::class, 'bookings'])->name('bookings.index');
    Route::post('/bookings/search', [DashboardController::class, 'searchBookings'])->name('bookings.search');
    Route::post('/dashboard/bookings', [DashboardController::class, 'store'])->name('dashboard.bookings.store');
});

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::view('/booking', 'admin.booking.index')->name('booking.index');
        Route::view('/users', 'admin.users.index')->name('users.index');
        Route::resource('layanan', LayananController::class);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('layanan', LayananController::class)->only(['index', 'show']);
});

require __DIR__.'/auth.php';
