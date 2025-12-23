<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details #{{ $order->order_number }} | Oweru Hardware</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { -webkit-tap-highlight-color: transparent; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #f9f9f9 0%, #f5f5f5 100%); }
        :root { --primary: rgb(218,165,32); --dark-blue: #002147; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: rgb(218,165,32); border-radius: 4px; }
    </style>
</head>
<body class="min-h-screen py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('order') }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Orders</span>
            </a>
            <a href="{{ route('order.invoice', $order) }}" class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition flex items-center gap-2">
                <i class="fa-solid fa-download"></i>
                Download Invoice
            </a>
        </div>

        <!-- Order Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 lg:p-8 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6 pb-6 border-b border-gray-200">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Order #{{ $order->order_number }}</h1>
                    <p class="text-gray-600">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
                <div class="flex flex-col items-end gap-2">
                    <span class="px-4 py-2 rounded-full text-sm font-bold
                        {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                        {{ in_array($order->status, ['pending', 'new']) ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ in_array($order->status, ['shipped', 'in_transit']) ? 'bg-indigo-100 text-indigo-800' : '' }}
                        {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                    </span>
                    <span class="px-4 py-2 rounded-full text-sm font-bold
                        {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Order Items</h2>
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover rounded-lg">
                            @else
                                <i class="fa-solid fa-box text-2xl text-gray-400"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">{{ $item->product_name }}</h3>
                            <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900">TZS {{ number_format($item->subtotal, 0) }}</p>
                            <p class="text-sm text-gray-600">TZS {{ number_format($item->price, 0) }} each</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="border-t border-gray-200 pt-6">
                <div class="space-y-3">
                    <div class="flex justify-between text-gray-700">
                        <span>Subtotal</span>
                        <span class="font-semibold">TZS {{ number_format($order->subtotal ?? ($order->total_amount - ($order->delivery_fee ?? 25000) - ($order->vat_amount ?? 0)), 0) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-700">
                        <span>Delivery Fee</span>
                        <span class="font-semibold">TZS {{ number_format($order->delivery_fee ?? 25000, 0) }}</span>
                    </div>
                    @if($order->vat_amount)
                    <div class="flex justify-between text-gray-700">
                        <span>VAT (18%)</span>
                        <span class="font-semibold">TZS {{ number_format($order->vat_amount, 0) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-xl font-bold text-gray-900 pt-3 border-t-2 border-gray-300">
                        <span>Total</span>
                        <span>TZS {{ number_format($order->total_amount, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 lg:p-8 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Shipping Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Customer</h3>
                    <p class="text-gray-900">{{ $order->customer_name }}</p>
                    <p class="text-gray-600">{{ $order->customer_email }}</p>
                    <p class="text-gray-600">{{ $order->customer_phone }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Delivery Address</h3>
                    <p class="text-gray-900">{{ $order->shipping_address }}</p>
                    @if($order->latitude && $order->longitude)
                    <p class="text-sm text-gray-500 mt-2">
                        <i class="fa-solid fa-map-marker-alt"></i> 
                        Location: {{ number_format($order->latitude, 6) }}, {{ number_format($order->longitude, 6) }}
                    </p>
                    @endif
                </div>
            </div>
            @if($order->notes)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="font-semibold text-gray-700 mb-2">Notes</h3>
                <p class="text-gray-900">{{ $order->notes }}</p>
            </div>
            @endif
        </div>

        <!-- Payment Information -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 lg:p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Payment Information</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-700">Payment Method</span>
                    <span class="font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">Payment Status</span>
                    <span class="px-3 py-1 rounded-full text-sm font-bold {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                @if($order->paid_at)
                <div class="flex justify-between">
                    <span class="text-gray-700">Paid At</span>
                    <span class="font-semibold text-gray-900">{{ $order->paid_at->format('F d, Y \a\t h:i A') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
