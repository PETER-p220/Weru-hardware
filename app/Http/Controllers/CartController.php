<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::current();
        // Load product relationships if needed
        $cart->load('user');
        return view('cart', compact('cart'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->stock <= 0) {
            return back()->with('error', 'Sorry, this product is out of stock!');
        }

        $cart = Cart::current();

        // Add item (handles min_order automatically in model)
        $cart->addItem($product, $request->input('quantity', 1));

        return back()->with('success', 'Added to cart successfully!');
    }

    public function update(Request $request, $productId)
    {
        $cart = Cart::current();

        $action = $request->input('action');

        if ($action === 'increase') {
            $product = Product::findOrFail($productId);
            $cart->addItem($product, 1);
        } elseif ($action === 'decrease') {
            $currentQty = $cart->items[$productId]['quantity'] ?? 0;
            if ($currentQty > 1) {
                $cart->updateItem($productId, $currentQty - 1);
            }
        }

        return back()->with('success', 'Cart updated!');
    }

    public function remove($productId)
    {
        $cart = Cart::current();
        $cart->removeItem($productId);

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $cart = Cart::current();
        $cart->clear();

        return back()->with('success', 'Cart cleared!');
    }
}