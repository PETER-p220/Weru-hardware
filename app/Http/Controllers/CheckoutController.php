<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
   
    public function index()
    {
        $cartItems = session('cart', []);

        // If you're using the hybrid DB cart (recommended), use this instead:
        // $cartItems = auth()->check() ? Cart::getCurrentCart()->items : session('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = collect($cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $deliveryFee = 15000;
        $vat = $subtotal * 0.18;
        $total = $subtotal + $deliveryFee + $vat;

        return view('checkout', compact('cartItems', 'subtotal', 'deliveryFee', 'vat', 'total'));
    }
}