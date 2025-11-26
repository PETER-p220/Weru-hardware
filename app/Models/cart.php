<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id', 'items'];

    protected $casts = [
        'items' => 'array',
    ];

    // Always get current cart (user or session)
    public static function current()
    {
        $sessionId = session()->getId();

        if (Auth::check()) {
            return static::firstOrCreate(
                ['user_id' => Auth::id()],
                ['items' => []]
            );
        }

        return static::firstOrCreate(
            ['session_id' => $sessionId],
            ['items' => []]
        );
    }

    // Add item to cart
    public function addItem($product, $quantity = 1)
    {
        $items = $this->items ?? [];
        $id = $product->id;

        if (isset($items[$id])) {
            $items[$id]['quantity'] += $quantity;
        } else {
            $items[$id] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => $product->price,
                'image'      => $product->image,
                'stock'      => $product->stock,
                'quantity'   => $quantity,
                'category'   => $product->categories?->name,
                'unit'       => $product->unit ?? 'pcs',
                'min_order'  => $product->min_order ?? 1,
            ];
        }

        $this->items = $items;
        $this->save();
    }

    // Update quantity
    public function updateItem($productId, $quantity)
    {
        $items = $this->items ?? [];

        if ($quantity <= 0) {
            unset($items[$productId]);
        } else {
            if (isset($items[$productId])) {
                $items[$productId]['quantity'] = $quantity;
            }
        }

        $this->items = $items;
        $this->save();
    }

    // Remove item
    public function removeItem($productId)
    {
        $items = $this->items ?? [];
        unset($items[$productId]);
        $this->items = $items;
        $this->save();
    }

    // Get total items count
    public function totalItems()
    {
        return collect($this->items)->sum('quantity');
    }

    // Get subtotal
    public function subtotal()
    {
        return collect($this->items)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    // Clear cart
    public function clear()
    {
        $this->items = [];
        $this->save();
    }

    // Merge guest cart into user cart on login
    public static function mergeGuestCart()
    {
        if (!Auth::check()) return;

        $sessionId = session()->getId();
        $guestCart = static::where('session_id', $sessionId)
                          ->whereNull('user_id')
                          ->first();

        if ($guestCart && count($guestCart->items) > 0) {
            $userCart = static::firstOrCreate(['user_id' => Auth::id()], ['items' => []]);

            foreach ($guestCart->items as $id => $item) {
                $product = \App\Models\Product::find($id);
                if ($product) {
                    $userCart->addItem($product, $item['quantity']);
                }
            }

            $guestCart->delete(); // clean up
        }
    }
}