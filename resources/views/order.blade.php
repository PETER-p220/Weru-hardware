<?php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
 @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>My Orders | Oweru Hardware</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * { -webkit-tap-highlight-color: transparent; }
        html { scroll-behavior: smooth; }
        :root {
            --primary: rgb(218,165,32);
            --primary-dark: rgb(218,165,32);
            --secondary: rgb(218,165,32);
            --dark-blue: #002147;
            --light-bg: #f5f5f5;
        }
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #f9f9f9 0%, #f5f5f5 100%);
        }
        .text-2xs { font-size: 0.625rem; line-height: 0.875rem; }
        
        /* Status badge styling */
        .status-badge { 
            font-weight: 600; 
            padding: 0.35rem 0.75rem; 
            border-radius: 9999px;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        /* Card animations */
        .card-hover { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 16px;
        }
        .card-hover:hover { 
            transform: translateY(-6px); 
            box-shadow: 0 20px 25px -5px rgba(218,165,32, 0.15);
        }
        
        /* Table row hover */
        .table-row { 
            transition: all 0.3s ease;
            border-radius: 12px;
        }
        .table-row:hover { 
            background-color: rgba(218, 165, 32, 0.08);
        }
        
        /* Filter active state */
        .filter-active { 
            background-color: var(--primary); 
            color: #000000;
            transform: scale(1.05);
        }

        /* Mobile menu */
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .mobile-menu.active {
            transform: translateX(0);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            body { padding: 0; margin: 0; }
            .header-nav { display: none; }
            .mobile-nav { display: flex; }
            .order-card { margin-bottom: 1rem; }
        }

        /* Loading skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s ease-in-out infinite;
        }
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Smooth transitions */
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-in { animation: slideInUp 0.5s ease-out forwards; }

        /* Button hover effects */
        .btn-primary {
            background-color: rgb(218,165,32);
            color: #000000;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            cursor: pointer;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(218,165,32, 0.3);
        }
        .btn-primary:active {
            transform: translateY(0);
        }

        /* Responsive grid */
        @media (max-width: 640px) {
            .grid-responsive { 
                grid-template-columns: 1fr; 
            }
            .header-title { font-size: 1.5rem; }
            .stat-value { font-size: 1.75rem; }
        }

        @media (min-width: 641px) and (max-width: 1024px) {
            .grid-responsive { 
                grid-template-columns: repeat(2, 1fr); 
            }
            .header-title { font-size: 2rem; }
            .stat-value { font-size: 2rem; }
        }

        @media (min-width: 1025px) {
            .grid-responsive { 
                grid-template-columns: repeat(4, 1fr); 
            }
            .header-title { font-size: 2.25rem; }
            .stat-value { font-size: 2.25rem; }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: rgb(218,165,32);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #d4af37;
        }

        /* Touch-friendly spacing */
        @media (max-width: 640px) {
            button, a {
                min-height: 44px;
                min-width: 44px;
            }
        }

        /* Responsive text sizes */
        .text-responsive-title {
            font-size: clamp(1.5rem, 5vw, 2.25rem);
        }
        .text-responsive-body {
            font-size: clamp(0.875rem, 2vw, 1rem);
        }

        /* Filter pill styling */
        .filter-pill {
            padding: 0.5rem 1rem;
            border-radius: 12px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
            white-space: nowrap;
            font-weight: 500;
        }
        .filter-pill:hover {
            transform: translateY(-2px);
        }

        /* Responsive table to cards */
        @media (max-width: 1024px) {
            .table-container {
                border: none;
                box-shadow: none;
            }
            .order-item {
                display: flex;
                flex-direction: column;
                background: white;
                border-radius: 12px;
                padding: 1rem;
                margin-bottom: 1rem;
                border: 2px solid #f5f5f5;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            }
        }

        /* Desktop table */
        @media (min-width: 1025px) {
            .order-item {
                display: grid;
                grid-template-columns: 2fr 2fr 1.5fr 1fr 1.5fr;
                gap: 1rem;
                align-items: center;
                padding: 1.5rem;
            }
        }

        /* Utility classes */
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .smooth-shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 10px 13px rgba(0, 0, 0, 0.1);
        }

        /* Success animation */
        @keyframes checkmark {
            0% { transform: scale(0) rotate(-45deg); }
            50% { transform: scale(1.2) rotate(0deg); }
            100% { transform: scale(1) rotate(0deg); }
        }
        .animate-checkmark { animation: checkmark 0.5s ease-out; }
    </style>
</head>
<body class="bg-slate-900 min-h-screen">

    <!-- Header -->
    <header class="sticky top-0 z-50 shadow-md backdrop-blur-md glass-effect" style="background-color: #002147; border-bottom: 2px solid rgba(218,165,32, 0.2);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 lg:py-6">
            <div class="flex items-center justify-between">
                <!-- Logo Section -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-110 transition" style="background-color: rgb(218,165,32);">
                        <i class="fa-solid fa-hard-hat text-white text-lg sm:text-xl" style="color: #002147;"></i>
                    </div>
                    <div>
                        <h1 class="text-base sm:text-lg lg:text-xl font-black text-white leading-tight">
                            Oweru<span style="color: rgb(218,165,32);">Hardware</span>
                        </h1>
                        <p class="text-2xs sm:text-xs text-gray-300">Order Management</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex gap-8 items-center">
                    <a href="{{ route('dashboard') ?? '#' }}" class="text-sm font-medium transition" style="color: rgba(218,165,32, 0.8);" onmouseover="this.style.color='rgb(218,165,32)'" onmouseout="this.style.color='rgba(218,165,32, 0.8)'">
                        <i class="fa-solid fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('order') ?? '#' }}" class="text-sm font-bold" style="color: rgb(218,165,32);">
                        <i class="fa-solid fa-shopping-bag mr-2"></i>My Orders
                    </a>
                    <a href="{{ route('products') ?? '#' }}" class="text-sm font-medium transition" style="color: rgba(218,165,32, 0.8);" onmouseover="this.style.color='rgb(218,165,32)'" onmouseout="this.style.color='rgba(218,165,32, 0.8)'">
                        <i class="fa-solid fa-store mr-2"></i>Shop
                    </a>
                    <a href="#" class="text-sm font-medium transition" style="color: rgba(218,165,32, 0.8);" onmouseover="this.style.color='rgb(218,165,32)'" onmouseout="this.style.color='rgba(218,165,32, 0.8)'">
                        <i class="fa-solid fa-headset mr-2"></i>Support
                    </a>
                </nav>

                <!-- Right Section -->
                <div class="flex items-center gap-3 sm:gap-6">
                    <!-- Notification -->
                    <div class="relative hidden sm:inline-block">
                        <button id="user-notif-bell" class="relative p-2 rounded-full transition inline-flex hover:scale-110" style="background-color: rgba(218,165,32, 0.1); color: rgb(218,165,32);">
                            <i class="fa-regular fa-bell text-lg"></i>
                            <span id="user-notif-badge" class="hidden absolute top-1 right-1 w-4 h-4 bg-red-600 text-[10px] text-white rounded-full flex items-center justify-center font-bold"></span>
                        </button>
                        <div id="user-notif-panel" class="hidden absolute right-0 mt-3 w-80 max-w-sm z-40">
                            <div class="bg-white border border-gray-200 rounded-2xl shadow-2xl overflow-hidden">
                                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                    <p class="text-sm font-semibold text-gray-900">Notifications</p>
                                    <button type="button" id="user-notif-clear" class="text-xs text-gray-500 hover:text-gray-700">Clear</button>
                                </div>
                                <div id="user-notif-list" class="max-h-72 overflow-y-auto">
                                    <div class="px-4 py-4 text-sm text-gray-500 text-center">
                                        No notifications yet.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Section -->
                    @if($user)
                        <div class="flex items-center gap-2 sm:gap-4">
                            <div class="hidden sm:text-right">
                                <p class="font-bold text-xs sm:text-sm text-white">{{ Str::limit($user->name, 15) }}</p>
                                <p class="text-2xs text-gray-300">Customer</p>
                            </div>
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg" style="background: linear-gradient(135deg, rgb(218,165,32), #002147);">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary text-sm sm:text-base">
                            <i class="fa-solid fa-sign-in-alt mr-2"></i>Login
                        </a>
                    @endif

                    <!-- Mobile Menu Toggle -->
                    <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg" style="background-color: rgba(218,165,32, 0.1);">
                        <i class="fa-solid fa-bars text-xl" style="color: rgb(218,165,32);"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobile-menu" class="hidden lg:hidden pb-4 border-t border-gray-700">
                <nav class="flex flex-col gap-3 mt-4">
                    <a href="{{ route('dashboard') ?? '#' }}" class="block px-4 py-3 rounded-lg text-sm font-medium transition hover:scale-105" style="background: rgba(218,165,32, 0.1); color: rgba(218,165,32, 0.9);">
                        <i class="fa-solid fa-home mr-3"></i>Dashboard
                    </a>
                    <a href="{{ route('order') ?? '#' }}" class="block px-4 py-3 rounded-lg text-sm font-medium transition hover:scale-105" style="background: rgba(218,165,32, 0.1); color: rgba(218,165,32, 0.9);">
                        <i class="fa-solid fa-shopping-bag mr-3"></i>My Orders
                    </a>
                    <a href="{{ route('products') ?? '#' }}" class="block px-4 py-3 rounded-lg text-sm font-medium transition hover:scale-105" style="background: rgba(218,165,32, 0.1); color: rgba(218,165,32, 0.9);">
                        <i class="fa-solid fa-store mr-3"></i>Shop
                    </a>
                    <a href="#" class="block px-4 py-3 rounded-lg text-sm font-medium transition hover:scale-105" style="background: rgba(218,165,32, 0.1); color: rgba(218,165,32, 0.9);">
                        <i class="fa-solid fa-headset mr-3"></i>Support
                    </a>
                </nav>
            </div>
        </div>
    </header>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-12">
        @if(!$user)
            <!-- Guest View -->
            <div class="rounded-2xl lg:rounded-3xl overflow-hidden animate-slide-in" style="background: linear-gradient(135deg, rgba(0, 33, 71, 0.05), rgba(218, 165, 32, 0.05));">
                <div class="py-16 lg:py-24 px-6 text-center">
                    <div class="w-20 h-20 lg:w-28 lg:h-28 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-lock text-4xl lg:text-6xl" style="color: #002147;"></i>
                    </div>
                    <h2 class="text-responsive-title font-black mb-4" style="color: #002147;">Login Required</h2>
                    <p class="text-responsive-body text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
                        You need to be signed in to view and track your orders. Manage your purchases, track shipments, and view order history.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}" class="btn-primary text-base">
                            <i class="fa-solid fa-sign-in-alt mr-2"></i>Login Now
                        </a>
                        <a href="{{ route('register') }}" class="btn-secondary text-base">
                            <i class="fa-solid fa-user-plus mr-2"></i>Create Account
                        </a>
                    </div>
                </div>
            </div>
        @else
            @php
                // Ensure variables exist (passed from controller)
                $totalOrders = $totalOrders ?? ($orders->total() ?? 0);
                $pendingOrders = $pendingOrders ?? 0;
                $processingOrders = $processingOrders ?? 0;
                $shippedOrders = $shippedOrders ?? 0;
                $deliveredOrders = $deliveredOrders ?? 0;
                $processing = $processingOrders; // Alias for compatibility with existing code
            @endphp

            <!-- Page Header -->
            <div class="mb-8 lg:mb-12 animate-slide-in">
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                    <div>
                        <h2 class="text-responsive-title font-black text-gray-900">My Orders</h2>
                        <p class="text-responsive-body text-gray-600 mt-2">
                            <i class="fa-solid fa-info-circle mr-2" style="color: rgb(218,165,32);"></i>
                            Track, manage, and review all your purchases
                        </p>
                    </div>
                    <a href="{{ route('products') ?? '#' }}" class="btn-primary text-sm sm:text-base inline-flex items-center justify-center">
                        <i class="fa-solid fa-plus mr-2"></i>
                        <span class="hidden sm:inline">Place New Order</span>
                        <span class="sm:hidden">New Order</span>
                    </a>
                </div>
            </div>

            <!-- Stats Cards Grid -->
            <div class="grid grid-responsive gap-4 lg:gap-6 mb-8 lg:mb-12">
                <!-- Total Orders Card -->
                <div class="card-hover glass-effect rounded-xl sm:rounded-2xl p-5 sm:p-6 lg:p-8 smooth-shadow animate-slide-in" style="border: 2px solid rgba(218, 165, 32, 0.1);">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-2xs sm:text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Total Orders</p>
                            <p class="stat-value font-black text-gray-900">{{ $totalOrders }}</p>
                        </div>
                        <div class="p-3 sm:p-4 rounded-xl" style="background-color: rgba(218, 165, 32, 0.1);">
                            <i class="fa-solid fa-receipt text-xl sm:text-2xl" style="color: rgb(218,165,32);"></i>
                        </div>
                    </div>
                    <p class="text-2xs sm:text-xs text-gray-500">All orders placed</p>
                </div>

                <!-- Processing Orders Card -->
                <div class="card-hover glass-effect rounded-xl sm:rounded-2xl p-5 sm:p-6 lg:p-8 smooth-shadow animate-slide-in" style="border: 2px solid rgba(218, 165, 32, 0.1);">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-2xs sm:text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Processing</p>
                            <p class="stat-value font-black text-gray-900">{{ ($pendingOrders ?? 0) + ($processingOrders ?? 0) }}</p>
                        </div>
                        <div class="p-3 sm:p-4 rounded-xl" style="background-color: rgba(218, 165, 32, 0.1);">
                            <i class="fa-solid fa-hourglass-half text-xl sm:text-2xl" style="color: rgb(218,165,32);"></i>
                        </div>
                    </div>
                    <p class="text-2xs sm:text-xs text-gray-500">Pending & processing</p>
                </div>

                <!-- Shipped Orders Card -->
                <div class="card-hover glass-effect rounded-xl sm:rounded-2xl p-5 sm:p-6 lg:p-8 smooth-shadow animate-slide-in" style="border: 2px solid rgba(218, 165, 32, 0.1);">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-2xs sm:text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">In Transit</p>
                            <p class="stat-value font-black text-gray-900">{{ $shippedOrders ?? 0 }}</p>
                        </div>
                        <div class="p-3 sm:p-4 rounded-xl" style="background-color: rgba(218, 165, 32, 0.1);">
                            <i class="fa-solid fa-truck text-xl sm:text-2xl" style="color: rgb(218,165,32);"></i>
                        </div>
                    </div>
                    <p class="text-2xs sm:text-xs text-gray-500">Shipped orders</p>
                </div>

                <!-- Delivered Orders Card -->
                <div class="card-hover glass-effect rounded-xl sm:rounded-2xl p-5 sm:p-6 lg:p-8 smooth-shadow animate-slide-in" style="border: 2px solid rgba(34, 197, 94, 0.1);">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-2xs sm:text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Delivered</p>
                            <p class="stat-value font-black text-green-600">{{ $deliveredOrders ?? 0 }}</p>
                        </div>
                        <div class="p-3 sm:p-4 rounded-xl" style="background-color: rgba(34, 197, 94, 0.1);">
                            <i class="fa-solid fa-check-circle text-xl sm:text-2xl text-green-600"></i>
                        </div>
                    </div>
                    <p class="text-2xs sm:text-xs text-gray-500">Completed</p>
                </div>
            </div>

            <!-- Filters & Search Section -->
            <div class="glass-effect rounded-xl sm:rounded-2xl p-4 sm:p-6 lg:p-8 mb-8 lg:mb-12 smooth-shadow animate-slide-in" style="border: 2px solid rgba(218, 165, 32, 0.1);">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 lg:gap-6">
                    <!-- Filter Pills -->
                    <div class="flex flex-wrap gap-2 overflow-x-auto pb-2">
                        @php $currentFilter = request('status', 'all'); @endphp
                        <a href="{{ route('order') }}?status=all" class="filter-pill" style="background-color: {{ $currentFilter == 'all' ? 'rgb(218,165,32)' : '#f5f5f5' }}; color: {{ $currentFilter == 'all' ? '#000000' : '#333333' }};">
                            <i class="fa-solid fa-list mr-2"></i>All<span class="ml-2 text-xs">({{ $totalOrders }})</span>
                        </a>
                        <a href="{{ route('order') }}?status=pending" class="filter-pill" style="background-color: {{ $currentFilter == 'pending' ? 'rgb(218,165,32)' : '#f5f5f5' }}; color: {{ $currentFilter == 'pending' ? '#000000' : '#333333' }};">
                            <i class="fa-solid fa-clock mr-2"></i>Pending<span class="ml-2 text-xs">({{ $pendingOrders }})</span>
                        </a>
                        <a href="{{ route('order') }}?status=processing" class="filter-pill" style="background-color: {{ $currentFilter == 'processing' ? 'rgb(218,165,32)' : '#f5f5f5' }}; color: {{ $currentFilter == 'processing' ? '#000000' : '#333333' }};">
                            <i class="fa-solid fa-spinner mr-2"></i>Processing<span class="ml-2 text-xs">({{ $processingOrders }})</span>
                        </a>
                        <a href="{{ route('order') }}?status=shipped" class="filter-pill" style="background-color: {{ in_array($currentFilter, ['shipped','in_transit']) ? 'rgb(218,165,32)' : '#f5f5f5' }}; color: {{ in_array($currentFilter, ['shipped','in_transit']) ? '#000000' : '#333333' }};">
                            <i class="fa-solid fa-truck mr-2"></i>Shipped<span class="ml-2 text-xs">({{ $shippedOrders }})</span>
                        </a>
                        <a href="{{ route('order') }}?status=delivered" class="filter-pill" style="background-color: {{ $currentFilter == 'delivered' ? 'rgb(218,165,32)' : '#f5f5f5' }}; color: {{ $currentFilter == 'delivered' ? '#000000' : '#333333' }};">
                            <i class="fa-solid fa-check-circle mr-2"></i>Delivered<span class="ml-2 text-xs">({{ $deliveredOrders }})</span>
                        </a>
                    </div>

                    <!-- Search & Filter Button -->
                    <div class="flex gap-2 flex-shrink-0">
                        <input type="text" placeholder="Search order..." class="hidden sm:block px-4 py-2.5 border-2 rounded-lg text-sm" style="border-color: #002147; background-color: #f5f5f5;" />
                        <button class="p-2.5 rounded-lg text-sm font-medium transition hover:scale-110" style="background-color: #f5f5f5; color: #002147;">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Orders Container -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border-2 overflow-hidden smooth-shadow animate-slide-in" style="border-color: #f5f5f5;">
                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b-2" style="background-color: rgba(218, 165, 32, 0.08); border-color: #f5f5f5;">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr class="table-row border-b-2" style="border-color: #f5f5f5;">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="hidden sm:flex w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: rgba(218, 165, 32, 0.1);">
                                                <i class="fa-solid fa-box" style="color: rgb(218,165,32); font-size: 1.25rem;"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-sm lg:text-base" style="color: #002147;">#{{ $order->order_number ?? str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                                                <p class="text-xs text-gray-500">Order ID</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="font-medium text-sm text-gray-700">{{ $order->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->format('h:i A') }}</p>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="status-badge text-xs" style="background-color: rgb(218,165,32); color: #000000;">
                                            <i class="fa-solid fa-circle-check mr-1.5"></i>{{ ucwords(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="font-bold text-lg" style="color: #002147;">TZS {{ number_format($order->total_amount, 0) }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->orderItems->sum('quantity') ?? $order->orderItems->count() }} item(s)</p>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex gap-2 justify-center">
                                            <a href="{{ route('order.show', $order) }}" title="View Details" class="p-2 rounded-lg transition hover:bg-blue-50">
                                                <i class="fa-solid fa-eye text-lg" style="color: #002147;"></i>
                                            </a>
                                            <a href="{{ route('order.invoice', $order) }}" title="Download Invoice" class="p-2 rounded-lg transition hover:bg-blue-50">
                                                <i class="fa-solid fa-download text-lg" style="color: #666666;"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-16 px-4">
                                        <i class="fa-solid fa-inbox text-5xl mb-4 block" style="color: #cccccc;"></i>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Orders Yet</h3>
                                        <p class="text-gray-600 mb-6">Start shopping to see your orders here</p>
                                        <a href="{{ route('products') ?? '#' }}" class="btn-primary inline-block">
                                            <i class="fa-solid fa-shopping-bag mr-2"></i>Browse Products
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="lg:hidden divide-y-2" style="divide-color: #f5f5f5;">
                    @forelse($orders as $order)
                        <div class="order-item animate-slide-in">
                            <div class="flex items-center gap-3 mb-4 pb-4 border-b" style="border-color: #f5f5f5;">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: rgba(218, 165, 32, 0.1);">
                                    <i class="fa-solid fa-box" style="color: rgb(218,165,32);"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-sm" style="color: #002147;">#{{ $order->order_number ?? str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <span class="status-badge text-xs" style="background-color: rgb(218,165,32); color: #000000;">
                                    {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </div>

                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-gray-600 uppercase">Amount</span>
                                    <p class="font-bold text-lg" style="color: #002147;">TZS {{ number_format($order->total_amount, 0) }}</p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-gray-600 uppercase">Items</span>
                                    <p class="text-sm font-medium text-gray-700">{{ $order->orderItems->sum('quantity') ?? $order->orderItems->count() }} item(s)</p>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('order.show', $order) }}" class="flex-1 py-2 px-4 bg-blue-50 text-center rounded-lg font-medium text-sm transition hover:bg-blue-100" style="color: #002147;">
                                    <i class="fa-solid fa-eye mr-2"></i>Details
                                </a>
                                <a href="{{ route('order.invoice', $order) }}" title="Download" class="py-2 px-4 rounded-lg font-medium text-sm transition hover:bg-gray-100" style="background-color: #f5f5f5; color: #666666;">
                                    <i class="fa-solid fa-download"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 px-4">
                            <i class="fa-solid fa-inbox text-5xl mb-4 block" style="color: #cccccc;"></i>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">No Orders Yet</h3>
                            <p class="text-sm text-gray-600 mb-6">Start shopping to see your orders here</p>
                            <a href="{{ route('products') ?? '#' }}" class="btn-primary inline-block">
                                <i class="fa-solid fa-shopping-bag mr-2"></i>Browse
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-8 lg:mt-12 flex justify-center">
                    <div class="flex gap-2 flex-wrap justify-center">
                        {{ $orders->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        @endif
    </main>

    <!-- Footer -->
    <footer class="mt-16 lg:mt-24 text-blue-100 py-12 lg:py-16 border-t-2" style="background-color: #002147; border-color: rgba(218, 165, 32, 0.2);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 mb-8">
                <!-- Brand -->
                <div>
                    <h3 class="text-lg font-black text-white mb-3">
                        Oweru<span style="color: rgb(218,165,32);">Hardware</span>
                    </h3>
                    <p class="text-sm text-blue-200">
                        Tanzania's premier building materials supplier with nationwide fast delivery.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-blue-200 hover:text-white transition" style="color: rgba(218,165,32, 0.8);">Orders</a></li>
                        <li><a href="#" class="text-blue-200 hover:text-white transition" style="color: rgba(218,165,32, 0.8);">Support</a></li>
                        <li><a href="#" class="text-blue-200 hover:text-white transition" style="color: rgba(218,165,32, 0.8);">Settings</a></li>
                    </ul>
                </div>

                <!-- Help -->
                <div>
                    <h4 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Help</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-blue-200 hover:text-white transition" style="color: rgba(218,165,32, 0.8);">Contact Us</a></li>
                        <li><a href="#" class="text-blue-200 hover:text-white transition" style="color: rgba(218,165,32, 0.8);">Privacy Policy</a></li>
                        <li><a href="#" class="text-blue-200 hover:text-white transition" style="color: rgba(218,165,32, 0.8);">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t-2 pt-6 lg:pt-8 text-center text-xs lg:text-sm" style="border-color: rgba(218, 165, 32, 0.2);">
                <p class="text-blue-200 mb-2">&copy; {{ date('Y') }} Oweru Hardware. All rights reserved.</p>
                <p class="text-blue-300">
                    <a href="#" class="transition" style="color: rgb(218,165,32);">Privacy</a> • 
                    <a href="#" class="transition" style="color: rgb(218,165,32);">Terms</a> • 
                    <a href="#" class="transition" style="color: rgb(218,165,32);">Contact</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Enhanced Interactivity -->
    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                const isOpen = !mobileMenu.classList.contains('hidden');
                mobileMenuBtn.innerHTML = isOpen 
                    ? '<i class="fa-solid fa-xmark text-xl" style="color: rgb(218,165,32);"></i>' 
                    : '<i class="fa-solid fa-bars text-xl" style="color: rgb(218,165,32);"></i>';
            });

            // Close menu when a link is clicked
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    mobileMenuBtn.innerHTML = '<i class="fa-solid fa-bars text-xl" style="color: rgb(218,165,32);"></i>';
                });
            });
        }

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                const target = document.querySelector(anchor.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-slide-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all stat cards and order items
        document.querySelectorAll('.card-hover, .order-item').forEach(el => {
            observer.observe(el);
        });

        // Add button ripple effect
        document.querySelectorAll('button, a.btn-primary').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (window.innerWidth > 768) {
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

        // Ripple animation
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

        // Add CSS for button styling
        const btnStyle = document.createElement('style');
        btnStyle.innerHTML = `
            .btn-secondary {
                background-color: white;
                color: #002147;
                border: 2px solid #002147;
                font-weight: 600;
                padding: 0.75rem 1.5rem;
                border-radius: 12px;
                transition: all 0.3s ease;
                cursor: pointer;
            }
            .btn-secondary:hover {
                background-color: #f5f5f5;
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(0, 33, 71, 0.2);
            }
            .btn-secondary:active {
                transform: translateY(0);
            }
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(btnStyle);

        // Smooth page transitions
        window.addEventListener('beforeunload', () => {
            document.body.style.opacity = '0.95';
        });

        window.addEventListener('load', () => {
            document.body.style.transition = 'opacity 0.3s ease';
            document.body.style.opacity = '1';
        });

        // =========================================================================
        // Live Order Status Notification on Orders Page (same as dashboard)
        // =========================================================================
        (function() {
            const bell    = document.getElementById('user-notif-bell');
            const badge   = document.getElementById('user-notif-badge');
            const panel   = document.getElementById('user-notif-panel');
            const listEl  = document.getElementById('user-notif-list');
            const clearEl = document.getElementById('user-notif-clear');

            if (!bell || !badge || !panel || !listEl || !clearEl) return;

            const seenOrderIds   = new Set();
            const orderStatusMap = {};
            let firstLoad = true;

            function statusLabel(str) {
                if (!str) return '';
                str = String(str);
                return str.charAt(0).toUpperCase() + str.slice(1);
            }

            function addNotification(order, oldStatus) {
                if (!order) return;

                // Reset "no notifications" placeholder
                if (listEl.children.length === 1 && listEl.children[0].textContent.includes('No notifications')) {
                    listEl.innerHTML = '';
                }

                const item = document.createElement('div');
                item.className = 'px-4 py-3 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition';
                item.innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 text-green-600">
                            <i class="fa-solid fa-circle text-[8px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-900">
                                Order #${order.order_number ?? ('ID ' + order.id)} status updated
                            </p>
                            <p class="text-xs text-gray-600 mt-0.5">
                                ${oldStatus ? statusLabel(oldStatus) + ' → ' : ''}<span class="font-semibold">${statusLabel(order.status)}</span>
                            </p>
                            <p class="text-[11px] text-gray-500 mt-0.5">
                                Total: TZS ${Number(order.total_amount).toLocaleString('en-US')}
                            </p>
                        </div>
                    </div>
                `;
                listEl.prepend(item);

                // Show badge
                badge.textContent = '1';
                badge.classList.remove('hidden');

                // Auto-open panel on first notification
                if (panel.classList.contains('hidden')) {
                    panel.classList.remove('hidden');
                }
            }

            async function checkOrderStatus() {
                try {
                    const response = await fetch('{{ route('user.orders.latest') }}', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (!response.ok) return;

                    const data = await response.json();

                    if (Array.isArray(data.orders)) {
                        if (firstLoad) {
                            // On first load, show ALL orders as notifications
                            listEl.innerHTML = '';
                            data.orders.forEach(o => {
                                if (!o?.id) return;
                                addNotification(o, null);
                                seenOrderIds.add(o.id);
                                orderStatusMap[o.id] = (o.status || '').toLowerCase();
                            });
                            firstLoad = false;
                            return;
                        }

                        // Subsequent polls: only new orders or status changes
                        data.orders.forEach(o => {
                            if (!o?.id) return;

                            if (!seenOrderIds.has(o.id)) {
                                addNotification(o, null);
                                seenOrderIds.add(o.id);
                                orderStatusMap[o.id] = (o.status || '').toLowerCase();
                                return;
                            }

                            const currentStatus = (o.status || '').toLowerCase();
                            const prevStatus    = orderStatusMap[o.id];
                            if (prevStatus && currentStatus && currentStatus !== prevStatus) {
                                addNotification(o, prevStatus);
                                orderStatusMap[o.id] = currentStatus;
                            }
                        });
                    }
                } catch (e) {
                    // Silent fail; will retry on next interval
                }
            }

            // Toggle panel on bell click
            bell.addEventListener('click', () => {
                panel.classList.toggle('hidden');
                if (!panel.classList.contains('hidden')) {
                    badge.classList.add('hidden');
                }
            });

            // Clear notifications
            clearEl.addEventListener('click', () => {
                listEl.innerHTML = `
                    <div class="px-4 py-4 text-sm text-gray-500 text-center">
                        No notifications yet.
                    </div>
                `;
                badge.classList.add('hidden');
            });

            // Initial check and polling every 10 seconds
            setTimeout(checkOrderStatus, 2000);
            setInterval(checkOrderStatus, 10000);
        })();
    </script>
</body>
</html>
