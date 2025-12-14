<?php

namespace App\Http\Controllers;

use App\Models\Product;

class StoreController extends Controller
{
    /**
     * 🏪 Customer storefront
     * Show products for customers (read-only)
     */
    public function index()
    {
        // 👶 Get all products, newest first
        // We still fetch all, but UI will handle out-of-stock
        $products = Product::orderBy('id', 'desc')->get();

        // 👶 Send products to the store view
        return view('store.index', compact('products'));
    }
}
