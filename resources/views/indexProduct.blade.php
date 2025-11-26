{{-- resources/views/products/index.blade.php --}}
@php
    $products = $products ?? App\Models\Product::with('category')->paginate(15);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products • Weru Hardware Admin</title>
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
        .text-2xs { font-size: 0.625rem; line-height: 0.875rem; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 25px -6px rgba(255,107,53,0.18); }
        .table-row:hover { background-color: #fff7f0; }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-light via-white to-orange-50 min-h-screen">

    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3 rounded-xl shadow-lg text-xs font-medium flex items-center gap-2 animate-pulse">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl border-r border-orange-100 z-50">
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
            <a href="{{ route('adminDashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-gauge-high w-4 h-4"></i>
                <span class="text-xs font-medium">Dashboard</span>
            </a>
            <a href="{{ route('indexProduct') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-gradient-to-r from-primary to-primary-dark text-white shadow-sm">
                <i class="fa-solid fa-boxes-stacked w-4 h-4"></i>
                <span class="text-xs font-medium">Products</span>
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-tags w-4 h-4"></i>
                <span class="text-xs font-medium">Categories</span>
            </a>
            <a href="/OrderManagement" class="flex-link">
                <i class="fa-solid fa-shopping-bag w-4 h-4"></i>
                <span class="text-xs font-medium">Orders</span>
            </a>
            <a href="{{ route('user') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-users w-4 h-4"></i>
                <span class="text-xs font-medium">Users</span>
            </a>
        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-5 border-t border-orange-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center text-white text-xs font-bold shadow">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) : 'G' }}
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-800">
                        {{ auth()->check() ? (auth()->user()->name ?? 'Admin') : 'Guest' }}
                    </p>
                    <p class="text-2xs text-gray-500">
                        {{ auth()->check() ? (auth()->user()->hasRole('admin') ? 'Administrator' : 'User') : 'Not Logged In' }}
                    </p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        <header class="bg-white border-b border-orange-100 sticky top-0 z-40 shadow-sm">
            <div class="flex items-center justify-between px-8 py-5">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Products Management</h2>
                    <p class="text-2xs text-gray-500 mt-0.5">Manage your entire product catalog</p>
                </div>
                <div class="flex items-center gap-6">
                    <a href="{{ route('createProduct') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold rounded-xl shadow-lg hover:shadow-xl hover-lift transition">
                        <i class="fa-solid fa-plus"></i>
                        Add New Product
                    </a>
                    @if(auth()->check())
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-gray-600 hover:text-primary font-medium">Logout</button>
                        </form>
                    @endif
                </div>
            </div>
        </header>

        <div class="p-8 max-w-7xl mx-auto">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl border border-orange-100 p-6 hover-lift transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-2xs font-bold text-gray-500 uppercase">Total Products</span>
                        <i class="fa-solid fa-boxes-stacked text-primary text-lg"></i>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $products->total() }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-orange-100 p-6 hover-lift transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-2xs font-bold text-gray-500 uppercase">Active</span>
                        <i class="fa-solid fa-check-circle text-green-600 text-lg"></i>
                    </div>
                    <p class="text-2xl font-bold text-green-600">{{ $products->where('is_active', 1)->count() }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-orange-100 p-6 hover-lift transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-2xs font-bold text-gray-500 uppercase">Featured</span>
                        <i class="fa-solid fa-star text-purple-600 text-lg"></i>
                    </div>
                    <p class="text-2xl font-bold text-purple-600">{{ $products->where('is_featured', 1)->count() }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-orange-100 p-6 hover-lift transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-2xs font-bold text-gray-500 uppercase">Low Stock</span>
                        <i class="fa-solid fa-triangle-exclamation text-orange-600 text-lg"></i>
                    </div>
                    <p class="text-2xl font-bold text-orange-600">
                        {{ $products->where('stock', '<', 10)->where('stock', '>', 0)->count() }}
                    </p>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-orange-100">
                    <h3 class="text-sm font-bold text-gray-800">All Products ({{ $products->total() }})</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-orange-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-2xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-orange-50">
                            @forelse($products as $product)
                            <tr class="table-row transition-all">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-xl object-cover shadow-sm">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-xl flex items-center justify-center">
                                                <i class="fa-solid fa-box text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $product->name }}</p>
                                            <p class="text-2xs text-gray-500">{{ $product->unit ?? '' }}</p>
                                            @if($product->is_featured)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-2xs font-bold bg-purple-100 text-purple-700 mt-1">Featured</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1 text-2xs font-bold text-primary bg-orange-100 rounded-full">
                                        {{ $product->category?->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-bold text-gray-900">TZS {{ number_format($product->price) }}</p>
                                    @if($product->old_price && $product->old_price > $product->price)
                                        <p class="text-2xs text-gray-500 line-through">TZS {{ number_format($product->old_price) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    @if($product->stock > 10)
                                        <span class="px-3 py-1 text-2xs font-bold text-green-700 bg-green-100 rounded-full">{{ $product->stock }} in stock</span>
                                    @elseif($product->stock > 0)
                                        <span class="px-3 py-1 text-2xs font-bold text-orange-700 bg-orange-100 rounded-full">{{ $product->stock }} low</span>
                                    @else
                                        <span class="px-3 py-1 text-2xs font-bold text-red-700 bg-red-100 rounded-full">Out of stock</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <span class="{{ $product->is_active ? 'text-green-700 bg-green-100' : 'text-gray-700 bg-gray-100' }} px-3 py-1 text-2xs font-bold rounded-full">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('editProduct', $product->id) }}" class="text-xs text-primary hover:text-primary-dark font-bold">
                                            Edit
                                        </a>
                                        <form action="{{ route('deleteProduct', $product->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Delete {{ addslashes($product->name) }} permanently?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-bold">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <i class="fa-solid fa-box-open text-6xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 font-medium">No products yet</p>
                                    <a href="{{ route('createProduct') }}" class="mt-4 inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold rounded-xl hover-lift transition">
                                        <i class="fa-solid fa-plus"></i>
                                        Add Your First Product
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($products->hasPages())
                <div class="bg-orange-50 px-6 py-5 border-t border-orange-100">
                    {{ $products->links('pagination::tailwind') }}
                </div>
                @endif
            </div>
        </div>
    </main>

    <footer class="ml-64 bg-white border-t border-orange-100 py-6">
        <div class="px-8 text-center text-2xs text-gray-500">
            © {{ date('Y') }} Weru Hardware • Built with passion in Tanzania
        </div>
    </footer>
</body>
</html>