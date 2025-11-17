<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/catalog', function () {
    return view('catalog');
})->name('catalog');
Route::get('/shopping', function () {
    return view('shopping');
})->name('shopping');  
Route::get('/order', function () {
    return view('order');
})->name('order');
Route::get('/cart', function () {
    return view('cart');
})->name('cart');
Route::get('/adminDashboard', function () {
    return view('adminDashboard');
})->name('adminDashboard');

Route::get('/dashboard', function () {
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Product routes
Route::get('/show', [ProductController::class, 'show'])->name('show');
Route::get('indexProduct', [ProductController::class, 'index'])->name('indexProduct');
Route::get('/createProduct',[ProductController::class,'create'])->name('createProduct');
Route::post('/createProduct',[ProductController::class,'store']);
Route::get('/editProduct/{product}',[ProductController::class,'edit'])->name('editProduct');
Route::post('/updateProduct/{product}',[ProductController::class,'update'])->name('updateProduct');
Route::post('/deleteProduct/{product}',[ProductController::class,'destroy'])->name('deleteProduct');
Route::get('/products', [ProductController::class, 'products'])->name('products');



// Category routes
Route::get('/indexCategory', [CategoryController::class, 'index'])->name('indexCategory');
Route::get('/createCategory',[CategoryController::class,'create'])->name('createCategory');
Route::post('/createCategory',[CategoryController::class,'store']);
Route::get('/editCategory/{category}',[CategoryController::class,'edit'])->name('editCategory');
Route::post('/updateCategory/{category}',[CategoryController::class,'update'])->name('updateCategory');
Route::post('/deleteCategory/{category}',[CategoryController::class,'destroy'])->name('deleteCategory');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
// Add this line anywhere in web.php
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout')
    ->middleware('auth');   // ← This is the correct modern way
require __DIR__.'/auth.php';
