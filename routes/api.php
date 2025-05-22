<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ProductApiController;

Route::apiResource('users', UserApiController::class);
Route::apiResource('products', ProductApiController::class);
