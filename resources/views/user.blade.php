@php
    use App\Models\User;
    use Spatie\Permission\Models\Role;

    $users = $users ?? User::with('roles')->latest()->paginate(15);

    $adminCount     = Role::where('name', 'admin')->first()?->users()->count() ?? 0;
    $customerCount  = Role::where('name', 'user')->first()?->users()->count() ?? 0;
    $activeToday    = User::whereDate('updated_at', today())->count();
@endphp

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Users • Oweru Hardware Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        slate: {
                            50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1',
                            400: '#94a3b8', 500: '#64748b', 600: '#475569', 700: '#334155',
                            800: '#1e293b', 900: '#0f172a', 950: '#020617'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .text-2xs { font-size: 0.625rem; line-height: 0.875rem; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.12); }
        .toast { animation: slideDown 0.5s ease-out; opacity: 1; transition: opacity 0.5s; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        .table-row:hover { background-color: #f8fafc; }
        #menu-btn { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        #menu-btn:hover { background: rgba(255,255,255,0.95); box-shadow: 0 10px 30px -5px rgba(15,23,42,0.2); }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-slate-50 min-h-screen">

    <!-- Mobile Menu Button -->
    <button id="menu-btn" class="fixed top-4 left-4 z-50 lg:hidden bg-white/90 rounded-full p-3.5 shadow-xl border border-slate-300 flex items-center justify-center hover:bg-white transition">
        <i class="fa-solid fa-bars text-slate-800 text-xl"></i>
    </button>
    <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <!-- Success Toast -->
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl text-sm font-medium flex items-center gap-3 toast">
            <i class="fa-solid fa-check-circle text-xl"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Toast -->
    @if(session('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-600 text-white px-6 py-4 rounded-xl shadow-2xl text-sm font-medium flex items-center gap-3 toast">
            <i class="fa-solid fa-exclamation-circle text-xl"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Sidebar – Always shows full text -->
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
            <a href="/OrderManagement" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-shopping-bag w-5"></i> Orders
            </a>
            <a href="{{ route('user') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl bg-gradient-to-r from-slate-800 to-slate-900 text-white shadow-md text-sm font-medium">
                <i class="fa-solid fa-users w-5"></i> Users
            </a>
            <a href="{{ route('ads') }}" class="flex items-center gap-4 px-5 py-3.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition text-sm font-medium">
                <i class="fa-solid fa-bullhorn w-5"></i> Advertisements
            </a>
        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-5 border-t border-slate-200 bg-slate-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-slate-800 to-slate-900 rounded-full flex items-center justify-center text-white font-bold shadow">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) : 'AD' }}
                </div>
                <div>
                    <p class="font-semibold text-slate-800 text-sm">{{ auth()->check() ? Str::limit(auth()->user()->name, 15) : 'Admin' }}</p>
                    <p class="text-2xs text-slate-500">
                        {{ auth()->check() && auth()->user()->hasRole('admin') ? 'Administrator' : 'Customer' }}
                    </p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-72 min-h-screen">
        <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-6 py-5 lg:px-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Users Management</h2>
                    <p class="text-sm text-slate-500 mt-1">Manage all registered users and administrators</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-slate-600 hover:text-slate-800">Logout</button>
                </form>
            </div>
        </header>

        <div class="p-5 lg:p-8 max-w-7xl mx-auto">

            <!-- Breadcrumb -->
            <div class="mb-6 text-sm text-slate-500">
                <div class="flex items-center gap-2">
                    <a href="{{ route('adminDashboard') }}" class="hover:text-slate-800 font-medium">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <span class="text-slate-800 font-bold">Users</span>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center hover-lift transition">
                    <i class="fa-solid fa-users text-3xl text-slate-700 mb-3"></i>
                    <p class="text-3xl font-bold text-slate-900">{{ $users->count() }}</p>
                    <p class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Total Users</p>
                </div>
                <div class="bg-white rounded-2xl border border-purple-200 p-6 text-center hover-lift transition">
                    <i class="fa-solid fa-shield-halved text-3xl text-purple-600 mb-3"></i>
                    <p class="text-3xl font-bold text-slate-900">{{ $adminCount }}</p>
                    <p class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Admins</p>
                </div>
                <div class="bg-white rounded-2xl border border-emerald-200 p-6 text-center hover-lift transition">
                    <i class="fa-solid fa-user text-3xl text-emerald-600 mb-3"></i>
                    <p class="text-3xl font-bold text-slate-900">{{ $customerCount }}</p>
                    <p class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Customers</p>
                </div>
                <div class="bg-white rounded-2xl border border-orange-200 p-6 text-center hover-lift transition">
                    <i class="fa-solid fa-circle-dot text-3xl text-orange-600 mb-3"></i>
                    <p class="text-3xl font-bold text-slate-900">{{ $activeToday }}</p>
                    <p class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Active Today</p>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">User</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Joined</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($users as $user)
                                <tr class="table-row transition-colors">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 bg-gradient-to-br from-slate-700 to-slate-900 rounded-full flex items-center justify-center text-white font-bold text-lg shadow">
                                                {{ strtoupper(substr($user->name ?? '??', 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-slate-900">{{ $user->name }}</div>
                                                <div class="text-xs text-slate-500">#{{ $user->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm text-slate-700">{{ $user->email }}</div>
                                        <div class="text-xs text-slate-500 mt-1">
                                            {{ $user->tel ? '+255' . substr($user->tel, 3) : '—' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        @if(auth()->user()->hasRole('admin') && auth()->id() !== $user->id)
                                            <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <select name="role" onchange="this.form.submit()" class="px-3 py-1 text-xs font-bold rounded-full border-0 focus:ring-2 focus:ring-purple-500 {{ $user->hasRole('admin') ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-700' }}">
                                                    <option value="user" {{ $user->hasRole('user') ? 'selected' : '' }}>Customer</option>
                                                    <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Administrator</option>
                                                </select>
                                            </form>
                                        @else
                                            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $user->hasRole('admin') ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-700' }}">
                                                {{ $user->hasRole('admin') ? 'Administrator' : 'Customer' }}
                                            </span>
                                        @endif
                                    </td>
                                   
                                    <td class="px-6 py-5 text-sm text-slate-600">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td data-label="Actions" class="px-6 py-5">
                                        <div class="flex items-center justify-center gap-2">
                                            @if(auth()->user()->hasRole('admin') && auth()->id() !== $user->id)
                                                <button onclick="editUser({{ $user->id }})" 
                                                    class="px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors flex items-center gap-1.5"
                                                    title="Edit User">
                                                    <i class="fa-solid fa-pencil text-xs"></i>
                                                    <span>Edit</span>
                                                </button>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to delete {{ $user->name }}? This action cannot be undone.')" 
                                                        class="px-3 py-1.5 text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors flex items-center gap-1.5"
                                                        title="Delete User">
                                                        <i class="fa-solid fa-trash text-xs"></i>
                                                        <span>Delete</span>
                                                    </button>
                                                </form>
                                            @elseif(auth()->id() === $user->id)
                                                <span class="text-xs text-slate-400 italic">You</span>
                                            @else
                                                <span class="text-xs text-slate-400 italic">—</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                        <i class="fa-solid fa-users-slash text-4xl mb-4 text-slate-300"></i>
                                        <p class="text-lg font-medium">No users found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                    {{ $users->onEachSide(2)->links() }}
                </div>
            </div>
        </div>
    </main>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-xl font-bold text-slate-900">Edit User</h3>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="editUserForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label for="edit_name" class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
                    <input type="text" id="edit_name" name="name" required
                        class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-lg focus:border-blue-500 focus:outline-none transition"
                        placeholder="John Doe">
                </div>

                <div>
                    <label for="edit_email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                    <input type="email" id="edit_email" name="email" required
                        class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-lg focus:border-blue-500 focus:outline-none transition"
                        placeholder="user@example.com">
                </div>

                <div>
                    <label for="edit_tel" class="block text-sm font-semibold text-slate-700 mb-2">Phone Number</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-4 text-sm text-slate-500 bg-slate-100 border border-r-0 border-slate-300 rounded-l-lg">
                            +255
                        </span>
                        <input type="text" id="edit_tel" name="tel" required
                            class="flex-1 px-4 py-2.5 border-2 border-slate-200 rounded-r-lg focus:border-blue-500 focus:outline-none transition"
                            placeholder="712345678" pattern="[0-9]{9}" maxlength="11">
                    </div>
                    <p class="mt-1 text-xs text-slate-500">Format: 712345678 (9 digits)</p>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeEditModal()" 
                        class="flex-1 px-4 py-2.5 text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="flex-1 px-4 py-2.5 text-white bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition">
                        <i class="fa-solid fa-save mr-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('menu-btn')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('mobile-overlay').classList.toggle('hidden');
        });
        document.getElementById('mobile-overlay')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('mobile-overlay').classList.add('hidden');
        });

        // Auto-hide toast
        setTimeout(() => {
            const toast = document.querySelector('.toast');
            if (toast) toast.style.opacity = '0';
        }, 5000);

        // Edit user function - opens modal and loads user data
        async function editUser(userId) {
            const modal = document.getElementById('editUserModal');
            const form = document.getElementById('editUserForm');
            
            try {
                // Fetch user data
                const response = await fetch(`/users/${userId}/edit`);
                const data = await response.json();
                
                if (data.user) {
                    // Populate form fields
                    document.getElementById('edit_name').value = data.user.name || '';
                    document.getElementById('edit_email').value = data.user.email || '';
                    document.getElementById('edit_tel').value = data.user.tel || '';
                    
                    // Update form action
                    form.action = `/users/${userId}`;
                    
                    // Show modal
                    modal.classList.remove('hidden');
                } else {
                    alert('Failed to load user data');
                }
            } catch (error) {
                console.error('Error loading user:', error);
                alert('Error loading user data. Please try again.');
            }
        }

        // Close edit modal
        function closeEditModal() {
            document.getElementById('editUserModal').classList.add('hidden');
            document.getElementById('editUserForm').reset();
        }

        // Close modal when clicking outside
        document.getElementById('editUserModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEditModal();
            }
        });
    </script>
</body>
</html>