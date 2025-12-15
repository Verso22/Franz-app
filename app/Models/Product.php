<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'description',
        'stock',
        'price',
        'category',
        'brand',
        'expiry_date',
        'image', // 🖼️ product image path (nullable)
    ];
}
