<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| App route map 🗺️
|--------------------------------------------------------------------------
*/

// 🏠 Redirect home to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ==============================================
// 🧭 Dashboard
// ==============================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// ==============================================
// 🛍️ Customer Storefront (PUBLIC)
// ==============================================
Route::get('/store', [StoreController::class, 'index'])
    ->name('store.index');

Route::get('/store/{product}', [StoreController::class, 'show'])
    ->name('store.show');

// ==============================================
// 🛒 Cart Routes (CUSTOMER — MUST LOGIN)
// ==============================================
Route::middleware('auth')->group(function () {

    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/add/{product}', [CartController::class, 'add'])
        ->name('cart.add');

    Route::patch('/cart/update/{item}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])
        ->name('cart.remove');

    Route::post('/cart/checkout', [CartController::class, 'checkout'])
        ->name('cart.checkout');
});

// ==============================================
// 🛍️ Products (Admin & Employee)
// ==============================================
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

// ⚙️ Admin-only product management
Route::middleware([IsAdmin::class])->group(function () {

    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');

    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');

    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->name('products.update');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->name('products.destroy');

    // 🗂️ Trash
    Route::get('/products/trash', [ProductController::class, 'trash'])
        ->name('products.trash');

    Route::patch('/products/{id}/restore', [ProductController::class, 'restore'])
        ->name('products.restore');

    Route::delete('/products/{id}/force-delete', [ProductController::class, 'forceDelete'])
        ->name('products.forceDelete');
});

// ==============================================
// 👥 Employees (Admin only)
// ==============================================
Route::middleware([IsAdmin::class])->group(function () {
    Route::get('/employees', function () {
        return view('employees');
    })->name('employees');
});

// ==============================================
// 💰 Transactions
// ==============================================
Route::get('/transactions', [TransactionController::class, 'index'])
    ->name('transactions.index');

Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])
    ->name('transactions.show');

// ==============================================
// 📈 Reports
// ==============================================
Route::get('/reports', function () {
    return view('reports');
})->name('reports');

// ==============================================
// 🔐 Authentication
// ==============================================
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// ==============================================
// 👤 Profile
// ==============================================
Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile');

Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])
    ->name('profile.updatePassword');
