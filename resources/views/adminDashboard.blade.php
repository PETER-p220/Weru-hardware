<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weru Hardware - Admin & User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .stat-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px -5px rgba(0, 0, 0, 0.15); }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { background: linear-gradient(to right, #eff6ff, #dbeafe); border-left: 3px solid #2563eb; }
        .sidebar-link.active { background: linear-gradient(to right, #dbeafe, #bfdbfe); border-left: 3px solid #2563eb; font-weight: 600; }
        .modal { display: none; position: fixed; z-index: 100; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); animation: fadeIn 0.3s ease; }
        .modal.active { display: flex; align-items: center; justify-content: center; }
        .modal-content { animation: slideUp 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { transform: translateY(50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s ease; }
        .data-table tr:hover { background-color: #f9fafb; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

<!-- Header -->
<header class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-lg font-bold text-gray-900">Weru Hardware</span>
                    <span class="ml-2 px-2 py-0.5 bg-purple-100 text-purple-700 text-xs font-semibold rounded">Admin</span>
                </div>
            </div>
            <div class="hidden md:flex flex-1 max-w-lg mx-8">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="search" placeholder="Search orders, products, users..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <div class="flex items-center gap-3 pl-3 border-l border-gray-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-900">Admin User</p>
                        <p class="text-xs text-gray-500">Super Admin</p>
                    </div>
                    <div class="w-9 h-9 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white text-sm font-bold">AU</div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 overflow-y-auto">
        <nav class="p-4 space-y-1">
            <button onclick="showTab('dashboard')" class="sidebar-link active w-full flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </button>
            <button onclick="showTab('orders')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Orders Management <span class="ml-auto px-2 py-0.5 bg-red-100 text-red-700 text-xs font-semibold rounded-full">12</span>
            </button>
            <button onclick="showTab('products')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Products
            </button>
            <button onclick="showTab('inventory')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Inventory
            </button>
            <button onclick="showTab('users')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Users
            </button>
            <button onclick="showTab('analytics')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Analytics
            </button>
            <button onclick="showTab('categories')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Categories
            </button>
            <button onclick="showTab('reports')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Reports
            </button>
            <button onclick="showTab('user-dashboard')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                User Dashboard
            </button>
            <div class="pt-4 mt-4 border-t border-gray-200">
                <button onclick="showTab('settings')" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Settings
                </button>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Dashboard Tab -->
        <div id="dashboard" class="tab-content active p-8">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
                <p class="text-sm text-gray-600 mt-1">Welcome back! Here's what's happening today.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/></svg>
                        </div>
                        <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-lg">+12.5%</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-1">1,248</h3>
                    <p class="text-sm text-gray-600">Total Orders</p>
                </div>
                <div class="stat-card bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/></svg>
                        </div>
                        <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-lg">+23.1%</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-1">TZS 45.8M</h3>
                    <p class="text-sm text-gray-600">Revenue</p>
                </div>
                <div class="stat-card bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                        </div>
                        <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-lg">+8.3%</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-1">847</h3>
                    <p class="text-sm text-gray-600">Total Users</p>
                </div>
                <div class="stat-card bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/></svg>
                        </div>
                        <span class="px-2.5 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-lg">-2.4%</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-1">356</h3>
                    <p class="text-sm text-gray-600">Products</p>
                </div>
            </div>
            <!-- Recent Orders + Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Recent Orders</h3>
                        <button class="text-sm text-blue-600 font-medium hover:text-blue-700">View All</button>
                    </div>
                    <table class="w-full text-sm">
                        <thead class="text-left text-xs font-semibold text-gray-600 border-b">
                            <tr><th class="pb-3">Order ID</th><th class="pb-3">Customer</th><th class="pb-3">Amount</th><th class="pb-3">Status</th><th class="pb-3">Date</th></tr>
                        </thead>
                        <tbody>
                            <tr class="border-b"><td class="py-3 font-medium">#10247</td><td class="py-3">John Mwamba</td><td class="py-3 font-medium">TZS 450,000</td><td class="py-3"><span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded">Delivered</span></td><td class="py-3">Nov 10</td></tr>
                            <tr class="border-b"><td class="py-3 font-medium">#10246</td><td class="py-3">Sarah Mohamed</td><td class="py-3 font-medium">TZS 280,000</td><td class="py-3"><span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-xs rounded">Shipped</span></td><td class="py-3">Nov 12</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h3>
                    <div class="space-y-3">
                        <button onclick="openModal('addProductModal')"  class="w-full flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 text-sm font-medium">
                            <a href='/createProduct'>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Add New Product
                            </a>
                        </button>
                        <button onclick="openModal('addUserModal')" class="w-full flex items-center gap-3 px-4 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Add New User
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other Tabs (Orders, Products, etc.) remain unchanged -->
        <!-- ... [Include all other tab-content blocks here] ... -->

        <!-- USER DASHBOARD TAB -->
        <div id="user-dashboard" class="tab-content p-8">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Welcome, John Mwamba</h1>
                <p class="text-sm text-gray-600 mt-1">Track your orders, quotes, and account activity</p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-medium text-gray-600">Active Orders</p>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M8 9h4m-2-4v8"/></svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">3</h3>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-medium text-gray-600">Total Spent</p>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">TZS 8.5M</h3>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-medium text-gray-600">Pending Quotes</p>
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">2</h3>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Orders</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold">#10247</div>
                            <div>
                                <p class="font-semibold text-gray-900">Mbeya Cement 50kg x20</p>
                                <p class="text-sm text-gray-500">Ordered on Nov 10, 2025</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900">TZS 480,000</p>
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded">Delivered</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <button class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl text-left hover:from-blue-700 hover:to-indigo-700 transition-all">
                    <svg class="w-8 h-8 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <h4 class="text-lg font-bold">Browse Products</h4>
                    <p class="text-sm opacity-90">View catalog and place new orders</p>
                </button>
                <button class="p-6 bg-white border-2 border-dashed border-gray-300 rounded-xl text-left hover:border-blue-500 transition-all">
                    <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <h4 class="text-lg font-bold text-gray-900">Request Quote</h4>
                    <p class="text-sm text-gray-600">Get custom pricing for bulk orders</p>
                </button>
            </div>
        </div>

        <!-- Settings Tab (Fixed) -->
        <div id="settings" class="tab-content p-8">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
                <p class="text-sm text-gray-600 mt-1">Configure system preferences</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <!-- General Settings -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">General Settings</h3>
                        <div class="space-y-4">
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Business Name</label><input type="text" value="Weru Hardware" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label><input type="email" value="admin@weruhardware.co.tz" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label><input type="tel" value="+255 712 345 678" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                            <div><label class="block text-sm font-medium text-gray-700 mb-2">Business Address</label><textarea rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">Mikocheni, Dar es Salaam, Tanzania</textarea></div>
                        </div>
                    </div>
                    <!-- Payment & Notifications -->
                    <!-- ... (keep as in original) -->
                </div>
                <div class="space-y-6">
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <button class="w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 font-semibold mb-3">Save Changes</button>
                        <button class="w-full px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">Reset to Default</button>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">System Information</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between"><span class="text-gray-600">Version</span><span class="font-medium text-gray-900">2.5.0</span></div>
                            <div class="flex justify-between"><span class="text-gray-600">Last Backup</span><span class="font-medium text-gray-900">Nov 15, 2025</span></div>
                            <div class="flex justify-between"><span class="text-gray-600">Database Size</span><span class="font-medium text-gray-900">2.4 GB</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modals (Add Product, User, etc.) -->
<!-- ... (Include all modals from your original code) ... -->

<script>
    function showTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        event.target.closest('.sidebar-link').classList.add('active');
    }

    function openModal(id) {
        document.getElementById(id).classList.add('active');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    // Close modal on outside click
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });
</script>
</body>
</html>