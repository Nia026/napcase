<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [PageController::class, 'register']);
Route::get('/login', [PageController::class, 'login']);
Route::post('/authenticate', [AuthController::class, 'login']);

Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [WebAuthController::class, 'register'])->name('register.action');

Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login'])->name('login.action');

Route::get('/admin/dashboard', function () {
    return 'Dashboard Admin';
})->name('admin.dashboard');

Route::get('/user/home', function () {
    return 'Homepage User';
})->name('user.home');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/home', [UserController::class, 'index'])->name('user.home');
});

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware([UserMiddleware::class])->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('user.home');
});