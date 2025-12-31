<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed Successfully - Oweru Hardware</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; -webkit-tap-highlight-color: transparent; }
        :root {
            --primary: rgb(218,165,32);
            --primary-dark: #002147;
            --primary-light: #f5f5f5;
        }
        body { background-color: #f5f5f5; }
        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f5f5f5; }
        ::-webkit-scrollbar-thumb { background: rgb(218,165,32); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #d4af37; }
        /* Mobile Optimizations */
        @media (max-width: 768px) {
            body { padding: 1rem; }
            .text-4xl { font-size: 1.875rem; }
            .text-3xl { font-size: 1.5rem; }
            .text-2xl { font-size: 1.5rem; }
            .text-xl { font-size: 1.125rem; }
            .p-10 { padding: 1.5rem; }
            .py-12 { padding: 1rem 0; }
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center py-8 lg:py-12 px-3 lg:px-4">

    <div class="max-w-lg w-full mx-auto text-center">
        <div class="bg-white rounded-2xl lg:rounded-3xl shadow-lg lg:shadow-2xl p-6 lg:p-10 border border-gray-200">

            <!-- Big Success Check -->
            <div class="mx-auto w-16 lg:w-24 h-16 lg:h-24 rounded-full flex items-center justify-center mb-6 lg:mb-8 animate-pulse" style="background: rgba(76,175,80,0.15);">
                <svg class="w-10 lg:w-14 h-10 lg:h-14 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-2xl lg:text-4xl font-bold text-gray-900 mb-2 lg:mb-3">Order Received!</h1>
            <p class="text-base lg:text-xl text-gray-700 mb-4 lg:mb-6">Order #<span class="font-bold" style="color: #002147;">{{ $order->order_number }}</span></p>

            <div class="rounded-lg lg:rounded-2xl p-4 lg:p-6 mb-6 lg:mb-8" style="background: rgba(218,165,32,0.08); border: 1px solid rgba(218,165,32,0.2);">
                <p class="text-base lg:text-lg text-gray-800 leading-relaxed">
                    Asante sana <strong>{{ $order->customer_name }}</strong>!<br>
                    Your order worth <strong class="text-lg lg:text-2xl" style="color: #4caf50;">TZS {{ number_format($order->total_amount, 0, '.', ',') }}</strong> has been received.
                </p>
            </div>

            <div class="rounded-lg lg:rounded-2xl p-4 lg:p-6 mb-6 lg:mb-8" style="background: rgba(218,165,32,0.1); border: 1px solid rgba(218,165,32,0.3);">
                <p class="font-bold text-base lg:text-lg mb-1 lg:mb-2" style="color: #002147;">We will call you in the next 5–15 minutes</p>
                <p class="text-sm lg:text-base" style="color: #002147;">
                    Our team is reviewing your order and will contact you on <strong>{{ $order->customer_phone }}</strong> to confirm items, delivery time, and payment method (Cash / Bank Transfer / M-Pesa).
                </p>
            </div>

            <!-- Auto WhatsApp Button for Admin -->
            @if(session('whatsapp'))
                <div class="my-6 lg:my-8">
                    <a href="{{ session('whatsapp') }}" target="_blank"
                       class="inline-flex items-center gap-2 lg:gap-3 text-white font-bold text-base lg:text-lg px-6 lg:px-8 py-3 lg:py-5 rounded-lg lg:rounded-xl hover:shadow-lg transition" style="background: #4caf50;">
                        <i class="fa-brands fa-whatsapp text-lg lg:text-2xl"></i>
                        Send Order to Admin WhatsApp
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-3 lg:gap-4 mt-8 lg:mt-10">
                <a href="/products"
                   class="border-2 border-gray-300 text-gray-700 font-bold py-3 lg:py-4 rounded-lg lg:rounded-xl hover:bg-gray-50 transition text-sm lg:text-base">
                    Continue Shopping
                </a>
                <a href="https://wa.me/255784000000" target="_blank"
                   class="text-white font-bold py-3 lg:py-4 rounded-lg lg:rounded-xl hover:shadow-lg transition flex items-center justify-center gap-1.5 lg:gap-2 text-sm lg:text-base" style="background: #4caf50;">
                    <i class="fa-brands fa-whatsapp text-lg lg:text-xl"></i>
                    <span>Chat Support</span>
                </a>
            </div>

            <p class="text-xs lg:text-sm text-gray-500 mt-8 lg:mt-10">
                Need help? Call us at <strong>0712 345 678</strong> or WhatsApp anytime
            </p>
        </div>
    </div>
</body>
</html>