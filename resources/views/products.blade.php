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
            }, 2000);
        }
    </script>
    <style>
        .product-card { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px -12px rgba(59, 130, 246, 0.2), 0 0 0 1px rgba(59, 130, 246, 0.1); }
        .category-chip.active { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
        .badge-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .7; } }
        .search-focus:focus-within { box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <!-- Success Notification (when item added) -->
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
                            <span class="text-xl font-extrabold text-gray-900">Weru<span class="text-blue-600">Hardware</span></span>
                        </a>
                    </div>
                    <div class="hidden md:flex md:space-x-1">
                        <a href="{{ route('indexProduct') }}" class="px-4 py-2 rounded-lg bg-blue-50 text-blue-700 font-semibold text-sm">Products</a>
                        <a href="#" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium text-sm transition-colors">About</a>
                        <a href="#" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium text-sm transition-colors">Contact</a>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-gray-100 rounded-lg">
                            <div class="w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-bold">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ Str::limit(Auth::user()->name ?? 'User', 15) }}</span>
                        </div>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="hidden md:inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Sign In
                        </a>
                    @endguest
                    <a href="{{ route('cart') }}" class="relative inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all hover:shadow-lg font-semibold text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="hidden sm:inline">Cart</span>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">
                            {{ count(session('cart', [])) }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex flex-col items-center md:items-start">
                    <div class="mb-4 flex justify-center">
                        <div class="bg-white rounded-full p-2 shadow-lg flex items-center justify-center" style="height:72px;width:72px;">
                            <img src="images\IMG-20251114-WA0007.jpg" alt="Weru Hardware Logo" class="h-20 w-24 object-contain" />
                        </div>
                    </div>
                    <h1 class="text-4xl font-extrabold tracking-tight mb-2 text-center md:text-left">
                        Products Catalog
                        <span class="inline-block ml-2">Construction</span>
                    </h1>
                    <p class="text-lg text-blue-100 text-center md:text-left">
                        Browse and order from <strong>{{ $totalProducts ?? 0 }}+ certified</strong> building materials
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-blue-700 rounded-lg hover:bg-blue-50 font-semibold text-sm transition-all hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Catalog
                    </button>
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <button onclick="toggleSidebar()" class="lg:hidden w-full flex items-center justify-center gap-2 mb-4 px-4 py-3 bg-blue-600 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-700 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    Filter Categories
                </button>

                <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

                <div id="category-sidebar" class="fixed top-0 right-0 h-full w-80 bg-white p-6 shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out z-50 lg:relative lg:translate-x-0 lg:w-full lg:rounded-2xl lg:border lg:border-gray-200 lg:sticky lg:top-24">
                    <div class="flex justify-between items-center mb-6 lg:hidden">
                        <h3 class="text-xl font-bold text-gray-900">Filter Categories</h3>
                        <button onclick="toggleSidebar()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="hidden lg:flex items-center gap-2 mb-6">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-900">Categories</h3>
                    </div>

                    <div class="space-y-2">
                        <a href="{{ route('indexProduct') }}"
                           class="flex items-center justify-between p-3.5 rounded-xl transition-all {{ request()->query('category') ? 'hover:bg-gray-50 text-gray-700' : 'category-chip active text-white' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                <span class="font-semibold">All Products</span>
                            </div>
                            <span class="px-2.5 py-0.5 {{ request()->query('category') ? 'bg-gray-100 text-gray-600' : 'bg-blue-500 text-white' }} text-xs font-bold rounded-full">
                                {{ $totalProducts ?? 0 }}
                            </span>
                        </a>

                        @foreach(\App\Models\Categories::withCount('products')->orderBy('name')->get() as $category)
                            <a href="{{ route('indexProduct', ['category' => $category->slug]) }}"
                               class="flex items-center justify-between p-3.5 rounded-xl transition-all {{ request()->query('category') === $category->slug ? 'category-chip active text-white' : 'hover:bg-gray-50 text-gray-700' }}">
                                <span class="font-medium">{{ $category->name }}</span>
                                <span class="px-2.5 py-0.5 {{ request()->query('category') === $category->slug ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600' }} text-xs font-bold rounded-full">
                                    {{ $category->products_count }}
                                </span>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Quick Stats</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>In Stock</span>
                                <span class="font-semibold text-green-600">{{ $totalProducts ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Categories</span>
                                <span class="font-semibold">{{ \App\Models\Categories::count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <section class="lg:col-span-3">
                <!-- Search Bar -->
                <div class="bg-white rounded-2xl border border-gray-200 p-4 mb-6 sticky top-20 z-30 shadow-sm">
                    <form action="{{ route('indexProduct') }}" method="GET">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="flex gap-2 search-focus rounded-xl">
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="search" name="search" value="{{ request('search') }}"
                                       placeholder="Search for cement, steel bars, paint..."
                                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all hover:shadow-lg">
                                Search
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Results Info -->
                <div class="mb-6 flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        Showing <span class="font-semibold text-gray-900">{{ $products->count() }}</span> products
                    </p>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($products as $product)
                        <article class="product-card bg-white rounded-2xl overflow-hidden group border border-gray-200">
                            <div class="relative aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <svg class="w-24 h-24 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zM4 6v8.586l3.293-3.293a1 1 0 011.414 0l2.586 2.586L16.293 8.293a1 1 0 011.414 0l2.293 2.293V6H4z"/>
                                    </svg>
                                @endif

                                <div class="absolute top-3 left-3">
                                    @if($product->stock > 0)
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg">
                                            <span class="w-1.5 h-1.5 bg-white rounded-full badge-pulse"></span>
                                            In Stock
                                        </span>
                                    @else
                                        <span class="px-3 py-1.5 bg-red-500 text-white text-xs font-bold rounded-full shadow-lg">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>

                                @if($product->min_order)
                                    <div class="absolute top-3 right-3 px-2.5 py-1 bg-blue-600 text-white text-xs font-bold rounded-full shadow-lg">
                                        Min: {{ $product->min_order }}
                                    </div>
                                @endif
                            </div>

                            <div class="p-5">
                                <div class="mb-3">
                                    <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg">
                                        {{ $product->categories?->name ?? 'Uncategorized' }}
                                    </span>
                                </div>

                                <a href="#" class="block mb-3">
                                    <h3 class="text-lg font-bold text-gray-900 line-clamp-2 transition-colors group-hover:text-blue-600 leading-snug">
                                        {{ $product->name }}
                                    </h3>
                                </a>

                                <p class="text-sm text-gray-600 mb-4 line-clamp-2 leading-relaxed">
                                    {{ Str::limit($product->description, 80) }}
                                </p>

                                <div class="flex items-baseline gap-2 mb-5 pb-4 border-t border-gray-100 pt-4">
                                    <p class="text-3xl font-extrabold text-gray-900">
                                        {{ number_format($product->price) }}
                                    </p>
                                    <p class="text-sm text-gray-500">TZS / {{ $product->unit ?? 'unit' }}</p>
                                </div>

                                <div class="flex items-center gap-2">
                                    @if($product->stock > 0)
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" onclick="showCartNotification()"
                                                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all hover:shadow-lg">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="flex-1 px-4 py-3 bg-gray-100 text-gray-400 font-semibold rounded-xl cursor-not-allowed">
                                            Out of Stock
                                        </button>
                                    @endif

                                    <a href="#" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full bg-white rounded-2xl p-12 text-center border-2 border-dashed border-gray-300">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No Products Found</h3>
                            <p class="text-gray-600 mb-6">Try adjusting your search or filter.</p>
                            <a href="{{ route('indexProduct') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                                Clear Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                @if(isset($products) && method_exists($products, 'links'))
                    <div class="mt-8">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            </section>
        </div>
    </main>

    
    <footer class="bg-gray-800 mt-12 text-gray-400 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Weru Hardware. All rights reserved.</p>
            <p class="mt-1 text-sm">Quality building materials delivered fast in Tanzania.</p>
        </div>
    </footer>
</body>
</html>