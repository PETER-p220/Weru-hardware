<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    //
    public $table = 'advertisements';
    
    protected $fillable = [
        'title', 'description', 'media_type', 'media_path', 'link', 'is_active', 'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
