<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Category - Weru Hardware</title>
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
                    <h2 class="text-lg font-bold text-gray-800">Add New Category</h2>
                    <p class="text-[10px] text-gray-500">Create a new product category</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('indexCategory') }}" class="text-[10px] text-gray-600 hover:text-primary transition-colors font-medium">
                        Back to Categories
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

        <div class="p-6 max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <div class="flex items-center space-x-2 text-[10px] text-gray-500">
                    <a href="{{ route('adminDashboard') }}" class="hover:text-primary font-medium">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('indexCategory') }}" class="hover:text-primary font-medium">Categories</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-primary font-semibold">Add New</span>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-xs font-medium animate-slide-in flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs font-medium animate-slide-in">
                <div class="flex items-center space-x-2 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="font-bold">Please fix the following errors:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-[10px]">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('createCategory') }}" class="space-y-4">
                @csrf
                
                <!-- Category Information -->
                <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
                    <div class="flex items-center space-x-3 mb-5">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary to-primary-dark rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Category Information</h3>
                            <p class="text-[10px] text-gray-500">Basic category details</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Category Name -->
                        <div>
                            <label for="name" class="block text-[11px] font-bold text-gray-700 mb-2">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                                class="w-full px-4 py-2.5 text-xs border border-gray-200 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('name') border-red-300 @enderror"
                                placeholder="e.g., Cement & Concrete">
                            @error('name')
                                <p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-[11px] font-bold text-gray-700 mb-2">
                                Category Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required 
                                class="w-full px-4 py-2.5 text-xs border border-gray-200 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('slug') border-red-300 @enderror"
                                placeholder="e.g., cement-concrete">
                            <p class="text-[9px] text-gray-500 mt-1">URL-friendly version (auto-generated from name)</p>
                            @error('slug')
                                <p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Icon -->
                        <div>
                            <label for="icon" class="block text-[11px] font-bold text-gray-700 mb-2">
                                Icon (Optional)
                            </label>
                            <input type="text" id="icon" name="icon" value="{{ old('icon') }}"
                                class="w-full px-4 py-2.5 text-xs border border-gray-200 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('icon') border-red-300 @enderror"
                                placeholder="e.g., 🏗️ or icon class name">
                            <p class="text-[9px] text-gray-500 mt-1">Emoji or CSS icon class</p>
                            @error('icon')
                                <p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Display Order -->
                        <div>
                            <label for="order" class="block text-[11px] font-bold text-gray-700 mb-2">
                                Display Order
                            </label>
                            <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0"
                                class="w-full px-4 py-2.5 text-xs border border-gray-200 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('order') border-red-300 @enderror"
                                placeholder="0">
                            <p class="text-[9px] text-gray-500 mt-1">Lower numbers appear first (default: 0)</p>
                            @error('order')
                                <p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Live Preview</h3>
                            <p class="text-[10px] text-gray-500">See how it will look</p>
                        </div>
                    </div>
                    <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center bg-gradient-to-br from-orange-50 to-white">
                        <div class="inline-flex items-center space-x-3 px-5 py-3 bg-white rounded-lg shadow-sm border border-orange-100">
                            <span id="previewIcon" class="text-2xl">📦</span>
                            <span id="previewName" class="text-sm font-bold text-gray-800">Category Name</span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-3 justify-end pt-2">
                    <a href="{{ route('indexCategory') }}"
                        class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-50 transition text-center">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-8 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center space-x-2 justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Create Category</span>
                    </button>
                </div>

            </form>
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

    <script>
        // Auto-generate slug from name
        document.getElementById('name').addEventListener('input', function(e) {
            const slug = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '');
            document.getElementById('slug').value = slug;
            
            // Update preview
            document.getElementById('previewName').textContent = e.target.value || 'Category Name';
        });

        // Update icon preview
        document.getElementById('icon').addEventListener('input', function(e) {
            const icon = e.target.value;
            document.getElementById('previewIcon').textContent = icon || '📦';
        });
    </script>

</body>
</html>