<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Advertisement • Oweru Hardware Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        slate: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .text-2xs { font-size: 0.625rem; line-height: 0.875rem; }
        .hover-lift:hover { transform: translateY(-8px); box-shadow: 0 25px 40px -12px rgba(15, 23, 42, 0.15); }
        .toast { animation: slideDown 0.5s ease-out; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-slate-50 min-h-screen">

    <!-- Mobile Menu Button -->
    <button id="menu-btn" class="fixed top-4 left-4 z-50 lg:hidden bg-white rounded-full p-3 shadow-xl border border-slate-200">
        <i class="fa-solid fa-bars text-slate-700 text-xl"></i>
    </button>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <!-- Success Toast -->
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl shadow-2xl text-sm font-medium flex items-center gap-3 toast">
            <i class="fa-solid fa-check-circle text-xl"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl border-r border-slate-200 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Oweru<span class="text-slate-700">Hardware</span></h1>
                    <p class="text-2xs text-gray-500">Admin Panel</p>
                </div>
            </div>
        </div>

        <nav class="p-4 space-y-1">
            <a href="{{ route('adminDashboard') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-gauge-high w-5 h-5"></i> Dashboard
            </a>
            <a href="{{ route('ads') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl bg-gradient-to-r from-slate-800 to-slate-900 text-white shadow-md text-sm font-medium">
                <i class="fa-solid fa-bullhorn w-5 h-5"></i> Advertisements
            </a>
            <a href="{{ route('indexProduct') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-boxes-stacked w-5 h-5"></i> Products
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-tags w-5 h-5"></i> Categories
            </a>
            <a href="/OrderManagement" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-shopping-bag w-5 h-5"></i> Orders
            </a>
            <a href="{{ route('user') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-users w-5 h-5"></i> Customers
            </a>
        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-5 border-t border-slate-200 bg-slate-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-slate-800 to-slate-900 rounded-full flex items-center justify-center text-white font-bold shadow">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) : 'AD' }}
                </div>
                <div>
                    <p class="font-semibold text-slate-800 text-sm">{{ auth()->check() ? Str::limit(auth()->user()->name, 15) : 'Admin' }}</p>
                    <p class="text-2xs text-slate-500">Administrator</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-72 min-h-screen">
        <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-6 py-5 lg:px-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Edit Advertisement</h2>
                    <p class="text-sm text-slate-500 mt-1">Update advertisement details</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('ads') }}" class="text-sm font-medium text-slate-600 hover:text-slate-800">
                        <i class="fa-solid fa-arrow-left mr-2"></i>Back to Ads
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-slate-600 hover:text-slate-800">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <div class="p-5 lg:p-8 max-w-5xl mx-auto">

            <!-- Breadcrumb -->
            <div class="mb-8 text-sm text-slate-500">
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('adminDashboard') }}" class="hover:text-slate-800 font-medium">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <a href="{{ route('ads') }}" class="hover:text-slate-800 font-medium">Advertisements</a>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <span class="text-slate-800 font-bold">Edit</span>
                </div>
            </div>

            @if($errors->any())
                <div class="mb-8 p-6 bg-red-50 border border-red-200 rounded-2xl text-red-700">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fa-solid fa-circle-exclamation text-xl"></i>
                        <p class="font-bold">Please fix the following errors:</p>
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('advertisement.update', $ad->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PATCH')

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Advertisement Details</h3>
                            <p class="text-sm text-slate-500">Update the promotion information</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Title <span class="text-red-500">*</span></label>
                                <input type="text" name="title" required value="{{ old('title', $ad->title) }}"
                                       class="w-full px-5 py-3.5 rounded-xl border border-slate-200 focus:border-slate-700 focus:ring-4 focus:ring-slate-700/10 transition text-sm @error('title') border-red-400 @enderror"
                                       placeholder="e.g. 20% Off All Cement This Week!">
                                @error('title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Description <span class="text-slate-500">(optional)</span></label>
                                <textarea name="description" rows="4"
                                          class="w-full px-5 py-3.5 rounded-xl border border-slate-200 focus:border-slate-700 focus:ring-4 focus:ring-slate-700/10 transition text-sm resize-none">{{ old('description', $ad->description) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Link URL <span class="text-slate-500">(optional)</span></label>
                                <input type="url" name="link" value="{{ old('link', $ad->link) }}"
                                       class="w-full px-5 py-3.5 rounded-xl border border-slate-200 focus:border-slate-700 focus:ring-4 focus:ring-slate-700/10 transition text-sm"
                                       placeholder="https://weruhardware.co.tz/special-offer">
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Display Order</label>
                                    <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $ad->sort_order) }}"
                                           class="w-full px-5 py-3.5 rounded-xl border border-slate-200 focus:border-slate-700 focus:ring-4 focus:ring-slate-700/10 transition text-sm">
                                    <p class="text-xs text-slate-500 mt-2">Lower = appears first</p>
                                </div>
                                <div class="flex items-end">
                                    <label class="flex items-center gap-4 cursor-pointer">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $ad->is_active) ? 'checked' : '' }} class="w-6 h-6 text-slate-700 rounded focus:ring-slate-700">
                                        <span class="text-sm font-bold text-slate-700">Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Media Upload & Preview -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-4">
                                Media (Image or Video) <span class="text-slate-500">(leave blank to keep current)</span>
                            </label>

                            <!-- Current Media Preview -->
                            @if($ad->media_path)
                                <div class="mb-4 rounded-2xl overflow-hidden shadow-lg border-2 border-slate-200 relative">
                                    @if($ad->media_type === 'image')
                                        <img src="{{ asset('storage/' . $ad->media_path) }}" alt="{{ $ad->title }}" class="w-full" id="currentMedia">
                                    @else
                                        <video src="{{ asset('storage/' . $ad->media_path) }}" controls class="w-full" id="currentMedia"></video>
                                    @endif
                                    <div class="p-3 bg-gradient-to-t from-black/70 to-transparent absolute bottom-0 left-0 right-0 text-white">
                                        <p class="font-bold text-sm">Current Media</p>
                                    </div>
                                </div>
                            @endif

                            <div class="border-4 border-dashed border-slate-300 rounded-2xl p-8 text-center hover:border-slate-700 transition-all cursor-pointer">
                                <input type="file" name="media" id="media" accept="image/*,video/*" class="hidden">
                                <label for="media" class="cursor-pointer block">
                                    <i class="fa-solid fa-cloud-arrow-up text-6xl text-slate-300 mb-4"></i>
                                    <p class="text-lg font-bold text-slate-700">Click to upload new media</p>
                                    <p class="text-sm text-slate-500 mt-2">JPG, PNG, MP4, WebM • Max 50MB</p>
                                </label>
                            </div>

                            <!-- Live Preview (for new uploads) -->
                            <div id="mediaPreview" class="mt-6 hidden rounded-2xl overflow-hidden shadow-2xl border-4 border-white relative">
                                <img id="previewImg" class="w-full hidden" alt="New image preview">
                                <video id="previewVideo" class="w-full hidden" controls loop muted playsinline></video>
                                <div class="p-4 bg-gradient-to-t from-black/70 to-transparent absolute bottom-0 left-0 right-0 text-white">
                                    <p class="font-bold text-lg" id="previewTitle">New Preview</p>
                                </div>
                                <button type="button" onclick="removeMedia()" class="absolute top-4 right-4 bg-white/90 text-red-600 rounded-full p-3 shadow-lg hover:bg-white transition">
                                    <i class="fa-solid fa-xmark text-xl"></i>
                                </button>
                            </div>

                            @error('media')
                                <p class="mt-3 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-5 justify-end pt-8 border-t border-slate-100 mt-10">
                        <a href="{{ route('ads') }}"
                           class="px-10 py-4 bg-white border-2 border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition text-center">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-12 py-4 bg-gradient-to-r from-slate-800 to-slate-900 text-white font-bold rounded-xl shadow-lg hover:shadow-2xl hover-lift transition flex items-center gap-3 justify-center">
                            <i class="fa-solid fa-save text-lg"></i>
                            Update Advertisement
                        </button>
                    </div>
                </div>
            </form>

            <!-- Mobile footer spacer -->
            <div class="h-16 lg:hidden"></div>
        </div>
    </main>

    <!-- Scripts -->
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const closeSidebar = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebarFunc() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        menuBtn?.addEventListener('click', openSidebar);
        closeSidebar?.addEventListener('click', closeSidebarFunc);
        overlay?.addEventListener('click', closeSidebarFunc);

        // Close sidebar on navigation (mobile)
        if (window.innerWidth < 1024) {
            const navLinks = sidebar.querySelectorAll('nav a');
            navLinks.forEach(link => {
                link.addEventListener('click', closeSidebarFunc);
            });
        }

        // Handle escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                closeSidebarFunc();
            }
        });

        // Media preview functionality
        document.getElementById('media').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const preview = document.getElementById('mediaPreview');
            const img = document.getElementById('previewImg');
            const video = document.getElementById('previewVideo');
            const title = document.getElementById('previewTitle');
            const currentMedia = document.getElementById('currentMedia');

            // Hide current media when new file is selected
            if (currentMedia) {
                currentMedia.style.display = 'none';
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                if (file.type.startsWith('image/')) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    video.classList.add('hidden');
                    video.pause();
                } else if (file.type.startsWith('video/')) {
                    video.src = e.target.result;
                    video.classList.remove('hidden');
                    img.classList.add('hidden');
                }
                title.textContent = file.name;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        });

        function removeMedia() {
            const fileInput = document.getElementById('media');
            const preview = document.getElementById('mediaPreview');
            const currentMedia = document.getElementById('currentMedia');
            
            fileInput.value = '';
            preview.classList.add('hidden');
            document.getElementById('previewImg').src = '';
            document.getElementById('previewVideo').src = '';
            
            // Show current media again
            if (currentMedia) {
                currentMedia.style.display = '';
            }
        }

        // Auto-dismiss toast after 5 seconds
        setTimeout(() => {
            const toast = document.querySelector('.toast');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                toast.style.transition = 'all 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    </script>
</body>
</html>
