<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

// Redirect halaman utama ke daftar produk
Route::get('/', function () {
    return redirect()->route('products.index');
});

// Route Resource CRUD
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);