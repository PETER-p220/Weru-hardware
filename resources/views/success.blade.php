<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - Weru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap'); * { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md mx-auto text-center">
        <div class="bg-white rounded-2xl shadow-xl p-10">
            <!-- Success Icon -->
            <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">Payment Successful!</h1>
            <p class="text-lg text-gray-700 mb-2">Order #{{ $order->order_number }}</p>
            <p class="text-gray-600 mb-8">
                Thank you, <strong>{{ $order->customer_name }}</strong>!<br>
                We have received your payment of <strong>TZS {{ number_format($order->total_amount, 0, '.', ',') }}</strong>
            </p>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
                <p class="text-green-800 font-medium">Your order is being prepared for delivery</p>
                <p class="text-sm text-green-700 mt-1">Expect delivery within 1–3 business days in Dar es Salaam</p>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                <p class="text-blue-800 font-medium">Phone used for payment: <strong>{{ session('phone') }}</strong></p>
                <p class="text-sm text-blue-700 mt-1">Selcom response: <pre>{{ session('selcom_action') }}</pre></p>
            </div>

            <div class="space-y-3">
                <a href="{{ route('orders.show', $order->id) }}" 
                   class="block w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition">
                    View Order Details
                </a>
                <a href="/" class="block w-full border border-gray-300 text-gray-700 font-medium py-3 rounded-lg hover:bg-gray-50 transition">
                    Continue Shopping
                </a>
            </div>

            <p class="text-sm text-gray-500 mt-8">
                Questions? Call us at <strong>0712 345 678</strong> or WhatsApp
            </p>
        </div>
    </div>
</body>
</html>