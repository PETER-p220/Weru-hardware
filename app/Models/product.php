<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table='products';
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 
        'price', 'old_price', 'unit', 'stock', 'image', 
        'is_featured', 'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the product
     */
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    /**
     * Alias for category (backward compatibility)
     */
    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    // Accessor for formatted price
    public function getFormattedPriceAttribute()
    {
        return 'TZS ' . number_format($this->price, 0);
    }

    // Check if product has discount
    public function hasDiscount()
    {
        return $this->old_price && $this->old_price > $this->price;
    }

    // Calculate discount percentage
    public function getDiscountPercentageAttribute()
    {
        if (!$this->hasDiscount()) return 0;
        return round((($this->old_price - $this->price) / $this->old_price) * 100);
    }
    /**
     * Get all order items for this product
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get all orders that contain this product
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
                    ->withPivot('quantity', 'price', 'subtotal')
                    ->withTimestamps();
    }

    /**
     * Scope to get only active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }
}