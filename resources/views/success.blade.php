<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed Successfully - Weru Hardware</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4">

    <div class="max-w-lg w-full mx-auto text-center">
        <div class="bg-white rounded-3xl shadow-2xl p-10 border border-gray-100">

            <!-- Big Success Check -->
            <div class="mx-auto w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-8 animate-pulse">
                <svg class="w-14 h-14 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-4xl font-bold text-gray-900 mb-3">Order Received!</h1>
            <p class="text-xl text-gray-700 mb-6">Order #<span class="font-bold text-blue-600">{{ $order->order_number }}</span></p>

            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-6 mb-8">
                <p class="text-lg text-gray-800 leading-relaxed">
                    Asante sana <strong>{{ $order->customer_name }}</strong>!<br>
                    Your order worth <strong class="text-2xl text-green-600">TZS {{ number_format($order->total_amount, 0, '.', ',') }}</strong> has been received.
                </p>
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 mb-8">
                <p class="text-amber-800 font-bold text-lg mb-2">We will call you in the next 5–15 minutes</p>
                <p class="text-amber-700">
                    Our team is reviewing your order and will contact you on <strong>{{ $order->customer_phone }}</strong> to confirm items, delivery time, and payment method (Cash / Bank Transfer / M-Pesa).
                </p>
            </div>

            <!-- Auto WhatsApp Button for Admin -->
            @if(session('whatsapp'))
                <div class="my-8">
                    <a href="{{ session('whatsapp') }}" target="_blank"
                       class="inline-flex items-center gap-3 bg-green-600 text-white font-bold text-lg px-8 py-5 rounded-xl hover:bg-green-700 transition shadow-lg">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 5.843h-.004c-1.575-.05-3.111-.803-4.467-2.162l-.338-.262-.985.26c-.421.111-1.062.14-1.557.14-3.746 0-6.779-3.033-6.779-6.779 0-1.815.709-3.521 1.998-4.805l.262-.338.26-.985c.319-1.356 1.07-2.436 2.162-3.111l.004-.004c3.746 0 6.779 3.033 6.779 6.779 0 1.815-.709 3.521-1.998 4.805z"/>
                        </svg>
                        Send This Order to Admin WhatsApp Now
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4 mt-10">
                <a href="/products"
                   class="border-2 border-gray-300 text-gray-700 font-bold py-4 rounded-xl hover:bg-gray-50 transition">
                    Continue Shopping
                </a>
                <a href="https://wa.me/255784000000" target="_blank"
                   class="bg-green-600 text-white font-bold py-4 rounded-xl hover:bg-green-700 transition flex items-center justify-center gap-2">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 5.843h-.004c-1.575-.05-3.111-.803-4.467-2.162l-.338-.262-.985.26c-.421.111-1.062.14-1.557.14-3.746 0-6.779-3.033-6.779-6.779 0-1.815.709-3.521 1.998-4.805l.262-.338.26-.985c.319-1.356 1.07-2.436 2.162-3.111l.004-.004c3.746 0 6.779 3.033 6.779 6.779 0 1.815-.709 3.521-1.998 4.805z"/></svg>
                    Chat with Support
                </a>
            </div>

            <p class="text-sm text-gray-500 mt-10">
                Need help? Call us at <strong>0712 345 678</strong> or WhatsApp anytime
            </p>
        </div>
    </div>
</body>
</html>