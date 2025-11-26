{{-- resources/views/admin/dashboard.blade.php --}}
@php
    use App\Models\User;
    use App\Models\Order;
    use App\Models\Product;
    use App\Models\Advertisement;

    $totalRevenue = Order::where('status', 'completed')->sum('total_amount') ?? 0;
    $recentOrders = Order::with('user')->latest()->take(10)->get();
    $totalOrdersThisMonth = Order::whereMonth('created_at', now()->month)->count();
    $totalProducts = Product::count();
    $totalUsers = User::count();
    $advertisements = Advertisement::orderBy('sort_order')->get();
    $lowStockProducts = Product::where('stock', '<=', 20)->where('stock', '>', 0)->get();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard • Weru Hardware Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#ff6b35',
                        'primary-dark': '#e85a2a',
                        'primary-light': '#fff3ed',
                    }
                }
            }
        }
    </script>
    <style>
        .text-2xs { font-size: 0.625rem; line-height: 1rem; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 25px -6px rgba(255,107,53,0.18); }
        .table-row:hover { background-color: #fff7f0; }
        .mobile-menu { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-light via-white to-orange-50 min-h-screen">

    {{-- Mobile Menu Button --}}
    <button id="menu-btn" class="fixed top-4 left-4 z-50 lg:hidden bg-white rounded-full p-3 shadow-lg border border-orange-200">
        <i class="fa-solid fa-bars text-primary text-xl"></i>
    </button>

    {{-- Mobile Overlay --}}
    <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl border-r border-orange-100 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="p-6 border-b border-orange-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-hard-hat text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900">Weru<span class="text-primary">Hardware</span></h1>
                    <p class="text-2xs text-gray-500">Admin Panel</p>
                </div>
            </div>
        </div>

        <nav class="p-4 space-y-1">
            <a href="{{ route('adminDashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-gradient-to-r from-primary to-primary-dark text-white shadow-sm text-sm font-medium">
                <i class="fa-solid fa-gauge-high w-5 h-5"></i> Dashboard
            </a>
            <a href="{{ route('indexProduct') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition text-sm">
                <i class="fa-solid fa-boxes-stacked w-5 h-5"></i> Products
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition text-sm">
                <i class="fa-solid fa-tags w-5 h-5"></i> Categories
            </a>
            <a href="/OrderManagement" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition text-sm">
                <i class="fa-solid fa-shopping-bag w-5 h-5"></i> Orders
            </a>
            <a href="{{ route('user') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition text-sm">
                <i class="fa-solid fa-users w-5 h-5"></i> Users
            </a>
            <a href="{{ url('ads') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition text-sm">
                <i class="fa-solid fa-bullhorn w-5 h-5"></i> Advertisements
            </a>
        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-5 border-t border-orange-100 bg-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center text-white font-bold shadow">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) : 'AD' }}
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">
                        {{ auth()->check() ? Str::limit(auth()->user()->name, 15) : 'Admin' }}
                    </p>
                    <p class="text-2xs text-gray-500">
                        {{ auth()->check() && auth()->user()->hasRole('admin') ? 'Administrator' : 'Staff' }}
                    </p>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="lg:ml-72 min-h-screen">
        {{-- Header --}}
        <header class="bg-white border-b border-orange-100 sticky top-0 z-40 shadow-sm">
            <div class="flex items-center justify-between px-6 py-5 lg:px-8">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Welcome back, {{ auth()->check() ? explode(' ', auth()->user()->name)[0] : 'Admin' }}!</h2>
                    <p class="text-xs text-gray-500 mt-1">{{ now()->format('l, d F Y') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('createProduct') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-primary to-primary-dark text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition text-sm">
                        <i class="fa-solid fa-plus"></i> Add Product
                    </a>
                    @if(auth()->check())
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 hover:text-primary font-medium">Logout</button>
                        </form>
                    @endif
                </div>
            </div>
        </header>

        <div class="p-5 lg:p-8 max-w-7xl mx-auto">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3 rounded-xl shadow text-sm font-medium flex items-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Stats Grid - Mobile Stacked --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <div class="bg-white rounded-2xl border border-orange-100 p-5 hover-lift transition text-center sm:text-left">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-gray-500 uppercase">Revenue</span>
                        <i class="fa-solid fa-sack-dollar text-green-600"></i>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">TZS {{ number_format($totalRevenue) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Completed orders</p>
                </div>

                <div class="bg-white rounded-2xl border border-orange-100 p-5 hover-lift transition text-center sm:text-left">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-gray-500 uppercase">Orders This Month</span>
                        <i class="fa-solid fa-shopping-cart text-primary"></i>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalOrdersThisMonth }}</p>
                    <p class="text-xs text-gray-500 mt-1">+8.2% vs last month</p>
                </div>

                <div class="bg-white rounded-2xl border border-orange-100 p-5 hover-lift transition text-center sm:text-left">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-gray-500 uppercase">Products</span>
                        <i class="fa-solid fa-boxes-stacked text-blue-600"></i>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
                    <p class="text-xs text-gray-500 mt-1">In catalog</p>
                </div>

                <div class="bg-white rounded-2xl border border-orange-100 p-5 hover-lift transition text-center sm:text-left">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-gray-500 uppercase">Customers</span>
                        <i class="fa-solid fa-users text-purple-600"></i>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
                    <p class="text-xs text-gray-500 mt-1">Registered</p>
                </div>
            </div>

            {{-- Main Grid - Mobile Stacked --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Recent Orders --}}
                <div class="lg:col-span-2 order-2 lg:order-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
                        <div class="px-5 py-4 border-b border-orange-100 flex items-center justify-between">
                            <h3 class="font-bold text-gray-800">Recent Orders</h3>
                            <a href="/OrderManagement" class="text-sm text-primary font-bold hover:underline">View all</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-orange-50 text-xs">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-bold text-gray-600">ID</th>
                                        <th class="px-4 py-3 text-left font-bold text-gray-600 hidden sm:table-cell">Customer</th>
                                        <th class="px-4 py-3 text-left font-bold text-gray-600">Amount</th>
                                        <th class="px-4 py-3 text-left font-bold text-gray-600">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-orange-50">
                                    @forelse($recentOrders as $order)
                                    <tr class="table-row text-xs">
                                        <td class="px-4 py-4 font-bold text-primary">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td class="px-4 py-4 text-gray-700 hidden sm:table-cell">{{ Str::limit($order->user?->name ?? 'Guest', 15) }}</td>
                                        <td class="px-4 py-4 font-bold">TZS {{ number_format($order->total_amount, 0) }}</td>
                                        <td class="px-4 py-4">
                                            <span class="px-2 py-1 text-xs font-bold rounded-full
                                                {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center py-10 text-gray-500 text-sm">No recent orders</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="space-y-6 order-1 lg:order-2">

                    {{-- Active Ads --}}
                    <div class="bg-white rounded-2xl border border-orange-100 p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-gray-800">Active Ads</h3>
                            <a href="{{ url('ads') }}" class="text-sm text-primary font-bold">Manage</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($advertisements->take(4) as $ad)
                            <div class="flex items-center gap-3 p-3 bg-orange-50 rounded-xl">
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                    @if($ad->media_type === 'image')
                                        <img src="{{ Storage::url($ad->media_path) }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-video text-red-600"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-gray-900 text-sm">{{ Str::limit($ad->title, 20) }}</p>
                                    <p class="text-xs text-gray-500">Sort: {{ $ad->sort_order }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-gray-500 py-4 text-sm">No ads yet</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Low Stock Alert --}}
                    @if($lowStockProducts->count() > 0)
                    <div class="bg-gradient-to-br from-red-50 to-orange-50 border-2 border-red-300 rounded-2xl p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-red-800 text-sm">Low Stock Alert</h3>
                            <i class="fa-solid fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="space-y-2">
                            @foreach($lowStockProducts->take(5) as $p)
                            <div class="flex justify-between text-sm">
                                <span class="font-medium text-gray-800">{{ Str::limit($p->name, 20) }}</span>
                                <span class="text-red-700 font-bold">{{ $p->stock }} left</span>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('indexProduct') }}" class="block text-center mt-4 text-sm font-bold text-red-700 hover:underline">
                            Go to Products
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </main>

    {{-- Mobile Menu Script --}}
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');
 
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>
</html>