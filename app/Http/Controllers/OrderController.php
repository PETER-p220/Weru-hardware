<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    //
    public function index()

    {

        return view('order');
    }
    public function manage(Request $request)
    {
        $query = Order::with(['user', 'orderItems']);

        // Search
        if ($search = $request->search) {
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($status = $request->status) {
            $query->where('status', $status);
        }

        $orders = Order::with('user')->latest()->get();
        $products = \App\Models\Product::all(); // Adjust model name as needed
        $users = \App\Models\User::all();
        $price=Order::with('total_amount')->sum('total_amount');
        return view('OrderManagement', compact('orders', 'products', 'users','price'));
    }

    public function show()

    {
        $orders = Order::with('user')->latest()->get();
        $products = \App\Models\Product::all(); 
        $users = \App\Models\User::all();
        return view('OrderManagement', compact('orders', 'products', 'users'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated successfully.');
    }
}
