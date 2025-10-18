{{-- ============================================== --}}
{{-- File: resources/views/layouts/app.blade.php --}}
{{-- Purpose: Dark modern dashboard layout with collapsible sidebar + floating toast notifications + role-based sidebar --}}
{{-- ============================================== --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Store Management App')</title>

    {{-- ✅ Laravel + Bootstrap assets --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* ------------------------------
🌙 Basic Page Styles
------------------------------ */
body {
    background-color: #f8f9fa;
    font-family: 'Poppins', sans-serif;
    margin: 0;
}

/* ------------------------------
🧭 Sidebar Layout
------------------------------ */
#sidebar {
    width: 240px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #1e1e2f;
    color: #fff;
    transition: width 0.25s ease, padding 0.25s ease;
    display: flex;
    flex-direction: column;
    padding: 0.6rem 0;
}

#sidebar.collapsed {
    width: 70px;
    padding: 0.35rem 0;
}

/* Sidebar links */
#sidebar .nav-link {
    color: #adb5bd;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 18px;
    font-size: 0.95rem;
    text-decoration: none;
    transition: background-color 0.2s ease, color 0.2s ease;
    white-space: nowrap;
}
#sidebar .nav-link i {
    font-size: 1.35rem;
    min-width: 33px;
    text-align: center;
}
#sidebar .nav-link:hover {
    background-color: #2b2b3a;
    color: #fff;
}
#sidebar .nav-link.active {
    background-color: #343a40 !important;
    color: #fff !important;
    font-weight: 600;
}
#sidebar .nav-link.active i {
    color: #fff !important;
}

/* Sidebar header (MyStore logo area) */
.sidebar-header .nav-link {
    color: #fff;
    font-weight: 600;
}
.sidebar-header .nav-link:hover {
    background-color: transparent;
}

/* Collapsed behavior */
#sidebar.collapsed .sidebar-text {
    display: none;
}
#sidebar.collapsed .nav-link {
    justify-content: center;
    padding: 10px 0;
}
#sidebar.collapsed .nav-link i {
    font-size: 1.55rem;
}

/* Logout pinned bottom */
#sidebar .mt-auto {
    margin-top: auto;
    padding-top: 0.6rem;
    padding-bottom: 0.6rem;
    border-top: 1px solid #292933;
}
#sidebar .mt-auto .nav-link {
    padding-left: 18px;
}
#sidebar.collapsed .mt-auto .nav-link {
    justify-content: center;
    padding: 10px 0;
}

/* ------------------------------
📦 Content & Navbar
------------------------------ */
#content {
    margin-left: 240px;
    transition: margin-left 0.25s ease;
}
#sidebar.collapsed + #content {
    margin-left: 70px;
}
.navbar {
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.06);
    padding: 0.5rem 1rem;
}

/* ------------------------------
📱 Responsive
------------------------------ */
@media (max-width: 768px) {
    #sidebar {
        position: fixed;
        z-index: 1040;
    }
    #content {
        margin-left: 0;
    }
}

/* ------------------------------
💎 Floating Toast Notifications
------------------------------ */
.toast-message {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%) translateY(-20px);
    display: none;
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: 500;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    z-index: 2000;
    opacity: 0;
    transition: opacity 0.5s ease, transform 0.5s ease;
}
.toast-message.show {
    display: flex;
    align-items: center;
    gap: 10px;
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}
.toast-message.bg-success {
    background-color: #198754;
}
.toast-message.bg-danger {
    background-color: #dc3545;
}
</style>
</head>

<body>
{{-- ===================== Sidebar ===================== --}}
<div id="sidebar" class="d-flex flex-column p-3">
    <ul class="nav nav-pills flex-column mb-auto">

        {{-- 🏪 MyStore Header --}}
        <li class="sidebar-header mb-2">
            <a href="{{ route('dashboard') }}"
                class="nav-link sidebar-brand {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-shop"></i>
                <span class="sidebar-text fw-semibold">MyStore</span>
            </a>
        </li>

        {{-- 🧭 Dashboard --}}
        <li>
            <a href="{{ route('dashboard') }}"
                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </li>

        {{-- 📦 Products --}}
        <li>
            <a href="{{ route('products.index') }}"
                class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                <span class="sidebar-text">Products</span>
            </a>
        </li>

        {{-- 👥 Employees (Admin only) --}}
        @if(auth()->check() && auth()->user()->isAdmin())
        <li>
            <a href="{{ route('employees') }}"
                class="nav-link {{ request()->routeIs('employees') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span class="sidebar-text">Employees</span>
            </a>
        </li>
        @endif

        {{-- 🛒 Transactions --}}
        <li>
            <a href="{{ route('transactions') }}"
                class="nav-link {{ request()->routeIs('transactions') ? 'active' : '' }}">
                <i class="bi bi-cart"></i>
                <span class="sidebar-text">Transactions</span>
            </a>
        </li>

        {{-- 📈 Reports --}}
        <li>
            <a href="{{ route('reports') }}"
                class="nav-link {{ request()->routeIs('reports') ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i>
                <span class="sidebar-text">Reports</span>
            </a>
        </li>
    </ul>

    {{-- 🔴 Logout --}}
    <div class="mt-auto">
        <a href="#" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right"></i>
            <span class="sidebar-text">Logout</span>
        </a>
    </div>
</div>

{{-- ===================== Main Content ===================== --}}
<div id="content">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="btn btn-outline-secondary" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>
            <div class="ms-auto d-flex align-items-center">
                <i class="bi bi-person-circle fs-4 me-2"></i>
                <span>Welcome, {{ auth()->user()->name ?? 'User' }}</span>
            </div>
        </div>
    </nav>

    <main class="container-fluid mt-4">
        @yield('content')
    </main>
</div>

{{-- ===================== Floating Toast (New Notification System) ===================== --}}
<div id="toastMessage" class="toast-message">
    <i id="toastIcon" class="bi me-2"></i><span id="toastText"></span>
</div>

{{-- ===================== Scripts ===================== --}}
<script>
    // Sidebar Toggle
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
    });

    // Floating Toast Notifications
    document.addEventListener('DOMContentLoaded', function () {
        const toast = document.getElementById('toastMessage');
        const toastText = document.getElementById('toastText');
        const toastIcon = document.getElementById('toastIcon');

        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @elseif(session('danger'))
            showToast('{{ session('danger') }}', 'danger');
        @endif

        function showToast(message, type = 'success') {
            toastText.textContent = message;
            toastIcon.className = 'bi me-2 ' + (type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill');
            toast.classList.remove('bg-success', 'bg-danger');
            toast.classList.add(type === 'success' ? 'bg-success' : 'bg-danger');

            // Show toast
            toast.classList.add('show');
            toast.style.display = 'flex';

            // Hide after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.style.display = 'none', 600);
            }, 3000);
        }
    });
</script>

</body>
</html>
