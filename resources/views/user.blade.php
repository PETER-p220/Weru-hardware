@php
    use App\Models\User;
    use Spatie\Permission\Models\Role;

    $users = User::paginate(10);

    $adminRole = Role::where('name', 'admin')->first();
    $customerRole = Role::where('name', 'user')->first();

    $adminCount     = $adminRole?->users()->count() ?? 0;
    $customerCount  = $customerRole?->users()->count() ?? 0;
    $activeToday    = User::whereDate('updated_at', today())->count();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management • Weru Hardware Admin</title>
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

    {{-- Success Message --}}
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3 rounded-xl shadow-lg text-xs font-medium flex items-center gap-2 animate-pulse">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Sidebar – SAFE: No crash if not logged in --}}
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
            <a href="{{ route('user') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-gradient-to-r from-primary to-primary-dark text-white shadow-sm">
                <i class="fa-solid fa-users w-4 h-4"></i>
                <span class="text-xs font-medium">Users</span>
            </a>
        </nav>

        {{-- User Info – 100% SAFE --}}
        <div class="absolute bottom-0 left-0 right-0 p-5 border-t border-orange-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center text-white text-xs font-bold shadow">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name ?? 'User', 0, 2)) : 'G' }}
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-800">
                        {{ auth()->check() ? (auth()->user()->name ?? 'Unknown User') : 'Guest' }}
                    </p>
                    <p class="text-2xs text-gray-500">
                        {{ auth()->check()
                            ? (auth()->user()->hasRole('admin') ? 'Administrator' : 'User')
                            : 'Not Logged In'
                        }}
                    </p>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="ml-64 min-h-screen">
        {{-- Top Bar --}}
        <header class="bg-white border-b border-orange-100 sticky top-0 z-40 shadow-sm">
            <div class="flex items-center justify-between px-8 py-5">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Users Management</h2>
                    <p class="text-2xs text-gray-500 mt-0.5">Manage all registered customers and administrators</p>
                </div>
                <div class="flex items-center gap-6">
                    <a href="{{ route('adminDashboard') }}" class="text-xs text-gray-600 hover:text-primary font-medium">
                        ← Back to Dashboard
                    </a>
                    @if(auth()->check())
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-gray-600 hover:text-primary font-medium">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-xs text-primary font-medium">
                            Login
                        </a>
                    @endif
                </div>
            </div>
        </header>

        <div class="p-8 max-w-7xl mx-auto">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl border border-orange-100 p-6 hover-lift transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-2xs font-bold text-gray-500 uppercase">Total Users</span>
                        <i class="fa-solid fa-users text-primary text-lg"></i>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $users->total() }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-orange-100 p-6 hover-lift transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-2xs font-bold text-gray-500 uppercase">Admins</span>
                        <i class="fa-solid fa-shield-halved text-purple-600 text-lg"></i>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $adminCount }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-orange-100 p-6 hover-lift transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-2xs font-bold text-gray-500 uppercase">Customers</span>
                        <i class="fa-solid fa-user text-green-600 text-lg"></i>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $customerCount }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-orange-100 p-6 hover-lift transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-2xs font-bold text-gray-500 uppercase">Active Today</span>
                        <i class="fa-solid fa-circle-dot text-primary text-lg"></i>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $activeToday }}</p>
                </div>
            </div>

            {{-- Users Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-orange-100">
                    <h3 class="text-sm font-bold text-gray-800">All Users ({{ $users->total() }})</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-orange-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">User</th>
                                <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Joined</th>
                                <th class="px-6 py-4 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-orange-50">
                            @foreach($users as $user)
                            <tr class="table-row transition-all">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                            {{ strtoupper(substr($user->name ?? '??', 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $user->name ?? 'No Name' }}</p>
                                            <p class="text-2xs text-gray-500">ID: #{{ $user->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div>
                                        <p class="text-xs text-gray-900">{{ $user->email }}</p>
                                        <p class="text-2xs text-gray-500">
                                            {{ $user->tel ? '+255 ' . substr($user->tel, 3) : '—' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @if($user->hasRole('admin'))
                                        <span class="px-3 py-1 text-2xs font-bold text-purple-700 bg-purple-100 rounded-full">Administrator</span>
                                    @else
                                        <span class="px-3 py-1 text-2xs font-bold text-primary bg-orange-100 rounded-full">Customer</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    @if($user->email_verified_at)
                                        <span class="px-3 py-1 text-2xs font-bold text-green-700 bg-green-100 rounded-full">Verified</span>
                                    @else
                                        <span class="px-3 py-1 text-2xs font-bold text-yellow-700 bg-yellow-100 rounded-full">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-xs text-gray-600">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-5">
                                    @if(auth()->check() && auth()->user()->hasRole('admin'))
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Delete {{ addslashes($user->name ?? 'user') }} permanently?')"
                                                    class="text-2xs text-red-600 hover:text-red-800 font-bold">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-orange-50 px-6 py-5 border-t border-orange-100">
                    {{ $users->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="ml-64 bg-white border-t border-orange-100 py-6">
        <div class="px-8 text-center text-2xs text-gray-500">
            © {{ date('Y') }} Weru Hardware • Built with passion in Tanzania
        </div>
    </footer>
</body>
</html>