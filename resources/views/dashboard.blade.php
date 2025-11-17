<?php

use App\Models\Order;

$orders=Order::all();
$user = Auth::user();
$latestOrder = Order::where('user_id', $user->id)->latest()->first();
$order = Order::where('user_id', $user->id)->get();
$totalAmount = Order::sum('total_amount');
$orderNumber = Order::latest()->first()->order_number ?? 'ORD1000';
$totalAverage = Order::avg('total_amount');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Weru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
        }
        
        .action-card {
            transition: all 0.2s ease;
        }
        
        .action-card:hover {
            transform: translateX(4px);
        }
        
        .progress-step {
            transition: all 0.4s ease;
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
                    <div class="mb-4 flex justify-center">
                        <div class="bg-white rounded-full p-2 shadow-lg flex items-center justify-center" style="height:72px;width:72px;">
                            <img src="images\IMG-20251114-WA0007.jpg" alt="Weru Hardware Logo" class="h-20 w-24 object-contain" />
                        </div>
                    </div>
                    <span class="text-lg font-bold text-gray-900">Weru Hardware</span>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{url('dashboard')}}" class="text-sm font-semibold text-blue-600">Dashboard</a>
                    <a href="{{url('order')}}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Orders</a>
                    <a href="#" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Products</a>
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
                            <p class="text-sm font-semibold text-gray-900">{{$user->name}}</p>
                            <p class="text-xs text-gray-500">Customer</p>
                        </div>
                        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            
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
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-sm text-gray-600 mt-1">Welcome back, {{$user->name}}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-lg">
                        Customer
                    </span>
                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Total Orders -->
            <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Orders</p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">{{$order->count()}}</h3>
                    <p class="text-sm text-gray-500">
                        <span class="text-green-600 font-semibold">+3</span> this month
                    </p>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Pending Orders</p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $order->where('status', 'pending')->count() }}
</h3>
                    <p class="text-sm text-gray-500">
                        <span class="text-blue-600 font-semibold">{{ $order->where('status', 'processing')->count() }}
</span> processing
                    </p>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Spent</p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">{{$totalAmount}}</h3>
                    <p class="text-sm text-gray-500">
                        <span class="text-gray-700 font-semibold">{{$totalAverage}}</span> avg order
                    </p>
                </div>
            </div>

            <!-- Saved Addresses -->
            <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Saved Addresses</p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">3</h3>
                    <p class="text-sm text-gray-500">
                        <span class="text-purple-600 font-semibold">1</span> default set
                    </p>
                </div>
            </div>

        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Recent Orders - Takes 2 columns -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    
                    <!-- Header -->
                    <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Recent Orders</h3>
                        <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                            View All →
                        </a>
                    </div>

                    <!-- Orders List -->
                    <div class="divide-y divide-gray-200">
                        
                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="font-semibold text-gray-900">{{$orderNumber}}</span>
                                        <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-lg">
                                            {{$latestOrder->status ?? 'No status'}}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600">{{\Carbon\Carbon::now()->format('Y-m-d H:i:s')}} • {{$order->count()}}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900 mb-1">TZS 180,000</p>
                                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                        Details
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Profile Card -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl shadow-sm p-6 text-white">
                    <div class="flex items-center gap-4 mb-6">
                       
                        <div class="flex-1">
                            <h4 class="font-bold text-lg mb-0.5">{{$user->name}}</h4>
                            <p class="text-gray-300 text-sm">{{$user->email}}</p>
                        </div>
                    </div>
                    <a href="{{url('profile')}}" class="flex items-center justify-between px-4 py-3 bg-white/10 hover:bg-white/15 rounded-xl transition-colors">
                        <span class="text-sm font-semibold">Edit Profile</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <p class="text-xs text-gray-400 mt-4">Member since {{}}</p>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        
                        <a href="#" class="action-card flex items-center px-4 py-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all group">
                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-900 text-sm">New Order</span>
                        </a>

                        <a href="/products" class="action-card flex items-center px-4 py-3 bg-green-50 hover:bg-green-100 rounded-xl transition-all group">
                            <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-900 text-sm">Browse Products</span>
                        </a>

                        <a href="#" class="action-card flex items-center px-4 py-3 bg-purple-50 hover:bg-purple-100 rounded-xl transition-all group">
                            <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-900 text-sm">Manage Addresses</span>
                        </a>

                        <a href="#" class="action-card flex items-center px-4 py-3 bg-orange-50 hover:bg-orange-100 rounded-xl transition-all group">
                            <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-900 text-sm">Help & Support</span>
                        </a>

                    </div>
                </div>

            </div>

        </div>

        <!-- Active Order Tracking -->
        <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Active Order Tracking</h3>
                <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                    View Details →
                </a>
            </div>
            
            <div class="flex items-center justify-between mb-6">
                <span class="font-semibold text-gray-900">Order #10246</span>
                <span class="text-sm text-gray-600">Nov 12, 2025</span>
            </div>

            <!-- Progress Timeline -->
            <div class="relative">
                <div class="flex items-center">
                    
                    <!-- Step 1: Pending (Completed) -->
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white mb-3 progress-step">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-blue-600">Pending</span>
                    </div>

                    <!-- Connector 1 -->
                    <div class="flex-1 h-1 bg-blue-600 -mx-2 mb-8"></div>

                    <!-- Step 2: Processing (Current) -->
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white mb-3 progress-step relative">
                            <span class="text-sm font-bold">2</span>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-blue-400 rounded-full animate-ping"></span>
                        </div>
                        <span class="text-xs font-semibold text-blue-600">Processing</span>
                    </div>

                    <!-- Connector 2 -->
                    <div class="flex-1 h-1 bg-gray-300 -mx-2 mb-8"></div>

                    <!-- Step 3: Shipped (Upcoming) -->
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-white mb-3 progress-step">
                            <span class="text-sm font-bold">3</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-500">Shipped</span>
                    </div>

                    <!-- Connector 3 -->
                    <div class="flex-1 h-1 bg-gray-300 -mx-2 mb-8"></div>

                    <!-- Step 4: Delivered (Upcoming) -->
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-white mb-3 progress-step">
                            <span class="text-sm font-bold">4</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-500">Delivered</span>
                    </div>

                </div>
            </div>

            <!-- Status Message -->
            <div class="mt-6 p-4 bg-blue-50 rounded-xl">
                <p class="text-sm text-gray-700">
                    <span class="font-semibold text-blue-600">Your order is being processed.</span> 
                    We're preparing your items for shipment. Expected delivery: Nov 17-19, 2025.
                </p>
            </div>
        </div>

    </main>


</body>
</html>