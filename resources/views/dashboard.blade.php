<?php
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$userOrders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
$totalOrders = $userOrders->count();
$totalSpent = number_format($userOrders->sum('total_amount') ?? 0);
$averageOrderValue = $userOrders->avg('total_amount') ? number_format($userOrders->avg('total_amount'), 2) : '0.00';
$pendingOrdersCount = $userOrders->where('status', 'pending')->count();
$processingOrdersCount = $userOrders->where('status', 'processing')->count();

$latestOrder = $userOrders->first();
$latestOrderNumber = $latestOrder?->order_number ?? 'N/A';
$latestOrderStatus = $latestOrder?->status ?? 'none';
$latestOrderAmount = number_format($latestOrder?->total_amount ?? 0);
$latestOrderDate = $latestOrder?->created_at?->format('M d, Y') ?? 'N/A';

$userInitial = strtoupper(substr($user->name ?? 'U', 0, 1));
$memberSince = $user->created_at?->format('M Y') ?? 'Unknown';

$recentOrders = $userOrders->take(3)->map(function ($order) {
    return [
        'id' => $order->id,
        'number' => $order->order_number,
        'status' => ucfirst($order->status),
        'amount' => number_format($order->total_amount),
        'statusClass' => match($order->status) {
            'pending' => 'bg-amber-100 text-amber-700 border border-amber-300',
            'processing' => 'bg-blue-100 text-blue-700 border border-blue-300',
            'shipped' => 'bg-indigo-100 text-indigo-700 border border-indigo-300',
            'delivered' => 'bg-green-100 text-green-700 border border-green-300',
            'cancelled' => 'bg-red-100 text-red-700 border border-red-300',
            default => 'bg-gray-100 text-gray-700 border border-gray-300',
        }
    ];
});

if ($recentOrders->isEmpty()) {
    $recentOrders = collect([[
        'number' => '—',
        'status' => 'No Orders Yet',
        'amount' => '0',
        'statusClass' => 'bg-gray-100 text-gray-600 border border-gray-300'
    ]]);
}

function getOrderStep($status) {
    return match(strtolower($status)) {
        'delivered' => 4,
        'shipped' => 3,
        'processing' => 2,
        default => 1,
    };
}
$currentStep = getOrderStep($latestOrderStatus);

$statusMessage = $latestOrder
    ? match(strtolower($latestOrderStatus)) {
        'pending' => "Your order <strong>#{$latestOrderNumber}</strong> is under review. We’ll confirm soon.",
        'processing' => "Your order <strong>#{$latestOrderNumber}</strong> is being prepared and packed.",
        'shipped' => "Your order <strong>#{$latestOrderNumber}</strong> is on its way!",
        'delivered' => "Order <strong>#{$latestOrderNumber}</strong> was delivered on " . $latestOrder->updated_at->format('M d, Y'),
        default => "Your latest order is currently <strong>" . ucfirst($latestOrderStatus) . "</strong>.",
    }
    : "You don't have any active orders to track at the moment.";

$savedAddressesCount = 3; // Replace with real count later
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard | Oweru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        :root {
            --primary: rgb(218,165,32);
            --primary-dark: #002147;
            --secondary: #f5f5f5;
        }
        * { -webkit-tap-highlight-color: transparent; }
        html { scroll-behavior: smooth; }
        body { 
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f9f9f9 0%, #f5f5f5 100%);
        }
        
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .animate-slide-in { animation: slideInUp 0.5s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
        .animate-scale-in { animation: scaleIn 0.3s ease-out forwards; }
        .badge-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -5px rgba(0, 33, 71, 0.15); }
        .progress-bar { height: 6px; background: #e5e7eb; }
        .progress-fill { height: 100%; background: var(--primary); transition: width 0.8s ease; }
        
        .glass-effect { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
        .smooth-shadow { box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 10px 13px rgba(0, 0, 0, 0.1); }
        
        .quantity-btn { min-width: 44px; min-height: 44px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; }
        .quantity-btn:hover { transform: scale(1.05); background-color: rgba(218,165,32, 0.1); }
        
        .text-responsive-title { font-size: clamp(1.75rem, 6vw, 2.25rem); }
        .text-responsive-subtitle { font-size: clamp(0.875rem, 2vw, 1rem); }
        
        header { position: sticky; top: 0; z-index: 50; background: linear-gradient(135deg, #002147, #001a33); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }
        
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: rgb(218,165,32); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #d4af37; }
        
        @media (max-width: 640px) {
            button, a { min-height: 44px; min-width: 44px; }
        }
        
        @media (max-width: 768px) {
            .dashboard-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (min-width: 769px) {
            .dashboard-grid { grid-template-columns: 2fr 1fr; }
            .stats-grid { grid-template-columns: repeat(4, 1fr); }
        }
    </style>
</head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
<body class="bg-gray-50 text-gray-800">

<!-- Header -->
<header>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <div class="flex items-center gap-3 lg:gap-6">
                <div class="flex-shrink-0 group">
                    <a href="/" class="flex items-center gap-2 transform group-hover:scale-105 transition">
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, rgb(218,165,32), #002147);">
                            <i class="fa-solid fa-shopping-cart text-white text-lg lg:text-xl"></i>
                        </div>
                        <span class="text-lg lg:text-xl font-black text-white leading-tight hidden sm:inline-block">
                            Oweru<span style="color: rgb(218,165,32);">Hardware</span>
                        </span>
                    </a>
                </div>
                <nav class="hidden md:flex gap-4 lg:gap-8 items-center">
                    <a href="{{ url('dashboard') }}" class="font-medium text-sm lg:text-base transition" style="color: rgba(218,165,32, 0.8);">Dashboard</a>
                    <a href="{{ url('order') }}" class="font-medium text-sm lg:text-base transition" style="color: rgba(218,165,32, 0.8);">Orders</a>
                    <a href="{{ url('products') }}" class="font-medium text-sm lg:text-base transition" style="color: rgba(218,165,32, 0.8);">Shop</a>
                    <a href="#" class="font-medium text-sm lg:text-base transition" style="color: rgba(218,165,32, 0.8);">Support</a>
                </nav>
            </div>

            <div class="flex items-center gap-3 sm:gap-6">
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg transition" style="background: rgba(218,165,32, 0.1); color: rgb(218,165,32);">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>

                <div class="relative hidden md:inline-block">
                    <button id="user-notif-bell" class="relative p-2 rounded-full transition inline-flex" style="background: rgba(218,165,32, 0.1); color: rgb(218,165,32);">
                        <i class="fa-regular fa-bell text-lg"></i>
                        <span id="user-notif-badge" class="hidden absolute top-1 right-1 w-4 h-4 bg-red-600 text-[10px] text-white rounded-full flex items-center justify-center font-bold badge-pulse"></span>
                    </button>
                    <div id="user-notif-panel" class="hidden absolute right-0 mt-3 w-80 max-w-sm z-40">
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-2xl overflow-hidden">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-900">Notifications</p>
                                <button type="button" id="user-notif-clear" class="text-xs text-gray-500 hover:text-gray-700">Clear</button>
                            </div>
                            <div id="user-notif-list" class="max-h-72 overflow-y-auto">
                                <div class="px-4 py-4 text-sm text-gray-500 text-center">
                                    No notifications yet.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hidden md:flex items-center gap-2 lg:gap-4 px-3 py-1.5 rounded-lg" style="background: rgba(218,165,32, 0.1);">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold" style="background: rgb(218,165,32); color: #000000;">
                        {{ $userInitial }}
                    </div>
                    <span class="text-sm font-medium" style="color: rgba(218,165,32, 0.9);">{{ Str::limit($user->name ?? 'User', 15) }}</span>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-gray-700">
            <nav class="flex flex-col gap-3 mt-4">
                <a href="{{ url('dashboard') }}" class="block px-4 py-3 rounded-lg text-sm font-medium transition hover:scale-105" style="background: rgba(218,165,32, 0.1); color: rgba(218,165,32, 0.9);">
                    <i class="fa-solid fa-th-large mr-3"></i>Dashboard
                </a>
                <a href="{{ url('order') }}" class="block px-4 py-3 rounded-lg text-sm font-medium transition hover:scale-105" style="background: rgba(218,165,32, 0.1); color: rgba(218,165,32, 0.9);">
                    <i class="fa-solid fa-receipt mr-3"></i>Orders
                </a>
                <a href="{{ url('products') }}" class="block px-4 py-3 rounded-lg text-sm font-medium transition hover:scale-105" style="background: rgba(218,165,32, 0.1); color: rgba(218,165,32, 0.9);">
                    <i class="fa-solid fa-box mr-3"></i>Shop
                </a>
                <a href="#" class="block px-4 py-3 rounded-lg text-sm font-medium transition hover:scale-105" style="background: rgba(218,165,32, 0.1); color: rgba(218,165,32, 0.9);">
                    <i class="fa-solid fa-headset mr-3"></i>Support
                </a>
            </nav>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-6 py-10">

    <!-- Welcome -->
    <div class="mb-10">
        <h2 class="text-4xl font-black text-gray-900 mb-2">Welcome back, {{ $user->name }}!</h2>
        <p class="text-lg text-gray-600">Here's what's happening with your account today.</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid gap-6 mb-10 animate-slide-in" style="display: grid;">
        <div class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 p-6 smooth-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: rgba(218,165,32, 0.1);">
                    <i class="fa-solid fa-shopping-bag text-2xl" style="color: rgb(218,165,32);"></i>
                </div>
            </div>
            <p class="text-gray-600 text-sm font-medium">Total Orders</p>
            <p class="text-4xl font-black text-gray-900 mt-1">{{ $totalOrders }}</p>
            <p class="text-sm text-gray-500 mt-2">{{ $processingOrdersCount }} in progress</p>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 p-6 smooth-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: rgba(218,165,32, 0.1);">
                    <i class="fa-solid fa-clock text-2xl" style="color: rgb(218,165,32);"></i>
                </div>
            </div>
            <p class="text-gray-600 text-sm font-medium">Pending Orders</p>
            <p class="text-4xl font-black text-gray-900 mt-1">{{ $pendingOrdersCount }}</p>
            <p class="text-sm text-gray-500 mt-2">Awaiting confirmation</p>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 p-6 smooth-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: rgba(76,175,80, 0.1);">
                    <i class="fa-solid fa-sack-dollar text-2xl" style="color: #4caf50;"></i>
                </div>
            </div>
            <p class="text-gray-600 text-sm font-medium">Total Spent</p>
            <p class="text-xl font-black text-gray-900 mt-1">TZS {{ $totalSpent }}</p>
            <p class="text-sm text-gray-500 mt-2">Avg: TZS {{ $averageOrderValue }}</p>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 p-6 smooth-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: rgba(218,165,32, 0.1);">
                    <i class="fa-solid fa-location-dot text-2xl" style="color: rgb(218,165,32);"></i>
                </div>
            </div>
            <p class="text-gray-600 text-sm font-medium">Saved Addresses</p>
            <p class="text-4xl font-black text-gray-900 mt-1">{{ $savedAddressesCount }}</p>
            <a href="{{ url('addresses') }}" class="text-sm font-medium mt-2 inline-block transition hover:scale-105" style="color: rgb(218,165,32);">Manage →</a>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="dashboard-grid gap-8" style="display: grid;">

        <!-- Recent Orders -->
        <div class="animate-scale-in">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden smooth-shadow">
                <div class="px-6 py-5 text-white flex items-center justify-between" style="background: linear-gradient(135deg, #002147, #001a33);">
                    <h3 class="text-xl font-bold">Recent Orders</h3>
                    <a href="{{ url('order') }}" class="text-sm font-medium flex items-center gap-1 transition hover:scale-105" style="color: rgba(218,165,32, 0.9);">
                        View All <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="divide-y divide-gray-100">
                    @foreach($recentOrders as $order)
                        @if(isset($order['id']))
                            <a href="{{ route('order.show', $order['id']) }}" class="block p-6 transition hover:bg-gray-50" style="background: rgba(218,165,32, 0.02);">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div>
                                        <div class="flex items-center gap-3 mb-1 flex-wrap">
                                            <span class="font-bold text-lg text-gray-900">#{{ $order['number'] }}</span>
                                            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $order['statusClass'] }}">
                                                {{ $order['status'] }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-left sm:text-right">
                                        <p class="font-bold text-lg sm:text-xl text-gray-900">TZS {{ $order['amount'] }}</p>
                                        <span class="text-sm font-medium transition hover:scale-105" style="color: rgb(218,165,32);">View Details →</span>
                                    </div>
                                </div>
                            </a>
                        @else
                            <div class="block p-6" style="background: rgba(218,165,32, 0.02);">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div>
                                        <div class="flex items-center gap-3 mb-1 flex-wrap">
                                            <span class="font-bold text-lg text-gray-900">#{{ $order['number'] }}</span>
                                            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $order['statusClass'] }}">
                                                {{ $order['status'] }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-left sm:text-right">
                                        <p class="font-bold text-lg sm:text-xl text-gray-900">TZS {{ $order['amount'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar: Profile + Quick Actions -->
        <div class="space-y-6 animate-fade-in">

            <!-- Profile Card -->
            <div class="rounded-2xl shadow-xl p-6 text-white smooth-shadow" style="background: linear-gradient(135deg, #002147, #001a33);">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold" style="background: rgb(218,165,32); color: #000000;">
                        {{ $userInitial }}
                    </div>
                    <div>
                        <h4 class="font-bold text-xl">{{ $user->name }}</h4>
                        <p class="text-sm" style="color: rgba(218,165,32, 0.8);">{{ $user->email }}</p>
                    </div>
                </div>
                <a href="{{ url('profile') }}" class="block text-center py-3 rounded-xl font-semibold transition hover:scale-105" style="background: rgb(218,165,32); color: #000000;">
                    Manage Account →
                </a>
                <p class="text-xs mt-3 text-center" style="color: rgba(218,165,32, 0.8);">Member since {{ $memberSince }}</p>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 smooth-shadow">
                <h3 class="font-bold text-lg mb-5 text-gray-900">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ url('products') }}" class="flex items-center gap-4 p-4 rounded-xl transition hover:scale-105" style="background: rgba(218,165,32, 0.1);">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white" style="background: rgb(218,165,32);">
                            <i class="fa-solid fa-store text-lg" style="color: #000000;"></i>
                        </div>
                        <span class="font-semibold text-gray-900">Continue Shopping</span>
                    </a>
                    <a href="{{ url('addresses') }}" class="flex items-center gap-4 p-4 rounded-xl transition hover:scale-105" style="background: rgba(218,165,32, 0.1);">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white" style="background: rgb(218,165,32);">
                            <i class="fa-solid fa-location-dot text-lg" style="color: #000000;"></i>
                        </div>
                        <span class="font-semibold text-gray-900">Manage Addresses ({{ $savedAddressesCount }})</span>
                    </a>
                    <a href="#" class="flex items-center gap-4 p-4 rounded-xl transition hover:scale-105" style="background: rgba(218,165,32, 0.1);">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white" style="background: rgb(218,165,32);">
                            <i class="fa-solid fa-headset text-lg" style="color: #000000;"></i>
                        </div>
                        <span class="font-semibold text-gray-900">Contact Support</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Order Tracking -->
    <div class="mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-8 smooth-shadow animate-slide-in">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <h3 class="text-2xl sm:text-3xl font-black text-gray-900">Active Order Tracking</h3>
            @if($latestOrder)
                <a href="{{ route('order.show', $latestOrder->id) }}" class="text-sm font-medium transition hover:scale-105 w-fit" style="color: rgb(218,165,32);">
                    View Order #{{$latestOrderNumber}} →
                </a>
            @endif
        </div>

        @if($latestOrder)
            <div class="mb-8 p-5 rounded-xl" style="background: linear-gradient(135deg, rgba(218,165,32, 0.1), rgba(218,165,32, 0.05)); border: 2px solid rgba(218,165,32, 0.2);">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <span class="font-bold text-xl text-gray-900">#{{ $latestOrderNumber }}</span>
                        <span class="text-gray-600 ml-4">• Placed on {{ $latestOrderDate }}</span>
                    </div>
                    <span class="font-bold text-xl text-gray-900">TZS {{ $latestOrderAmount }}</span>
                </div>
            </div>

            <!-- Progress Steps -->
            <div class="relative mb-8">
                <div class="flex justify-between items-center">
                    @php
                        $steps = ['Pending', 'Processing', 'Shipped', 'Delivered'];
                        $stepIcons = ['fa-clock', 'fa-box', 'fa-truck', 'fa-check-circle'];
                    @endphp
                    @foreach($steps as $index => $step)
                        @php
                            $stepNum = $index + 1;
                            $isActive = $stepNum <= $currentStep;
                            $isDone = $stepNum < $currentStep;
                        @endphp
                        <div class="flex flex-col items-center z-10 flex-1">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg transition
                                {{ $isDone || $isActive ? 'ring-4' : '' }}"
                                style="background: {{ $isDone || $isActive ? 'rgb(218,165,32)' : '#d1d5db' }}; ring-color: rgba(218,165,32, 0.3);">
                                @if($isDone)
                                    <i class="fa-solid fa-check"></i>
                                @else
                                    <i class="fa-solid {{ $stepIcons[$index] }}"></i>
                                @endif
                            </div>
                            <span class="mt-2 sm:mt-3 text-xs sm:text-sm font-medium text-center" style="color: {{ $isActive || $isDone ? 'rgb(218,165,32)' : '#6b7280' }};">
                                {{ $step }}
                            </span>
                        </div>

                        @if($index < 3)
                            <div class="progress-bar absolute top-5 sm:top-7 left-14 right-14 -z-10">
                                <div class="progress-fill" style="width: {{ $stepNum <= $currentStep ? '100%' : '0%' }}"></div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="p-5 sm:p-6 rounded-xl" style="background: linear-gradient(135deg, rgba(218,165,32, 0.1), rgba(218,165,32, 0.05)); border: 2px solid rgba(218,165,32, 0.2);">
                <p class="text-gray-800 leading-relaxed">{!! $statusMessage !!}</p>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fa-solid fa-inbox text-6xl text-gray-300 mb-4"></i>
                <p class="text-xl font-semibold text-gray-700 mb-2">No Active Orders</p>
                <p class="text-gray-600 mb-6">When you place an order, track its status here in real-time.</p>
                <a href="{{ url('products') }}" class="inline-flex items-center gap-3 text-white font-bold px-8 py-4 rounded-xl shadow-lg transition hover:scale-105" style="background: rgb(218,165,32); color: #000000;">
                    Start Shopping Now <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>

</main>

<!-- JavaScript Enhancements -->
<script>
    // Intersection Observer for Lazy Animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('animate-slide-in');
                }, index * 50);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe Cards and Elements
    document.querySelectorAll('.card-hover').forEach(el => {
        observer.observe(el);
    });

    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenuBtn.innerHTML = isOpen 
                ? '<i class="fa-solid fa-xmark text-lg"></i>' 
                : '<i class="fa-solid fa-bars text-lg"></i>';
        });

        // Close menu when a link is clicked
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.innerHTML = '<i class="fa-solid fa-bars text-lg"></i>';
            });
        });
    }

    // Button Ripple Effect
    document.querySelectorAll('button[type="submit"], a').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (window.innerWidth > 768 && (this.tagName === 'BUTTON' || this.classList.contains('btn-action'))) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    background: rgba(255, 255, 255, 0.5);
                    border-radius: 50%;
                    left: ${x}px;
                    top: ${y}px;
                    pointer-events: none;
                    animation: ripple 0.6s ease-out;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            }
        });
    });

    // Add Ripple Animation
    const style = document.createElement('style');
    style.innerHTML = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    // Smooth Page Transitions
    window.addEventListener('load', () => {
        document.body.style.transition = 'opacity 0.3s ease';
        document.body.style.opacity = '1';
    });

    // =========================================================================
    // Live Order Status Notification for User Dashboard
    // =========================================================================
    (function() {
        const bell    = document.getElementById('user-notif-bell');
        const badge   = document.getElementById('user-notif-badge');
        const panel   = document.getElementById('user-notif-panel');
        const listEl  = document.getElementById('user-notif-list');
        const clearEl = document.getElementById('user-notif-clear');

        if (!bell || !badge || !panel || !listEl || !clearEl) return;

        const seenOrderIds   = new Set();
        const orderStatusMap = {};
        let firstLoad = true;

        function statusLabel(str) {
            if (!str) return '';
            str = String(str);
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function addNotification(order, oldStatus) {
            if (!order) return;

            // Reset "no notifications" placeholder
            if (listEl.children.length === 1 && listEl.children[0].textContent.includes('No notifications')) {
                listEl.innerHTML = '';
            }

            const item = document.createElement('div');
            item.className = 'px-4 py-3 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition';
            item.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 text-green-600">
                        <i class="fa-solid fa-circle text-[8px]"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-900">
                            Order #${order.order_number ?? ('ID ' + order.id)} status updated
                        </p>
                        <p class="text-xs text-gray-600 mt-0.5">
                            ${oldStatus ? statusLabel(oldStatus) + ' → ' : ''}<span class="font-semibold">${statusLabel(order.status)}</span>
                        </p>
                        <p class="text-[11px] text-gray-500 mt-0.5">
                            Total: TZS ${Number(order.total_amount).toLocaleString('en-US')}
                        </p>
                    </div>
                </div>
            `;
            listEl.prepend(item);
            // Show badge
            badge.textContent = '1';
            badge.classList.remove('hidden');

            // Auto-open panel on first notification
            if (panel.classList.contains('hidden')) {
                panel.classList.remove('hidden');
            }
        }

        async function checkOrderStatus() {
            try {
                const response = await fetch('{{ route('user.orders.latest') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!response.ok) return;

                const data = await response.json();
                if (Array.isArray(data.orders)) {
                    if (firstLoad) {
                        // On first load, show ALL orders as notifications
                        listEl.innerHTML = '';
                        data.orders.forEach(o => {
                            if (!o?.id) return;
                            addNotification(o, null);
                            seenOrderIds.add(o.id);
                            orderStatusMap[o.id] = (o.status || '').toLowerCase();
                        });
                        firstLoad = false;
                        return;
                    }

                    // Subsequent polls: only new orders or status changes
                    data.orders.forEach(o => {
                        if (!o?.id) return;

                        if (!seenOrderIds.has(o.id)) {
                            addNotification(o, null);
                            seenOrderIds.add(o.id);
                            orderStatusMap[o.id] = (o.status || '').toLowerCase();
                            return;
                        }

                        const currentStatus = (o.status || '').toLowerCase();
                        const prevStatus    = orderStatusMap[o.id];
                        if (prevStatus && currentStatus && currentStatus !== prevStatus) {
                            addNotification(o, prevStatus);
                            orderStatusMap[o.id] = currentStatus;
                        }
                    });
                }
            } catch (e) {
                // Silent fail; will retry on next interval
            }
        }

        // Toggle panel on bell click
        bell.addEventListener('click', () => {
            panel.classList.toggle('hidden');
            if (!panel.classList.contains('hidden')) {
                badge.classList.add('hidden');
            }
        });

        // Clear notifications
        clearEl.addEventListener('click', () => {
            listEl.innerHTML = `
                <div class="px-4 py-4 text-sm text-gray-500 text-center">
                    No notifications yet.
                </div>
            `;
            badge.classList.add('hidden');
        });

        // Initial check shortly after load, then poll every 10 seconds
        setTimeout(checkOrderStatus, 2000);
        setInterval(checkOrderStatus, 10000);
    })();
</script>
</body>
</html>