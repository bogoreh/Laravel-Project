<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SnakeGameController;

Route::get('/', [SnakeGameController::class, 'index']);
Route::post('/save-score', [SnakeGameController::class, 'saveScore']);
Route::get('/high-scores', [SnakeGameController::class, 'getHighScores']);