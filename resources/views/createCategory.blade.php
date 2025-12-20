<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add New Category • Oweru Hardware</title>

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
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f5f5f5; }
        ::-webkit-scrollbar-thumb { background: rgb(218,165,32); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #d4af37; }
        .text-2xs { font-size: 0.625rem; line-height: 0.875rem; }
        .hover-lift:hover { transform: translateY(-6px); box-shadow: 0 20px 30px -10px rgba(218,165,32,0.2); }
        .toast { animation: slideDown 0.5s ease-out; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 768px) {
            .text-2xl { font-size: 1.5rem; }
            .text-xl { font-size: 1.125rem; }
            .p-8 { padding: 1.5rem; }
            .p-5 { padding: 1rem; }
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
            <a href="{{ route('indexProduct') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-gray-600 transition text-sm font-medium" style="color: #666;" onmouseover="this.style.backgroundColor='rgba(218,165,32,0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                <i class="fa-solid fa-boxes-stacked w-5 h-5"></i> Products
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-white shadow-md text-sm font-medium" style="background: #002147;">
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
                    <h2 class="text-lg lg:text-2xl font-bold text-gray-900">Add New Category</h2>
                    <p class="text-xs lg:text-sm text-gray-500 mt-1">Create a new product category</p>
                </div>
                <div class="flex items-center gap-4 flex-wrap">
                    <a href="{{ route('indexCategory') }}" class="text-xs lg:text-sm font-medium text-gray-600 hover:text-gray-900">
                        <i class="fa-solid fa-arrow-left mr-2"></i>Back to Categories
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs lg:text-sm font-medium text-gray-600 hover:text-gray-900">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8 max-w-4xl mx-auto">

            <!-- Breadcrumb -->
            <div class="mb-6 lg:mb-8 text-xs lg:text-sm text-gray-500">
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('adminDashboard') }}" class="hover:text-gray-900 font-medium">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <a href="{{ route('indexCategory') }}" class="hover:text-gray-900 font-medium">Categories</a>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <span style="color: #002147; font-weight: bold;">Add New</span>
                </div>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 lg:mb-8 p-4 lg:p-5 rounded-lg lg:rounded-2xl text-red-700" style="background: rgba(211,47,47,0.1); border: 1px solid rgba(211,47,47,0.3);">
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
            <form method="POST" action="{{ route('createCategory') }}" class="space-y-8">
                @csrf

                <!-- Category Details Card -->
                <div class="bg-white rounded-lg lg:rounded-2xl shadow-sm p-5 lg:p-8" style="border: 1px solid rgba(218,165,32,0.2);">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-lg lg:rounded-xl flex items-center justify-center shadow-lg" style="background: #002147;">
                            <i class="fa-solid fa-tag text-white text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-base lg:text-xl font-bold text-gray-900">Category Information</h3>
                            <p class="text-xs lg:text-sm text-gray-500">Fill in the details below</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 lg:px-5 py-2 lg:py-3.5 rounded-lg lg:rounded-xl border border-gray-200 text-xs lg:text-sm transition @error('name') border-red-400 @enderror"
                                placeholder="e.g., Electrical Tools">
                            @error('name')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">
                                Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required
                                class="w-full px-4 lg:px-5 py-2 lg:py-3.5 rounded-lg lg:rounded-xl border border-gray-200 text-xs lg:text-sm transition @error('slug') border-red-400 @enderror"
                                placeholder="electrical-tools">
                            <p class="text-2xs text-gray-500 mt-2">Auto-generated from name</p>
                        </div>

                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">
                                Icon (Emoji or Class)
                            </label>
                            <input type="text" id="icon" name="icon" value="{{ old('icon', 'folder') }}"
                                class="w-full px-4 lg:px-5 py-2 lg:py-3.5 rounded-lg lg:rounded-xl border border-gray-200 text-xs lg:text-sm transition"
                                placeholder="e.g., tools or fa-screwdriver-wrench">
                        </div>

                        <div>
                            <label class="block text-xs lg:text-sm font-bold text-gray-700 mb-2">
                                Display Order
                            </label>
                            <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                                class="w-full px-4 lg:px-5 py-2 lg:py-3.5 rounded-lg lg:rounded-xl border border-gray-200 text-xs lg:text-sm transition"
                                placeholder="0">
                            <p class="text-2xs text-gray-500 mt-2">Lower = appears first</p>
                        </div>
                    </div>
                </div>

                <!-- Live Preview Card -->
                <div class="bg-white rounded-lg lg:rounded-2xl shadow-sm p-5 lg:p-8" style="border: 1px solid rgba(218,165,32,0.2);">
                    <div class="flex items-center gap-3 lg:gap-4 mb-6 lg:mb-8">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-lg lg:rounded-xl flex items-center justify-center shadow-lg" style="background: #002147;">
                            <i class="fa-solid fa-eye text-white text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-base lg:text-xl font-bold text-gray-900">Live Preview</h3>
                            <p class="text-xs lg:text-sm text-gray-500">How it will appear in the store</p>
                        </div>
                    </div>

                    <div class="rounded-lg lg:rounded-2xl p-6 lg:p-12 text-center" style="background: #f5f5f5; border: 2px dashed rgba(218,165,32,0.3);">
                        <div class="inline-flex items-center gap-3 lg:gap-5 px-6 lg:px-8 py-4 lg:py-6 bg-white rounded-lg lg:rounded-2xl shadow-lg" style="border: 2px solid rgba(218,165,32,0.2);">
                            <span id="previewIcon" class="text-3xl lg:text-5xl">folder</span>
                            <div class="text-left">
                                <p id="previewName" class="text-base lg:text-2xl font-bold text-gray-800">Category Name</p>
                                <p class="text-xs lg:text-sm text-gray-500 mt-1">0 products</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 lg:gap-4 justify-end pt-6 lg:pt-8">
                    <a href="{{ route('indexCategory') }}"
                        class="px-6 lg:px-8 py-2 lg:py-4 bg-white text-gray-700 font-bold rounded-lg lg:rounded-xl transition text-center text-xs lg:text-sm"
                        style="border: 1px solid rgba(0,33,71,0.2);">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-8 lg:px-10 py-3 lg:py-4 text-white font-bold rounded-lg lg:rounded-xl shadow-lg transition text-xs lg:text-sm flex items-center gap-2 lg:gap-3 justify-center"
                        style="background: #002147;">
                        <i class="fa-solid fa-plus"></i>
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Scripts -->
    <script>
        // Auto-generate slug
        document.getElementById('name').addEventListener('input', function(e) {
            const slug = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('slug').value = slug;
            document.getElementById('previewName').textContent = e.target.value || 'Category Name';
        });

        // Update icon preview
        document.getElementById('icon').addEventListener('input', function(e) {
            const icon = e.target.value.trim();
            const preview = document.getElementById('previewIcon');
            if (icon && !icon.includes('fa-')) {
                preview.textContent = icon;
            } else {
                preview.innerHTML = icon ? `<i class="fa-solid ${icon}"></i>` : 'folder';
            }
        });

        // Mobile menu toggle
        document.getElementById('menu-btn')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('mobile-overlay').classList.toggle('hidden');
        });

        document.getElementById('mobile-overlay')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('mobile-overlay').classList.add('hidden');
        });
    </script>
</body>
</html>