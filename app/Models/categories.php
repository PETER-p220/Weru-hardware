<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public $table='categories';
    protected $fillable = ['name', 'slug', 'icon', 'order'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}