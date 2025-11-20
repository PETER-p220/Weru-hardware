<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id', 'items'];

    protected $casts = [
        'items' => 'array'
    ];

    // Helper: Get cart items as array
    public function getItemsAttribute($value)
    {
        return $value ?? [];
    }

    public function setItemsAttribute($value)
    {
        $this->attributes['items'] = json_encode($value);
    }

    // Scope for current user or session
    public static function getCurrentCart()
    {
        $sessionId = session()->getId();
        $userId = auth()->id();

        return static::firstOrCreate(
            ['user_id' => $userId, 'session_id' => $userId ? null : $sessionId],
            ['items' => []]
        );
    }
    public function getTotal(): float
    {
        return $this->cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
    public function cartItems()
{
    return $this->hasMany(CartItem::class);
}
public function getItemsCount(): int
{
    return $this->cartItems->sum('quantity');
}
}