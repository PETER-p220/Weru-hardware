
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Weru Hardware Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="flex items-center justify-between px-6 py-4">
            <div class="flex items-center space-x-8">
                <h1 class="text-2xl font-bold text-blue-600">Weru Hardware Admin</h1>
                <nav class="hidden md:flex space-x-6">
                    <a href="/adminDashboard" class="text-blue-600 font-medium">Dashboard</a>
                    <a href="/createProduct" class="text-gray-600 hover:text-gray-900">Products</a>
                    <a href="OrderManagement" class="text-gray-600 hover:text-gray-900">Orders</a>
                    <a href="/user" class="text-gray-600 hover:text-gray-900">Customers</a>
                    <a href="#" class="text-gray-600 hover:text-gray-900">Settings</a>
                </nav>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm font-medium">Admin User</p>
                    <p class="text-xs text-gray-500">Administrator</p>
                </div>
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-6 py-8">
        <!-- Dashboard Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Dashboard Overview</h2>
            <p class="text-gray-600">Welcome back! Here's what's happening today.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Revenue</h3>
                    <span class="text-xs text-green-600 font-semibold">TZS {{$price}}</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Orders</h3>
                    <span class="text-xs text-green-600 font-semibold"></span>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $orders->count() }}</p>
                <p class="text-xs text-gray-500 mt-2">vs. last month</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Products</h3>
                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Active</span>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $products->count() }}</p>
                <p class="text-xs text-gray-500 mt-2">In catalog</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Customers</h3>
                    <span class="text-xs text-green-600 font-semibold">+15.3%</span>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $users->count() }}</p>
                <p class="text-xs text-gray-500 mt-2">vs. last month</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Orders - Main Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($orders->take(10) as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">TZS {{ number_format($order->total_amount, 0) }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full font-medium
                                            @if($order->status == 'delivered') bg-green-100 text-green-800
                                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                            @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="openOrderModal({{ $order->id }}, '{{ $order->order_number }}', '{{ $order->status }}')" 
                                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Update
                                            </button>
                                            <a href="" class="text-gray-600 hover:text-gray-800 text-sm">View</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                    <a href="/createProduct" class="bg-blue-600 text-white rounded-lg p-4 text-center hover:bg-blue-700 transition">
                        <p class="font-semibold">Add Product</p>
                    </a>
                    <a href="/OrderManagement" class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center hover:border-blue-600 transition">
                        <p class="font-semibold text-gray-700">View Orders</p>
                    </a>
                    <a href="/user" class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center hover:border-blue-600 transition">
                        <p class="font-semibold text-gray-700">Customers</p>
                    </a>
                    <button class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center hover:border-blue-600 transition">
                        <p class="font-semibold text-gray-700">Analytics</p>
                    </button>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Low Stock Alert -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Low Stock Alert</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Roofing Sheet 3m</p>
                                <p class="text-xs text-red-600">Only 8 left</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Circuit Breaker 100A</p>
                                <p class="text-xs text-yellow-600">Only 12 left</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-orange-50 rounded">
                            <div>
                                <p class="text-sm font-medium text-gray-900">PVC Pipe 110mm</p>
                                <p class="text-xs text-orange-600">Only 15 left</p>
                            </div>
                        </div>
                    </div>
                    <button class="w-full mt-4 bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                        Restock Items
                    </button>
                </div>

                <!-- Top Products -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Products</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl font-bold text-gray-400">1</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Mbeya Cement 50kg</p>
                                <p class="text-xs text-gray-500">452 sold</p>
                            </div>
                            <span class="text-xs text-green-600 font-semibold">↑ 23%</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl font-bold text-gray-400">2</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Y12 TMT Steel</p>
                                <p class="text-xs text-gray-500">328 sold</p>
                            </div>
                            <span class="text-xs text-green-600 font-semibold">↑ 18%</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl font-bold text-gray-400">3</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Crown Paint 20L</p>
                                <p class="text-xs text-gray-500">287 sold</p>
                            </div>
                            <span class="text-xs text-green-600 font-semibold">↑ 15%</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm text-gray-900">New order received</p>
                                <p class="text-xs text-gray-500">2 minutes ago</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm text-gray-900">Product restocked</p>
                                <p class="text-xs text-gray-500">15 minutes ago</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm text-gray-900">New customer registered</p>
                                <p class="text-xs text-gray-500">1 hour ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Update Modal -->
    <div id="orderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Update Order Status</h3>
                <button onclick="closeOrderModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="orderStatusForm" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Order Number</label>
                        <input type="text" id="modalOrderNumber" readonly 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Order Status</label>
                        <select name="status" id="orderStatus" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div id="statusMessage" class="hidden p-3 rounded-lg"></div>
                </div>
                <div class="flex items-center justify-end space-x-3 p-6 border-t bg-gray-50">
                    <button type="button" onclick="closeOrderModal()"
                            class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-white border-t mt-12 py-6">
        <div class="container mx-auto px-6 flex items-center justify-between">
            <p class="text-sm text-gray-600">© 2024 Weru Hardware. All rights reserved.</p>
            <div class="flex space-x-6">
                <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Help Center</a>
                <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Documentation</a>
                <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
            </div>
        </div>
    </footer>

    <script>
        let currentOrderId = null;

        function openOrderModal(orderId, orderNumber, currentStatus) {
            currentOrderId = orderId;
            document.getElementById('modalOrderNumber').value = orderNumber;
            document.getElementById('orderStatus').value = currentStatus;
            document.getElementById('orderModal').classList.remove('hidden');
            document.getElementById('statusMessage').classList.add('hidden');
        }

        function closeOrderModal() {
            document.getElementById('orderModal').classList.add('hidden');
            currentOrderId = null;
        }

        document.getElementById('orderStatusForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const statusMessage = document.getElementById('statusMessage');
            
            try {
                const response = await fetch(`/admin/orders/${currentOrderId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    statusMessage.className = 'p-3 rounded-lg bg-green-100 text-green-800';
                    statusMessage.textContent = 'Order status updated successfully!';
                    statusMessage.classList.remove('hidden');
                    
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Failed to update order status');
                }
            } catch (error) {
                statusMessage.className = 'p-3 rounded-lg bg-red-100 text-red-800';
                statusMessage.textContent = error.message;
                statusMessage.classList.remove('hidden');
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeOrderModal();
            }
        });

        // Close modal on background click
        document.getElementById('orderModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeOrderModal();
            }
        });
    </script>
</body>
</html>