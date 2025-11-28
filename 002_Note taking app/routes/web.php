<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('notes.index');
});

Route::resource('notes', NoteController::class);

Route::post('/notes/{note}/toggle-pin', [NoteController::class, 'togglePin'])
    ->name('notes.toggle-pin');