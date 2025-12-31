<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $table = 'checkouts';
    
    protected $fillable = [
        'user_id',
        'cart_id',
        'order_number',
        'status',
        'total_amount',
        'payment_method',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function order()
    {
        return $this->hasOne(Order::class, 'checkout_id');
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