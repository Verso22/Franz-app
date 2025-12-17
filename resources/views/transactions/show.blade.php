{{-- ============================================== --}}
{{-- File: resources/views/transactions/show.blade.php --}}
{{-- Purpose: Transaction Detail Page (REAL DATA) --}}
{{-- ============================================== --}}

@extends('layouts.app')
@section('title', 'Transaction Detail')

@section('content')
<div class="container-fluid py-4">

    {{-- 🔙 Back Button --}}
    <a href="{{ route('transactions.index') }}"
       class="btn btn-sm btn-outline-secondary mb-4">
        ← Back to Transactions
    </a>

    {{-- 🧾 Transaction Header --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <div class="row g-3">
                <div class="col-md-4">
                    <h6 class="text-muted mb-1">Customer</h6>
                    <div class="fw-semibold">
                        {{ $transaction->user->name ?? 'Unknown' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <h6 class="text-muted mb-1">Transaction Date</h6>
                    <div class="fw-semibold">
                        {{ $transaction->created_at->format('Y-m-d H:i') }}
                    </div>
                </div>

                <div class="col-md-4">
                    <h6 class="text-muted mb-1">Payment Method</h6>
                    <div class="fw-semibold">
                        {{ strtoupper($transaction->payment_method) }}
                    </div>
                </div>
            </div>

            <hr>

            <div class="row g-3">
                <div class="col-md-4">
                    <h6 class="text-muted mb-1">Status</h6>
                    @if($transaction->status === 'completed')
                        <span class="badge bg-success">Completed</span>
                    @elseif($transaction->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @else
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </div>

                <div class="col-md-4">
                    <h6 class="text-muted mb-1">Total Items</h6>
                    <div class="fw-semibold">
                        {{ $transaction->items->sum('quantity') }}
                    </div>
                </div>

                <div class="col-md-4">
                    <h6 class="text-muted mb-1">Total Amount</h6>
                    <div class="fw-bold fs-5">
                        {{ rupiah($transaction->total_amount) }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- 📦 Transaction Items --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Purchased Items</h5>

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th width="120">Quantity</th>
                            <th width="150">Price</th>
                            <th width="150">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->product->name ?? 'Product deleted' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ rupiah($item->price) }}</td>
                                <td>{{ rupiah($item->quantity * $item->price) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
