<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/manage-products', [ProductController::class, 'manage'])
    ->name('products.manage');

Route::post('/manage-products', [ProductController::class, 'store'])
    ->name('products.store');

Route::put('/manage-products/{id}', [ProductController::class, 'update'])
    ->name('products.update');

Route::delete('/manage-products/{id}', [ProductController::class, 'destroy'])
    ->name('products.destroy');
