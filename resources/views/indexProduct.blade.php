@php
    $products = $products ?? App\Models\Product::with('category')->latest()->paginate(15);
@endphp

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Products • Oweru Hardware Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        slate: {
                            50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1',
                            400: '#94a3b8', 500: '#64748b', 600: '#475569', 700: '#334155',
                            800: '#1e293b', 900: '#0f172a', 950: '#020617'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .text-2xs { font-size: 0.625rem; line-height: 0.875rem; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.12); }
        .toast { animation: slideDown 0.5s ease-out; opacity: 1; transition: opacity 0.5s; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        .table-row:hover { background-color: #f8fafc; }

        /* Mobile: Table → Clean Cards */
        @media (max-width: 768px) {
            .products-table thead { display: none; }
            .products-table tbody, .products-table tr, .products-table td { display: block; width: 100%; }
            .products-table tr {
                background: white;
                border-radius: 1rem;
                overflow: hidden;
                box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
                border: 1px solid #e2e8f0;
                margin-bottom: 1rem;
            }
            .products-table td {
                padding: 1rem;
                border-bottom: 1px solid #f1f5f9;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .products-table td:last-child { border: none; }
            .products-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #334155;
                text-transform: uppercase;
                font-size: 0.7rem;
                letter-spacing: 0.05em;
            }
            .action-buttons { justify-content: flex-end !important; gap: 1rem; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-slate-50 min-h-screen">

    <!-- Mobile Menu Button -->
    <button id="menu-btn" class="fixed top-4 left-4 z-50 lg:hidden bg-white/90 rounded-full p-3.5 shadow-xl border border-slate-300 flex items-center justify-center hover:bg-white transition">
        <i class="fa-solid fa-bars text-slate-800 text-xl"></i>
    </button>
    <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <!-- Success Toast -->
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl text-sm font-medium flex items-center gap-3 toast">
            <i class="fa-solid fa-check-circle text-xl"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Sidebar – Always shows full text -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl border-r border-slate-200 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Oweru<span class="text-slate-700">Hardware</span></h1>
                    <p class="text-2xs text-slate-500">Admin Panel</p>
                </div>
            </div>
        </div>

        <nav class="p-4 space-y-1">
            <a href="{{ route('adminDashboard') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-gauge-high w-5"></i> Dashboard
            </a>
            <a href="{{ route('indexProduct') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl bg-gradient-to-r from-slate-800 to-slate-900 text-white shadow-md text-sm font-medium">
                <i class="fa-solid fa-boxes-stacked w-5"></i> Products
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-tags w-5"></i> Categories
            </a>
            <a href="/OrderManagement" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-shopping-bag w-5"></i> Orders
            </a>
            <a href="{{ route('user') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-users w-5"></i> Users
            </a>
            <a href="{{ route('ads') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-bullhorn w-5"></i> Advertisements
            </a>
            <a href="{{ route('contact.messages') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-100 rounded-xl transition touch-feedback">
                <i class="fa-solid fa-envelope w-5"></i>
                <span>Contact Messages</span>
            </a>

        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-5 border-t border-slate-200 bg-slate-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-slate-800 to-slate-900 rounded-full flex items-center justify-center text-white font-bold shadow">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) : 'AD' }}
                </div>
                <div>
                    <p class="font-semibold text-slate-800 text-sm">{{ auth()->check() ? Str::limit(auth()->user()->name, 15) : 'Admin' }}</p>
                    <p class="text-2xs text-slate-500">Administrator</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-72 min-h-screen">
        <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-6 py-5 lg:px-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Products Management</h2>
                    <p class="text-sm text-slate-500 mt-1">Manage your entire product inventory</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('createProduct') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-slate-800 to-slate-900 text-white font-semibold rounded-xl hover:shadow-lg hover-lift transition text-sm">
                        <i class="fa-solid fa-plus"></i>
                        Add New Product
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-slate-600 hover:text-slate-800">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <div class="p-5 lg:p-8 max-w-7xl mx-auto">

            <!-- Breadcrumb -->
            <div class="mb-6 text-sm text-slate-500">
                <div class="flex items-center gap-2">
                    <a href="{{ route('adminDashboard') }}" class="hover:text-slate-800 font-medium">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <span class="text-slate-800 font-bold">Products</span>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center hover-lift transition">
                    <i class="fa-solid fa-boxes-stacked text-3xl text-slate-700 mb-3"></i>
                    <p class="text-3xl font-bold text-slate-900">{{ $products->total() }}</p>
                    <p class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Total Products</p>
                </div>
                <div class="bg-white rounded-2xl border border-emerald-200 p-6 text-center hover-lift transition">
                    <i class="fa-solid fa-check-circle text-3xl text-emerald-600 mb-3"></i>
                    <p class="text-3xl font-bold text-slate-900">{{ $products->where('is_active', 1)->count() }}</p>
                    <p class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Active</p>
                </div>
                <div class="bg-white rounded-2xl border border-purple-200 p-6 text-center hover-lift transition">
                    <i class="fa-solid fa-star text-3xl text-purple-600 mb-3"></i>
                    <p class="text-3xl font-bold text-slate-900">{{ $products->where('is_featured', 1)->count() }}</p>
                    <p class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Featured</p>
                </div>
                <div class="bg-white rounded-2xl border border-orange-200 p-6 text-center hover-lift transition">
                    <i class="fa-solid fa-triangle-exclamation text-3xl text-orange-600 mb-3"></i>
                    <p class="text-3xl font-bold text-slate-900">
                        {{ $products->where('stock', '<', 10)->where('stock', '>', 0)->count() }}
                    </p>
                    <p class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Low Stock</p>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">All Products</h3>
                        <p class="text-sm text-slate-500 mt-1">{{ $products->total() }} products found</p>
                    </div>
                    <a href="{{ route('createProduct') }}" class="text-sm font-medium text-slate-600 hover:text-slate-800">
                        <i class="fa-solid fa-plus mr-1"></i> Add Product
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full products-table">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($products as $product)
                                <tr class="table-row transition-colors">
                                    <td data-label="Product" class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                     class="w-12 h-12 rounded-xl object-cover shadow-sm">
                                            @else
                                                <div class="w-12 h-12 bg-slate-200 rounded-xl flex items-center justify-center">
                                                    <i class="fa-solid fa-box text-slate-400"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-bold text-slate-900">{{ $product->name }}</p>
                                                <p class="text-xs text-slate-500">{{ $product->unit ?? '' }}</p>
                                                @if($product->is_featured)
                                                    <span class="inline-block mt-1 px-2 py-0.5 text-xs font-bold bg-purple-100 text-purple-700 rounded-full">Featured</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Category" class="px-6 py-5">
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-slate-100 text-slate-700">
                                            {{ $product->category?->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td data-label="Price" class="px-6 py-5">
                                        <p class="font-bold text-slate-900">TZS {{ number_format($product->price) }}</p>
                                        @if($product->old_price && $product->old_price > $product->price)
                                            <p class="text-xs text-slate-500 line-through">TZS {{ number_format($product->old_price) }}</p>
                                        @endif
                                    </td>
                                    <td data-label="Stock" class="px-6 py-5">
                                        @if($product->stock > 10)
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700">
                                                {{ $product->stock }} in stock
                                            </span>
                                        @elseif($product->stock > 0)
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-700">
                                                {{ $product->stock }} low
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">
                                                Out of stock
                                            </span>
                                        @endif
                                    </td>
                                    <td data-label="Status" class="px-6 py-5">
                                        <span class="px-3 py-1 text-xs font-bold rounded-full {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td data-label="Actions" class="px-6 py-5 text-center action-buttons">
                                        <div class="flex items-center justify-center gap-4">
                                            <a href="{{ route('editProduct', $product->id) }}" class="text-slate-600 hover:text-slate-900 transition">
                                                <i class="fa-solid fa-pen-to-square text-lg"></i>
                                            </a>
                                            <form action="{{ route('deleteProduct', $product->id) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Delete {{ addslashes($product->name) }} permanently?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                                    <i class="fa-solid fa-trash text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center text-slate-500">
                                        <i class="fa-solid fa-box-open text-5xl mb-4 text-slate-300"></i>
                                        <p class="text-lg font-medium">No products found</p>
                                        <a href="{{ route('createProduct') }}" class="mt-4 inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-800 to-slate-900 text-white font-semibold rounded-xl hover:shadow-lg transition">
                                            <i class="fa-solid fa-plus"></i>
                                            Add First Product
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                    {{ $products->onEachSide(2)->links() }}
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('menu-btn')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('mobile-overlay').classList.toggle('hidden');
        });

        document.getElementById('mobile-overlay')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('mobile-overlay').classList.add('hidden');
        });

        // Auto-hide toast
        setTimeout(() => {
            const toast = document.querySelector('.toast');
            if (toast) toast.style.opacity = '0';
        }, 5000);
    </script>
</body>
</html>