<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $userId = auth()->id();
        
        // Start query with relationships
        $query = Order::with(['orderItems.product', 'orderItems'])
            ->where('user_id', $userId);

        // Filter by status if provided
        $status = $request->query('status', 'all');
        
        if ($status !== 'all') {
            // Handle shipped status - it might include 'in_transit' as well
            if ($status === 'shipped') {
                $query->whereIn('status', ['shipped', 'in_transit']);
            } else {
                $query->where('status', $status);
            }
        }

        // Get paginated orders
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Append the status filter to pagination links
        $orders->appends(['status' => $status]);

        // Calculate counts for filter badges
        $totalOrders = Order::where('user_id', $userId)->count();
        $pendingOrders = Order::where('user_id', $userId)->where('status', 'pending')->count();
        $processingOrders = Order::where('user_id', $userId)->where('status', 'processing')->count();
        $shippedOrders = Order::where('user_id', $userId)->whereIn('status', ['shipped', 'in_transit'])->count();
        $deliveredOrders = Order::where('user_id', $userId)->where('status', 'delivered')->count();

        return view('order', compact('orders', 'totalOrders', 'pendingOrders', 'processingOrders', 'shippedOrders', 'deliveredOrders'));
    }
    // public function manage(Request $request)
    // {
    //     $query = Order::with(['user', 'orderItems']);

    //     // Search
    //     if ($search = $request->search) {
    //         $query->where(function($q) use ($search) {
    //             $q->where('order_number', 'like', "%{$search}%")
    //               ->orWhereHas('user', function($q) use ($search) {
    //                   $q->where('name', 'like', "%{$search}%")
    //                     ->orWhere('email', 'like', "%{$search}%");
    //               });
    //         });
    //     }

    //     // Filter by status
    //     if ($status = $request->status) {
    //         $query->where('status', $status);
    //     }

    //     $orders = Order::with('user')->latest()->get();
    //     $products = \App\Models\Product::all(); // Adjust model name as needed
    //     $users = \App\Models\User::all();
    //     $price=Order::with('total_amount')->sum('total_amount');
    //     return view('OrderManagement', compact('orders', 'products', 'users','price'));
    // }
public function show()
{
    // Paginate orders with relationships
    $orders = Order::with(['user', 'orderItems.product'])
        ->orderBy('created_at', 'desc')
        ->paginate(5);

    // Stats - Revenue: Sum of total_amount for paid orders only (actual revenue received)
    $revenue = Order::where('payment_status', 'paid')->sum('total_amount') ?? 0;
    
    $totalOrders   = Order::count();
    $productsCount = Product::count();
    $users         = User::count();

    return view('OrderManagement', compact(
        'orders',
        'revenue',
        'totalOrders',
        'productsCount',
        'users'
    ));
}


    public function updateStatus(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
    ]);

    // Update order status
    $updateData = ['status' => $request->status];
    
    // If order is marked as delivered, automatically mark as paid (for COD orders)
    if ($request->status === 'delivered' && $order->payment_status !== 'paid') {
        $updateData['payment_status'] = 'paid';
        $updateData['paid_at'] = now();
    }
    
    $order->update($updateData);

    $message = "Order #{$order->order_number} updated to " . ucfirst($request->status) . "!";
    if ($request->status === 'delivered' && isset($updateData['payment_status'])) {
        $message .= " Payment status updated to paid.";
    }

    return back()->with('success', $message);
}
    public function markAsPaid(Order $order)
    {
        if ($order->payment_status === 'paid') {
            return back()->with('info', "Order #{$order->order_number} is already marked as paid.");
        }

        $order->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        return back()->with('success', "Order #{$order->order_number} marked as paid successfully!");
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', "Order #{$order->id} has been deleted permanently.");
    }
}
