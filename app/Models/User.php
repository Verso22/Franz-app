<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * 🧠 Mass assignable fields
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',      // admin | employee | customer
        'phone',
        'address',
        'avatar',
    ];

    /**
     * 🔐 Hidden fields
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 🔄 Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone'   => 'string',
        'address' => 'string',
    ];

    /**
     * 🔑 Role helpers
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    /**
     * 🧺 Carts
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function activeCart()
    {
        return $this->hasOne(Cart::class)->where('status', 'active');
    }

    /**
     * 💰 Transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
