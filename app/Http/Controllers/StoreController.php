<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * 🏪 Storefront (product list + search + filters)
     */
    public function index(Request $request)
    {
        // 👶 Get filters from URL
        $search   = $request->query('q');
        $category = $request->query('category');
        $brand    = $request->query('brand');

        // 👶 Base query: newest products first
        $query = Product::orderBy('id', 'desc');

        // 🔍 Search by product name
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // 🏷️ Filter by category
        if ($category) {
            $query->where('category', $category);
        }

        // 🏭 Filter by brand
        if ($brand) {
            $query->where('brand', $brand);
        }

        // 👶 Execute query
        $products = $query->get();

        // 👶 Send to storefront
        return view('store.index', compact('products'));
    }

    /**
     * 📄 Product detail page (READ ONLY)
     */
    public function show(Product $product)
    {
        // 👶 Laravel auto-finds product by ID
        return view('store.show', compact('product'));
    }
}
