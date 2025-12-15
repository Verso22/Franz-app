<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * 📋 Show list of products (SEARCH + FILTER)
     */
    public function index(Request $request)
    {
        // 🔍 Get filters from URL
        $search   = $request->query('q');
        $category = $request->query('category');
        $brand    = $request->query('brand');

        // 👶 Base query
        $query = Product::orderBy('id', 'desc');

        // 🔍 Search by name
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

        // 📊 REAL stats (based on filtered results)
        $totalProducts = $products->count();

        $totalCategories = $products
            ->pluck('category')
            ->filter()
            ->unique()
            ->count();

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
            'image'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

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
            'image'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

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
        Product::findOrFail($id)->delete();

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
        Product::onlyTrashed()->findOrFail($id)->restore();

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

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->forceDelete();

        return redirect()
            ->route('products.trash')
            ->with('danger', 'Product permanently deleted.');
    }
}
