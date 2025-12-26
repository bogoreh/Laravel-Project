<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpamController;
use App\Http\Controllers\TrainingController;

Route::get('/', function () {
    return redirect()->route('spam.check');
});

Route::prefix('spam')->group(function () {
    Route::get('/check', [SpamController::class, 'checkForm'])->name('spam.check');
    Route::post('/check', [SpamController::class, 'check']);
    Route::get('/stats', [SpamController::class, 'stats'])->name('spam.stats');
});

Route::prefix('training')->group(function () {
    Route::get('/', [TrainingController::class, 'index'])->name('training.index');
    Route::post('/', [TrainingController::class, 'store'])->name('training.store');
    Route::post('/train', [TrainingController::class, 'train'])->name('training.train');
    Route::delete('/{trainingData}', [TrainingController::class, 'destroy'])->name('training.destroy');
});