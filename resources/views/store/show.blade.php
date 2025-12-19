{{-- ============================================== --}}
{{-- File: resources/views/store/show.blade.php --}}
{{-- Purpose: Customer Product Detail Page (Polished UI, Perfect Image Fit) --}}
{{-- ============================================== --}}

@extends('layouts.public')

@section('title', $product->name)

@section('content')
<div class="container py-5">

    {{-- Back --}}
    <a href="{{ route('store.index') }}"
       class="btn btn-sm btn-outline-secondary mb-4">
        ← Back to Store
    </a>

    @php
        $outOfStock = $product->stock <= 0;
    @endphp

    <div class="row g-5 align-items-start">

        {{-- ================= IMAGE ================= --}}
        <div class="col-md-5">

            <div class="product-image-box shadow-sm">

                @if($product->image)
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="product-image {{ $outOfStock ? 'grayscale' : '' }}">
                @else
                    <div class="product-image-placeholder">
                        <i class="bi bi-box-seam"></i>
                    </div>
                @endif

            </div>

        </div>

        {{-- ================= DETAILS ================= --}}
        <div class="col-md-7">

            <h2 class="fw-bold mb-2">
                {{ $product->name }}
            </h2>

            <div class="text-muted mb-3">
                <span class="me-4">
                    Category:
                    <strong>{{ $product->category ?? '-' }}</strong>
                </span>
                <span>
                    Brand:
                    <strong>{{ $product->brand ?? '-' }}</strong>
                </span>
            </div>

            <div class="fs-3 fw-bold text-primary mb-3">
                {{ rupiah($product->price) }}
            </div>

            <div class="mb-3">
                @if($outOfStock)
                    <span class="badge bg-danger px-3 py-2">Out of Stock</span>
                @else
                    <span class="badge bg-success px-3 py-2">In Stock</span>
                @endif
            </div>

            {{-- Description --}}
            <div class="mt-4 product-description">
                <h6 class="fw-semibold mb-2">Product Description</h6>
                <p class="text-muted mb-0">
                    {{ $product->description ?? 'No description available.' }}
                </p>
            </div>

            {{-- Action --}}
            <div class="mt-5">

                @if($outOfStock)
                    <button class="btn btn-outline-secondary btn-lg px-5" disabled>
                        Out of Stock
                    </button>
                @else
                    <form method="POST" action="{{ route('cart.add', $product) }}">
                        @csrf
                        <button class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-cart-plus me-2"></i>
                            Add to Cart
                        </button>
                    </form>
                @endif

            </div>

        </div>
    </div>
</div>

{{-- ================= STYLES ================= --}}
<style>
/* Image container */
.product-image-box {
    width: 100%;
    height: 420px;
    background: #f8f9fa;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

/* ✅ PERFECT IMAGE FIT (NO CROP) */
.product-image {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
}

/* Placeholder */
.product-image-placeholder {
    font-size: 4rem;
    color: #adb5bd;
}

/* Description spacing */
.product-description {
    line-height: 1.7;
}

/* Out of stock visual */
.grayscale {
    filter: grayscale(100%);
}
</style>
@endsection
