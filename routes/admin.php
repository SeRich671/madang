<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', AdminController::class)->name('index');

Route::resource('order', OrderController::class, [
    'except' => ['show', 'create', 'store'],
]);
