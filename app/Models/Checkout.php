<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    // ← ADD THIS LINE (this fixes the error forever!)
    protected $fillable = [
        'user_id',
        'cart_id',
        'order_number',
        'status',
        'total_amount',
    ];

    // Your relationships if you have any
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}