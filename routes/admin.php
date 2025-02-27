<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Department\LinkController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\MailingController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\User\AddressController;
use App\Http\Controllers\Admin\User\BillingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductImportController;
use Illuminate\Support\Facades\Route;

Route::get('/', AdminController::class)->name('index');

Route::resource('order', OrderController::class, [
    'except' => ['show', 'create', 'store'],
]);

Route::get('order/{order}/download-pdf', [OrderController::class, 'download'])->name('order.download');

Route::resource('branch', BranchController::class, [
    'except' => ['show'],
]);
Route::resource('department', DepartmentController::class, [
    'except' => ['show'],
]);

Route::prefix('department/{department}')->name('department.')->group(function () {
    Route::resource('link', LinkController::class, [
        'only' => ['create', 'store', 'edit', 'update', 'destroy']
    ]);
});

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

Route::get('report', [\App\Http\Controllers\Admin\ReportHistoryController::class, 'index'])->name('report.index');

Route::get('product-export', [ExportController::class, 'products'])->name('product.export');
Route::get('product-export/{report}/download', [ExportController::class, 'download'])->name('product.export.download');

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

Route::post('/import-products', [ProductImportController::class, 'import'])->name('product.import');

Route::get('mailing', [MailingController::class, 'index'])->name('mailing.index');
Route::delete('mailing', [MailingController::class, 'destroy'])->name('mailing.destroy');
Route::post('/send-mailing', [MailingController::class, 'sendMailing'])->name('sendMailing');


Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
