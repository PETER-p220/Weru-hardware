<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selcom Payment Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-orange-50 to-orange-100 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-black text-orange-600 mb-4">Selcom Payment Test</h1>
            <p class="text-gray-600 text-lg">Enter any phone number to test M-Pesa / Tigo Pesa / Airtel Money USSD push</p>
            <div class="mt-4 text-sm">
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">
                    Environment: {{ config('selcom.environment', 'Not Set') }}
                </span>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
                <p class="font-bold">❌ Error</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                <p class="font-bold">✅ Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
                <p class="font-bold">❌ Validation Errors:</p>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Configuration Check -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-lg">
            <p class="font-bold text-blue-900">🔧 Configuration Status:</p>
            <div class="mt-2 text-sm text-blue-800">
                <div>✓ Base URL: {{ config('selcom.base_url') ? 'Configured' : '❌ Missing' }}</div>
                <div>✓ API Key: {{ config('selcom.api_key') ? 'Configured' : '❌ Missing' }}</div>
                <div>✓ API Secret: {{ config('selcom.api_secret') ? 'Configured' : '❌ Missing' }}</div>
                <div>✓ Vendor ID: {{ config('selcom.vendor_id') ? 'Configured' : '❌ Missing' }}</div>
            </div>
        </div>

        <!-- Test Form -->
        <form action="{{ route('selcom.test.pay') }}" method="POST" class="bg-white rounded-3xl shadow-xl p-10 mb-8">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-lg font-bold text-gray-700 mb-3">Phone Number</label>
                    <input type="text" 
                           name="phone" 
                           value="{{ old('phone', '0616012915') }}" 
                           required
                           class="w-full px-6 py-5 border-2 border-gray-300 rounded-xl text-xl focus:border-orange-600 focus:outline-none transition @error('phone') border-red-500 @enderror"
                           placeholder="0616012915">
                    <p class="text-sm text-gray-500 mt-2">Format: 0XXXXXXXXX or 255XXXXXXXXX</p>
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-lg font-bold text-gray-700 mb-3">Amount (TZS)</label>
                    <input type="number" 
                           name="amount" 
                           value="{{ old('amount', '1000') }}" 
                           min="1000" 
                           required
                           class="w-full px-6 py-5 border-2 border-gray-300 rounded-xl text-xl focus:border-orange-600 focus:outline-none transition @error('amount') border-red-500 @enderror"
                           placeholder="1000">
                    <p class="text-sm text-gray-500 mt-2">Minimum: 1,000 TZS</p>
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <button type="submit" 
                    class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-5 px-8 rounded-xl text-xl shadow-lg transform hover:scale-105 transition-all duration-200">
                🚀 Test Payment
            </button>
        </form>

        <!-- Recent Transactions -->
        @if(isset($transactions) && $transactions->count() > 0)
            <div class="bg-white rounded-3xl shadow-xl p-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Recent Test Transactions</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-3 px-4 font-bold text-gray-700">Order ID</th>
                                <th class="text-left py-3 px-4 font-bold text-gray-700">Phone</th>
                                <th class="text-left py-3 px-4 font-bold text-gray-700">Amount</th>
                                <th class="text-left py-3 px-4 font-bold text-gray-700">Status</th>
                                <th class="text-left py-3 px-4 font-bold text-gray-700">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">
                                        <span class="font-mono text-sm">{{ $transaction->order_number }}</span>
                                    </td>
                                    <td class="py-3 px-4">{{ $transaction->customer_phone }}</td>
                                    <td class="py-3 px-4 font-bold">TZS {{ number_format($transaction->total_amount, 0) }}</td>
                                    <td class="py-3 px-4">
                                        @if($transaction->payment_status === 'paid')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                        @elseif($transaction->payment_status === 'unpaid')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">{{ ucfirst($transaction->payment_status) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-gray-100 rounded-xl p-8 text-center text-gray-500">
                <p class="text-lg">No transactions yet. Try making a test payment!</p>
            </div>
        @endif

        <!-- Back to Home -->
        <div class="text-center mt-8">
            <a href="{{ url('/') }}" class="text-orange-600 hover:text-orange-700 font-semibold">
                ← Back to Home
            </a>
        </div>

    </div>
</body>
</html>