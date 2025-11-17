<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public $table = 'orders';
    public $fillable = [
        'user_id', 'order_number', 'status', 'total_amount', 'payment_method'
    ];
}
