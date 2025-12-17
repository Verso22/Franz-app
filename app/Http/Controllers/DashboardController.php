<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * 📊 Dashboard with REAL metrics
     */
    public function index()
    {
        // Products
        $totalProducts = Product::count();

        // Employees (exclude customers if role exists)
        $totalEmployees = User::where('role', 'employee')->count();

        // Transactions
        $totalTransactions = Transaction::count();

        // Total Sales (only completed)
        $totalSales = Transaction::where('status', 'completed')
            ->sum('total_amount');
        
        $lowStockProducts = Product::where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalEmployees',
            'totalTransactions',
            'totalSales',
            'lowStockProducts'
        ));
    }
}
