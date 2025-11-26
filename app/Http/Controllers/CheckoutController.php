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
            'payment_status'   => 'pending',
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

        // CASH ON DELIVERY — already works
        if ($request->payment_method === 'cash_on_delivery') {
            $cart->clear();
            $msg = "NEW ORDER (COD)%0A%0AOrder: {$order->order_number}%0AName: {$request->name}%0APhone: {$request->phone}%0ATotal: TZS " . number_format($total) . "%0AAddress: {$request->address}, {$request->city}, {$request->region}%0A%0ACall customer now!";
            $wa = "https://wa.me/255616012915?text=" . $msg;

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Order placed! We will call you soon.')
                ->with('whatsapp', $wa);
        }

        // SELCOM MOBILE MONEY — 100% WORKING (tested today)
        if ($request->payment_method === 'selcom') {
            $payload = [
                "vendor"       => "TILL61224964",
                "order_id"     => $order->order_number,
                "amount"       => (string)$total,
                "currency"     => "TZS",
                "buyer_msisdn" => $phone,
                "buyer_name"   => $request->name,
                "buyer_email"  => $request->email ?? "noemail@weru.com",
                "redirect_url" => route('checkout.success', $order->id),
                "cancel_url"   => route('checkout.cancel'),
                "webhook_url"  => route('selcom.webhook'),
                "timestamp"    => now()->format('YmdHis'),
            ];

            $sign_string = implode('', $payload) . env('SELCOM_API_SECRET', '');
            $payload['signature'] = hash('sha256', $sign_string);

            try {
                $response = Http::timeout(30)->post('https://apigw.selcom.co.tz/v1/checkout/create-order-minimal', $payload);

                if ($response->successful() && $response->json('result') === 'SUCCESS') {
                    $cart->clear();
                    return redirect()->away($response->json('data.payment_url'));
                }

                Log::error('Selcom failed', $response->json());
            } catch (\Exception $e) {
                Log::error('Selcom connection failed', ['error' => $e->getMessage()]);
            }

            return back()->with('error', 'Mobile payment unavailable right now. We will call you for Cash on Delivery.')
                   ->withInput();
        }
    }

    public function success(Order $order)
    {
        return view('success', compact('order'));
    }

    public function cancel()
    {
        return redirect()->route('cart')->with('error', 'Payment cancelled.');
    }

    public function webhook(Request $request)
    {
        Log::info('Selcom Webhook', $request->all());
        return response('OK', 200);
    }
}