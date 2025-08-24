<?php

use Illuminate\Support\Facades\Route;

// API routes for all resources will be registered here. 

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', App\Http\Controllers\Api\UserController::class);
    Route::apiResource('business-partners', App\Http\Controllers\Api\BusinessPartnerController::class);
    Route::apiResource('items', App\Http\Controllers\Api\ItemController::class);
    Route::apiResource('offer-requests', App\Http\Controllers\Api\OfferRequestController::class);
    Route::apiResource('offer-request-items', App\Http\Controllers\Api\OfferRequestItemController::class);
    Route::apiResource('orders', App\Http\Controllers\Api\OrderController::class);
    Route::apiResource('order-items', App\Http\Controllers\Api\OrderItemController::class);
    Route::apiResource('salesmen', App\Http\Controllers\Api\SalesmanController::class);
    Route::apiResource('salesmen-groups', App\Http\Controllers\Api\SalesmanGroupController::class);
});
Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');
