<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'role', // admin | employee | customer
        'avatar'
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
    ];

    /**
     * 👶 Simple role check: is admin?
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * 👷 Is employee?
     */
    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    /**
     * 🧺 User has MANY carts
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * 🧺 Get ACTIVE cart only
     */
    public function activeCart()
    {
        return $this->hasOne(Cart::class)->where('status', 'active');
    }

    /**
     * 💰 User has MANY transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
