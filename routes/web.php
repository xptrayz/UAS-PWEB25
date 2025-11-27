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


Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/', [App\Http\Controllers\LaporanController::class, 'index'])->name('index');
    Route::get('/preview', [App\Http\Controllers\LaporanController::class, 'preview'])->name('preview');
    Route::get('/cetak-pdf', [App\Http\Controllers\LaporanController::class, 'cetakPdf'])->name('cetakPdf');
});


Route::prefix('reviews')->name('reviews.')->group(function () {
    Route::get('/booking/{booking}/create', [App\Http\Controllers\ReviewController::class, 'create'])->name('create');
    Route::post('/booking/{booking}', [App\Http\Controllers\ReviewController::class, 'store'])->name('store');
    Route::get('/lapangan/{lapangan}', [App\Http\Controllers\ReviewController::class, 'index'])->name('lapangan');
    Route::get('/{review}/edit', [App\Http\Controllers\ReviewController::class, 'edit'])->name('edit');
    Route::put('/{review}', [App\Http\Controllers\ReviewController::class, 'update'])->name('update');
    Route::delete('/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('destroy');
});