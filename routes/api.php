<?php

use Illuminate\Support\Facades\Route;

// Product endpoint (already defined in plan)
Route::middleware('auth:sanctum')->get('products', [App\Http\Controllers\Api\ProductApiController::class, 'index']);

// Category hierarchy endpoint
Route::middleware('auth:sanctum')->get('categories', [App\Http\Controllers\Api\CategoryApiController::class, 'index']);

// Filter metadata endpoint (brands, price range)
Route::middleware('auth:sanctum')->get('filters', [App\Http\Controllers\Api\FilterApiController::class, 'index']);
