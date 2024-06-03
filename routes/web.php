<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Profile\AddressController;
use App\Http\Controllers\Profile\BillingController;
use App\Http\Controllers\Profile\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Middleware\HasBranch;
use App\Http\Middleware\SetSessionDomain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();


Route::get('contact', [ContactController::class, 'index'])->name('contact.index');

Route::get('search', [SearchController::class, 'search'])->name('search.index');

Route::domain('{subdomain}.' . config('app.url_short'))->middleware(SetSessionDomain::class)->group(function () {
    Route::get('/', [HomeController::class, 'department'])->name('department.index');
    Route::get('new', [HomeController::class, 'new'])->name('department.new');
    Route::get('recommended', [HomeController::class, 'recommended'])->name('department.recommended');
    Route::get('{category}', [HomeController::class, 'category'])->name('department.category.index');
    Route::get('product/{product}/{category?}', [ProductController::class, 'show'])->name('product.show');
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('order')->middleware(['auth', HasBranch::class])->name('order.')->group(function () {
    Route::get('create', [\App\Http\Controllers\OrderController::class, 'create'])->name('create');
    Route::post('store', [\App\Http\Controllers\OrderController::class, 'store'])->name('store');
    Route::get('summary/{orderReference}', [\App\Http\Controllers\OrderController::class, 'summary'])->name('summary');
    Route::post('summary/{orderReference}/confirm', [\App\Http\Controllers\OrderController::class, 'confirm'])->name('confirm');
});

Route::prefix('cart')->middleware(['auth', HasBranch::class])->name('cart.')->group(function () {
    Route::get('/show', [CartController::class, 'show'])->name('show');
    Route::post('add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('recalculate', [CartController::class, 'recalculate'])->name('recalculate');
    Route::get('delete/{cartItem}', [CartController::class, 'delete'])->name('delete');
});

Route::prefix('profile')->middleware(['auth', HasBranch::class])->name('profile.')->group(function () {
    Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('update', [ProfileController::class, 'update'])->name('update');

    Route::resource('billing', BillingController::class, [
        'except' => ['show'],
    ]);
    Route::resource('address', AddressController::class, [
        'except' => ['show'],
    ]);
    Route::resource('order', OrderController::class, [
        'only' => ['index', 'show'],
    ]);
});
