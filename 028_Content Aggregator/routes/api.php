<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleFetchController;

Route::post('/fetch-articles', [ArticleFetchController::class, 'fetch']);