<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Secure Checkout • Oweru Hardware</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Google Maps API -->
    @if(env('GOOGLE_MAPS_API_KEY') && env('GOOGLE_MAPS_API_KEY') !== 'YOUR_API_KEY_HERE')
    <script>
        // Initialize map after Google Maps loads
        window.googleMapsLoaded = function() {
            if (typeof initMap === 'function') {
                initMap();
            }
        };
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=googleMapsLoaded"></script>
    @else
    <script>
        console.warn('Google Maps API key not configured. Map will not be available.');
    </script>
    @endif
    <style>
        :root {
            --primary: rgb(218,165,32);
            --primary-dark: #002147;
            --primary-light: #f5f5f5;
        }
        * { -webkit-tap-highlight-color: transparent; }
        body { font-family: 'Inter', sans-serif; background-color: #f5f5f5; }
        .btn-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,33,71,0.3); }
        .input-focus:focus { outline: none; border-color: rgb(218,165,32); box-shadow: 0 0 0 3px rgba(218,165,32,0.15); }
        .payment-option:checked + label { box-shadow: 0 0 0 4px rgba(218,165,32,0.3); border-color: rgb(218,165,32); background-color: rgba(218,165,32,0.05); }
        
        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f5f5f5; }
        ::-webkit-scrollbar-thumb { background: rgb(218,165,32); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #d4af37; }
        
        /* Location Status Styles */
        .location-success { background: rgba(34, 197, 94, 0.1); border-color: rgb(34, 197, 94); }
        .location-error { background: rgba(239, 68, 68, 0.1); border-color: rgb(239, 68, 68); }
        .location-loading { background: rgba(59, 130, 246, 0.1); border-color: rgb(59, 130, 246); }
        
        /* Pulse Animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        
        /* Google Maps Container */
        #mapContainer {
            width: 100%;
            height: 400px;
            border-radius: 0.75rem;
            overflow: hidden;
            border: 2px solid #e5e7eb;
        }
        #map {
            width: 100%;
            height: 100%;
        }
        
        /* Custom Marker Info Window */
        .custom-info-window {
            padding: 10px;
            font-size: 14px;
        }
        
        /* Mobile Optimizations */
        @media (max-width: 768px) {
            .page-container { padding: 1rem 1rem; }
            .text-3xl { font-size: 1.875rem; }
            .text-2xl { font-size: 1.5rem; }
            .text-xl { font-size: 1.125rem; }
            .gap-10 { gap: 1.5rem; }
            .p-8 { padding: 1.5rem; }
            .py-8 { padding: 1rem 0; }
            #mapContainer {
                height: 300px;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="page-container py-8 max-w-7xl mx-auto px-6">

    <!-- Header -->
    <div class="rounded-2xl lg:rounded-3xl shadow-lg p-4 lg:p-8 mb-8 lg:mb-10 flex justify-between items-center flex-wrap gap-4 lg:gap-6" style="background: #002147;">
        <div class="flex items-center gap-3 lg:gap-5">
            <div class="w-10 lg:w-14 h-10 lg:h-14 rounded-lg lg:rounded-2xl flex items-center justify-center shadow-lg" style="background: rgb(218,165,32);">
                <i class="fa-solid fa-hard-hat text-white text-xl lg:text-2xl" style="color: #002147;"></i>
            </div>
            <h1 class="text-xl lg:text-3xl font-black text-white">Oweru<span style="color: rgb(218,165,32);">Hardware</span></h1>
        </div>
        <a href="{{ route('cart') }}" class="flex items-center gap-2 lg:gap-3 font-bold hover:transition text-sm lg:text-base" style="color: rgb(218,165,32);">
            <i class="fa-solid fa-arrow-left"></i> 
            Back to Cart ({{ \App\Models\Cart::current()->totalItems() }} items)
        </a>
    </div>

    <!-- Page Title -->
    <div class="text-center mb-8 lg:mb-12">
        <h2 class="text-2xl lg:text-5xl font-black text-gray-900 mb-2 lg:mb-4">Secure Checkout</h2>
        <p class="text-sm lg:text-xl text-gray-600">Complete your order in under 2 minutes</p>
    </div>

    @php
        $cart = \App\Models\Cart::current();
        $subtotal = $cart->subtotal();
        $totalItems = $cart->totalItems();
        $delivery = $totalItems > 0 ? 25000 : 0;
        $vat = round($subtotal * 0.18);
        $total = $subtotal + $delivery + $vat;
    @endphp

    <!-- Error Messages -->
    @if(session('error'))
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-5 py-4 rounded-xl shadow-md flex items-center gap-3 animate-slide-in">
        <i class="fa-solid fa-exclamation-circle text-red-600 text-xl"></i> 
        <span class="flex-1 font-medium">{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 touch-feedback">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('warning'))
    <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 px-5 py-4 rounded-xl shadow-md flex items-center gap-3 animate-slide-in">
        <i class="fa-solid fa-exclamation-triangle text-yellow-600 text-xl"></i> 
        <span class="flex-1 font-medium">{{ session('warning') }}</span>
        <button onclick="this.parentElement.remove()" class="text-yellow-400 hover:text-yellow-600 touch-feedback">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
        <!-- Hidden Location Fields -->
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <input type="hidden" name="location_accuracy" id="locationAccuracy">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Left: Form -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Contact Information -->
                <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg border border-gray-200 p-4 lg:p-8">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-lg lg:rounded-xl flex items-center justify-center text-lg lg:text-xl font-black text-white" style="background: rgb(218,165,32);">1</div>
                        <h3 class="text-lg lg:text-2xl font-black text-gray-900">Contact Information</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-1 lg:mb-2">Full Name <span class="text-red-600">*</span></label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                   class="w-full px-3 lg:px-6 py-2 lg:py-4 border-2 border-gray-200 rounded-lg lg:rounded-xl input-focus transition text-sm lg:text-base" placeholder="Peter Mushi">
                            @error('name') <p class="text-red-600 text-xs lg:text-sm mt-1 lg:mt-2"><i class="fa-solid fa-exclamation-triangle"></i> {{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-1 lg:mb-2">Phone Number <span class="text-red-600">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                   class="w-full px-3 lg:px-6 py-2 lg:py-4 border-2 border-gray-200 rounded-lg lg:rounded-xl input-focus transition text-sm lg:text-base" 
                                   placeholder="0616 012 915">
                            @error('phone') <p class="text-red-600 text-xs lg:text-sm mt-1 lg:mt-2"><i class="fa-solid fa-exclamation-triangle"></i> {{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-1 lg:mb-2">Email Address <span class="text-red-600">*</span></label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                                   class="w-full px-3 lg:px-6 py-2 lg:py-4 border-2 border-gray-200 rounded-lg lg:rounded-xl input-focus transition text-sm lg:text-base" placeholder="peter@example.com">
                            @error('email') <p class="text-red-600 text-xs lg:text-sm mt-1 lg:mt-2"><i class="fa-solid fa-exclamation-triangle"></i> {{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg border border-gray-200 p-4 lg:p-8">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-lg lg:rounded-xl flex items-center justify-center text-lg lg:text-xl font-black text-white" style="background: rgb(218,165,32);">2</div>
                        <h3 class="text-lg lg:text-2xl font-black text-gray-900">Delivery Address</h3>
                    </div>
                    <div class="space-y-4 lg:space-y-6">
                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-1 lg:mb-2">Full Address <span class="text-red-600">*</span></label>
                            <input type="text" name="address" value="{{ old('address') }}" required class="w-full px-3 lg:px-6 py-2 lg:py-4 border-2 border-gray-200 rounded-lg lg:rounded-xl input-focus transition text-sm lg:text-base" placeholder="Plot 123, Mwananyamala">
                            @error('address') <p class="text-red-600 text-xs lg:text-sm mt-1 lg:mt-2"><i class="fa-solid fa-exclamation-triangle"></i> {{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                            <div>
                                <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-1 lg:mb-2">Region <span class="text-red-600">*</span></label>
                                <select name="region" required class="w-full px-3 lg:px-6 py-2 lg:py-4 border-2 border-gray-200 rounded-lg lg:rounded-xl input-focus transition text-sm lg:text-base">
                                    <option value="">Select Region</option>
                                    @foreach(['Dar es Salaam','Arusha','Mwanza','Dodoma','Mbeya','Morogoro','Tanga','Kilimanjaro','Zanzibar','Other'] as $region)
                                        <option value="{{ $region }}" {{ old('region') == $region ? 'selected' : '' }}>{{ $region }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-1 lg:mb-2">City / District <span class="text-red-600">*</span></label>
                                <input type="text" name="city" value="{{ old('city') }}" required class="w-full px-3 lg:px-6 py-2 lg:py-4 border-2 border-gray-200 rounded-lg lg:rounded-xl input-focus transition text-sm lg:text-base" placeholder="Ilala">
                            </div>
                        </div>
                        
                        <!-- Interactive Map Location Picker -->
                        <div id="locationSection" class="p-4 lg:p-6 rounded-lg lg:rounded-xl border-2 border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-map-location-dot text-2xl lg:text-3xl" style="color: rgb(218,165,32);"></i>
                                    <div>
                                        <h4 class="text-sm lg:text-base font-bold text-gray-900">Select Your Delivery Location <span class="text-xs font-normal text-gray-500">(Optional)</span></h4>
                                        <p class="text-xs lg:text-sm text-gray-600">Click on the map or use your current location for faster delivery</p>
                                    </div>
                                </div>
                                <button type="button" id="getLocationBtn" class="px-4 lg:px-6 py-2 lg:py-3 rounded-lg font-bold text-sm lg:text-base transition-all flex items-center gap-2 whitespace-nowrap" style="background: rgb(218,165,32); color: #002147;">
                                    <i class="fa-solid fa-crosshairs"></i>
                                    <span class="hidden md:inline">Use My Location</span>
                                    <span class="md:hidden">My Location</span>
                                </button>
                            </div>
                            
                            <!-- Google Map Container -->
                            <div id="mapContainer" class="mb-4">
                                <div id="map"></div>
                            </div>
                            
                            <!-- Location Info -->
                            <div id="locationStatus" class="hidden"></div>
                            <div id="mapAddressInfo" class="mt-4 p-3 rounded-lg bg-gray-50 border border-gray-200">
                                <div class="flex items-start gap-2">
                                    <i class="fa-solid fa-info-circle mt-0.5" style="color: rgb(218,165,32);"></i>
                                    <div class="flex-1 text-xs lg:text-sm text-gray-600">
                                        <p><strong>Selected Location:</strong></p>
                                        <p id="selectedAddressText" class="text-gray-700 font-medium mt-1">-</p>
                                        <p id="selectedCoordinates" class="text-gray-500 mt-1 text-xs">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-1 lg:mb-2">Delivery Notes (Optional)</label>
                            <textarea name="notes" rows="3" class="w-full px-3 lg:px-6 py-2 lg:py-4 border-2 border-gray-200 rounded-lg lg:rounded-xl input-focus transition resize-none text-sm lg:text-base" placeholder="Near mosque, red gate, call when close...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method Selection -->
                <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg border border-gray-200 p-4 lg:p-8">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-lg lg:rounded-xl flex items-center justify-center text-lg lg:text-xl font-black text-white" style="background: rgb(218,165,32);">3</div>
                        <h3 class="text-lg lg:text-2xl font-black text-gray-900">Payment Method</h3>
                    </div>

                    <div class="space-y-3 lg:space-y-5">
                        <!-- Cash on Delivery (DEFAULT & RECOMMENDED) -->
                        <label class="flex items-start gap-3 lg:gap-5 p-3 lg:p-6 rounded-lg lg:rounded-2xl border-2 border-gray-200 hover:border-gray-300 cursor-pointer transition-all">
                            <input type="radio" name="payment_method" value="cash_on_delivery" checked class="mt-1 lg:mt-1 w-5 lg:w-6 h-5 lg:h-6" style="accent-color: rgb(218,165,32);">
                            <div class="flex-1">
                                <div class="flex items-start gap-2 lg:gap-3">
                                    <i class="fa-solid fa-truck text-2xl lg:text-3xl text-green-600 mt-0.5"></i>
                                    <div>
                                        <p class="text-base lg:text-xl font-bold text-gray-900">Cash on Delivery (Recommended)</p>
                                        <p class="text-sm lg:text-base text-gray-600">Pay with cash, M-Pesa, or bank transfer when you receive your items</p>
                                    </div>
                                </div>
                                <p class="text-xs lg:text-sm text-gray-500 mt-2 lg:mt-3">Most popular • No online payment needed • We call you to confirm</p>
                            </div>
                        </label>

                        <!-- Pay Now with Mobile Money -->
                        <label class="flex items-start gap-3 lg:gap-5 p-3 lg:p-6 rounded-lg lg:rounded-2xl border-2 border-gray-200 hover:border-gray-300 cursor-pointer transition-all">
                            <input type="radio" name="payment_method" value="selcom" class="mt-1 lg:mt-1 w-5 lg:w-6 h-5 lg:h-6" style="accent-color: rgb(218,165,32);">
                            <div class="flex-1">
                                <div class="flex items-start gap-2 lg:gap-3">
                                    <i class="fa-solid fa-mobile-alt text-2xl lg:text-3xl text-blue-600 mt-0.5"></i>
                                    <div>
                                        <p class="text-base lg:text-xl font-bold text-gray-900">Pay Now with Mobile Money</p>
                                        <p class="text-sm lg:text-base text-gray-600">Instant payment via M-Pesa, Tigo Pesa, Airtel Money, HaloPesa</p>
                                    </div>
                                </div>
                                <p class="text-xs lg:text-sm font-bold mt-2 lg:mt-3" style="color: rgb(218,165,32);">Get your order faster • 100% secure • Powered by Selcom</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-4">
                <div class="rounded-2xl lg:rounded-3xl shadow-lg p-4 lg:p-8 text-white sticky top-4 lg:top-6" style="background: #002147;">

                    <h3 class="text-lg lg:text-2xl font-black mb-6 lg:mb-8">Order Summary</h3>

                    @if($totalItems > 0)
                        <div class="mb-4 lg:mb-6 max-h-48 lg:max-h-64 overflow-y-auto space-y-2 lg:space-y-3">
                            @foreach($cart->items as $id => $item)
                                <div class="rounded-lg lg:rounded-xl p-2 lg:p-4" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(218,165,32,0.2);">
                                    <div class="flex gap-2 lg:gap-3">
                                        <div class="w-12 lg:w-16 h-12 lg:h-16 rounded-lg overflow-hidden" style="background: rgba(255,255,255,0.1);">
                                            @if($item['image'])<img src="{{ asset('storage/'.$item['image']) }}" class="w-full h-full object-cover">@else
                                                <div class="w-full h-full flex items-center justify-center"><i class="fa-solid fa-box text-white text-lg"></i></div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-xs lg:text-sm truncate">{{ $item['name'] }}</h4>
                                            <p class="text-2xs lg:text-xs opacity-90 mt-0.5 lg:mt-1">{{ $item['quantity'] }} × TZS {{ number_format($item['price']) }}</p>
                                            <p class="text-sm lg:text-base font-bold mt-0.5 lg:mt-1">TZS {{ number_format($item['price'] * $item['quantity']) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-4 lg:pt-6 space-y-3 lg:space-y-5 text-sm lg:text-lg" style="border-top: 2px solid rgba(218,165,32,0.3);">
                            <div class="flex justify-between"><span>Subtotal ({{ $totalItems }} items)</span><span class="font-bold">TZS {{ number_format($subtotal) }}</span></div>
                            <div class="flex justify-between"><span>Delivery Fee</span><span class="font-bold">TZS {{ number_format($delivery) }}</span></div>
                            <div class="flex justify-between"><span>VAT (18%)</span><span class="font-bold">TZS {{ number_format($vat) }}</span></div>
                            <div class="pt-4 lg:pt-6" style="border-top: 2px solid rgba(218,165,32,0.3);">
                                <div class="flex justify-between items-baseline">
                                    <span class="text-base lg:text-xl font-bold">Total Amount</span>
                                    <span class="text-2xl lg:text-4xl font-black" style="color: rgb(218,165,32);">TZS {{ number_format($total) }}</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="submitBtn" class="btn-hover w-full mt-6 lg:mt-10 py-3 lg:py-6 text-white font-black text-base lg:text-xl rounded-lg lg:rounded-2xl shadow-lg transition-all duration-300 flex items-center justify-center gap-2 lg:gap-3" style="background: rgb(218,165,32); color: #002147;">
                            <i class="fa-solid fa-check-circle text-lg lg:text-2xl"></i>
                            <span id="submitText">Complete Order</span>
                            <span id="submitLoader" class="hidden">
                                <i class="fa-solid fa-spinner fa-spin"></i> Processing...
                            </span>
                        </button>

                        <div class="mt-6 lg:mt-8 text-center text-xs lg:text-sm">
                            <p class="opacity-90">Powered by <strong>Selcom</strong> • Trusted by 1000+ Tanzanian businesses</p>
                            <p class="text-2xs mt-2 lg:mt-3 opacity-80">M-Pesa • Tigo Pesa • Airtel Money • HaloPesa • Cash on Delivery</p>
                        </div>
                    @else
                        <div class="text-center py-8 lg:py-10">
                            <i class="fa-solid fa-cart-shopping text-4xl lg:text-6xl opacity-50 mb-3 lg:mb-4"></i>
                            <p class="text-base lg:text-xl font-bold">Your cart is empty</p>
                            <a href="{{ route('products') }}" class="mt-4 lg:mt-6 inline-block px-6 lg:px-8 py-2 lg:py-4 text-white font-bold rounded-lg lg:rounded-xl" style="background: rgb(218,165,32); color: #002147;">Browse Products</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>

    <footer class="mt-20 text-center text-gray-600">
        <p class="text-base lg:text-lg font-medium">© {{ date('Y') }} Oweru Hardware • Tanzania's #1 Building Materials Supplier</p>
        <p class="mt-2 lg:mt-4 text-2xs lg:text-sm">
            <a href="tel:+255616012915" class="hover:underline" style="color: rgb(218,165,32);">+255 616 012 915</a> •
            <a href="https://wa.me/255616012915" class="hover:underline" style="color: rgb(218,165,32);">WhatsApp</a>
        </p>
    </footer>
</div>

<!-- Selcom Payment Popup Modal -->
<div id="selcomModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Payment Processing</h3>
            <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-times text-2xl"></i>
            </button>
        </div>
        <div class="p-6 text-center">
            <div id="modalContent">
                <i class="fa-solid fa-spinner fa-spin text-4xl mb-4" style="color: rgb(218,165,32);"></i>
                <p class="text-lg font-semibold text-gray-700 mb-2">Opening payment window...</p>
                <p class="text-sm text-gray-500">Please complete your payment in the popup window</p>
                <div class="mt-6">
                    <button id="openPaymentWindow" class="px-6 py-3 rounded-lg font-bold text-white" style="background: rgb(218,165,32); color: #002147;">
                        Open Payment Window
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkoutForm = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitLoader = document.getElementById('submitLoader');
    const selcomModal = document.getElementById('selcomModal');
    const modalContent = document.getElementById('modalContent');
    const closeModal = document.getElementById('closeModal');
    
    const getLocationBtn = document.getElementById('getLocationBtn');
    const locationStatus = document.getElementById('locationStatus');
    const locationSection = document.getElementById('locationSection');
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');
    const accuracyInput = document.getElementById('locationAccuracy');
    const selectedAddressText = document.getElementById('selectedAddressText');
    const selectedCoordinates = document.getElementById('selectedCoordinates');
    
    // Google Maps variables
    let map;
    let marker;
    let geocoder;
    let defaultCenter = { lat: -6.7924, lng: 39.2083 }; // Dar es Salaam, Tanzania
    
    // Initialize Google Map
    function initMap() {
        // Check if Google Maps API is available
        if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
            // Show fallback message
            const mapContainer = document.getElementById('mapContainer');
            if (mapContainer) {
                mapContainer.innerHTML = `
                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                        <div class="text-center p-6">
                            <i class="fa-solid fa-map text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 mb-2">Google Maps API not loaded</p>
                            <p class="text-sm text-gray-500">Please check your API key configuration</p>
                            <p class="text-xs text-gray-400 mt-2">You can still use the "Use My Location" button</p>
                        </div>
                    </div>
                `;
            }
            return;
        }
        
        // Initialize map centered on Dar es Salaam
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: defaultCenter,
            mapTypeControl: true,
            streetViewControl: true,
            fullscreenControl: true,
            styles: [
                {
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [{ visibility: "off" }]
                }
            ]
        });
        
        // Initialize geocoder
        geocoder = new google.maps.Geocoder();
        
        // Add click listener to map
        map.addListener('click', function(event) {
            placeMarker(event.latLng);
            updateLocationFields(event.latLng.lat(), event.latLng.lng());
            reverseGeocode(event.latLng);
        });
        
        // Try to get user's current location on load (non-blocking)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(userLocation);
                    map.setZoom(16);
                    placeMarker(userLocation);
                    updateLocationFields(userLocation.lat, userLocation.lng, position.coords.accuracy);
                    reverseGeocode(userLocation);
                },
                function(error) {
                    // User denied or error - center on default (silent fail, not blocking)
                    placeMarker(defaultCenter);
                    
                    // Only show error if it's a timeout (user might want to know)
                    if (error.code === error.TIMEOUT) {
                        console.log('Location request timed out. You can still select location on the map.');
                    }
                },
                {
                    enableHighAccuracy: false, // Use faster, less accurate location
                    timeout: 15000, // 15 seconds timeout
                    maximumAge: 60000 // Accept cached location up to 1 minute old
                }
            );
        } else {
            // No geolocation support - center on default
            placeMarker(defaultCenter);
        }
    }
    
    // Place marker on map
    function placeMarker(location) {
        if (!map) return;
        
        if (marker) {
            marker.setPosition(location);
        } else {
            marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                title: 'Delivery Location'
            });
            
            // Add drag listener
            marker.addListener('dragend', function(event) {
                updateLocationFields(event.latLng.lat(), event.latLng.lng());
                reverseGeocode(event.latLng);
            });
        }
        
        map.setCenter(location);
        if (map.getZoom() < 15) {
            map.setZoom(16);
        }
    }
    
    // Reverse geocode coordinates to address
    function reverseGeocode(location) {
        if (!geocoder) return;
        
        geocoder.geocode({ location: location }, function(results, status) {
            if (status === 'OK' && results[0]) {
                const address = results[0].formatted_address;
                selectedAddressText.textContent = address;
                
                // Try to auto-fill address fields
                autoFillAddressFields(results[0]);
            } else {
                selectedAddressText.textContent = 'Address not found';
            }
            
            selectedCoordinates.textContent = `Coordinates: ${location.lat().toFixed(6)}, ${location.lng().toFixed(6)}`;
        });
    }
    
    // Auto-fill address fields from geocoding result
    function autoFillAddressFields(result) {
        const addressComponents = result.address_components;
        const addressInput = document.querySelector('input[name="address"]');
        
        // Build address string
        let streetAddress = '';
        let city = '';
        let region = '';
        
        addressComponents.forEach(component => {
            const types = component.types;
            
            if (types.includes('street_number')) {
                streetAddress = component.long_name + ' ' + streetAddress;
            } else if (types.includes('route')) {
                streetAddress += component.long_name;
            } else if (types.includes('locality')) {
                city = component.long_name;
            } else if (types.includes('administrative_area_level_1')) {
                region = component.long_name;
            } else if (types.includes('administrative_area_level_2') && !city) {
                city = component.long_name;
            }
        });
        
        // Auto-fill if fields are empty
        if (addressInput && !addressInput.value) {
            addressInput.value = streetAddress.trim() || result.formatted_address;
        }
        
        const cityInput = document.querySelector('input[name="city"]');
        if (cityInput && !cityInput.value && city) {
            cityInput.value = city;
        }
        
        const regionSelect = document.querySelector('select[name="region"]');
        if (regionSelect && !regionSelect.value && region) {
            // Try to match region
            const regionOptions = Array.from(regionSelect.options);
            const matchedOption = regionOptions.find(option => 
                option.text.toLowerCase().includes(region.toLowerCase()) ||
                region.toLowerCase().includes(option.text.toLowerCase())
            );
            if (matchedOption) {
                regionSelect.value = matchedOption.value;
            }
        }
    }
    
    // Update hidden location fields
    function updateLocationFields(lat, lng, accuracy = null) {
        latitudeInput.value = lat;
        longitudeInput.value = lng;
        if (accuracy !== null) {
            accuracyInput.value = accuracy;
        }
        
        // Show success status
        showLocationStatus('success', 'Location selected on map!');
        locationSection.classList.add('location-success');
        locationSection.classList.remove('location-error');
    }
    
    // Initialize map function - will be called when Google Maps loads
    window.initMap = function() {
        initMap();
    };
    
    // Also try to init immediately if already loaded
    if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
        initMap();
    }

    // Location button click handler
    getLocationBtn.addEventListener('click', function() {
        if (!navigator.geolocation) {
            showLocationStatus('error', 'Geolocation is not supported by your browser');
            return;
        }

        // Show loading state
        showLocationStatus('loading', 'Getting your location... Please wait, this may take up to 25 seconds.');
        getLocationBtn.disabled = true;
        getLocationBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span class="hidden md:inline">Getting Location...</span><span class="md:hidden">Loading...</span>';

        navigator.geolocation.getCurrentPosition(
            function(position) {
                // Success
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                const accuracy = position.coords.accuracy;
                const userLocation = { lat: lat, lng: lon };

                // Update map if available
                if (map) {
                    map.setCenter(userLocation);
                    map.setZoom(16);
                    placeMarker(userLocation);
                    reverseGeocode(new google.maps.LatLng(lat, lon));
                }

                // Store in hidden fields
                updateLocationFields(lat, lon, accuracy);

                // Show success message
                showLocationStatus('success', 
                    `Location captured successfully!<br>
                    <span class="text-xs opacity-80">Coordinates: ${lat.toFixed(6)}, ${lon.toFixed(6)}</span><br>
                    <span class="text-xs opacity-80">Accuracy: ±${Math.round(accuracy)} meters</span>`
                );

                // Update button
                getLocationBtn.innerHTML = '<i class="fa-solid fa-check-circle"></i> <span class="hidden md:inline">Location Captured</span><span class="md:hidden">Done</span>';
                getLocationBtn.classList.add('opacity-75');
                locationSection.classList.add('location-success');
            },
            function(error) {
                // Error - but location is optional, so don't block the user
                let errorMessage = '';
                let suggestion = 'Don\'t worry! You can still complete your order.';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Location access denied. Please enable location permissions in your browser settings if you want automatic location detection.';
                        suggestion = 'You can manually select your location by clicking anywhere on the map above.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'Unable to determine your location. Your device location may be unavailable.';
                        suggestion = 'You can manually select your location by clicking anywhere on the map above.';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'Location request timed out. This may happen if your GPS signal is weak or if you\'re indoors.';
                        suggestion = 'You can manually select your location by clicking anywhere on the map above, or click "Try Again" if you\'re in an area with better GPS signal.';
                        break;
                    default:
                        errorMessage = 'Unable to get your location automatically.';
                        suggestion = 'You can manually select your location by clicking anywhere on the map above.';
                }

                // Show friendly error message (not blocking)
                showLocationStatus('error', 
                    '<div class="text-left">' +
                    '<p class="font-semibold mb-2">' + errorMessage + '</p>' +
                    '<p class="text-xs opacity-90 mt-1">💡 ' + suggestion + '</p>' +
                    '<p class="text-xs opacity-75 mt-2 italic">Location is optional - you can still proceed with your order.</p>' +
                    '</div>'
                );
                
                // Reset button
                getLocationBtn.disabled = false;
                getLocationBtn.innerHTML = '<i class="fa-solid fa-crosshairs"></i> <span class="hidden md:inline">Try Again</span><span class="md:hidden">Retry</span>';
                locationSection.classList.add('location-error');
                
                // Make sure default location is set if map exists (user can still click to select)
                if (map && !marker) {
                    placeMarker(defaultCenter);
                }
            },
            {
                enableHighAccuracy: false, // Use faster, less accurate location first
                timeout: 25000, // 25 seconds timeout (increased for better success rate)
                maximumAge: 120000 // Accept cached location up to 2 minutes old (faster response)
            }
        );
    });

    function showLocationStatus(type, message) {
        locationStatus.classList.remove('hidden');
        locationStatus.classList.remove('location-success', 'location-error', 'location-loading');
        
        let icon = '';
        let bgClass = '';
        
        switch(type) {
            case 'success':
                icon = '<i class="fa-solid fa-check-circle text-green-600"></i>';
                bgClass = 'bg-green-50 border-green-200 text-green-800';
                break;
            case 'error':
                icon = '<i class="fa-solid fa-exclamation-circle text-red-600"></i>';
                bgClass = 'bg-red-50 border-red-200 text-red-800';
                break;
            case 'loading':
                icon = '<i class="fa-solid fa-spinner fa-spin text-blue-600"></i>';
                bgClass = 'bg-blue-50 border-blue-200 text-blue-800';
                break;
        }
        
        locationStatus.className = `mt-4 p-4 rounded-lg border-2 text-sm ${bgClass}`;
        locationStatus.innerHTML = `
            <div class="flex items-start gap-3">
                ${icon}
                <div class="flex-1">${message}</div>
            </div>
        `;
    }

    // Handle form submission with Selcom popup
    checkoutForm.addEventListener('submit', function(e) {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        
        if (paymentMethod === 'selcom') {
            e.preventDefault();
            
            // Show loading state
            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            submitLoader.classList.remove('hidden');
            
            // Get form data
            const formData = new FormData(checkoutForm);
            
            // Submit via AJAX
            fetch(checkoutForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.payment_url) {
                    // Show modal
                    selcomModal.classList.remove('hidden');
                    
                    // Store payment URL and order ID
                    const paymentUrl = data.payment_url;
                    const orderId = data.order_id;
                    
                    // Open payment in popup window
                    const paymentWindow = window.open(
                        paymentUrl,
                        'SelcomPayment',
                        'width=800,height=600,scrollbars=yes,resizable=yes,menubar=no,toolbar=no,location=no,status=no'
                    );
                    
                    if (!paymentWindow) {
                        // Popup blocked - redirect to payment page
                        alert('Popup blocked. Redirecting to payment page...');
                        window.location.href = paymentUrl;
                        return;
                    }
                    
                    // Update modal content
                    modalContent.innerHTML = `
                        <i class="fa-solid fa-credit-card text-4xl mb-4" style="color: rgb(218,165,32);"></i>
                        <p class="text-lg font-semibold text-gray-700 mb-2">Payment window opened</p>
                        <p class="text-sm text-gray-500 mb-4">Order: ${data.order_number}</p>
                        <p class="text-xs text-gray-400">Complete your payment in the popup window. This window will close automatically when payment is complete.</p>
                        <div class="mt-6">
                            <button onclick="window.open('${paymentUrl}', 'SelcomPayment', 'width=800,height=600')" class="px-6 py-3 rounded-lg font-bold text-white" style="background: rgb(218,165,32); color: #002147;">
                                Reopen Payment Window
                            </button>
                        </div>
                    `;
                    
                    // Poll for payment completion
                    let checkCount = 0;
                    const maxChecks = 120; // 60 seconds max
                    
                    const checkPaymentStatus = setInterval(function() {
                        checkCount++;
                        
                        // Check if popup is closed (user might have completed payment)
                        if (paymentWindow.closed) {
                            clearInterval(checkPaymentStatus);
                            // Check payment status
                            fetch('{{ route("checkout.status", ":order_id") }}'.replace(':order_id', orderId), {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            })
                            .then(response => response.json())
                            .then(statusData => {
                                if (statusData.payment_status === 'paid') {
                                    selcomModal.classList.add('hidden');
                                    window.location.href = '{{ route("checkout.success", ":order_id") }}'.replace(':order_id', orderId);
                                } else {
                                    // Payment not completed, show message
                                    modalContent.innerHTML = `
                                        <i class="fa-solid fa-exclamation-triangle text-4xl mb-4 text-yellow-500"></i>
                                        <p class="text-lg font-semibold text-gray-700 mb-2">Payment window closed</p>
                                        <p class="text-sm text-gray-500 mb-4">If you completed the payment, we'll verify it shortly.</p>
                                        <p class="text-xs text-gray-400">You can close this window and check your order status.</p>
                                    `;
                                }
                            })
                            .catch(err => {
                                console.error('Error checking payment status:', err);
                            });
                            return;
                        }
                        
                        // Poll payment status every 3 seconds
                        if (checkCount % 6 === 0) {
                            fetch('{{ route("checkout.status", ":order_id") }}'.replace(':order_id', orderId), {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            })
                            .then(response => response.json())
                            .then(statusData => {
                                if (statusData.payment_status === 'paid') {
                                    clearInterval(checkPaymentStatus);
                                    paymentWindow.close();
                                    selcomModal.classList.add('hidden');
                                    window.location.href = '{{ route("checkout.success", ":order_id") }}'.replace(':order_id', orderId);
                                }
                            })
                            .catch(err => {
                                // Ignore errors, continue checking
                            });
                        }
                        
                        if (checkCount >= maxChecks) {
                            clearInterval(checkPaymentStatus);
                            modalContent.innerHTML += `
                                <p class="text-xs text-red-500 mt-4">Payment check timeout. Please check your order status manually.</p>
                            `;
                        }
                    }, 500);
                    
                } else {
                    alert(data.error || 'Payment initialization failed. Please try again.');
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    submitLoader.classList.add('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again or use Cash on Delivery.');
                submitBtn.disabled = false;
                submitText.classList.remove('hidden');
                submitLoader.classList.add('hidden');
            });
        }
        // If cash on delivery, let form submit normally
    });
    
    // Close modal handler
    closeModal.addEventListener('click', function() {
        if (confirm('Are you sure you want to close? Your payment is still processing.')) {
            selcomModal.classList.add('hidden');
            modalContent.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin text-4xl mb-4" style="color: rgb(218,165,32);"></i>
                <p class="text-lg font-semibold text-gray-700 mb-2">Opening payment window...</p>
                <p class="text-sm text-gray-500">Please complete your payment in the popup window</p>
            `;
        }
    });
    
    // Close modal on outside click
    selcomModal.addEventListener('click', function(e) {
        if (e.target === selcomModal) {
            selcomModal.classList.add('hidden');
        }
    });
});
</script>

</body>
</html>