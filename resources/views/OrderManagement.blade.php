<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Weru Hardware Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff6b35',
                        'primary-dark': '#e85a2a',
                        'primary-light': '#ff8c5f',
                    }
                }
            }
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-white to-orange-50 min-h-screen">

    <!-- Success Message -->
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-lg shadow-lg animate-slide-in flex items-center space-x-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 h-full w-64 bg-white shadow-xl z-40 border-r border-orange-100">
        <div class="p-5 border-b border-orange-100">
            <h1 class="text-xl font-bold text-primary">Weru Hardware</h1>
            <p class="text-[10px] text-gray-500 mt-0.5">Admin Dashboard</p>
        </div>
        
        <nav class="p-4">
            <a href="/adminDashboard" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-gradient-to-r from-primary to-primary-dark text-white mb-1 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-xs font-medium">Dashboard</span>
            </a>
            <a href="/createProduct" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition-all mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="text-xs font-medium">Products</span>
            </a>
            <a href="/OrderManagement" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition-all mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="text-xs font-medium">Orders</span>
            </a>
            <a href="/user" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition-all mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="text-xs font-medium">Customers</span>
            </a>
            <a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition-all mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span class="text-xs font-medium">Analytics</span>
            </a>
            <a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="text-xs font-medium">Settings</span>
            </a>
        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-orange-100">
            <div class="flex items-center space-x-3 px-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center text-white text-xs font-bold">
                    A
                </div>
                <div class="flex-1">
                    <p class="text-xs font-semibold text-gray-800">Admin User</p>
                    <p class="text-[10px] text-gray-500">Administrator</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        <header class="bg-white shadow-sm border-b border-orange-100 sticky top-0 z-30">
            <div class="flex items-center justify-between px-6 py-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Dashboard Overview</h2>
                    <p class="text-[10px] text-gray-500">Welcome back! Here's what's happening today.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button class="relative p-2 text-gray-400 hover:text-primary transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-primary rounded-full"></span>
                    </button>
                    <div class="h-6 w-px bg-gray-200"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-gray-600 hover:text-primary transition-colors font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="p-6">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-2 bg-gradient-to-br from-green-400 to-green-500 rounded-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-[10px] text-green-600 font-semibold bg-green-50 px-2 py-0.5 rounded-full">+12.5%</span>
                    </div>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mb-1">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">TZS {{ number_format($price ?? 0, 0) }}</p>
                    <p class="text-[9px] text-gray-400 mt-1">vs. last month</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-2 bg-gradient-to-br from-primary to-primary-dark rounded-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <span class="text-[10px] text-primary font-semibold bg-orange-50 px-2 py-0.5 rounded-full">+8.2%</span>
                    </div>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mb-1">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $orders->count() ?? 0 }}</p>
                    <p class="text-[9px] text-gray-400 mt-1">vs. last month</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-2 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <span class="text-[10px] text-blue-600 font-semibold bg-blue-50 px-2 py-0.5 rounded-full">Active</span>
                    </div>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mb-1">Total Products</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $products->count() ?? 0 }}</p>
                    <p class="text-[9px] text-gray-400 mt-1">In catalog</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-2 bg-gradient-to-br from-purple-400 to-purple-500 rounded-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <span class="text-[10px] text-purple-600 font-semibold bg-purple-50 px-2 py-0.5 rounded-full">+15.3%</span>
                    </div>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mb-1">Total Customers</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $users->count() ?? 0 }}</p>
                    <p class="text-[9px] text-gray-400 mt-1">vs. last month</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Orders -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white rounded-xl shadow-sm border border-orange-100">
                        <div class="flex items-center justify-between p-5 border-b border-orange-100">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Recent Orders</h3>
                                <p class="text-[10px] text-gray-500 mt-0.5">Latest transactions</p>
                            </div>
                            <a href="/OrderManagement" class="text-[10px] text-primary hover:text-primary-dark font-semibold flex items-center space-x-1">
                                <span>View All</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-orange-50">
                                    <tr>
                                        <th class="px-5 py-3 text-left text-[10px] font-bold text-gray-600 uppercase tracking-wider">Order ID</th>
                                        <th class="px-5 py-3 text-left text-[10px] font-bold text-gray-600 uppercase tracking-wider">Customer</th>
                                        <th class="px-5 py-3 text-left text-[10px] font-bold text-gray-600 uppercase tracking-wider">Amount</th>
                                        <th class="px-5 py-3 text-left text-[10px] font-bold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th class="px-5 py-3 text-left text-[10px] font-bold text-gray-600 uppercase tracking-wider">Update Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($orders->take(10) as $order)
                                    <tr class="hover:bg-orange-50 transition-colors">
                                        <td class="px-5 py-3 text-xs font-semibold text-gray-900">{{ $order->order_number }}</td>
                                        <td class="px-5 py-3 text-xs text-gray-600">{{ $order->user->name ?? 'N/A' }}</td>
                                        <td class="px-5 py-3 text-xs font-bold text-gray-900">TZS {{ number_format($order->total_amount, 0) }}</td>
                                        <td class="px-5 py-3">
                                            <span class="px-2 py-1 text-[10px] rounded-full font-semibold
                                                @if($order->status == 'delivered') bg-green-100 text-green-700
                                                @elseif($order->status == 'processing') bg-blue-100 text-blue-700
                                                @elseif($order->status == 'shipped') bg-purple-100 text-purple-700
                                                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-700
                                                @elseif($order->status == 'cancelled') bg-red-100 text-red-700
                                                @else bg-gray-100 text-gray-700
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()"
                                                    class="text-[10px] px-3 py-1.5 rounded-full font-medium border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary cursor-pointer
                                                        @if($order->status == 'delivered') bg-green-50 text-green-700
                                                        @elseif($order->status == 'processing') bg-blue-50 text-blue-700
                                                        @elseif($order->status == 'shipped') bg-purple-50 text-purple-700
                                                        @elseif($order->status == 'pending') bg-yellow-50 text-yellow-700
                                                        @elseif($order->status == 'cancelled') bg-red-50 text-red-700
                                                        @else bg-gray-50 text-gray-700
                                                        @endif">
                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <a href="/createProduct" class="group bg-gradient-to-br from-primary to-primary-dark text-white rounded-lg p-4 text-center hover:shadow-lg transition-all transform hover:-translate-y-1">
                            <svg class="w-6 h-6 mx-auto mb-2 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap " stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <p class="text-xs font-bold">Add Product</p>
                        </a>
                        <a href="/OrderManagement" class="group bg-white border-2 border-orange-100 rounded-lg p-4 text-center hover:border-primary hover:shadow-md transition-all transform hover:-translate-y-1">
                            <svg class="w-6 h-6 mx-auto mb-2 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <p class="text-xs font-bold text-gray-700 group-hover:text-primary transition-colors">View Orders</p>
                        </a>
                        <a href="/user" class="group bg-white border-2 border-orange-100 rounded-lg p-4 text-center hover:border-primary hover:shadow-md transition-all transform hover:-translate-y-1">
                            <svg class="w-6 h-6 mx-auto mb-2 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <p class="text-xs font-bold text-gray-700 group-hover:text-primary transition-colors">Customers</p>
                        </a>
                        <button class="group bg-white border-2 border-orange-100 rounded-lg p-4 text-center hover:border-primary hover:shadow-md transition-all transform hover:-translate-y-1">
                            <svg class="w-6 h-6 mx-auto mb-2 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <p class="text-xs font-bold text-gray-700 group-hover:text-primary transition-colors">Analytics</p>
                        </button>
                    </div>
                </div>

                <!-- Rest of your sidebar widgets (Low Stock, Top Products, Recent Activity) -->
                <!-- (Unchanged - keeping your original beautiful design) -->
                <div class="space-y-4">
                    <!-- Low Stock Alert -->
                    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-bold text-gray-900">Low Stock Alert</h3>
                            <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-red-50 to-orange-50 rounded-lg border border-red-100">
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-gray-900">Roofing Sheet 3m</p>
                                    <p class="text-[10px] text-red-600 font-medium mt-0.5">Only 8 units left</p>
                                </div>
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-red-600">8</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg border border-yellow-100">
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-gray-900">Circuit Breaker 100A</p>
                                    <p class="text-[10px] text-yellow-600 font-medium mt-0.5">Only 12 units left</p>
                                </div>
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-yellow-600">12</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg border border-orange-200">
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-gray-900">PVC Pipe 110mm</p>
                                    <p class="text-[10px] text-orange-600 font-medium mt-0.5">Only 15 units left</p>
                                </div>
                                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-orange-600">15</span>
                                </div>
                            </div>
                        </div>
                        <button class="w-full mt-3 bg-gradient-to-r from-primary to-primary-dark text-white py-2.5 rounded-lg hover:shadow-md transition-all text-xs font-bold">
                            Restock Items
                        </button>
                    </div>

                    <!-- Top Products & Recent Activity (unchanged) -->
                    <!-- ... your existing code ... -->
                </div>
            </div>
        </div>
    </main>

    <footer class="ml-64 bg-white border-t border-orange-100 py-4">
        <div class="px-6 flex items-center justify-between">
            <p class="text-[10px] text-gray-500">© 2025 Weru Hardware. All rights reserved.</p>
            <div class="flex space-x-4">
                <a href="#" class="text-[10px] text-gray-500 hover:text-primary transition-colors font-medium">Help Center</a>
                <a href="#" class="text-[10px] text-gray-500 hover:text-primary transition-colors font-medium">Documentation</a>
                <a href="#" class="text-[10px] text-gray-500 hover:text-primary transition-colors font-medium">Privacy Policy</a>
            </div>
        </div>
    </footer>
</body>
</html>