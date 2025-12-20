<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Shopping Cart • Oweru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { -webkit-tap-highlight-color: transparent; }
        html { scroll-behavior: smooth; }
        :root {
            --primary: rgb(218,165,32);
            --dark-blue: #002147;
            --light-bg: #f5f5f5;
        }
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #f9f9f9 0%, #f5f5f5 100%);
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .animate-slide-in { animation: slideInUp 0.5s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
        .animate-scale-in { animation: scaleIn 0.3s ease-out forwards; }
        .badge-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }

        .cart-item { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border-radius: 16px; }
        .cart-item:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -5px rgba(0, 33, 71, 0.15); }

        .glass-effect { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
        .smooth-shadow { box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 10px 13px rgba(0, 0, 0, 0.1); }

        .quantity-btn { min-width: 44px; min-height: 44px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; }
        .quantity-btn:hover { transform: scale(1.05); background-color: rgba(218,165,32, 0.1); }
        .quantity-btn:active { transform: scale(0.95); }

        .text-responsive-title { font-size: clamp(1.75rem, 6vw, 2.25rem); }
        .text-responsive-subtitle { font-size: clamp(0.875rem, 2vw, 1rem); }

        header { position: sticky; top: 0; z-index: 50; background: linear-gradient(135deg, #002147, #001a33); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: rgb(218,165,32); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #d4af37; }

        @media (max-width: 640px) {
            button, a { min-height: 44px; min-width: 44px; }
        }

        @media (max-width: 768px) {
            .cart-item-layout { flex-direction: column; }
            .cart-image { width: 100%; height: auto; aspect-ratio: 16/9; }
            .order-summary-mobile { position: static; }
        }

        @media (min-width: 769px) {
            .cart-image { width: 120px; height: 120px; flex-shrink: 0; }
            .order-summary-mobile { position: sticky; }
        }
    </style>
</head>
<body class="bg-slate-50 antialiased">

    <!-- Success Notification -->
    @if(session('success'))
        <div class="fixed top-20 right-4 z-50 bg-green-600 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg sm:rounded-xl shadow-2xl transform transition-all duration-300 opacity-100 translate-y-0 animate-fade-in flex items-center gap-2 sm:gap-3 text-sm sm:text-base">
            <i class="fa-solid fa-check-circle flex-shrink-0"></i>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
        <script>
            setTimeout(() => {
                const n = document.querySelector('[data-notification]');
                if(n) { n.classList.add('opacity-0', 'translate-y-2'); setTimeout(() => n.remove(), 300); }
            }, 3000);
        </script>
    @endif

    <!-- Header -->
    <header>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <div class="flex items-center gap-3 lg:gap-6">
                    <div class="flex-shrink-0 group">
                        <a href="/" class="flex items-center gap-2 transform group-hover:scale-105 transition">
                            <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, rgb(218,165,32), #002147);">
                                <i class="fa-solid fa-shopping-cart text-white text-lg lg:text-xl"></i>
                            </div>
                            <span class="text-lg lg:text-xl font-black text-white leading-tight hidden sm:inline-block">
                                Oweru<span style="color: rgb(218,165,32);">Hardware</span>
                            </span>
                        </a>
                    </div>
                    <nav class="hidden md:flex gap-4 lg:gap-8 items-center">
                        <a href="{{ url('dashboard') }}" class="font-medium text-gray-100 text-sm lg:text-base transition" style="color: rgba(218,165,32, 0.8);">Dashboard</a>
                        <a href="{{ url('order') }}" class="font-medium text-sm lg:text-base transition" style="color: rgba(218,165,32, 0.8);">Orders</a>
                        <a href="{{ route('products') }}" class="font-medium text-sm lg:text-base transition" style="color: rgba(218,165,32, 0.8);">Products</a>
                    </nav>
                </div>

                <div class="flex items-center gap-3 sm:gap-6">
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg transition" style="background: rgba(218,165,32, 0.1); color: rgb(218,165,32);">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>

                    @auth
                        <div class="hidden md:flex items-center gap-2 lg:gap-4 px-3 py-1.5 rounded-lg" style="background: rgba(218,165,32, 0.1);">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold" style="background: rgb(218,165,32); color: #000000;">
                                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                            </div>
                            <span class="text-sm font-medium" style="color: rgba(218,165,32, 0.9);">{{ Str::limit(Auth::user()->name ?? 'User', 15) }}</span>
                        </div>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="hidden md:inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg transition" style="color: rgba(218,165,32, 0.8);">
                            <i class="fa-solid fa-sign-in-alt"></i>Sign In
                        </a>
                    @endguest

                    <a href="{{ route('cart') }}" class="relative inline-flex items-center gap-2 px-4 lg:px-5 py-2.5 lg:py-3 rounded-lg font-bold text-xs lg:text-sm transition hover:shadow-lg transform hover:scale-105" style="background: rgb(218,165,32); color: #000000;">
                        <i class="fa-solid fa-shopping-cart"></i>
                        <span class="hidden sm:inline">Cart</span>
                        <span class="absolute -top-2 -right-2 text-xs font-black rounded-full h-6 w-6 flex items-center justify-center" style="background: #d32f2f; color: white;">
                            {{ \App\Models\Cart::current()->totalItems() }}
                        </span>
                    </a>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-gray-700">
                <nav class="flex flex-col gap-3 mt-4">
                    <a href="{{ url('dashboard') }}" class="block px-4 py-3 rounded-lg text-sm font-medium transition hover:scale-105" style="background: rgba(218,165,32, 0.1); color: rgba(218,165,32, 0.9);">
                        <i class="fa-solid fa-th-large mr-3"></i>Dashboard
                    </a>
                    <a href="{{ url('order') }}" class="block px-4 py-3 rounded-lg text-sm font-medium transition hover:scale-105" style="background: rgba(218,165,32, 0.1); color: rgba(218,165,32, 0.9);">
                        <i class="fa-solid fa-receipt mr-3"></i>Orders
                    </a>
                    <a href="{{ route('products') }}" class="block px-4 py-3 rounded-lg text-sm font-medium transition hover:scale-105" style="background: rgba(218,165,32, 0.1); color: rgba(218,165,32, 0.9);">
                        <i class="fa-solid fa-box mr-3"></i>Products
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="block px-4 py-3 rounded-lg text-sm font-medium transition hover:scale-105" style="background: rgb(218,165,32); color: #000000;">
                            <i class="fa-solid fa-sign-in-alt mr-3"></i>Sign In
                        </a>
                    @endguest
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-12">

        <!-- Page Title -->
        <div class="mb-8 lg:mb-12 animate-slide-in">
            <h2 class="text-responsive-title font-black text-gray-900 mb-2">Shopping Cart</h2>
            <p class="text-responsive-subtitle text-gray-600">
                <i class="fa-solid fa-info-circle mr-2" style="color: rgb(218,165,32);"></i>Review and manage your items
            </p>
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
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

                <!-- Cart Items -->
                <div class="lg:col-span-8 space-y-4 lg:space-y-6">
                    @foreach($cart->items as $id => $item)
                        @php
                            $itemTotal = $item['price'] * $item['quantity'];
                        @endphp

                        <div class="cart-item bg-white rounded-xl lg:rounded-2xl shadow-lg border border-gray-100 overflow-hidden smooth-shadow animate-scale-in" style="border-color: rgba(218, 165, 32, 0.1);">
                            <div class="p-4 sm:p-6 flex flex-col sm:flex-row gap-4 sm:gap-6 cart-item-layout">
                                <!-- Product Image -->
                                <div class="cart-image bg-gradient-to-br from-gray-100 to-gray-50 rounded-lg sm:rounded-xl overflow-hidden border border-gray-200">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fa-solid fa-box text-4xl lg:text-5xl text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Details -->
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-3 sm:mb-4">
                                        <div class="flex-1">
                                            <h3 class="text-lg lg:text-xl font-bold text-gray-900 line-clamp-2">{{ $item['name'] }}</h3>
                                            <p class="text-xs lg:text-sm text-gray-500 mt-1">{{ $item['category'] ?? 'Building Materials' }}</p>
                                        </div>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Remove this item?')" class="flex-shrink-0 ml-2">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg transition hover:scale-110 transform" style="background: rgba(211, 47, 47, 0.1); color: #d32f2f;" title="Remove item">
                                                <i class="fa-solid fa-trash text-lg"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Stock Status -->
                                    <div class="mb-3 sm:mb-4">
                                        @if($item['stock'] > 0)
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold" style="background: rgba(76, 175, 80, 0.1); color: #4caf50;">
                                                <span class="w-2 h-2 rounded-full badge-pulse" style="background: #4caf50;"></span> In Stock
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold" style="background: rgba(211, 47, 47, 0.1); color: #d32f2f;">
                                                <i class="fa-solid fa-times"></i> Out of Stock
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Quantity & Price -->
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div class="flex items-center gap-2 sm:gap-4">
                                            <div class="flex items-center border-2 rounded-lg sm:rounded-xl overflow-hidden" style="border-color: rgba(218, 165, 32, 0.2);">
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="decrease">
                                                    <button type="submit" class="quantity-btn {{ $item['quantity'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}" style="color: #002147;" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                        <i class="fa-solid fa-minus"></i>
                                                    </button>
                                                </form>
                                                <span class="px-4 sm:px-6 py-2 lg:py-3 font-bold text-base lg:text-lg" style="color: #002147;">{{ $item['quantity'] }}</span>
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="increase">
                                                    <button type="submit" class="quantity-btn" style="color: #002147;">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            @if(isset($item['min_order']) && $item['min_order'] > 1)
                                                <span class="text-xs lg:text-sm text-gray-500">
                                                    Min: {{ $item['min_order'] }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="text-right">
                                            <p class="text-xl lg:text-2xl font-black" style="color: rgb(218,165,32);">TZS {{ number_format($itemTotal) }}</p>
                                            <p class="text-xs lg:text-sm text-gray-500">{{ number_format($item['price']) }}/{{ $item['unit'] ?? 'unit' }}</p>
                                        </div>
                                    </div>

                                    @if(isset($item['min_order']) && $item['quantity'] < $item['min_order'])
                                        <div class="mt-3 sm:mt-4 p-3 rounded-lg text-xs lg:text-sm font-medium" style="background: rgba(255, 152, 0, 0.1); color: #f57c00; border: 1px solid rgba(255, 152, 0, 0.3);">
                                            <i class="fa-solid fa-exclamation-triangle mr-2"></i>
                                            Min order: <strong>{{ $item['min_order'] }} {{ $item['unit'] ?? 'pcs' }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-4 order-summary-mobile">
                    <div class="glass-effect rounded-xl lg:rounded-2xl shadow-xl p-6 lg:p-8 smooth-shadow animate-fade-in" style="border: 2px solid rgba(218, 165, 32, 0.2); top: 100px;">
                        <h3 class="text-xl lg:text-2xl font-black text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-receipt" style="color: rgb(218,165,32);"></i>
                            Order Summary
                        </h3>

                        <div class="space-y-4 lg:space-y-5 text-sm lg:text-base">
                            <div class="flex justify-between items-center p-3 lg:p-4 rounded-lg" style="background: rgba(218,165,32, 0.05);">
                                <span class="text-gray-700">Subtotal <span class="text-xs text-gray-500">({{ $totalItems }} items)</span></span>
                                <span class="font-bold" style="color: #002147;">TZS {{ number_format($subtotal) }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 lg:p-4 rounded-lg" style="background: rgba(218,165,32, 0.05);">
                                <span class="text-gray-700" style="color: #666666;">Delivery Fee</span>
                                <span class="font-bold" style="color: #002147;">TZS {{ number_format($deliveryFee) }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 lg:p-4 rounded-lg" style="background: rgba(218,165,32, 0.05);">
                                <span class="text-gray-700" style="color: #666666;">VAT (18%)</span>
                                <span class="font-bold" style="color: #002147;">TZS {{ number_format($vat) }}</span>
                            </div>
                            <div class="pt-4 lg:pt-5 border-t-2" style="border-color: rgba(218, 165, 32, 0.2);">
                                <div class="flex justify-between items-baseline">
                                    <span class="font-bold text-gray-900">Total Amount</span>
                                    <span class="text-2xl lg:text-3xl font-black" style="color: rgb(218,165,32);">TZS {{ number_format($grandTotal) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 lg:mt-8 space-y-3 lg:space-y-4">
                            <a href="{{ route('checkout.process') }}" class="block w-full text-center py-3 lg:py-5 text-white font-black text-base lg:text-lg rounded-lg lg:rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-300" style="background: linear-gradient(135deg, #002147, #001a33);">
                                <i class="fa-solid fa-lock mr-2"></i>
                                <span class="hidden sm:inline">Proceed to Secure</span><span class="sm:hidden">Checkout</span>
                            </a>
                            <a href="{{ route('products') }}" class="block text-center py-3 lg:py-4 font-bold rounded-lg lg:rounded-xl transition" style="background: rgba(218,165,32, 0.1); color: rgb(218,165,32); border: 2px solid rgb(218,165,32);">
                                <i class="fa-solid fa-shopping-bag mr-2"></i>Continue Shopping
                            </a>
                        </div>

                        <div class="mt-6 lg:mt-8 p-4 lg:p-5 rounded-lg lg:rounded-xl text-sm text-gray-700" style="background: rgba(76, 175, 80, 0.05); border: 1px solid rgba(76, 175, 80, 0.2);">
                            <p class="font-bold mb-2" style="color: #4caf50;"><i class="fa-solid fa-shield-alt mr-2"></i> Secure Shopping</p>
                            <p class="text-xs lg:text-sm text-gray-600">Your payment information is encrypted and secure. We never store your card details.</p>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <!-- Empty Cart State -->
            <div class="text-center py-16 lg:py-24 bg-white rounded-2xl lg:rounded-3xl shadow-lg border-2 border-dashed border-gray-200 animate-fade-in">
                <div class="mb-6 inline-block p-6 rounded-full" style="background: rgba(218,165,32, 0.1);">
                    <i class="fa-solid fa-cart-shopping text-5xl lg:text-6xl" style="color: rgb(218,165,32);"></i>
                </div>
                <h3 class="text-xl lg:text-2xl font-black text-gray-900 mb-4">Your Cart is Empty</h3>
                <p class="text-sm lg:text-lg text-gray-600 mb-8 lg:mb-10 max-w-md mx-auto px-4 leading-relaxed">
                    Start shopping and build something great with our premium building materials!
                </p>
                <a href="{{ route('products') }}" class="inline-flex items-center gap-2 px-6 lg:px-10 py-3 lg:py-5 text-white font-black text-sm lg:text-lg rounded-lg lg:rounded-xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition" style="background: linear-gradient(135deg, #002147, #001a33);">
                    <i class="fa-solid fa-store"></i>
                    <span class="hidden sm:inline">Browse Products Now</span><span class="sm:hidden">Shop Now</span>
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="mt-16 lg:mt-24 py-12 lg:py-16 text-blue-100 border-t-2" style="background: linear-gradient(135deg, #002147, #001a33); border-color: rgba(218, 165, 32, 0.2);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 mb-8">
                <!-- Brand -->
                <div class="animate-fade-in text-center md:text-left">
                    <h3 class="text-lg lg:text-xl font-black text-white mb-3">
                        Oweru<span style="color: rgb(218,165,32);">Hardware</span>
                    </h3>
                    <p class="text-sm text-blue-200">Tanzania's premier building materials supplier with fast delivery nationwide.</p>
                </div>

                <!-- Quick Links -->
                <div class="animate-fade-in" style="animation-delay: 0.1s; text-center;">
                    <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('products') }}" class="transition hover:text-white" style="color: rgba(218,165,32, 0.8);">Products</a></li>
                        <li><a href="{{ route('order') }}" class="transition hover:text-white" style="color: rgba(218,165,32, 0.8);">My Orders</a></li>
                        <li><a href="#" class="transition hover:text-white" style="color: rgba(218,165,32, 0.8);">Support</a></li>
                    </ul>
                </div>

                <!-- Help -->
                <div class="animate-fade-in" style="animation-delay: 0.2s; text-center;">
                    <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Help & Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="transition hover:text-white" style="color: rgba(218,165,32, 0.8);">Privacy Policy</a></li>
                        <li><a href="#" class="transition hover:text-white" style="color: rgba(218,165,32, 0.8);">Terms & Conditions</a></li>
                        <li><a href="#" class="transition hover:text-white" style="color: rgba(218,165,32, 0.8);">Contact</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="border-t-2 pt-6 lg:pt-8 text-center text-xs lg:text-sm" style="border-color: rgba(218, 165, 32, 0.2);">
                <p class="text-blue-200 mb-2">&copy; {{ date('Y') }} Oweru Hardware. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript Enhancements -->
    <script>
        // Intersection Observer for Lazy Animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('animate-slide-in');
                    }, index * 50);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe Cart Items
        document.querySelectorAll('.cart-item').forEach(el => {
            observer.observe(el);
        });

        // Button Ripple Effect
        document.querySelectorAll('button[type="submit"], a').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (window.innerWidth > 768 && (this.tagName === 'BUTTON' || this.classList.contains('btn-action'))) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        background: rgba(255, 255, 255, 0.5);
                        border-radius: 50%;
                        left: ${x}px;
                        top: ${y}px;
                        pointer-events: none;
                        animation: ripple 0.6s ease-out;
                    `;
                    
                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);
                    
                    setTimeout(() => ripple.remove(), 600);
                }
            });
        });

        // Add Ripple Animation
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                const isOpen = !mobileMenu.classList.contains('hidden');
                mobileMenuBtn.innerHTML = isOpen 
                    ? '<i class="fa-solid fa-xmark text-lg"></i>' 
                    : '<i class="fa-solid fa-bars text-lg"></i>';
            });

            // Close menu when a link is clicked
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    mobileMenuBtn.innerHTML = '<i class="fa-solid fa-bars text-lg"></i>';
                });
            });
        }

        // Smooth Page Transitions
        window.addEventListener('load', () => {
            document.body.style.transition = 'opacity 0.3s ease';
            document.body.style.opacity = '1';
        });
    </script>
</body>
</html>