@php
    $ads = $ads ?? App\Models\Advertisement::orderBy('sort_order')->get();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertisements • Weru Hardware Admin</title>
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
        .table-row:hover { background-color: #fff7f0; }
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
            <a href="{{ route('advertisement') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-gradient-to-r from-primary to-primary-dark text-white shadow-sm">
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
                    <h2 class="text-xl font-bold text-gray-900">Advertisement Management</h2>
                    <p class="text-2xs text-gray-500 mt-0.5">Manage promotional banners and videos</p>
                </div>
                <a href="{{ route('advertisement') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold rounded-xl shadow-lg hover:shadow-xl hover-lift transition">
                    <i class="fa-solid fa-plus"></i>
                    Add New Ad
                </a>
            </div>
        </header>

        <div class="p-8 max-w-7xl mx-auto">

            <!-- Stats Bar -->
            <div class="bg-white rounded-2xl border border-orange-100 p-5 mb-6 shadow-sm">
                <div class="flex flex-wrap items-center gap-8">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-primary"></div>
                        <span class="text-sm font-bold text-gray-700">Total: <span class="text-primary">{{ $ads->count() }}</span></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <span class="text-sm font-bold text-gray-700">Active: <span class="text-green-600">{{ $ads->where('is_active', true)->count() }}</span></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                        <span class="text-sm font-bold text-gray-700">Inactive: <span class="text-gray-600">{{ $ads->where('is_active', false)->count() }}</span></span>
                    </div>
                </div>
            </div>

            @if($ads->count() === 0)
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border border-orange-100 p-16 text-center">
                    <i class="fa-solid fa-bullhorn text-6xl text-orange-200 mb-6"></i>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">No Advertisements Yet</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">Start promoting your products by creating eye-catching banners or videos for the homepage.</p>
                    <a href="{{ route('advertisement') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary to-primary-dark text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover-lift transition">
                        <i class="fa-solid fa-plus"></i>
                        Create Your First Ad
                    </a>
                </div>
            @else
                <!-- Advertisements Table -->
                <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-orange-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Preview</th>
                                    <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Title & Details</th>
                                    <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Order</th>
                                    <th class="px-6 py-4 text-right text-2xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-50">
                                @foreach($ads as $ad)
                                <tr class="table-row transition-all">
                                    <td class="px-6 py-5">
                                        <div class="w-32 h-20 rounded-xl overflow-hidden shadow-md ring-2 ring-orange-100">
                                            @if($ad->media_type === 'video')
                                                <div class="relative group cursor-pointer">
                                                    <video class="w-full h-full object-cover" muted>
                                                        <source src="{{ Storage::url($ad->media_path) }}" type="video/mp4">
                                                    </video>
                                                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                                        <i class="fa-solid fa-play text-white text-2xl"></i>
                                                    </div>
                                                </div>
                                            @else
                                                <img src="{{ Storage::url($ad->media_path) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $ad->title ?: 'Untitled Ad' }}</p>
                                            @if($ad->description)
                                                <p class="text-2xs text-gray-600 mt-1 line-clamp-2">{{ Str::limit($ad->description, 80) }}</p>
                                            @endif
                                            @if($ad->link)
                                                <a href="{{ $ad->link }}" target="_blank" class="text-2xs text-primary hover:underline mt-1 inline-block">
                                                    {{ Str::limit($ad->link, 40) }} <i class="fa-solid fa-external-link-alt ml-1"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 text-2xs font-bold rounded-full {{ $ad->media_type === 'video' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ ucfirst($ad->media_type) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 text-2xs font-bold rounded-full {{ $ad->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $ad->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-primary/10 text-primary font-bold text-sm">
                                            {{ $ad->sort_order }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="#" class="text-xs text-primary font-bold hover:text-primary-dark">
                                                Edit
                                            </a>
                                            <form action="#" method="POST" class="inline"
                                                  onsubmit="return confirm('Delete this advertisement permanently?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-bold">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-orange-50 px-6 py-4 border-t border-orange-100">
                        <p class="text-2xs text-gray-600 text-center">
                            <i class="fa-solid fa-lightbulb text-primary mr-1"></i>
                            <strong>Tip:</strong> Lower sort order numbers appear first on the homepage.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <footer class="ml-64 bg-white border-t border-orange-100 py-6">
        <div class="px-8 text-center text-2xs text-gray-500">
            © {{ date('Y') }} Weru Hardware • Built with passion in Tanzania
        </div>
    </footer>
</body>
</html>