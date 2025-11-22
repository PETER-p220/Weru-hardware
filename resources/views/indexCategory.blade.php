<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Weru Hardware Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#f97316',
                        secondary: '#fbbf24'
                    }
                }
            }
        }
    </script>
    <style>
        .category-card { transition: all 0.3s ease; }
        .category-card:hover { transform: translateY(-8px); box-shadow: 0 20px 30px rgba(249, 115, 22, 0.15); }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-orange-700 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-hard-hat text-white text-2xl"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-extrabold text-gray-900">Weru<span class="text-primary">Hardware</span></span>
                        <p class="text-xs text-gray-500 font-medium">Admin Panel</p>
                    </div>
                </div>

                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('adminDashboard') }}" class="text-gray-600 hover:text-primary font-medium transition">Dashboard</a>
                    <a href="{{ route('indexProduct') }}" class="text-gray-600 hover:text-primary font-medium transition">Products</a>
                    <a href="{{ route('indexCategory') }}" class="text-primary font-bold border-b-3 border-primary pb-1">Categories</a>
                    <a href="{{ route('ads') }}" class="text-gray-600 hover:text-primary font-medium transition">Advertisements</a>
                </nav>

                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-700">Admin</span>
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold">AD</div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-black text-gray-900">Manage Categories</h1>
                <p class="text-lg text-gray-600 mt-2">Organize your products with beautiful icons and perfect order</p>
            </div>
            <a href="{{ route('createCategory') }}" 
               class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-primary to-orange-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                <i class="fa-solid fa-plus text-xl"></i>
                Add New Category
            </a>
        </div>

        <!-- Success / Error Messages -->
        @if(session('success'))
            <div class="mb-8 bg-green-50 border-2 border-green-300 text-green-800 px-6 py-5 rounded-2xl flex items-center gap-4 shadow-md">
                <i class="fa-solid fa-check-circle text-3xl"></i>
                <div>
                    <p class="font-bold text-lg">Success!</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 bg-red-50 border-2 border-red-300 text-red-800 px-6 py-5 rounded-2xl flex items-center gap-4 shadow-md">
                <i class="fa-solid fa-exclamation-triangle text-3xl"></i>
                <div>
                    <p class="font-bold text-lg">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Categories Grid -->
        @if($categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($categories as $category)
                <div class="category-card bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden group">
                    <div class="p-8 text-center">
                        <div class="mb-6">
                            @if($category->icon && !str_starts_with($category->icon, 'fa-'))
                                <div class="text-6xl mb-4">{{ $category->icon }}</div>
                            @elseif($category->icon)
                                <i class="{{ $category->icon }} text-6xl text-primary mb-4"></i>
                            @else
                                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-primary/20 to-orange-300 rounded-2xl flex items-center justify-center">
                                    <i class="fa-solid fa-layer-group text-primary text-3xl"></i>
                                </div>
                            @endif
                            <h3 class="text-2xl font-black text-gray-900 mt-4 group-hover:text-primary transition">
                                {{ $category->name }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">Display Order: {{ $category->order ?? '—' }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-orange-50 rounded-xl p-4">
                                <p class="text-xs text-gray-600 font-medium">Products</p>
                                <p class="text-2xl font-bold text-primary">{{ $category->products_count ?? 0 }}</p>
                            </div>
                            <div class="bg-green-50 rounded-xl p-4">
                                <p class="text-xs text-gray-600 font-medium">Active</p>
                                <p class="text-2xl font-bold text-green-600">{{ $category->active_products_count ?? 0 }}</p>
                            </div>
                        </div>

                        <div class="text-center mb-6">
                            <p class="text-xs text-gray-500">URL Slug</p>
                            <code class="text-sm font-mono bg-gray-100 px-3 py-1 rounded-lg text-primary">{{ $category->slug }}</code>
                        </div>

                        <div class="flex gap-3">
                            <a href="#" 
                               class="flex-1 py-3 bg-primary/10 text-primary font-bold rounded-xl hover:bg-primary hover:text-white transition">
                                View
                            </a>
                            <a href="#" 
                               class="flex-1 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition">
                                Edit
                            </a>
                        </div>

                        <form method="POST" action="#" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('⚠️ Delete {{ $category->name }}?\n\nThis will also delete ALL products in this category!')"
                                class="w-full py-3 text-red-600 font-bold rounded-xl border-2 border-red-200 hover:bg-red-50 transition
                                {{ ($category->products_count ?? 0) > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ ($category->products_count ?? 0) > 0 ? 'disabled' : '' }}>
                                <i class="fa-solid fa-trash mr-2"></i> Delete
                            </button>
                            @if(($category->products_count ?? 0) > 0)
                                <p class="text-xs text-red-600 text-center mt-2">
                                    Remove all products first
                                </p>
                            @endif
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Summary Stats -->
            <div class="mt-12 bg-gradient-to-r from-primary/5 to-orange-50 rounded-3xl p-8 border-2 border-primary/20">
                <h2 class="text-2xl font-black text-gray-900 mb-6 text-center">Category Summary</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div>
                        <p class="text-5xl font-black text-primary">{{ $categories->count() }}</p>
                        <p class="text-lg font-bold text-gray-700 mt-2">Total Categories</p>
                    </div>
                    <div>
                        <p class="text-5xl font-black text-green-600">{{ $categories->sum('products_count') }}</p>
                        <p class="text-lg font-bold text-gray-700 mt-2">Total Products</p>
                    </div>
                    <div>
                        <p class="text-5xl font-black text-purple-600">
                            {{ $categories->count() > 0 ? round($categories->sum('products_count') / $categories->count(), 1) : 0 }}
                        </p>
                        <p class="text-lg font-bold text-gray-700 mt-2">Avg Products / Category</p>
                    </div>
                </div>
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-32 h-32 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-8">
                    <i class="fa-solid fa-folder-open text-6xl text-gray-400"></i>
                </div>
                <h3 class="text-3xl font-black text-gray-900 mb-4">No Categories Yet</h3>
                <p class="text-xl text-gray-600 mb-8">Start organizing your products into beautiful categories</p>
                <a href="{{ route('createCategory') }}" 
                   class="inline-flex items-center gap-3 px-10 py-5 bg-gradient-to-r from-primary to-orange-700 text-white font-bold text-xl rounded-xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all">
                    <i class="fa-solid fa-plus"></i>
                    Create Your First Category
                </a>
            </div>
        @endif

    </main>

    <footer class="bg-white border-t border-gray-200 mt-20 py-8">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-sm text-gray-600">© {{ date('Y') }} Weru Hardware Tanzania • Built with passion in Dar es Salaam</p>
        </div>
    </footer>
</body>
</html>