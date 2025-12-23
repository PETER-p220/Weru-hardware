@php
    use App\Models\User;
    use App\Models\Order;
    use App\Models\Product;
    use App\Models\Advertisement;

    $totalRevenue = Order::where('status', 'completed')->sum('total_amount') ?? 0;
    $recentOrders = Order::with(['user', 'orderItems.product'])->latest()->take(10)->get();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard • Oweru Hardware Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        slate: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * {
            -webkit-tap-highlight-color: transparent;
            box-sizing: border-box;
        }
        
        .text-2xs { 
            font-size: 0.625rem; 
            line-height: 1rem; 
        }
        
        /* Enhanced responsive table to cards on mobile */
        @media (max-width: 640px) {
            .responsive-table thead { 
                display: none; 
            }
            .responsive-table tbody {
                display: block;
            }
            .responsive-table tr { 
                display: block; 
                margin-bottom: 1rem; 
                border: 1px solid #e2e8f0; 
                border-radius: 0.875rem; 
                overflow: hidden;
                background: white;
                box-shadow: 0 2px 6px rgba(15, 23, 42, 0.06);
            }
            .responsive-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.875rem 1rem;
                border-bottom: 1px solid #f1f5f9;
            }
            .responsive-table td:last-child { 
                border-bottom: none; 
            }
            .responsive-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #334155;
                text-transform: uppercase;
                font-size: 0.65rem;
                letter-spacing: 0.05em;
            }
        }

        /* Smooth animations */
        @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateY(10px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        .animate-slide-in {
            animation: slideIn 0.4s ease-out forwards;
        }

        /* Stat card animation delay */
        .stat-card { 
            animation: slideIn 0.4s ease-out forwards;
        }
        .stat-card:nth-child(1) { animation-delay: 0s; }
        .stat-card:nth-child(2) { animation-delay: 0.1s; }
        .stat-card:nth-child(3) { animation-delay: 0.2s; }
        .stat-card:nth-child(4) { animation-delay: 0.3s; }

        /* Mobile optimizations */
        @media (max-width: 640px) {
            .mobile-optimized {
                touch-action: manipulation;
            }
            
            /* Better touch targets */
            button, a {
                min-height: 44px;
                min-width: 44px;
            }
        }

        /* Improved scrollbar for desktop */
        @media (min-width: 1024px) {
            ::-webkit-scrollbar { 
                width: 8px; 
                height: 8px; 
            }
            ::-webkit-scrollbar-track { 
                background: #f1f5f9; 
            }
            ::-webkit-scrollbar-thumb { 
                background: #64748b; 
                border-radius: 4px; 
            }
            ::-webkit-scrollbar-thumb:hover { 
                background: #475569; 
            }
        }

        /* Mobile sidebar */
        @media (max-width: 1023px) {
            #sidebar {
                max-width: 85vw;
            }
        }

        /* Active nav highlight */
        .nav-active {
            position: relative;
        }
        .nav-active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 70%;
            background: #ffffff;
            border-radius: 0 4px 4px 0;
        }

        /* Touch feedback */
        .touch-feedback:active {
            transform: scale(0.97);
            transition: transform 0.1s ease;
        }

        /* Hover effects */
        .hover-lift {
            transition: all 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(15, 23, 42, 0.1);
        }

        /* Pulse animation for notification badge */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen mobile-optimized">

    <!-- Mobile Menu Button -->
    <button id="menu-btn" class="fixed top-4 left-4 z-50 lg:hidden bg-white rounded-xl p-3 shadow-lg border border-slate-200 text-slate-700 hover:bg-slate-50 touch-feedback">
        <i class="fa-solid fa-bars text-xl"></i>
        @if($lowStockProducts->count() > 0)
        <span class="absolute -top-1 -right-1 w-5 h-5 bg-slate-800 text-white text-xs rounded-full flex items-center justify-center font-bold shadow-md">{{ $lowStockProducts->count() }}</span>
        @endif
    </button>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-slate-900/60 z-40 hidden lg:hidden transition-opacity duration-300 backdrop-blur-sm"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white shadow-xl z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col border-r border-slate-200">
        <!-- Close button for mobile -->
        <button id="close-sidebar" class="absolute top-4 right-4 lg:hidden text-slate-400 hover:text-slate-600 w-10 h-10 flex items-center justify-center rounded-lg hover:bg-slate-100 touch-feedback">
            <i class="fa-solid fa-times text-xl"></i>
        </button>

        <!-- Logo -->
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Oweru<span class="text-slate-600">Hardware</span></h1>
                    <p class="text-xs text-slate-500">Admin Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-1 flex-1 overflow-y-auto">
            <a href="{{ route('adminDashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-slate-800 text-white rounded-xl font-medium nav-active touch-feedback transition hover:bg-slate-700">
                <i class="fa-solid fa-gauge-high w-5"></i> 
                <span>Dashboard</span>
            </a>
            <a href="{{ route('indexProduct') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-100 rounded-xl transition touch-feedback">
                <i class="fa-solid fa-boxes-stacked w-5"></i> 
                <span>Products</span>
                <span class="ml-auto text-xs px-2.5 py-1 bg-slate-100 text-slate-700 rounded-full font-bold">{{ $totalProducts }}</span>
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-100 rounded-xl transition touch-feedback">
                <i class="fa-solid fa-tags w-5"></i> 
                <span>Categories</span>
            </a>
            <a href="/OrderManagement" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-100 rounded-xl transition touch-feedback">
                <i class="fa-solid fa-shopping-bag w-5"></i> 
                <span>Orders</span>
                @if($totalOrdersThisMonth > 0)
                <span class="ml-auto text-xs px-2.5 py-1 bg-slate-100 text-slate-700 rounded-full font-bold">{{ $totalOrdersThisMonth }}</span>
                @endif
            </a>
            <a href="{{ route('user') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-100 rounded-xl transition touch-feedback">
                <i class="fa-solid fa-users w-5"></i> 
                <span>Users</span>
            </a>
            <a href="{{ url('ads') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-100 rounded-xl transition touch-feedback">
                <i class="fa-solid fa-bullhorn w-5"></i> 
                <span>Advertisements</span>
            </a>
            <a href="{{ route('contact.messages') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-100 rounded-xl transition touch-feedback">
                <i class="fa-solid fa-envelope w-5"></i>
                <span>Contact Messages</span>
            </a>

            <!-- Mobile Quick Actions -->
            <div class="lg:hidden pt-4 mt-4 border-t border-slate-200">
                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Quick Actions</p>
                <a href="{{ route('createProduct') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-100 rounded-xl transition touch-feedback">
                    <i class="fa-solid fa-plus-circle w-5"></i> 
                    <span>Add Product</span>
                </a>
            </div>
        </nav>

        <!-- User Profile -->
        <div class="p-5 bg-slate-50 border-t border-slate-200">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-slate-700 text-white rounded-full flex items-center justify-center font-bold text-lg shadow">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) : 'AD' }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-slate-800 text-sm truncate">
                        {{ auth()->check() ? auth()->user()->name : 'Admin' }}
                    </p>
                    <p class="text-xs text-slate-500">
                        {{ auth()->check() && auth()->user()->hasRole('admin') ? 'Administrator' : 'Staff' }}
                    </p>
                </div>
                @if(auth()->check())
                <form method="POST" action="{{ route('logout') }}" class="lg:hidden">
                    @csrf
                    <button type="submit" class="touch-feedback p-2 text-slate-600 hover:text-slate-800 rounded-lg hover:bg-slate-100">
                        <i class="fa-solid fa-right-from-bracket text-lg"></i>
                    </button>
                </form>
                @endif
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-72 min-h-screen">
        <!-- Header -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-4 sm:px-6 lg:px-8 py-4 gap-3">
                <div class="pl-14 lg:pl-0 w-full sm:w-auto">
                    <h2 class="text-xl font-bold text-slate-900">Welcome back, {{ auth()->check() ? explode(' ', auth()->user()->name)[0] : 'Admin' }}!</h2>
                    <p class="text-sm text-slate-500 mt-0.5">{{ now()->format('l, d F Y') }}</p>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                    <button id="admin-notif-bell" class="relative hidden sm:inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50 shadow-sm touch-feedback">
                        <i class="fa-solid fa-bell text-lg"></i>
                        <span id="admin-notif-badge" class="hidden absolute -top-1 -right-1 w-4 h-4 bg-red-600 text-white text-[10px] rounded-full flex items-center justify-center font-bold"></span>
                    </button>
                    <a href="{{ route('createProduct') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-slate-800 text-white font-semibold rounded-xl shadow-md hover:bg-slate-700 hover:shadow-lg transition touch-feedback">
                        <i class="fa-solid fa-plus"></i> 
                        <span class="hidden sm:inline">Add Product</span>
                        <span class="sm:hidden">Add</span>
                    </a>
                    @if(auth()->check())
                    <form method="POST" action="{{ route('logout') }}" class="hidden lg:block">
                        @csrf
                        <button type="submit" class="px-4 py-2.5 text-slate-600 hover:text-slate-900 font-medium rounded-xl hover:bg-slate-100 transition touch-feedback">
                            Logout
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-6 bg-white border-l-4 border-slate-700 text-slate-700 px-5 py-4 rounded-xl shadow-md flex items-center gap-3 animate-slide-in">
                <i class="fa-solid fa-check-circle text-slate-700 text-xl"></i> 
                <span class="flex-1 font-medium">{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600 touch-feedback">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            @endif

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
                <div class="stat-card bg-white rounded-2xl border border-slate-200 p-5 hover-lift shadow-sm">
                    <div class="flex items-start justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Revenue</span>
                        <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-sack-dollar text-slate-700 text-lg"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-900 mb-1">TZS {{ number_format($totalRevenue) }}</p>
                    <p class="text-xs text-slate-500">Completed orders</p>
                </div>

                <div class="stat-card bg-white rounded-2xl border border-slate-200 p-5 hover-lift shadow-sm">
                    <div class="flex items-start justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Orders</span>
                        <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-shopping-cart text-white text-lg"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-900 mb-1">{{ $totalOrdersThisMonth }}</p>
                    <p class="text-xs text-slate-500">This month</p>
                </div>

                <div class="stat-card bg-white rounded-2xl border border-slate-200 p-5 hover-lift shadow-sm">
                    <div class="flex items-start justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Products</span>
                        <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-boxes-stacked text-slate-700 text-lg"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-900 mb-1">{{ $totalProducts }}</p>
                    <p class="text-xs text-slate-500">In catalog</p>
                </div>

                <div class="stat-card bg-white rounded-2xl border border-slate-200 p-5 hover-lift shadow-sm">
                    <div class="flex items-start justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Customers</span>
                        <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-users text-slate-700 text-lg"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-900 mb-1">{{ $totalUsers }}</p>
                    <p class="text-xs text-slate-500">Registered</p>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Recent Orders -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                            <h3 class="font-bold text-slate-900 text-lg">Recent Orders</h3>
                            <a href="/OrderManagement" class="text-sm text-slate-700 font-semibold hover:text-slate-900 touch-feedback">View all →</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm responsive-table">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left font-bold text-slate-700 text-xs uppercase tracking-wide">ID</th>
                                        <th class="px-6 py-3 text-left font-bold text-slate-700 text-xs uppercase tracking-wide">Customer</th>
                                        <th class="px-6 py-3 text-left font-bold text-slate-700 text-xs uppercase tracking-wide">Product</th>
                                        <th class="px-6 py-3 text-left font-bold text-slate-700 text-xs uppercase tracking-wide">Amount</th>
                                        <th class="px-6 py-3 text-left font-bold text-slate-700 text-xs uppercase tracking-wide">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($recentOrders as $order)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td data-label="ID" class="px-6 py-4 font-bold text-slate-700">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td data-label="Customer" class="px-6 py-4 text-slate-700 font-medium">{{ Str::limit($order->user?->name ?? 'Guest', 20) }}</td>
                                        <td data-label="Products" class="px-6 py-4 text-slate-600 text-xs">
                                            @if($order->orderItems->count() > 0)
                                                @foreach($order->orderItems->take(2) as $item)
                                                    <div class="mb-1">
                                                        {{ $item->product_name ?? ($item->product->name ?? 'N/A') }}
                                                        @if($item->quantity > 1)
                                                            <span class="text-slate-400">(x{{ $item->quantity }})</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                @if($order->orderItems->count() > 2)
                                                    <span class="text-slate-400 italic">+{{ $order->orderItems->count() - 2 }} more</span>
                                                @endif
                                            @else
                                                <span class="text-slate-400">No products</span>
                                            @endif
                                        </td>
                                        <td data-label="Amount" class="px-6 py-4 font-bold text-slate-900">TZS {{ number_format($order->total_amount, 0) }}</td>
                                        <td data-label="Status" class="px-6 py-4">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full inline-block
                                                {{ $order->status == 'completed' ? 'bg-slate-800 text-white' : '' }}
                                                {{ $order->status == 'pending' ? 'bg-slate-100 text-slate-700 border border-slate-200' : '' }}
                                                {{ $order->status == 'processing' ? 'bg-slate-200 text-slate-800' : '' }}
                                                {{ $order->status == 'cancelled' ? 'bg-slate-300 text-slate-900' : '' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-12 text-slate-500">No recent orders</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">

                    <!-- Active Ads -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-slate-900">Active Ads</h3>
                            <a href="{{ url('ads') }}" class="text-sm text-slate-700 font-semibold hover:text-slate-900 touch-feedback">Manage →</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($advertisements->take(4) as $ad)
                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl hover:bg-slate-100 transition touch-feedback border border-slate-100">
                                <div class="w-12 h-12 bg-slate-200 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if($ad->media_type === 'image')
                                        <img src="{{ Storage::url($ad->media_path) }}" class="w-full h-full object-cover" alt="{{ $ad->title }}">
                                    @else
                                        <i class="fa-solid fa-video text-slate-600 text-xl"></i>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-slate-900 text-sm truncate">{{ $ad->title }}</p>
                                    <p class="text-xs text-slate-500">Sort: {{ $ad->sort_order }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-slate-500 py-8 text-sm">No ads yet</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Low Stock Alert -->
                    @if($lowStockProducts->count() > 0)
                    <div class="bg-white border-2 border-slate-300 rounded-2xl p-5 animate-slide-in shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-exclamation-triangle text-slate-700"></i>
                                Low Stock Alert
                            </h3>
                            <div class="w-2.5 h-2.5 bg-slate-700 rounded-full animate-pulse"></div>
                        </div>
                        <div class="space-y-2">
                            @foreach($lowStockProducts->take(5) as $p)
                            <div class="flex justify-between items-center bg-slate-50 rounded-lg p-3 border border-slate-200 hover:border-slate-300 transition">
                                <span class="font-medium text-slate-800 truncate pr-3 text-sm">{{ Str::limit($p->name, 20) }}</span>
                                <span class="text-slate-900 font-bold flex-shrink-0 bg-slate-200 px-2.5 py-1 rounded-full text-xs">{{ $p->stock }} left</span>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('indexProduct') }}" class="block text-center mt-4 px-4 py-2.5 bg-slate-800 text-white font-semibold rounded-lg hover:bg-slate-700 shadow-md hover:shadow-lg transition touch-feedback">
                            Go to Products
                        </a>
                    </div>
                    @endif

                </div>
            </div>

            <!-- Mobile footer spacer -->
            <div class="h-16 lg:hidden"></div>
        </div>
    </main>

    <!-- Scripts -->
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const closeSidebar = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');
 
        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebarFunc() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        menuBtn.addEventListener('click', openSidebar);
        closeSidebar.addEventListener('click', closeSidebarFunc);
        overlay.addEventListener('click', closeSidebarFunc);

        // Close sidebar on navigation (mobile)
        if (window.innerWidth < 1024) {
            const navLinks = sidebar.querySelectorAll('nav a');
            navLinks.forEach(link => {
                link.addEventListener('click', closeSidebarFunc);
            });
        }

        // Handle escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                closeSidebarFunc();
            }
        });

        // Auto-dismiss success messages
        setTimeout(() => {
            const successAlert = document.querySelector('.border-slate-700');
            if (successAlert && successAlert.classList.contains('animate-slide-in')) {
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateY(-10px)';
                successAlert.style.transition = 'all 0.3s ease';
                setTimeout(() => successAlert.remove(), 300);
            }
        }, 5000);

        // Touch feedback
        document.querySelectorAll('.touch-feedback').forEach(el => {
            el.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.97)';
            });
            el.addEventListener('touchend', function() {
                this.style.transform = '';
            });
        });

        // =========================================================================
        // Live New Order Notification (simple polling)
        // =========================================================================
        (function() {
            const seenOrderIds   = new Set();
            const orderStatusMap = {};
            let firstLoad = true;

            function showNewOrderToast(order) {
                if (!order) return;

                const bell = document.getElementById('admin-notif-bell');
                const badge = document.getElementById('admin-notif-badge');

                if (badge) {
                    badge.textContent = '1';
                    badge.classList.remove('hidden');
                }

                const panelId = 'admin-notif-panel';
                let panel = document.getElementById(panelId);

                if (!panel) {
                    panel = document.createElement('div');
                    panel.id = panelId;
                    panel.className = 'hidden absolute top-14 right-4 sm:right-8 z-50 w-80 max-w-sm';
                    panel.innerHTML = `
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-2xl overflow-hidden">
                            <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                                <p class="text-sm font-semibold text-slate-900">Notifications</p>
                                <button type="button" class="text-xs text-slate-500 hover:text-slate-700" id="admin-notif-clear">Clear</button>
                            </div>
                            <div id="admin-notif-list" class="max-h-72 overflow-y-auto">
                            </div>
                        </div>
                    `;
                    document.body.appendChild(panel);

                    // Position panel relative to header (top-right)
                    const header = document.querySelector('header');
                    if (header) {
                        panel.style.top = (header.offsetTop + header.offsetHeight + 8) + 'px';
                    }
                }

                const list = document.getElementById('admin-notif-list');
                if (list) {
                    // If first-load seeding, clear placeholder
                    if (firstLoad && list.children.length === 1) {
                        list.innerHTML = '';
                    }
                    const item = document.createElement('div');
                    item.className = 'px-4 py-3 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition';
                    item.innerHTML = `
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 text-slate-700">
                                <i class="fa-solid fa-circle text-[8px]"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-slate-900">Order #${order.order_number ?? ('ID ' + order.id)}</p>
                                <p class="text-xs text-slate-600 mt-0.5">
                                    <span class="font-semibold">${order.customer_name}</span>
                                    <span class="text-slate-400">•</span>
                                    <span class="font-semibold">${order.status ? order.status.charAt(0).toUpperCase() + order.status.slice(1) : ''}</span>
                                </p>
                                <p class="text-[11px] text-slate-500 mt-0.5">Total: TZS ${Number(order.total_amount).toLocaleString('en-US')}</p>
                            </div>
                        </div>
                    `;
                    list.prepend(item);
                }

                // Open panel automatically on first new order
                if (panel && panel.classList.contains('hidden')) {
                    panel.classList.remove('hidden');
                }

                // Clicking bell toggles panel
                if (bell && !bell.dataset.bound) {
                    bell.dataset.bound = '1';
                    bell.addEventListener('click', () => {
                        if (!panel) return;
                        panel.classList.toggle('hidden');
                        if (!panel.classList.contains('hidden') && badge) {
                            badge.classList.add('hidden');
                        }
                    });
                }

                // Clear button
                const clearBtn = document.getElementById('admin-notif-clear');
                if (clearBtn) {
                    clearBtn.addEventListener('click', () => {
                        const listEl = document.getElementById('admin-notif-list');
                        if (listEl) listEl.innerHTML = '';
                        if (badge) badge.classList.add('hidden');
                    });
                }

            }

            async function checkForNewOrders() {
                try {
                    const response = await fetch('{{ route('admin.orders.latest') }}', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (!response.ok) return;

                    const data = await response.json();
                    if (Array.isArray(data.orders)) {
                        if (firstLoad) {
                            // Seed all orders once
                            const list = document.getElementById('admin-notif-list');
                            if (list) list.innerHTML = '';
                            data.orders.forEach(o => {
                                if (!o?.id) return;
                                showNewOrderToast(o);
                                seenOrderIds.add(o.id);
                                orderStatusMap[o.id] = (o.status || '').toLowerCase();
                            });
                            firstLoad = false;
                            return;
                        }

                        data.orders.forEach(o => {
                            if (!o?.id) return;

                            if (!seenOrderIds.has(o.id)) {
                                showNewOrderToast(o);
                                seenOrderIds.add(o.id);
                                orderStatusMap[o.id] = (o.status || '').toLowerCase();
                                return;
                            }

                            const currentStatus = (o.status || '').toLowerCase();
                            const prevStatus    = orderStatusMap[o.id];
                            if (prevStatus && currentStatus && currentStatus !== prevStatus) {
                                showNewOrderToast(o);
                                orderStatusMap[o.id] = currentStatus;
                            }
                        });
                    }
                } catch (e) {
                    // Fail silently; will retry next interval
                }
            }

            // Poll every 10 seconds while on admin dashboard
            setInterval(checkForNewOrders, 10000);
            // Initial seed after load
            setTimeout(checkForNewOrders, 1500);
        })();
    </script>
</body>
</html>