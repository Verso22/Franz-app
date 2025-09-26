<?php

use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| These are the "roads" (URLs) of your app.
| When someone visits a URL, Laravel decides what should happen.
| Think of it like a big map for your website 🚗🗺️
*/

// 🏠 Redirect home ("/") to the products list
Route::get('/', function () {
    return redirect()->route('products.index');
});

// 📋 Show all products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// ➕ Show the "Add New Product" form
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// 💾 Save a new product (this runs when you press "Save" on the form)
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// ✏️ Show the "Edit Product" form
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

// 🔄 Update a product (this runs when you press "Update" on the form)
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

// 🗑️ Soft delete a product (moves it to trash)
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// 🗂️ Show all products that are in the trash
Route::get('/products/trash', [ProductController::class, 'trash'])->name('products.trash');

// 🔙 Restore a product from trash
Route::patch('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');

// 🚮 Permanently delete a product from trash (optional)
Route::delete('/products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
