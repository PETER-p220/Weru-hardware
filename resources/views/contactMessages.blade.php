<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
    <style>
        .text-2xs {
            font-size: 0.625rem;
            line-height: 0.75rem;
        }
    </style>
</head>
<body class="min-h-full bg-slate-50 text-slate-800">
    
    <!-- Mobile Menu Button -->
    <div class="lg:hidden fixed top-4 left-4 z-50">
        <button onclick="toggleSidebar()" class="p-3 bg-white rounded-xl shadow-lg border border-slate-200 hover:bg-slate-50 transition">
            <i class="fa-solid fa-bars text-slate-800 text-xl"></i>
        </button>
    </div>

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl border-r border-slate-200 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">
        <!-- Close Button (Mobile) -->
        <div class="lg:hidden absolute top-4 right-4">
            <button onclick="toggleSidebar()" class="p-2 hover:bg-slate-100 rounded-lg transition">
                <i class="fa-solid fa-xmark text-slate-600 text-xl"></i>
            </button>
        </div>

        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-hard-hat text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Oweru<span class="text-slate-700">Hardware</span></h1>
                    <p class="text-2xs text-slate-500">Admin Panel</p>
                </div>
            </div>
        </div>

        <nav class="p-4 space-y-1">
            <a href="{{ route('adminDashboard') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-gauge-high w-5"></i> Dashboard
            </a>
            <a href="{{ route('indexProduct') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-boxes-stacked w-5"></i> Products
            </a>
            <a href="{{ route('indexCategory') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-tags w-5"></i> Categories
            </a>
            <a href="/OrderManagement" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-shopping-bag w-5"></i> Orders
            </a>
            <a href="{{ route('user') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-users w-5"></i> Users
            </a>
            <a href="{{ route('ads') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-bullhorn w-5"></i> Advertisements
            </a>
            <a href="{{ route('contact.messages') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl bg-gradient-to-r from-slate-800 to-slate-900 text-white shadow-md text-sm font-medium">
                <i class="fa-solid fa-envelope w-5"></i>
                <span>Contact Messages</span>
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



    
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-8">
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Messages</p>
                            <p class="text-3xl font-black text-slate-900">{{ $messages->total() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-inbox text-2xl text-slate-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">This Month</p>
                            <p class="text-3xl font-black text-slate-900">{{ \App\Models\ContactMessage::whereMonth('created_at', now()->month)->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-calendar text-2xl text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Today</p>
                            <p class="text-3xl font-black text-slate-900">{{ \App\Models\ContactMessage::whereDate('created_at', today())->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-clock text-2xl text-green-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500">Inbox</p>
                    <h1 class="text-3xl font-black text-slate-900">Contact Messages</h1>
                </div>
                <a href="{{ route('adminDashboard') }}" class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-900 px-4 py-2.5 rounded-lg border border-slate-200 bg-white shadow-sm hover:shadow transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>

            <!-- Messages Container -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">All Messages</p>
                            <p class="text-xs text-slate-500">Newest first</p>
                        </div>
                        <span class="inline-flex items-center gap-2 text-xs px-3 py-1.5 rounded-full bg-slate-800 text-white border border-slate-700 font-semibold">
                            <i class="fa-solid fa-inbox"></i>
                            Total: {{ $messages->total() }}
                        </span>
                    </div>
                </div>

                <!-- Messages List -->
                <div class="divide-y divide-slate-100">
                    @forelse($messages as $message)
                        <div class="px-6 py-5 hover:bg-slate-50 transition">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-3 mb-3">
                                <div class="flex-1">
                                    <div class="flex items-start gap-3 mb-2">
                                        <div class="w-10 h-10 bg-gradient-to-br from-slate-700 to-slate-900 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                            {{ strtoupper(substr($message->name, 0, 2)) }}
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-base font-bold text-slate-900">{{ $message->name }}</p>
                                            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500 mt-1">
                                                <span class="inline-flex items-center gap-1">
                                                    <i class="fa-solid fa-envelope"></i>
                                                    {{ $message->email }}
                                                </span>
                                                @if($message->phone)
                                                    <span class="text-slate-300">•</span>
                                                    <span class="inline-flex items-center gap-1">
                                                        <i class="fa-solid fa-phone"></i>
                                                        {{ $message->phone }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-slate-500 whitespace-nowrap">
                                        <i class="fa-solid fa-clock mr-1"></i>
                                        {{ $message->created_at->format('M d, Y h:i A') }}
                                    </span>
                                    <form method="POST" action="{{ route('contact.messages.destroy', $message) }}" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-red-50 hover:text-red-600 hover:border-red-200 text-xs font-semibold transition">
                                            <i class="fa-solid fa-trash mr-1"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Subject -->
                            <div class="mb-3 pl-13">
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold">
                                    <i class="fa-solid fa-tag"></i>
                                    {{ $message->subject }}
                                </span>
                            </div>

                            <!-- Message Content -->
                            <div class="pl-13 bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <p class="text-sm text-slate-700 whitespace-pre-line leading-relaxed">{{ $message->message }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-16 text-center">
                            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-inbox text-4xl text-slate-400"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2">No messages yet</h3>
                            <p class="text-sm text-slate-500">Contact messages will appear here when customers reach out.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($messages->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                        {{ $messages->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>

    </main>

</body>
</html>