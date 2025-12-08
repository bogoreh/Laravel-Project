<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('contacts.create');
});

Route::resource('contacts', ContactController::class)->only([
    'index', 'create', 'store'
]);