{{-- ============================================== --}}
{{-- File: resources/views/store/index.blade.php --}}
{{-- Purpose: Customer Storefront (Modern UI – Polished) --}}
{{-- ============================================== --}}

@extends('layouts.public')

@section('title', 'Store')

@section('content')
<div class="container py-5">

    {{-- ================= STORE HEADER ================= --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold mb-2 display-6">Shop at MyStore</h1>
        <p class="text-muted fs-5 mb-0">
            Find the best products, curated just for you
        </p>
    </div>

    {{-- ================= SEARCH & FILTER ================= --}}
    <form method="GET" action="{{ route('store.index') }}" class="mb-5">
        <div class="card border-0 shadow-sm p-4 filter-card">
            <div class="row g-3 align-items-end">

                {{-- Search --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text"
                           name="q"
                           class="form-control"
                           placeholder="Search product name..."
                           value="{{ request('q') }}">
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

                    @if(request()->hasAny(['q', 'category', 'brand']))
                        <a href="{{ route('store.index') }}"
                           class="btn btn-outline-secondary">
                            Clear
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </form>

    {{-- ================= PRODUCT GRID ================= --}}
    <div class="row g-4">

        @if($products->count() === 0)
            <div class="col-12 text-center text-muted py-5">
                No products found.
            </div>
        @endif

        @foreach($products as $product)
            @php $outOfStock = $product->stock <= 0; @endphp

            <div class="col-6 col-md-4 col-lg-3">

                <div class="card product-card h-100 border-0">

                    {{-- Image --}}
                    <a href="{{ route('store.show', $product) }}"
                       class="product-image-wrapper {{ $outOfStock ? 'opacity-50' : '' }}">
                        @if($product->image)
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="product-image">
                        @else
                            <div class="product-image-placeholder">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        @endif
                    </a>

                    {{-- Body --}}
                    <div class="card-body d-flex flex-column p-3">

                        <h6 class="fw-semibold product-title mb-1">
                            {{ $product->name }}
                        </h6>

                        <small class="text-muted mb-2">
                            {{ $product->category ?? 'Uncategorized' }}
                        </small>

                        <div class="fw-bold text-primary mb-3 fs-6">
                            {{ rupiah($product->price) }}
                        </div>

                        <div class="mt-auto">

                            @if($outOfStock)
                                <span class="badge bg-danger mb-2">
                                    Out of Stock
                                </span>
                                <button class="btn btn-outline-secondary w-100" disabled>
                                    Unavailable
                                </button>
                            @else
                                <span class="badge bg-success mb-2">
                                    In Stock
                                </span>

                                <form method="POST"
                                      action="{{ route('cart.add', $product) }}">
                                    @csrf
                                    <button class="btn btn-outline-primary w-100">
                                        Add to Cart
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>

                </div>

            </div>
        @endforeach

    </div>
</div>

{{-- ================= STYLES ================= --}}
<style>
/* Filter card */
.filter-card {
    border-radius: 16px;
}

/* Product card */
.product-card {
    border-radius: 16px;
    background: #ffffff;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 26px rgba(0,0,0,0.12);
}

/* Image handling (PERFECT FIT) */
.product-image-wrapper {
    width: 100%;
    height: 190px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
}

.product-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; /* ✅ NO CROP, NO DISTORTION */
}

.product-image-placeholder {
    color: #adb5bd;
    font-size: 3rem;
}

/* Title clamp */
.product-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
