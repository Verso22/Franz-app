<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;

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
// 🛍️ Customer Storefront
// ==============================================
Route::get('/store', [StoreController::class, 'index'])
    ->name('store.index');

// ==============================================
// 🛒 Cart Routes (Customer only)
// ==============================================
Route::post('/cart/add/{product}', [CartController::class, 'add'])
    ->name('cart.add');

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

// ==============================
// 🔐 Authentication Routes
// ==============================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\ProfileController;

// ==============================================
// 👤 Profile Page (all users can access)
// ==============================================
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
