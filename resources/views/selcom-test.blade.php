<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selcom Test • Weru Hardware</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen py-12">
<div class="max-w-4xl mx-auto px-6">

    <div class="bg-white rounded-3xl shadow-2xl p-10 text-center mb-10">
        <h1 class="text-4xl font-black text-orange-600 mb-4">Selcom Payment Test</h1>
        <p class="text-gray-600 text-lg">Enter any phone number to test M-Pesa / Tigo Pesa / Airtel Money USSD push</p>
    </div>

    <!-- Test Form -->
    <form action="{{ route('selcom.test.pay') }}" method="POST" class="bg-white rounded-3xl shadow-xl p-10">
        @csrf
        <div class="grid md:grid-cols-2 gap-8 mb-8">
            <div>
                <label class="block text-lg font-bold text-gray-700 mb-3">Phone Number</label>
                <input type="text" name="phone" value="0616012915" required
                       class="w-full px-6 py-5 border-2 border-gray-300 rounded-xl text-xl focus:border-orange-600 focus:outline-none transition"
                       placeholder="0616012915">
            </div>
            <div>
                <label class="block text-lg font-bold text-gray-700 mb-3">Amount (TZS)</label>
                <input type="number" name="amount" value="1000" min="100" required
                       class="w-full px-6 py-5 border-2 border-gray-300 rounded-xl text-xl focus:border-orange-600 focus:outline-none">
            </div>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-orange-700 text-white font-black text-2xl py-6 rounded-2xl hover:shadow-2xl transform hover:scale-105 transition duration-300 flex items-center justify-center gap-4">
            <i class="fa-solid fa-mobile-alt text-3xl"></i>
            Send USSD Push Now!
        </button>
    </form>

    <!-- Recent Transactions -->
    <div class="mt-12 bg-white rounded-3xl shadow-xl p-10">
        <h2 class="text-3xl font-black text-gray-800 mb-8 flex items-center gap-4">
            <i class="fa-solid fa-history text-orange-600"></i> Recent Transactions
        </h2>

        @if($transactions->count() > 0)
            <div class="space-y-6">
                @foreach($transactions as $t)
                    <div class="bg-gray-50 rounded-2xl p-6 border-l-8 border-orange-600">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-2xl font-bold text-gray-800">TZS {{ number_format($t->amount) }}</p>
                                <p class="text-gray-600">Order: <strong>{{ $t->order_id }}</strong></p>
                                <p class="text-gray-600">Phone: <strong>{{ $t->msisdn }}</strong></p>
                            </div>
                            <div class="text-right">
                                <span class="px-4 py-2 rounded-full text-white font-bold text-sm
                                    {{ $t->result === 'SUCCESS' ? 'bg-green-600' : 'bg-orange-600' }}">
                                    {{ $t->result ?? 'PENDING' }}
                                </span>
                                <p class="text-gray-500 text-sm mt-2">{{ $t->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 text-xl py-12">No transactions yet. Make your first test payment!</p>
        @endif
    </div>
</div>
</body>
</html>