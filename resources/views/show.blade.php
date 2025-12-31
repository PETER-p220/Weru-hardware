<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Oweru Hardware</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 antialiased">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">OH</span>
                    </div>
                    <span class="text-lg font-bold text-slate-900">Oweru Hardware</span>
                </div>

                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{ route('products') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">Products</a>
                    <a href="#" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Categories</a>
                    <a href="#" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">About</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Breadcrumb & Back Button -->
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <a href="{{ route('products') }}" class="hover:text-blue-600 transition-colors font-medium">Products</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 font-semibold">{{ $product->name }}</span>
            </div>

            <a href="{{ route('products') }}" 
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Products
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Product Image & Details Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    
                    <!-- Product Image -->
                    @if($product->image)
                    <div class="w-full h-96 bg-gray-100 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    @else
                    <div class="w-full h-96 bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                        <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif

                    <!-- Product Information -->
                    <div class="p-8">
                        
                        <!-- Badges -->
                        <div class="flex items-center gap-2 mb-4">
                            @if($product->is_featured)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700 border border-purple-200">
                                <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Featured Product
                            </span>
                            @endif
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $product->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $product->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <!-- Product Name & Unit -->
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                        <p class="text-sm text-gray-500 font-medium mb-6">{{ $product->unit }}</p>

                        <!-- Price Section -->
                        <div class="mb-8 pb-6 border-b border-gray-200">
                            <div class="flex items-baseline gap-3 mb-2">
                                <span class="text-4xl font-bold text-gray-900">{{ $product->formatted_price }}</span>
                                @if($product->hasDiscount())
                                <span class="text-xl text-gray-400 line-through">TZS {{ number_format($product->old_price, 0) }}</span>
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                    {{ $product->discount_percentage }}% OFF
                                </span>
                                @endif
                            </div>
                            @if($product->hasDiscount())
                            <p class="text-sm text-green-600 font-semibold">
                                💰 You Save: TZS {{ number_format($product->old_price - $product->price, 0) }}
                            </p>
                            @endif
                        </div>

                        <!-- Description -->
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Product Description
                            </h2>
                            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Product Meta Information Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide">Category</h3>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($product->category->icon)
                            <span class="text-xl">{{ $product->category->icon }}</span>
                            @endif
                            <span class="font-semibold text-base text-gray-900">{{ $product->category->name }}</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide">Product ID</h3>
                        </div>
                        <p class="font-mono text-base font-semibold text-gray-900">{{ $product->id }}</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide">Created</h3>
                        </div>
                        <p class="text-sm font-semibold text-gray-900">{{ $product->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide">Last Updated</h3>
                        </div>
                        <p class="text-sm font-semibold text-gray-900">{{ $product->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Stock Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Stock Status
                    </h2>
                    
                    <div class="mb-6">
                        @if($product->stock > 10)
                        <div class="flex items-start gap-3 p-4 bg-green-50 rounded-xl border border-green-200">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-green-900 text-sm">In Stock</p>
                                <p class="text-sm text-green-700 mt-0.5">{{ $product->stock }} units available</p>
                            </div>
                        </div>
                        @elseif($product->stock > 0)
                        <div class="flex items-start gap-3 p-4 bg-orange-50 rounded-xl border border-orange-200">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-orange-900 text-sm">Low Stock</p>
                                <p class="text-sm text-orange-700 mt-0.5">Only {{ $product->stock }} units left</p>
                            </div>
                        </div>
                        @else
                        <div class="flex items-start gap-3 p-4 bg-red-50 rounded-xl border border-red-200">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-red-900 text-sm">Out of Stock</p>
                                <p class="text-sm text-red-700 mt-0.5">Currently unavailable</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Progress Bar -->
                    <div>
                        <div class="flex justify-between text-xs mb-2">
                            <span class="text-gray-600 font-medium">Stock Level</span>
                            <span class="font-bold text-gray-900">{{ $product->stock }} / 100</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="h-3 rounded-full transition-all duration-300 {{ $product->stock > 10 ? 'bg-green-500' : ($product->stock > 0 ? 'bg-orange-500' : 'bg-red-500') }}" 
                                 style="width: {{ min(($product->stock / 100) * 100, 100) }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Quick Stats
                    </h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm text-gray-600 font-medium">Price per Unit</span>
                            <span class="font-bold text-gray-900">{{ $product->formatted_price }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm text-gray-600 font-medium">Unit Type</span>
                            <span class="font-bold text-gray-900">{{ ucfirst($product->unit) }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <span class="text-sm text-blue-700 font-medium">Total Value</span>
                            <span class="font-bold text-blue-700">TZS {{ number_format($product->price * $product->stock, 0) }}</span>
                        </div>
                        @if($product->hasDiscount())
                        <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg border border-green-200">
                            <span class="text-sm text-green-700 font-medium">Active Discount</span>
                            <span class="font-bold text-green-700">{{ $product->discount_percentage }}% OFF</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Slug Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        Product Slug
                    </h3>
                    <p class="font-mono text-sm text-gray-700 break-all bg-gray-50 p-3 rounded-lg">{{ $product->slug }}</p>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button onclick="window.print()" 
                       class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-slate-800 text-white text-sm font-bold rounded-xl hover:bg-slate-700 transition-colors shadow-sm ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print Details
                    </button>
                </div>

            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12 print:hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-sm text-gray-600">
                <p>&copy; 2024 Oweru Hardware. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <style>
        @media print {
            header, footer, .print\:hidden, button { 
                display: none !important; 
            }
            body {
                background: white;
            }
            .shadow-sm, .shadow-md {
                box-shadow: none !important;
            }
        }
    </style>

</body>
</html>