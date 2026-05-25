<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
Route::get('/subscriptions/{id}', [SubscriptionController::class, 'show'])->name('subscriptions.show');