<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock <= 0) {
            return back()->with('error', 'Sorry, this product is out of stock!');
        }

        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => $product->min_order ?? 10,
                'image'    => $product->image,
                'stock'    => $product->stock,
                'unit'     => $product->unit ?? 'unit',
                'min_order'=> $product->min_order,
                'category' => $product->categories?->name ?? 'Uncategorized'
            ];
        }

        // Enforce minimum order
        if ($product->min_order && $cart[$id]['quantity'] < $product->min_order) {
            $cart[$id]['quantity'] = $product->min_order;
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Added to cart successfully!');
    }

    public function update(Request $request, $id)
    {
        $cart = session('cart', []);
        if (!isset($cart[$id])) return back();

        $action = $request->input('action');

        if ($action === 'increase') {
            $cart[$id]['quantity']++;
        } elseif ($action === 'decrease' && $cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
        }

        $product = Product::find($id);
        if ($product?->min_order && $cart[$id]['quantity'] < $product->min_order) {
            $cart[$id]['quantity'] = $product->min_order;
        }

        if ($cart[$id]['quantity'] <= 0) unset($cart[$id]);

        session(['cart' => $cart]);
        return back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return back()->with('success', 'Item removed.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared!');
    }

    public function index()
    {
        $cart = session('cart', []);
        return view('cart', compact('cart'));
    }
}