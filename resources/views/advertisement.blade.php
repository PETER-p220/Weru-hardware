{{-- resources/views/ads/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Advertisement • Weru Hardware Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#ff6b35',
                        'primary-dark': '#e85a2a',
                        'primary-light': '#fff3ed',
                    }
                }
            }
        }
    </script>

    <style>
        .text-2xs { font-size: 0.625rem; line-height: 0.875rem; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 25px -6px rgba(255,107,53,0.18); }
        input:focus, textarea:focus, select:focus { outline: none; ring: 2px solid #ff6b35; border-color: #ff6b35; }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-light via-white to-orange-50 min-h-screen">

    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3 rounded-xl shadow-lg text-xs font-medium flex items-center gap-2 animate-pulse">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl border-r border-orange-100 z-50">
        <div class="p-6 border-b border-orange-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-hard-hat text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900">Weru<span class="text-primary">Hardware</span></h1>
                    <p class="text-2xs text-gray-500">Admin Panel</p>
                </div>
            </div>
        </div>

        <nav class="p-4 space-y-1">
            <a href="{{ route('adminDashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-gauge-high w-4 h-4"></i>
                <span class="text-xs font-medium">Dashboard</span>
            </a>
            <a href="{{ route('indexProduct') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-boxes-stacked w-4 h-4"></i>
                <span class="text-xs font-medium">Products</span>
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-tags w-4 h-4"></i>
                <span class="text-xs font-medium">Categories</span>
            </a>
            <a href="/OrderManagement" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-shopping-bag w-4 h-4"></i>
                <span class="text-xs font-medium">Orders</span>
            </a>
            <a href="{{ route('user') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-users w-4 h-4"></i>
                <span class="text-xs font-medium">Users</span>
            </a>
            <a href="{{ route('ads') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-gradient-to-r from-primary to-primary-dark text-white shadow-sm">
                <i class="fa-solid fa-bullhorn w-4 h-4"></i>
                <span class="text-xs font-medium">Advertisements</span>
            </a>
        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-5 border-t border-orange-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center text-white text-xs font-bold shadow">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) : 'G' }}
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-800">
                        {{ auth()->check() ? (auth()->user()->name ?? 'Admin') : 'Guest' }}
                    </p>
                    <p class="text-2xs text-gray-500">
                        {{ auth()->check() ? (auth()->user()->hasRole('admin') ? 'Administrator' : 'User') : 'Not Logged In' }}
                    </p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        <header class="bg-white border-b border-orange-100 sticky top-0 z-40 shadow-sm">
            <div class="flex items-center justify-between px-8 py-5">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Add New Advertisement</h2>
                    <p class="text-2xs text-gray-500 mt-0.5">Create a new banner or video ad for the homepage</p>
                </div>
                <a href="{{ route('ads') }}" class="text-xs text-gray-600 hover:text-primary font-medium">
                    ← Back to Ads
                </a>
            </div>
        </header>

        <div class="p-8 max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-orange-100 bg-gradient-to-r from-primary/5 to-transparent">
                    <h3 class="text-lg font-bold text-gray-900">Advertisement Details</h3>
                </div>

                <div class="p-8">
                    <form action="{{ route('advertisement') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-7">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" required
                                   class="w-full px-5 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition"
                                   placeholder="e.g. 20% Off All Cement This Week"
                                   value="{{ old('title') }}">
                            @error('title')
                                <p class="text-red-600 text-2xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-7">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Description <span class="text-gray-500">(optional)</span></label>
                            <textarea name="description" rows="4"
                                      class="w-full px-5 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition"
                                      placeholder="Brief description of the promotion...">{{ old('description') }}</textarea>
                        </div>

                        <!-- Media Upload -->
                        <div class="mb-7">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Image or Video <span class="text-red-500">*</span>
                            </label>
                            <div class="border-2 border-dashed border-orange-200 rounded-xl p-8 text-center hover:border-primary transition">
                                <input type="file" name="media" accept="image/*,video/*" required
                                       class="hidden" id="media-upload">
                                <label for="media-upload" class="cursor-pointer">
                                    <i class="fa-solid fa-cloud-arrow-up text-4xl text-primary mb-3"></i>
                                    <p class="text-sm font-medium text-gray-700">Click to upload image or video</p>
                                    <p class="text-2xs text-gray-500 mt-1">Max 50MB • JPG, PNG, MP4, MOV</p>
                                </label>
                            </div>
                            @error('media')
                                <p class="text-red-600 text-2xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Link -->
                        <div class="mb-7">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Link URL <span class="text-gray-500">(optional)</span></label>
                            <input type="url" name="link"
                                   class="w-full px-5 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition"
                                   placeholder="https://weruhardware.co.tz/special-offer"
                                   value="{{ old('link') }}">
                        </div>

                        <!-- Sort Order -->
                        <div class="mb-7">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Display Order</label>
                            <input type="number" name="sort_order" min="1" value="{{ old('sort_order', 1) }}"
                                   class="w-full px-5 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition">
                            <p class="text-2xs text-gray-500 mt-1">Lower numbers appear first</p>
                        </div>

                        <!-- Active Toggle -->
                        <div class="mb-10 flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" id="is_active" checked
                                   class="w-5 h-5 text-primary rounded focus:ring-primary">
                            <label for="is_active" class="ml-3 text-sm font-bold text-gray-700">
                                Show on homepage immediately
                            </label>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-4">
                            <button type="submit"
                                    class="px-8 py-4 bg-gradient-to-r from-primary to-primary-dark text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover-lift transition">
                                <i class="fa-solid fa-save mr-2"></i>
                                Save Advertisement
                            </button>
                            <a href="{{ route('ads') }}"
                               class="px-8 py-4 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer class="ml-64 bg-white border-t border-orange-100 py-6">
        <div class="px-8 text-center text-2xs text-gray-500">
            © {{ date('Y') }} Weru Hardware • Built with passion in Tanzania
        </div>
    </footer>
</body>
</html>