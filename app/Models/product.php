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
}