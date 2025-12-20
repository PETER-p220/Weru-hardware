<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    
    protected $fillable = [
        'user_id',
        'order_number',
        'transaction_id',
        'product_id',
        'status',
        'total_amount',
        'payment_method',
        'payment_status',
        'shipping_address',
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes',
        'paid_at',
        'latitude',
        'longitude',
        'location_accuracy',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'location_accuracy' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get all products in this order
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity', 'price', 'subtotal', 'product_name')
                    ->withTimestamps();
    }

    /**
     * Get the checkout associated with this order
     */
    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'unpaid');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Accessors
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'unpaid'    => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Unpaid</span>',
            'paid'      => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Paid</span>',
            'failed'    => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Failed</span>',
            'cancelled' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Cancelled</span>',
        ];

        return $badges[$this->payment_status] ?? $badges['unpaid'];
    }

    public function getOrderStatusBadgeAttribute()
    {
        $badges = [
            'pending'    => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>',
            'confirmed'  => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Confirmed</span>',
            'processing' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Processing</span>',
            'shipped'    => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Shipped</span>',
            'delivered'  => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Delivered</span>',
            'cancelled'  => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>',
        ];

        return $badges[$this->status] ?? $badges['pending'];
    }

    /**
     * Get formatted total amount
     */
    public function getFormattedTotalAttribute()
    {
        return 'TZS ' . number_format($this->total_amount, 0);
    }

    /**
     * Check if order is paid
     */
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if order is pending
     */
    public function isPending()
    {
        return $this->payment_status === 'unpaid';
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending']) && $this->payment_status === 'unpaid';
    }
}