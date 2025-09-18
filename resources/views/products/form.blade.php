<!DOCTYPE html>
<html>
<head>
    <title>{{ $product ? 'Edit Product' : 'Add Product' }}</title>
</head>
<body>
    <h1>{{ $product ? 'Edit Product' : 'Add Product' }}</h1>

    {{-- Show validation errors --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($product)
        {{-- Edit form --}}
        <form method="POST" action="{{ route('products.update', $product->id) }}">
            @method('PUT')
    @else
        {{-- Create form --}}
        <form method="POST" action="{{ route('products.store') }}">
    @endif
        @csrf

        <label>Name:</label><br>
        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"><br><br>

        @error('name')
            <p style="color:red">{{ $message }}</p>
        @enderror

        <label>Description:</label><br>
        <textarea name="description">{{ old('description', $product->description ?? '') }}</textarea><br><br>

        <label>Stock:</label><br>
        <input type="number" name="stock" value="{{ old('stock', $product->stock ?? '') }}"><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}"><br><br>

        <label>Category:</label><br>
        <input type="text" name="category" value="{{ old('category', $product->category ?? '') }}"><br><br>

        <label>Brand:</label><br>
        <input type="text" name="brand" value="{{ old('brand', $product->brand ?? '') }}"><br><br>

        <label>Expiry Date:</label><br>
        <input type="date" name="expiry_date" value="{{ old('expiry_date', $product->expiry_date ?? '') }}"><br><br>

        <button type="submit">{{ $product ? 'Update' : 'Save' }}</button>
    </form>

    <br>
    <a href="{{ route('products.index') }}">← Back to List</a>
</body>
</html>
