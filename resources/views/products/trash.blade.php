@extends('layouts.app')

@section('content')
    <h2>🗑️ Trash Bin (Deleted Products)</h2>

    {{-- ✅ Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ✅ Back to product list --}}
    <a href="{{ route('products.index') }}" class="btn btn-primary mb-3">← Back to Product List</a>
        <!-- 🧩 NEW: Back to Home button (helps user return to homepage) -->
    <a href="{{ url('/') }}" class="btn btn-light mb-3">🏠 Back to Home</a>


    {{-- ✅ Table of trashed products --}}
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Deleted At</th>
                <th style="width:240px">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->brand }}</td>
                    <td>{{ $product->deleted_at }}</td>
                    <td>
                        {{-- 🔄 Restore --}}
                        <form action="{{ route('products.restore', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">
                                Restore
                            </button>
                        </form>

                        {{-- ❌ Force Delete --}}
                        <form action="{{ route('products.forceDelete', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('⚠️ Permanently delete this product? This cannot be undone!')">
                                Delete Permanently
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No trashed products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
