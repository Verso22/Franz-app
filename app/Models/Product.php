<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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
    ];
}
