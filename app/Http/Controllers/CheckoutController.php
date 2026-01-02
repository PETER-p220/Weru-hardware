<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }

    public function process(Request $request)
    {
        $cart = Cart::current();
        if ($cart->totalItems() === 0) {
            return back()->with('error', 'Your cart is empty.');
        }

        $subtotal = $cart->subtotal();
        $delivery = 25000;
        $total    = $subtotal + $delivery;

        $phone = '255' . substr(preg_replace('/\D/', '', $request->phone), -9);

        $order = Order::create([
            'user_id'           => Auth::id() ?? null,
            'order_number'      => 'OH-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
            'total_amount'      => $total,
            'status'            => 'new',
            'payment_status'    => 'pending',
            'payment_method'    => $request->payment_method,
            'customer_name'     => $request->name,
            'customer_email'    => $request->email,
            'customer_phone'    => $phone,
            'shipping_address'  => $request->address . ', ' . $request->city . ', ' . $request->region,
            'notes'             => $request->notes,
            'items'             => $cart->items,
            'subtotal'          => $subtotal,
            'delivery_fee'      => $delivery,
            'latitude'          => $request->latitude ?: null,
            'longitude'         => $request->longitude ?: null,
            'location_accuracy' => $request->location_accuracy ?: null,
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item['product_id'],
                'product_name' => $item['name'],
                'quantity'     => $item['quantity'],
                'price'        => $item['price'],
                'subtotal'     => $item['price'] * $item['quantity'],
            ]);
        }

        $cart->clear();

        // CASH ON DELIVERY
        if ($request->payment_method === 'cash_on_delivery') {
            $msg = "NEW ORDER (COD)%0A%0AOrder: {$order->order_number}%0AName: {$request->name}%0APhone: {$request->phone}%0ATotal: TZS " . number_format($total) . "%0AAddress: {$request->address}, {$request->city}, {$request->region}%0A%0ACall customer now!";
            $wa = "https://wa.me/255616012915?text=" . $msg;

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Order placed! We will call you soon.')
                ->with('whatsapp', $wa);
        }

        // OWERU SELCOM CONSOLE (Push USSD)
        if ($request->payment_method === 'selcom') {
            $baseUrl = 'https://api.selcom.oweru.com/api/checkout'; // From your earlier description
            $appKey  = env('OWERU_APP_KEY'); // Your X-App-Key from console

            if (!$appKey) {
                Log::error('Missing OWERU_APP_KEY in .env');
                return back()->with('error', 'Payment service not configured.');
            }

            try {
                // Step 1: Create order
                $create = Http::withHeaders([
                    'X-App-Key'     => $appKey,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                ])->post($baseUrl . '/create-order-minimal', [
                    'amount'   => number_format($total, 2, '.', ''),
                    'currency' => 'TZS',
                    'msisdn'   => $phone,
                ]);

                $createData = $create->json();

                Log::info('Oweru Create Order Response', $createData);

                if (!$create->successful() || $createData['result'] ?? '' !== 'SUCCESS') {
                    Log::error('Oweru Create Failed', $createData);
                    return back()->with('error', 'Payment initiation failed. Use Cash on Delivery.');
                }

                $selcomOrderId = $createData['data']['order_id'] ?? null;

                if (!$selcomOrderId) {
                    return back()->with('error', 'No order ID received.');
                }

                // Step 2: Trigger Push USSD
                $pay = Http::withHeaders([
                    'X-App-Key'     => $appKey,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                ])->post($baseUrl . '/wallet-payment', [
                    'order_id' => $selcomOrderId,
                    'msisdn'   => $phone,
                    'amount'   => number_format($total, 2, '.', ''),
                ]);

                $payData = $pay->json();

                Log::info('Oweru Wallet Payment Response', $payData);

                $order->update([
                    'payment_status' => 'pending',
                    'transaction_id' => $selcomOrderId,
                ]);

                $message = "Payment request sent to {$request->phone}! Check your phone and approve the prompt from M-Pesa/Tigo Pesa/Airtel Money/HaloPesa.";

                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success'       => true,
                        'message'       => $message,
                        'order_id'      => $order->id,
                        'order_number'  => $order->order_number,
                        'selcom_order'  => $selcomOrderId,
                    ]);
                }

                return redirect()->route('checkout.success', $order->id)->with('success', $message);

            } catch (\Exception $e) {
                Log::error('Oweru Console Exception', ['message' => $e->getMessage()]);
                return back()->with('error', 'Payment service unavailable. Use Cash on Delivery.');
            }
        }

        return back()->with('error', 'Invalid payment method.');
    }

    public function success(Order $order)
    {
        $order->load(['orderItems.product', 'user']);
        return view('success', compact('order'));
    }

    public function checkStatus($orderId)
    {
        $order = Order::findOrFail($orderId);

        return response()->json([
            'payment_status' => $order->payment_status,
            'order_status'   => $order->status,
            'is_paid'        => $order->payment_status === 'paid',
        ]);
    }

    public function cancel()
    {
        return redirect()->route('cart')->with('error', 'Payment cancelled. You can try again.');
    }

    public function webhook(Request $request)
    {
        Log::info('Selcom Webhook Received', $request->all());

        $orderNumber = $request->input('order_id');
        $status      = $request->input('status');
        $transId     = $request->input('transaction_id');

        $order = Order::where('order_number', $orderNumber)->first();

        if ($order) {
            if (in_array($status, ['COMPLETED', 'SUCCESS'])) {
                $order->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $transId ?? $order->transaction_id,
                    'paid_at'        => now(),
                    'status'         => 'confirmed',
                ]);
            } elseif (in_array($status, ['FAILED', 'CANCELLED'])) {
                $order->update(['payment_status' => 'failed']);
            }
        }

        return response('OK', 200);
    }
}