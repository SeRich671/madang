<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\User\AddressController;
use App\Http\Controllers\Admin\User\BillingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', AdminController::class)->name('index');

Route::resource('order', OrderController::class, [
    'except' => ['show', 'create', 'store'],
]);

Route::resource('branch', BranchController::class, [
    'except' => ['show'],
]);
Route::resource('department', DepartmentController::class, [
    'except' => ['show'],
]);
Route::resource('category', CategoryController::class, [
    'except' => ['show'],
]);

Route::resource('product', ProductController::class, [
    'except' => ['show'],
]);

Route::prefix('product/{product}')->name('product.')->group(function () {
    Route::resource('attribute', AttributeController::class, [
        'except' => ['show'],
    ]);
});

Route::resource('attribute', AttributeController::class, [
    'except' => ['show'],
]);

Route::resource('user', UserController::class, [
    'except' => ['show'],
]);

Route::prefix('user/{user}')->name('user.')->group(function () {
    Route::resource('billing', BillingController::class, [
        'except' => ['show', 'index'],
    ]);
    Route::resource('address', AddressController::class, [
        'except' => ['show', 'index'],
    ]);
});

Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
