{{-- ============================================== --}}
{{-- File: resources/views/home.blade.php --}}
{{-- Purpose: Public homepage (guest + customer landing page) --}}
{{-- ============================================== --}}

@extends('layouts.public')

@section('title', 'Welcome to MyStore')

@section('content')
<div class="container py-5">

    {{-- ================= HERO SECTION ================= --}}
    <div class="row align-items-center mb-6 g-5">

        <div class="col-lg-6">
            <h1 class="fw-bold display-5 mb-3 lh-sm">
                Shop Smarter at <span class="text-primary">MyStore</span>
            </h1>

            <p class="text-muted mb-4 fs-5">
                Discover curated products, transparent pricing,
                and a smooth checkout experience — all in one place.
            </p>

            {{-- Auth Buttons --}}
            <div class="d-flex flex-wrap gap-3">
                @guest
                    <a href="{{ route('login') }}"
                       class="btn btn-primary btn-lg px-4">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="btn btn-outline-secondary btn-lg px-4">
                        Register
                    </a>
                @else
                    <a href="{{ route('store.index') }}"
                       class="btn btn-primary btn-lg px-4">
                        Start Shopping
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger btn-lg px-4">
                            Logout
                        </button>
                    </form>
                @endguest
            </div>
        </div>

        <div class="col-lg-6 text-center">
            <img
                src="https://illustrations.popsy.co/gray/shopping-bags.svg"
                alt="Shopping Illustration"
                class="img-fluid hero-image">
        </div>
    </div>

    {{-- ================= RECOMMENDED PRODUCTS ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Recommended Products</h4>

        <a href="{{ route('store.index') }}"
           class="text-decoration-none fw-medium text-primary">
            View all →
        </a>
    </div>

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-6 col-md-4 col-lg-3">

                <div class="card product-card h-100 border-0">

                    {{-- Image --}}
                    <div class="product-image-wrapper">
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
                    </div>

                    {{-- Body --}}
                    <div class="card-body d-flex flex-column p-3">

                        <h6 class="fw-semibold mb-1 product-title">
                            {{ $product->name }}
                        </h6>

                        <p class="text-muted small mb-3">
                            {{ Str::limit($product->description, 55) }}
                        </p>

                        <div class="mt-auto">
                            <div class="fw-bold text-primary fs-6 mb-3">
                                {{ rupiah($product->price) }}
                            </div>

                            <a href="{{ route('store.show', $product) }}"
                               class="btn btn-sm btn-outline-primary w-100">
                                View Product
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                No products available yet.
            </div>
        @endforelse
    </div>

</div>

{{-- ================= STYLES ================= --}}
<style>
/* ================= HERO ================= */
.hero-image {
    max-height: 360px;
}

/* ================= PRODUCT CARD ================= */
.product-card {
    border-radius: 16px;
    background: #ffffff;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 26px rgba(0,0,0,0.12);
}

/* ================= IMAGE HANDLING (PERFECT FIT) ================= */
.product-image-wrapper {
    width: 100%;
    height: 190px;
    background-color: #f8f9fa;
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
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    font-size: 3rem;
}

/* ================= TITLE CLAMP ================= */
.product-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
