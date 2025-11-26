<?php

use App\Http\Controllers\LapanganController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('lapangan', LapanganController::class);
Route::get('/lapangan/create', [LapanganController::class, 'create'])->name('lapangan.create');
Route::post('/lapangan', [LapanganController::class, 'store'])->name('lapangan.store');


Route::resource('booking', BookingController::class)->except(['edit', 'update', 'destroy']);
Route::post('booking/{booking}/status', [BookingController::class, 'updateStatus'])->name('booking.updateStatus');
Route::get('booking/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.checkAvailability');