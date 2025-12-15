{{-- ============================================== --}}
{{-- File: resources/views/cart/index.blade.php --}}
{{-- Purpose: Customer Cart Page --}}
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
                            <th width="120">Quantity</th>
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
                            @endphp

                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ rupiah($item->product->price) }}</td>
                                <td>{{ rupiah($subtotal) }}</td>
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

                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Total</td>
                            <td>{{ rupiah($total) }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                    <form method="POST" action="{{ route('cart.checkout') }}">
                        @csrf
                        <button class="btn btn-success">
                            Proceed to Checkout
                        </button>
                    </form>

                </div>

            </div>
        </div>

    @endif
</div>
@endsection
