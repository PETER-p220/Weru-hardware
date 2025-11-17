<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Weru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        * { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="text-xl font-bold text-gray-900">Weru Hardware</a>
                <a href="{{ route('cart') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                    ← Back to Cart ({{ count($cartItems) }} items)
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Complete Your Order</h2>

                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Delivery Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="name" value="{{ auth()->user()->name ?? '' }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Full Name">
                                <input type="tel" name="phone" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Phone Number (e.g. 0712 345 678)">
                            </div>
                            <div class="mt-4">
                                <input type="text" name="address" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Delivery Address (Street, Area, City)">
                            </div>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <select name="region" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                    <option value="">Select Region</option>
                                    <option value="dar">Dar es Salaam</option>
                                    <option value="arusha">Arusha</option>
                                    <option value="mwanza">Mwanza</option>
                                    <option value="dodoma">Dodoma</option>
                                </select>
                                <input type="text" name="notes"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                                       placeholder="Order notes (optional)">
                            </div>
                        </div>

                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold mb-4">Payment Method</h3>
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment" value="mpesa" checked class="mr-3">
                                    <span class="font-medium">M-Pesa (Recommended)</span>
                                </label>
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment" value="cash" class="mr-3">
                                    <span class="font-medium">Cash on Delivery</span>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Order Summary</h3>
                    <div class="space-y-3 mb-6">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                                <span>TZS {{ number_format($item['price'] * $item['quantity']) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t pt-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span>TZS {{ number_format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Delivery Fee</span>
                            <span>TZS {{ number_format($deliveryFee) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">VAT (18%)</span>
                            <span>TZS {{ number_format($vat) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-4 border-t">
                            <span>Total</span>
                            <span>TZS {{ number_format($total) }}</span>
                        </div>
                    </div>

                    <button type="submit" form="checkout-form" class="w-full mt-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all shadow-lg">
                        Place Order Now
                    </button>

                    <div class="mt-6 text-center text-xs text-gray-500">
                        By placing order, you agree to our <a href="#" class="text-blue-600">Terms</a> & <a href="#" class="text-blue-600">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>