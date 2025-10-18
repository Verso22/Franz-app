{{-- ============================================== --}}
{{-- File: resources/views/products/form.blade.php --}}
{{-- Purpose: Modern two-column Add/Edit Product form --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')
<div class="container-fluid">

    {{-- ✅ Success message (appears after add/update) --}}
    @if (session('success'))
        <div id="alertMessage" class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- 🧱 Page Title --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-box-seam text-primary me-2"></i>
            {{ isset($product) ? 'Edit Product' : 'Add New Product' }}
        </h2>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle me-1"></i> Back
        </a>
    </div>

    {{-- 🪄 Modern Card Form --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" 
                  method="POST">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif

                <div class="row g-4">
                    {{-- 🧍 Left Column --}}
                    <div class="col-md-6">
                        {{-- Brand --}}
                        <div class="mb-3">
                            <label for="brand" class="form-label fw-semibold">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand"
                                   value="{{ old('brand', $product->brand ?? '') }}" placeholder="Enter brand name">
                        </div>

                        {{-- Product Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ old('name', $product->name ?? '') }}" placeholder="Enter product name">
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5"
                                      placeholder="Enter product description">{{ old('description', $product->description ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- 🧍‍♂️ Right Column --}}
                    <div class="col-md-6">
                        {{-- Category --}}
                        <div class="mb-3">
                            <label for="category" class="form-label fw-semibold">Category</label>
                            <input type="text" class="form-control" id="category" name="category"
                                   value="{{ old('category', $product->category ?? '') }}" placeholder="Enter category">
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label for="price" class="form-label fw-semibold">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="price" name="price"
                                       value="{{ old('price', $product->price ?? '') }}" placeholder="Enter price">
                            </div>
                            <span id="pricePreview" class="form-text text-muted">
                                {{ rupiah(old('price', $product->price ?? 0)) }}
                            </span>
                        </div>

                        {{-- Stock --}}
                        <div class="mb-3">
                            <label for="stock" class="form-label fw-semibold">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock"
                                   value="{{ old('stock', $product->stock ?? '') }}" placeholder="Enter stock quantity">
                        </div>

                        {{-- Expiry Date --}}
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label fw-semibold">Expiry Date</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date"
                                   value="{{ old('expiry_date', $product->expiry_date ?? '') }}">
                        </div>
                    </div>
                </div>

                {{-- 🧩 Buttons --}}
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ isset($product) ? 'Update Product' : 'Add Product' }}
                    </button>
                    <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('products.index') }}"
                       class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 💰 Live Rupiah Preview --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const priceInput = document.getElementById('price');
    const pricePreview = document.getElementById('pricePreview');
    const alertBox = document.getElementById('alertMessage');

    // 💸 Function to format number as Rupiah
    function formatRupiah(angka) {
        if (!angka) return 'Rp 0';
        const number = parseInt(angka, 10);
        return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Update preview live while typing
    if (priceInput) {
        priceInput.addEventListener('input', function () {
            pricePreview.textContent = formatRupiah(priceInput.value);
        });
    }

    // 🧩 Auto-hide success alert after 3 seconds
    if (alertBox) {
        setTimeout(() => {
            alertBox.classList.remove('show');
            alertBox.classList.add('fade');
        }, 3000);
    }
});
</script>

{{-- 💅 Form Styles --}}
<style>
    .card {
        border-radius: 1rem;
    }

    .form-label {
        font-size: 0.95rem;
    }

    .form-control, .input-group-text {
        border-radius: 0.5rem;
    }

    .btn {
        border-radius: 0.5rem;
    }

    .form-text {
        font-size: 0.85rem;
        color: #6c757d;
    }

    #alertMessage {
        border-radius: 0.5rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        transition: opacity 0.4s ease;
    }

    @media (max-width: 768px) {
        .col-md-6 {
            width: 100%;
        }
    }
</style>
@endsection
