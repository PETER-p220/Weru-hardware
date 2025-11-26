<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }

    public function process(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email',
            'phone'          => 'required|regex:/^0[67][0-9]{8}$/',
            'address'        => 'required|string',
            'region'         => 'required|string',
            'city'           => 'required|string',
            'notes'          => 'nullable|string',
            'payment_method' => 'required|in:cash_on_delivery,selcom',
        ]);

        $cart = Cart::current();
        if ($cart->totalItems() === 0) {
            return back()->with('error', 'Your cart is empty.');
        }

        $subtotal = $cart->subtotal();
        $delivery = 25000;
        $vat      = round($subtotal * 0.18);
        $total    = $subtotal + $delivery + $vat;
        $phone    = '255' . substr(preg_replace('/\D/', '', $request->phone), -9);

        $order = Order::create([
            'user_id'          => Auth::id() ?? null,
            'order_number'     => 'WH-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
            'total_amount'     => $total,
            'status'           => 'new',
            'payment_status'   => $request->payment_method === 'selcom' ? 'pending' : 'pending',
            'payment_method'   => $request->payment_method,
            'customer_name'    => $request->name,
            'customer_email'   => $request->email,
            'customer_phone'   => $phone,
            'shipping_address' => $request->address . ', ' . $request->city . ', ' . $request->region,
            'notes'            => $request->notes,
            'items'            => json_encode($cart->items),
            'subtotal'         => $subtotal,
            'delivery_fee'     => $delivery,
            'vat_amount'       => $vat,
        ]);

        // CLEAR CART HAPA HAPA — kabla ya malipo (hii ni best practice)
        $cart->clear();

        // CASH ON DELIVERY
        if ($request->payment_method === 'cash_on_delivery') {
            $msg = "NEW ORDER (COD)%0A%0AOrder: {$order->order_number}%0AName: {$request->name}%0APhone: {$request->phone}%0ATotal: TZS " . number_format($total) . "%0AAddress: {$request->address}, {$request->city}, {$request->region}%0A%0ACall customer now!";
            $wa = "https://wa.me/255616012915?text=" . $msg;

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Order placed! We will call you soon.')
                ->with('whatsapp', $wa);
        }

        // SELCOM MOBILE MONEY — ITAKUFANYA KAZI KAMILI LIVE
        if ($request->payment_method === 'selcom') {
            $payload = [
                "vendor"       => "TILL61224964",
                "amount"       => number_format($total, 2, '.', ''),
                "currency"     => "TZS",
                "order_id"     => $order->order_number,
                "buyer_msisdn" => $phone,
                "buyer_name"   => $request->name,
                "buyer_email"  => $request->email,
                "redirect_url" => route('checkout.success', $order->id),
                "cancel_url"   => route('checkout.cancel'),
                "webhook_url"  => route('selcom.webhook'),
                "timestamp"    => now()->format('YmdHis'),
            ];

            $sign_string = $payload['vendor']
                         . $payload['amount']
                         . $payload['currency']
                         . $payload['order_id']
                         . $payload['buyer_msisdn']
                         . $payload['buyer_name']
                         . $payload['buyer_email']
                         . $payload['redirect_url']
                         . $payload['cancel_url']
                         . $payload['webhook_url']
                         . $payload['timestamp']
                         . env('SELCOM_API_SECRET');

            $payload['signature'] = hash('sha256', $sign_string);

            $response = Http::timeout(30)
                ->withHeaders(['Accept' => 'application/json'])
                ->post('https://apigw.selcommobile.com/v1/checkout/create-order-minimal', $payload);

            if ($response->successful() && $response->json('result') === 'SUCCESS') {
                return redirect()->away($response->json('data.payment_url'));
            }

            Log::error('Selcom Payment Failed', [
                'order' => $order->order_number,
                'response' => $response->json()
            ]);

            return back()->with('error', 'Mobile payment failed. We\'ve saved your order — we will call you for Cash on Delivery.')
                         ->withInput();
        }
    }

    public function success(Order $order)
    {
        // Hapa tunaweza update status to 'paid' kama tunatumia webhook
        return view('success', compact('order'));
    }

    public function cancel()
    {
        return redirect()->route('cart')->with('error', 'Payment cancelled. You can try again.');
    }

    public function webhook(Request $request)
    {
        Log::info('Selcom Webhook Received', $request->all());

        // Hapa utaweka logic ya ku-update order status to 'paid' automatically
        // (nitakupa hii code baadae)

        return response('OK', 200);
    }
}