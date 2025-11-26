<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Weru Hardware</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
        .product-card { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px -12px rgba(249, 115, 22, 0.25); }
        .category-chip.active { background: #ea580c; color: white; }
        .badge-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .7; } }
        .search-focus:focus-within { box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2); }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <!-- Success Notification -->
    @if(session('success'))
        <div id="cart-notification" class="fixed top-20 right-4 z-50 bg-green-600 text-white px-6 py-3 rounded-lg shadow-2xl transform transition-all duration-300 opacity-100 translate-y-0">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-semibold">{{ session('success') }}</span>
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
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-8">
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center gap-2">
                            <span class="text-xl font-extrabold text-gray-900">Weru<span class="text-orange-600">Hardware</span></span>
                        </a>
                    </div>
                    <div class="hidden md:flex md:space-x-1">
                        <a href="{{ route('products') }}" class="px-4 py-2 rounded-lg bg-orange-50 text-orange-700 font-semibold text-sm">Products</a>
                        <a href="#" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium text-sm transition-colors">About</a>
                        <a href="#" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium text-sm transition-colors">Contact</a>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-gray-100 rounded-lg">
                            <div class="w-7 h-7 bg-orange-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-bold">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ Str::limit(Auth::user()->name ?? 'User', 15) }}</span>
                        </div>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="hidden md:inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-orange-600 hover:bg-orange-50 rounded-lg transition-colors">
                            Sign In
                        </a>
                    @endguest

                    <!-- Cart Button with Real Count -->
                    <a href="{{ route('cart') }}" class="relative inline-flex items-center gap-2 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-all hover:shadow-lg font-semibold text-sm">
                        Cart
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">
                            {{ \App\Models\Cart::current()->totalItems() }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-orange-600 to-orange-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-8">
                <div class="flex flex-col items-center md:items-start">
                    <div class="mb-6">
                        <div class="bg-white rounded-full p-3 shadow-2xl">
                            <img src="{{ asset('images/IMG-20251114-WA0007.jpg') }}" alt="Weru Hardware Logo" class="h-24 w-24 object-contain rounded-full">
                        </div>
                    </div>
                    <h1 class="text-5xl font-black tracking-tight mb-3 text-center md:text-left">
                        Products Catalog
                    </h1>
                    <p class="text-xl text-orange-100 text-center md:text-left">
                        Browse <strong>{{ $totalProducts ?? 0 }}+ premium building materials</strong> delivered fast across Tanzania
                    </p>
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <button onclick="toggleSidebar()" class="lg:hidden w-full flex items-center justify-center gap-2 mb-4 px-4 py-3 bg-orange-600 text-white rounded-xl font-bold shadow-lg hover:bg-orange-700 transition">
                    Filter Categories
                </button>

                <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

                <div id="category-sidebar" class="fixed top-0 right-0 h-full w-80 bg-white p-6 shadow-2xl transform translate-x-full transition-transform duration-300 z-50 lg:relative lg:translate-x-0 lg:w-full lg:rounded-2xl lg:border lg:border-gray-200 lg:sticky lg:top-24 overflow-y-auto">
                    <div class="flex justify-between items-center mb-8 lg:hidden">
                        <h3 class="text-xl font-bold text-gray-900">Categories</h3>
                        <button onclick="toggleSidebar()" class="text-gray-400 hover:text-gray-600">
                            X
                        </button>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('products') }}"
                           class="flex items-center justify-between p-4 rounded-xl transition-all {{ !request('category') ? 'bg-orange-600 text-white shadow-lg' : 'hover:bg-gray-50 text-gray-700' }}">
                            <div class="flex items-center gap-3">
                                All Products
                            </div>
                            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold">
                                {{ $totalProducts ?? 0 }}
                            </span>
                        </a>

                        @foreach(\App\Models\Categories::withCount('products')->orderBy('name')->get() as $category)
                            <a href="{{ route('products', ['category' => $category->slug]) }}"
                               class="flex items-center justify-between p-4 rounded-xl transition-all {{ request('category') === $category->slug ? 'bg-orange-600 text-white shadow-lg' : 'hover:bg-gray-50 text-gray-700' }}">
                                <span class="font-medium">{{ $category->name }}</span>
                                <span class="px-3 py-1 {{ request('category') === $category->slug ? 'bg-white/20' : 'bg-gray-200' }} rounded-full text-xs font-bold">
                                    {{ $category->products_count }}
                                </span>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-bold text-gray-700 mb-4">Quick Stats</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Products</span>
                                <span class="font-bold text-orange-600">{{ $totalProducts ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Categories</span>
                                <span class="font-bold">{{ \App\Models\Categories::count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <section class="lg:col-span-3">
                <!-- Search Bar -->
                <div class="bg-white rounded-2xl border border-gray-200 p-5 mb-8 sticky top-20 z-30 shadow-md">
                    <form action="{{ route('products') }}" method="GET">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="flex gap-3 search-focus rounded-xl">
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    Search
                                </div>
                                <input type="search" name="search" value="{{ request('search') }}"
                                       placeholder="Search cement, steel, paint, roofing..."
                                       class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-300 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                            </div>
                            <button type="submit" class="px-8 py-4 bg-orange-600 text-white font-bold rounded-xl hover:bg-orange-700 transition shadow-lg">
                                Search
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Results Info -->
                <div class="mb-6 flex items-center justify-between">
                    <p class="text-gray-600">
                        Showing <strong class="text-gray-900">{{ $products->count() }}</strong> of {{ $totalProducts ?? 0 }} products
                    </p>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    @forelse($products as $product)
                        <article class="product-card bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-lg hover:shadow-2xl">
                            <div class="relative aspect-square bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fa-solid fa-box text-6xl text-gray-300"></i>
                                    </div>
                                @endif

                                <!-- Stock Badge -->
                                <div class="absolute top-4 left-4">
                                    @if($product->stock > 0)
                                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-full shadow-lg">
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
                                    <div class="absolute top-4 right-4 px-3 py-1.5 bg-orange-700 text-white text-xs font-bold rounded-full shadow-lg">
                                        Min: {{ $product->min_order }}
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <div class="mb-3">
                                    <span class="inline-block px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">
                                        {{ $product->category?->name ?? 'Uncategorized' }}
                                    </span>
                                </div>

                                <h3 class="text-xl font-black text-gray-900 mb-2 line-clamp-2">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                    {{ Str::limit($product->description, 90) }}
                                </p>

                                <!-- Price Section -->
                                <div class="mb-6">
                                    <div class="flex items-baseline gap-3">
                                        <span class="text-3xl font-black text-orange-600">
                                            TZS {{ number_format($product->price) }}
                                        </span>
                                        @if($product->old_price && $product->old_price > $product->price)
                                            <span class="text-lg text-gray-500 line-through">
                                                TZS {{ number_format($product->old_price) }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($product->old_price && $product->old_price > $product->price)
                                        <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
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
                                                    class="w-full py-4 bg-gradient-to-r from-orange-600 to-orange-700 text-white font-black text-lg rounded-xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition duration-300 flex items-center justify-center gap-3">
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full py-4 bg-gray-200 text-gray-500 font-bold rounded-xl cursor-not-allowed">
                                            Out of Stock
                                        </button>
                                    @endif

                                    <a href="{{ route('show', $product->slug ?? $product->id) }}" class="p-4 bg-gray-100 rounded-xl hover:bg-orange-100 transition">
                                        View
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full text-center py-20">
                            <div class="w-32 h-32 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fa-solid fa-box-open text-6xl text-orange-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No Products Found</h3>
                            <p class="text-gray-600 mb-8">Try adjusting your search or filters.</p>
                            <a href="{{ route('products') }}" class="px-8 py-4 bg-orange-600 text-white font-bold rounded-xl hover:bg-orange-700 transition shadow-lg">
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

    <footer class="bg-gray-900 text-gray-400 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-xl font-bold text-white mb-2">Weru Hardware</p>
            <p class="text-lg">Tanzania's #1 Building Materials Supplier • Fast Delivery Nationwide</p>
            <p class="mt-6 text-sm">&copy; {{ date('Y') }} Weru Hardware. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>