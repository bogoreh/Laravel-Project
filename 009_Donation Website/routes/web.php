<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DonationController;

// Pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/campaigns', [PageController::class, 'campaigns'])->name('campaigns');

// Donations
Route::prefix('donations')->name('donations.')->group(function () {
    Route::get('/create/{campaign?}', [DonationController::class, 'create'])->name('create');
    Route::post('/', [DonationController::class, 'store'])->name('store');
    Route::get('/success/{donation}', [DonationController::class, 'success'])->name('success');
});