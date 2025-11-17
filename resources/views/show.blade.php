<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Weru Hardware</title>
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
                    <span class="text-lg font-bold text-gray-900">Weru Hardware Admin</span>
                </div>

                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{ route('indexProduct') }}" class="text-sm font-semibold text-blue-600">Products</a>
                    <a href="{{ route('indexCategory') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Categories</a>
                </nav>

                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                        AD
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Breadcrumb -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <a href="{{ route('indexProduct') }}" class="hover:text-blue-600 transition-colors">Products</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 font-medium">{{ $product->name }}</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-6 flex flex-wrap gap-3">
            <a href="{{ route('products.edit', $product) }}" 
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Product
            </a>
            <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')"
                    class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 font-semibold rounded-lg hover:bg-red-200 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete
                </button>
            </form>
            <a href="{{ route('products.index') }}" 
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Products
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Product Info -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Product Details Card -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <!-- Image Section -->
                    @if($product->image)
                    <div class="aspect-video bg-gray-100 flex items-center justify-center">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                    @else
                    <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif

                    <!-- Product Header -->
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    @if($product->is_featured)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        Featured
                                    </span>
                                    @endif
                                    @if($product->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                    @endif
                                </div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                                <p class="text-gray-600">{{ $product->unit }}</p>
                            </div>
                        </div>

                        <!-- Price Section -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <div class="flex items-baseline gap-3">
                                <span class="text-4xl font-bold text-gray-900">{{ $product->formatted_price }}</span>
                                @if($product->hasDiscount())
                                <span class="text-2xl text-gray-400 line-through">TZS {{ number_format($product->old_price, 0) }}</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                    {{ $product->discount_percentage }}% OFF
                                </span>
                                @endif
                            </div>
                            @if($product->hasDiscount())
                            <p class="mt-2 text-sm text-green-600 font-medium">
                                You save: TZS {{ number_format($product->old_price - $product->price, 0) }}
                            </p>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <h2 class="text-lg font-bold text-gray-900 mb-3">Description</h2>
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                        </div>

                        <!-- Category -->
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 mb-3">Category</h2>
                            <a href="{{ route('categories.show', $product->category) }}" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors">
                                @if($product->category->icon)
                                <span class="text-xl">{{ $product->category->icon }}</span>
                                @endif
                                <span class="font-semibold">{{ $product->category->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product Meta -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Product Information</h2>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <dt class="text-sm text-gray-600 mb-1">Product Code</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $product->id }}</dd>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <dt class="text-sm text-gray-600 mb-1">Slug</dt>
                            <dd class="text-lg font-mono text-gray-900">{{ $product->slug }}</dd>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <dt class="text-sm text-gray-600 mb-1">Created</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $product->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <dt class="text-sm text-gray-600 mb-1">Last Updated</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $product->updated_at->format('M d, Y') }}</dd>
                        </div>
                    </dl>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Stock Status Card -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Stock Status</h2>
                    
                    <div class="mb-6">
                        @if($product->stock > 10)
                        <div class="flex items-center gap-2 p-4 bg-green-50 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-bold text-green-800">In Stock</p>
                                <p class="text-sm text-green-600">{{ $product->stock }} units available</p>
                            </div>
                        </div>
                        @elseif($product->stock > 0)
                        <div class="flex items-center gap-2 p-4 bg-orange-50 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-bold text-orange-800">Low Stock</p>
                                <p class="text-sm text-orange-600">Only {{ $product->stock }} left</p>
                            </div>
                        </div>
                        @else
                        <div class="flex items-center gap-2 p-4 bg-red-50 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-bold text-red-800">Out of Stock</p>
                                <p class="text-sm text-red-600">Currently unavailable</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Stock Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Stock Level</span>
                            <span class="font-bold text-gray-900">{{ $product->stock }} units</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="h-3 rounded-full {{ $product->stock > 10 ? 'bg-green-500' : ($product->stock > 0 ? 'bg-orange-500' : 'bg-red-500') }}" 
                                 style="width: {{ min(($product->stock / 100) * 100, 100) }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Stats</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                            <span class="text-gray-600">Price per Unit</span>
                            <span class="font-bold text-gray-900">{{ $product->formatted_price }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                            <span class="text-gray-600">Unit Type</span>
                            <span class="font-bold text-gray-900">{{ ucfirst($product->unit) }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                            <span class="text-gray-600">Total Value</span>
                            <span class="font-bold text-blue-600">TZS {{ number_format($product->price * $product->stock, 0) }}</span>
                        </div>
                        @if($product->hasDiscount())
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Discount</span>
                            <span class="font-bold text-green-600">{{ $product->discount_percentage }}% OFF</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="{{ route('products.edit', $product) }}" 
                           class="flex items-center justify-center w-full px-4 py-3 bg-white text-blue-700 font-semibold rounded-lg hover:bg-blue-50 transition-colors shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Product
                        </a>
                        <button onclick="window.print()" 
                           class="flex items-center justify-center w-full px-4 py-3 bg-white text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print Details
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <style>
        @media print {
            header, .lg\:col-span-1, button { display: none !important; }
        }
    </style>

</body>
</html>