<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/browse', [HomeController::class, 'browse'])->name('browse');
Route::get('/album/{id}', [HomeController::class, 'albumDetail'])->name('album.detail');
Route::get('/artist/{id}', [HomeController::class, 'artistDetail'])->name('artist.detail');
Route::get('/artists', [HomeController::class, 'artists'])->name('artists');

// Cart Routes
Route::get('/cart', [OrderController::class, 'cart'])->name('cart');
Route::post('/cart/add/{id}', [OrderController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/remove/{id}', [OrderController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update', [OrderController::class, 'updateCart'])->name('cart.update');

// Checkout Routes
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('order.place');