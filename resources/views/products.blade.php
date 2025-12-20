<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Products - Oweru Hardware</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } }

        function toggleSidebar() {
            const sidebar = document.getElementById('category-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function showCartNotification() {
            const notification = document.getElementById('cart-notification');
            notification.classList.remove('hidden', 'opacity-0', 'translate-y-2');
            notification.classList.add('opacity-100', 'translate-y-0');
            setTimeout(() => {
                notification.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => notification.classList.add('hidden'), 300);
            }, 2500);
        }
    </script>
    <style>
        * { -webkit-tap-highlight-color: transparent; }
        html { scroll-behavior: smooth; }
        :root {
            --primary: rgb(218,165,32);
            --dark-blue: #002147;
            --light-bg: #f5f5f5;
        }
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #f9f9f9 0%, #f5f5f5 100%);
        }

        /* Advanced Animations */
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        .animate-slide-in { animation: slideInUp 0.5s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
        .animate-scale-in { animation: scaleIn 0.3s ease-out forwards; }
        .badge-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }

        /* Product Card Styles */
        .product-card { 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            border-radius: 16px;
        }
        .product-card:hover { 
            transform: translateY(-12px); 
            box-shadow: 0 30px 60px -12px rgba(0, 33, 71, 0.2);
        }

        /* Glass Effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        /* Smooth Shadow */
        .smooth-shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 10px 13px rgba(0, 0, 0, 0.1);
        }

        /* Search Focus Effect */
        .search-focus:focus-within { 
            box-shadow: 0 0 0 3px rgba(218, 165, 32, 0.2); 
        }

        /* Category Sidebar Animations */
        .category-chip.active { 
            background: rgb(218,165,32); 
            color: #000000;
            transform: scale(1.02);
        }
        .category-chip {
            transition: all 0.3s ease;
        }
        .category-chip:hover {
            transform: translateY(-2px);
        }

        /* Hero Section Styles */
        .hero-section {
            background: linear-gradient(135deg, #002147 0%, #001a33 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(218,165,32, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* Responsive Typography */
        .text-responsive-title {
            font-size: clamp(1.75rem, 6vw, 2.5rem);
        }
        .text-responsive-subtitle {
            font-size: clamp(0.9rem, 3vw, 1.125rem);
        }

        /* Responsive Grid */
        @media (max-width: 640px) {
            .grid-products { 
                grid-template-columns: 1fr; 
            }
            .sidebar-button { width: 100%; }
        }

        @media (641px) and (max-width: 1024px) {
            .grid-products { 
                grid-template-columns: repeat(2, 1fr); 
            }
        }

        @media (min-width: 1025px) {
            .grid-products { 
                grid-template-columns: repeat(3, 1fr); 
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: rgb(218,165,32);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #d4af37;
        }

        /* Touch-Friendly Buttons */
        @media (max-width: 640px) {
            button, a {
                min-height: 44px;
                min-width: 44px;
            }
        }

        /* Navigation Styles */
        nav {
            background: linear-gradient(135deg, #002147 0%, #001a33 100%);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid rgba(218,165,32, 0.2);
        }

        nav a {
            transition: all 0.3s ease;
            position: relative;
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: rgb(218,165,32);
            transition: width 0.3s ease;
        }

        nav a:hover::after {
            width: 100%;
        }

        /* Filter Pills */
        .filter-pill {
            padding: 0.5rem 1.25rem;
            border-radius: 12px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
            white-space: nowrap;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .filter-pill:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Button Ripple Effect */
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* No Products State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        /* Responsive Layout */
        @media (max-width: 768px) {
            body { padding: 0; margin: 0; }
            .search-bar { position: sticky; top: 60px; z-index: 30; }
            .product-card { margin-bottom: 0.5rem; }
        }

        /* Header Sticky */
        header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: linear-gradient(135deg, #002147 0%, #001a33 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-slate-50 antialiased">

    <!-- Success Notification -->
    @if(session('success'))
        <div id="cart-notification" class="fixed top-20 right-4 z-50 bg-green-600 text-white px-6 py-4 rounded-lg shadow-2xl transform transition-all duration-300 opacity-100 translate-y-0 animate-fade-in">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-semibold text-sm">{{ session('success') }}</span>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const n = document.getElementById('cart-notification');
                if(n) { n.classList.add('opacity-0', 'translate-y-2'); setTimeout(() => n.classList.add('hidden'), 300); }
            }, 2500);
        </script>
    @endif

    <!-- Navigation -->
    <header class="sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <div class="flex items-center gap-4 lg:gap-8">
                    <div class="flex-shrink-0 group">
                        <a href="/" class="flex items-center gap-2 transform group-hover:scale-105 transition">
                            <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, rgb(218,165,32), #002147);">
                                <i class="fa-solid fa-hard-hat text-white text-lg lg:text-xl"></i>
                            </div>
                            <span class="text-lg lg:text-xl font-black text-white leading-tight">
                                Oweru<span style="color: rgb(218,165,32);">Hardware</span>
                            </span>
                        </a>
                    </div>
                    <nav class="hidden md:flex gap-6 lg:gap-8 items-center">
                        <a href="{{ route('products') }}" class="px-4 py-2 rounded-lg font-semibold text-sm lg:text-base transition" style="background: rgb(218,165,32); color: #000000;">Products</a>
                        <a href="#" class="font-medium text-sm lg:text-base transition" style="color: rgba(218,165,32, 0.8);">About</a>
                        <a href="#" class="font-medium text-sm lg:text-base transition" style="color: rgba(218,165,32, 0.8);">Contact</a>
                    </nav>
                </div>
                <div class="flex items-center gap-3 lg:gap-6">
                    @auth
                        <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-lg" style="background: rgba(218,165,32, 0.1);">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold" style="background: rgb(218,165,32); color: #000000;">
                                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                            </div>
                            <span class="text-sm font-medium" style="color: rgba(218,165,32, 0.9);">{{ Str::limit(Auth::user()->name ?? 'User', 15) }}</span>
                        </div>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="hidden md:inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg transition" style="color: rgba(218,165,32, 0.8);">
                            <i class="fa-solid fa-sign-in-alt"></i>Sign In
                        </a>
                    @endguest

                    <!-- Cart Button -->
                    <a href="{{ route('cart') }}" class="relative inline-flex items-center gap-2 px-4 lg:px-5 py-2.5 lg:py-3 rounded-lg font-bold text-xs lg:text-sm transition hover:shadow-lg transform hover:scale-105" style="background: rgb(218,165,32); color: #000000;">
                        <i class="fa-solid fa-shopping-cart"></i>
                        <span class="hidden sm:inline">Cart</span>
                        <span class="absolute -top-2 -right-2 text-xs font-black rounded-full h-6 w-6 flex items-center justify-center" style="background: #d32f2f; color: white;">
                            {{ \App\Models\Cart::current()->totalItems() }}
                        </span>
                    </a>

                    <!-- Mobile Menu Toggle -->
                    <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg transition hover:scale-110" style="background: rgba(218,165,32, 0.1);">
                        <i class="fa-solid fa-bars text-xl" style="color: rgb(218,165,32);"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="hero-section py-12 lg:py-16 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-8 relative z-10">
                <div class="flex flex-col items-center md:items-start">
                    <div class="mb-6 animate-fade-in">
                        <div class="bg-white rounded-full p-3 lg:p-4 shadow-2xl transform hover:scale-110 transition">
                            <img src="{{ asset('images/IMG-20251114-WA0007.jpg') }}" alt="Oweru Hardware Logo" class="h-20 w-20 lg:h-24 lg:w-24 object-contain rounded-full">
                        </div>
                    </div>
                    <h1 class="text-responsive-title font-black tracking-tight mb-3 text-center md:text-left animate-slide-in">
                        Products Catalog
                    </h1>
                    <p class="text-responsive-subtitle text-blue-100 text-center md:text-left animate-slide-in" style="animation-delay: 0.1s;">
                        Browse <strong style="color: rgb(218,165,32);">{{ $totalProducts ?? 0 }}+ premium building materials</strong> delivered fast across Tanzania
                    </p>
                </div>
                <div class="hidden md:block w-32 h-32 opacity-10 animate-pulse">
                    <i class="fa-solid fa-warehouse text-6xl"></i>
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <button onclick="toggleSidebar()" class="lg:hidden w-full flex items-center justify-center gap-2 mb-4 px-4 py-3 bg-gold text-white rounded-xl font-bold shadow-lg hover:bg-gold-dark transition">
                    Filter Categories
                </button>

                <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

                <div id="category-sidebar" class="fixed top-0 right-0 h-full w-80 bg-slate-900 p-6 shadow-2xl transform translate-x-full transition-transform duration-300 z-50 lg:relative lg:translate-x-0 lg:w-full lg:rounded-2xl lg:border lg:border-slate-900 lg:sticky lg:top-24 overflow-y-auto">
                    <div class="flex justify-between items-center mb-8 lg:hidden">
                        <h3 class="text-xl font-bold text-white">Categories</h3>
                        <button onclick="toggleSidebar()" class="text-slate-300 hover:text-slate-100">
                            X
                        </button>
                    </div>

                    <div class="space-y-3 bg-slate-900 ">
                        <a href="{{ route('products') }}"
                           class="flex items-center justify-between p-4 rounded-xl transition-all {{ !request('category') ? 'bg-slate-800 text-white shadow-lg font-bold' : 'hover:bg-red-800 text-slate-100' }}">
                            <div class="flex items-center gap-3">
                                All Products
                            </div>
                            <span class="px-3 py-1 {{ !request('category')}}  bg-slate-800 rounded-full text-xs font-bold">
                                {{ $totalProducts ?? 0 }}
                            </span>
                        </a>

                        @foreach(\App\Models\Categories::withCount('products')->orderBy('name')->get() as $category)
                            <a href="{{ route('products', ['category' => $category->slug]) }}"
                               class="flex items-center justify-between p-4 rounded-xl transition-all {{ request('category') === $category->slug ? 'bg-amber-600 text-slate-900 shadow-lg font-bold' : 'hover:bg-slate-800 text-slate-100' }}">
                                <span class="font-medium">{{ $category->name }}</span>
                                <span class="px-3 py-1 {{ request('category') === $category->slug ? 'bg-white/20' : 'bg-slate-800' }} rounded-full text-xs font-bold">
                                    {{ $category->products_count }}
                                </span>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-800">
                        <h4 class="text-sm font-bold text-slate-100 mb-4">Quick Stats</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-200">Total Products</span>
                                <span class="font-bold text-yellow-400">{{ $totalProducts ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-200">Categories</span>
                                <span class="font-bold text-yellow-400">{{ \App\Models\Categories::count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <section class="lg:col-span-3">
                <!-- Search Bar -->
                <div class="bg-slate-900 rounded-2xl border border-slate-800 p-5 mb-8 sticky top-20 z-30 shadow-md">
                    <form action="{{ route('products') }}" method="GET">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="flex gap-3 search-focus rounded-xl bg-slate">
                            <div class="relative flex-1">
                               
                                <input type="search" name="search" value="{{ request('search') }}"
                                       placeholder="Search cement, steel, paint, roofing..."
                                       class="w-full pl-12 pr-4 py-4 bg-slate-800 border border-slate-700 rounded-xl text-base text-white placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
                            </div>
                            <button type="submit" class="px-8 py-4 bg-amber-600 text-white font-bold rounded-xl hover:bg-red-700 transition shadow-lg">
                                Search
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Results Info -->
                <div class="mb-6 flex items-center justify-between">
                    <p class="text-slate-100">
                        Showing <strong class="text-white">{{ $products->count() }}</strong> of {{ $totalProducts ?? 0 }} products
                    </p>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    @forelse($products as $product)
                        <article class="product-card bg-slate-950 rounded-2xl overflow-hidden border border-slate-800 shadow-lg hover:shadow-2xl">
                            <div class="relative aspect-square bg-gradient-to-br from-slate-900 to-slate-800 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-slate-800">
                                        <i class="fa-solid fa-box text-6xl text-slate-700"></i>
                                    </div>
                                @endif

                                <!-- Stock Badge -->
                                <div class="absolute top-4 left-4">
                                    @if($product->stock > 0)
                                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 text-white text-sm font-bold rounded-full shadow-lg">
                                            <span class="w-2 h-2 bg-white rounded-full badge-pulse"></span>
                                            In Stock
                                        </span>
                                    @else
                                        <span class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-full shadow-lg">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>

                                @if($product->min_order > 1)
                                    <div class="absolute top-4 right-4 px-3 py-1.5 bg-yellow-500 text-slate-900 text-xs font-bold rounded-full shadow-lg">
                                        Min: {{ $product->min_order }}
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <div class="mb-3">
                                    <span class="inline-block px-3 py-1 bg-slate-800 text-yellow-400 text-xs font-bold rounded-full">
                                        {{ $product->category?->name ?? 'Uncategorized' }}
                                    </span>
                                </div>

                                <h3 class="text-xl font-black text-white mb-2 line-clamp-2">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-sm text-slate-200 mb-4 line-clamp-2">
                                    {{ Str::limit($product->description, 90) }}
                                </p>

                                <!-- Price Section -->
                                <div class="mb-6">
                                    <div class="flex items-baseline gap-3">
                                        <span class="text-3xl font-black text-yellow-400">
                                            TZS {{ number_format($product->price) }}
                                        </span>
                                        @if($product->old_price && $product->old_price > $product->price)
                                            <span class="text-lg text-slate-400 line-through">
                                                TZS {{ number_format($product->old_price) }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($product->old_price && $product->old_price > $product->price)
                                        <span class="inline-block mt-2 px-3 py-1 bg-green-600 text-white text-xs font-bold rounded-full">
                                            {{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}% OFF
                                        </span>
                                    @endif
                                </div>

                                <!-- Add to Cart Button -->
                                <div class="flex gap-3">
                                    @if($product->stock > 0)
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" onclick="showCartNotification()"
                                                    class="w-full py-4 bg-amber-600 text-white font-black text-lg rounded-xl shadow-xl hover:bg-red-700 hover:shadow-2xl transform hover:scale-105 transition duration-300 flex items-center justify-center gap-3">
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full py-4 bg-slate-800 text-slate-400 font-bold rounded-xl cursor-not-allowed">
                                            Out of Stock
                                        </button>
                                    @endif

                                    <a href="{{ route('show', $product->slug ?? $product->id) }}" class="p-4 bg-amber-600 rounded-xl hover:bg-yellow-400 transition text-slate-900 font-bold">
                                        View
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full text-center py-20">
                            <div class="w-32 h-32 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fa-solid fa-box-open text-6xl text-yellow-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-3">No Products Found</h3>
                            <p class="text-slate-200 mb-8">Try adjusting your search or filters.</p>
                            <a href="{{ route('products') }}" class="px-8 py-4 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition shadow-lg">
                                Clear Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="mt-12">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            </section>
        </div>
    </main>

    <footer class="bg-slate-950 text-slate-200 py-12 mt-20 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-xl font-bold text-white mb-2">Oweru Hardware</p>
            <p class="text-lg text-slate-300">Tanzania's #1 Building Materials Supplier • Fast Delivery Nationwide</p>
            <p class="mt-6 text-sm text-slate-400">&copy; {{ date('Y') }} Oweru Hardware. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>