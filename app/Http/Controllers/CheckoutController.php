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
        // $request->validate([
        //     'name'           => 'required|string|max:255',
        //     'email'          => 'required|email',
        //     'phone'          => 'required|regex:/^0[67][0-9]{8}$/',
        //     'address'        => 'required|string',
        //     'region'         => 'required|string',
        //     'city'           => 'required|string',
        //     'notes'          => 'nullable|string',
        //     'payment_method' => 'required|in:cash_on_delivery,selcom',
        // ]);

        $cart = Cart::current();
        if ($cart->totalItems() === 0) {
            return back()->with('error', 'Your cart is empty.');
        }

        $subtotal = $cart->subtotal();
        $delivery = 25000;
        $vat      = round($subtotal * 0.18);
        $total    = $subtotal + $delivery + $vat;
        $phone    = '255' . substr(preg_replace('/\D/', '', $request->phone), -9);

        // ===== Selcom credentials & endpoint =====
        $vendorId  = env('SELCOM_VENDOR_ID');
        $apiKey    = env('SELCOM_API_KEY');
        $apiSecret = env('SELCOM_API_SECRET');
        $baseUrl   = rtrim(env('SELCOM_BASE_URL', 'https://apigw.selcommobile.com/v1'), '/');

        if (!$vendorId || !$apiKey || !$apiSecret) {
            Log::error('Selcom Payment Failed - Missing credentials', compact('vendorId', 'apiKey', 'apiSecret'));
            $errorMessage = 'Payment unavailable: Selcom credentials are not set. Please contact support.';
            return $request->wantsJson() || $request->ajax()
                ? response()->json(['success' => false, 'error' => $errorMessage], 400)
                : back()->with('error', $errorMessage)->withInput();
        }

        $order = Order::create([
            'user_id'          => Auth::id() ?? null,
            'order_number'     => 'OH-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
            'total_amount'     => $total,
            'status'           => 'new',
            'payment_status'   => $request->payment_method === 'selcom' ? 'pending' : 'pending',
            'payment_method'   => $request->payment_method,
            'customer_name'    => $request->name,
            'customer_email'   => $request->email,
            'customer_phone'   => $phone,
            'shipping_address' => $request->address . ', ' . $request->city . ', ' . $request->region,
            'notes'            => $request->notes,
            'items'            => $cart->items,
            'subtotal'         => $subtotal,
            'delivery_fee'     => $delivery,
            'vat_amount'       => $vat,
            'latitude'         => $request->latitude ?: null,
            'longitude'        => $request->longitude ?: null,
            'location_accuracy' => $request->location_accuracy ?: null,
        ]);

        // Create OrderItems for proper Eloquent relationships
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

        // SELCOM MOBILE MONEY — WITH POPUP SUPPORT
        if ($request->payment_method === 'selcom') {
            $payload = [
                "vendor"       => $vendorId,
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

            // Signature per Selcom docs (concatenate fields + secret)
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
                         . $apiSecret;
            $payload['signature'] = hash('sha256', $sign_string); 
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'apiKey' => $apiKey,
                    // Some Selcom environments require Authorization header as well
                    'Authorization' => 'Bearer ' . $apiKey,
                ])
                ->asJson()
                ->post($baseUrl . '/checkout/create-order-minimal', $payload);

            if ($response->successful() && $response->json('result') === 'SUCCESS') {
                $paymentUrl = $response->json('data.payment_url');
                
                // If request wants JSON (for popup), return JSON
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'payment_url' => $paymentUrl,
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                    ]);
                }
                
                // Otherwise redirect normally
                return redirect()->away($paymentUrl);
            }

            Log::error('Selcom Payment Failed', [
                'order' => $order->order_number,
                'response' => $response->json()
            ]);

            $errorMessage = 'Mobile payment failed. We\'ve saved your order — we will call you for Cash on Delivery.';
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => $errorMessage
                ], 400);
            }

            return back()->with('error', $errorMessage)->withInput();
        }
    }

    public function success(Order $order)
    {
        // Load relationships for the view
        $order->load(['orderItems.product', 'user']);
        
        // Hapa tunaweza update status to 'paid' kama tunatumia webhook
        return view('success', compact('order'));
    }

    /**
     * Check payment status (for AJAX polling)
     */
    public function checkStatus($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        return response()->json([
            'payment_status' => $order->payment_status,
            'order_status' => $order->status,
            'is_paid' => $order->payment_status === 'paid',
        ]);
    }

    public function cancel()
    {
        return redirect()->route('cart')->with('error', 'Payment cancelled. You can try again.');
    }

    public function webhook(Request $request)
    {
        Log::info('Selcom Webhook Received', $request->all());
        
        // Verify webhook signature if needed
        $orderNumber = $request->input('order_id');
        $status = $request->input('status');
        $transactionId = $request->input('transaction_id');
        
        // Find order by order number
        $order = Order::where('order_number', $orderNumber)->first();
        
        if ($order) {
            // Update order based on payment status
            if ($status === 'COMPLETED' || $status === 'SUCCESS') {
                $order->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $transactionId,
                    'paid_at' => now(),
                    'status' => 'confirmed',
                ]);
                
                Log::info('Order payment confirmed via webhook', [
                    'order_number' => $orderNumber,
                    'transaction_id' => $transactionId,
                ]);
            } elseif ($status === 'FAILED' || $status === 'CANCELLED') {
                $order->update([
                    'payment_status' => 'failed',
                    'transaction_id' => $transactionId,
                ]);
                
                Log::info('Order payment failed via webhook', [
                    'order_number' => $orderNumber,
                    'status' => $status,
                ]);
            }
        } else {
            Log::warning('Order not found for webhook', [
                'order_number' => $orderNumber,
            ]);
        }
        
        return response('OK', 200);
    }
}