<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\IsAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Think of this file as your app’s map 🗺️
| Every route here defines what page a URL should show.
|--------------------------------------------------------------------------
*/

// 🏠 Redirect home ("/") to the dashboard (main landing page)
Route::get('/', function () {
    return redirect()->route('dashboard');
});


// ==============================================
// 🧭 Dashboard Route
// ==============================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


// ==============================================
// 🛍️ Products Routes (with role protection)
// ==============================================

// 🧾 Public routes (both admin + employee can see)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// ⚙️ Admin-only routes (protected by middleware)
Route::middleware([IsAdmin::class])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // 🗂️ Trash management
    Route::get('/products/trash', [ProductController::class, 'trash'])->name('products.trash');
    Route::patch('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('/products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
});


// ==============================================
// 👥 Employees Page (Admin only)
// ==============================================
Route::middleware([IsAdmin::class])->group(function () {
    Route::get('/employees', function () {
        return view('employees');
    })->name('employees');
});


// ==============================================
// 💰 Transactions Page (accessible to both)
// ==============================================
Route::get('/transactions', function () {
    return view('transactions');
})->name('transactions');


// ==============================================
// 📈 Reports Page (accessible to both)
// ==============================================
Route::get('/reports', function () {
    return view('reports');
})->name('reports');
