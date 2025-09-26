<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * 📋 Show list of products
     */
    public function index()
    {
        // Get all products (newest first)
        $products = Product::orderBy('id', 'desc')->get();

        // Return the index view with the products
        return view('products.index', compact('products'));
    }

    /**
     * ➕ Show the create form
     */
    public function create()
    {
        // Reuse the same form view, pass null since it's "create"
        return view('products.form')->with('product', null);
    }

    /**
     * 💾 Store the new product in the database
     */
    public function store(Request $request)
    {
        // Validate user input
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'expiry_date' => 'nullable|date',
        ]);

        // Save to DB
        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    /**
     * ✏️ Show the edit form
     */
    public function edit(Product $product)
    {
        return view('products.form', compact('product'));
    }

    /**
     * 🔄 Update a product
     */
    public function update(Request $request, Product $product)
    {
        // Validation (ignore current product name for unique rule)
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'expiry_date' => 'nullable|date',
        ]);

        // Update in DB
        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * 🗑️ Soft delete a product
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * 🗂️ Show trashed (soft deleted) products
     */
    public function trash()
    {
        // onlyTrashed = fetch soft-deleted only
        $products = Product::onlyTrashed()->orderBy('deleted_at', 'desc')->get();

        return view('products.trash', compact('products'));
    }

    /**
     * 🔙 Restore a trashed product
     */
    public function restore($id)
    {
        $product = Product::onlyTrashed()->where('id', $id)->firstOrFail();
        $product->restore();

        return redirect()->route('products.trash')->with('success', 'Product restored successfully.');
    }

    /**
     * 🚮 Permanently delete a product from trash
     */
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->where('id', $id)->firstOrFail();
        $product->forceDelete();

        return redirect()->route('products.trash')->with('success', 'Product permanently deleted.');
    }
}
