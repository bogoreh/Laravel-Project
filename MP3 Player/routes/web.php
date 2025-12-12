<?php

use App\Http\Controllers\MusicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MusicController::class, 'index'])->name('music.index');
Route::get('/upload', [MusicController::class, 'upload'])->name('music.upload');
Route::post('/upload', [MusicController::class, 'store'])->name('music.store');
Route::delete('/song/{song}', [MusicController::class, 'destroy'])->name('music.destroy');