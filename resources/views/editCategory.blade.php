<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - Oweru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 antialiased">

    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-gray-900">Oweru Hardware Admin</span>
                </div>

                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{ route('createProduct') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Products</a>
                    <a href="{{ route('createCategory') }}" class="text-sm font-semibold text-blue-600">Categories</a>
                </nav>

                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                        AD
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                <a href="{{ route('indexCategory') }}" class="hover:text-blue-600">Categories</a>
                <span>/</span>
                <span class="text-gray-900">Edit: {{ $category->name }}</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Category</h1>
            <p class="text-gray-600">Update the category information below</p>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
        @endif
        <form method="POST" action="{{ route('updateCategory', $category) }}" class="space-y-6">
            @csrf
            @method('PATCH')
            
            <!-- Category Information -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Category Information
                </h2>

                <div class="space-y-6">
                    <!-- Category Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                            placeholder="e.g., Cement & Concrete">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">
                            Category Slug <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('slug') border-red-500 @enderror"
                            placeholder="e.g., cement-concrete">
                        <p class="text-xs text-gray-500 mt-1">URL-friendly version</p>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon -->
                    <div>
                        <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">
                            Icon (Optional)
                        </label>
                        <input type="text" id="icon" name="icon" value="{{ old('icon', $category->icon) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('icon') border-red-500 @enderror"
                            placeholder="e.g., 🏗️ or icon class name">
                        <p class="text-xs text-gray-500 mt-1">Emoji or CSS icon class</p>
                        @error('icon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Display Order -->
                    <div>
                        <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">
                            Display Order
                        </label>
                        <input type="number" id="order" name="order" value="{{ old('order', $category->order) }}" min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('order') border-red-500 @enderror"
                            placeholder="0">
                        <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Category Statistics</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Total Products</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $category->products->count() }}</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Active Products</p>
                        <p class="text-2xl font-bold text-green-600">{{ $category->products->where('is_active', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Preview</h2>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                    <div class="inline-flex items-center gap-3 px-6 py-4 bg-blue-50 rounded-lg">
                        <span id="previewIcon" class="text-3xl">{{ $category->icon ?? '📦' }}</span>
                        <span id="previewName" class="text-lg font-semibold text-gray-800">{{ $category->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex flex-col sm:flex-row gap-4 justify-between">
                    <button type="button" onclick="confirmDelete()" 
                        class="px-6 py-3 bg-red-100 text-red-700 font-semibold rounded-lg hover:bg-red-200 transition-colors"
                        {{ $category->products->count() > 0 ? 'disabled title="Cannot delete category with products"' : '' }}>
                        Delete Category
                    </button>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('indexCategory') }}"
                            class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors text-center">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
                            Update Category
                        </button>
                    </div>
                </div>
                @if($category->products->count() > 0)
                <p class="mt-3 text-sm text-gray-500 text-center">
                    ⚠️ This category has {{ $category->products->count() }} product(s). Delete all products first before deleting this category.
                </p>
                @endif
            </div>

        </form>

        <!-- Delete Form (Hidden) -->
        <form id="deleteForm" method="POST" action="{{ route('indexCategory', $category) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </main>

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