@extends('layouts.app')  
{{-- 🧩 This means: use the layout so Bootstrap is loaded --}}

@section('content')
    <h2>{{ isset($product) ? 'Edit Product' : 'Add New Product' }}</h2>

    {{-- 🧩 Show validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <!-- 🧩 NEW: Navigation buttons -->
    <a href="{{ route('products.index') }}" class="btn btn-primary mb-3">← Back to Product List</a>
    <a href="{{ url('/') }}" class="btn btn-light mb-3">🏠 Back to Home</a>

        {{-- 🧩 Form changes depending on Add vs Edit --}}
    <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST">

        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <!-- 🧩 Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" 
                    value="{{ old('name', $product->name ?? '') }}" required>
            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- 🧩 Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- 🧩 Stock -->
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" 
                    value="{{ old('stock', $product->stock ?? '') }}" required>
        </div>

        <!-- 🧩 Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" 
                    value="{{ old('price', $product->price ?? '') }}" required>
        </div>

        <!-- 🧩 Category -->
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" name="category" class="form-control" 
                    value="{{ old('category', $product->category ?? '') }}">
        </div>

        <!-- 🧩 Brand -->
        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" name="brand" class="form-control" 
                    value="{{ old('brand', $product->brand ?? '') }}">
        </div>

        <!-- 🧩 Expiry Date -->
        <div class="mb-3">
            <label for="expiry_date" class="form-label">Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control" 
                    value="{{ old('expiry_date', $product->expiry_date ?? '') }}">
        </div>

        <!-- 🧩 Buttons -->
        <button type="submit" class="btn btn-success">
            {{ isset($product) ? 'Update' : 'Save' }}
        </button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
