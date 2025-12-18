<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EmployeeController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Redirect home to dashboard
Route::get('/', [HomeController::class, 'index'])->name('home');

// ==============================================
// 🔐 Authentication (PUBLIC)
// ==============================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ==============================================
// 🔓 Routes that REQUIRE login (ALL ROLES)
// ==============================================
Route::middleware('auth')->group(function () {

    // Logout (ALL ROLES)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==============================================
    // 👤 Profile (ALL ROLES)
    // ==============================================
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])
        ->name('profile.update');

    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])
        ->name('profile.updatePassword');

    // ==============================================
    // 🛍️ Storefront (ALL ROLES)
    // ==============================================
    Route::get('/store', [StoreController::class, 'index'])->name('store.index');
    Route::get('/store/{product}', [StoreController::class, 'show'])->name('store.show');

    // ==============================================
    // 🛒 Cart (CUSTOMER / EMPLOYEE / ADMIN)
    // ==============================================
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // ==============================================
    // 📦 Products (VIEW ONLY – ALL ROLES)
    // ==============================================
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // ==============================================
    // 💰 Transactions (VIEW)
    // ==============================================
    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions.index');

    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])
        ->name('transactions.show');

    // ==============================================
    // 📈 Reports (VIEW)
    // ==============================================
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])
        ->name('reports.export.pdf');
});

// ==============================================
// 🔒 ADMIN-ONLY ROUTES
// ==============================================
Route::middleware([IsAdmin::class])->group(function () {

    // ==============================================
    // 📦 Products Management
    // ==============================================
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->name('products.destroy');

    Route::get('/products/trash', [ProductController::class, 'trash'])->name('products.trash');
    Route::patch('/products/{id}/restore', [ProductController::class, 'restore'])
        ->name('products.restore');
    Route::delete('/products/{id}/force-delete', [ProductController::class, 'forceDelete'])
        ->name('products.forceDelete');

    // ==============================================
    // 👥 Employees Management (ADMIN ONLY)
    // ==============================================
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])
        ->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])
        ->name('employees.store');

    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])
        ->name('employees.edit');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])
        ->name('employees.update');

    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])
        ->name('employees.destroy');

    Route::get('/employees/trash', [EmployeeController::class, 'trash'])
        ->name('employees.trash');

    Route::patch('/employees/{id}/restore', [EmployeeController::class, 'restore'])
        ->name('employees.restore');
});
