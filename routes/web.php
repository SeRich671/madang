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
use App\Http\Middleware\HasNoDeletedStatus;
use App\Http\Middleware\SetSessionDomain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware([SetSessionDomain::class, HasNoDeletedStatus::class])->group(function () {
    Auth::routes([
        'verify' => true
    ]);

    Route::get('search', [SearchController::class, 'search'])->name('search.index');

    Route::domain('{subdomain}.' . config('app.url_short'))->middleware([HasNoDeletedStatus::class])->group(function () {
        Route::get('contact', [ContactController::class, 'show'])->name('contact.show');
        Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
        Route::get('/', [HomeController::class, 'department'])->name('department.index');
        Route::get('new', [HomeController::class, 'new'])->name('department.new');
        Route::get('recommended', [HomeController::class, 'recommended'])->name('department.recommended');
        Route::get('last-deliveries', [HomeController::class, 'lastDeliveries'])->name('department.last-deliveries');
        Route::get('discounted', [HomeController::class, 'discounted'])->name('department.discounted');
        Route::get('product/{product}/{category?}', [ProductController::class, 'show'])->name('product.show');
        Route::get('category/{category}', [HomeController::class, 'category'])->name('department.category.index');
    });

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('order')->middleware(['auth', HasNoDeletedStatus::class, 'verified', HasBranch::class, ])->name('order.')->group(function () {
        Route::get('create', [\App\Http\Controllers\OrderController::class, 'create'])->name('create');
        Route::post('store', [\App\Http\Controllers\OrderController::class, 'store'])->name('store');
        Route::get('summary/{orderReference}', [\App\Http\Controllers\OrderController::class, 'summary'])->name('summary');
        Route::post('summary/{orderReference}/confirm', [\App\Http\Controllers\OrderController::class, 'confirm'])->name('confirm');
    });

    Route::prefix('cart')->middleware(['auth', HasNoDeletedStatus::class, 'verified', HasBranch::class])->name('cart.')->group(function () {
        Route::get('/show', [CartController::class, 'show'])->name('show');
        Route::post('add/{product}', [CartController::class, 'add'])->name('add');
        Route::post('recalculate', [CartController::class, 'recalculate'])->name('recalculate');
        Route::post('empty', [CartController::class, 'empty'])->name('empty');
        Route::get('delete/{cartItem}', [CartController::class, 'delete'])->name('delete');
    });

    Route::prefix('profile')->middleware(['auth', HasNoDeletedStatus::class, 'verified', HasBranch::class])->name('profile.')->group(function () {
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
        Route::post('order/{order}/recreate', [OrderController::class, 'recreate'])->name('order.recreate');
    });
});
