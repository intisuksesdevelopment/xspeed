<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/uploads', [ItemController::class, 'upload'])->name('product-upload');
Route::get('/product', [ItemController::class, 'getData'])->name('api-product-list');