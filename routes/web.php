<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth'], 'as' => 'admin.'], function () {
    Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
        Route::get('/products/suggestions', [\App\Http\Controllers\Admin\Api\ProductController::class, 'suggestions']);
    });
    Route::get('/admin', [\App\Http\Controllers\Admin\HomeController::class, 'index']);
    Route::get('/home', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
    Route::resource('/products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('/brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::resource('/stock-management', \App\Http\Controllers\Admin\StockManagementController::class)->only('index');
    Route::resource('/purchases', \App\Http\Controllers\Admin\PurchaseController::class);
    Route::resource('/sales', \App\Http\Controllers\Admin\SaleController::class);
    Route::resource('/transfers', \App\Http\Controllers\Admin\TransferController::class);
    Route::resource('/warehouses', \App\Http\Controllers\Admin\WarehouseController::class);
});
