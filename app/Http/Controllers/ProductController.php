<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * 📋 Show list of products (REAL DATA)
     */
    public function index()
    {
        // Get all products (latest first)
        $products = Product::orderBy('id', 'desc')->get();

        // Dashboard statistics (REAL, not gimmick)
        $totalProducts = $products->count();

        $totalCategories = $products
            ->pluck('category')     // get only category column
            ->filter()              // remove null values
            ->unique()              // unique categories
            ->count();              // count them

        $lowStockCount = $products
            ->where('stock', '<=', 5)
            ->count();

        return view('products.index', compact(
            'products',
            'totalProducts',
            'totalCategories',
            'lowStockCount'
        ));
    }

    /**
     * ➕ Show the create form
     */
    public function create()
    {
        return view('products.form', ['product' => null]);
    }

    /**
     * 💾 Store a new product
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255|unique:products,name',
            'description'  => 'nullable|string',
            'stock'        => 'required|integer',
            'price'        => 'required|numeric',
            'category'     => 'nullable|string|max:100',
            'brand'        => 'nullable|string|max:100',
            'expiry_date'  => 'nullable|date',
        ]);

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully.');
    }

    /**
     * ✏️ Show edit form
     */
    public function edit(Product $product)
    {
        return view('products.form', compact('product'));
    }

    /**
     * 🔄 Update product
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255|unique:products,name,' . $product->id,
            'description'  => 'nullable|string',
            'stock'        => 'required|integer',
            'price'        => 'required|numeric',
            'category'     => 'nullable|string|max:100',
            'brand'        => 'nullable|string|max:100',
            'expiry_date'  => 'nullable|date',
        ]);

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * 🗑️ Soft delete product
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * 🗂️ Show trash
     */
    public function trash()
    {
        $products = Product::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('products.trash', compact('products'));
    }

    /**
     * 🔙 Restore product
     */
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()
            ->route('products.trash')
            ->with('success', 'Product restored successfully.');
    }

    /**
     * 🚮 Permanently delete product
     */
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()
            ->route('products.trash')
            ->with('danger', 'Product permanently deleted.');
    }
}
