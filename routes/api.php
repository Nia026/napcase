<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\MetodePembayaranApiController;
use App\Http\Controllers\ProductController;

Route::apiResource('users', UserApiController::class);
Route::apiResource('products', ProductApiController::class);
Route::apiResource('MetodePembayaran', MetodePembayaranApiController::class);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
