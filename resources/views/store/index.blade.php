{{-- ============================================== --}}
{{-- File: resources/views/store/index.blade.php --}}
{{-- Purpose: Customer Storefront (Search + Category + Brand Filter + Clear) --}}
{{-- ============================================== --}}

@extends('layouts.store')

@section('title', 'Store')

@section('content')
<div class="container py-5">

    {{-- 🏪 Store Header --}}
    <div class="text-center mb-4">
        <h1 class="fw-bold">Welcome to MyStore</h1>
        <p class="text-muted">
            Browse our products and add them to your cart.
        </p>
    </div>

    {{-- 🔍 SEARCH & FILTER FORM --}}
    <form method="GET" action="{{ route('store.index') }}" class="mb-5">
        <div class="row g-3 justify-content-center align-items-end">

            {{-- Search --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Search</label>
                <input
                    type="text"
                    name="q"
                    class="form-control"
                    placeholder="Search product name..."
                    value="{{ request('q') }}"
                >
            </div>

            {{-- Category --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold">Category</label>
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($products->pluck('category')->filter()->unique() as $category)
                        <option value="{{ $category }}"
                            {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Brand --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold">Brand</label>
                <select name="brand" class="form-select">
                    <option value="">All Brands</option>
                    @foreach($products->pluck('brand')->filter()->unique() as $brand)
                        <option value="{{ $brand }}"
                            {{ request('brand') == $brand ? 'selected' : '' }}>
                            {{ $brand }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Buttons --}}
            <div class="col-md-2 d-grid gap-2">
                <button class="btn btn-primary">
                    Apply
                </button>

                {{-- 🧹 Clear Filters (only show if active) --}}
                @if(request()->hasAny(['q', 'category', 'brand']))
                    <a href="{{ route('store.index') }}"
                       class="btn btn-outline-secondary">
                        Clear Filters
                    </a>
                @endif
            </div>

        </div>
    </form>

    {{-- 📦 Product Grid --}}
    <div class="row g-4">

        @if($products->count() === 0)
            <div class="col-12 text-center text-muted">
                No products found.
            </div>
        @endif

        @foreach($products as $product)

            @php
                $outOfStock = $product->stock <= 0;
            @endphp

            <div class="col-md-3">

                <a href="{{ route('store.show', $product) }}"
                   class="text-decoration-none text-dark">

                    <div class="card h-100 shadow-sm {{ $outOfStock ? 'opacity-50' : '' }}">

                        {{-- 🖼️ Image --}}
                        <div class="product-image-wrapper">
                            @if($product->image)
                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="product-image {{ $outOfStock ? 'grayscale' : '' }}"
                                >
                            @else
                                <div class="no-image">No Image</div>
                            @endif
                        </div>

                        {{-- 📄 Content --}}
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

                                <form method="POST"
                                      action="{{ route('cart.add', $product) }}"
                                      onclick="event.stopPropagation();">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-outline-primary w-100">
                                        Add to Cart
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>
                </a>
            </div>

        @endforeach

    </div>
</div>

{{-- 🎨 Image styles --}}
<style>
.product-image-wrapper {
    width: 100%;
    height: 180px;
    overflow: hidden;
    border-bottom: 1px solid #eee;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 10px;
    background-color: #fff;
}

.no-image {
    color: #aaa;
    font-size: 0.9rem;
}

.grayscale {
    filter: grayscale(100%);
}
</style>
@endsection
