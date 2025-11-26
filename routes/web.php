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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/selcom/callback', 'SelcomController@handleCallback'); // Package creates this
Route::post('/selcom/webhook', function (Request $request) {
    Selcom::handleWebhook($request->all());
    return response()->json(['status' => 'ok']);
});
 
Route::post('/selcom/webhook', [CheckoutController::class, 'handleWebhook']);

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])
        ->name('checkout.success');
        
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])
        ->name('checkout.cancel');
});
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Product routes
    Route::get('/show', [ProductController::class, 'show'])->name('show');

    Route::get('/indexProduct', [ProductController::class, 'index'])
        ->name('indexProduct');

    Route::get('/products', [ProductController::class, 'products'])
        ->name('products');

    // Cart view route
    Route::middleware('auth')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});});


//Order routes
Route::middleware(['auth'])->group(function () {
    Route::get('/order', [OrderController::class, 'index'])
     ->name('order');
    Route::get('/OrderManagement', [OrderController::class, 'manage'])->name('OrderManagement');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::patch('orders/{order}/update-status', [OrderController::class, 'updateStatus'])
    ->name('orders.update-status');
    
    // Product CRUD routes
    Route::get('/createProduct', [ProductController::class, 'create'])
        ->name('createProduct');
    Route::post('/createProduct', [ProductController::class, 'store']);

    Route::get('/editProduct/{product}', [ProductController::class, 'edit'])
        ->name('editProduct');
    Route::post('/updateProduct/{product}', [ProductController::class, 'update'])
        ->name('updateProduct');

    Route::post('/deleteProduct/{product}', [ProductController::class, 'destroy'])
        ->name('deleteProduct');

// Category routes
    Route::get('/indexCategory', [CategoryController::class, 'index'])->name('indexCategory');
    Route::get('/createCategory',[CategoryController::class,'create'])->name('createCategory');
    Route::post('/createCategory',[CategoryController::class,'store']);
    Route::get('/editCategory/{category}',[CategoryController::class,'edit'])->name('editCategory');
    Route::post('/updateCategory/{category}',[CategoryController::class,'update'])->name('updateCategory');
    Route::post('/deleteCategory/{category}',[CategoryController::class,'destroy'])->name('deleteCategory');

   

//User routes
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Admin Dashboard
    Route::get('/adminDashboard', function () {
        $orders = Order::with('user')->latest()->get();
        $products = \App\Models\Product::all(); 
        $users = \App\Models\User::all();
        return view('adminDashboard',compact('orders', 'products', 'users'));
    })->name('adminDashboard')       ;

    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])
        ->name('orders.destroy');

    });

//Selcom Payment Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'process']);
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('success');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('cancel');
Route::post('/webhook/selcom', [CheckoutController::class, 'webhook'])->name('selcom.webhook')->withoutMiddleware('csrf');

Route::get('/selcom-test', [App\Http\Controllers\SelcomController::class, 'createOrder'])->name('selcom-test');

//Advertisement routes
Route::get('/ads', [App\Http\Controllers\AdvertisementController::class, 'index'])->name('ads');
Route::get('/advertisement',[App\Http\Controllers\AdvertisementController::class,'create'])->name('advertisement');
Route::post('/advertisement',[App\Http\Controllers\AdvertisementController::class,'store'])->name('store');
Route::post('/ads/{id}',[App\Http\Controllers\AdvertisementController::class,'destroy'])->name('destroy');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/payment/success/{order}', [CheckoutController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [CheckoutController::class, 'cancel'])->name('payment.cancel');
});
    

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{orderId}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
    
    // Test routes
    Route::get('/selcom/test', [CheckoutController::class, 'testPage'])->name('selcom.test');
    Route::post('/selcom/test-payment', [CheckoutController::class, 'testPayment'])->name('selcom.test.payment');

// Webhook route (no auth middleware)
Route::post('/selcom/webhook', [CheckoutController::class, 'handleWebhook'])->name('selcom.webhook');
// Selcom test routes
    Route::get('/selcom/test', [CheckoutController::class, 'testPage'])->name('selcom.test');
    Route::post('/selcom/test', [CheckoutController::class, 'testPayment'])->name('selcom.test.pay');

Route::get('/selcom/test-credentials', [CheckoutController::class, 'testCredentials']);


require __DIR__.'/auth.php';
