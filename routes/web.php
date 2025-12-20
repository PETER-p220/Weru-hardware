<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

// ============================================================================
// PUBLIC ROUTES (No authentication required)
// ============================================================================

Route::get('/', function () {
    return view('welcome');
});

// Webhook routes (must be public, no CSRF)
Route::post('/selcom/webhook', [CheckoutController::class, 'handleWebhook'])
    ->name('selcom.webhook')
    ->withoutMiddleware('csrf');
Route::post('/webhook/selcom', [CheckoutController::class, 'webhook'])
    ->name('selcom.webhook.alternative')
    ->withoutMiddleware('csrf');

// ============================================================================
// SHARED AUTHENTICATED ROUTES (Available to both admins and regular users)
// Admins can also shop and view their own orders
// ============================================================================

Route::middleware('auth')->group(function () {
    // User Profile (available to all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Product viewing (browsing) - available to all authenticated users
    Route::get('/products', [ProductController::class, 'products'])->name('products');
    Route::get('/show', [ProductController::class, 'show'])->name('show');

    // Shopping Cart - available to all authenticated users
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout - available to all authenticated users (admins can also make purchases)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])
        ->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])
        ->name('checkout.cancel');
    Route::get('/checkout/status/{orderId}', [CheckoutController::class, 'checkStatus'])
        ->name('checkout.status');

    // User's own orders - available to all authenticated users (admins can view their orders too)
    Route::get('/order', [OrderController::class, 'index'])->name('order');
});

// ============================================================================
// REGULAR USER-ONLY ROUTES (Regular users only, admins redirected)
// ============================================================================

Route::middleware(['auth', 'user'])->group(function () {
    // User Dashboard - only for regular users
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ============================================================================
// ADMIN-ONLY ROUTES (Authentication + Admin role required)
// Regular users will be redirected to their dashboard
// ============================================================================

Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/adminDashboard', function () {
        $orders = Order::with('user')->latest()->get();
        $products = Product::all(); 
        $users = User::all();
        return view('adminDashboard', compact('orders', 'products', 'users'));
    })->name('adminDashboard');

    // Product Management (CRUD)
    Route::get('/indexProduct', [ProductController::class, 'index'])->name('indexProduct');
    Route::get('/createProduct', [ProductController::class, 'create'])->name('createProduct');
    Route::post('/createProduct', [ProductController::class, 'store'])->name('createProduct.store');
    Route::get('/editProduct/{product}', [ProductController::class, 'edit'])->name('editProduct');
    Route::post('/updateProduct/{product}', [ProductController::class, 'update'])->name('updateProduct');
    Route::post('/deleteProduct/{product}', [ProductController::class, 'destroy'])->name('deleteProduct');

    // Category Management (CRUD)
    Route::get('/indexCategory', [CategoryController::class, 'index'])->name('indexCategory');
    Route::get('/createCategory', [CategoryController::class, 'create'])->name('createCategory');
    Route::post('/createCategory', [CategoryController::class, 'store'])->name('createCategory.store');
    Route::get('/editCategory/{category}', [CategoryController::class, 'edit'])->name('editCategory');
    Route::patch('/updateCategory/{category}', [CategoryController::class, 'update'])->name('updateCategory');
    Route::delete('/deleteCategory/{category}', [CategoryController::class, 'destroy'])->name('deleteCategory');

    // Order Management
    Route::get('/OrderManagement', [OrderController::class, 'show'])->name('OrderManagement');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::patch('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])
        ->name('orders.update-status');
    Route::patch('/orders/{order}/mark-as-paid', [OrderController::class, 'markAsPaid'])
        ->name('orders.mark-as-paid');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // User Management
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');

    // Advertisement Management
    Route::get('/ads', [App\Http\Controllers\AdvertisementController::class, 'index'])->name('ads');
    Route::get('/advertisement', [App\Http\Controllers\AdvertisementController::class, 'create'])
        ->name('advertisement');
    Route::post('/advertisement', [App\Http\Controllers\AdvertisementController::class, 'store'])
        ->name('advertisement.store');
    Route::get('/advertisement/{ad}/edit', [App\Http\Controllers\AdvertisementController::class, 'edit'])
        ->name('advertisement.edit');
    Route::patch('/advertisement/{ad}', [App\Http\Controllers\AdvertisementController::class, 'update'])
        ->name('advertisement.update');
    Route::delete('/ads/{ad}', [App\Http\Controllers\AdvertisementController::class, 'destroy'])
        ->name('advertisement.destroy');
});

// ============================================================================
// AUTHENTICATION ROUTES
// ============================================================================

require __DIR__.'/auth.php';