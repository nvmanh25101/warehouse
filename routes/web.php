<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('processLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/statistic', [HomeController::class, 'statistic'])->name('statistic')->middleware('auth');
Route::get('/statistic/api', [HomeController::class, 'api'])->name('statistic_api')->middleware('auth');

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
    Route::delete('/{product}/delete', 'destroy')->name('destroy');
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
    Route::delete('/{supplier}/delete', 'destroy')->name('destroy');
});

Route::group([
    'as' => 'customers.',
    'prefix' => 'customers',
    'controller' => CustomerController::class,
    'middleware' => 'auth',
], static function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/api', 'api')->name('api');
    Route::post('/store', 'store')->name('store');
    Route::get('/{customer}/edit', 'edit')->name('edit');
    Route::put('/{customer}/update', 'update')->name('update');
    Route::delete('/{customer}/delete', 'destroy')->name('destroy');
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
    Route::put('/{receipt}/update', 'update')->name('update');
    Route::get('/{receipt}/edit', 'edit')->name('edit');
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
    Route::get('/export/', 'export')->name('export');
});

Route::group([
    'as' => 'exports.',
    'prefix' => 'exports',
    'controller' => ExportController::class,
    'middleware' => 'auth',
], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/api', 'api')->name('api');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::delete('/{export}/delete', 'destroy')->name('destroy')->middleware('admin');
    Route::get('/{export}/edit', 'edit')->name('edit');
    Route::put('/{export}/update', 'update')->name('update');
});

Route::group([
    'as' => 'profiles.',
    'prefix' => 'profiles',
    'controller' => ProfileController::class,
    'middleware' => 'auth',
], function () {
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::put('/{id}/update', 'update')->name('update');
});

Route::group([
    'as' => 'users.',
    'prefix' => 'users',
    'controller' => UserController::class,
    'middleware' => ['auth', 'admin'],
], static function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/api', 'api')->name('api');
    Route::post('/store', 'store')->name('store');
    Route::get('/{user}/edit', 'edit')->name('edit');
    Route::put('/{user}/update', 'update')->name('update');
    Route::delete('/{user}/delete', 'destroy')->name('destroy');
});
