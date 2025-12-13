<?php

use App\Http\Controllers\TetrisController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TetrisController::class, 'index']);
Route::post('/save-score', [TetrisController::class, 'saveScore']);
Route::get('/high-scores', [TetrisController::class, 'getHighScores']);