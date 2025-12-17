<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * 📄 Transactions list (Admin & Employee)
     */
    public function index(Request $request)
    {
        // Filters
        $search = $request->query('q');
        $status = $request->query('status');
        $date   = $request->query('date');

        // Base query
        $query = Transaction::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc');

        // 🔍 Search by customer name
        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // 🏷️ Status filter
        if ($status) {
            $query->where('status', $status);
        }

        // 📅 Date filter
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        // Execute query
        $transactions = $query->get();

        // Summary statistics (REAL DATA)
        $totalSales = $transactions->sum('total_amount');

        $completedCount = $transactions->where('status', 'completed')->count();
        $pendingCount   = $transactions->where('status', 'pending')->count();
        $cancelledCount = $transactions->where('status', 'cancelled')->count();

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
