<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');


    // Dashboard
    Route::get('/', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('products.index');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'verified', 'customer'])->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});


Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    // Product Management (Admin-only actions)
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Order Management
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Admin Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

require __DIR__.'/auth.php';
