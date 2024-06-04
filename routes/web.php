<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('processLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::group([
    'as' => 'products.',
    'prefix' => 'products',
    'controller' => ProductController::class,
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
], static function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/api', 'api')->name('api');
    Route::post('/store', 'store')->name('store');
    Route::get('/{supplier}/edit', 'edit')->name('edit');
    Route::put('/{supplier}/update', 'update')->name('update');
    Route::delete('/{supplier}/delete', 'delete')->name('destroy');
});
