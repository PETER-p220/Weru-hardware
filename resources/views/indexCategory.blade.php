<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Weru Hardware Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff6b35',
                        'primary-dark': '#e85a2a',
                        'primary-light': '#ff8c5f',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
        .category-card {
            transition: all 0.3s ease;
        }
        .category-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-white to-orange-50 min-h-screen">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 h-full w-64 bg-white shadow-xl z-40 border-r border-orange-100">
        <div class="p-5 border-b border-orange-100">
            <h1 class="text-xl font-bold text-primary">Weru Hardware</h1>
            <p class="text-[10px] text-gray-500 mt-0.5">Admin Dashboard</p>
        </div>
        
        <nav class="p-4">
            <a href="{{ route('adminDashboard') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition-all mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-xs font-medium">Dashboard</span>
            </a>
            <a href="{{ route('indexProduct') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition-all mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="text-xs font-medium">Products</span>
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-gradient-to-r from-primary to-primary-dark text-white mb-1 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <span class="text-xs font-medium">Categories</span>
            </a>
            <a href="/OrderManagement" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition-all mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="text-xs font-medium">Orders</span>
            </a>
            <a href="/user" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="text-xs font-medium">Customers</span>
            </a>
        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-orange-100">
            <div class="flex items-center space-x-3 px-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center text-white text-xs font-bold">
                    A
                </div>
                <div class="flex-1">
                    <p class="text-xs font-semibold text-gray-800">Admin User</p>
                    <p class="text-[10px] text-gray-500">Administrator</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm border-b border-orange-100 sticky top-0 z-30">
            <div class="flex items-center justify-between px-6 py-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Manage Categories</h2>
                    <p class="text-[10px] text-gray-500">Organize your products efficiently</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('createCategory') }}" class="px-4 py-2 bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold rounded-lg hover:shadow-md transition-all flex items-center space-x-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Add Category</span>
                    </a>
                    <div class="h-6 w-px bg-gray-200"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-gray-600 hover:text-primary transition-colors font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="p-6">
            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-xs font-medium animate-slide-in flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs font-medium animate-slide-in flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            <!-- Categories Grid -->
            @if($categories->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6">
                    @foreach($categories as $category)
                    <div class="category-card bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden hover:shadow-md transition-all">
                        <div class="p-5">
                            <!-- Icon & Name -->
                            <div class="text-center mb-4">
                                @if($category->icon && !str_starts_with($category->icon, 'fa-'))
                                    <div class="text-4xl mb-2">{{ $category->icon }}</div>
                                @elseif($category->icon)
                                    <div class="w-12 h-12 mx-auto bg-gradient-to-br from-primary/10 to-orange-100 rounded-lg flex items-center justify-center mb-2">
                                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-12 h-12 mx-auto bg-gradient-to-br from-primary/10 to-orange-100 rounded-lg flex items-center justify-center mb-2">
                                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                @endif
                                <h3 class="text-sm font-bold text-gray-900">{{ $category->name }}</h3>
                                <p class="text-[9px] text-gray-500">Order: {{ $category->order ?? '—' }}</p>
                            </div>

                            <!-- Stats -->
                            <div class="grid grid-cols-2 gap-2 mb-4">
                                <div class="bg-orange-50 rounded-lg p-2.5 text-center">
                                    <p class="text-[9px] text-gray-600 font-semibold uppercase tracking-wide">Products</p>
                                    <p class="text-lg font-bold text-primary">{{ $category->products_count ?? 0 }}</p>
                                </div>
                                <div class="bg-green-50 rounded-lg p-2.5 text-center">
                                    <p class="text-[9px] text-gray-600 font-semibold uppercase tracking-wide">Active</p>
                                    <p class="text-lg font-bold text-green-600">{{ $category->active_products_count ?? 0 }}</p>
                                </div>
                            </div>

                            <!-- Slug -->
                            <div class="mb-4 p-2 bg-gray-50 rounded-lg">
                                <p class="text-[9px] text-gray-500 uppercase font-semibold mb-0.5">URL Slug</p>
                                <code class="text-[10px] font-mono text-primary">{{ $category->slug }}</code>
                            </div>

                            <!-- Actions -->
                            <div class="space-y-2">
                                <div class="grid grid-cols-2 gap-2">
                                    <a href="#" 
                                       class="py-2 bg-primary/10 text-primary text-[10px] font-bold rounded-lg hover:bg-primary hover:text-white transition text-center">
                                        View
                                    </a>
                                    <a href="#" 
                                       class="py-2 bg-gray-100 text-gray-700 text-[10px] font-bold rounded-lg hover:bg-gray-200 transition text-center">
                                        Edit
                                    </a>
                                </div>

                                <form method="POST" action="#" onsubmit="return confirm('⚠️ Delete {{ $category->name }}?\n\nThis will also delete ALL products in this category!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full py-2 text-red-600 text-[10px] font-bold rounded-lg border border-red-200 hover:bg-red-50 transition
                                        {{ ($category->products_count ?? 0) > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ ($category->products_count ?? 0) > 0 ? 'disabled' : '' }}>
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                    @if(($category->products_count ?? 0) > 0)
                                        <p class="text-[9px] text-red-600 text-center mt-1">
                                            Remove all products first
                                        </p>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Summary Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center space-x-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span>Category Summary</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gradient-to-br from-primary/5 to-orange-50 rounded-lg p-4 text-center border border-orange-100">
                            <p class="text-2xl font-bold text-primary">{{ $categories->count() }}</p>
                            <p class="text-[10px] font-semibold text-gray-600 uppercase tracking-wide">Total Categories</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 text-center border border-green-100">
                            <p class="text-2xl font-bold text-green-600">{{ $categories->sum('products_count') }}</p>
                            <p class="text-[10px] font-semibold text-gray-600 uppercase tracking-wide">Total Products</p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-4 text-center border border-purple-100">
                            <p class="text-2xl font-bold text-purple-600">
                                {{ $categories->count() > 0 ? round($categories->sum('products_count') / $categories->count(), 1) : 0 }}
                            </p>
                            <p class="text-[10px] font-semibold text-gray-600 uppercase tracking-wide">Avg Products</p>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Categories Yet</h3>
                    <p class="text-xs text-gray-600 mb-6">Start organizing your products into categories</p>
                    <a href="{{ route('createCategory') }}" 
                       class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Create First Category</span>
                    </a>
                </div>
            @endif
        </div>
    </main>

    <footer class="ml-64 bg-white border-t border-orange-100 py-4">
        <div class="px-6 flex items-center justify-between">
            <p class="text-[10px] text-gray-500">© 2024 Weru Hardware. All rights reserved.</p>
            <div class="flex space-x-4">
                <a href="#" class="text-[10px] text-gray-500 hover:text-primary transition-colors font-medium">Help Center</a>
                <a href="#" class="text-[10px] text-gray-500 hover:text-primary transition-colors font-medium">Documentation</a>
            </div>
        </div>
    </footer>
</body>
</html>