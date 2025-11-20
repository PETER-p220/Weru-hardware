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
        'number' => $order->order_number,
        'status' => ucfirst($order->status),
        'date' => $order->created_at->diffForHumans(),
        'amount' => number_format($order->total_amount),
        'statusClass' => match($order->status) {
            'pending' => 'bg-orange-100 text-orange-700 border border-orange-300',
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
        'date' => '—',
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
    <title>Customer Dashboard | Weru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --secondary: #fbbf24;
        }
        body { font-family: 'Inter', sans-serif; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 25px -5px rgba(249, 115, 22, 0.15); }
        .progress-bar { height: 6px; background: #e5e7eb; }
        .progress-fill { height: 100%; background: var(--primary); transition: width 0.8s ease; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- Header -->
<header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-orange-600 to-orange-700 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-hard-hat text-white text-xl"></i>
            </div>
            <h1 class="text-2xl font-black text-gray-900">Weru<span class="text-orange-600">Hardware</span></h1>
        </div>

        <nav class="hidden lg:flex items-center gap-10 font-medium">
            <a href="{{ url('dashboard') }}" class="text-orange-600 font-bold border-b-2 border-orange-600 pb-1">Dashboard</a>
            <a href="{{ url('order') }}" class="hover:text-orange-600 transition">Orders</a>
            <a href="{{ url('products') }}" class="hover:text-orange-600 transition">Shop</a>
            <a href="#" class="hover:text-orange-600 transition">Support</a>
        </nav>

        <div class="flex items-center gap-5">
            <button class="relative p-2 text-gray-600 hover:bg-orange-50 rounded-full transition">
                <i class="fa-regular fa-bell text-xl"></i>
                <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full"></span>
            </button>

            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="font-bold text-gray-900">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500">Member since {{ $memberSince }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-orange-600 to-orange-700 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                    {{ $userInitial }}
                </div>
            </div>
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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-shopping-bag text-2xl text-orange-600"></i>
                </div>
            </div>
            <p class="text-gray-600 text-sm font-medium">Total Orders</p>
            <p class="text-4xl font-black text-gray-900 mt-1">{{ $totalOrders }}</p>
            <p class="text-sm text-gray-500 mt-2">{{ $processingOrdersCount }} in progress</p>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-clock text-2xl text-amber-600"></i>
                </div>
            </div>
            <p class="text-gray-600 text-sm font-medium">Pending Orders</p>
            <p class="text-4xl font-black text-gray-900 mt-1">{{ $pendingOrdersCount }}</p>
            <p class="text-sm text-gray-500 mt-2">Awaiting confirmation</p>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-sack-dollar text-2xl text-green-600"></i>
                </div>
            </div>
            <p class="text-gray-600 text-sm font-medium">Total Spent</p>
            <p class="text-4xl font-black text-gray-900 mt-1">TZS {{ $totalSpent }}</p>
            <p class="text-sm text-gray-500 mt-2">Avg: TZS {{ $averageOrderValue }}</p>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-location-dot text-2xl text-purple-600"></i>
                </div>
            </div>
            <p class="text-gray-600 text-sm font-medium">Saved Addresses</p>
            <p class="text-4xl font-black text-gray-900 mt-1">{{ $savedAddressesCount }}</p>
            <a href="{{ url('addresses') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium mt-2 inline-block">Manage →</a>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Recent Orders -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-orange-600 to-orange-700 text-white flex items-center justify-between">
                    <h3 class="text-xl font-bold">Recent Orders</h3>
                    <a href="{{ url('order') }}" class="text-sm font-medium hover:underline flex items-center gap-1">
                        View All <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="divide-y divide-gray-100">
                    @foreach($recentOrders as $order)
                        <a href="{{ url('order/' . $order['number']) }}" class="block p-6 hover:bg-orange-50 transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="font-bold text-lg">#{{ $order['number'] }}</span>
                                        <span class="px-3 py-1 text-xs font-bold rounded-full {{ $order['statusClass'] }}">
                                            {{ $order['status'] }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600">Placed {{ $order['date'] }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-xl">TZS {{ $order['amount'] }}</p>
                                    <span class="text-sm text-orange-600 font-medium">View Details →</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar: Profile + Quick Actions -->
        <div class="space-y-6">

            <!-- Profile Card -->
            <div class="bg-gradient-to-br from-orange-600 to-orange-700 rounded-2xl shadow-xl p-6 text-white">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-full flex items-center justify-center text-2xl font-bold border-2 border-white/40">
                        {{ $userInitial }}
                    </div>
                    <div>
                        <h4 class="font-bold text-xl">{{ $user->name }}</h4>
                        <p class="text-orange-100 text-sm">{{ $user->email }}</p>
                    </div>
                </div>
                <a href="{{ url('profile') }}" class="block text-center bg-white/20 hover:bg-white/30 py-3 rounded-xl font-semibold transition">
                    Manage Account →
                </a>
                <p class="text-xs text-orange-100 mt-3 text-center">Member since {{ $memberSince }}</p>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="font-bold text-lg mb-5 text-gray-900">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ url('products') }}" class="flex items-center gap-4 p-4 bg-orange-50 hover:bg-orange-100 rounded-xl transition">
                        <div class="w-12 h-12 bg-orange-600 rounded-xl flex items-center justify-center text-white">
                            <i class="fa-solid fa-store text-lg"></i>
                        </div>
                        <span class="font-semibold">Continue Shopping</span>
                    </a>
                    <a href="{{ url('addresses') }}" class="flex items-center gap-4 p-4 bg-amber-50 hover:bg-amber-100 rounded-xl transition">
                        <div class="w-12 h-12 bg-amber-600 rounded-xl flex items-center justify-center text-white">
                            <i class="fa-solid fa-location-dot text-lg"></i>
                        </div>
                        <span class="font-semibold">Manage Addresses ({{ $savedAddressesCount }})</span>
                    </a>
                    <a href="#" class="flex items-center gap-4 p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition">
                        <div class="w-12 h-12 bg-gray-700 rounded-xl flex items-center justify-center text-white">
                            <i class="fa-solid fa-headset text-lg"></i>
                        </div>
                        <span class="font-semibold">Contact Support</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Order Tracking -->
    <div class="mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-bold text-gray-900">Active Order Tracking</h3>
            @if($latestOrder)
                <a href="{{ url('order/' . $latestOrderNumber) }}" class="text-orange-600 font-semibold hover:underline">
                    View Order #{{$latestOrderNumber}} →
                </a>
            @endif
        </div>

        @if($latestOrder)
            <div class="mb-8 p-5 bg-orange-50 rounded-xl border border-orange-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <span class="font-bold text-xl">#{{ $latestOrderNumber }}</span>
                        <span class="text-gray-600 ml-4">• Placed on {{ $latestOrderDate }}</span>
                    </div>
                    <span class="font-bold text-xl">TZS {{ $latestOrderAmount }}</span>
                </div>
            </div>

            <!-- Progress Steps -->
            <div class="relative">
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
                            <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg
                                {{ $isDone || $isActive ? 'bg-orange-600' : 'bg-gray-300' }}
                                {{ $isActive ? 'ring-4 ring-orange-200' : '' }}">
                                @if($isDone)
                                    <i class="fa-solid fa-check"></i>
                                @else
                                    <i class="fa-solid {{ $stepIcons[$index] }}"></i>
                                @endif
                            </div>
                            <span class="mt-3 text-sm font-medium {{ $isActive || $isDone ? 'text-orange-600' : 'text-gray-500' }}">
                                {{ $step }}
                            </span>
                        </div>

                        @if($index < 3)
                            <div class="progress-bar absolute top-7 left-14 right-14 -z-10">
                                <div class="progress-fill" style="width: {{ $stepNum <= $currentStep ? '100%' : '0%' }}"></div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="mt-10 p-5 bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl border border-orange-200">
                <p class="text-gray-800 leading-relaxed">{!! $statusMessage !!}</p>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fa-solid fa-inbox text-6xl text-gray-300 mb-4"></i>
                <p class="text-xl font-semibold text-gray-700 mb-2">No Active Orders</p>
                <p class="text-gray-600 mb-6">When you place an order, track its status here in real-time.</p>
                <a href="{{ url('products') }}" class="inline-flex items-center gap-3 bg-orange-600 hover:bg-orange-700 text-white font-bold px-8 py-4 rounded-xl shadow-lg transition">
                    Start Shopping Now <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>

</main>
</body>
</html>