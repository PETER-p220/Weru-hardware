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
    <title>Weru Hardware Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff6b35',
                        'primary-dark': '#e85a2a',
                        'primary-light': '#ff8c5f',
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        .text-xs { font-size: 0.6875rem; }
        .text-2xs { font-size: 0.625rem; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 10px 25px -5px rgba(255, 107, 53, 0.25); }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-white to-orange-50 min-h-screen font-sans">

    <!-- Success / Error Messages -->
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-lg shadow-lg text-xs font-medium flex items-center gap-2 animate-slide-in">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-orange-100 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-hard-hat text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900">Weru <span class="text-primary">Hardware</span></h1>
                    <p class="text-2xs text-gray-500">Admin Dashboard • {{ now()->format('d M Y') }}</p>
                </div>
            </div>

            <nav class="hidden md:flex items-center space-x-6">
                <a href="{{ url('adminDashboard') }}" class="text-xs font-bold text-primary border-b-2 border-primary pb-1">Dashboard</a>
                <a href="{{ url('createProduct') }}" class="text-xs font-medium text-gray-600 hover:text-primary">Products</a>
                <a href="{{ url('OrderManagement') }}" class="text-xs font-medium text-gray-600 hover:text-primary">Orders</a>
                <a href="{{ url('user') }}" class="text-xs font-medium text-gray-600 hover:text-primary">Customers</a>
                <a href="{{ url('ads') }}" class="text-xs font-medium text-gray-600 hover:text-primary">Ads</a>
            </nav>

            <div class="flex items-center space-x-3">
                <span class="text-xs font-medium text-gray-700">Admin</span>
                <div class="w-8 h-8 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center text-white text-xs font-bold shadow">A</div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-xl border border-orange-100 p-5 hover-lift transition-all">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 bg-gradient-to-br from-green-400 to-green-500 rounded-lg">
                        <i class="fa-solid fa-sack-dollar text-white text-sm"></i>
                    </div>
                    <span class="text-2xs text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded-full">+12.5%</span>
                </div>
                <p class="text-2xs text-gray-500 uppercase font-bold tracking-wider">Total Revenue</p>
                <p class="text-xl font-bold text-gray-900 mt-1">TZS {{ number_format($totalRevenue, 0) }}</p>
                <p class="text-2xs text-gray-400 mt-1">Completed orders</p>
            </div>

            <div class="bg-white rounded-xl border border-orange-100 p-5 hover-lift transition-all">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 bg-gradient-to-br from-primary to-primary-dark rounded-lg">
                        <i class="fa-solid fa-shopping-cart text-white text-sm"></i>
                    </div>
                    <span class="text-2xs text-primary font-bold bg-orange-50 px-2 py-0.5 rounded-full">+8.2%</span>
                </div>
                <p class="text-2xs text-gray-500 uppercase font-bold tracking-wider">Total Orders</p>
                <p class="text-xl font-bold text-gray-900 mt-1">{{ $orders->count() }}</p>
                <p class="text-2xs text-gray-400 mt-1">This month</p>
            </div>

            <div class="bg-white rounded-xl border border-orange-100 p-5 hover-lift transition-all">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg">
                        <i class="fa-solid fa-boxes-stacked text-white text-sm"></i>
                    </div>
                </div>
                <p class="text-2xs text-gray-500 uppercase font-bold tracking-wider">Products</p>
                <p class="text-xl font-bold text-gray-900 mt-1">{{ $products->count() }}</p>
                <p class="text-2xs text-gray-400 mt-1">In catalog</p>
            </div>

            <div class="bg-white rounded-xl border border-orange-100 p-5 hover-lift transition-all">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 bg-gradient-to-br from-purple-400 to-purple-500 rounded-lg">
                        <i class="fa-solid fa-users text-white text-sm"></i>
                    </div>
                    <span class="text-2xs text-purple-600 font-bold bg-purple-50 px-2 py-0.5 rounded-full">+15.3%</span>
                </div>
                <p class="text-2xs text-gray-500 uppercase font-bold tracking-wider">Customers</p>
                <p class="text-xl font-bold text-gray-900 mt-1">{{ $users->count() }}</p>
                <p class="text-2xs text-gray-400 mt-1">Registered</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Recent Orders with Delete Button -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl border border-orange-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-orange-100 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-900">Recent Orders</h3>
                        <a href="{{ url('OrderManagement') }}" class="text-2xs text-primary font-bold hover:text-primary-dark flex items-center gap-1">
                            View All <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-orange-50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Order ID</th>
                                    <th class="px-5 py-3 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Customer</th>
                                    <th class="px-5 py-3 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Amount</th>
                                    <th class="px-5 py-3 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-5 py-3 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($orders as $order)
                                <tr class="hover:bg-orange-50 transition-colors">
                                    <td class="px-5 py-3 text-xs font-bold text-primary">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-5 py-3 text-xs text-gray-700">{{ $order->user?->name ?? 'Guest' }}</td>
                                    <td class="px-5 py-3 text-xs font-bold text-gray-900">TZS {{ number_format($order->total_amount, 0) }}</td>
                                    <td class="px-5 py-3">
                                        <span class="px-2 py-1 text-2xs font-bold rounded-full
                                            {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                            {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('⚠️ Are you sure you want to DELETE order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}? This cannot be undone.')"
                                                    class="text-2xs text-red-600 hover:text-red-800 font-bold hover:underline">
                                                 Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-8 text-gray-500 text-xs">No orders found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar: Ads + Low Stock -->
            <div class="space-y-5">

                <!-- Manage Advertisements -->
                <div class="bg-white rounded-xl border border-orange-100 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-gray-900">Advertisements</h3>
                        <a href="{{ url('ads') }}" class="text-2xs bg-gradient-to-r from-primary to-primary-dark text-white px-3 py-1.5 rounded-lg font-bold shadow hover:shadow-md">
                            + New Ad
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($advertisements as $ad)
                        <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg border {{ $ad->is_active ? 'border-green-300' : 'border-orange-200' }}">
                            <div class="flex items-center gap-3">
                                @if($ad->media_type === 'image')
                                    <img src="{{ Storage::url($ad->media_path) }}" class="w-10 h-10 object-cover rounded-lg">
                                @else
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fa-solid fa-video text-red-600 text-sm"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-xs font-bold text-gray-900">{{ Str::limit($ad->title, 18) }}</p>
                                    <p class="text-2xs text-gray-500">Sort: {{ $ad->sort_order }}</p>
                                </div>
                            </div>
                            <a href="{{ url('ads/'.$ad->id.'/edit') }}" class="text-primary hover:text-primary-dark">
                                <i class="fa-solid fa-edit text-xs"></i>
                            </a>
                        </div>
                        @empty
                        <p class="text-center text-2xs text-gray-500 py-4">No ads yet</p>
                        @endforelse
                    </div>
                </div>

                <!-- Low Stock Alert -->
                @if($lowStockProducts->count() > 0)
                <div class="bg-red-50 border-2 border-red-300 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-bold text-red-800">Low Stock Alert</h3>
                        <i class="fa-solid fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="space-y-2">
                        @foreach($lowStockProducts->take(4) as $p)
                        <div class="text-xs">
                            <span class="font-bold">{{ $p->name }}</span>
                            <span class="text-red-700"> — {{ $p->stock }} left</span>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ url('createProduct') }}" class="block text-center mt-4 text-2xs font-bold text-red-700 hover:underline">
                        Restock Items →
                    </a>
                </div>
                @endif

            </div>
        </div>
    </main>

    <footer class="mt-16 py-6 border-t border-orange-100 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-2xs text-gray-500">© {{ date('Y') }} Weru Hardware Tanzania • All rights reserved</p>
        </div>
    </footer>
</body>
</html>