<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    /**
     * 🧠 Fields that can be mass-assigned
     */
    protected $fillable = [
        'user_id',
        'status',
    ];

    /**
     * 👤 Cart belongs to ONE user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 📦 Cart has MANY cart items
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
