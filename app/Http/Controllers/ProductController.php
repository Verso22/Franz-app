<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show list of products
     */
    public function index()
    {
        // Get all products (newest first)
        $products = Product::orderBy('id', 'desc')->get();

        // Return the view resources/views/products/index.blade.php
        // and pass the $products collection to it
        return view('products.index', compact('products'));
    }

    /**
     * Show the create form (same view used for edit)
     */
    public function create()
    {
        // We'll reuse resources/views/products/form.blade.php
        // pass null so the view knows it's a "create" action
        return view('products.form')->with('product', null);
    }

    /**
     * Store the new product in the database
     */
    public function store(Request $request)
    {
        // Validate incoming data - if validation fails, user returns to the form
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'expiry_date' => 'nullable|date',
        ]);

        // Create the product (mass assignment uses $fillable in the Model)
        Product::create($data);

        // Redirect back to list with a success message
        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    /**
     * Show the edit form for a specific product
     */
    public function edit(Product $product)
    {
        // Pass the Product model to the same form view (it will be filled)
        return view('products.form', compact('product'));
    }

    /**
     * Update a product in the database
     */
    public function update(Request $request, Product $product)
    {
        // Same validation rules as store()
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'expiry_date' => 'nullable|date',
            ]);

        // Update the product
        $product->update($data);

        // Back to list with message
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
        {
            $product = Product::findFail($id);
            $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
        }
        // Show trashed (soft deleted) products
    public function trash()
        {
            $products = Product::onlyTrashed()->get();
        return view('products.trash', compact('products'));
        }

        // Restore a trashed product
    public function restore($id)
        {
            $product = Product::onlyTrashed()->where('id', $id)->firstOrFail();
            $product->restore();

        return redirect()->route('products.trash')->with('success', 'Product restored successfully.');
        }

}
