<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScraperController;

Route::get('/', function () {
    return redirect()->route('scraper.index');
});

Route::prefix('scraper')->group(function () {
    Route::get('/', [ScraperController::class, 'index'])->name('scraper.index');
    Route::get('/create', [ScraperController::class, 'create'])->name('scraper.create');
    Route::post('/scrape', [ScraperController::class, 'scrape'])->name('scraper.scrape');
    Route::get('/show/{id}', [ScraperController::class, 'show'])->name('scraper.show');
    Route::delete('/delete/{id}', [ScraperController::class, 'destroy'])->name('scraper.destroy');
    Route::post('/clear-all', [ScraperController::class, 'clearAll'])->name('scraper.clearAll');
});