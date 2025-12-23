<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Category • Oweru Hardware Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
        * { 
            -webkit-tap-highlight-color: transparent;
            box-sizing: border-box;
        }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #64748b; border-radius: 4px; }
        .hover-lift:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 12px 24px rgba(15,23,42,0.12); 
        }
        .text-2xs { font-size: 0.625rem; line-height: 0.875rem; }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .toast { animation: slideDown 0.5s ease-out; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen overflow-x-hidden">

    <!-- Mobile Menu Button -->
    <button id="menu-btn" class="fixed top-4 left-4 z-50 lg:hidden bg-white/90 rounded-full p-3.5 shadow-xl border border-slate-300 flex items-center justify-center hover:bg-white transition">
        <i class="fa-solid fa-bars text-slate-800 text-xl"></i>
    </button>
    <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-slate-800 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 toast">
            <i class="fa-solid fa-check-circle text-lg"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 toast">
            <i class="fa-solid fa-exclamation-circle text-lg"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Sidebar -->
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
            <a href="{{ route('indexProduct') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-boxes-stacked w-5"></i> Products
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl bg-gradient-to-r from-slate-800 to-slate-900 text-white shadow-md text-sm font-medium">
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

    <main class="lg:pl-72 min-h-screen">
        <header class="bg-white sticky top-0 z-40 shadow-sm border-b border-slate-200">
            <div class="px-4 lg:px-8 py-4 lg:py-5 flex items-center justify-between">
                <div class="pl-12 lg:pl-0">
                    <div class="flex items-center gap-2 text-sm text-slate-600 mb-2">
                        <a href="{{ route('indexCategory') }}" class="hover:text-slate-900 font-medium">Categories</a>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                        <span class="text-slate-900 font-semibold">Edit: {{ Str::limit($category->name, 40) }}</span>
                    </div>
                    <h2 class="text-xl lg:text-2xl font-bold text-slate-900">Edit Category</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Update category information</p>
                </div>
                <div class="flex items-center gap-4">
                    <form method="POST" action="{{ route('logout') }}">@csrf 
                        <button class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-slate-900 hover:bg-slate-100 rounded-lg">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8 max-w-6xl mx-auto">
            <form method="POST" action="{{ route('updateCategory', $category) }}" class="space-y-6 lg:space-y-8">
                @csrf
                @method('PATCH')
                
                <!-- Category Information -->
                <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm border border-slate-200 p-5 lg:p-8 hover-lift transition">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 bg-slate-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-tags text-slate-700 text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg lg:text-xl font-bold text-slate-900">Category Information</h3>
                            <p class="text-xs lg:text-sm text-slate-500">Essential category details</p>
                        </div>
                    </div>

                    <div class="space-y-5 lg:space-y-6">
                        <!-- Category Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                                placeholder="e.g., Cement & Concrete">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-semibold text-slate-700 mb-2">
                                Category Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all @error('slug') border-red-500 @enderror"
                                placeholder="e.g., cement-concrete">
                            <p class="text-xs text-slate-500 mt-1">URL-friendly version (auto-generated from name)</p>
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Icon -->
                        <div>
                            <label for="icon" class="block text-sm font-semibold text-slate-700 mb-2">
                                Icon (Optional)
                            </label>
                            <input type="text" id="icon" name="icon" value="{{ old('icon', $category->icon) }}"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all @error('icon') border-red-500 @enderror"
                                placeholder="e.g., 🏗️ or fa-solid fa-hammer">
                            <p class="text-xs text-slate-500 mt-1">Emoji or Font Awesome icon class (e.g., fa-solid fa-hammer)</p>
                            @error('icon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Display Order -->
                        <div>
                            <label for="order" class="block text-sm font-semibold text-slate-700 mb-2">
                                Display Order
                            </label>
                            <input type="number" id="order" name="order" value="{{ old('order', $category->order) }}" min="0"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all @error('order') border-red-500 @enderror"
                                placeholder="0">
                            <p class="text-xs text-slate-500 mt-1">Lower numbers appear first</p>
                            @error('order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm border border-slate-200 p-5 lg:p-8 hover-lift transition">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-chart-bar text-emerald-600 text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg lg:text-xl font-bold text-slate-900">Category Statistics</h3>
                            <p class="text-xs lg:text-sm text-slate-500">Product counts in this category</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 lg:gap-6">
                        <div class="bg-blue-50 rounded-xl p-4 lg:p-6 border border-blue-200">
                            <p class="text-sm text-slate-600 mb-2 font-semibold">Total Products</p>
                            <p class="text-2xl lg:text-3xl font-bold text-blue-600">{{ $category->products->count() }}</p>
                        </div>
                        <div class="bg-emerald-50 rounded-xl p-4 lg:p-6 border border-emerald-200">
                            <p class="text-sm text-slate-600 mb-2 font-semibold">Active Products</p>
                            <p class="text-2xl lg:text-3xl font-bold text-emerald-600">{{ $category->products->where('is_active', true)->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm border border-slate-200 p-5 lg:p-8 hover-lift transition">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-eye text-indigo-600 text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg lg:text-xl font-bold text-slate-900">Preview</h3>
                            <p class="text-xs lg:text-sm text-slate-500">How your category will appear</p>
                        </div>
                    </div>
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 lg:p-8 text-center">
                        <div class="inline-flex items-center gap-3 px-6 lg:px-8 py-4 lg:py-5 bg-slate-50 rounded-xl border border-slate-200">
                            <span id="previewIcon" class="text-3xl lg:text-4xl">{{ $category->icon ?? '📦' }}</span>
                            <span id="previewName" class="text-lg lg:text-xl font-bold text-slate-900">{{ $category->name }}</span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm border border-slate-200 p-5 lg:p-8">
                    <div class="flex flex-col sm:flex-row gap-4 justify-between">
                        <button type="button" onclick="confirmDelete()" 
                            class="px-6 py-3 bg-red-50 text-red-700 font-semibold rounded-lg hover:bg-red-100 transition-colors flex items-center justify-center gap-2"
                            {{ $category->products->count() > 0 ? 'disabled' : '' }}>
                            <i class="fa-solid fa-trash"></i>
                            Delete Category
                        </button>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('indexCategory') }}"
                                class="px-6 py-3 bg-slate-100 text-slate-700 font-semibold rounded-lg hover:bg-slate-200 transition-colors text-center flex items-center justify-center gap-2">
                                <i class="fa-solid fa-times"></i>
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-3 bg-slate-800 text-white font-semibold rounded-lg hover:bg-slate-900 shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-save"></i>
                                Update Category
                            </button>
                        </div>
                    </div>
                    @if($category->products->count() > 0)
                    <p class="mt-4 text-sm text-slate-600 text-center p-3 bg-amber-50 border border-amber-200 rounded-lg">
                        <i class="fa-solid fa-exclamation-triangle text-amber-600 mr-2"></i>
                        This category has {{ $category->products->count() }} product(s). Delete or reassign all products before deleting this category.
                    </p>
                    @endif
                </div>
            </form>

            <!-- Delete Form (Hidden) -->
            <form id="deleteForm" method="POST" action="{{ route('deleteCategory', $category) }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </main>

    <script>
        // Sidebar toggle
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');

        menuBtn?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Auto-generate slug from name
        document.getElementById('name')?.addEventListener('input', function(e) {
            const slug = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '');
            document.getElementById('slug').value = slug;
            
            // Update preview
            document.getElementById('previewName').textContent = e.target.value || 'Category Name';
        });

        // Update icon preview
        document.getElementById('icon')?.addEventListener('input', function(e) {
            const icon = e.target.value;
            document.getElementById('previewIcon').textContent = icon || '📦';
        });

        // Delete confirmation
        function confirmDelete() {
            const productCount = {{ $category->products->count() }};
            
            if (productCount > 0) {
                alert('Cannot delete this category because it has ' + productCount + ' product(s). Please delete or reassign all products first.');
                return;
            }
            
            if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>

</body>
</html>