<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LegalController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/services', [ServicesController::class, 'index'])->name('services.index');

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/contact',  [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/',        [BookingController::class, 'index'])   ->name('index');
    Route::post('/',       [BookingController::class, 'store'])   ->name('store');
    Route::get('/success', [BookingController::class, 'success']) ->name('success');
});

Route::get('/{slug}', [LegalController::class, 'show'])
    ->where('slug', 'privacy-policy|terms-of-service')
    ->name('legal.show');