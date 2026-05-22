<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SubscriptionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::patch('services/{id}/change-status', [ServiceController::class, 'changeStatus']);
Route::patch('customers/{id}/change-status', [CustomerController::class, 'changeStatus']);
Route::patch('subscriptions/{id}/change-status', [SubscriptionController::class, 'changeStatus']);


Route::apiResource('services', ServiceController::class);
Route::apiResource('customers', CustomerController::class);


Route::apiResource('subscriptions', SubscriptionController::class)->except(['update', 'destroy']);