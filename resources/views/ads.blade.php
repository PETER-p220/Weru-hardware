<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Oweru Hardware • Advertisement Management</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] }}},
            plugins: []
        }
    </script>

    <style>
        * { box-sizing: border-box; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #64748b; border-radius: 4px; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(15,23,42,0.12); }

        @media (max-width: 768px) {
            .ads-table thead { display: none; }
            .ads-table tbody { display: block; }
            .ads-table tr { display: block; margin-bottom: 1rem; background: white; border-radius: 0.875rem; overflow: hidden; box-shadow: 0 2px 8px rgba(15,23,42,0.08); border: 1px solid #e2e8f0; }
            .ads-table td { display: flex; justify-content: space-between; align-items: center; padding: 0.875rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: 0.875rem; }
            .ads-table td:last-child { border: none; }
            .ads-table td::before { content: attr(data-label); font-weight: 600; color: #334155; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 0.05em; min-width: 100px; }
        }
        .nav-active::before { content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 4px; height: 70%; background: #334155; border-radius: 0 4px 4px 0; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen overflow-x-hidden">

    <!-- Mobile Menu Button -->
    <button id="menu-toggle" class="fixed top-4 left-4 z-50 bg-white rounded-xl p-3 shadow-lg border border-slate-200 text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-bars text-xl"></i>
    </button>
    <div id="overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 hidden"></div>

    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-slate-800 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 animate-slide-down">
            <i class="fa-solid fa-check-circle text-lg"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 animate-slide-down">
            <i class="fa-solid fa-exclamation-circle text-lg"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl z-50 transform -translate-x-full transition-transform duration-300 flex flex-col border-r border-slate-200">
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
            <a href="{{ route('adminDashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium">
                <i class="fa-solid fa-gauge-high w-5"></i> Dashboard
            </a>
            <a href="{{ route('ads') }}" class="flex items-center gap-3 px-4 py-3 bg-slate-800 text-white rounded-xl font-medium nav-active">
                <i class="fa-solid fa-bullhorn w-5"></i> Advertisements
            </a>
            <a href="{{ route('indexProduct') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium">
                <i class="fa-solid fa-boxes-stacked w-5"></i> Products
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium">
                <i class="fa-solid fa-tags w-5"></i> Categories
            </a>
            <a href="/OrderManagement" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium">
                <i class="fa-solid fa-shopping-bag w-5"></i> Orders
            </a>
            <a href="{{ route('user') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-slate-100 transition font-medium">
                <i class="fa-solid fa-users w-5"></i> Customers
            </a>
        </nav>
        <div class="p-5 bg-slate-50 border-t border-slate-200">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-slate-700 rounded-full flex items-center justify-center text-white font-bold text-lg shadow">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) : 'AD' }}
                </div>
                <div><p class="font-semibold text-slate-800 text-sm truncate">{{ auth()->user()->name ?? 'Admin' }}</p><p class="text-xs text-slate-500">Administrator</p></div>
            </div>
        </div>
    </aside>

    <main class="lg:pl-72 min-h-screen">
        <header class="bg-white sticky top-0 z-40 shadow-sm border-b border-slate-200">
            <div class="px-4 lg:px-8 py-4 lg:py-5 flex items-center justify-between">
                <div class="pl-12 lg:pl-0">
                    <h2 class="text-xl lg:text-2xl font-bold text-slate-900">Advertisement Management</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Manage banners and promotional content</p>
                </div>
                <div class="flex items-center gap-4">
                   
                    <form method="POST" action="{{ route('logout') }}">@csrf 
                        <button class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-slate-900 hover:bg-slate-100 rounded-lg">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-8">
                <div class="bg-white rounded-xl lg:rounded-2xl p-4 lg:p-6 hover-lift shadow-sm border border-slate-200">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-11 h-11 bg-slate-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-bullhorn text-slate-700 text-lg"></i>
                        </div>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Total Ads</p>
                    <p class="text-2xl lg:text-3xl font-bold text-slate-900">{{ $ads->count() }}</p>
                </div>
                <div class="bg-white rounded-xl lg:rounded-2xl p-4 lg:p-6 hover-lift shadow-sm border border-slate-200">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-11 h-11 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-check-circle text-emerald-600 text-lg"></i>
                        </div>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Active Ads</p>
                    <p class="text-2xl lg:text-3xl font-bold text-slate-900">{{ $ads->where('is_active', true)->count() }}</p>
                </div>
                <div class="bg-white rounded-xl lg:rounded-2xl p-4 lg:p-6 hover-lift shadow-sm border border-slate-200 col-span-2 lg:col-span-1">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-image text-blue-600 text-lg"></i>
                        </div>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Images</p>
                    <p class="text-2xl lg:text-3xl font-bold text-slate-900">{{ $ads->where('media_type', 'image')->count() }}</p>
                </div>
            </div>

            <!-- Advertisements Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold text-slate-900">All Advertisements</h3>
                        <p class="text-sm text-slate-500">{{ $ads->count() }} advertisement(s) total</p>
                    </div>
                    <a href="{{ route('advertisement') }}" class="hidden sm:flex px-4 py-2 bg-slate-800 text-white font-semibold rounded-lg hover:bg-slate-900 transition items-center gap-2">
                        <i class="fa-solid fa-plus text-sm"></i>
                        Add Advertisement
                    </a>
                </div>

                @if($ads->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full ads-table">
                            <thead class="hidden md:table-header-group bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Preview</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Title</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Type</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Order</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Link</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-700 tracking-wide">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($ads as $ad)
                                    <tr class="hover:bg-amber-50 transition">
                                        <td data-label="Preview" class="px-6 py-4">
                                            @if($ad->media_type === 'image')
                                                <div class="w-20 h-20 rounded-lg overflow-hidden border border-slate-200 flex-shrink-0">
                                                    <img src="{{ asset('storage/' . $ad->media_path) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover">
                                                </div>
                                            @else
                                                <div class="w-20 h-20 rounded-lg overflow-hidden border border-slate-200 bg-slate-100 flex items-center justify-center flex-shrink-0">
                                                    <i class="fa-solid fa-video text-2xl text-slate-600"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td data-label="Title" class="px-6 py-4">
                                            <div>
                                                <span class="font-bold text-slate-900">{{ $ad->title }}</span>
                                                @if($ad->description)
                                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ Str::limit($ad->description, 60) }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-label="Type" class="px-6 py-4">
                                            <span class="px-3 py-1.5 text-xs font-bold rounded-full inline-block
                                                {{ $ad->media_type === 'image' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                <i class="fa-solid {{ $ad->media_type === 'image' ? 'fa-image' : 'fa-video' }} mr-1"></i>
                                                {{ ucfirst($ad->media_type) }}
                                            </span>
                                        </td>
                                        <td data-label="Status" class="px-6 py-4">
                                            @if($ad->is_active)
                                                <span class="px-3 py-1.5 text-xs font-bold rounded-full inline-block bg-green-100 text-green-800">
                                                    <i class="fa-solid fa-check-circle mr-1"></i>Active
                                                </span>
                                            @else
                                                <span class="px-3 py-1.5 text-xs font-bold rounded-full inline-block bg-slate-100 text-slate-600">
                                                    <i class="fa-solid fa-pause-circle mr-1"></i>Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td data-label="Order" class="px-6 py-4">
                                            <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-semibold">
                                                {{ $ad->sort_order }}
                                            </span>
                                        </td>
                                        <td data-label="Link" class="px-6 py-4">
                                            @if($ad->link)
                                                <a href="{{ $ad->link }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                                                    <i class="fa-solid fa-external-link text-xs"></i>
                                                    <span class="truncate max-w-[150px]">{{ $ad->link }}</span>
                                                </a>
                                            @else
                                                <span class="text-xs text-slate-400">No link</span>
                                            @endif
                                        </td>
                                        <td data-label="Actions" class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('advertisement.edit', $ad->id) }}"
                                                   class="px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors flex items-center gap-1.5"
                                                   title="Edit Advertisement">
                                                    <i class="fa-solid fa-pencil text-xs"></i>
                                                    <span class="hidden sm:inline">Edit</span>
                                                </a>
                                                <form action="{{ route('advertisement.destroy', $ad->id) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('Delete advertisement: {{ addslashes($ad->title) }}?\\n\\nThis action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="px-3 py-1.5 text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors flex items-center gap-1.5"
                                                            title="Delete Advertisement">
                                                        <i class="fa-solid fa-trash text-xs"></i>
                                                        <span class="hidden sm:inline">Delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="px-6 py-12 text-center">
                        <div class="w-24 h-24 mx-auto bg-slate-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fa-solid fa-bullhorn text-5xl text-slate-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3">No Advertisements Yet</h3>
                        <p class="text-slate-600 mb-8 max-w-md mx-auto">Start promoting your products by creating your first advertisement</p>
                        <a href="{{ route('advertisement') }}"
                           class="inline-flex items-center gap-3 px-6 py-3 bg-slate-800 text-white font-semibold rounded-xl shadow-lg hover:bg-slate-900 transition">
                            <i class="fa-solid fa-plus"></i>
                            Create First Advertisement
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script>
        // Sidebar toggle script
        const toggleBtn = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const closeBtn = document.getElementById('close-sidebar');

        function openSidebar() { 
            sidebar.classList.remove('-translate-x-full'); 
            overlay.classList.remove('hidden'); 
            document.body.style.overflow = 'hidden'; 
        }
        function closeSidebar() { 
            sidebar.classList.add('-translate-x-full'); 
            overlay.classList.add('hidden'); 
            document.body.style.overflow = ''; 
        }

        toggleBtn.addEventListener('click', () => sidebar.classList.contains('-translate-x-full') ? openSidebar() : closeSidebar());
        overlay.addEventListener('click', closeSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        document.addEventListener('keydown', e => e.key === 'Escape' && closeSidebar());

        // Auto-hide success/error messages after 5 seconds
        setTimeout(() => {
            const messages = document.querySelectorAll('[class*="animate-slide-down"]');
            messages.forEach(msg => {
                msg.style.transition = 'opacity 0.5s';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>