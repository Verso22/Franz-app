{{-- ============================================== --}}
{{-- File: resources/views/products/trash.blade.php --}}
{{-- Purpose: Modern Trash Bin page for deleted products (role-based control + clean) --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', 'Trash Bin')

@section('content')
<div class="container-fluid">

    {{-- 🧱 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-trash3-fill text-danger me-2"></i> Trash Bin
        </h2>
    </div>

    {{-- 🧩 Card container --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="fw-semibold mb-0 text-danger">
                <i class="bi bi-recycle me-2"></i> Deleted Products
            </h5>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to Products
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Price</th>
                            <th scope="col">Deleted At</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category }}</td>
                            <td>{{ $product->brand }}</td>
                            <td>{{ rupiah($product->price) }}</td>
                            <td>{{ $product->deleted_at->format('Y-m-d') }}</td>
                            <td class="text-center">
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    {{-- 🟢 Restore --}}
                                    <form action="{{ route('products.restore', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success me-2">
                                            <i class="bi bi-arrow-clockwise"></i> Restore
                                        </button>
                                    </form>

                                    {{-- 🔴 Delete permanently --}}
                                    <form action="{{ route('products.forceDelete', $product->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to permanently delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash3"></i> Delete Permanently
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">No Actions Available</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        {{-- 🧱 Empty state --}}
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Trash is empty.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- 🪄 Floating Back Button --}}
<a href="{{ route('products.index') }}" 
    class="btn btn-secondary shadow-lg d-flex align-items-center gap-2 floating-back-btn">
    <i class="bi bi-arrow-left-circle fs-5"></i>
    <span>Back to Products</span>
</a>

{{-- 💅 Styles --}}
<style>
/* Floating back button (bottom-right) */
.floating-back-btn {
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
.floating-back-btn:hover {
    background-color: #5a6268;
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(0,0,0,0.2);
    color: #fff;
    text-decoration: none;
}

/* Table and card enhancements */
.card {
    border-radius: 1rem;
}
.table-hover tbody tr:hover {
    background-color: rgba(255, 0, 0, 0.05);
}
.btn-outline-danger:hover {
    background-color: #dc3545;
    color: #fff;
}
.btn-outline-success:hover {
    background-color: #198754;
    color: #fff;
}
</style>
@endsection
