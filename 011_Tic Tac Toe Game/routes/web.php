<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicTacToeController;

Route::get('/', [TicTacToeController::class, 'index'])->name('tictactoe.index');
Route::post('/move', [TicTacToeController::class, 'makeMove'])->name('tictactoe.move');
Route::post('/reset', [TicTacToeController::class, 'resetGame'])->name('tictactoe.reset');
Route::post('/change-mode', [TicTacToeController::class, 'changeMode'])->name('tictactoe.change-mode');