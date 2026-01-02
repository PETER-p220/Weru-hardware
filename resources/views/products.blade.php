<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Premium Building Materials | Oweru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            gold: '#DAA520',
                            goldhover: '#B8860B',
                            dark: '#001529',
                            slate: '#0F172A'
                        }
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }
                }
            }
        }

        // Dark mode toggle
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('darkMode', isDark);
            
            // Update icon
            const icon = document.getElementById('theme-icon');
            icon.className = isDark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        }

        // Check saved preference on load
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-category-menu');
            menu.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }
    </script>

    <style>
        * { -webkit-tap-highlight-color: transparent; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        .dark ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #daa520; border-radius: 10px; }

        .product-card { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        
        @media (min-width: 1024px) {
            .product-card:hover { transform: translateY(-8px); }
            .dark .product-card:hover { border-color: #DAA520; }
            .product-card:hover { border-color: #DAA520; }
        }

        .glass-nav {
            backdrop-filter: blur(12px);
        }

        .dark .glass-nav {
            background: rgba(0, 21, 41, 0.9);
            border-bottom: 1px solid rgba(218, 165, 32, 0.1);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .hero-gradient {
            background: linear-gradient(to bottom, #f8fafc, #f1f5f9);
        }

        .dark .hero-gradient {
            background: radial-gradient(circle at top right, rgba(218, 165, 32, 0.1), transparent),
                        linear-gradient(to bottom, #001529, #0b0f1a);
        }

        .bottom-nav {
            backdrop-filter: blur(10px);
        }

        .dark .bottom-nav {
            background: rgba(15, 23, 42, 0.95);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .bottom-nav {
            background: rgba(255, 255, 255, 0.95);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-[#0b0f1a] text-gray-900 dark:text-slate-200 antialiased pb-20 lg:pb-0 transition-colors duration-300">

    <header class="glass-nav sticky top-0 z-50">
        <div class="max-w-[98%] mx-auto px-4 lg:px-6">
            <div class="flex items-center justify-between h-16 lg:h-20">
          <nav class="bg-white/95 backdrop-blur-lg border-b border-gray-200 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-8">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl font-extrabold text-gray-900">Oweru<span class="text-amber-600">Hardware</span></span>
                    </div>
                    <div class="hidden md:flex space-x-8 gap-8">
                        <a href="/" class="text-amber-600 font-bold transition">Home</a>
                        <a href="/products" class="text-gray-600 hover:text-amber-600 font-medium transition">Products</a>
                        <a href="/about" class="text-gray-600 hover:text-amber-600 font-medium transition">About Us</a>
                        <a href="/contact" class="text-gray-600 hover:text-amber-600 font-medium transition">Contact</a>
                    </div>
                </div> &nbsp; &nbsp; 
                <div class="flex items-center gap-2">
                    <!-- Sign In button - now visible on all screen sizes -->
                    <a href="/login" class="text-white font-semibold bg-amber-600 px-4 py-2 rounded-lg transition hover:bg-amber-700">Sign In</a>
                    <a href="/cart" class="relative bg-slate-800 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-bold flex items-center gap-2 shadow-lg hover:shadow-xl transition transform hover:scale-105">
                        <i class="fa-solid fa-cart-shopping w-5 h-5"></i>
                        <span class="hidden sm:inline">Cart</span>
                        <span class="absolute -top-2 -right-2 bg-amber-400 text-black text-xs font-extrabold rounded-full h-6 w-6 flex items-center justify-center ring-2 ring-white">{{ \App\Models\Cart::current()->totalItems() }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>


                <div class="flex items-center gap-3 lg:gap-4">
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="p-2 text-gray-600 dark:text-slate-300 hover:text-brand-gold transition rounded-lg hover:bg-gray-100 dark:hover:bg-white/5">
                        <i id="theme-icon" class="fa-solid fa-moon text-lg lg:text-xl"></i>
                    </button>
                    
                    <a href="{{ route('cart') }}" class="relative p-2 text-gray-600 dark:text-slate-300 hover:text-brand-gold transition">
                        <i class="fa-solid fa-cart-shopping text-lg lg:text-xl"></i>
                        <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">
                            {{ \App\Models\Cart::current()->totalItems() }}
                        </span>
                    </a>
                   
                </div>
            </div>
        </div>
    </header>

    <section class="hero-gradient pt-10 pb-16 lg:pt-16 lg:pb-24 border-b border-gray-200 dark:border-white/5">
        <div class="max-w-[98%] mx-auto px-4 lg:px-6 text-center lg:text-left">
            <div class="max-w-3xl">
                <span class="inline-block px-3 py-1 rounded-full bg-brand-gold/10 text-brand-gold text-[10px] lg:text-xs font-bold uppercase tracking-widest mb-4 border border-brand-gold/20">
                    Industry Grade Materials
                </span>
                <h1 class="text-3xl lg:text-6xl font-extrabold text-gray-900 dark:text-white mb-4 lg:mb-6 leading-tight">
                    Premium Inventory for <br class="hidden lg:block"><span class="text-brand-gold">Master Builders.</span>
                </h1>
                <p class="text-sm lg:text-lg text-gray-600 dark:text-slate-400 leading-relaxed mb-6 lg:mb-10 max-w-xl mx-auto lg:mx-0">
                    Sourcing the highest quality steel, cement, and electrical supplies across Tanzania.
                </p>
            </div>
        </div>
    </section>

    <main class="max-w-[98%] mx-auto px-2 lg:px-4 py-6 lg:py-8 -mt-8 lg:-mt-12">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            
            <aside class="hidden lg:block w-72 flex-shrink-0">
                <div class="bg-white dark:bg-brand-dark border border-gray-200 dark:border-white/10 rounded-2xl p-6 sticky top-28 shadow-sm">
                    <h3 class="text-gray-900 dark:text-white font-bold mb-6 flex items-center gap-2 text-sm uppercase tracking-wider">
                        <i class="fa-solid fa-layer-group text-brand-gold"></i>
                        Categories
                    </h3>
                    <div class="space-y-1">
                        <a href="{{ route('products') }}" class="flex items-center justify-between p-3 rounded-xl {{ !request('category') ? 'bg-brand-gold text-brand-dark font-bold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-white/5' }} transition">
                            <span>All Inventory</span>
                            <span class="text-xs opacity-70">{{ $products->total() }}</span>
                        </a>
                        @foreach($categories as $category)
                        <a href="{{ route('products', ['category' => $category->slug]) }}" class="flex items-center justify-between p-3 rounded-xl {{ request('category') == $category->slug ? 'bg-brand-gold/10 text-brand-gold border border-brand-gold/20' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-white/5' }} transition">
                            <span class="font-medium">{{ $category->name }}</span>
                            <span class="text-xs text-gray-400 dark:text-slate-600">{{ $category->products_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </aside>

            <section class="flex-grow">
                <div class="bg-white dark:bg-brand-dark/50 border border-gray-200 dark:border-white/5 rounded-2xl p-3 lg:p-4 mb-6 lg:mb-8 flex gap-2 lg:gap-4 items-center shadow-sm">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-slate-500 text-sm"></i>
                        <input type="text" placeholder="Search..." class="w-full bg-gray-50 dark:bg-slate-900/50 border border-gray-200 dark:border-white/10 rounded-xl py-2.5 lg:py-3 pl-11 pr-4 text-sm text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-brand-gold transition">
                    </div>
                    <button onclick="toggleMobileMenu()" class="lg:hidden bg-brand-gold/10 border border-brand-gold/20 text-brand-gold p-2.5 rounded-xl">
                        <i class="fa-solid fa-sliders"></i>
                    </button>
                    <select class="hidden md:block bg-gray-50 dark:bg-slate-900/50 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-slate-300 outline-none">
                        <option>Sort: Newest</option>
                        <option>Price: Low-High</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4 lg:gap-6">
                    @foreach($products as $product)
                    <div class="product-card group bg-white dark:bg-brand-dark border border-gray-200 dark:border-white/5 rounded-xl lg:rounded-2xl overflow-hidden flex flex-col h-full shadow-sm">
                        
                        <div class="relative aspect-square overflow-hidden bg-gray-100 dark:bg-[#161b22]">
                            <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $product->name }}">
                            
                            <div class="absolute top-2 left-2 lg:top-3 lg:left-3">
                                <span class="bg-white/90 dark:bg-brand-dark/90 backdrop-blur-md text-brand-gold text-[9px] lg:text-[10px] font-bold px-2 py-0.5 rounded border border-brand-gold/30">
                                    {{ $product->category->name ?? 'Material' }}
                                </span>
                            </div>

                            <div class="hidden lg:flex absolute inset-0 bg-black/60 dark:bg-brand-dark/60 opacity-0 group-hover:opacity-100 transition-all duration-300 items-center justify-center backdrop-blur-[2px]">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-brand-gold text-brand-dark h-11 px-6 rounded-full font-bold text-sm transform translate-y-4 group-hover:translate-y-0 transition-all shadow-xl">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="p-3 lg:p-5 flex flex-col flex-1">
                            <h3 class="text-gray-900 dark:text-white font-bold text-sm lg:text-base mb-1 line-clamp-1 group-hover:text-brand-gold transition-colors">
                                {{ $product->name }}
                            </h3>
                            <p class="text-gray-500 dark:text-slate-500 text-[11px] lg:text-xs mb-3 lg:mb-4 line-clamp-2">
                                {{ $product->description }}
                            </p>
                            
                            <div class="mt-auto flex items-end justify-between">
                                <div>
                                    <p class="text-[9px] text-gray-400 dark:text-slate-500 uppercase font-bold tracking-widest mb-0.5">Price</p>
                                    <p class="text-base lg:text-lg font-black text-gray-900 dark:text-white leading-none">
                                        <span class="text-brand-gold text-[10px] lg:text-sm mr-0.5">TZS</span>{{ number_format($product->price) }}
                                    </p>
                                </div>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="lg:hidden">
                                    @csrf
                                    <button type="submit" class="w-9 h-9 bg-brand-gold text-brand-dark rounded-lg flex items-center justify-center shadow-lg active:scale-95 transition-transform">
                                        <i class="fa-solid fa-plus text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-12 mb-20 lg:mb-0 lg:py-8 border-t border-gray-200 dark:border-white/5">
                    {{ $products->links() }}
                </div>
            </section>
        </div>
    </main>

    <div id="mobile-category-menu" class="fixed inset-0 z-[60] bg-white dark:bg-brand-dark hidden">
        <div class="p-6 h-full flex flex-col">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-gray-900 dark:text-white font-bold text-xl uppercase tracking-widest">Categories</h3>
                <button onclick="toggleMobileMenu()" class="text-gray-500 dark:text-slate-400 text-2xl"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="flex-grow overflow-y-auto space-y-4">
                <a href="{{ route('products') }}" class="block p-4 bg-brand-gold text-brand-dark rounded-xl font-bold">All Inventory</a>
                @foreach($categories as $category)
                <a href="{{ route('products', ['category' => $category->slug]) }}" class="block p-4 bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-slate-300 rounded-xl font-medium border border-gray-200 dark:border-white/5">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="lg:hidden bottom-nav fixed bottom-0 left-0 right-0 z-50 h-16 flex items-center justify-around px-4">
        <a href="/" class="flex flex-col items-center gap-1 text-gray-500 dark:text-slate-400">
            <i class="fa-solid fa-house text-lg"></i>
            <span class="text-[9px] font-bold uppercase tracking-widest">Home</span>
        </a>
        <button onclick="toggleMobileMenu()" class="flex flex-col items-center gap-1 text-brand-gold">
            <i class="fa-solid fa-layer-group text-lg"></i>
            <span class="text-[9px] font-bold uppercase tracking-widest">Filter</span>
        </button>
        <a href="{{ route('cart') }}" class="relative flex flex-col items-center gap-1 text-gray-500 dark:text-slate-400">
            <i class="fa-solid fa-cart-shopping text-lg"></i>
            <span class="text-[9px] font-bold uppercase tracking-widest">Cart</span>
            <span class="absolute -top-1 right-0 bg-red-500 text-white text-[8px] px-1 rounded-full">{{ \App\Models\Cart::current()->totalItems() }}</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-gray-500 dark:text-slate-400">
            <i class="fa-solid fa-user text-lg"></i>
            <span class="text-[9px] font-bold uppercase tracking-widest">Profile</span>
        </a>
    </div>
    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12 mt-16 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="flex items-center justify-center gap-2 mb-4">
                <i class="fas fa-hard-hat text-2xl" style="color: rgb(218, 165, 32);"></i>
                <p class="text-xl font-bold text-white">Oweru Hardware</p>
            </div>
            <p class="text-gray-400 mb-2">Tanzania's Premier Building Materials Supplier</p>

        </div>
    </footer>
</body>
</html>