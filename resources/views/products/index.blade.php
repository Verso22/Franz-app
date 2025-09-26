@extends('layouts.app')  
{{-- 🧩 This means: "use the layout from layouts/app.blade.php" --}}

@section('content')  
{{-- 🧩 Everything inside here will be placed into the @yield('content') in the layout --}}

    <h1>All Products</h1>
    <!-- 🧩 Wrap the whole products list inside a Bootstrap card -->
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">📦 All Products</h2>
        </div>
        <div class="card-body">
        {{-- Success message --}}

    {{-- 🧩 Success message after adding/updating/deleting --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 🧩 Top action buttons (only appear once, above the table) --}}
    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">+ Add New Product</a>
    <a href="{{ route('products.trash') }}" class="btn btn-secondary mb-3">🗑️ View Trash Bin</a>

    <!-- 🧩 Table to show all products -->
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Expiry Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->brand }}</td>
                    <td>{{ $product->expiry_date }}</td>
                    <td>
                        <!-- 🧩 Edit button (yellow small button) -->
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <!-- 🧩 Delete button (red small button) -->
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <!-- 🧩 If there are no products, show this -->
                <tr>
                    <td colspan="8" class="text-center">No products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
        <!-- 🧩 NEW: Trash Bin button placed at the bottom of the table -->
    <!-- This gives the user another shortcut to view deleted products -->
    <a href="{{ route('products.trash') }}" class="btn btn-secondary mt-3">🗑️ View Trash Bin</a>
        <!-- 🧩 NEW: Back to Home button (helps user return to homepage) -->
    <a href="{{ url('/') }}" class="btn btn-light mt-2">🏠 Back to Home</a>
    </div>
</div>    

@endsection
