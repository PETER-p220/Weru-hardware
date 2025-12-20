<?php
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
$orderId = Auth::id();
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Oweru Hardware • Order Management</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] }}},
            plugins: []
        }
    </script>

    <style>
        * { box-sizing: border-box; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #64748b; border-radius: 4px; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12 24px rgba(15,23,42,0.12); }

        @media (max-width: 768px) {
            .orders-table thead { display: none; }
            .orders-table tbody { display: block; }
            .orders-table tr { display: block; margin-bottom: 1rem; background: white; border-radius: 0.875rem; overflow: hidden; box-shadow: 0 2px 8px rgba(15,23,42,0.08); border: 1px solid #e2e8f0; }
            .orders-table td { display: flex; justify-content: space-between; align-items: center; padding: 0.875rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: 0.875rem; }
            .orders-table td:last-child { border: none; }
            .orders-table td::before { content: attr(data-label); font-weight: 600; color: #334155; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 0.05em; min-width: 70px; }
        }
        .nav-active::before { content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 4px; height: 70%; background: #334155; border-radius: 0 4px 4px 0; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen overflow-x-hidden">

    <!-- Same Sidebar & Header as before (unchanged) -->
    <button id="menu-toggle" class="fixed top-4 left-4 z-50 bg-white rounded-xl p-3 shadow-lg border border-slate-200 text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-bars text-xl"></i>
    </button>
    <div id="overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 hidden"></div>

    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-slate-800 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 animate-slide-down">
            <i class="fa-solid fa-check-circle text-lg"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Sidebar (same as yours) -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl z-50 transform -translate-x-full transition-transform duration-300 flex flex-col border-r border-slate-200">
        <!-- Your sidebar content here (unchanged) -->
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Oweru<span class="text-slate-600">Hardware</span></h1>
                    <p class="text-xs text-slate-500">Admin Panel</p>
                </div>
            </div>
            <button id="close-sidebar" class="lg:hidden text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-times text-xl"></i>
            </button>
        </div>
        <nav class="p-4 space-y-1 flex-1 overflow-y-auto">
            <a href="{{ route('adminDashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium"><i class="fa-solid fa-gauge-high w-5"></i> Dashboard</a>
            <a href="{{ route('indexProduct') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium"><i class="fa-solid fa-boxes-stacked w-5"></i> Products</a>
            <a href="{{ route('indexCategory') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium"><i class="fa-solid fa-tags w-5"></i> Categories</a>
            <a href="/OrderManagement" class="flex items-center gap-3 px-4 py-3 bg-slate-800 text-white rounded-xl font-medium nav-active"><i class="fa-solid fa-shopping-bag w-5"></i> Orders</a>
            <a href="{{ route('user') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium"><i class="fa-solid fa-users w-5"></i> Customers</a>
            <a href="{{ route('ads') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium"><i class="fa-solid fa-bullhorn w-5"></i> Advertisements</a>
        </nav>
        <div class="p-5 bg-slate-50 border-t border-slate-200">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-slate-700 rounded-full flex items-center justify-center text-white font-bold text-lg shadow">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) : 'AD' }}
                </div>
                <div><p class="font-semibold text-slate-800 text-sm truncate">{{ auth()->user()->name ?? 'Admin' }}</p><p class="text-xs text-slate-500">Administrator</p></div>
            </div>
        </div>
    </aside>

    <main class="lg:pl-72 min-h-screen">
        <header class="bg-white sticky top-0 z-40 shadow-sm border-b border-slate-200">
            <div class="px-4 lg:px-8 py-4 lg:py-5 flex items-center justify-between">
                <div class="pl-12 lg:pl-0">
                    <h2 class="text-xl lg:text-2xl font-bold text-slate-900">Order Management</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Monitor and manage all orders</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="relative p-2.5 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg"><i class="fa-solid fa-bell text-lg"></i></button>
                    <form method="POST" action="{{ route('logout') }}">@csrf <button class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-slate-900 hover:bg-slate-100 rounded-lg">Logout</button></form>
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8">

            <!-- Stats Cards (unchanged) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
                <div class="bg-white rounded-xl lg:rounded-2xl p-4 lg:p-6 hover-lift shadow-sm border border-slate-200">
                    <div class="flex items-start justify-between mb-3"><div class="w-11 h-11 bg-slate-100 rounded-xl flex items-center justify-center"><i class="fa-solid fa-money-bill-wave text-slate-700 text-lg"></i></div></div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Revenue</p>
                    <p class="text-2xl lg:text-3xl font-bold text-slate-900">TZS {{ number_format($revenue) }}</p>
                </div>
                <div class="bg-white rounded-xl lg:rounded-2xl p-4 lg:p-6 hover-lift shadow-sm border border-slate-200">
                    <div class="flex items-start justify-between mb-3"><div class="w-11 h-11 bg-slate-800 rounded-xl flex items-center justify-center"><i class="fa-solid fa-shopping-cart text-white text-lg"></i></div></div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Total Orders</p>
                    <p class="text-2xl lg:text-3xl font-bold text-slate-900">{{ $totalOrders }}</p>
                </div>
                <div class="bg-white rounded-xl lg:rounded-2xl p-4 lg:p-6 hover-lift shadow-sm border border-slate-200">
                    <div class="flex items-start justify-between mb-3"><div class="w-11 h-11 bg-slate-100 rounded-xl flex items-center justify-center"><i class="fa-solid fa-boxes-stacked text-slate-700 text-lg"></i></div></div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Products</p>
                    <p class="text-2xl lg:text-3xl font-bold text-slate-900">{{ $productsCount }}</p>
                </div>
                <div class="bg-white rounded-xl lg:rounded-2xl p-4 lg:p-6 hover-lift shadow-sm border border-slate-200">
                    <div class="flex items-start justify-between mb-3"><div class="w-11 h-11 bg-slate-100 rounded-xl flex items-center justify-center"><i class="fa-solid fa-users text-slate-700 text-lg"></i></div></div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Customers</p>
                    <p class="text-2xl lg:text-3xl font-bold text-slate-900">{{ $users }}</p>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold text-slate-900">All Orders</h3>
                        <p class="text-sm text-slate-500">Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }} of {{ $orders->total() }} orders</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full orders-table">
                        <thead class="hidden md:table-header-group bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Order ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Products</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Payment</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Update</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($orders as $order)
                                <tr class="hover:bg-amber-50 transition">
                                    <td data-label="Order ID" class="px-6 py-4 font-bold text-slate-700">#{{ $order->order_number ?? 'N/A' }}</td>
                                    <td data-label="Customer" class="px-6 py-4 text-slate-700 font-medium">
                                        {{ $order->user?->name ?? $order->customer_name ?? 'Guest' }}
                                    </td>

                                    <td data-label="Products" class="px-6 py-4 text-slate-700 font-medium max-w-xs">
                                        @if($order->orderItems->count() > 0)
                                            <div class="space-y-1">
                                                @foreach($order->orderItems->take(2) as $item)
                                                    <div class="text-sm">
                                                        {{ $item->product_name ?? ($item->product->name ?? 'N/A') }}
                                                        @if($item->quantity > 1)
                                                            <span class="text-slate-500">(x{{ $item->quantity }})</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                @if($order->orderItems->count() > 2)
                                                    <div class="text-xs text-slate-500 italic">
                                                        +{{ $order->orderItems->count() - 2 }} more product(s)
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-slate-400 text-sm">No products</span>
                                        @endif
                                    </td>

                                    <td data-label="Amount" class="px-6 py-4 font-bold text-slate-900">
                                        TZS {{ number_format($order->total_amount) }}
                                    </td>

                                    <td data-label="Payment" class="px-6 py-4">
                                        @if($order->payment_status === 'paid')
                                            <span class="px-3 py-1.5 text-xs font-bold rounded-full inline-block bg-green-100 text-green-800">
                                                <i class="fa-solid fa-check-circle mr-1"></i>Paid
                                            </span>
                                        @else
                                            <span class="px-3 py-1.5 text-xs font-bold rounded-full inline-block bg-yellow-100 text-yellow-800 mr-2">
                                                {{ ucfirst($order->payment_status ?? 'Pending') }}
                                            </span>
                                            <form action="{{ route('orders.mark-as-paid', $order->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" onclick="return confirm('Mark order #{{ $order->order_number }} as paid?')" 
                                                    class="px-2 py-1 text-xs font-semibold text-white bg-green-600 hover:bg-green-700 rounded-lg transition">
                                                    <i class="fa-solid fa-money-bill-wave mr-1"></i>Mark Paid
                                                </button>
                                            </form>
                                        @endif
                                    </td>

                                    <td data-label="Status" class="px-6 py-4">
                                        <span class="px-3 py-1.5 text-xs font-bold rounded-full inline-block
                                            {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $order->status == 'shipped' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                            {{ in_array($order->status, ['pending','new']) ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <td data-label="Update" class="px-6 py-4">
                                        <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="px-3 py-2 rounded-lg text-xs font-medium border border-slate-300 text-slate-700 bg-white hover:border-slate-400 focus:border-slate-500 outline-none cursor-pointer">
                                                <option value="pending" {{ in_array($order->status, ['pending','new']) ? 'selected' : '' }}>Pending</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-12 text-center text-slate-500">No orders found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Beautiful Pagination -->
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="text-sm text-slate-600">
                        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
                    </div>
                    <div>
                        {{ $orders->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Sidebar toggle script (same as before)
        const toggleBtn = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const closeBtn = document.getElementById('close-sidebar');

        function openSidebar() { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
        function closeSidebar() { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); document.body.style.overflow = ''; }

        toggleBtn.addEventListener('click', () => sidebar.classList.contains('-translate-x-full') ? openSidebar() : closeSidebar());
        overlay.addEventListener('click', closeSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        document.addEventListener('keydown', e => e.key === 'Escape' && closeSidebar());
    </script>
</body>
</html>