{{-- ============================================== --}}
{{-- File: resources/views/layouts/public.blade.php --}}
{{-- Purpose: PUBLIC layout (Homepage, Storefront, Customer pages) --}}
{{-- ============================================== --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyStore')</title>

    {{-- Assets --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* ================= Base ================= */
body {
    background-color: #f9fafb;
    font-family: 'Poppins', sans-serif;
    margin: 0;
}

/* ================= Navbar ================= */
.navbar {
    background-color: #ffffff;
    border-bottom: 1px solid #e5e7eb;
    padding: 0.75rem 1.5rem;
}

.navbar-brand {
    font-weight: 600;
    font-size: 1.3rem;
}

.nav-link {
    font-weight: 500;
    color: #374151;
}

.nav-link:hover {
    color: #0d6efd;
}

/* Cart icon */
.cart-link {
    position: relative;
    font-size: 1.25rem;
}

/* ================= Main Content ================= */
main {
    min-height: 70vh;
}

/* ================= Footer ================= */
footer {
    border-top: 1px solid #e5e7eb;
    padding: 1.5rem 0;
    margin-top: 4rem;
    color: #6b7280;
    background: #ffffff;
}

/* ================= Toast ================= */
.toast-message {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    padding: 12px 20px;
    border-radius: 12px;
    color: #fff;
    display: none;
    z-index: 2000;
    font-weight: 500;
}

.toast-message.show {
    display: flex;
}

.toast-message.bg-success { background: #198754; }
.toast-message.bg-danger { background: #dc3545; }
</style>
</head>

<body>

{{-- ================= NAVBAR ================= --}}
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">

        {{-- Brand --}}
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-shop"></i> MyStore
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#publicNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="publicNavbar">
            <ul class="navbar-nav ms-auto align-items-center gap-3">

                {{-- Store --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('store.index') }}">
                        Store
                    </a>
                </li>

                {{-- Auth --}}
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm px-3" href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @else
                    {{-- Cart --}}
                    <li class="nav-item">
                        <a class="nav-link cart-link" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart"></i>
                        </a>
                    </li>

                    {{-- Profile --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile') }}">
                            <i class="bi bi-person"></i> Profile
                        </a>
                    </li>

                    {{-- Logout --}}
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm px-3">
                                Logout
                            </button>
                        </form>
                    </li>
                @endguest

            </ul>
        </div>
    </div>
</nav>

{{-- ================= CONTENT ================= --}}
<main class="container-fluid px-4 py-4">
    @yield('content')
</main>

{{-- ================= FOOTER ================= --}}
<footer class="text-center">
    <div class="container">
        <small>© {{ date('Y') }} MyStore. All rights reserved.</small>
    </div>
</footer>

{{-- ================= TOAST ================= --}}
<div id="toastMessage" class="toast-message"></div>

<script>
@if(session('success'))
    showToast("{{ session('success') }}", "success");
@endif

@if(session('danger'))
    showToast("{{ session('danger') }}", "danger");
@endif

function showToast(msg, type) {
    const t = document.getElementById('toastMessage');
    t.textContent = msg;
    t.className = 'toast-message show bg-' + type;
    setTimeout(() => t.classList.remove('show'), 3000);
}
</script>

</body>
</html>
