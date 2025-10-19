{{-- ============================================== --}}
{{-- File: resources/views/reports.blade.php --}}
{{-- Purpose: Reports and Analytics (mock data + KPIs + charts) --}}
{{-- ============================================== --}}

@extends('layouts.app')
@section('title', 'Reports')

@section('content')
<div class="container-fluid py-4">
    {{-- 🧭 Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Reports & Analytics</h2>
        <button class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-download me-2"></i> Export Report
        </button>
    </div>

    {{-- 💰 KPI Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 text-center kpi-card">
                <h6 class="text-muted mb-1">Total Revenue</h6>
                <h4 class="fw-bold text-primary mb-0">Rp 250M</h4>
                <small class="text-success"><i class="bi bi-graph-up-arrow"></i> +8.2% this month</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 text-center kpi-card">
                <h6 class="text-muted mb-1">Total Profit</h6>
                <h4 class="fw-bold text-success mb-0">Rp 98M</h4>
                <small class="text-success"><i class="bi bi-cash-stack"></i> +12.4%</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 text-center kpi-card">
                <h6 class="text-muted mb-1">Expenses</h6>
                <h4 class="fw-bold text-danger mb-0">Rp 45M</h4>
                <small class="text-danger"><i class="bi bi-arrow-down-circle"></i> -2.3%</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 text-center kpi-card">
                <h6 class="text-muted mb-1">Monthly Growth</h6>
                <h4 class="fw-bold text-warning mb-0">+5.7%</h4>
                <small class="text-muted">vs last month</small>
            </div>
        </div>
    </div>

    {{-- 📈 Charts Section --}}
    <div class="row g-4 align-items-stretch">
        {{-- Sales Chart --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0 p-3 h-100">
                <h5 class="fw-semibold mb-3">📈 Monthly Sales Trend</h5>
                <canvas id="salesChart" height="150"></canvas>
            </div>
        </div>

        {{-- Category Chart (smaller now) --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center h-100">
                <h5 class="fw-semibold mb-3">🏷️ Top Selling Categories</h5>
                <div style="max-width: 250px; margin: 0 auto;">
                    <canvas id="categoryChart" height="250" width="250"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // 🧭 Sales Chart
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Sales (Rp)',
                data: [12000000, 15000000, 9000000, 20000000, 18000000, 25000000],
                borderWidth: 2,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: '#0d6efd'
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // 🏷️ Category Chart (smaller doughnut)
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: ['Food', 'Beverages', 'Snacks', 'Hygiene', 'Household'],
            datasets: [{
                data: [40, 25, 15, 10, 10],
                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d']
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            },
            cutout: '60%' // makes the chart more compact
        }
    });
});
</script>

{{-- 💅 Styles --}}
<style>
.kpi-card {
    border-radius: 12px;
    transition: all 0.3s ease;
}
.kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
}
.card h5 {
    color: #333;
}
</style>
@endsection
