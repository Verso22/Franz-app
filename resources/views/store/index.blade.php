{{-- ============================================== --}}
{{-- File: resources/views/store/index.blade.php --}}
{{-- Purpose: Customer Storefront (product browsing only, no cart yet) --}}
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

    {{-- 📦 Product List (placeholder for now) --}}
    <div class="row g-4">

        {{-- Example product card --}}
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="fw-semibold">Example Product</h5>
                    <p class="text-muted mb-2">Category</p>
                    <p class="fw-bold">{{ rupiah(10000) }}</p>

                    {{-- Disabled for now --}}
                    <button class="btn btn-outline-primary w-100" disabled>
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
