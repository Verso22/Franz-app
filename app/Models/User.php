<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * 🧠 Mass assignable fields
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
    public function isAdmin()
    {
        return $this->role === 'admin';
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
}
