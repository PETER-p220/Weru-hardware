<?php
use App\Models\User;
use Spatie\Permission\Models\Role;

$users = User::paginate(10);

// Safe counts – will never crash
$adminRole = Role::where('name', 'admin')->first();
$customerRole = Role::where('name', 'user')->first();

$adminCount     = $adminRole ? $adminRole->users()->count() : 0;
$customerCount  = $customerRole ? $customerRole->users()->count() : 0;

// Fallback for "Active Today" – uses `updated_at` (exists in every Laravel app)
$activeToday    = User::whereDate('updated_at', today())->count();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management - Weru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff6b35',
                        'primary-dark': '#e85a2a',
                        'primary-light': '#ff8c5f',
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        .text-xs { font-size: 0.6875rem; }
        .text-2xs { font-size: 0.625rem; }
        .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px -5px rgba(255, 107, 53, 0.2); }
        .table-row:hover { background-color: #fff7f0; }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-white to-orange-50 min-h-screen font-sans">

    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-lg shadow-lg text-xs font-medium flex items-center gap-2 animate-pulse">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-orange-100 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-hard-hat text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900">Weru <span class="text-primary">Hardware</span></h1>
                    <p class="text-2xs text-gray-500">Admin • Users Management</p>
                </div>
            </div>

            <nav class="hidden md:flex items-center space-x-6">
                <a href="/adminDashboard" class="text-xs font-medium text-gray-600 hover:text-primary">Dashboard</a>
                <a href="/createProduct" class="text-xs font-medium text-gray-600 hover:text-primary">Products</a>
                <a href="/OrderManagement" class="text-xs font-medium text-gray-600 hover:text-primary">Orders</a>
                <a href="/user" class="text-xs font-bold text-primary border-b-2 border-primary pb-1">Users</a>
            </nav>

            <div class="flex items-center space-x-3">
                <span class="text-xs font-medium text-gray-700">Admin</span>
                <div class="w-8 h-8 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center text-white text-xs font-bold">A</div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">

        <!-- Page Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-900">Users Management</h1>
                <p class="text-2xs text-gray-500 mt-1">Manage all registered customers & admins</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl border border-orange-100 p-4 hover-lift transition-all">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xs font-bold text-gray-500 uppercase tracking-wider">Total Users</span>
                    <div class="p-1.5 bg-blue-100 rounded-lg"><i class="fa-solid fa-users text-blue-600 text-xs"></i></div>
                </div>
                <p class="text-xl font-bold text-gray-900">{{ $users->total() }}</p>
            </div>

            <div class="bg-white rounded-xl border border-orange-100 p-4 hover-lift transition-all">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xs font-bold text-gray-500 uppercase tracking-wider">Admins</span>
                    <div class="p-1.5 bg-purple-100 rounded-lg"><i class="fa-solid fa-shield-halved text-purple-600 text-xs"></i></div>
                </div>
                <p class="text-xl font-bold text-gray-900">{{ $adminCount }}</p>
            </div>

            <div class="bg-white rounded-xl border border-orange-100 p-4 hover-lift transition-all">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xs font-bold text-gray-500 uppercase tracking-wider">Customers</span>
                    <div class="p-1.5 bg-green-100 rounded-lg"><i class="fa-solid fa-user text-green-600 text-xs"></i></div>
                </div>
                <p class="text-xl font-bold text-gray-900">{{ $customerCount }}</p>
            </div>

            <div class="bg-white rounded-xl border border-orange-100 p-4 hover-lift transition-all">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xs font-bold text-gray-500 uppercase tracking-wider">Active Today</span>
                    <div class="p-1.5 bg-orange-100 rounded-lg"><i class="fa-solid fa-circle-dot text-primary text-xs"></i></div>
                </div>
                <p class="text-xl font-bold text-gray-900">{{ $activeToday }}</p>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-xl border border-orange-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-orange-100">
                <p class="text-xs font-bold text-gray-700">All Users ({{ $users->total() }})</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-orange-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">User</th>
                            <th class="px-5 py-3 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Contact</th>
                            <th class="px-5 py-3 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Role</th>
                            <th class="px-5 py-3 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-5 py-3 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Joined</th>
                            <th class="px-5 py-3 text-left text-2xs font-bold text-gray-600 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-orange-50">
                        @foreach($users as $user)
                        <tr class="table-row transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900">{{ $user->name }}</p>
                                        <p class="text-2xs text-gray-500">ID: #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div>
                                    <p class="text-xs text-gray-900">{{ $user->email }}</p>
                                    <p class="text-2xs text-gray-500">+255 {{ $user->phone ?? 'N/A' }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                @if($user->roles->contains('name', 'admin'))
                                    <span class="px-2 py-1 text-2xs font-bold text-purple-700 bg-purple-100 rounded-full">Admin</span>
                                @else
                                    <span class="px-2 py-1 text-2xs font-bold text-primary bg-orange-100 rounded-full">Customer</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($user->email_verified_at)
                                    <span class="px-2 py-1 text-2xs font-bold text-green-700 bg-green-100 rounded-full">Verified</span>
                                @else
                                    <span class="px-2 py-1 text-2xs font-bold text-yellow-700 bg-yellow-100 rounded-full">Pending</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-xs text-gray-600">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4">
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Delete user {{ $user->name }} (#{{ $user->id }}) permanently?')"
                                            class="text-2xs text-red-600 hover:text-red-800 font-bold hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-orange-50 px-5 py-4 border-t border-orange-100">
                <div class="flex items-center justify-center">
                    {{ $users->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-16 py-6 border-t border-orange-100 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-2xs text-gray-500">© {{ date('Y') }} Weru Hardware Tanzania • All rights reserved</p>
        </div>
    </footer>
</body>
</html>