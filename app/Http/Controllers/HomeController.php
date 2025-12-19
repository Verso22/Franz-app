<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    /**
     * 🏠 Public Homepage
     */
    public function index()
    {
        $products = Product::latest()
            ->whereNull('deleted_at') // ✅ respect soft delete
            ->take(12)
            ->get();

        return view('home', compact('products'));
    }
}
