<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->activeCart()->with('items.product')->first();
        return view('cart.index', compact('cart'));
    }

    public function add(Product $product)
    {
        $user = Auth::user();

        if ($product->stock <= 0) {
            return back()->with('danger', 'Out of stock.');
        }

        $cart = $user->activeCart()->first()
            ?? Cart::create(['user_id' => $user->id]);

        $item = $cart->items()->where('product_id', $product->id)->first();

        $item
            ? $item->increment('quantity')
            : CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);

        return back()->with('success', 'Added to cart.');
    }

    public function remove(CartItem $item)
    {
        $item->delete();
        return back()->with('success', 'Item removed.');
    }

    /**
     * ✅ CHECKOUT
     */
    public function checkout()
    {
        $user = Auth::user();
        $cart = $user->activeCart()->with('items.product')->first();

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
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'completed',
                'payment_method' => 'cash',
            ]);

            // 📦 Save items + reduce stock
            foreach ($cart->items as $item) {

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // 🔻 Reduce stock
                $item->product->decrement('stock', $item->quantity);
            }

            // 🧹 Close cart
            $cart->update(['status' => 'checked_out']);
        });

        return redirect()->route('store.index')
            ->with('success', 'Checkout successful!');
    }
}
