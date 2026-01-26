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
    <!-- Leaflet CSS + JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5nQ9nXqV8=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: rgb(218,165,32);
            --primary-dark: #002147;
        }
        body { font-family: 'Inter', sans-serif; background-color: #f5f5f5; }
        .btn-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,33,71,0.3); }
        .input-focus:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(218,165,32,0.15); }
        .payment-option:checked + label { box-shadow: 0 0 0 4px rgba(218,165,32,0.3); border-color: var(--primary); background-color: rgba(218,165,32,0.05); }

        /* Professional map container */
        .map-container {
            margin-top: 1.25rem;
            border-radius: 1rem;
            overflow: hidden;
            border: 1px solid rgba(218,165,32,0.3);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            background: white;
            transition: all 0.4s ease;
        }
        #map {
            height: 0;
            transition: height 0.5s ease;
        }
        #map.expanded {
            height: 350px;
        }
        @media (max-width: 768px) {
            #map.expanded { height: 250px; }
        }
        .map-toggle-btn {
            background: white;
            border: 2px solid var(--primary);
            color: var(--primary);
            transition: all 0.3s ease;
        }
        .map-toggle-btn:hover {
            background: var(--primary);
            color: white;
        }
        .status-pill {
            background: rgba(218,165,32,0.08);
            border: 1px solid rgba(218,165,32,0.25);
            border-radius: 9999px;
            padding: 0.5rem 1.25rem;
        }
        .coord-info {
            font-size: 0.875rem;
            color: #4b5563;
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
        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Left Column -->
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

                <!-- Delivery Address with Professional Compact Map -->
                <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg border border-gray-200 p-4 lg:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3 lg:gap-4">
                            <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-lg lg:rounded-xl flex items-center justify-center text-lg lg:text-xl font-black text-white" style="background: rgb(218,165,32);">2</div>
                            <h3 class="text-lg lg:text-2xl font-black text-gray-900">Delivery Address</h3>
                        </div>
                        <button 
                            type="button" 
                            id="toggleMapBtn"
                            class="map-toggle-btn px-5 py-2.5 rounded-lg font-medium text-sm flex items-center gap-2 shadow-sm transition-all">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <span id="toggleText">Show Map</span>
                        </button>
                    </div>

                    <!-- Compact Map Area -->
                    <div id="map-wrapper" class="map-box">
                        <div id="map"></div>
                    </div>

                    <!-- Status & Controls -->
                    <div class="mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="status-box flex items-center gap-3 px-4 py-2.5 text-sm">
                            <i id="statusIcon" class="fa-solid fa-location-crosshairs text-xl" style="color: var(--primary);"></i>
                            <span id="statusText">Click "Use Current Location" or drag the marker</span>
                        </div>
                        <div class="flex gap-3 flex-wrap">
                            <button type="button" id="getLocationBtn" class="px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm" style="border: 2px solid var(--primary); color: var(--primary);">
                                <i class="fa-solid fa-crosshairs"></i> Use Location
                            </button>
                            <button type="button" id="resetMapBtn" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-2">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </button>
                        </div>
                    </div>

                    <!-- Coordinates -->
                    <div class="mt-3 text-xs coord-info flex gap-6 justify-center sm:justify-start">
                        <span>Lat: <span id="displayLat">—</span></span>
                        <span>Lng: <span id="displayLng">—</span></span>
                    </div>

                    <!-- Manual fields -->
                    <div class="space-y-6 mt-8">
                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">Full Address <span class="text-red-600">*</span></label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--primary)] transition text-base" placeholder="Plot 123, Mwananyamala">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">Region <span class="text-red-600">*</span></label>
                                <select name="region" id="region" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--primary)] transition text-base">
                                    <option value="">Select Region</option>
                                    @foreach(['Dar es Salaam','Arusha','Mwanza','Dodoma','Mbeya','Morogoro','Tanga','Kilimanjaro','Zanzibar','Other'] as $region)
                                        <option value="{{ $region }}" {{ old('region') == $region ? 'selected' : '' }}>{{ $region }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">City / District <span class="text-red-600">*</span></label>
                                <input type="text" name="city" id="city" value="{{ old('city') }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--primary)] transition text-base" placeholder="Ilala">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">Delivery Notes (Optional)</label>
                            <textarea name="notes" rows="3" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--primary)] transition resize-none text-base" placeholder="Near mosque, red gate, call when close...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg border border-gray-200 p-4 lg:p-8">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-lg lg:rounded-xl flex items-center justify-center text-lg lg:text-xl font-black text-white" style="background: rgb(218,165,32);">3</div>
                        <h3 class="text-lg lg:text-2xl font-black text-gray-900">Payment Method</h3>
                    </div>

                    <div class="space-y-4">
                        <label class="flex items-start gap-4 p-5 rounded-xl border-2 border-gray-200 hover:border-[var(--primary)] cursor-pointer transition-all">
                            <input type="radio" name="payment_method" value="cash_on_delivery" checked class="mt-1.5 w-5 h-5" style="accent-color: var(--primary);">
                            <div>
                                <p class="text-lg font-bold text-gray-900">Cash on Delivery (Recommended)</p>
                                <p class="text-sm text-gray-600 mt-1">Pay with cash, M-Pesa, or bank transfer on delivery</p>
                                <p class="text-xs text-gray-500 mt-2">Most popular • No online payment needed</p>
                            </div>
                        </label>

                        <label class="flex items-start gap-4 p-5 rounded-xl border-2 border-gray-200 hover:border-[var(--primary)] cursor-pointer transition-all">
                            <input type="radio" name="payment_method" value="selcom" class="mt-1.5 w-5 h-5" style="accent-color: var(--primary);">
                            <div>
                                <p class="text-lg font-bold text-gray-900">Pay Now with Mobile Money</p>
                                <p class="text-sm text-gray-600 mt-1">Instant payment via M-Pesa, Tigo Pesa, Airtel Money, HaloPesa</p>
                                <p class="text-xs font-bold mt-2" style="color: var(--primary);">Faster processing • Prompt on phone</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-4">
                <div class="rounded-2xl lg:rounded-3xl shadow-lg p-6 lg:p-8 text-white sticky top-8" style="background: #002147;">
                    <h3 class="text-xl lg:text-2xl font-black mb-6">Order Summary</h3>

                    @if($totalItems > 0)
                        <div class="mb-6 max-h-64 overflow-y-auto space-y-4 pr-2">
                            @foreach($cart->items as $id => $item)
                                <div class="flex gap-4 bg-white/10 p-4 rounded-xl border border-white/10">
                                    <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0" style="background: rgba(255,255,255,0.1);">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/'.$item['image']) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center"><i class="fa-solid fa-box text-white text-lg"></i></div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-base truncate">{{ $item['name'] }}</h4>
                                        <p class="text-sm opacity-90 mt-1">{{ $item['quantity'] }} × TZS {{ number_format($item['price']) }}</p>
                                        <p class="text-base font-bold mt-2">TZS {{ number_format($item['price'] * $item['quantity']) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-6 space-y-4 text-base border-t border-white/20">
                            <div class="flex justify-between"><span>Subtotal</span><span class="font-bold">TZS {{ number_format($subtotal) }}</span></div>
                            <div class="flex justify-between"><span>Delivery Fee</span><span class="font-bold">TZS {{ number_format($delivery) }}</span></div>
                            <div class="pt-4 border-t border-white/20 flex justify-between items-baseline">
                                <span class="text-lg font-bold">Total</span>
                                <span class="text-3xl font-black" style="color: var(--primary);">TZS {{ number_format($total) }}</span>
                            </div>
                        </div>

                        <button type="submit" id="submitBtn" class="w-full mt-8 py-5 text-white font-black text-lg rounded-xl shadow-xl transition-all flex items-center justify-center gap-3" style="background: var(--primary); color: #002147;">
                            <i class="fa-solid fa-check-circle text-xl"></i>
                            <span id="submitText">Complete Order</span>
                            <span id="submitLoader" class="hidden"><i class="fa-solid fa-spinner fa-spin"></i> Processing...</span>
                        </button>
                    @else
                        <div class="text-center py-12">
                            <i class="fa-solid fa-cart-shopping text-6xl opacity-50 mb-4"></i>
                            <p class="text-xl font-bold">Your cart is empty</p>
                            <a href="{{ route('products') }}" class="mt-6 inline-block px-8 py-4 text-white font-bold rounded-xl shadow-lg" style="background: var(--primary); color: #002147;">Browse Products</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Success Modal -->
<div id="paymentModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-60 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <div class="p-8 text-center">
            <div id="modalContent">
                <i class="fa-solid fa-spinner fa-spin text-5xl mb-6" style="color: var(--primary);"></i>
                <p class="text-xl font-bold text-gray-800 mb-3">Processing your order...</p>
                <p class="text-gray-600">Please wait a moment</p>
            </div>
        </div>
    </div>
</div>

<!-- Hidden geolocation component -->
<geolocation 
    id="geolocator"
    onlocation="handleLocation(event)" 
    autolocate 
    accuracymode="precise"
    style="display: none;">
</geolocation>

<script>
// ────────────────────────────────────────────────
// PROFESSIONAL COLLAPSIBLE MAP (small box, auto-center on show)
// ────────────────────────────────────────────────
let map = null;
let marker = null;
const defaultLat = -6.7924;
const defaultLng = 39.2083;
let mapVisible = false;

function initMap(lat = defaultLat, lng = defaultLng) {
    if (map) return;

    map = L.map('map', {
        zoomControl: false,
        attributionControl: true
    }).setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(map);

    marker = L.marker([lat, lng], { 
        draggable: true,
        icon: L.divIcon({
            html: '<i class="fa-solid fa-location-pin text-4xl drop-shadow-lg" style="color: var(--primary);"></i>',
            className: '',
            iconSize: [40, 48],
            iconAnchor: [20, 48]
        })
    }).addTo(map);

    marker.on('dragend', (e) => {
        const pos = e.target.getLatLng();
        document.getElementById('latitude').value = pos.lat.toFixed(6);
        document.getElementById('longitude').value = pos.lng.toFixed(6);
        reverseGeocode(pos.lat, pos.lng);
    });

    // Add zoom control
    L.control.zoom({ position: 'topright' }).addTo(map);
}

function toggleMap() {
    const mapDiv = document.getElementById('map');
    const wrapper = document.getElementById('map-wrapper');
    const btn = document.getElementById('toggleMapBtn');
    const text = document.getElementById('toggleText');

    mapVisible = !mapVisible;

    if (mapVisible) {
        mapDiv.classList.add('expanded');
        wrapper.classList.add('shadow-lg');
        text.textContent = 'Hide Map';
        btn.classList.add('bg-[var(--primary)]', 'text-white');
        btn.classList.remove('text-[var(--primary)]');

        // Initialize map if not already
        if (!map) {
            initMap();
        }

        // Automatically try to get current location when showing map
        if (!document.getElementById('latitude').value.trim() || 
            document.getElementById('latitude').value === defaultLat.toFixed(6)) {
            requestLocation();
        }
    } else {
        mapDiv.classList.remove('expanded');
        wrapper.classList.remove('shadow-lg');
        text.textContent = 'Show Map';
        btn.classList.remove('bg-[var(--primary)]', 'text-white');
        btn.classList.add('text-[var(--primary)]');
    }
}

function handleLocation(event) {
    const geo = event.target;
    
    if (geo.position) {
        const { latitude, longitude, accuracy } = geo.position.coords;
        
        document.getElementById('latitude').value = latitude.toFixed(6);
        document.getElementById('longitude').value = longitude.toFixed(6);
        
        document.getElementById('displayLat').textContent = latitude.toFixed(6);
        document.getElementById('displayLng').textContent = longitude.toFixed(6);
        document.getElementById('statusText').textContent = 'Location acquired (' + accuracy.toFixed(0) + 'm)';
        
        // Center map and marker on current location
        if (map && marker) {
            map.setView([latitude, longitude], 16);
            marker.setLatLng([latitude, longitude]);
        }
        
        reverseGeocode(latitude, longitude);
        
        document.getElementById('statusIcon').className = 'fa-solid fa-check-circle text-green-600';
    } else if (geo.error) {
        document.getElementById('statusText').textContent = geo.error.message || 'Location failed';
        document.getElementById('statusIcon').className = 'fa-solid fa-exclamation-triangle text-red-500';
    }
}

function requestLocation() {
    const geo = document.getElementById('geolocator');
    const btn = document.getElementById('getLocationBtn');
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Locating...';
    
    document.getElementById('statusText').textContent = 'Requesting your location...';
    
    geo.requestLocation();
    
    setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-crosshairs mr-2"></i> Use Location';
    }, 10000);
}

async function reverseGeocode(lat, lng) {
    try {
        const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
        const data = await res.json();
        
        if (data?.display_name) {
            document.getElementById('address').value = data.display_name;
            
            if (data.address) {
                const regionSelect = document.getElementById('region');
                const region = (data.address.state || data.address.region || '').toLowerCase();
                const opt = Array.from(regionSelect.options).find(o => o.value.toLowerCase().includes(region));
                if (opt) regionSelect.value = opt.value;

                document.getElementById('city').value = 
                    data.address.city || data.address.town || data.address.village || data.address.suburb || '';
            }
        }
    } catch (e) {
        console.error('Reverse geocoding failed', e);
    }
}

// ────────────────────────────────────────────────
// Initialize
// ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    // Toggle map
    document.getElementById('toggleMapBtn')?.addEventListener('click', toggleMap);

    // Reset
    document.getElementById('resetMapBtn')?.addEventListener('click', () => {
        if (map && marker) {
            map.setView([defaultLat, defaultLng], 13);
            marker.setLatLng([defaultLat, defaultLng]);
            document.getElementById('latitude').value = defaultLat.toFixed(6);
            document.getElementById('longitude').value = defaultLng.toFixed(6);
            document.getElementById('displayLat').textContent = defaultLat.toFixed(6);
            document.getElementById('displayLng').textContent = defaultLng.toFixed(6);
            document.getElementById('statusText').textContent = 'Reset to default';
        }
    });

    // Form submission (your original logic)
    const form = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitLoader = document.getElementById('submitLoader');
    const modal = document.getElementById('paymentModal');
    const modalContent = document.getElementById('modalContent');

    form.addEventListener('submit', async function(e) {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;

        if (paymentMethod === 'cash_on_delivery') {
            return;
        }

        e.preventDefault();

        if (!paymentMethod) {
            alert('Please select a payment method');
            return;
        }

        submitBtn.disabled = true;
        submitText.classList.add('hidden');
        submitLoader.classList.remove('hidden');
        modal.classList.remove('hidden');

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                },
                body: formData,
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.log('Error response:', errorText.substring(0, 400));
                throw new Error(`Server error ${response.status}`);
            }

            const data = await response.json();

            if (data.success) {
                modalContent.innerHTML = `
                    <i class="fa-solid fa-mobile-alt text-5xl mb-6" style="color: var(--primary);"></i>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Payment Request Sent!</h3>
                    <p class="text-lg text-gray-700 mb-2">Check your phone now</p>
                    <p class="text-base text-gray-600 mb-6">Follow the instructions to complete your payment.</p>
                    ${data.redirect_url ? `<a href="${data.redirect_url}" class="inline-block px-6 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition">Continue</a>` : ''}
                `;
            } else {
                modalContent.innerHTML = `
                    <i class="fa-solid fa-times-circle text-5xl mb-6 text-red-500"></i>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Payment Failed</h3>
                    <p class="text-lg text-gray-700 mb-6">${data.message || 'An error occurred while processing your payment.'}</p>
                    <button id="modalCloseBtn" class="inline-block px-6 py-3 bg-gray-600 text-white font-bold rounded-lg hover:bg-gray-700 transition">Close</button>
                `;
                document.getElementById('modalCloseBtn')?.addEventListener('click', () => modal.classList.add('hidden'));
            }
        } catch (error) {
            console.error('Fetch error:', error);
            modalContent.innerHTML = `
                <i class="fa-solid fa-times-circle text-5xl mb-6 text-red-500"></i>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Error</h3>
                <p class="text-lg text-gray-700 mb-6">${error.message || 'An unexpected error occurred. Please try again.'}</p>
                <p class="text-sm text-gray-500">Check browser console (F12) for details.</p>
                <button id="modalCloseBtn" class="inline-block px-6 py-3 bg-gray-600 text-white font-bold rounded-lg hover:bg-gray-700 transition">Close</button>
            `;
            document.getElementById('modalCloseBtn')?.addEventListener('click', () => modal.classList.add('hidden'));
        } finally {
            submitBtn.disabled = false;
            submitText.classList.remove('hidden');
            submitLoader.classList.add('hidden');
        }
    });
});
</script>
</body>
</html>