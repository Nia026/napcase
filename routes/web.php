<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('landing');
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

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


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

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/admin/products', function () {
    return view('admin.products');
});
Route::get('admin/create', [ProductController::class, 'create']);
Route::post('admin/products', [ProductController::class, 'store']);
Route::get('admin/edit/{id}', [ProductController::class, 'edit']);
Route::put('admin/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
