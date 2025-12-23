<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Product • Oweru Hardware Admin</title>

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
        .nav-active::before { 
            content: ''; 
            position: absolute; 
            left: 0; 
            top: 50%; 
            transform: translateY(-50%); 
            width: 4px; 
            height: 70%; 
            background: #334155; 
            border-radius: 0 4px 4px 0; 
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .toast { animation: slideDown 0.5s ease-out; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen overflow-x-hidden">

    <!-- Mobile Menu Button -->
    <button id="menu-toggle" class="fixed top-4 left-4 z-50 lg:hidden bg-white rounded-xl p-3 shadow-lg border border-slate-200 text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-bars text-xl"></i>
    </button>
    <div id="overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 hidden"></div>

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
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col border-r border-slate-200">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Oweru<span class="text-slate-600">Hardware</span></h1>
                    <p class="text-xs text-slate-500">Admin Panel</p>
                </div>
            </div>
            <button id="close-sidebar" class="lg:hidden text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-times text-xl"></i>
            </button>
        </div>
        
        <nav class="p-4 space-y-1 flex-1 overflow-y-auto">
            <a href="{{ route('adminDashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium relative">
                <i class="fa-solid fa-gauge-high w-5"></i> Dashboard
            </a>
            <a href="{{ route('indexProduct') }}" class="flex items-center gap-3 px-4 py-3 bg-slate-800 text-white rounded-xl font-medium nav-active relative">
                <i class="fa-solid fa-boxes-stacked w-5"></i> Products
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium relative">
                <i class="fa-solid fa-tags w-5"></i> Categories
            </a>
            <a href="/OrderManagement" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium relative">
                <i class="fa-solid fa-shopping-bag w-5"></i> Orders
            </a>
            <a href="{{ route('user') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium relative">
                <i class="fa-solid fa-users w-5"></i> Customers
            </a>
            <a href="{{ route('ads') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium relative">
                <i class="fa-solid fa-bullhorn w-5"></i> Advertisements
            </a>
        </nav>

        <div class="p-5 bg-slate-50 border-t border-slate-200">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-slate-700 rounded-full flex items-center justify-center text-white font-bold text-lg shadow">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) : 'AD' }}
                </div>
                <div>
                    <p class="font-semibold text-slate-800 text-sm truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-slate-500">Administrator</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="lg:pl-72 min-h-screen">
        <header class="bg-white sticky top-0 z-40 shadow-sm border-b border-slate-200">
            <div class="px-4 lg:px-8 py-4 lg:py-5 flex items-center justify-between">
                <div class="pl-12 lg:pl-0">
                    <div class="flex items-center gap-2 text-sm text-slate-600 mb-2">
                        <a href="{{ route('indexProduct') }}" class="hover:text-slate-900 font-medium">Products</a>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                        <span class="text-slate-900 font-semibold">Edit: {{ Str::limit($product->name, 40) }}</span>
                    </div>
                    <h2 class="text-xl lg:text-2xl font-bold text-slate-900">Edit Product</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Update product information</p>
                </div>
                <div class="flex items-center gap-4">
                    <form method="POST" action="{{ route('logout') }}">@csrf 
                        <button class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-slate-900 hover:bg-slate-100 rounded-lg">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8 max-w-6xl mx-auto">
            <form method="POST" action="{{ route('updateProduct', $product) }}" enctype="multipart/form-data" class="space-y-6 lg:space-y-8">
                @csrf
                
                <!-- Basic Information -->
                <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm border border-slate-200 p-5 lg:p-8 hover-lift transition">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 bg-slate-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-info-circle text-slate-700 text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg lg:text-xl font-bold text-slate-900">Basic Information</h3>
                            <p class="text-xs lg:text-sm text-slate-500">Essential product details</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                                placeholder="e.g., Mbeya OPC Cement 50kg Bag">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="slug" class="block text-sm font-semibold text-slate-700 mb-2">
                                Product Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all @error('slug') border-red-500 @enderror"
                                placeholder="e.g., mbeya-opc-cement-50kg-bag">
                            <p class="text-xs text-slate-500 mt-1">URL-friendly version of product name (auto-generated)</p>
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-slate-700 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select id="category_id" name="category_id" required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all @error('category_id') border-red-500 @enderror">
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
                            <label for="unit" class="block text-sm font-semibold text-slate-700 mb-2">
                                Unit <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="unit" name="unit" value="{{ old('unit', $product->unit) }}" required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all @error('unit') border-red-500 @enderror"
                                placeholder="e.g., bag, piece, meter, roll">
                            @error('unit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea id="description" name="description" required rows="4"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all @error('description') border-red-500 @enderror"
                                placeholder="Enter detailed product description...">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm border border-slate-200 p-5 lg:p-8 hover-lift transition">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-money-bill-wave text-emerald-600 text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg lg:text-xl font-bold text-slate-900">Pricing & Stock</h3>
                            <p class="text-xs lg:text-sm text-slate-500">Set pricing and inventory</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-6">
                        <div>
                            <label for="price" class="block text-sm font-semibold text-slate-700 mb-2">
                                Current Price (TZS) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required min="0" step="0.01"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all @error('price') border-red-500 @enderror"
                                placeholder="24000.00">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="old_price" class="block text-sm font-semibold text-slate-700 mb-2">
                                Old Price (Optional)
                            </label>
                            <input type="number" id="old_price" name="old_price" value="{{ old('old_price', $product->old_price) }}" min="0" step="0.01"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all @error('old_price') border-red-500 @enderror"
                                placeholder="28000.00">
                            <p class="text-xs text-slate-500 mt-1">For showing discounts</p>
                            @error('old_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-semibold text-slate-700 mb-2">
                                Stock Quantity <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all @error('stock') border-red-500 @enderror"
                                placeholder="100">
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="discountDisplay" class="{{ $product->hasDiscount() ? '' : 'hidden' }}">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Discount
                            </label>
                            <div class="w-full px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-lg">
                                <span class="text-emerald-700 font-bold text-lg" id="discountPercent">{{ $product->discount_percentage }}%</span>
                                <span class="text-emerald-600 text-sm ml-2">OFF</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Settings -->
                <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm border border-slate-200 p-5 lg:p-8 hover-lift transition">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-cog text-purple-600 text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg lg:text-xl font-bold text-slate-900">Product Settings</h3>
                            <p class="text-xs lg:text-sm text-slate-500">Visibility and features</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                    {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                    class="w-5 h-5 text-slate-800 rounded border-slate-300 focus:ring-slate-800">
                            </div>
                            <div class="ml-3">
                                <label for="is_featured" class="text-sm font-semibold text-slate-700 cursor-pointer">Featured Product</label>
                                <p class="text-xs text-slate-500">Display prominently on homepage</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                    class="w-5 h-5 text-slate-800 rounded border-slate-300 focus:ring-slate-800">
                            </div>
                            <div class="ml-3">
                                <label for="is_active" class="text-sm font-semibold text-slate-700 cursor-pointer">Active Status</label>
                                <p class="text-xs text-slate-500">Visible to customers</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm border border-slate-200 p-5 lg:p-8 hover-lift transition">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-image text-indigo-600 text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg lg:text-xl font-bold text-slate-900">Product Image</h3>
                            <p class="text-xs lg:text-sm text-slate-500">Upload or change product image</p>
                        </div>
                    </div>

                    @if($product->image)
                    <div class="mb-6">
                        <p class="text-sm text-slate-600 mb-3 font-semibold">Current Image:</p>
                        <div class="inline-block">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-h-48 rounded-xl shadow-md border border-slate-200">
                        </div>
                    </div>
                    @endif

                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:border-slate-400 transition-colors">
                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-slate-400 mb-4"></i>
                        <div class="mt-4">
                            <label for="image" class="cursor-pointer">
                                <span class="mt-2 block text-sm font-medium text-slate-700 hover:text-slate-900">
                                    {{ $product->image ? 'Change image' : 'Upload product image' }}
                                </span>
                                <input id="image" name="image" type="file" accept="image/*" class="hidden">
                            </label>
                            <p class="mt-2 text-xs text-slate-500">PNG, JPG, WEBP up to 10MB</p>
                        </div>
                        @error('image')
                            <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div id="imagePreview" class="mt-6 hidden">
                            <img id="previewImg" class="mx-auto max-h-48 rounded-xl shadow-md border border-slate-200" alt="Preview">
                            <button type="button" onclick="removeImage()" class="mt-3 text-sm text-red-600 hover:text-red-700 font-medium">
                                <i class="fa-solid fa-trash mr-1"></i>Remove New Image
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm border border-slate-200 p-5 lg:p-8">
                    <div class="flex flex-col sm:flex-row gap-4 justify-between">
                        <button type="button" onclick="confirmDelete()" 
                            class="px-6 py-3 bg-red-50 text-red-700 font-semibold rounded-lg hover:bg-red-100 transition-colors flex items-center justify-center gap-2">
                            <i class="fa-solid fa-trash"></i>
                            Delete Product
                        </button>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('indexProduct') }}"
                                class="px-6 py-3 bg-slate-100 text-slate-700 font-semibold rounded-lg hover:bg-slate-200 transition-colors text-center flex items-center justify-center gap-2">
                                <i class="fa-solid fa-times"></i>
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-3 bg-slate-800 text-white font-semibold rounded-lg hover:bg-slate-900 shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-save"></i>
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
        </div>
    </main>

    <script>
        // Sidebar toggle
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const closeSidebar = document.getElementById('close-sidebar');

        menuToggle?.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        closeSidebar?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Auto-generate slug
        document.getElementById('name')?.addEventListener('input', function(e) {
            const slug = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '');
            document.getElementById('slug').value = slug;
        });

        // Image preview
        document.getElementById('image')?.addEventListener('change', function(e) {
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

        document.getElementById('price')?.addEventListener('input', calculateDiscount);
        document.getElementById('old_price')?.addEventListener('input', calculateDiscount);

        // Delete confirmation
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>

</body>
</html>