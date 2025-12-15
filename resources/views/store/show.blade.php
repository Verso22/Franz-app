{{-- ============================================== --}}
{{-- File: resources/views/store/show.blade.php --}}
{{-- Purpose: Product Detail Page (Read-Only) --}}
{{-- ============================================== --}}

@extends('layouts.store')

@section('title', $product->name)

@section('content')
<div class="container py-5">

    <a href="{{ route('store.index') }}" class="btn btn-sm btn-outline-secondary mb-4">
        ← Back to Store
    </a>

    @php
        $outOfStock = $product->stock <= 0;
    @endphp

    <div class="row g-5">

        {{-- 🖼️ Image --}}
        <div class="col-md-5">
            <div class="border rounded p-3 bg-light">
                @if($product->image)
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        class="img-fluid w-100 {{ $outOfStock ? 'grayscale' : '' }}"
                        style="object-fit: contain; max-height: 350px;"
                        alt="{{ $product->name }}"
                    >
                @else
                    <div class="text-center text-muted py-5">
                        No Image
                    </div>
                @endif
            </div>
        </div>

        {{-- 📄 Info --}}
        <div class="col-md-7">
            <h2 class="fw-bold">{{ $product->name }}</h2>

            <p class="text-muted mb-1">
                Category: {{ $product->category ?? '-' }}
            </p>

            <p class="text-muted mb-3">
                Brand: {{ $product->brand ?? '-' }}
            </p>

            <h4 class="fw-bold mb-3">
                {{ rupiah($product->price) }}
            </h4>

            @if($outOfStock)
                <span class="badge bg-danger mb-3">Out of Stock</span>
            @else
                <span class="badge bg-success mb-3">In Stock</span>
            @endif

            <p class="mt-4">
                {{ $product->description ?? 'No description available.' }}
            </p>

            {{-- 🛒 Action --}}
            <div class="mt-4">
                @if($outOfStock)
                    <button class="btn btn-outline-secondary" disabled>
                        Out of Stock
                    </button>
                @else
                    <form method="POST" action="{{ route('cart.add', $product) }}">
                        @csrf
                        <button class="btn btn-primary">
                            Add to Cart
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</div>

<style>
.grayscale {
    filter: grayscale(100%);
}
</style>
@endsection
