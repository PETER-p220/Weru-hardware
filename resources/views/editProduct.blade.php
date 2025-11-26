<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Weru Hardware</title>
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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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

                
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                <a href="{{ route('indexProduct') }}" class="hover:text-blue-600">Products</a>
                <span>/</span>
                <span class="text-gray-900">Edit: {{ $product->name }}</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Product</h1>
            <p class="text-gray-600">Update the product information below</p>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('updateProduct', $product) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Basic Information -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Basic Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                            placeholder="e.g., Mbeya OPC Cement 50kg Bag">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">
                            Product Slug <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('slug') border-red-500 @enderror"
                            placeholder="e.g., mbeya-opc-cement-50kg-bag">
                        <p class="text-xs text-gray-500 mt-1">URL-friendly version of product name</p>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id" name="category_id" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('category_id') border-red-500 @enderror">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="unit" class="block text-sm font-semibold text-gray-700 mb-2">
                            Unit <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="unit" name="unit" value="{{ old('unit', $product->unit) }}" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('unit') border-red-500 @enderror"
                            placeholder="e.g., bag, piece, meter, roll">
                        @error('unit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" required rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('description') border-red-500 @enderror"
                            placeholder="Enter detailed product description...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing & Stock -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pricing & Stock
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                            Current Price (TZS) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required min="0" step="0.01"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('price') border-red-500 @enderror"
                            placeholder="24000.00">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="old_price" class="block text-sm font-semibold text-gray-700 mb-2">
                            Old Price (Optional)
                        </label>
                        <input type="number" id="old_price" name="old_price" value="{{ old('old_price', $product->old_price) }}" min="0" step="0.01"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('old_price') border-red-500 @enderror"
                            placeholder="28000.00">
                        <p class="text-xs text-gray-500 mt-1">For showing discounts</p>
                        @error('old_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">
                            Stock Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('stock') border-red-500 @enderror"
                            placeholder="100">
                        @error('stock')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="discountDisplay" class="{{ $product->hasDiscount() ? '' : 'hidden' }}">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Discount
                        </label>
                        <div class="w-full px-4 py-3 bg-green-50 border border-green-200 rounded-lg">
                            <span class="text-green-700 font-bold text-lg" id="discountPercent">{{ $product->discount_percentage }}%</span>
                            <span class="text-green-600 text-sm ml-2">OFF</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Settings -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Product Settings
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        </div>
                        <div class="ml-3">
                            <label for="is_featured" class="text-sm font-semibold text-gray-700 cursor-pointer">Featured Product</label>
                            <p class="text-xs text-gray-500">Display prominently on homepage</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        </div>
                        <div class="ml-3">
                            <label for="is_active" class="text-sm font-semibold text-gray-700 cursor-pointer">Active Status</label>
                            <p class="text-xs text-gray-500">Visible to customers</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Upload -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Product Image
                </h2>

                @if($product->image)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-h-48 rounded-lg shadow-md">
                </div>
                @endif

                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <div class="mt-4">
                        <label for="image" class="cursor-pointer">
                            <span class="mt-2 block text-sm font-medium text-blue-600 hover:text-blue-500">
                                {{ $product->image ? 'Change image' : 'Upload product image' }}
                            </span>
                            <input id="image" name="image" type="file" accept="image/*" class="hidden">
                        </label>
                        <p class="mt-1 text-xs text-gray-500">PNG, JPG, WEBP up to 10MB</p>
                    </div>
                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="previewImg" class="mx-auto max-h-48 rounded-lg shadow-md" alt="Preview">
                        <button type="button" onclick="removeImage()" class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium">
                            Remove New Image
                        </button>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex flex-col sm:flex-row gap-4 justify-between">
                    <button type="button" onclick="confirmDelete()" class="px-6 py-3 bg-red-100 text-red-700 font-semibold rounded-lg hover:bg-red-200 transition-colors">
                        Delete Product
                    </button>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('indexProduct') }}"
                            class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors text-center">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
                            Update Product
                        </button>
                    </div>
                </div>
            </div>

        </form>

        <!-- Delete Form (Hidden) -->
        <form id="deleteForm" method="POST" action="{{ route('deleteProduct', $product) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </main>

    <script>
        // Auto-generate slug
        document.getElementById('name').addEventListener('input', function(e) {
            const slug = e.target.value
                .toLowerCase()
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
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
        }

        // Calculate discount
        function calculateDiscount() {
            const price = parseFloat(document.getElementById('price').value) || 0;
            const oldPrice = parseFloat(document.getElementById('old_price').value) || 0;
            
            if (oldPrice && price && oldPrice > price) {
                const discount = Math.round(((oldPrice - price) / oldPrice) * 100);
                document.getElementById('discountPercent').textContent = discount + '%';
                document.getElementById('discountDisplay').classList.remove('hidden');
            } else {
                document.getElementById('discountDisplay').classList.add('hidden');
            }
        }

        document.getElementById('price').addEventListener('input', calculateDiscount);
        document.getElementById('old_price').addEventListener('input', calculateDiscount);

        // Delete confirmation
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>

</body>
</html>