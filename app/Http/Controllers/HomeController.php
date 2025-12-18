<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * 🏠 Public Homepage
     *
     * Rules:
     * - First page when server starts
     * - Accessible WITHOUT login
     * - Customers redirect back here after login
     * - Admin & Employees should NOT be forced here after login
     */
    public function index()
    {
        // Example: show latest / featured products
        // You can expand this later (recommendations, banners, etc.)
        $products = Product::latest()
            ->take(12)
            ->get();

        return view('home', compact('products'));
    }
}
