<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RackController;
use App\Http\Controllers\StockController;
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
    Route::get('/search', [ApiController::class, 'getProductSearch'])->name('api-product-search');

});
Route::prefix('/brand')->group(function () {
    Route::get('/all', [ApiController::class, 'getBrands'])->name('api-brand-all');
    Route::get('/paged', [ApiController::class, 'getBrandsPaginated'])->name('api-brand-paged');
});
Route::prefix('/unit')->group(function () {
    Route::get('/paged', [ApiController::class, 'getUnitsPaginated'])->name('api-unit-paged');
});
Route::prefix('/rack')->group(function () {
    Route::get('/paged', [ApiController::class, 'getRacksPaginated'])->name('api-rack-paged');
});
Route::prefix('/stock')->group(function () {
    Route::get('/paged', [ApiController::class, 'getStocksPaginated'])->name('api-stock-paged');
});
Route::prefix('/category')->group(function () {
    Route::get('/all', [ApiController::class, 'getCategories'])->name('api-category-all');
});
Route::prefix('/subcategory')->group(function () {
    Route::get('/all', [ApiController::class, 'getSubcategories'])->name('api-subcategory-all');
    Route::get('/paged', [ApiController::class, 'getSubcategoriesPaginated'])->name('api-subcategory-paged');
    Route::get('/{categoryId}', [ApiController::class, 'getSubcategories'])->name('api-subcategory-by-category');
});
Route::prefix('/supplier')->group(function () {
    Route::get('/all', [ApiController::class, 'getSuppliers'])->name('api-supplier-all');
});
Route::prefix('/customer')->group(function () {
    Route::get('/all', [ApiController::class, 'getCustomers'])->name('api-customer-all');
});

Route::prefix('/warehouse')->group(function () {
    Route::get('/all', [ApiController::class, 'getWarehouses'])->name('api-warehouse-all');
});
Route::prefix('/contact')->group(function () {
    Route::get('/{supplierUuid}', [ApiController::class, 'getContactBySupplier'])->name('api-contact-supplier');
    Route::get('/detail/{uuid}', [ApiController::class, 'getContacts'])->name('api-contact-detail');
});
Route::prefix('/payment-method')->group(function () {
    Route::get('/all', [ApiController::class, 'getPaymentMethods'])->name('api-payment-method-all');
});
Route::prefix('/bank')->group(function () {
    Route::get('/all', [ApiController::class, 'getBanks'])->name('api-bank-all');
});
Route::prefix('/bank-account')->group(function () {
    Route::get('/all', [ApiController::class, 'getBankAccounts'])->name('api-bank-account-all');
    Route::post('/create', [ApiController::class, 'createBankAccount'])->name('api-bank-account-create');
});
Route::prefix('/order')->group(function () {
    Route::post('/add', [ApiController::class, 'addOrder'])->name('api-order-add');
    Route::delete('/delete/{uuid}', [ApiController::class, 'deleteOrder'])->name('api-order-delete');
});
Route::prefix('/sales')->group(function () {
    Route::post('/add', [ApiController::class, 'addSales'])->name('api-sales-add');
});
// });
