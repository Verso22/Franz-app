{{-- ============================================== --}}
{{-- File: resources/views/transactions.blade.php --}}
{{-- Purpose: Transactions page (REAL DATA + Search & Filters) --}}
{{-- ============================================== --}}

@extends('layouts.app')
@section('title', 'Transactions')

@section('content')
<div class="container-fluid py-4">

    {{-- 🧱 Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Transactions</h2>
    </div>

    {{-- 🔍 SEARCH & FILTER --}}
    <form method="GET" action="{{ route('transactions.index') }}" class="mb-4">
        <div class="row g-3 align-items-end">

            {{-- Search by customer --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Search Customer</label>
                <input
                    type="text"
                    name="q"
                    class="form-control"
                    placeholder="Customer name..."
                    value="{{ request('q') }}"
                >
            </div>

            {{-- Status --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            {{-- Date --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold">Date</label>
                <input
                    type="date"
                    name="date"
                    class="form-control"
                    value="{{ request('date') }}"
                >
            </div>

            {{-- Buttons --}}
            <div class="col-md-2 d-grid gap-2">
                <button class="btn btn-primary">
                    Apply
                </button>

                @if(request()->hasAny(['q', 'status', 'date']))
                    <a href="{{ route('transactions.index') }}"
                       class="btn btn-outline-secondary">
                        Clear
                    </a>
                @endif
            </div>

        </div>
    </form>

    {{-- 💳 Summary Cards --}}
    <div class="row g-3 mb-4">

        {{-- Total Sales --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary text-white rounded-3 p-3 me-3">
                        <i class="bi bi-cash-coin fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ rupiah($totalSales) }}</h5>
                        <small class="text-muted">Total Sales</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Completed --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-success text-white rounded-3 p-3 me-3">
                        <i class="bi bi-cart-check fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $completedCount }}</h5>
                        <small class="text-muted">Completed</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-warning text-white rounded-3 p-3 me-3">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $pendingCount }}</h5>
                        <small class="text-muted">Pending</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cancelled --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-danger text-white rounded-3 p-3 me-3">
                        <i class="bi bi-x-circle fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $cancelledCount }}</h5>
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
                        @forelse($transactions as $index => $transaction)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $transaction->user->name ?? 'Unknown' }}</td>
                                <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                                <td>{{ rupiah($transaction->total_amount) }}</td>

                                <td>
                                    @if($transaction->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($transaction->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>

                                <td>{{ strtoupper($transaction->payment_method) }}</td>

                                <td>
                                    <a href="{{ route('transactions.show', $transaction) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
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
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.table td, .table th {
    color: #333;
}
</style>
@endsection
