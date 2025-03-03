<?php

use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::prefix('pos')->group(function () {
        Route::post('/add', [PosController::class, 'add'])->name('pos-add');
    });
});

