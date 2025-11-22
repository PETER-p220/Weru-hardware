<?php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Weru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --secondary: #fbbf24;
        }
        body { font-family: 'Inter', sans-serif; }
        .status-badge { font-size: 0.75rem; font-weight: 600; padding: 0.35rem 0.75rem; border-radius: 9999px; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 25px -5px rgba(249, 115, 22, 0.15); }
        .table-row:hover { background-color: #fff7ed; }
        .filter-active { background-color: var(--primary); color: white; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-5">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-600 to-orange-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-gray-900">Weru<span class="text-orange-600">Hardware</span></h1>
                    <nav class="hidden md:flex text-sm font-medium text-gray-600 gap-8 mt-1">
                        <a href="{{ route('dashboard') ?? '#' }}" class="hover:text-orange-600 transition">Dashboard</a>
                        <a href="{{ route('order') ?? '#' }}" class="text-orange-600 font-bold">My Orders</a>
                        <a href="{{ route('products') ?? '#' }}" class="hover:text-orange-600 transition">Shop</a>
                        <a href="#" class="hover:text-orange-600 transition">Support</a>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <button class="relative p-2 text-gray-600 hover:bg-orange-50 rounded-full transition">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                </button>

                @if($user)
                    <div class="flex items-center gap-4">
                        <div class="text-right hidden sm:block">
                            <p class="font-bold text-gray-900">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">Customer Account</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-600 to-orange-700 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-orange-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-orange-700 transition shadow-lg">
                        Login
                    </a>
                @endif
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">

        @if(!$user)
            <!-- Guest View -->
            <div class="text-center py-24 bg-gradient-to-br from-orange-50 to-amber-50 rounded-3xl">
                <i class="fa-solid fa-lock text-6xl text-orange-600 mb-6"></i>
                <h2 class="text-4xl font-black text-gray-900 mb-4">Login Required</h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    You need to be signed in to view and track your orders.
                </p>
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('login') }}" class="bg-orange-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-orange-700 transition shadow-lg">
                        Login Now
                    </a>
                    <a href="{{ route('register') }}" class="bg-white border-2 border-orange-600 text-orange-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-orange-50 transition">
                        Create Account
                    </a>
                </div>
            </div>
        @else
            @php
                $orders = $orders ?? \App\Models\Order::where('user_id', $user->id)
                                    ->orderByDesc('created_at')
                                    ->paginate(10);

                $totalOrders     = $orders->total();
                $pendingOrders   = \App\Models\Order::where('user_id', $user->id)->where('status', 'pending')->count();
                $processing      = \App\Models\Order::where('user_id', $user->id)->where('status', 'processing')->count();
                $shipped         = \App\Models\Order::where('user_id', $user->id)->whereIn('status', ['shipped', 'in_transit'])->count();
                $delivered       = \App\Models\Order::where('user_id', $user->id)->where('status', 'delivered')->count();
            @endphp

            <!-- Page Header -->
            <div class="mb-10 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
                <div>
                    <h2 class="text-4xl font-black text-gray-900">My Orders</h2>
                    <p class="text-lg text-gray-600 mt-2">Track, manage, and review all your purchases</p>
                </div>
                <a href="{{ route('products') ?? '#' }}" class="bg-gradient-to-r from-orange-600 to-orange-700 text-white px-8 py-4 rounded-xl font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition flex items-center gap-3 whitespace-nowrap">
                    <i class="fa-solid fa-plus"></i> Place New Order
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
                <div class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 p-6 text-center">
                    <i class="fa-solid fa-receipt text-3xl text-orange-600 mb-3"></i>
                    <p class="text-4xl font-black text-gray-...
                    <p class="text-sm text-gray-600">All Orders</p>
                </div>
                <div class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 p-6 text-center">
                    <i class="fa-solid fa-clock text-3xl text-amber-600 mb-3"></i>
                    <p class="text-4xl font-black text-gray-900">{{ $pendingOrders + $processing }}</p>
                    <p class="text-sm text-gray-600">Processing</p>
                </div>
                <div class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 p-6 text-center">
                    <i class="fa-solid fa-truck text-3xl text-blue-600 mb-3"></i>
                    <p class="text-4xl font-black text-gray-900">{{ $shipped }}</p>
                    <p class="text-sm text-gray-600">In Transit</p>
                </div>
                <div class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 p-6 text-center">
                    <i class="fa-solid fa-check-circle text-3xl text-green-600 mb-3"></i>
                    <p class="text-4xl font-black text-gray-900">{{ $delivered }}</p>
                    <p class="text-sm text-gray-600">Delivered</p>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="flex flex-wrap gap-3">
                        @php $currentFilter = request('status', 'all'); @endphp
                        <a href="{{ route('order') }}?status=all" class="{{ $currentFilter == 'all' ? 'filter-active' : 'bg-gray-100 hover:bg-gray-200' }} px-5 py-2.5 rounded-xl font-semibold transition">All Orders <span class="ml-1 text-xs">({{ $totalOrders }})</span></a>
                        <a href="{{ route('order') }}?status=pending" class="{{ $currentFilter == 'pending' ? 'filter-active' : 'bg-gray-100 hover:bg-gray-200' }} px-5 py-2.5 rounded-xl font-semibold transition">Pending</a>
                        <a href="{{ route('order') }}?status=processing" class="{{ $currentFilter == 'processing' ? 'filter-active' : 'bg-gray-100 hover:bg-gray-200' }} px-5 py-2.5 rounded-xl font-semibold transition">Processing</a>
                        <a href="{{ route('order') }}?status=shipped" class="{{ in_array($currentFilter, ['shipped','in_transit']) ? 'filter-active' : 'bg-gray-100 hover:bg-gray-200' }} px-5 py-2.5 rounded-xl font-semibold transition">Shipped</a>
                        <a href="{{ route('order') }}?status=delivered" class="{{ $currentFilter == 'delivered' ? 'filter-active' : 'bg-gray-100 hover:bg-gray-200' }} px-5 py-2.5 rounded-xl font-semibold transition">Delivered</a>
                    </div>
                    <div class="flex gap-3">
                        <input type="text" placeholder="Search orders..." class="px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <button class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                @forelse($orders as $order)
                    <div class="table-row p-6 border-b border-gray-100 last:border-0">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                            <div class="lg:col-span-3">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                        <i class="fa-solid fa-box text-orange-600"></i>
                                    </div>
                                    <div>
                                        <a href="#" class="font-bold text-lg text-gray-900 hover:text-orange-600 transition">
                                            #{{ $order->order_number ?? $order->id }}
                                        </a>
                                        <p class="text-sm text-gray-500">
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="lg:col-span-3">
                                <span class="status-badge
                                    @if($order->status == 'pending') bg-orange-100 text-orange-700 border border-orange-300
                                    @elseif(in_array($order->status, ['processing'])) bg-amber-100 text-amber-700 border border-amber-300
                                    @elseif(in_array($order->status, ['shipped','in_transit'])) bg-blue-100 text-blue-700 border border-blue-300
                                    @elseif($order->status == 'delivered') bg-green-100 text-green-700 border border-green-300
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </div>

                            <div class="lg:col-span-2 text-right lg:text-left">
                                <p class="font-bold text-xl text-gray-900">TZS {{ number_format($order->total_amount) }}</p>
                                <p class="text-sm text-gray-500">{{ $order->items_count ?? 'N/A' }} items</p>
                            </div>

                            <div class="lg:col-span-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="#" class="text-orange-600 font-semibold hover:underline">
                                        View Details →
                                    </a>
                                    @if($order->status === 'pending')
                                        <button class="text-green-600 font-semibold hover:underline">Pay Now</button>
                                        <button class="text-red-600 font-semibold hover:underline" onclick="event.preventDefault(); if(confirm('Cancel order #{{ $order->id }}?')) this.closest('form').submit();">
                                            Cancel
                                        </button>
                                        <form method="POST" action="#" class="hidden">
                                            @csrf @method('DELETE')
                                        </form>
                                    @endif
                                    <a href="#" class="text-gray-600 hover:text-gray-900">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <i class="fa-solid fa-inbox text-7xl text-gray-300 mb-6"></i>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No Orders Yet</h3>
                        <p class="text-gray-600 mb-8">Start building your project today!</p>
                        <a href="{{ route('products') ?? '#' }}" class="bg-gradient-to-r from-orange-600 to-orange-700 text-white px-10 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition transform hover:scale-105">
                            Browse Products
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $orders->links('pagination::tailwind') }}
                </div>
            @endif
        @endif
    </main>

    <!-- Footer -->
    <footer class="mt-20 bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-lg">&copy; {{ date('Y') }} Weru Hardware. Building Tanzania Strong.</p>
            <p class="mt-4 text-sm">
                <a href="#" class="hover:text-white transition">Privacy</a> • 
                <a href="#" class="hover:text-white transition">Terms</a> • 
                <a href="#" class="hover:text-white transition">Contact Us</a>
            </p>
        </div>
    </footer>
</body>
</html>