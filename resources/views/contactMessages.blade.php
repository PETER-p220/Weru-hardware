
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
    </script>
</head>
<body class="min-h-full bg-slate-50 text-slate-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500">Inbox</p>
                <h1 class="text-2xl font-black text-slate-900">Contact Messages</h1>
            </div>
            <a href="{{ route('adminDashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-900 px-3 py-2 rounded-lg border border-slate-200 bg-white shadow-sm hover:shadow transition">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>
 <!-- Sidebar -->
 <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl border-r border-slate-200 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
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
            <a href="/OrderManagement" class="flex items-center gap-4 px-5 py-3.5 rounded-xl bg-gradient-to-r from-slate-800 to-slate-900 text-white shadow-md text-sm font-medium">
                <i class="fa-solid fa-shopping-bag w-5"></i> Orders
            </a>
            <a href="{{ route('user') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-users w-5"></i> Users
            </a>
            <a href="{{ route('ads') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-bullhorn w-5"></i> Advertisements
            </a>
            <a href="{{ route('contact.messages') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-100 rounded-xl transition touch-feedback">
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

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-900">All Messages</p>
                    <p class="text-xs text-slate-500">Newest first</p>
                </div>
                <span class="text-xs px-3 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                    Total: {{ $messages->total() }}
                </span>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($messages as $message)
                    <div class="px-6 py-4 hover:bg-slate-50 transition">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ $message->name }}</p>
                                <p class="text-xs text-slate-500">{{ $message->email }} @if($message->phone) • {{ $message->phone }} @endif</p>
                            </div>
                            <div class="flex items-center gap-3 text-xs text-slate-500">
                                <span>{{ $message->created_at->format('M d, Y h:i A') }}</span>
                                <form method="POST" action="{{ route('contact.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 rounded-lg border border-slate-200 text-slate-600 hover:bg-red-50 hover:text-red-600 hover:border-red-200 text-xs font-semibold transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="text-sm font-bold text-slate-800 mt-2">{{ $message->subject }}</p>
                        <p class="text-sm text-slate-700 mt-1 whitespace-pre-line leading-relaxed">{{ $message->message }}</p>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-slate-500">
                        No messages yet.
                    </div>
                @endforelse
            </div>

            @if($messages->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                    {{ $messages->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>

