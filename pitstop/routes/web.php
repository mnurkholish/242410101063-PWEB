<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/dashboard/bookings', [DashboardController::class, 'store'])->name('dashboard.bookings.store');

Route::view('/tentang', 'tentang');
