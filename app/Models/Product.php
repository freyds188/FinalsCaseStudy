<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'barcode',
        'name',
        'description',
        'price',
        'quantity',
        'category'
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
} 