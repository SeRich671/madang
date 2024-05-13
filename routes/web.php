<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Profile\AddressController;
use App\Http\Controllers\Profile\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\SetSessionDomain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::domain('{subdomain}.' . config('app.url_short'))->middleware(SetSessionDomain::class)->group(function () {
    Route::get('/', [HomeController::class, 'department'])->name('department.index');
    Route::get('{category}', [HomeController::class, 'category'])->name('department.category.index');
    Route::get('product/{product}/{category?}', [ProductController::class, 'show'])->name('product.show');
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('order')->name('order.')->group(function () {
    Route::get('create', [\App\Http\Controllers\OrderController::class, 'create'])->name('create');
    Route::post('store', [\App\Http\Controllers\OrderController::class, 'store'])->name('store');
    Route::get('summary/{orderReference}', [\App\Http\Controllers\OrderController::class, 'summary'])->name('summary');
    Route::post('summary/{orderReference}/confirm', [\App\Http\Controllers\OrderController::class, 'confirm'])->name('confirm');
});

Route::prefix('cart')->middleware('auth')->name('cart.')->group(function () {
    Route::get('/show', [CartController::class, 'show'])->name('show');
    Route::post('add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('recalculate', [CartController::class, 'recalculate'])->name('recalculate');
    Route::get('delete/{cartItem}', [CartController::class, 'delete'])->name('delete');
});

Route::prefix('profile')->middleware('auth')->name('profile.')->group(function () {
    Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('update', [ProfileController::class, 'update'])->name('update');
    Route::resource('address', AddressController::class, [
        'except' => ['show'],
    ]);
    Route::resource('order', OrderController::class, [
        'only' => ['index', 'show'],
    ]);
});

Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
