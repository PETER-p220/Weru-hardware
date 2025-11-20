<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout • Weru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --secondary: #fbbf24;
        }
        body { font-family: 'Inter', sans-serif; }
        .input-focus { transition: all 0.3s ease; }
        .input-focus:focus { ring: 2px; ring-color: #f97316; border-color: #f97316; }
        .btn-hover { transition: all 0.3s ease; }
        .btn-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(249, 115, 22, 0.3); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="fixed top-24 right-6 z-50 bg-green-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 animate-pulse">
            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="fixed top-24 right-6 z-50 bg-red-600 text-white px-6 py-4 rounded-xl shadow-2xl animate-pulse">
            <i class="fa-solid fa-exclamation-triangle mr-2"></i>
            {{ session('error') ?: 'Please correct the errors below' }}
        </div>
    @endif

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-600 to-orange-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                </div>
                <h1 class="text-2xl font-black text-gray-900">Weru<span class="text-orange-600">Hardware</span></h1>
            </div>

            <a href="{{ route('cart') }}" class="flex items-center gap-2 text-orange-600 font-bold hover:text-orange-700 transition">
                <i class="fa-solid fa-arrow-left"></i> Back to Cart ({{ $cart->getItemsCount() }} items)
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="text-center mb-10">
            <h2 class="text-4xl font-black text-gray-900 mb-3">Secure Checkout</h2>
            <p class="text-xl text-gray-600">Complete your order in under 2 minutes</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Checkout Form -->
            <div class="lg:col-span-8">
                <form action="{{ route('store') }}" method="POST" id="checkout-form" class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                    @csrf

                    <!-- Customer Info -->
                    <div class="p-8 border-b border-gray-100">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-user text-orange-600 text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-black text-gray-900">1. Contact Information</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Full Name *</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                       class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl input-focus focus:border-orange-600" placeholder="John Doe">
                                @error('name') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" required
                                       class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl input-focus focus:border-orange-600" placeholder="+255 712 345 678">
                                @error('phone') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Email Address *</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                                       class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl input-focus focus:border-orange-600" placeholder="john@example.com">
                                @error('email') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flexed items-center justify-center">
                                <i class="fa-solid fa-truck text-orange-600 text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-black text-gray-900">2. Delivery Address</h3>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Full Address *</label>
                                <input type="text" name="address" value="{{ old('address') }}" required
                                       class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl input-focus focus:border-orange-600"
                                       placeholder="Plot 123, Mwananyamala Street, Kinondoni, Dar es Salaam">
                                @error('address') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Region *</label>
                                    <select name="region" required class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl input-focus focus:border-orange-600">
                                        <option value="">Select Region</option>
                                        @foreach(['Dar es Salaam', 'Arusha', 'Mwanza', 'Dodoma', 'Mbeya', 'Morogoro', 'Tanga', 'Kilimanjaro', 'Zanzibar', 'Other'] as $region)
                                            <option value="{{ $region }}" {{ old('region') == $region ? 'selected' : '' }}>{{ $region }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">City / District *</label>
                                    <input type="text" name="city" value="{{ old('city') }}" required
                                           class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl input-focus focus:border-orange-600" placeholder="e.g. Ilala, Temeke">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Delivery Notes (Optional)</label>
                                <textarea name="notes" rows="3" class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl input-focus focus:border-orange-600"
                                          placeholder="Landmarks, gate number, preferred delivery time...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary & Payment -->
            <div class="lg:col-span-4">
                <div class="bg-gradient-to-br from-orange-600 to-orange-700 rounded-3xl shadow-2xl p-8 text-white sticky top-24">
                    <h3 class="text-2xl font-black mb-6">Order Summary</h3>

                    @php
                        $subtotal = $cart->getTotal();
                        $deliveryFee = $cart->getItemsCount() > 0 ? 25000 : 0;
                        $vat = $subtotal * 0.18;
                        $total = $subtotal + $deliveryFee + $vat;
                    @endphp

                    <div class="space-y-5 text-lg">
                        <div class="flex justify-between">
                            <span>Subtotal ({{ $cart->getItemsCount() }} items)</span>
                            <span class="font-bold">TZS {{ number_format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Delivery Fee</span>
                            <span class="font-bold">TZS {{ number_format($deliveryFee) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>VAT (18%)</span>
                            <span class="font-bold">TZS {{ number_format($vat) }}</span>
                        </div>
                        <div class="pt-6 border-t-2 border-white/30">
                            <div class="flex justify-between items-baseline">
                                <span class="text-xl font-bold">Total to Pay</span>
                                <span class="text-4xl font-black">TZS {{ number_format($total) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <button type="submit" form="checkout-form"
                            class="w-full mt-8 py-6 bg-white text-orange-600 font-black text-2xl rounded-2xl shadow-2xl hover:shadow-orange-500/50 btn-hover transform transition-all duration-300 flex items-center justify-center gap-4">
                        <i class="fa-solid fa-mobile-alt text-3xl"></i>
                        Pay with Mobile Money
                    </button>

                    <!-- Trust Badges -->
                    <div class="mt-8 grid grid-cols-3 gap-4 text-center text-sm">
                        <div class="bg-white/20 backdrop-blur rounded-xl p-4">
                            <i class="fa-solid fa-shield-halved text-2xl mb-2 block"></i>
                            <span class="font-bold">Secure</span>
                        </div>
                        <div class="bg-white/20 backdrop-blur rounded-xl p-4">
                            <i class="fa-solid fa-lock text-2xl mb-2 block"></i>
                            <span class="font-bold">Encrypted</span>
                        </div>
                        <div class="bg-white/20 backdrop-blur rounded-xl p-4">
                            <i class="fa-solid fa-trophy text-2xl mb-2 block"></i>
                            <span class="font-bold">Trusted</span>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <p class="text-sm opacity-90">Powered by <strong>Selcom • NMB • CRDB • M-Pesa</strong></p>
                        <p class="text-xs mt-3 opacity-80">
                            Supports M-Pesa • Tigo Pesa • Airtel Money • HaloPesa • Bank Cards
                        </p>
                    </div>

                    <p class="text-center text-xs mt-8 opacity-80">
                        By placing your order, you agree to our 
                        <a href="#" class="underline hover:opacity-100">Terms</a> & 
                        <a href="#" class="underline hover:opacity-100">Privacy Policy</a>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-20 bg-gray-900 text-gray-400 py-12 text-center">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-lg">&copy; {{ date('Y') }} Weru Hardware • Tanzania's #1 Building Materials Supplier</p>
            <p class="mt-4 text-sm">
                <a href="#" class="hover:text-white transition">Privacy</a> • 
                <a href="#" class="hover:text-white transition">Terms</a> • 
                <a href="tel:+255784123456" class="hover:text-white transition">+255 784 123 456</a>
            </p>
        </div>
    </footer>
</body>
</html>