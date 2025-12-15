<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * 📄 Transactions list (Admin & Employee)
     */
    public function index()
    {
        // Get all transactions with user + items
        $transactions = Transaction::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Summary statistics (REAL DATA)
        $totalSales = $transactions->sum('total_amount');

        $completedCount = $transactions
            ->where('status', 'completed')
            ->count();

        $pendingCount = $transactions
            ->where('status', 'pending')
            ->count();

        $cancelledCount = $transactions
            ->where('status', 'cancelled')
            ->count();

        return view('transactions', compact(
            'transactions',
            'totalSales',
            'completedCount',
            'pendingCount',
            'cancelledCount'
        ));
    }

    /**
     * 👁 View single transaction detail
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'items.product']);

        return view('transactions.show', compact('transaction'));
    }
}
