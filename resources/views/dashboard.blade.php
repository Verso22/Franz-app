{{-- ============================================== --}}
{{-- File: resources/views/dashboard.blade.php --}}
{{-- Purpose: Dashboard home page for Admin & HRD users (REAL DATA) --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">

    {{-- 🧱 Page Title --}}
    <h2 class="fw-bold mb-4">Dashboard Overview</h2>

    {{-- 📊 Summary Cards --}}
    <div class="row g-4">

        {{-- Total Products --}}
        <div class="col-md-3">
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

        {{-- Employees --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-success text-white rounded-3 p-3 me-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $totalEmployees }}</h5>
                        <small class="text-muted">Employees</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Sales --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-warning text-white rounded-3 p-3 me-3">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ rupiah($totalSales) }}</h5>
                        <small class="text-muted">Total Sales</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Transactions --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-danger text-white rounded-3 p-3 me-3">
                        <i class="bi bi-receipt fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $totalTransactions }}</h5>
                        <small class="text-muted">Transactions</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ⚠️ Low Stock Alert --}}
    <div class="card mt-5 shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-bold mb-3 text-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Low Stock Alert
            </h5>

            @if($lowStockProducts->count() === 0)
                <div class="text-muted">
                    All products have sufficient stock.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th width="120">Stock</th>
                                <th width="120">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        <span class="badge bg-danger">
                                            Low
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- 📈 Placeholder Chart --}}
    <div class="card mt-5 shadow-sm border-0 p-4">
        <h5 class="fw-bold mb-3">Sales Overview</h5>
        <p class="text-muted">This section will show a graph later for weekly sales data.</p>

        <div class="p-5 bg-light text-center rounded-3 text-muted">
            <i class="bi bi-bar-chart fs-1"></i>
            <p class="mt-2">[ Chart will be added here later ]</p>
        </div>
    </div>

</div>

{{-- 💅 Styles --}}
<style>
.dashboard-card {
    transition: all 0.3s ease;
    border-radius: 12px;
}
.dashboard-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}
.icon-box {
    width: 55px;
    height: 55px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection
