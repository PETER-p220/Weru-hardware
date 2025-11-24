<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - Weru Hardware Admin</title>
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
            <a href="{{ route('products') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-gradient-to-r from-primary to-primary-dark text-white mb-1 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="text-xs font-medium">Products</span>
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition-all mb-1">
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
                    <h2 class="text-lg font-bold text-gray-800">Add New Product</h2>
                    <p class="text-[10px] text-gray-500">Create a new product in your catalog</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('products') }}" class="text-[10px] text-gray-600 hover:text-primary transition-colors font-medium">
                        Back to Products
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

        <div class="p-6 max-w-6xl mx-auto">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <div class="flex items-center space-x-2 text-[10px] text-gray-500">
                    <a href="{{ route('adminDashboard') }}" class="hover:text-primary font-medium">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('products') }}" class="hover:text-primary font-medium">Products</a>
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
            <form method="POST" action="#" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Basic Information -->
                <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
                    <div class="flex items-center space-x-3 mb-5">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary to-primary-dark rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Basic Information</h3>
                            <p class="text-[10px] text-gray-500">Essential product details</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div class="lg:col-span-2">
                            <label class="block text-[11px] font-bold text-gray-700 mb-2">Product Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-2.5 text-xs rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('name') border-red-300 @enderror"
                                placeholder="e.g. Twiga Cement 50kg Bag">
                        </div>

                        <div class="lg:col-span-2">
                            <label class="block text-[11px] font-bold text-gray-700 mb-2">Slug (URL) <span class="text-red-500">*</span></label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                                class="w-full px-4 py-2.5 text-xs rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('slug') border-red-300 @enderror"
                                placeholder="twiga-cement-50kg-bag">
                            <p class="text-[9px] text-gray-500 mt-1">Auto-generated from name • Used in URL</p>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                            <select name="category_id" required class="w-full px-4 py-2.5 text-xs rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('category_id') border-red-300 @enderror">
                                <option value="">Choose category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->icon }} {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-2">Unit <span class="text-red-500">*</span></label>
                            <input type="text" name="unit" value="{{ old('unit') }}" required placeholder="e.g. bag, piece, roll, meter"
                                class="w-full px-4 py-2.5 text-xs rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('unit') border-red-300 @enderror">
                        </div>

                        <div class="lg:col-span-2">
                            <label class="block text-[11px] font-bold text-gray-700 mb-2">Description <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="4" required placeholder="Detailed description, specifications, and uses..."
                                class="w-full px-4 py-2.5 text-xs rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('description') border-red-300 @enderror">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
                    <div class="flex items-center space-x-3 mb-5">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Pricing & Stock</h3>
                            <p class="text-[10px] text-gray-500">Set prices and inventory</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-2">Current Price (TZS) <span class="text-red-500">*</span></label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required step="100"
                                class="w-full px-4 py-2.5 text-xs rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('price') border-red-300 @enderror"
                                placeholder="28000">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-2">Old Price (Optional)</label>
                            <input type="number" name="old_price" id="old_price" value="{{ old('old_price') }}" step="100"
                                class="w-full px-4 py-2.5 text-xs rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                placeholder="32000">
                            <p class="text-[9px] text-gray-500 mt-1">For showing discount</p>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-2">Stock Quantity <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0"
                                class="w-full px-4 py-2.5 text-xs rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('stock') border-red-300 @enderror"
                                placeholder="150">
                        </div>
                    </div>

                    <!-- Live Discount Preview -->
                    <div id="discountPreview" class="hidden mt-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-green-800 font-bold text-sm" id="discountText">Save 12%</p>
                                <p class="text-green-700 text-[10px] font-medium">Customers save <span id="saveAmount">TZS 4,000</span> per unit!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Image -->
                <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
                    <div class="flex items-center space-x-3 mb-5">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Product Image</h3>
                            <p class="text-[10px] text-gray-500">Upload product photo</p>
                        </div>
                    </div>

                    <div class="border-2 border-dashed border-gray-200 rounded-lg p-8 text-center hover:border-primary transition-all">
                        <input type="file" name="image" id="image" accept="image/*" class="hidden">
                        <label for="image" class="cursor-pointer">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-xs font-bold text-gray-700 mb-1">Click to upload image</p>
                            <p class="text-[10px] text-gray-500">PNG, JPG, WebP • Max 10MB</p>
                        </label>

                        <div id="imagePreview" class="mt-4 hidden">
                            <img id="previewImg" class="mx-auto max-h-64 rounded-lg shadow-lg" alt="Product preview">
                            <button type="button" onclick="removeImage()" class="mt-3 text-[10px] text-red-600 font-bold hover:text-red-700">
                                Remove Image
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Settings -->
                <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
                    <div class="flex items-center space-x-3 mb-5">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Product Settings</h3>
                            <p class="text-[10px] text-gray-500">Configure visibility options</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-start space-x-3 cursor-pointer p-3 rounded-lg hover:bg-orange-50 transition-colors border border-gray-100">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                class="w-4 h-4 text-primary rounded focus:ring-primary mt-0.5">
                            <div>
                                <p class="text-xs font-bold text-gray-900">Featured Product</p>
                                <p class="text-[10px] text-gray-600">Display on homepage & promotions</p>
                            </div>
                        </label>

                        <label class="flex items-start space-x-3 cursor-pointer p-3 rounded-lg hover:bg-orange-50 transition-colors border border-gray-100">
                            <input type="checkbox" name="is_active" value="1" checked {{ old('is_active', true) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary rounded focus:ring-primary mt-0.5">
                            <div>
                                <p class="text-xs font-bold text-gray-900">Active & Visible</p>
                                <p class="text-[10px] text-gray-600">Customers can view and purchase</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 justify-end pt-2">
                    <a href="{{ route('products') }}"
                        class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-50 transition text-center">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-8 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center space-x-2 justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Create Product</span>
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
        // Auto slug generation
        document.getElementById('name').addEventListener('input', function() {
            const slug = this.value.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '');
            document.getElementById('slug').value = slug;
        });

        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    document.getElementById('previewImg').src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
        }

        // Live discount calculator
        function updateDiscount() {
            const price = parseFloat(document.getElementById('price').value) || 0;
            const oldPrice = parseFloat(document.getElementById('old_price').value) || 0;

            if (oldPrice > price && price > 0) {
                const discount = Math.round(((oldPrice - price) / oldPrice) * 100);
                const saved = oldPrice - price;

                document.getElementById('discountText').textContent = `Save ${discount}%`;
                document.getElementById('saveAmount').textContent = `TZS ${saved.toLocaleString()}`;
                document.getElementById('discountPreview').classList.remove('hidden');
            } else {
                document.getElementById('discountPreview').classList.add('hidden');
            }
        }

        document.getElementById('price').addEventListener('input', updateDiscount);
        document.getElementById('old_price').addEventListener('input', updateDiscount);
    </script>
</body>
</html>