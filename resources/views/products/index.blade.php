{{-- ============================================== --}}
{{-- File: resources/views/products.blade.php --}}
{{-- Purpose: Product management UI (modern dashboard design) --}}
{{-- ============================================== --}}

@extends('layouts.app')
{{-- 🧠 Uses our main layout (dark sidebar, top navbar) --}}

@section('title', 'Products')

@section('content')
<div class="container-fluid py-4">
    {{-- 🧱 Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Products</h2>

        {{-- ➕ Add Product Button --}}
        <a href="#" class="btn btn-primary shadow-sm px-4">
            <i class="bi bi-plus-circle me-2"></i> Add Product
        </a>
    </div>

    {{-- 📦 Summary Cards (Optional, for visual balance) --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary text-white rounded-3 p-3 me-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">120</h5>
                        <small class="text-muted">Total Products</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-success text-white rounded-3 p-3 me-3">
                        <i class="bi bi-tags fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">8</h5>
                        <small class="text-muted">Categories</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-warning text-white rounded-3 p-3 me-3">
                        <i class="bi bi-exclamation-triangle fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">5</h5>
                        <small class="text-muted">Low Stock</small>
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
                        {{-- 🧪 Temporary sample data (replace with @foreach later) --}}
                        <tr>
                            <td>1</td>
                            <td>Chocolate Bar</td>
                            <td>Snacks</td>
                            <td>35</td>
                            <td>{{ rupiah(5000) }}</td>
            {{-- If dynamic: <td>{{ rupiah($product->price) }}</td> --}}

                            <td>2025-10-15</td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Instant Noodles</td>
                            <td>Food</td>
                            <td>62</td>
                            <td>{{ rupiah(3500) }}</td>
                            <td>2025-10-10</td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Mineral Water</td>
                            <td>Beverage</td>
                            <td>120</td>
                            <td>{{ rupiah(3000) }}</td>
                            <td>2025-10-05</td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- 🎨 Inline style tweaks (same visual tone as dashboard) --}}
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
</style>
@endsection
