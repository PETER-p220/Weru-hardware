<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Weru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .cart-item-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .cart-item-card:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <!-- Success Notification -->
    @if(session('success'))
        <div class="fixed top-20 right-4 z-50 bg-green-600 text-white px-6 py-3 rounded-lg shadow-2xl animate-pulse">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-gray-900">Weru Hardware</span>
                </div>
                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{ url('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Dashboard</a>
                    <a href="{{ url('order') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Orders</a>
                    <a href="{{ route('indexProduct') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Products</a>
                    <a href="{{ route('cart') }}" class="text-sm font-semibold text-blue-600">Cart ({{ count(session('cart', [])) }})</a>
                </nav>
                <div class="flex items-center gap-4">
                    @auth
                    <div class="flex items-center gap-3 pl-3 border-l border-gray-200">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Customer</p>
                        </div>
                        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Sign In</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Page Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Shopping Cart</h1>
                    <p class="text-sm text-gray-600 mt-1">Review and manage your cart items</p>
                </div>
                <div class="flex items-center gap-3">
                    @if(session('cart') && count(session('cart')) > 0)
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear entire cart?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Clear Cart
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('indexProduct') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 text-sm font-semibold">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('cart') && count(session('cart')) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Cart Items -->
                <div class="lg:col-span-8 space-y-4">
                    @php $subtotal = 0; @endphp
                    @foreach(session('cart') as $id => $item)
                        @php
                            $itemTotal = $item['price'] * $item['quantity'];
                            $subtotal += $itemTotal;
                        @endphp
                        <div class="cart-item-card bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <div class="p-6">
                                <div class="flex gap-6">
                                    <div class="w-24 h-24 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover rounded-xl">
                                        @else
                                            <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <h3 class="text-base font-bold text-gray-900 mb-1">{{ $item['name'] }}</h3>
                                                <div class="flex items-center gap-3 text-sm text-gray-600">
                                                    <span>{{ $item['category'] }}</span>
                                                    <span>•</span>
                                                    <span>SKU: {{ $id }}</span>
                                                </div>
                                            </div>
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 p-1">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                        <div class="mb-4">
                                            @if($item['stock'] > 0)
                                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-lg bg-green-100 text-green-700">
                                                    In Stock
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-lg bg-red-100 text-red-700">
                                                    Out of Stock
                                                </span>
                                            @endif
                                        </div>

                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex items-center border border-gray-300 rounded-lg">
                                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="action" value="decrease">
                                                        <button type="submit" class="px-3 py-2 hover:bg-gray-50">−</button>
                                                    </form>
                                                    <span class="w-16 text-center py-2 text-sm font-medium border-x border-gray-300">{{ $item['quantity'] }}</span>
                                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="action" value="increase">
                                                        <button type="submit" class="px-3 py-2 hover:bg-gray-50">+</button>
                                                    </form>
                                                </div>
                                                @if($item['min_order'])
                                                    <span class="text-xs text-gray-500">Min: {{ $item['min_order'] }}</span>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xl font-bold text-gray-900">TZS {{ number_format($itemTotal) }}</p>
                                                <p class="text-xs text-gray-500">TZS {{ number_format($item['price']) }} / {{ $item['unit'] }}</p>
                                            </div>
                                        </div>

                                        @if($item['min_order'] && $item['quantity'] < $item['min_order'])
                                            <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-800">
                                                Minimum order quantity is <strong>{{ $item['min_order'] }} {{ $item['unit'] }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-24">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Order Summary</h3>
                        @php
                            $deliveryFee = 15000;
                            $vat = $subtotal * 0.10;
                            $total = $subtotal + $deliveryFee + $vat;
                        @endphp
                        <div class="space-y-3 pb-4 mb-4 border-b border-gray-200">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal ({{ count(session('cart')) }} items)</span>
                                <span class="font-medium">TZS {{ number_format($subtotal) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Delivery Fee</span>
                                <span class="font-medium">TZS {{ number_format($deliveryFee) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">VAT (10%)</span>
                                <span class="font-medium">TZS {{ number_format($vat) }}</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-baseline mb-6">
                            <span class="text-base font-bold">Total</span>
                            <span class="text-2xl font-bold text-gray-900">TZS {{ number_format($total) }}</span>
                        </div>
                        <a href="{{ route('checkout') }}" class="block w-full text-center py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="bg-white rounded-xl border-2 border-dashed border-gray-300 p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-600 mb-8">Add some quality building materials to get started</p>
                <a href="{{ route('indexProduct') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg">
                    Start Shopping
                </a>
            </div>
        @endif
    </main>

    <footer class="bg-white border-t border-gray-200 mt-16 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-600">
            © {{ date('Y') }} Weru Hardware. All rights reserved.
        </div>
    </footer>
</body>
</html>