<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortScannerController;

Route::get('/', [PortScannerController::class, 'index'])->name('scanner.index');
Route::post('/scan', [PortScannerController::class, 'scan'])->name('port.scan');