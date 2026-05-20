<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\LayananController as AdminLayananController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'home'])->name('home');
Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/kontak', 'kontak')->name('kontak');
Route::view('/preferensi', 'preferensi')->name('preferensi');
Route::post('/preferensi', [PreferenceController::class, 'store'])->name('preferensi.store');

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/search', [BookingController::class, 'index'])->name('bookings.search');
    Route::post('/dashboard/bookings', [BookingController::class, 'store'])->name('dashboard.bookings.store');
});

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::view('/booking', 'admin.booking.index')->name('booking.index');
        Route::view('/users', 'admin.users.index')->name('users.index');
        Route::post('/layanan/search', [AdminLayananController::class, 'index'])->name('layanan.search');
        Route::resource('layanan', AdminLayananController::class);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/layanan/search', [LayananController::class, 'index'])->name('layanan.search');
    Route::resource('layanan', LayananController::class)->only(['index', 'show']);
});

require __DIR__.'/auth.php';
