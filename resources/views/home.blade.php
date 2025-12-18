{{-- ============================================== --}}
{{-- File: resources/views/home.blade.php --}}
{{-- Purpose: Public homepage (guest + customer landing page) --}}
{{-- ============================================== --}}

@extends('layouts.public')

@section('title', 'Welcome to MyStore')

@section('content')
<div class="container py-5">

    {{-- ================= HERO SECTION ================= --}}
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h1 class="fw-bold mb-3">
                Welcome to <span class="text-primary">MyStore</span>
            </h1>
            <p class="text-muted mb-4">
                Discover great products, best prices, and fast checkout.
                Shop anytime, anywhere.
            </p>

            {{-- Auth Buttons --}}
            <div class="d-flex gap-3">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary px-4">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary px-4">
                        Register
                    </a>
                @else
                    <a href="{{ route('store.index') }}" class="btn btn-primary px-4">
                        Start Shopping
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger px-4">
                            Logout
                        </button>
                    </form>
                @endguest
            </div>
        </div>

        <div class="col-md-6 text-center">
            <img
                src="https://illustrations.popsy.co/gray/shopping-bags.svg"
                alt="Shopping Illustration"
                class="img-fluid"
                style="max-height: 320px;">
        </div>
    </div>

    {{-- ================= FEATURED PRODUCTS ================= --}}
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4 class="fw-semibold mb-0">Recommended Products</h4>

        <a href="{{ route('store.index') }}" class="text-decoration-none">
            View all →
        </a>
    </div>

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0 product-card">

                    {{-- Product Image --}}
                    @if($product->image)
                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            class="card-img-top"
                            style="height: 180px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light"
                             style="height: 180px;">
                            <i class="bi bi-box-seam fs-1 text-secondary"></i>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h6 class="fw-semibold mb-1">
                            {{ $product->name }}
                        </h6>

                        <p class="text-muted small mb-2">
                            {{ Str::limit($product->description, 50) }}
                        </p>

                        <div class="mt-auto">
                            <div class="fw-bold text-primary mb-2">
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
.product-card {
    transition: all 0.25s ease;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.1);
}
</style>
@endsection
