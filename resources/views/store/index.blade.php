{{-- ============================================== --}}
{{-- File: resources/views/store/index.blade.php --}}
{{-- Purpose: Customer Storefront (Add to Cart enabled) --}}
{{-- ============================================== --}}

@extends('layouts.store')

@section('title', 'Store')

@section('content')
<div class="container py-5">

    {{-- 🏪 Store Header --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold">Welcome to MyStore</h1>
        <p class="text-muted">
            Browse our products and add them to your cart.
        </p>
    </div>

    {{-- 📦 Product Grid --}}
    <div class="row g-4">

        @if($products->count() === 0)
            <div class="col-12 text-center text-muted">
                No products available.
            </div>
        @endif

        @foreach($products as $product)

            @php
                $outOfStock = $product->stock <= 0;
            @endphp

            <div class="col-md-3">
                <div class="card h-100 shadow-sm {{ $outOfStock ? 'opacity-50' : '' }}">
                    <div class="card-body text-center">

                        <h5 class="fw-semibold">{{ $product->name }}</h5>

                        <p class="text-muted mb-1">
                            {{ $product->category ?? '-' }}
                        </p>

                        <p class="fw-bold mb-2">
                            {{ rupiah($product->price) }}
                        </p>

                        @if($outOfStock)
                            <span class="badge bg-danger mb-3">Out of Stock</span>

                            <button class="btn btn-outline-secondary w-100" disabled>
                                Out of Stock
                            </button>
                        @else
                            <span class="badge bg-success mb-3">In Stock</span>

                            <form method="POST" action="{{ route('cart.add', $product) }}">
                                @csrf
                                <button class="btn btn-outline-primary w-100">
                                    Add to Cart
                                </button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>

        @endforeach

    </div>
</div>
@endsection
