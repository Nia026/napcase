<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // ✅ CRUD User
    Route::get('/users', [UserController::class, 'index']); // Lihat semua user
    Route::get('/users/{id}', [UserController::class, 'show']); // Lihat 1 user
    Route::put('/users/{id}', [UserController::class, 'update']); // Edit user
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Hapus user

    // ✅ Dashboard admin dan home user (jika diperlukan API route)
    Route::middleware('admin')->get('/dashboard', [AdminController::class, 'index']);
    Route::middleware('user')->get('/home', [UserController::class, 'home']);
});