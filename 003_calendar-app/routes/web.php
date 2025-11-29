<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index'])->name('calendar');
Route::get('/events', [EventController::class, 'getEvents'])->name('events.get');
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');