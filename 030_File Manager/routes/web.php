<?php

use App\Http\Controllers\FileManagerController;
use Illuminate\Support\Facades\Route;

Route::get('/filemanager', [FileManagerController::class, 'index'])->name('filemanager.index');
Route::post('/filemanager/upload', [FileManagerController::class, 'upload'])->name('filemanager.upload');
Route::post('/filemanager/folder', [FileManagerController::class, 'createFolder'])->name('filemanager.folder.create');
Route::get('/filemanager/download/{file}', [FileManagerController::class, 'download'])->name('filemanager.download');
Route::delete('/filemanager/delete', [FileManagerController::class, 'delete'])->name('filemanager.delete');