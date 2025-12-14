<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    /**
     * 🧠 Fields that can be mass-assigned
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    /**
     * 🧺 CartItem belongs to ONE cart
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * 📦 CartItem belongs to ONE product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
