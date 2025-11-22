<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - Weru Hardware Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#f97316',
                        secondary: '#fbbf24'
                    }
                }
            }
        }
    </script>
    <style>
        .glass-card { background: rgba(255,255,255,0.1); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.15); }
        .gradient-text { background: linear-gradient(to right, #fde047, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .category-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(249, 115, 22, 0.2); }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-orange-700 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-hard-hat text-white text-2xl"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-extrabold text-gray-900">Weru<span class="text-primary">Hardware</span></span>
                        <p class="text-xs text-gray-500 font-medium">Admin Panel</p>
                    </div>
                </div>

                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('adminDashboard') }}" class="text-gray-600 hover:text-primary font-medium transition">Dashboard</a>
                    <a href="{{ route('products') }}" class="text-primary font-bold border-b-2 border-primary">Products</a>
                    <a href="{{ route('indexCategory') }}" class="text-gray-600 hover:text-primary font-medium transition">Categories</a>
                    <a href="{{ route('advertisement') }}" class="text-gray-600 hover:text-primary font-medium transition">Ads</a>
                </nav>

                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-700">Admin</span>
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold">AD</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-6 py-10">

        <!-- Breadcrumb & Title -->
        <div class="mb-8">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                <a href="{{ route('adminDashboard') }}" class="hover:text-primary">Dashboard</a>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <a href="{{ route('createProduct') }}" class="hover:text-primary">Products</a>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span class="text-primary font-medium">Add New</span>
            </div>
            <h1 class="text-4xl font-black text-gray-900 mb-3">Add New Product</h1>
            <p class="text-lg text-gray-600">Fill in the details below to add a product to your catalog.</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-8 bg-green-50 border-2 border-green-300 text-green-800 px-6 py-4 rounded-xl flex items-center gap-3">
                <i class="fa-solid fa-check-circle text-2xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="#" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Basic Information -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-info text-primary text-xl"></i>
                    </div>
                    Basic Information
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Product Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all text-lg @error('name') border-red-500 @enderror"
                            placeholder="e.g. Twiga Cement 50kg Bag">
                        @error('name') <p class="mt-2 text-red-600 text-sm font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Slug (URL) <span class="text-red-500">*</span></label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                            class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all @error('slug') border-red-500 @enderror"
                            placeholder="twiga-cement-50kg-bag">
                        <p class="text-xs text-gray-500 mt-2">Auto-generated from name • Used in URL</p>
                        @error('slug') <p class="mt-2 text-red-600 text-sm font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Category <span class="text-red-500">*</span></label>
                        <select name="category_id" required class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all @error('category_id') border-red-500 @enderror">
                            <option value="">Choose category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->icon }} {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-2 text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Unit <span class="text-red-500">*</span></label>
                        <input type="text" name="unit" value="{{ old('unit') }}" required placeholder="e.g. bag, piece, roll, meter"
                            class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all @error('unit') border-red-500 @enderror">
                        @error('unit') <p class="mt-2 text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Description <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="5" required placeholder="Detailed description, specs, uses..."
                            class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-2 text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing & Stock -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-tag text-green-600 text-xl"></i>
                    </div>
                    Pricing & Stock
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Current Price (TZS) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" required step="100"
                            class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all text-lg @error('price') border-red-500 @enderror"
                            placeholder="28,000">
                        @error('price') <p class="mt-2 text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Old Price (Optional)</label>
                        <input type="number" name="old_price" id="old_price" value="{{ old('old_price') }}" step="100"
                            class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all"
                            placeholder="32,000">
                        <p class="text-xs text-gray-500 mt-2">For showing discount</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Stock Quantity <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0"
                            class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all text-lg @error('stock') border-red-500 @enderror"
                            placeholder="150">
                        @error('stock') <p class="mt-2 text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Live Discount Preview -->
                <div id="discountPreview" class="hidden mt-8 p-6 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-2xl">
                    <div class="flex items-center justify-center gap-4">
                        <i class="fa-solid fa-tags text-green-600 text-4xl"></i>
                        <div>
                            <p class="text-green-800 font-black text-3xl" id="discountText">Save 12%</p>
                            <p class="text-green-700 font-medium">Customers save <span id="saveAmount">TZS 4,000</span> per unit!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Image -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-image text-indigo-600 text-xl"></i>
                    </div>
                    Product Image
                </h2>

                <div class="border-4 border-dashed border-gray-300 rounded-2xl p-12 text-center hover:border-primary transition-all">
                    <input type="file" name="image" id="image" accept="image/*" class="hidden">
                    <label for="image" class="cursor-pointer">
                        <i class="fa-solid fa-cloud-arrow-up text-6xl text-gray-400 mb-6"></i>
                        <p class="text-xl font-bold text-gray-700 mb-2">Click to upload image</p>
                        <p class="text-sm text-gray-500">PNG, JPG, WebP • Max 10MB</p>
                    </label>

                    <div id="imagePreview" class="mt-8 hidden">
                        <img id="previewImg" class="mx-auto max-h-80 rounded-2xl shadow-2xl" alt="Product preview">
                        <button type="button" onclick="removeImage()" class="mt-4 text-red-600 font-bold hover:text-red-700">
                            Remove Image
                        </button>
                    </div>
                </div>
                @error('image') <p class="mt-4 text-red-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Settings -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-sliders text-purple-600 text-xl"></i>
                    </div>
                    Product Settings
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <label class="flex items-center gap-4 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                            class="w-6 h-6 text-primary rounded focus:ring-primary">
                        <div>
                            <p class="font-bold text-gray-900">Featured Product</p>
                            <p class="text-sm text-gray-600">Show on homepage & promotions</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-4 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked {{ old('is_active') ? 'checked' : '' }}
                            class="w-6 h-6 text-primary rounded focus:ring-primary">
                        <div>
                            <p class="font-bold text-gray-900">Active & Visible</p>
                            <p class="text-sm text-gray-600">Customers can see and buy</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('createProduct') }}"
                    class="px-8 py-4 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition text-center">
                    Cancel
                </a>
                <button type="submit"
                    class="px-12 py-4 bg-gradient-to-r from-primary to-orange-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all flex items-center gap-3 justify-center">
                    <i class="fa-solid fa-plus"></i>
                    Create Product
                </button>
            </div>
        </form>
    </main>

    <script>
        // Auto slug
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