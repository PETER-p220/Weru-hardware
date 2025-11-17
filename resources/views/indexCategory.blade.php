<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Weru Hardware</title>
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
                    <span class="text-lg font-bold text-gray-900">Weru Admin</span>
                </div>

                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{ route('indexProduct') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Products</a>
                    <a href="{{ route('indexCategory') }}" class="text-sm font-semibold text-blue-600">Categories</a>
                </nav>

               
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
                <p class="text-gray-600 mt-1">Organize your products into categories</p>
            </div>
            <a href="{{ route('createCategory') }}" 
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Category
            </a>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
        @endif

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($categories as $category)
            <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all group">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        @if($category->icon)
                        <span class="text-4xl">{{ $category->icon }}</span>
                        @else
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                {{ $category->name }}
                            </h3>
                            <p class="text-sm text-gray-500">Order: {{ $category->order }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-blue-50 rounded-lg p-3">
                        <p class="text-xs text-gray-600 mb-1">Products</p>
                        <p class="text-xl font-bold text-blue-600">{{ $category->products_count }}</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3">
                        <p class="text-xs text-gray-600 mb-1">Active</p>
                        <p class="text-xl font-bold text-green-600">{{ $category->active_products_count }}</p>
                    </div>
                </div>

                <!-- Slug -->
                <div class="mb-4 pb-4 border-b border-gray-100">
                    <p class="text-xs text-gray-500">Slug:</p>
                    <code class="text-sm text-gray-700 bg-gray-50 px-2 py-1 rounded">{{ $category->slug }}</code>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <a href="#" 
                        class="flex-1 px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors text-center">
                        View
                    </a>
                    <a href="#" 
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors text-center">
                        Edit
                    </a>
                    <form method="POST" action="#" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            onclick="return confirm('Are you sure? This will delete the category and all its products.')"
                            class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors"
                            {{ $category->products_count > 0 ? 'disabled title="Has products"' : '' }}>
                            Delete
                        </button>
                    </form>
                </div>

                @if($category->products_count > 0)
                <p class="mt-2 text-xs text-gray-500 text-center">
                    ⚠️ Delete products first
                </p>
                @endif
            </div>
            @empty
            <div class="col-span-full bg-white rounded-xl border border-gray-200 p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">No categories yet</h3>
                <p class="mt-2 text-gray-500">Get started by creating your first category</p>
                <a href="{{ route('createCategory') }}" 
                    class="mt-6 inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Category
                </a>
            </div>
            @endforelse
        </div>

        <!-- Summary Stats -->
        @if($categories->count() > 0)
        <div class="mt-8 bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Summary</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Total Categories</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $categories->count() }}</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Total Products</p>
                    <p class="text-3xl font-bold text-green-600">{{ $categories->sum('products_count') }}</p>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Avg Products/Category</p>
                    <p class="text-3xl font-bold text-purple-600">
                        {{ $categories->count() > 0 ? round($categories->sum('products_count') / $categories->count(), 1) : 0 }}
                    </p>
                </div>
            </div>
        </div>
        @endif

    </main>

</body>
</html>