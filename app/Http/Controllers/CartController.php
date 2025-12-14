<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * 🛒 Add product to cart
     */
    public function add(Product $product)
    {
        $user = Auth::user();

        // 🚫 Safety: only customers can add to cart
        if ($user->role !== 'customer') {
            return back()->with('danger', 'Only customers can add to cart.');
        }

        // 🚫 Safety: out of stock
        if ($product->stock <= 0) {
            return back()->with('danger', 'Product is out of stock.');
        }

        // 🧺 Get active cart or create one
        $cart = $user->activeCart()->first();

        if (! $cart) {
            $cart = Cart::create([
                'user_id' => $user->id,
                'status'  => 'active',
            ]);
        }

        // 📦 Check if product already in cart
        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            // ➕ Increase quantity
            $item->increment('quantity');
        } else {
            // ➕ Add new product to cart
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'quantity'   => 1,
            ]);
        }

        return back()->with('success', 'Product added to cart.');
    }
}
