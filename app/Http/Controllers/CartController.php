<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * 🛒 Show user cart
     */
    public function index()
    {
        $cart = Auth::user()
            ->activeCart()
            ->with('items.product')
            ->first();

        return view('cart.index', compact('cart'));
    }

    /**
     * ➕ Add product to cart
     */
    public function add(Product $product)
    {
        $user = Auth::user();

        // 🚫 Out of stock protection
        if ($product->stock <= 0) {
            return back()->with('danger', 'Out of stock.');
        }

        // 🛒 Get or create active cart
        $cart = $user->activeCart()->first()
            ?? Cart::create(['user_id' => $user->id]);

        // 🔁 Check existing item
        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            // 🚫 Prevent exceeding stock
            if ($item->quantity < $product->stock) {
                $item->increment('quantity');
            }
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'quantity'   => 1,
            ]);
        }

        return back()->with('success', 'Added to cart.');
    }

    /**
     * 🔢 Update cart item quantity (+ / -)
     */
    public function update(Request $request, CartItem $item)
    {
        // 🔒 Security: only cart owner can update
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $action = $request->input('action');

        if ($action === 'increase') {

            // 🚫 Do not exceed product stock
            if ($item->quantity < $item->product->stock) {
                $item->increment('quantity');
            }

        } elseif ($action === 'decrease') {

            // 🚫 Do not go below 1
            if ($item->quantity > 1) {
                $item->decrement('quantity');
            }
        }

        return back();
    }

    /**
     * 🗑 Remove item from cart
     */
    public function remove(CartItem $item)
    {
        // 🔒 Security check
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $item->delete();

        return back()->with('success', 'Item removed.');
    }

    /**
     * ✅ Checkout
     */
    public function checkout()
    {
        $user = Auth::user();

        $cart = $user->activeCart()
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('danger', 'Cart is empty.');
        }

        DB::transaction(function () use ($cart, $user) {

            $total = 0;

            foreach ($cart->items as $item) {
                $total += $item->quantity * $item->product->price;
            }

            // 🧾 Create transaction
            $transaction = Transaction::create([
                'user_id'        => $user->id,
                'total_amount'  => $total,
                'status'        => 'completed',
                'payment_method'=> 'cash',
            ]);

            // 📦 Save items + reduce stock
            foreach ($cart->items as $item) {

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $item->product_id,
                    'quantity'       => $item->quantity,
                    'price'          => $item->product->price,
                ]);

                // 🔻 Reduce stock
                $item->product->decrement('stock', $item->quantity);
            }

            // 🧹 Close cart
            $cart->update(['status' => 'checked_out']);
        });

        return redirect()
            ->route('store.index')
            ->with('success', 'Checkout successful!');
    }
}
