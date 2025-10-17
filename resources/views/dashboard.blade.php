{{-- ============================================== --}}
{{-- File: resources/views/dashboard.blade.php --}}
{{-- Purpose: Dashboard home page for Admin & HRD users --}}
{{-- ============================================== --}}

@extends('layouts.app')
{{-- 🧠 Uses our main dark sidebar layout --}}

@section('title', 'Dashboard')
{{-- 🧠 Sets the browser tab title dynamically --}}

@section('content')
<div class="container-fluid py-4">
    {{-- 🧱 Page Title --}}
    <h2 class="fw-bold mb-4">Dashboard Overview</h2>

    {{-- 🎨 Dashboard Summary Cards Row --}}
    <div class="row g-4">
        {{-- 🧩 Total Products Card --}}
        <div class="col-md-3">
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

        {{-- 🧩 Total Employees Card --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-success text-white rounded-3 p-3 me-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">15</h5>
                        <small class="text-muted">Employees</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- 🧩 Total Sales Card --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-warning text-white rounded-3 p-3 me-3">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ rupiah(25000) }}</h5>
                        {{-- Later replace 25000 with a dynamic variable --}}                       
                        <small class="text-muted">Total Sales</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- 🧩 Total Transactions Card --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-danger text-white rounded-3 p-3 me-3">
                        <i class="bi bi-receipt fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">89</h5>
                        <small class="text-muted">Transactions</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 📊 Placeholder Section for Future Charts --}}
    <div class="card mt-5 shadow-sm border-0 p-4">
        <h5 class="fw-bold mb-3">Sales Overview</h5>
        <p class="text-muted">This section will show a graph later for weekly sales data.</p>

        <div class="p-5 bg-light text-center rounded-3 text-muted">
            <i class="bi bi-bar-chart fs-1"></i>
            <p class="mt-2">[ Chart will be added here later ]</p>
        </div>
    </div>
</div>

{{-- 🪄 Inline CSS for hover animation & modern look --}}
<style>
    /* 🧱 Add smooth hover animation to dashboard cards */
    .dashboard-card {
        transition: all 0.3s ease;
        border-radius: 12px; /* rounded corners */
    }
    .dashboard-card:hover {
        transform: translateY(-6px); /* lift up slightly */
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2); /* deeper shadow */
    }

    /* 🎨 Style for the icon box inside each card */
    .icon-box {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    /* 🧭 Responsive adjustments */
    @media (max-width: 768px) {
        .dashboard-card {
            text-align: center;
        }
        .icon-box {
            margin: 0 auto 10px;
        }
    }
</style>
@endsection
