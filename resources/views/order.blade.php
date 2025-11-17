<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Weru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .order-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .filter-btn {
            transition: all 0.2s ease;
        }
        
        .filter-btn.active {
            background: linear-gradient(to right, #2563eb, #4f46e5);
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                         <img src="images\IMG-20251114-WA0007.jpg" alt="Weru Hardware Logo" class="h-16 w-50 drop-shadow-xl" />
                        </svg>
                    </div>
                  
                    <span class="text-lg font-bold text-gray-900">Weru Hardware</span>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{url('dashboard')}}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Dashboard</a>
                    <a href="{{url('order')}}" class="text-sm font-semibold text-blue-600">Orders</a>
                    <a href="{{url('products')}}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Products</a>
                    <a href="#" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Support</a>
                </nav>
                
                <!-- User Menu -->
                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    
                    <div class="flex items-center gap-3 pl-3 border-l border-gray-200">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-gray-900">John Mwamba</p>
                            <p class="text-xs text-gray-500">Customer</p>
                        </div>
                        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            JM
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    

    <!-- Page Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Orders</h1>
                    <p class="text-sm text-gray-600 mt-1">Track and manage all your orders</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export
                    </button>
                    <button class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-colors text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Order
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-gray-600">All Orders</p>
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">24</h3>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">5</h3>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-gray-600">In Transit</p>
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">3</h3>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-gray-600">Delivered</p>
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">16</h3>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="search" placeholder="Search by order ID, date, or amount..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2">
                    <button class="filter-btn active px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">
                        All Orders
                    </button>
                    <button class="filter-btn px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">
                        Pending
                    </button>
                    <button class="filter-btn px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">
                        Processing
                    </button>
                    <button class="filter-btn px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">
                        Shipped
                    </button>
                    <button class="filter-btn px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">
                        Delivered
                    </button>
                </div>

                <!-- Date Filter -->
                <button class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Date Range
                </button>
            </div>
        </div>

        <!-- Orders List -->
        <div class="space-y-4">
            
            <!-- Order Card 1 -->
            <div class="order-card bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-bold text-gray-900">Order #10247</h3>
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-lg">
                                        Delivered
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">Placed on November 10, 2025 at 2:30 PM</p>
                                <p class="text-sm text-gray-600">5 items • Delivered to Mikocheni, Dar es Salaam</p>
                            </div>
                        </div>
                        <div class="text-left lg:text-right">
                            <p class="text-2xl font-bold text-gray-900 mb-1">TZS 450,000</p>
                            <p class="text-sm text-gray-500">Paid via M-Pesa</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View Details
                            </button>
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download Invoice
                            </button>
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reorder
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Card 2 -->
            <div class="order-card bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-bold text-gray-900">Order #10246</h3>
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-lg">
                                        Shipped
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">Placed on November 12, 2025 at 10:15 AM</p>
                                <p class="text-sm text-gray-600">3 items • Shipping to Kinondoni, Dar es Salaam</p>
                            </div>
                        </div>
                        <div class="text-left lg:text-right">
                            <p class="text-2xl font-bold text-gray-900 mb-1">TZS 280,000</p>
                            <p class="text-sm text-gray-500">Paid via Bank Transfer</p>
                        </div>
                    </div>

                    <!-- Tracking Progress -->
                    <div class="bg-purple-50 rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-semibold text-purple-900">In Transit</p>
                            <p class="text-xs text-purple-700">Expected: Nov 17-19</p>
                        </div>
                        <div class="w-full bg-purple-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                Track Order
                            </button>
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View Details
                            </button>
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Contact Support
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Card 3 -->
            <div class="order-card bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-bold text-gray-900">Order #10245</h3>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-lg">
                                        Processing
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">Placed on November 13, 2025 at 3:45 PM</p>
                                <p class="text-sm text-gray-600">8 items • To be delivered to Masaki, Dar es Salaam</p>
                            </div>
                        </div>
                        <div class="text-left lg:text-right">
                            <p class="text-2xl font-bold text-gray-900 mb-1">TZS 620,000</p>
                            <p class="text-sm text-gray-500">Paid via M-Pesa</p>
                        </div>
                    </div>

                    <!-- Processing Status -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-blue-900 mb-1">Your order is being prepared</p>
                                <p class="text-xs text-blue-700">We're gathering your items and will ship them soon</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View Details
                            </button>
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancel Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Card 4 -->
            <div class="order-card bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-bold text-gray-900">Order #10244</h3>
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-lg">
                                        Pending Payment
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">Placed on November 14, 2025 at 11:20 AM</p>
                                <p class="text-sm text-gray-600">2 items • To be delivered to Mbezi, Dar es Salaam</p>
                            </div>
                        </div>
                        <div class="text-left lg:text-right">
                            <p class="text-2xl font-bold text-gray-900 mb-1">TZS 180,000</p>
                            <p class="text-sm text-red-600 font-medium">Payment Required</p>
                        </div>
                    </div>

                    <!-- Payment Warning -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"/>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-yellow-900 mb-1">Payment pending</p>
                                <p class="text-xs text-yellow-700">Complete payment within 24 hours to process your order</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-600 text-white text-sm font-semibold rounded-lg hover:bg-yellow-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Complete Payment
                            </button>
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View Details
                            </button>
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancel Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Card 5 -->
            <div class="order-card bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-bold text-gray-900">Order #10243</h3>
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-lg">
                                        Delivered
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">Placed on November 5, 2025 at 9:00 AM</p>
                                <p class="text-sm text-gray-600">6 items • Delivered to Oysterbay, Dar es Salaam</p>
                            </div>
                        </div>
                        <div class="text-left lg:text-right">
                            <p class="text-2xl font-bold text-gray-900 mb-1">TZS 520,000</p>
                            <p class="text-sm text-gray-500">Paid via Bank Transfer</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                Leave Review
                            </button>
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View Details
                            </button>
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reorder
                            </button>
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Invoice
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Pagination -->
        <div class="mt-8 flex items-center justify-between">
            <p class="text-sm text-gray-600">Showing <span class="font-semibold">1-5</span> of <span class="font-semibold">24</span> orders</p>
            
            <div class="flex items-center gap-2">
                <button class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Previous
                </button>
                <button class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">1</button>
                <button class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">2</button>
                <button class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">3</button>
                <button class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">4</button>
                <span class="px-3 py-2 text-gray-500">...</span>
                <button class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                    Next
                </button>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-600">© 2025 Weru Hardware. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Privacy Policy</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Terms of Service</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Support</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>