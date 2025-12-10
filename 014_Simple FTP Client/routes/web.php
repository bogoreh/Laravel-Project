<?php

use App\Http\Controllers\FtpController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FtpController::class, 'index'])->name('ftp.index');
Route::get('/connect', [FtpController::class, 'showConnectForm'])->name('ftp.show-connect');
Route::post('/connect', [FtpController::class, 'connect'])->name('ftp.connect');
Route::get('/disconnect', [FtpController::class, 'disconnect'])->name('ftp.disconnect');
Route::get('/files', [FtpController::class, 'listFiles'])->name('ftp.files');
Route::post('/upload', [FtpController::class, 'upload'])->name('ftp.upload');
Route::post('/download', [FtpController::class, 'download'])->name('ftp.download');
Route::post('/delete', [FtpController::class, 'delete'])->name('ftp.delete');
Route::post('/create-folder', [FtpController::class, 'createFolder'])->name('ftp.create-folder');