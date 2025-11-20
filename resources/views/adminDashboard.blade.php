<?php
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

$product=Product::all();
$user=User::all();
$order=Order::all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Weru Hardware</title>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-gray-900">Weru Hardware Admin</span>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{url('adminDashboard')}}" class="text-sm font-semibold text-blue-600">Dashboard</a>
                    <a href="{{url('products')}}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Products</a>
                    <a href="{{url('order')}}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Orders</a>
                    <a href="{{url('user')}}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Customers</a>
                    <a href="#" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Settings</a>
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
                            <p class="text-sm font-semibold text-gray-900">Admin User</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <div class="w-9 h-9 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            AU
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Overview</h1>
            <p class="text-gray-600">Welcome back! Here's what's happening today.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Total Revenue -->
            <div class="stat-card bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">+12.5%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">TZS 8.5M</h3>
                <p class="text-sm text-gray-600">Total Revenue</p>
                <p class="text-xs text-gray-500 mt-2">vs. last month</p>
            </div>

            <!-- Total Orders -->
            <div class="stat-card bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">+8.2%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">{{$order->count() }}</h3>
                <p class="text-sm text-gray-600">Total Orders</p>
                <p class="text-xs text-gray-500 mt-2">vs. last month</p>
            </div>

            <!-- Total Products -->
            <div class="stat-card bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded">Active</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">{{$product->count()}}</h3>
                <p class="text-sm text-gray-600">Total Products</p>
                <p class="text-xs text-gray-500 mt-2">In catalog</p>
            </div>

            <!-- Total Customers -->
            <div class="stat-card bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">+15.3%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">{{$user->count()}}</h3>
                <p class="text-sm text-gray-600">Total Customers</p>
                <p class="text-xs text-gray-500 mt-2">vs. last month</p>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Recent Orders -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Recent Orders</h2>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">View All</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left text-xs font-semibold text-gray-600 pb-3">Order ID</th>
                                    <th class="text-left text-xs font-semibold text-gray-600 pb-3">Customer</th>
                                    <th class="text-left text-xs font-semibold text-gray-600 pb-3">Product</th>
                                    <th class="text-left text-xs font-semibold text-gray-600 pb-3">Amount</th>
                                    <th class="text-left text-xs font-semibold text-gray-600 pb-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 text-sm font-medium text-gray-900">#ORD-1001</td>
                                    <td class="py-4 text-sm text-gray-600">John Mwamba</td>
                                    <td class="py-4 text-sm text-gray-600">Mbeya Cement 50kg</td>
                                    <td class="py-4 text-sm font-semibold text-gray-900">TZS 480,000</td>
                                    <td class="py-4">
                                        <span class="px-2.5 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Delivered</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 text-sm font-medium text-gray-900">#ORD-1002</td>
                                    <td class="py-4 text-sm text-gray-600">Sarah Kimaro</td>
                                    <td class="py-4 text-sm text-gray-600">Y12 TMT Steel Rebar</td>
                                    <td class="py-4 text-sm font-semibold text-gray-900">TZS 185,000</td>
                                    <td class="py-4">
                                        <span class="px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">Processing</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 text-sm font-medium text-gray-900">#ORD-1003</td>
                                    <td class="py-4 text-sm text-gray-600">Peter Komba</td>
                                    <td class="py-4 text-sm text-gray-600">Roofing Sheet 3m</td>
                                    <td class="py-4 text-sm font-semibold text-gray-900">TZS 210,000</td>
                                    <td class="py-4">
                                        <span class="px-2.5 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">Pending</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 text-sm font-medium text-gray-900">#ORD-1004</td>
                                    <td class="py-4 text-sm text-gray-600">Grace Ndege</td>
                                    <td class="py-4 text-sm text-gray-600">Crown Paint 20L</td>
                                    <td class="py-4 text-sm font-semibold text-gray-900">TZS 144,500</td>
                                    <td class="py-4">
                                        <span class="px-2.5 py-1 text-xs font-semibold text-purple-700 bg-purple-100 rounded-full">Shipped</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 text-sm font-medium text-gray-900">#ORD-1005</td>
                                    <td class="py-4 text-sm text-gray-600">David Moshi</td>
                                    <td class="py-4 text-sm text-gray-600">PVC Pipe 110mm</td>
                                    <td class="py-4 text-sm font-semibold text-gray-900">TZS 106,500</td>
                                    <td class="py-4">
                                        <span class="px-2.5 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Delivered</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 mt-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <button class="flex flex-col items-center gap-3 p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                           <a href="{{url('createProduct')}}" class="text-sm font-semibold text-gray-900">Add Product</a>
                        </button>

                        <button class="flex flex-col items-center gap-3 p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">View Orders</span>
                        </button>

                        <button class="flex flex-col items-center gap-3 p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBopx="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <a href="{{url('user')}}" class="text-sm font-semibold text-gray-900">Customers</a>
                        </button>                      

                        <button class="flex flex-col items-center gap-3 p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                            <div class="w-12 h-12 bg-orange-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">Analytics</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Low Stock Alert -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Low Stock Alert</h3>
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg">
                            <div class="w-10 h-10 bg-gradient-to-br from-gray-200 to-gray-300 rounded flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">Roofing Sheet 3m</p>
                                <p class="text-xs text-gray-600">Only 8 left</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-orange-50 rounded-lg">
                            <div class="w-10 h-10 bg-gradient-to-br from-gray-200 to-gray-300 rounded flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">Circuit Breaker 100A</p>
                                <p class="text-xs text-gray-600">Only 12 left</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-orange-50 rounded-lg">
                            <div class="w-10 h-10 bg-gradient-to-br from-gray-200 to-gray-300 rounded flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">PVC Pipe 110mm</p>
                                <p class="text-xs text-gray-600">Only 15 left</p>
                            </div>
                        </div>
                    </div>
                    <button class="w-full mt-4 px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                        Restock Items
                    </button>
                </div>

                <!-- Top Products -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Top Products</h3>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-lg font-bold text-blue-600">1</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">Mbeya Cement 50kg</p>
                                <p class="text-xs text-gray-600">452 sold</p>
                            </div>
                            <span class="text-sm font-bold text-green-600">↑ 23%</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-lg font-bold text-purple-600">2</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">Y12 TMT Steel</p>
                                <p class="text-xs text-gray-600">328 sold</p>
                            </div>
                            <span class="text-sm font-bold text-green-600">↑ 18%</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-lg font-bold text-green-600">3</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">Crown Paint 20L</p>
                                <p class="text-xs text-gray-600">287 sold</p>
                            </div>
                            <span class="text-sm font-bold text-green-600">↑ 15%</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Activity</h3>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="w-2 h-2 bg-blue-600 rounded-full mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="text-sm text-gray-900 font-medium">New order received</p>
                                <p class="text-xs text-gray-500">2 minutes ago</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-2 h-2 bg-green-600 rounded-full mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="text-sm text-gray-900 font-medium">Product restocked</p>
                                <p class="text-xs text-gray-500">15 minutes ago</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-2 h-2 bg-purple-600 rounded-full mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="text-sm text-gray-900 font-medium">New customer registered</p>
                                <p class="text-xs text-gray-500">1 hour ago</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-2 h-2 bg-orange-600 rounded-full mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="text-sm text-gray-900 font-medium">Payment received</p>
                                <p class="text-xs text-gray-500">3 hours ago</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-2 h-2 bg-red-600 rounded-full mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="text-sm text-gray-900 font-medium">Low stock alert</p>
                                <p class="text-xs text-gray-500">5 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 mt-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Sales Overview</h2>
                <div class="flex items-center gap-2">
                    <button class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Week
                    </button>
                    <button class="px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        Month
                    </button>
                    <button class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Year
                    </button>
                </div>
            </div>
            
            <!-- Simple Bar Chart Visualization -->
            <div class="flex items-end justify-between h-64 gap-4">
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg hover:from-blue-700 hover:to-blue-500 transition-all cursor-pointer" style="height: 60%;"></div>
                    <span class="text-xs font-medium text-gray-600">Mon</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg hover:from-blue-700 hover:to-blue-500 transition-all cursor-pointer" style="height: 75%;"></div>
                    <span class="text-xs font-medium text-gray-600">Tue</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg hover:from-blue-700 hover:to-blue-500 transition-all cursor-pointer" style="height: 85%;"></div>
                    <span class="text-xs font-medium text-gray-600">Wed</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg hover:from-blue-700 hover:to-blue-500 transition-all cursor-pointer" style="height: 70%;"></div>
                    <span class="text-xs font-medium text-gray-600">Thu</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg hover:from-blue-700 hover:to-blue-500 transition-all cursor-pointer" style="height: 95%;"></div>
                    <span class="text-xs font-medium text-gray-600">Fri</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg hover:from-blue-700 hover:to-blue-500 transition-all cursor-pointer" style="height: 55%;"></div>
                    <span class="text-xs font-medium text-gray-600">Sat</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg hover:from-blue-700 hover:to-blue-500 transition-all cursor-pointer" style="height: 45%;"></div>
                    <span class="text-xs font-medium text-gray-600">Sun</span>
                </div>
            </div>

            <div class="flex items-center justify-center gap-8 mt-6 pt-6 border-t border-gray-200">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-blue-600 rounded"></div>
                    <span class="text-sm text-gray-600">Revenue: <span class="font-semibold text-gray-900">TZS 2.4M</span></span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-600 rounded"></div>
                    <span class="text-sm text-gray-600">Orders: <span class="font-semibold text-gray-900">342</span></span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-purple-600 rounded"></div>
                    <span class="text-sm text-gray-600">Customers: <span class="font-semibold text-gray-900">156</span></span>
                </div>
            </div>
        </div>

        <!-- Category Performance -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Cement & Concrete</h3>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">TZS 2.1M</p>
                        <p class="text-sm text-gray-600">Monthly sales</p>
                    </div>
                    <span class="text-sm font-semibold text-green-600">+12%</span>
                </div>
                <div class="mt-4 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: 85%"></div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Steel & Rebar</h3>
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">TZS 1.8M</p>
                        <p class="text-sm text-gray-600">Monthly sales</p>
                    </div>
                    <span class="text-sm font-semibold text-green-600">+8%</span>
                </div>
                <div class="mt-4 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gray-600 h-2 rounded-full" style="width: 72%"></div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Roofing</h3>
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">TZS 1.5M</p>
                        <p class="text-sm text-gray-600">Monthly sales</p>
                    </div>
                    <span class="text-sm font-semibold text-green-600">+15%</span>
                </div>
                <div class="mt-4 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-amber-600 h-2 rounded-full" style="width: 68%"></div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-600">© 2024 Weru Hardware. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Help Center</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Documentation</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Add interactivity for demo purposes
        console.log('Weru Hardware Admin Dashboard loaded');
        
        // Simulate real-time updates (optional)
        setInterval(() => {
            // You can add WebSocket connections here for real-time updates
        }, 5000);
    </script>

</body>
</html>