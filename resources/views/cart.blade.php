<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart • Weru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --secondary: #fbbf24;
        }
        body { font-family: 'Inter, sans-serif; }
        .cart-item { transition: all 0.3s ease; }
        .cart-item:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(249, 115, 22, 0.15); }
        .quantity-btn { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Success Notification -->
    @if(session('success'))
        <div class="fixed top-24 right-6 z-50 bg-green-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 animate-pulse">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => document.querySelector('.animate-pulse').remove(), 4000);
        </script>
    @endif

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-600 to-orange-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                </div>
                <h1 class="text-2xl font-black text-gray-900">Weru<span class="text-orange-600">Hardware</span></h1>
            </div>

            <nav class="hidden lg:flex items-center gap-10 font-medium">
                <a href="{{ url('dashboard') }}" class="hover:text-orange-600 transition">Dashboard</a>
                <a href="{{ url('order') }}" class="hover:text-orange-600 transition">My Orders</a>
                <a href="{{ route('products') }}" class="hover:text-orange-600 transition">Products</a>
                <a href="{{ route('cart') }}" class="text-orange-600 font-bold flex items-center gap-2">
                    Cart 
                    <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full text-xs font-bold">
                        {{ \App\Models\Cart::current()->totalItems() }}
                    </span>
                </a>
            </nav>

            <div class="flex items-center gap-5">
                @auth
                    <div class="flex items-center gap-4">
                        <div class="text-right hidden sm:block">
                            <p class="font-bold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Customer</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-600 to-orange-700 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-orange-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-orange-700 transition shadow-lg">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">

        <!-- Page Title -->
        <div class="mb-10">
            <h2 class="text-4xl font-black text-gray-900 mb-2">Your Shopping Cart</h2>
            <p class="text-lg text-gray-600">Review items and proceed to secure checkout</p>
        </div>

        @php
            $cart = \App\Models\Cart::current();
            $subtotal = $cart->subtotal();
            $totalItems = $cart->totalItems();
            $deliveryFee = $totalItems > 0 ? 25000 : 0;
            $vat = round($subtotal * 0.18);
            $grandTotal = $subtotal + $deliveryFee + $vat;
        @endphp

        @if($totalItems > 0)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Cart Items -->
                <div class="lg:col-span-8 space-y-6">
                    @foreach($cart->items as $id => $item)
                        @php
                            $itemTotal = $item['price'] * $item['quantity'];
                        @endphp

                        <div class="cart-item bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="p-6 flex gap-6">
                                <!-- Product Image -->
                                <div class="w-32 h-32 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 border border-gray-200">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fa-solid fa-box text-4xl text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Details -->
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900">{{ $item['name'] }}</h3>
                                            <p class="text-sm text-gray-500 mt-1">{{ $item['category'] ?? 'Building Materials' }}</p>
                                        </div>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Remove this item?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                                <i class="fa-solid fa-xmark text-xl"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Stock Status -->
                                    <div class="mb-4">
                                        @if($item['stock'] > 0)
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                                <i class="fa-solid fa-check"></i> In Stock
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                                                <i class="fa-solid fa-times"></i> Out of Stock
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Quantity & Price -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center border-2 border-gray-300 rounded-xl overflow-hidden">
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="decrease">
                                                    <button type="submit" class="quantity-btn hover:bg-gray-100 transition {{ $item['quantity'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                        {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                        <i class="fa-solid fa-minus"></i>
                                                    </button>
                                                </form>
                                                <span class="px-6 py-3 font-bold text-lg">{{ $item['quantity'] }}</span>
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="increase">
                                                    <button type="submit" class="quantity-btn hover:bg-gray-100 transition">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            @if(isset($item['min_order']) && $item['min_order'] > 1)
                                                <span class="text-sm text-gray-500">
                                                    Min: {{ $item['min_order'] }} {{ $item['unit'] ?? 'pcs' }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="text-right">
                                            <p class="text-2xl font-black text-gray-900">TZS {{ number_format($itemTotal) }}</p>
                                            <p class="text-sm text-gray-500">TZS {{ number_format($item['price']) }} / {{ $item['unit'] ?? 'unit' }}</p>
                                        </div>
                                    </div>

                                    @if(isset($item['min_order']) && $item['quantity'] < $item['min_order'])
                                        <div class="mt-4 p-3 bg-orange-50 border border-orange-300 rounded-lg text-sm text-orange-800 font-medium">
                                            <i class="fa-solid fa-exclamation-triangle mr-2"></i>
                                            Minimum order: <strong>{{ $item['min_order'] }} {{ $item['unit'] ?? 'pcs' }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-4">
                    <div class="bg-gradient-to-b from-orange-50 to-white rounded-2xl shadow-xl border border-orange-200 p-8 sticky top-24">
                        <h3 class="text-2xl font-black text-gray-900 mb-6">Order Summary</h3>

                        <div class="space-y-5 text-lg">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal ({{ $totalItems }} items)</span>
                                <span class="font-bold">TZS {{ number_format($subtotal) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Delivery Fee</span>
                                <span class="font-bold">TZS {{ number_format($deliveryFee) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">VAT (18%)</span>
                                <span class="font-bold">TZS {{ number_format($vat) }}</span>
                            </div>
                            <div class="pt-5 border-t-2 border-orange-300">
                                <div class="flex justify-between items-baseline">
                                    <span class="text-xl font-bold text-gray-900">Total Amount</span>
                                    <span class="text-3xl font-black text-orange-600">TZS {{ number_format($grandTotal) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 space-y-4">
                            <a href="{{ route('checkout.process') }}" class="block w-full text-center py-5 bg-gradient-to-r from-orange-600 to-orange-700 text-white font-black text-xl rounded-xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition duration-300">
                                <i class="fa-solid fa-lock mr-3"></i>
                                Proceed to Secure Checkout
                            </a>
                            <a href="{{ route('products') }}" class="block text-center py-4 border-2 border-orange-600 text-orange-600 font-bold rounded-xl hover:bg-orange-50 transition">
                                Continue Shopping
                            </a>
                        </div>

                        <div class="mt-8 p-5 bg-orange-50 rounded-xl border border-orange-200 text-sm text-gray-700">
                            <p class="font-bold text-orange-800 mb-2"><i class="fa-solid fa-shield-alt mr-2"></i> Secure Shopping</p>
                            <p>Your payment information is encrypted and secure. We never store your card details.</p>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <!-- Empty Cart State -->
            <div class="text-center py-24 bg-white rounded-3xl shadow-lg border-2 border-dashed border-gray-300">
                <div class="w-32 h-32 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fa-solid fa-cart-shopping text-6xl text-orange-600"></i>
                </div>
                <h3 class="text-4xl font-black text-gray-900 mb-4">Your Cart is Empty</h3>
                <p class="text-xl text-gray-600 mb-10 max-w-md mx-auto">
                    Looks like you haven't added any building materials yet. Start shopping and build something great!
                </p>
                <a href="{{ route('products') }}" class="inline-flex items-center gap-4 px-10 py-5 bg-gradient-to-r from-orange-600 to-orange-700 text-white font-black text-xl rounded-xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition">
                    <i class="fa-solid fa-store"></i>
                    Browse Products Now
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="mt-20 bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-lg">&copy; {{ date('Y') }} Weru Hardware • Tanzania's Trusted Building Materials Partner</p>
            <p class="mt-4 text-sm">
                <a href="#" class="hover:text-white transition">Privacy Policy</a> • 
                <a href="#" class="hover:text-white transition">Terms of Service</a> • 
                <a href="#" class="hover:text-white transition">Contact Us</a>
            </p>
        </div>
    </footer>
</body>
</html>