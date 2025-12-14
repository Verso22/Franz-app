{{-- ============================================== --}}
{{-- File: resources/views/products/index.blade.php --}}
{{-- Purpose: REAL Product management UI (DB-connected) --}}
{{-- ============================================== --}}

@extends('layouts.app')
@section('title', 'Products')

@section('content')
<div class="container-fluid py-4">

    {{-- 🧱 Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Products</h2>

        {{-- ➕ Add Product Button (Admin Only) --}}
        @if(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm px-4">
                <i class="bi bi-plus-circle me-2"></i> Add Product
            </a>
        @endif
    </div>

    {{-- 📦 Summary Cards (REAL DATA) --}}
    <div class="row g-3 mb-4">

        {{-- Total Products --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary text-white rounded-3 p-3 me-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $totalProducts }}</h5>
                        <small class="text-muted">Total Products</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Categories --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-success text-white rounded-3 p-3 me-3">
                        <i class="bi bi-tags fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $totalCategories }}</h5>
                        <small class="text-muted">Categories</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Low Stock --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-warning text-white rounded-3 p-3 me-3">
                        <i class="bi bi-exclamation-triangle fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $lowStockCount }}</h5>
                        <small class="text-muted">Low Stock (≤ 5)</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- 📋 Product Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Product List</h5>

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Date Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category ?? '-' }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ rupiah($product->price) }}</td>
                                <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if(auth()->check() && auth()->user()->isAdmin())

                                        {{-- ✏️ Edit --}}
                                        <a href="{{ route('products.edit', $product->id) }}"
                                           class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- 🗑️ Delete --}}
                                        <form action="{{ route('products.destroy', $product->id) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Delete this product?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    @else
                                        <span class="text-muted">View Only</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No products found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

{{-- 🧭 Floating Trash Button (Admin Only) --}}
@if(auth()->check() && auth()->user()->isAdmin())
    <a href="{{ route('products.trash') }}"
       class="btn btn-secondary shadow-lg d-flex align-items-center gap-2 floating-trash-btn">
        <i class="bi bi-trash fs-5"></i>
        <span>View Trash</span>
    </a>
@endif

{{-- 💅 Page-specific styles --}}
<style>
.dashboard-card {
    transition: all 0.3s ease;
    border-radius: 12px;
}
.dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
}
.icon-box {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.table th {
    font-weight: 600;
    color: #333;
}
.table td {
    color: #555;
}
.btn-outline-secondary:hover i,
.btn-outline-danger:hover i {
    color: white;
}

/* Floating Trash Button */
.floating-trash-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background-color: #6c757d;
    border: none;
    border-radius: 50px;
    padding: 10px 18px;
    font-weight: 500;
    color: #fff;
    transition: all 0.25s ease;
    z-index: 1050;
}
.floating-trash-btn:hover {
    background-color: #5a6268;
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(0,0,0,0.2);
    color: #fff;
    text-decoration: none;
}
.floating-trash-btn i {
    font-size: 1.2rem;
}
</style>
@endsection
