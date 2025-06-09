<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\MetodePembayaranApiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransaksiController;

Route::apiResource('users', UserApiController::class);
Route::apiResource('products', ProductApiController::class);
Route::apiResource('MetodePembayaran', MetodePembayaranApiController::class);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::get('/transaksi', [TransaksiController::class, 'index']);
Route::get('/transaksi/{id}', [TransaksiController::class, 'show']);
Route::put('/transaksi/{id}', [TransaksiController::class, 'update']);
Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy']);
Route::get('/transaksi/user/{id}', [TransaksiController::class, 'getByUser']);
Route::post('/transaksi/selesai/{id}', [TransaksiController::class, 'konfirmasiSelesai']);
