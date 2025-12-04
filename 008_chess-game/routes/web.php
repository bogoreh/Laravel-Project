<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChessController;
use App\Http\Controllers\GameController;

Route::get('/', [ChessController::class, 'index'])->name('chess.index');
Route::post('/chess/create', [ChessController::class, 'create'])->name('chess.create');
Route::get('/chess/game/{id}', [ChessController::class, 'game'])->name('chess.game');
Route::post('/chess/game/{id}/move', [ChessController::class, 'move'])->name('chess.move');
Route::get('/chess/game/{id}/valid-moves', [ChessController::class, 'getValidMoves'])->name('chess.valid-moves');
Route::get('/game/{id}/join/{color}', [GameController::class, 'join'])->name('game.join');