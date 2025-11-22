<?php
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Advertisement;
use Illuminate\Support\Facades\DB;

// Fetch real data
$users = User::all();
$orders = Order::with('user')->latest()->take(10)->get();
$products = Product::all();
$advertisements = Advertisement::orderBy('sort_order')->get();
$totalRevenue = Order::where('status', 'completed')->sum('total_amount') ?? 0;
$lowStockProducts = Product::where('stock', '<=', 20)->get();

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } }
    </script>
    <style>
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-6px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
        .table-row:hover { background-color: #f9fafb; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                    </div>
                    <span class="text-xl font-extrabold text-gray-900">Weru <span class="text-primary">Hardware</span> Admin</span>
                </div>

                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ url('adminDashboard') }}" class="text-orange-600 font-bold text-sm">Dashboard</a>
                    <a href="{{ url('admin/products') }}" class="text-gray-600 hover:text-orange-600 font-medium text-sm">Products</a>
                    <a href="{{ url('admin/orders') }}" class="text-gray-600 hover:text-orange-600 font-medium text-sm">Orders</a>
                    <a href="{{ url('admin/customers') }}" class="text-gray-600 hover:text-orange-600 font-medium text-sm">Customers</a>
                    <a href="{{ url('admin/advertisements') }}" class="text-orange-600 font-bold text-sm border-b-2 border-orange-600">Advertisements</a>
                </nav>

                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-700">Welcome, Admin</span>
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold">AD</div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Page Title -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Welcome Back, Boss!</h1>
            <p class="text-gray-600 mt-2">Here's what's happening with Weru Hardware today — {{ now()->format('l, d F Y') }}</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="stat-card bg-gradient-to-br from-orange-500 to-red-600 text-white rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Total Revenue</p>
                        <p class="text-3xl font-black mt-2">TZS {{ number_format($totalRevenue) }}</p>
                    </div>
                    <i class="fa-solid fa-sack-dollar text-4xl opacity-80"></i>
                </div>
                <p class="text-xs mt-3 opacity-90">All completed orders</p>
            </div>

            <div class="stat-card bg-white border border-gray-200 rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Orders</p>
                        <p class="text-3xl font-black text-gray-900 mt-2">{{ $orders->count() }}</p>
                    </div>
                    <i class="fa-solid fa-shopping-cart text-orange-600 text-4xl"></i>
                </div>
                <p class="text-xs text-green-600 mt-3">+12% from last month</p>
            </div>

            <div class="stat-card bg-white border border-gray-200 rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Products</p>
                        <p class="text-3xl font-black text-gray-900 mt-2">{{ $products->count() }}</p>
                    </div>
                    <i class="fa-solid fa-boxes-stacked text-blue-600 text-4xl"></i>
                </div>
                <p class="text-xs text-gray-500 mt-3">In catalog</p>
            </div>

            <div class="stat-card bg-white border border-gray-200 rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Customers</p>
                        <p class="text-3xl font-black text-gray-900 mt-2">{{ $users->count() }}</p>
                    </div>
                    <i class="fa-solid fa-users text-green-600 text-4xl"></i>
                </div>
                <p class="text-xs text-green-600 mt-3">+18% growth</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left: Recent Orders + Quick Actions -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Recent Orders -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900">Recent Orders</h2>
                        <a href="{{ url('admin/orders') }}" class="text-sm text-orange-600 font-semibold hover:underline">View All →</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Order ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($orders->take(6) as $order)
                                <tr class="table-row">
                                    <td class="px-6 py-4 text-sm font-medium text-orange-600">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $order->user?->name ?? 'Guest' }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold">TZS {{ number_format($order->total_amount) }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-bold rounded-full 
                                            {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-8 text-gray-500">No orders yet</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ url('createProduct') }}" class="text-center p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition">
                            <i class="fa-solid fa-plus text-2xl text-orange-600 mb-2"></i>
                            <p class="text-sm font-bold">Add Product</p>
                        </a>
                        <a href="{{ url('ads') }}" class="text-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition">
                            <i class="fa-solid fa-bullhorn text-2xl text-purple-600 mb-2"></i>
                            <p class="text-sm font-bold">New Ad</p>
                        </a>
                        <a href="{{ url('OrderManagement') }}" class="text-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition">
                            <i class="fa-solid fa-truck text-2xl text-blue-600 mb-2"></i>
                            <p class="text-sm font-bold">Manage Orders</p>
                        </a>
                        <a href="{{ url('user') }}" class="text-center p-4 bg-green-50 rounded-xl hover:bg-green-100 transition">
                            <i class="fa-solid fa-users text-2xl text-green-600 mb-2"></i>
                            <p class="text-sm font-bold">Customers</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">

                <!-- Advertisements Management -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Manage Advertisements</h3>
                        <a href="{{ url('admin/advertisements/create') }}" class="text-xs bg-orange-600 text-white px-3 py-1.5 rounded-lg font-bold hover:bg-orange-700">
                            <i class="fa-solid fa-plus mr-1"></i> New Ad
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($advertisements as $ad)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border {{ $ad->is_active ? 'border-green-300' : 'border-gray-300' }}">
                            <div class="flex items-center gap-3">
                                @if($ad->media_type === 'image')
                                    <img src="{{ Storage::url($ad->media_path) }}" class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fa-solid fa-video text-red-600"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-sm">{{ Str::limit($ad->title, 20) }}</p>
                                    <p class="text-xs text-gray-500">Sort: {{ $ad->sort_order }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs {{ $ad->is_active ? 'text-green-600' : 'text-gray-500' }}">
                                    {{ $ad->is_active ? 'Active' : 'Off' }}
                                </span>
                                <a href="{{ url('admin/advertisements/'.$ad->id.'/edit') }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 py-6">No ads yet. Create your first promotion!</p>
                        @endforelse
                    </div>
                </div>

                <!-- Low Stock Alert -->
                @if($lowStockProducts->count() > 0)
                <div class="bg-red-50 border-2 border-red-300 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-red-800">Low Stock Alert</h3>
                        <i class="fa-solid fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="space-y-2">
                        @foreach($lowStockProducts->take(4) as $p)
                        <div class="text-sm">
                            <span class="font-semibold">{{ $p->name }}</span>
                            <span class="text-red-700"> — only {{ $p->stock }} left</span>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ url('admin/products') }}" class="block text-center mt-4 text-sm font-bold text-red-700 hover:underline">
                        Restock Now →
                    </a>
                </div>
                @endif

                <!-- Top Products -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Top Selling Products</h3>
                    <div class="space-y-3">
                       
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16 py-8">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-sm text-gray-600">© {{ date('Y') }} Weru Hardware Tanzania • All rights reserved</p>
        </div>
    </footer>
</body>
</html>