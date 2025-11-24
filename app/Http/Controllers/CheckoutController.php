<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::getCurrentCart()->load('cartItems.product');
        return view('checkout', compact('cart'));
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
        ]);

        $cart = Cart::getCurrentCart()->load('cartItems.product');

        if ($cart->getItemsCount() == 0) {
            return back()->with('error', 'Your cart is empty');
        }

        $subtotal = $cart->getTotal();
        $delivery = 25000;
        $vat      = $subtotal * 0.18;
        $total    = $subtotal + $delivery + $vat;

        $phone = preg_replace('/\D/', '', $request->phone);
        if (str_starts_with($phone, '0')) {
            $phone = '255' . substr($phone, 1);
        }

        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_number'     => 'WH-' . date('YmdHis') . rand(100, 999),
            'total_amount'     => $total,
            'status'           => 'pending',
            'payment_status'   => 'unpaid',
            'payment_method'   => 'selcom',
            'customer_name'    => $request->name,
            'customer_email'   => $request->email,
            'customer_phone'   => $phone,
            'shipping_address' => $request->address . ', ' . $request->city . ', ' . $request->region,
            'notes'            => $request->notes,
        ]);

        foreach ($cart->cartItems as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item->product_id,
                'product_name' => $item->product->name ?? $item->product_name,
                'quantity'     => $item->quantity,
                'price'        => $item->price,
                'subtotal'     => $item->price * $item->quantity,
            ]);
        }

        $cart->cartItems()->delete();

        $payment = Selcom::checkout([
            'amount'         => $total,
            'order_id'       => $order->order_number,
            'msisdn'         => $phone,
            'buyer_name'     => $request->name,
            'buyer_email'    => $request->email,
            'redirect_url'   => route('payment.success', $order->id),
            'cancel_url'     => route('payment.cancel'),
            'payment_method' => 'mobile',   // forces web flow + USSD even in sandbox
        ]);

        \Log::info('SELCOM REDIRECT URL: ' . $payment->redirect_url);

        return redirect($payment->redirect_url);
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
    public function testPage()
{
    $transactions = \DB::table('selcom_orders')
        ->orderByDesc('created_at')
        ->limit(10)
        ->get();

    return view('selcom-test', compact('transactions'));
}
public function testPayment(Request $request)
{
    $request->validate([
        'phone' => 'required',
        'amount' => 'required|numeric|min:100'
    ]);

    if (config('selcom.environment') === 'live') {
        if ($request->amount > 5000) {
            return back()->with('error', 
                'Production testing limited to max 5,000 TZS');
        }
        
        \Log::warning('⚠️ PRODUCTION PAYMENT TEST', [
            'amount' => $request->amount,
            'phone' => $request->phone,
            'user' => auth()->id()
        ]);
    }

    $phone = preg_replace('/\D/', '', $request->phone);
    if (str_starts_with($phone, '0')) {
        $phone = '255' . substr($phone, 1);
    }

    $orderId = 'TEST-' . now()->format('YmdHis');

    try {
        \Log::info('SELCOM TEST - ABOUT TO CALL API', [
            'phone' => $phone,
            'amount' => $request->amount,
            'order_id' => $orderId,
            'environment' => config('selcom.environment')
        ]);

        $payment = Selcom::checkout([
            'amount'         => $request->amount,
            'order_id'       => $orderId,
            'phone'          => $phone,
            'name'           => auth()->user()->name,
            'email'          => auth()->user()->email,
            'transaction_id' => $orderId,
            'redirect_url'   => route('selcom.test'),
            'cancel_url'     => route('selcom.test'),
            // ✅ ADD WEBHOOK URL using your ngrok URL
            'webhook_url'    => 'https://anthropogenic-wonda-groundably.ngrok-free.dev/selcom/webhook',
        ]);

        \Log::info('SELCOM SUCCESS! Redirect URL: ' . $payment->redirect_url);

        return redirect($payment->redirect_url);
        
    } catch (\Illuminate\Http\Client\ConnectionException $e) {
        \Log::error('SELCOM CONNECTION ERROR: ' . $e->getMessage());
        return back()->with('error', 'Unable to connect to payment gateway. Please try again later.');
    } catch (\Exception $e) {
        \Log::error('SELCOM ERROR: ' . $e->getMessage());
        return back()->with('error', 'Payment initialization failed: ' . $e->getMessage());
    }
}
public function handleWebhook(Request $request)
{
    \Log::info('SELCOM WEBHOOK RECEIVED', [
        'payload' => $request->all(),
        'headers' => $request->headers->all()
    ]);

    // Selcom will send payment status updates here
    // Process according to Selcom's webhook documentation
    
    return response()->json(['status' => 'received']);
}
}