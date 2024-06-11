<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('processLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');

Route::group([
    'as' => 'products.',
    'prefix' => 'products',
    'controller' => ProductController::class,
    'middleware' => 'auth',
], static function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/api', 'api')->name('api');
    Route::post('/store', 'store')->name('store');
    Route::get('/{product}/edit', 'edit')->name('edit');
    Route::put('/{product}/update', 'update')->name('update');
    Route::delete('/{product}/delete', 'delete')->name('destroy');
});

Route::group([
    'as' => 'suppliers.',
    'prefix' => 'suppliers',
    'controller' => SupplierController::class,
    'middleware' => 'auth',
], static function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/api', 'api')->name('api');
    Route::post('/store', 'store')->name('store');
    Route::get('/{supplier}/edit', 'edit')->name('edit');
    Route::put('/{supplier}/update', 'update')->name('update');
    Route::delete('/{supplier}/delete', 'delete')->name('destroy');
});

Route::group([
    'as' => 'receipts.',
    'prefix' => 'receipts',
    'controller' => ReceiptController::class,
    'middleware' => 'auth',
], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/api', 'api')->name('api');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{receipt}/edit', 'edit')->name('edit');
    Route::put('/{receipt}/update', 'update')->name('update');
    Route::delete('/{receipt}/delete', 'delete')->name('destroy');
});

Route::group([
    'as' => 'warehouses.',
    'prefix' => 'warehouses',
    'controller' => WarehouseController::class,
    'middleware' => 'auth',
], static function () {
    Route::get('/', 'index')->name('index');
    Route::get('/api', 'api')->name('api');
    Route::get('/{warehouse}/edit', 'edit')->name('edit');
    Route::put('/{warehouse}/update', 'update')->name('update');
});
