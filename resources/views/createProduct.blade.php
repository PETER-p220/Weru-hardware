<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add New Product • Oweru Hardware Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: 'rgb(218,165,32)',
                        'primary-dark': '#002147',
                        'primary-light': '#f5f5f5',
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --primary: rgb(218,165,32);
            --primary-dark: #002147;
            --primary-light: #f5f5f5;
        }
        * { -webkit-tap-highlight-color: transparent; }
        body { background-color: #f5f5f5; }
        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f5f5f5; }
        ::-webkit-scrollbar-thumb { background: rgb(218,165,32); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #d4af37; }
        .text-2xs { font-size: 0.625rem; line-height: 0.875rem; }
        .hover-lift:hover { transform: translateY(-6px); box-shadow: 0 20px 30px -10px rgba(218,165,32,0.2); }
        .toast { animation: slideDown 0.5s ease-out; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        /* Mobile optimizations */
        @media (max-width: 768px) {
            .text-2xl { font-size: 1.5rem; }
            .text-xl { font-size: 1.125rem; }
            .p-8 { padding: 1.5rem; }
            .p-5 { padding: 1rem; }
            .gap-8 { gap: 1.5rem; }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

    <!-- Mobile Menu Button -->
    <button id="menu-btn" class="fixed top-4 left-4 z-50 lg:hidden bg-white rounded-full p-3 shadow-xl" style="border: 1px solid rgba(218,165,32,0.2);">
        <i class="fa-solid fa-bars text-xl" style="color: #002147;"></i>
    </button>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <!-- Success Toast -->
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 border px-6 py-4 rounded-xl shadow-xl text-sm font-medium flex items-center gap-3 toast" style="background: rgba(76,175,80,0.1); border-color: rgba(76,175,80,0.3); color: #4caf50;">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out" style="border-right: 1px solid rgba(218,165,32,0.2);">
        <div class="p-6" style="border-bottom: 1px solid rgba(218,165,32,0.2);">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg" style="background: #002147;">
                    <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Oweru<span style="color: rgb(218,165,32);">Hardware</span></h1>
                    <p class="text-2xs text-gray-500">Admin Panel</p>
                </div>
            </div>
        </div>

        <nav class="p-4 space-y-1">
            <a href="{{ route('adminDashboard') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-gray-600 transition text-sm font-medium" style="color: #666;" onmouseover="this.style.backgroundColor='rgba(218,165,32,0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                <i class="fa-solid fa-gauge-high w-5 h-5"></i> Dashboard
            </a>
            <a href="{{ route('indexProduct') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-white shadow-md text-sm font-medium" style="background: #002147;">
                <i class="fa-solid fa-boxes-stacked w-5 h-5"></i> Products
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-gray-600 transition text-sm font-medium" style="color: #666;" onmouseover="this.style.backgroundColor='rgba(218,165,32,0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                <i class="fa-solid fa-tags w-5 h-5"></i> Categories
            </a>
            <a href="/OrderManagement" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-gray-600 transition text-sm font-medium" style="color: #666;" onmouseover="this.style.backgroundColor='rgba(218,165,32,0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                <i class="fa-solid fa-shopping-bag w-5 h-5"></i> Orders
            </a>
            <a href="{{ route('user') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-gray-600 transition text-sm font-medium" style="color: #666;" onmouseover="this.style.backgroundColor='rgba(218,165,32,0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                <i class="fa-solid fa-users w-5 h-5"></i> Customers
            </a>
        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-5 bg-gray-50" style="border-top: 1px solid rgba(218,165,32,0.2);">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold shadow" style="background: #002147;">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) : 'AD' }}
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">{{ auth()->check() ? Str::limit(auth()->user()->name, 15) : 'Admin' }}</p>
                    <p class="text-2xs text-gray-500">Administrator</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-72 min-h-screen">
        <header class="bg-white sticky top-0 z-40 shadow-sm" style="border-bottom: 1px solid rgba(218,165,32,0.2);">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-5 lg:px-8 py-4 lg:py-5 gap-4">
                <div>
                    <h2 class="text-lg lg:text-2xl font-bold text-gray-900">Add New Product</h2>
                    <p class="text-xs lg:text-sm text-gray-500 mt-1">Create a new product in your catalog</p>
                </div>
                <div class="flex items-center gap-4 flex-wrap">
                    <a href="{{ route('indexProduct') }}" class="text-xs lg:text-sm font-medium text-gray-600 hover:text-gray-900">
                        <i class="fa-solid fa-arrow-left mr-2"></i>Back to Products
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs lg:text-sm font-medium text-gray-600 hover:text-gray-900">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8 max-w-6xl mx-auto">

            <!-- Breadcrumb -->
            <div class="mb-6 lg:mb-8 text-xs lg:text-sm text-gray-500">
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('adminDashboard') }}" class="hover:text-gray-900 font-medium">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <a href="{{ route('indexProduct') }}" class="hover:text-gray-900 font-medium">Products</a>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <span font-bold" style="color: #002147;">Add New</span>
                </div>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 lg:mb-8 p-4 lg:p-6 rounded-lg lg:rounded-2xl text-red-700" style="background: rgba(211,47,47,0.1); border: 1px solid rgba(211,47,47,0.3);">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fa-solid fa-circle-exclamation text-lg lg:text-xl"></i>
                        <p class="font-bold text-sm lg:text-base">Please fix the following errors:</p>
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-xs lg:text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="#" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Basic Information -->
                <div class="bg-white rounded-lg lg:rounded-2xl shadow-sm p-5 lg:p-8 mb-6 lg:mb-8" style="border: 1px solid rgba(218,165,32,0.2);">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-lg lg:rounded-xl flex items-center justify-center shadow-lg" style="background: #002147;">
                            <i class="fa-solid fa-info text-white text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-base lg:text-xl font-bold text-gray-900">Basic Information</h3>
                            <p class="text-xs lg:text-sm text-gray-500">Essential product details</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                        <div class="lg:col-span-2">
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">Product Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full px-4 lg:px-5 py-2 lg:py-3.5 rounded-lg lg:rounded-xl border border-gray-200 text-xs lg:text-sm transition @error('name') border-red-400 @enderror" style="focus-color: rgb(218,165,32); focus-ring-color: rgba(218,165,32,0.1);" 
                                placeholder="e.g. Twiga Cement 50kg Bag">
                            @error('name')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="lg:col-span-2">
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">Slug (URL) <span class="text-red-500">*</span></label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                                class="w-full px-4 lg:px-5 py-2 lg:py-3.5 rounded-lg lg:rounded-xl border border-gray-200 text-xs lg:text-sm transition @error('slug') border-red-400 @enderror"
                                placeholder="twiga-cement-50kg-bag">
                            <p class="text-2xs text-gray-500 mt-2">Auto-generated from name</p>
                        </div>

                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                            <select name="category_id" required class="w-full px-4 lg:px-5 py-2 lg:py-3.5 rounded-lg lg:rounded-xl border border-gray-200 text-xs lg:text-sm @error('category_id') border-red-400 @enderror">
                                <option value="">Choose category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->icon }} {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">Unit <span class="text-red-500">*</span></label>
                            <input type="text" name="unit" value="{{ old('unit') }}" required placeholder="e.g. bag, piece, meter"
                                class="w-full px-4 lg:px-5 py-2 lg:py-3.5 rounded-lg lg:rounded-xl border border-gray-200 text-xs lg:text-sm @error('unit') border-red-400 @enderror">
                        </div>

                        <div class="lg:col-span-2">
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">Description <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="5" lg:rows="6" required placeholder="Detailed description, specifications, uses..."
                                class="w-full px-4 lg:px-5 py-2 lg:py-3.5 rounded-lg lg:rounded-xl border border-gray-200 resize-none text-xs lg:text-sm @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="bg-white rounded-lg lg:rounded-2xl shadow-sm p-5 lg:p-8 mb-6 lg:mb-8" style="border: 1px solid rgba(218,165,32,0.2);">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-lg lg:rounded-xl flex items-center justify-center shadow-lg" style="background: #4caf50;">
                            <i class="fa-solid fa-tag text-white text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-base lg:text-xl font-bold text-gray-900">Pricing & Stock</h3>
                            <p class="text-xs lg:text-sm text-gray-500">Set price and inventory levels</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6">
                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">Current Price (TZS) <span class="text-red-500">*</span></label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required step="100"
                                class="w-full px-4 lg:px-5 py-2 lg:py-3.5 rounded-lg lg:rounded-xl border border-gray-200 text-xs lg:text-sm @error('price') border-red-400 @enderror"
                                placeholder="28000">
                        </div>
                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">Old Price (Optional)</label>
                            <input type="number" name="old_price" id="old_price" value="{{ old('old_price') }}" step="100"
                                class="w-full px-4 lg:px-5 py-2 lg:py-3.5 rounded-lg lg:rounded-xl border border-gray-200 text-xs lg:text-sm"
                                placeholder="32000">
                            <p class="text-2xs text-gray-500 mt-2">Shows discount badge</p>
                        </div>
                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">Stock Quantity <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0"
                                class="w-full px-4 lg:px-5 py-2 lg:py-3.5 rounded-lg lg:rounded-xl border border-gray-200 text-xs lg:text-sm @error('stock') border-red-400 @enderror"
                                placeholder="150">
                        </div>
                    </div>

                    <div id="discountPreview" class="hidden mt-6 lg:mt-8 p-4 lg:p-6 rounded-lg lg:rounded-2xl" style="background: rgba(76,175,80,0.1); border: 2px solid rgba(76,175,80,0.2);">
                        <div class="flex items-center gap-3 lg:gap-5">
                            <div class="w-10 lg:w-14 h-10 lg:h-14 rounded-full flex items-center justify-center flex-shrink-0" style="background: rgba(76,175,80,0.15);">
                                <i class="fa-solid fa-gift text-lg lg:text-2xl" style="color: #4caf50;"></i>
                            </div>
                            <div>
                                <p class="text-lg lg:text-2xl font-bold" style="color: #4caf50;" id="discountText">Save 12%</p>
                                <p class="text-sm lg:text-base" style="color: #4caf50;">Customers save <span id="saveAmount">TZS 4,000</span> per unit!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Image -->
                <div class="bg-white rounded-lg lg:rounded-2xl shadow-sm p-5 lg:p-8 mb-6 lg:mb-8" style="border: 1px solid rgba(218,165,32,0.2);">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-lg lg:rounded-xl flex items-center justify-center shadow-lg" style="background: #2196F3;">
                            <i class="fa-solid fa-image text-white text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-base lg:text-xl font-bold text-gray-900">Product Image</h3>
                            <p class="text-xs lg:text-sm text-gray-500">Upload a high-quality photo</p>
                        </div>
                    </div>

                    <div class="border-4 border-dashed border-gray-300 rounded-lg lg:rounded-2xl p-8 lg:p-12 text-center hover:border-gray-400 transition-all cursor-pointer" style="border-color: rgba(218,165,32,0.2);">
                        <input type="file" name="image" id="image" accept="image/*" class="hidden">
                        <label for="image" class="cursor-pointer block">
                            <i class="fa-solid fa-cloud-arrow-up text-4xl lg:text-6xl text-gray-300 mb-3 lg:mb-4"></i>
                            <p class="text-base lg:text-lg font-bold text-gray-700">Click to upload image</p>
                            <p class="text-xs lg:text-sm text-gray-500 mt-2">PNG, JPG, WebP • Max 10MB</p>
                        </label>

                        <div id="imagePreview" class="mt-6 lg:mt-8 hidden">
                            <img id="previewImg" class="mx-auto max-h-96 rounded-lg lg:rounded-2xl shadow-2xl border-4 border-white" alt="Product preview">
                            <button type="button" onclick="removeImage()" class="mt-4 px-5 lg:px-6 py-2 text-red-600 font-bold rounded-lg hover:bg-red-50 transition text-sm">
                                Remove Image
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Settings -->
                <div class="bg-white rounded-lg lg:rounded-2xl shadow-sm p-5 lg:p-8 mb-6 lg:mb-8" style="border: 1px solid rgba(218,165,32,0.2);">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-lg lg:rounded-xl flex items-center justify-center shadow-lg" style="background: #9333ea;">
                            <i class="fa-solid fa-sliders text-white text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-base lg:text-xl font-bold text-gray-900">Product Settings</h3>
                            <p class="text-xs lg:text-sm text-gray-500">Visibility and promotion options</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <label class="flex items-center gap-4 lg:gap-5 p-4 lg:p-5 rounded-lg lg:rounded-2xl cursor-pointer transition" style="border: 2px solid rgba(218,165,32,0.1);" onmouseover="this.style.borderColor='rgba(218,165,32,0.3)'; this.style.backgroundColor='rgba(218,165,32,0.05)'" onmouseout="this.style.borderColor='rgba(218,165,32,0.1)'; this.style.backgroundColor='transparent'">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                class="w-5 lg:w-6 h-5 lg:h-6 rounded" style="accent-color: rgb(218,165,32);">
                            <div>
                                <p class="font-bold text-gray-900 text-base lg:text-lg">Featured Product</p>
                                <p class="text-xs lg:text-sm text-gray-600">Appear on homepage & special banners</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 lg:gap-5 p-4 lg:p-5 rounded-lg lg:rounded-2xl cursor-pointer transition" style="border: 2px solid rgba(218,165,32,0.1);" onmouseover="this.style.borderColor='rgba(218,165,32,0.3)'; this.style.backgroundColor='rgba(218,165,32,0.05)'" onmouseout="this.style.borderColor='rgba(218,165,32,0.1)'; this.style.backgroundColor='transparent'">
                            <input type="checkbox" name="is_active" value="1" checked {{ old('is_active', true) ? 'checked' : '' }}
                                class="w-5 lg:w-6 h-5 lg:h-6 rounded" style="accent-color: rgb(218,165,32);">
                            <div>
                                <p class="font-bold text-gray-900 text-base lg:text-lg">Active & Visible</p>
                                <p class="text-xs lg:text-sm text-gray-600">Customers can view and buy</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 lg:gap-5 justify-end pt-6 lg:pt-8">
                    <a href="{{ route('indexProduct') }}"
                        class="px-8 lg:px-10 py-3 lg:py-4 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-lg lg:rounded-xl hover:bg-gray-50 transition text-center text-sm lg:text-base">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-10 lg:px-12 py-3 lg:py-4 text-white font-bold rounded-lg lg:rounded-xl shadow-lg hover:shadow-2xl hover-lift transition flex items-center gap-2 lg:gap-3 justify-center text-sm lg:text-base" style="background: #002147;">
                        <i class="fa-solid fa-plus text-lg lg:text-xl"></i>
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Scripts -->
    <script>
        // Mobile menu
        document.getElementById('menu-btn')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('mobile-overlay').classList.toggle('hidden');
        });
        document.getElementById('mobile-overlay')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('mobile-overlay').classList.add('hidden');
        });

        // Auto slug
        document.getElementById('name')?.addEventListener('input', function() {
            const slug = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('slug').value = slug;
        });

        // Image preview
        document.getElementById('image')?.addEventListener('change', function(e) {
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

        // Live discount preview
        function updateDiscount() {
            const price = parseFloat(document.getElementById('price').value) || 0;
            const oldPrice = parseFloat(document.getElementById('old_price').value) || 0;

            const preview = document.getElementById('discountPreview');
            if (oldPrice > price && price > 0) {
                const discount = Math.round(((oldPrice - price) / oldPrice) * 100);
                const saved = oldPrice - price;
                document.getElementById('discountText').textContent = `Save ${discount}%`;
                document.getElementById('saveAmount').textContent = `TZS ${saved.toLocaleString()}`;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }
        document.getElementById('price')?.addEventListener('input', updateDiscount);
        document.getElementById('old_price')?.addEventListener('input', updateDiscount);
    </script>
</body>
</html>