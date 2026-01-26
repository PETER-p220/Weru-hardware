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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: rgb(218,165,32);
            --primary-dark: #002147;
        }
        body { font-family: 'Inter', sans-serif; background-color: #f5f5f5; }
        .btn-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,33,71,0.3); }
        .input-focus:focus { outline: none; border-color: rgb(218,165,32); box-shadow: 0 0 0 3px rgba(218,165,32,0.15); }
        .payment-option:checked + label { box-shadow: 0 0 0 4px rgba(218,165,32,0.3); border-color: rgb(218,165,32); background-color: rgba(218,165,32,0.05); }
        #map { 
            height: 400px; 
            width: 100%; 
            border-radius: 1rem; 
            border: 3px solid rgba(218,165,32,0.3);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        @media (max-width: 768px) {
            #map { height: 300px; }
        }
        .location-card {
            background: linear-gradient(135deg, rgba(218,165,32,0.1) 0%, rgba(0,33,71,0.05) 100%);
            border: 2px dashed rgba(218,165,32,0.3);
        }
        .location-success {
            background: linear-gradient(135deg, rgba(34,197,94,0.1) 0%, rgba(22,163,74,0.05) 100%);
            border: 2px solid rgba(34,197,94,0.3);
        }
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .leaflet-popup-content {
            margin: 16px;
            font-family: 'Inter', sans-serif;
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
        $total = $subtotal + $delivery ;
    @endphp

    <!-- Error Messages -->
    @if(session('error'))
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-5 py-4 rounded-xl shadow-md flex items-center gap-3">
        <i class="fa-solid fa-exclamation-circle text-red-600 text-xl"></i> 
        <span class="flex-1 font-medium">{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

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
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required class="w-full px-3 lg:px-6 py-2 lg:py-4 border-2 border-gray-200 rounded-lg lg:rounded-xl input-focus transition text-sm lg:text-base" placeholder="Peter Mushi">
                        </div>
                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-1 lg:mb-2">Phone Number <span class="text-red-600">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required class="w-full px-3 lg:px-6 py-2 lg:py-4 border-2 border-gray-200 rounded-lg lg:rounded-xl input-focus transition text-sm lg:text-base" placeholder="0616 012 915">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-1 lg:mb-2">Email Address <span class="text-red-600">*</span></label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required class="w-full px-3 lg:px-6 py-2 lg:py-4 border-2 border-gray-200 rounded-lg lg:rounded-xl input-focus transition text-sm lg:text-base" placeholder="peter@example.com">
                        </div>
                    </div>
                </div>

                <!-- Delivery Address with Geolocation & Live Map -->
                <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg border border-gray-200 p-4 lg:p-8">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-lg lg:rounded-xl flex items-center justify-center text-lg lg:text-xl font-black text-white" style="background: rgb(218,165,32);">2</div>
                        <h3 class="text-lg lg:text-2xl font-black text-gray-900">Delivery Address</h3>
                    </div>

                    <!-- Geolocation Component -->
                    <div class="mb-6">
                        <geolocation 
                            id="geolocator"
                            onlocation="handleLocation(event)" 
                            autolocate 
                            accuracymode="precise"
                            style="display: none;">
                        </geolocation>

                        <div id="locationCard" class="location-card rounded-xl p-6 text-center transition-all duration-300">
                            <i class="fa-solid fa-location-crosshairs text-4xl mb-3" style="color: rgb(218,165,32);"></i>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Get Your Location</h4>
                            <p class="text-sm text-gray-600 mb-4">Click below to automatically detect your delivery location</p>
                            <button 
                                type="button" 
                                id="getLocationBtn"
                                onclick="requestLocation()"
                                class="bg-white px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all font-bold text-sm flex items-center gap-2 mx-auto" 
                                style="color: rgb(218,165,32); border: 2px solid rgb(218,165,32);">
                                <i class="fa-solid fa-crosshairs"></i>
                                <span>Use My Current Location</span>
                            </button>
                        </div>

                        <div id="locationDisplay" class="hidden location-success rounded-xl p-6">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-check text-green-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-bold text-gray-800 mb-2">Location Detected</h4>
                                    <div class="space-y-1 text-sm text-gray-700">
                                        <p><strong>Latitude:</strong> <span id="displayLat">-</span></p>
                                        <p><strong>Longitude:</strong> <span id="displayLng">-</span></p>
                                        <p class="text-xs text-gray-500 mt-2">
                                            <i class="fa-solid fa-info-circle"></i> 
                                            Accuracy: <span id="displayAccuracy">-</span>m
                                        </p>
                                    </div>
                                    <button 
                                        type="button" 
                                        onclick="requestLocation()"
                                        class="mt-3 text-sm font-semibold hover:underline" 
                                        style="color: rgb(218,165,32);">
                                        <i class="fa-solid fa-rotate"></i> Update Location
                                    </button>
                                </div>
                            </div>
                        </div>

                        <p class="text-xs lg:text-sm text-gray-600 mt-3 flex items-center gap-2">
                            <i class="fa-solid fa-info-circle" style="color: rgb(218,165,32);"></i>
                            Your precise location helps us deliver faster and more accurately
                        </p>
                    </div>

                    <!-- Live Map -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm lg:text-base font-bold text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-map-location-dot" style="color: rgb(218,165,32);"></i>
                                Delivery Location Map
                            </h4>
                            <button 
                                type="button" 
                                onclick="map.setView([currentLat, currentLng], 15)"
                                class="text-xs font-semibold px-3 py-1 rounded-lg border-2 hover:bg-gray-50 transition"
                                style="color: rgb(218,165,32); border-color: rgb(218,165,32);">
                                <i class="fa-solid fa-crosshairs"></i> Center Map
                            </button>
                        </div>
                        <div id="map"></div>
                        <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                            <i class="fa-solid fa-hand-pointer"></i>
                            Click and drag the marker to adjust your exact delivery location
                        </p>
                    </div>

                    <div class="space-y-4 lg:space-y-6">
                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-1 lg:mb-2">Full Address <span class="text-red-600">*</span></label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}" required class="w-full px-3 lg:px-6 py-2 lg:py-4 border-2 border-gray-200 rounded-lg lg:rounded-xl input-focus transition text-sm lg:text-base" placeholder="Plot 123, Mwananyamala">
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
                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-1 lg:mb-2">Delivery Notes (Optional)</label>
                            <textarea name="notes" rows="3" class="w-full px-3 lg:px-6 py-2 lg:py-4 border-2 border-gray-200 rounded-lg lg:rounded-xl input-focus transition resize-none text-sm lg:text-base" placeholder="Near mosque, red gate, call when close...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg border border-gray-200 p-4 lg:p-8">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-lg lg:rounded-xl flex items-center justify-center text-lg lg:text-xl font-black text-white" style="background: rgb(218,165,32);">3</div>
                        <h3 class="text-lg lg:text-2xl font-black text-gray-900">Payment Method</h3>
                    </div>

                    <div class="space-y-3 lg:space-y-5">
                        <!-- Cash on Delivery -->
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
                                <p class="text-xs lg:text-sm font-bold mt-2 lg:mt-3" style="color: rgb(218,165,32);">Get your order faster • Receive payment prompt on your phone • Powered by Selcom</p>
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
                            <span id="submitLoader" class="hidden"><i class="fa-solid fa-spinner fa-spin"></i> Processing...</span>
                        </button>
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
</div>

<!-- Success Modal for Mobile Money -->
<div id="paymentModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
        <div class="p-6 text-center">
            <div id="modalContent">
                <i class="fa-solid fa-spinner fa-spin text-4xl mb-4" style="color: rgb(218,165,32);"></i>
                <p class="text-lg font-semibold text-gray-700 mb-2">Processing your order...</p>
                <p class="text-sm text-gray-500">Please wait</p>
            </div>
        </div>
    </div>
</div>

<script>
// Map variables
let map;
let marker;
let currentLat = -6.7924;
let currentLng = 39.2083;

// Initialize map on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeMap();
});

function initializeMap() {
    // Initialize Leaflet map centered on Dar es Salaam
    map = L.map('map').setView([currentLat, currentLng], 13);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Custom icon for the marker
    const customIcon = L.divIcon({
        className: 'custom-marker',
        html: '<div style="background: rgb(218,165,32); width: 40px; height: 40px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 3px solid white; box-shadow: 0 3px 10px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-location-dot" style="transform: rotate(45deg); color: #002147; font-size: 20px;"></i></div>',
        iconSize: [40, 40],
        iconAnchor: [20, 40]
    });
    
    // Add draggable marker
    marker = L.marker([currentLat, currentLng], {
        draggable: true,
        icon: customIcon
    }).addTo(map);
    
    marker.bindPopup('<b>Your Delivery Location</b><br>Drag to adjust').openPopup();
    
    // Update coordinates when marker is dragged
    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        currentLat = position.lat;
        currentLng = position.lng;
        
        document.getElementById('latitude').value = currentLat;
        document.getElementById('longitude').value = currentLng;
        
        document.getElementById('displayLat').textContent = currentLat.toFixed(6);
        document.getElementById('displayLng').textContent = currentLng.toFixed(6);
        
        reverseGeocode(currentLat, currentLng);
    });
}

function updateMapLocation(lat, lng) {
    currentLat = lat;
    currentLng = lng;
    
    // Update map view and marker position
    map.setView([lat, lng], 15);
    marker.setLatLng([lat, lng]);
    marker.bindPopup('<b>Your Delivery Location</b><br>Drag to adjust position').openPopup();
}

// Geolocation handler
function handleLocation(event) {
    const geoElement = event.target;
    
    if (geoElement.position) {
        const { latitude, longitude, accuracy } = geoElement.position.coords;
        
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;
        
        document.getElementById('displayLat').textContent = latitude.toFixed(6);
        document.getElementById('displayLng').textContent = longitude.toFixed(6);
        document.getElementById('displayAccuracy').textContent = accuracy.toFixed(0);
        
        document.getElementById('locationCard').classList.add('hidden');
        document.getElementById('locationDisplay').classList.remove('hidden');  
        updateMapLocation(latitude, longitude);
        reverseGeocode(latitude, longitude);
    } else if (geoElement.error) {
        alert('Error obtaining location: ' + geoElement.error.message);
    }
}
function requestLocation() {
    const geoElement = document.getElementById('geolocator');
    geoElement.requestLocation();
}
function reverseGeocode(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
        .then(response => response.json())
        .then(data => {
            if (data && data.display_name) {
                document.getElementById('address').value = data.display_name;
            }
        })
        .catch(error => {
            console.error('Error during reverse geocoding:', error);
        });
}
// Form submission handler
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    if (paymentMethod === 'selcom') {
        e.preventDefault();
        showPaymentModal();
        setTimeout(() => {
            this.submit();
        }, 2000);
    } else {
        document.getElementById('submitText').classList.add('hidden');
        document.getElementById('submitLoader').classList.remove('hidden');
    }
});
function showPaymentModal() {
    const modal = document.getElementById('paymentModal');
    const modalContent = document.getElementById('modalContent');
    
    modalContent.innerHTML = `
        <i class="fa-solid fa-spinner fa-spin text-4xl mb-4" style="color: rgb(218,165,32);"></i>
        <p class="text-lg font-semibold text-gray-700 mb-2">Processing your order...</p>
        <p class="text-sm text-gray-500">Please wait</p>
    `;
    
    modal.classList.remove('hidden');
}
</script>
</body>
</html>