<?php

use Illuminate\Http\Request;
use App\Services\WarehouseService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/uploads', [ItemController::class, 'upload'])->name('product-upload');
Route::get('/product', [ItemController::class, 'getData'])->name('api-product-list');

Route::middleware(['web'])->group(function () {
    Route::prefix('warehouse')->group(function () {
        Route::get('/active', [WarehouseService::class, 'apiGetActive'])->name('api-warehouse-active');
    });
});