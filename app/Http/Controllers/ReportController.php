<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * 📊 Reports & Analytics (REAL DATA)
     */
    public function index(Request $request)
    {
        // Optional date filters
        $from = $request->query('from');
        $to   = $request->query('to');

        // =========================
        // BASE TRANSACTION QUERY
        // =========================
        $transactionsQuery = Transaction::query()
            ->where('status', 'completed');

        if ($from) {
            $transactionsQuery->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $transactionsQuery->whereDate('created_at', '<=', $to);
        }

        $transactions = $transactionsQuery->get();

        // =========================
        // KPI METRICS
        // =========================
        $totalRevenue = $transactions->sum('total_amount');

        // =========================
        // MONTHLY SALES (LINE CHART)
        // =========================
        $monthlySales = Transaction::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('status', 'completed')
            ->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('created_at', '<=', $to))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $salesLabels = $monthlySales->map(function ($row) {
            return date('M', mktime(0, 0, 0, $row->month, 1));
        });

        $salesData = $monthlySales->pluck('total');

        // =========================
        // TOP CATEGORIES (DOUGHNUT)
        // =========================
        $categorySales = DB::table('transaction_items')
            ->join('products', 'products.id', '=', 'transaction_items.product_id')
            ->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->where('transactions.status', 'completed')
            ->when($from, fn ($q) => $q->whereDate('transactions.created_at', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('transactions.created_at', '<=', $to))
            ->select(
                'products.category',
                DB::raw('SUM(transaction_items.quantity * transaction_items.price) as total')
            )
            ->whereNotNull('products.category')
            ->groupBy('products.category')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $categoryLabels = $categorySales->pluck('category');
        $categoryData   = $categorySales->pluck('total');

        // =========================
        // SEND TO VIEW
        // =========================
        return view('reports', compact(
            'totalRevenue',
            'salesLabels',
            'salesData',
            'categoryLabels',
            'categoryData',
            'transactions'
        ));
    }

    /**
     * 📄 Export Reports to PDF (REAL PDF)
     */
    public function exportPdf(Request $request)
    {
        $from = $request->query('from');
        $to   = $request->query('to');

        $transactions = Transaction::where('status', 'completed')
            ->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('created_at', '<=', $to))
            ->with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $transactions->sum('total_amount');

        $pdf = Pdf::loadView('reports.pdf', compact(
            'transactions',
            'totalRevenue',
            'from',
            'to'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('sales-report.pdf');
    }
}
