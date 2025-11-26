<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Secure Checkout • Weru Hardware</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --primary-light: #fff7ed;
        }
        body { font-family: 'Inter', sans-serif; }
        .btn-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(249, 115, 22, 0.3); }
        .input-focus:focus { outline: none; border-color: #f97316; box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2); }
        .payment-option:checked + label { @apply ring-4 ring-orange-300 bg-orange-50 border-orange-500; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="page-container py-8 max-w-7xl mx-auto px-6">

    <!-- Header -->
    <div class="bg-white rounded-3xl shadow-xl p-8 mb-10 flex justify-between items-center flex-wrap gap-6">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 bg-gradient-to-br from-orange-600 to-orange-700 rounded-2xl flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-hard-hat text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-black text-gray-900">Weru<span class="text-orange-600">Hardware</span></h1>
        </div>
        <a href="{{ route('cart') }}" class="flex items-center gap-3 text-orange-600 font-bold hover:text-orange-700 transition">
            <i class="fa-solid fa-arrow-left"></i> 
            Back to Cart ({{ \App\Models\Cart::current()->totalItems() }} items)
        </a>
    </div>

    <!-- Page Title -->
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-5xl font-black text-gray-900 mb-4">Secure Checkout</h2>
        <p class="text-base md:text-xl text-gray-600">Complete your order in under 2 minutes</p>
    </div>

    @php
        $cart = \App\Models\Cart::current();
        $subtotal = $cart->subtotal();
        $totalItems = $cart->totalItems();
        $delivery = $totalItems > 0 ? 25000 : 0;
        $vat = round($subtotal * 0.18);
        $total = $subtotal + $delivery + $vat;
    @endphp

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- Left: Form -->
            <div class="lg:col-span-8 space-y-8">

                <!-- Contact Information -->
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <span class="text-orange-600 font-black text-xl">1</span>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900">Contact Information</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Full Name <span class="text-red-600">*</span></label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                   class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl input-focus transition" placeholder="Peter Mushi">
                            @error('name') <p class="text-red-600 text-sm mt-2"><i class="fa-solid fa-exclamation-triangle"></i> {{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Phone Number <span class="text-red-600">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                   class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl input-focus transition" 
                                   placeholder="0616 012 915">
                            @error('phone') <p class="text-red-600 text-sm mt-2"><i class="fa-solid fa-exclamation-triangle"></i> {{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email Address <span class="text-red-600">*</span></label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                                   class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl input-focus transition" placeholder="peter@example.com">
                            @error('email') <p class="text-red-600 text-sm mt-2"><i class="fa-solid fa-exclamation-triangle"></i> {{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <span class="text-orange-600 font-black text-xl">2</span>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900">Delivery Address</h3>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Full Address <span class="text-red-600">*</span></label>
                            <input type="text" name="address" value="{{ old('address') }}" required class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl input-focus transition" placeholder="Plot 123, Mwananyamala">
                            @error('address') <p class="text-red-600 text-sm mt-2"><i class="fa-solid fa-exclamation-triangle"></i> {{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Region <span class="text-red-600">*</span></label>
                                <select name="region" required class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl input-focus transition">
                                    <option value="">Select Region</option>
                                    @foreach(['Dar es Salaam','Arusha','Mwanza','Dodoma','Mbeya','Morogoro','Tanga','Kilimanjaro','Zanzibar','Other'] as $region)
                                        <option value="{{ $region }}" {{ old('region') == $region ? 'selected' : '' }}>{{ $region }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">City / District <span class="text-red-600">*</span></label>
                                <input type="text" name="city" value="{{ old('city') }}" required class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl input-focus transition" placeholder="Ilala">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Delivery Notes (Optional)</label>
                            <textarea name="notes" rows="3" class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl input-focus transition resize-none" placeholder="Near mosque, red gate, call when close...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method Selection -->
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <span class="text-orange-600 font-black text-xl">3</span>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900">Payment Method</h3>
                    </div>

                    <div class="space-y-5">
                        <!-- Cash on Delivery (DEFAULT & RECOMMENDED) -->
                        <label class="flex items-start gap-5 p-6 rounded-2xl border-2 border-gray-200 hover:border-orange-400 cursor-pointer transition-all">
                            <input type="radio" name="payment_method" value="cash_on_delivery" checked class="mt-1 w-6 h-6 text-orange-600">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-truck text-3xl text-green-600"></i>
                                    <div>
                                        <p class="text-xl font-bold text-gray-900">Cash on Delivery (Recommended)</p>
                                        <p class="text-gray-600">Pay with cash, M-Pesa, or bank transfer when you receive your items</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-3">Most popular • No online payment needed • We call you to confirm</p>
                            </div>
                        </label>

                        <!-- Pay Now with Mobile Money -->
                        <label class="flex items-start gap-5 p-6 rounded-2xl border-2 border-gray-200 hover:border-orange-400 cursor-pointer transition-all">
                            <input type="radio" name="payment_method" value="selcom" class="mt-1 w-6 h-6 text-orange-600">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-mobile-alt text-3xl text-blue-600"></i>
                                    <div>
                                        <p class="text-xl font-bold text-gray-900">Pay Now with Mobile Money</p>
                                        <p class="text-gray-600">Instant payment via M-Pesa, Tigo Pesa, Airtel Money, HaloPesa</p>
                                    </div>
                                </div>
                                <p class="text-sm text-green-600 font-bold mt-3">Get your order faster • 100% secure • Powered by Selcom</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-4">
                <div class="bg-gradient-to-br from-orange-600 to-orange-700 rounded-3xl shadow-2xl p-8 text-white sticky top-6">

                    <h3 class="text-2xl font-black mb-8">Order Summary</h3>

                    @if($totalItems > 0)
                        <div class="mb-6 max-h-64 overflow-y-auto space-y-3">
                            @foreach($cart->items as $id => $item)
                                <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                                    <div class="flex gap-3">
                                        <div class="w-16 h-16 bg-white/20 rounded-lg overflow-hidden">
                                            @if($item['image'])<img src="{{ asset('storage/'.$item['image']) }}" class="w-full h-full object-cover">@else
                                                <div class="w-full h-full flex items-center justify-center"><i class="fa-solid fa-box text-white text-xl"></i></div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-sm truncate">{{ $item['name'] }}</h4>
                                            <p class="text-xs opacity-90 mt-1">{{ $item['quantity'] }} × TZS {{ number_format($item['price']) }}</p>
                                            <p class="text-sm font-bold mt-1">TZS {{ number_format($item['price'] * $item['quantity']) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t-2 border-white/30 pt-6 space-y-5 text-lg">
                            <div class="flex justify-between"><span>Subtotal ({{ $totalItems }} items)</span><span class="font-bold">TZS {{ number_format($subtotal) }}</span></div>
                            <div class="flex justify-between"><span>Delivery Fee</span><span class="font-bold">TZS {{ number_format($delivery) }}</span></div>
                            <div class="flex justify-between"><span>VAT (18%)</span><span class="font-bold">TZS {{ number_format($vat) }}</span></div>
                            <div class="pt-6 border-t-2 border-white/30">
                                <div class="flex justify-between items-baseline">
                                    <span class="text-xl font-bold">Total Amount</span>
                                    <span class="text-4xl font-black">TZS {{ number_format($total) }}</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-hover w-full mt-10 py-6 bg-white text-orange-600 font-black text-xl rounded-2xl shadow-2xl transition-all duration-300 flex items-center justify-center gap-3">
                            <i class="fa-solid fa-check-circle text-2xl"></i>
                            Complete Order
                        </button>

                        <div class="mt-8 text-center text-sm">
                            <p class="opacity-90">Powered by <strong>Selcom</strong> • Trusted by 1000+ Tanzanian businesses</p>
                            <p class="text-xs mt-3 opacity-80">M-Pesa • Tigo Pesa • Airtel Money • HaloPesa • Cash on Delivery</p>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <i class="fa-solid fa-cart-shopping text-6xl opacity-50 mb-4"></i>
                            <p class="text-xl font-bold">Your cart is empty</p>
                            <a href="{{ route('products') }}" class="mt-6 inline-block px-8 py-4 bg-white text-orange-600 font-bold rounded-xl">Browse Products</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>

    <footer class="mt-20 text-center text-gray-600">
        <p class="text-lg font-medium">© {{ date('Y') }} Weru Hardware • Tanzania's #1 Building Materials Supplier</p>
        <p class="mt-4 text-sm">
            <a href="tel:+255616012915" class="text-orange-600 hover:underline">+255 616 012 915</a> •
            <a href="https://wa.me/255616012915" class="text-orange-600 hover:underline">WhatsApp</a>
        </p>
    </footer>
</div>
</body>
</html>