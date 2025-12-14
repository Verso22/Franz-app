{{-- ============================================== --}}
{{-- File: resources/views/layouts/store.blade.php --}}
{{-- Purpose: Simple layout for customer storefront --}}
{{-- ============================================== --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Store')</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

{{-- 🔝 Simple Navbar --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('store.index') }}">
            🏪 MyStore
        </a>

        <div class="ms-auto">
            <span class="me-3 text-muted">
                Hello, {{ auth()->user()->name ?? 'Guest' }}
            </span>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-outline-danger btn-sm">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- 🧱 Page Content --}}
<main>
    @yield('content')
</main>

</body>
</html>
