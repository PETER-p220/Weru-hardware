<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Checkout as CheckoutRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::getCurrentCart()->load('cartItems.product');

        $subtotal    = $cart->getTotal();
        $deliveryFee = 10000;
        $vat         = round($subtotal * 0.18);
        $total       = $subtotal + $deliveryFee + $vat;

        return view('checkout', compact('cart', 'subtotal', 'deliveryFee', 'vat', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required',
            'address' => 'required|string',
            'region'  => 'required|string',
            'city'    => 'required|string',
            'notes'   => 'nullable|string',
            'cart_id' => 'required|exists:carts,id',
        ]);

        $cart = Cart::with('cartItems.product')->findOrFail($request->cart_id);

        if ($cart->user_id !== auth()->id()) {
            return back()->with('error', 'Invalid cart');
        }

        $subtotal    = $cart->getTotal();
        $deliveryFee = 10000;
        $vat         = round($subtotal * 0.18);
        $totalAmount = $subtotal + $deliveryFee + $vat;

        // Format phone
        $phone = preg_replace('/\D/', '', $request->phone);
        if (strlen($phone) == 10 && str_starts_with($phone, '0')) {
            $phone = '255' . substr($phone, 1);
        }

        DB::beginTransaction();

        try {

            // Generate unique order number
            $orderNumber = 'WH-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            // Save checkout tracking record
            CheckoutRecord::create([
                'user_id'      => auth()->id(),
                'cart_id'      => $cart->id,
                'order_number' => $orderNumber,
                'status'       => 'pending',
                'total_amount' => $totalAmount,
            ]);

            // Create the actual order
            $order = Order::create([
                'user_id'          => auth()->id(),
                'order_number'     => $orderNumber,
                'status'           => 'pending',
                'total_amount'     => $totalAmount,
                'payment_method'   => 'selcom',
                'payment_status'   => 'unpaid',
                'shipping_address' => $request->address . ', ' . $request->city . ', ' . $request->region,
                'customer_name'    => $request->name,
                'customer_email'   => $request->email,
                'customer_phone'   => $phone,
                'notes'            => $request->notes,
            ]);

            // Add items to order
            foreach ($cart->cartItems as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity'     => $item->quantity,
                    'price'        => $item->price,
                    'subtotal'     => $item->price * $item->quantity,
                ]);
            }

            // Clear the cart
            $cart->cartItems()->delete();

            DB::commit();

            // ================================================================
            //      FIXED + CLEANED + CORRECTED SELCOM MINIMAL CHECKOUT CODE
            // ================================================================

            $params = [
                'vendor'        => env('SELCOM_VENDOR_ID'),
                'order_id'      => $order->id,
                'buyer_email'   => $request->email,
                'buyer_name'    => $request->name,
                'buyer_phone'   => $phone,
                'amount'        => $totalAmount,
                'currency'      => 'TZS',
                'reference'     => $orderNumber,
                'timestamp'     => now()->format('YmdHis'),
                'redirect_url'  => route('success', $order->id),
                'cancel_url'    => route('cancel'),
                'buyer_remarks' => "Order #{$orderNumber}",
            ];

            // Correct Selcom Minimal Checkout Signature (10 fields only)
            $signString =
                $params['vendor'] .
                $params['order_id'] .
                $params['buyer_email'] .
                $params['buyer_name'] .
                $params['buyer_phone'] .
                $params['amount'] .
                $params['currency'] .
                $params['reference'] .
                $params['timestamp'] .
                env('SELCOM_API_SECRET');

            $params['sig'] = hash('sha256', $signString);

            Log::info('Selcom Request Payload', $params);

            $response = Http::asForm()
                ->timeout(30)
                ->post('https://apigw.selcommobile.com/v1/checkout/create-order-minimal', $params);

            Log::info('Selcom Response', [
                'body'   => $response->body(),
                'status' => $response->status()
            ]);

            if ($response->failed()) {
                return back()->with('error', 'Selcom connection failed. Please try again.');
            }

            $result = $response->json();

            if (!isset($result['redirect_url'])) {
                return back()->with('error', 'Selcom error: ' . ($result['message'] ?? 'Unknown error from Selcom'));
            }

            return redirect($result['redirect_url']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Exception: ' . $e->getMessage());
            return back()->with('error', 'Payment failed. Please try again.');
        }
    }

    public function success($orderId)
    {
        $order = Order::with('orderItems.product')->findOrFail($orderId);
        if ($order->user_id !== auth()->id()) abort(403);
        return view('success', compact('order'));
    }

    public function cancel()
    {
        return view('cancel');
    }

    public function webhook(Request $request)
    {
        Log::info('Selcom Webhook Received', $request->all());

        $payload = $request->all();

        if (in_array($payload['result'] ?? '', ['SUCCESS', 'COMPLETED', 'SUCCESSFUL'])) {
            $order = Order::find($payload['order_id'] ?? null);
            if ($order && $order->payment_status === 'unpaid') {
                $order->update([
                    'payment_status' => 'paid',
                    'status'         => 'confirmed',
                    'paid_at'        => now(),
                ]);

                foreach ($order->orderItems as $item) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }
        }

        return response('OK', 200);
    }
}
