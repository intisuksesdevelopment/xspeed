<?php

use App\Services\ContactService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;

Route::prefix('api')->group(function () {
    Route::prefix('pos')->group(function () {
        Route::post('/add', [PosController::class, 'add'])->name('pos-add');
    });
    Route::prefix('contact')->group(function () {
        Route::post('/{supplierUuid}', [ContactService::class, 'get']);
    });
});

