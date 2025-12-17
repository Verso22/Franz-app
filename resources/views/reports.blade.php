{{-- ============================================== --}}
{{-- File: resources/views/reports.blade.php --}}
{{-- Purpose: Reports & Analytics (REAL DATA + Charts + Table + Date Filter + PDF Export) --}}
{{-- ============================================== --}}

@extends('layouts.app')
@section('title', 'Reports')

@section('content')
<div class="container-fluid py-4">

    {{-- 🧭 Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Reports & Analytics</h2>

        {{-- 📄 Export PDF --}}
        <a href="{{ route('reports.export.pdf', request()->only(['from','to'])) }}"
           class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-file-earmark-pdf me-2"></i> Export PDF
        </a>
    </div>

    {{-- 📅 DATE FILTER --}}
    <form method="GET" action="{{ route('reports') }}" class="mb-4">
        <div class="row g-3 align-items-end">

            <div class="col-md-3">
                <label class="form-label fw-semibold">From</label>
                <input type="date"
                       name="from"
                       class="form-control"
                       value="{{ request('from') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">To</label>
                <input type="date"
                       name="to"
                       class="form-control"
                       value="{{ request('to') }}">
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100">Apply</button>

                @if(request()->hasAny(['from','to']))
                    <a href="{{ route('reports') }}"
                       class="btn btn-outline-secondary w-100">
                        Clear
                    </a>
                @endif
            </div>

        </div>
    </form>

    {{-- 💰 KPI Summary Cards --}}
    <div class="row g-3 mb-4">

        {{-- Total Revenue --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 text-center kpi-card">
                <h6 class="text-muted mb-1">Total Revenue</h6>
                <h4 class="fw-bold text-primary mb-0">
                    {{ rupiah($totalRevenue) }}
                </h4>
                <small class="text-muted">Completed transactions</small>
            </div>
        </div>

        {{-- Placeholders --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 text-center kpi-card">
                <h6 class="text-muted mb-1">Total Profit</h6>
                <h4 class="fw-bold text-success mb-0">—</h4>
                <small class="text-muted">Coming soon</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 text-center kpi-card">
                <h6 class="text-muted mb-1">Expenses</h6>
                <h4 class="fw-bold text-danger mb-0">—</h4>
                <small class="text-muted">Coming soon</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 text-center kpi-card">
                <h6 class="text-muted mb-1">Monthly Growth</h6>
                <h4 class="fw-bold text-warning mb-0">—</h4>
                <small class="text-muted">Coming soon</small>
            </div>
        </div>

    </div>

    {{-- 📈 Charts --}}
    <div class="row g-4 align-items-stretch">

        {{-- Monthly Sales --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0 p-3 h-100">
                <h5 class="fw-semibold mb-3">📈 Monthly Sales Trend</h5>
                <canvas id="salesChart" height="150"></canvas>
            </div>
        </div>

        {{-- Category Chart --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center h-100">
                <h5 class="fw-semibold mb-3">🏷️ Top Selling Categories</h5>
                <div style="max-width: 250px; margin: 0 auto;">
                    <canvas id="categoryChart" height="250"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- 📋 Transactions Table --}}
    <div class="card mt-5 shadow-sm border-0">
        <div class="card-body">

            <h5 class="fw-bold mb-3">📋 Transaction Details</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $index => $transaction)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $transaction->user->name ?? 'Unknown' }}</td>
                                <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                                <td>{{ rupiah($transaction->total_amount) }}</td>
                                <td>{{ strtoupper($transaction->payment_method) }}</td>
                                <td>
                                    @if($transaction->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($transaction->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: @json($salesLabels),
            datasets: [{
                data: @json($salesData),
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: @json($categoryLabels),
            datasets: [{
                data: @json($categoryData),
                backgroundColor: [
                    '#0d6efd',
                    '#198754',
                    '#ffc107',
                    '#dc3545',
                    '#6c757d'
                ]
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } },
            cutout: '60%'
        }
    });

});
</script>

<style>
.kpi-card {
    border-radius: 12px;
    transition: all 0.3s ease;
}
.kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
}
</style>
@endsection
