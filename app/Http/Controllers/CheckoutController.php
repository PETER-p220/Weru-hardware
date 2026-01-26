<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }

    public function process(Request $request)
    {
        // ────────────────────────────────────────────────
        // FORCE JSON MODE FOR AJAX / FETCH REQUESTS
        // ────────────────────────────────────────────────
        if ($request->header('X-Requested-With') === 'XMLHttpRequest' ||
            str_contains($request->header('Accept', ''), 'application/json')) {
            $request->headers->set('Accept', 'application/json');
            $request->setRequestFormat('json');
        }

        // Debug log - remove this after confirming it works
        Log::debug('Checkout::process - request detection', [
            'is_ajax'          => $request->ajax(),
            'expects_json'     => $request->expectsJson(),
            'wants_json'       => $request->wantsJson(),
            'accept_header'    => $request->header('Accept'),
            'x_requested_with' => $request->header('X-Requested-With'),
            'content_type'     => $request->header('Content-Type'),
            'forced_json'      => $request->expectsJson(),
        ]);

        $cart = Cart::current();
        if ($cart->totalItems() === 0) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Your cart is empty.'], 400);
            }
            return back()->with('error', 'Your cart is empty.');
        }

        $subtotal  = $cart->subtotal();
        $delivery  = 25000;
        $total     = $subtotal + $delivery;

        // Normalize Tanzanian phone number
        $rawPhone = preg_replace('/\D/', '', $request->phone);
        $phone    = '255' . substr($rawPhone, -9);

        if (strlen($phone) !== 12 || !preg_match('/^255[67][1256789]\d{7}$/', $phone)) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Invalid Tanzanian mobile number format (e.g. 0712 345 678).'], 422);
            }
            return back()->with('error', 'Please enter a valid Tanzanian mobile number (e.g. 0712 345 678).');
        }

        // Generate unique order number
        $orderNumber = 'OH-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        $merchantOrderId = $orderNumber;

        $order = Order::create([
            'user_id'           => Auth::id() ?? null,
            'order_number'      => $orderNumber,
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

        // ────────────────────────────────────────────────
        // CASH ON DELIVERY
        // ────────────────────────────────────────────────
        if ($request->payment_method === 'cash_on_delivery') {
            $msg = "NEW ORDER (COD)%0A%0AOrder: {$order->order_number}%0AName: {$request->name}%0APhone: {$request->phone}%0ATotal: TZS " . number_format($total) . "%0AAddress: {$request->address}, {$request->city}, {$request->region}%0A%0ACall customer now!";
            $wa  = "https://wa.me/255616012915?text=" . $msg;

            if ($request->expectsJson()) {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Order placed! We will call you soon.',
                    'whatsapp' => $wa,
                    'order_id' => $order->id,
                ]);
            }

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Order placed! We will call you soon.')
                ->with('whatsapp', $wa);
        }

        // ────────────────────────────────────────────────
        // SELCOM via OWERU WRAPPER – Push USSD
        // ────────────────────────────────────────────────
        if ($request->payment_method === 'selcom') {
            $baseUrl = 'https://api.selcom.oweru.com/api/checkout';
            $appKey  = env('OWERU_APP_KEY');

            if (!$appKey) {
                Log::error('Missing OWERU_APP_KEY in .env');
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'Payment service not configured. Please use Cash on Delivery.'], 503);
                }
                return back()->with('error', 'Payment service not configured. Please use Cash on Delivery.');
            }

            try {
                // Step 1: Create order
                $createResponse = Http::withHeaders([
                    'X-App-Key'     => $appKey,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                ])->post($baseUrl . '/create-order-minimal', [
                    'order_id'         => $merchantOrderId,
                    'buyer_name'       => $request->name,
                    'buyer_email'      => $request->email,
                    'buyer_phone'      => $phone,
                    'amount'           => number_format($total, 0, '.', ''),
                    'currency'         => 'TZS',
                    'buyer_remarks'    => 'Hardware purchase via website',
                    'merchant_remarks' => 'Order #' . $order->id,
                    'no_of_items'      => $cart->totalItems(),
                ]);

                $createData = $createResponse->json();

                Log::info('Oweru Create Order Response', [
                    'status' => $createResponse->status(),
                    'body'   => $createData,
                ]);

                if (!$createResponse->successful() || ($createData['result'] ?? '') !== 'SUCCESS') {
                    $errorMsg = $createData['message'] ?? $createData['error'] ?? 'Unknown error from Oweru';
                    Log::error('Oweru Create Order Failed', $createData);
                    if ($request->expectsJson()) {
                        return response()->json(['success' => false, 'message' => "Could not initiate payment: $errorMsg"], 400);
                    }
                    return back()->with('error', "Could not initiate payment: $errorMsg. Please try Cash on Delivery.");
                }

                // Step 2: Trigger wallet payment (Push USSD)
                $payResponse = Http::withHeaders([
                    'X-App-Key'     => $appKey,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                ])->post($baseUrl . '/wallet-payment', [
                    'order_id' => $merchantOrderId,
                    'transid'  => $merchantOrderId,
                    'msisdn'   => $phone,
                ]);

                $payData = $payResponse->json();

                Log::info('Oweru Wallet Payment Response', [
                    'status' => $payResponse->status(),
                    'body'   => $payData,
                ]);

                if (!$payResponse->successful()) {
                    $errorMsg = $payData['message'] ?? 'Payment trigger failed';
                    Log::error('Oweru Wallet Payment Failed', $payData);
                    if ($request->expectsJson()) {
                        return response()->json(['success' => false, 'message' => "Payment request could not be sent: $errorMsg"], 400);
                    }
                    return back()->with('error', "Payment request could not be sent: $errorMsg");
                }

                // Update order
                $order->update([
                    'payment_status' => 'pending',
                    'transaction_id' => $merchantOrderId,
                ]);

                $message = "Payment request sent to {$request->phone}! Please check your phone and approve the prompt.";

                if ($request->expectsJson()) {
                    return response()->json([
                        'success'       => true,
                        'message'       => $message,
                        'order_id'      => $order->id,
                        'order_number'  => $order->order_number,
                        'selcom_order'  => $merchantOrderId,
                    ]);
                }

                return redirect()->route('checkout.success', $order->id)
                    ->with('success', $message);

            } catch (\Exception $e) {
                Log::error('Oweru Payment Exception', [
                    'message' => $e->getMessage(),
                    'trace'   => $e->getTraceAsString(),
                ]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Payment service temporarily unavailable. Please use Cash on Delivery.'
                    ], 503);
                }

                return back()->with('error', 'Payment service temporarily unavailable. Please use Cash on Delivery.');
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Invalid payment method selected.'], 422);
        }

        return back()->with('error', 'Invalid payment method selected.');
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
        Log::info('Selcom/Oweru Webhook Received', $request->all());

        $orderNumber = $request->input('order_id');
        $status      = strtoupper($request->input('status') ?? '');
        $transId     = $request->input('transaction_id') ?? $request->input('transid');

        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            Log::warning('Webhook: Order not found', ['order_number' => $orderNumber]);
            return response('Order not found', 200);
        }

        if (in_array($status, ['COMPLETED', 'SUCCESS', 'PAID'])) {
            $order->update([
                'payment_status' => 'paid',
                'transaction_id' => $transId ?: $order->transaction_id,
                'paid_at'        => now(),
                'status'         => 'confirmed',
            ]);
            Log::info('Order marked as PAID via webhook', ['order' => $order->order_number]);
        } elseif (in_array($status, ['FAILED', 'CANCELLED', 'REJECTED'])) {
            $order->update(['payment_status' => 'failed']);
            Log::info('Order payment failed via webhook', ['order' => $order->order_number]);
        }

        return response('OK', 200);
    }
}