{{-- ============================================== --}}
{{-- File: resources/views/cart/index.blade.php --}}
{{-- Purpose: Customer Cart Page (Image + Quantity Update) --}}
{{-- ============================================== --}}

@extends('layouts.store')

@section('title', 'Your Cart')

@section('content')
<div class="container py-5">

    <h2 class="fw-bold mb-4">🛒 Your Cart</h2>

    @if(!$cart || $cart->items->count() === 0)
        <div class="alert alert-info">
            Your cart is empty.
        </div>
        <a href="{{ route('store.index') }}" class="btn btn-primary">
            Back to Store
        </a>
    @else

        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th width="160">Quantity</th>
                            <th width="150">Price</th>
                            <th width="150">Subtotal</th>
                            <th width="80"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp

                        @foreach($cart->items as $item)
                            @php
                                $subtotal = $item->quantity * $item->product->price;
                                $total += $subtotal;
                                $outOfStock = $item->product->stock <= 0;
                            @endphp

                            <tr>
                                {{-- 🖼 Product + Image --}}
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if($item->product->image)
                                            <img
                                                src="{{ asset('storage/' . $item->product->image) }}"
                                                alt="{{ $item->product->name }}"
                                                class="cart-thumb">
                                        @else
                                            <div class="cart-thumb no-image">
                                                No Image
                                            </div>
                                        @endif

                                        <div>
                                            <div class="fw-semibold">
                                                {{ $item->product->name }}
                                            </div>
                                            <small class="text-muted">
                                                Stock: {{ $item->product->stock }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                {{-- 🔢 Quantity Controls --}}
                                <td>
                                    <form method="POST"
                                          action="{{ route('cart.update', $item) }}"
                                          class="d-flex align-items-center gap-1">
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            name="action"
                                            value="decrease"
                                            class="btn btn-sm btn-outline-secondary"
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                            −
                                        </button>

                                        <input
                                            type="text"
                                            class="form-control text-center"
                                            value="{{ $item->quantity }}"
                                            readonly
                                            style="width: 45px;">

                                        <button
                                            type="submit"
                                            name="action"
                                            value="increase"
                                            class="btn btn-sm btn-outline-secondary"
                                            {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                            +
                                        </button>
                                    </form>
                                </td>

                                {{-- 💰 Price --}}
                                <td>{{ rupiah($item->product->price) }}</td>

                                {{-- 📦 Subtotal --}}
                                <td>{{ rupiah($subtotal) }}</td>

                                {{-- 🗑 Remove --}}
                                <td>
                                    <form method="POST" action="{{ route('cart.remove', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        {{-- 🧮 Total --}}
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Total</td>
                            <td>{{ rupiah($total) }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                {{-- ✅ Checkout --}}
                <form method="POST" action="{{ route('cart.checkout') }}">
                    @csrf
                    <button class="btn btn-success">
                        Proceed to Checkout
                    </button>
                </form>

            </div>
        </div>

    @endif
</div>

{{-- 🎨 Cart Image Styles --}}
<style>
.cart-thumb {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #ddd;
    background-color: #f8f9fa;
}

.cart-thumb.no-image {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    color: #999;
}
</style>
@endsection
