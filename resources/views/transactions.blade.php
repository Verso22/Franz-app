{{-- ============================================== --}}
{{-- File: resources/views/transactions.blade.php --}}
{{-- Purpose: Modern Transactions page (mock data, CRUD later) --}}
{{-- ============================================== --}}

@extends('layouts.app')
@section('title', 'Transactions')

@section('content')
<div class="container-fluid py-4">

    {{-- 🧱 Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Transactions</h2>

        {{-- ➕ Add Transaction (Admin only) --}}
        @if(auth()->check() && auth()->user()->isAdmin())
            <a href="#" class="btn btn-primary shadow-sm px-4">
                <i class="bi bi-plus-circle me-2"></i> Add Transaction
            </a>
        @endif
    </div>

    {{-- 💳 Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary text-white rounded-3 p-3 me-3">
                        <i class="bi bi-cash-coin fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Rp 12.5M</h5>
                        <small class="text-muted">Total Sales</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-success text-white rounded-3 p-3 me-3">
                        <i class="bi bi-cart-check fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">1,245</h5>
                        <small class="text-muted">Completed Orders</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-warning text-white rounded-3 p-3 me-3">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">32</h5>
                        <small class="text-muted">Pending</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-danger text-white rounded-3 p-3 me-3">
                        <i class="bi bi-x-circle fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">12</h5>
                        <small class="text-muted">Cancelled</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 📋 Transactions Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Recent Transactions</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Mock Data --}}
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>2025-10-15</td>
                            <td>Rp 150,000</td>
                            <td><span class="badge bg-success">Completed</span></td>
                            <td>Cash</td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jane Smith</td>
                            <td>2025-10-14</td>
                            <td>Rp 98,000</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td>QRIS</td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- 💅 Styles --}}
<style>
.dashboard-card {
    border-radius: 12px;
    transition: all 0.3s ease;
}
.dashboard-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
}
.icon-box {
    width: 50px; height: 50px;
    display: flex; align-items: center; justify-content: center;
}
.table td, .table th { color: #333; }
</style>
@endsection
