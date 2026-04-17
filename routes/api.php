<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/uploads', [ItemController::class, 'upload'])->name('product-upload');
Route::get('/product', [ItemController::class, 'getData'])->name('api-product-all');
// Route::prefix('/api')->group(function () {
Route::prefix('/product')->group(function () {
    // Route::get('/all', [ItemController::class, 'getData'])->name('api-product-all');
    Route::get('/paged', [ApiController::class, 'getProductsPaginated'])->name('api-product-paged');
    Route::get('/detail/{uuid}', [ApiController::class, 'getProductDetail'])->name('api-product-detail');
    Route::get('/search', [ApiController::class, 'quickSearch'])->name('api-product-search');

});
Route::prefix('/brand')->group(function () {
     Route::get('/all', [ApiController::class, 'getBrands'])->name('api-brand-all');
});
Route::prefix('/category')->group(function () {
     Route::get('/all', [ApiController::class, 'getCategories'])->name('api-category-all');
});
Route::prefix('/warehouse')->group(function () {
     Route::get('/all', [ApiController::class, 'getWarehouses'])->name('api-warehouse-all');
});
// });
