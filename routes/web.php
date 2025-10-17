<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
    // Loads resources/views/dashboard.blade.php
    return view('dashboard');
})->name('dashboard');


// ==============================================
// 🛍️ Products Routes (CRUD logic)
// ==============================================
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/trash', [ProductController::class, 'trash'])->name('products.trash');
Route::patch('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
Route::delete('/products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');


// ==============================================
// 👥 Employees Page (UI only for now)
// ==============================================
Route::get('/employees', function () {
    return view('employees');
})->name('employees');


// ==============================================
// 💰 Transactions Page (UI only for now)
// ==============================================
Route::get('/transactions', function () {
    return view('transactions');
})->name('transactions');


// ==============================================
// 📈 Reports Page (UI only for now)
// ==============================================
Route::get('/reports', function () {
    return view('reports');
})->name('reports');
