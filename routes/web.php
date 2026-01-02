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
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\SettingController;

// ============================================================================
// PUBLIC ROUTES (No authentication required)
// ============================================================================

Route::get('/', function () {
    return view('welcome');
});

// Contact form submission from landing page
Route::post('/contact', function (Request $request) {
    $data = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'phone'   => 'nullable|string|max:50',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:2000',
    ]);

    // Store in database
    ContactMessage::create($data);

    // Prepare email content
    $body = "New contact message from Oweru Hardware website:\n\n"
          . "Name: {$data['name']}\n"
          . "Email: {$data['email']}\n"
          . "Phone: " . ($data['phone'] ?? 'N/A') . "\n"
          . "Subject: {$data['subject']}\n\n"
          . "Message:\n{$data['message']}\n";

    try {
        Mail::raw($body, function ($message) use ($data) {
            $message->to(config('peterpatrick29@gmail.com'))
                    ->subject('Website Contact: ' . $data['subject']);
        });
        return back()->with('success', 'Thanks! Your message has been sent. We will contact you shortly.');
    } catch (\Throwable $e) {
        Log::error('Contact form failed to send', ['error' => $e->getMessage()]);
        // Fallback: still acknowledge user
        return back()->with('success', 'Thanks! Your message has been received.');
    }
})->name('contact.submit');

// Webhook routes (must be public, no CSRF)
Route::post('/selcom/webhook', [CheckoutController::class, 'handleWebhook'])
    ->name('selcom.webhook')
    ->withoutMiddleware('csrf');
Route::post('/webhook/selcom', [CheckoutController::class, 'webhook'])
    ->name('selcom.webhook.alternative')
    ->withoutMiddleware('csrf');





Route::middleware('auth')->group(function () {
    // User Profile (available to all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Product viewing (browsing) - available to all authenticated users
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('show');
    Route::get('/products', [ProductController::class, 'products'])->name('products');

    Route::get('/privacy', [SettingController::class, 'index'])->name('privacy');
    Route::get('/about', [SettingController::class, 'about'])->name('about');
    Route::get('/contact', [SettingController::class, 'contact'])->name('contact');

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
    Route::get('/order/{order}', [OrderController::class, 'showUserOrder'])->name('order.show');
    Route::get('/order/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('order.invoice');

    // Lightweight endpoint for logged-in user to get latest order status (for dashboard notifications)
    Route::get('/user/orders/latest', function () {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['latest_id' => null, 'order' => null]);
        }

        $ordersQuery = Order::where('user_id', $user->id)->orderByDesc('id');
        $latestOrder = $ordersQuery->first();
        $allOrders   = $ordersQuery->get();

        return response()->json([
            'latest_id' => $latestOrder?->id,
            'order' => $latestOrder ? [
                'id'             => $latestOrder->id,
                'order_number'   => $latestOrder->order_number,
                'status'         => $latestOrder->status,
                'payment_status' => $latestOrder->payment_status,
                'total_amount'   => $latestOrder->total_amount,
                'updated_at'     => optional($latestOrder->updated_at)->toIso8601String(),
            ] : null,
            // All orders for seeding notifications (includes older orders)
            'orders' => $allOrders->map(function ($order) {
                return [
                    'id'             => $order->id,
                    'order_number'   => $order->order_number,
                    'status'         => $order->status,
                    'payment_status' => $order->payment_status,
                    'total_amount'   => $order->total_amount,
                    'updated_at'     => optional($order->updated_at)->toIso8601String(),
                ];
            }),
        ]);
    })->name('user.orders.latest');
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

    // Lightweight endpoint for live new-order notifications on admin dashboard
    Route::get('/admin/orders/latest', function () {
        $ordersQuery = Order::with('user')->orderByDesc('id');
        $latestOrder = $ordersQuery->first();
        $allOrders   = $ordersQuery->get();

        return response()->json([
            'latest_id'   => $latestOrder?->id,
            'latest_time' => $latestOrder?->created_at?->toIso8601String(),
            'order'       => $latestOrder ? [
                'id'            => $latestOrder->id,
                'order_number'  => $latestOrder->order_number,
                'customer_name' => $latestOrder->customer_name ?? optional($latestOrder->user)->name ?? 'Guest',
                'total_amount'  => $latestOrder->total_amount,
                'status'        => $latestOrder->status,
            ] : null,
            'orders' => $allOrders->map(function ($order) {
                return [
                    'id'            => $order->id,
                    'order_number'  => $order->order_number,
                    'customer_name' => $order->customer_name ?? optional($order->user)->name ?? 'Guest',
                    'total_amount'  => $order->total_amount,
                    'status'        => $order->status,
                    'created_at'    => optional($order->created_at)->toIso8601String(),
                ];
            }),
        ]);
    })->name('admin.orders.latest');

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
    Route::get('/checkout-management', function() {
        return view('checkoutManagement');
    })->name('checkoutManagement');
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

    // Contact messages listing for admin
    Route::get('/contact-messages', function () {
        $messages = ContactMessage::orderByDesc('created_at')->paginate(20);
        return view('contactMessages', compact('messages'));
    })->name('contact.messages');

    Route::delete('/contact-messages/{message}', function (ContactMessage $message) {
        $message->delete();
        return back()->with('success', 'Message deleted.');
    })->name('contact.messages.destroy');
});

// ============================================================================
// AUTHENTICATION ROUTES
// ============================================================================

require __DIR__.'/auth.php';