<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\VideoController;

// Redirect root to game index
Route::get('/', function () {
    return redirect()->route('game.index');
});

// Game Routes
Route::get('/game', [GameController::class, 'index'])->name('game.index');
Route::get('/game/play', [GameController::class, 'play'])->name('game.play');
Route::post('/game/save-score', [GameController::class, 'saveScore'])->name('game.saveScore');
Route::get('/game/scores', [GameController::class, 'highScores'])->name('game.scores');

// Video Routes
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');