{{-- ============================================== --}}
{{-- File: resources/views/layouts/app.blade.php --}}
{{-- Purpose: Dark modern dashboard layout with collapsible sidebar --}}
{{-- ============================================== --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> {{-- Sets character encoding --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> {{-- Makes it mobile-friendly --}}
    <title>@yield('title', 'Store Management App')</title> {{-- Dynamic tab title --}}

    {{-- ✅ Load Laravel’s compiled CSS & JS using Vite --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- ✅ Bootstrap Icons for sidebar and UI elements --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    {{-- ✅ Custom inline styles for layout structure --}}
<style>
/* ------------------------------
Basic page styles
------------------------------ */
body {
    background-color: #f8f9fa;
    font-family: 'Poppins', sans-serif;
    margin: 0;
}

/* ------------------------------
Sidebar container
------------------------------ */
#sidebar {
    width: 240px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #1e1e2f;
    color: #ffffff;
    transition: width 0.25s ease, padding 0.25s ease;
    display: flex;
    flex-direction: column;
    padding: 0.6rem 0;
}
#sidebar.collapsed {
    width: 70px;
    padding: 0.35rem 0;
}

/* ------------------------------
Shared sidebar link styling
------------------------------ */
#sidebar .nav-link {
    color: #adb5bd;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 18px;
    font-size: 0.95rem;
    text-decoration: none;
    transition: background-color 0.2s ease, color 0.2s ease; /* 🪄 smooth hover transition */
    white-space: nowrap;
}
#sidebar .nav-link i {
    font-size: 1.35rem;
    min-width: 33px;
    text-align: center;
    line-height: 1;
    display: inline-block;
}
#sidebar .nav-link:hover {
    background-color: #2b2b3a;
    color: #ffffff;
}

#sidebar .nav-link:focus {
    background-color: #2b2b3a;
    color: #ffffff;
    text-decoration: none;
}

/* ------------------------------
MyStore header (inherits nav-link layout)
------------------------------ */
.sidebar-header .nav-link {
    color: #ffffff;
    font-weight: 600;
}
.sidebar-header .nav-link:hover {
    background-color: transparent; /* keep static header clean */
}

/* ------------------------------
Collapsed behavior
------------------------------ */
#sidebar.collapsed .sidebar-text {
    display: none;
}
#sidebar.collapsed .nav-link {
    justify-content: center;
    padding: 10px 0;
}
#sidebar.collapsed .nav-link i {
    font-size: 1.55rem;
    min-width: 0;
}

/* ------------------------------
Logout area pinned bottom
------------------------------ */
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
Content & navbar
------------------------------ */
#content {
    margin-left: 240px;
    transition: margin-left 0.25s ease;
    padding-top: 0;
}
#sidebar.collapsed + #content {
    margin-left: 70px;
}
.navbar {
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
    padding: 0.5rem 1rem;
}

/* ------------------------------
Responsive
------------------------------ */
@media (max-width: 768px) {
    #sidebar {
        position: fixed;
        z-index: 1040;
    }
    #content {
        margin-left: 0;
    }

    /* ✅ Highlight the active sidebar link */
#sidebar .nav-link.active {
    background-color: #343a40 !important; /* darker highlight background */
    color: #ffffff !important;             /* white text for active state */
    font-weight: 600;                      /* make text slightly bolder */
}

/* Optional: icon inside active link also turns white */
#sidebar .nav-link.active i {
    color: #ffffff !important;
}

}
</style>

</head>

<body>
{{-- ✅ Sidebar Section --}}
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

    {{-- 👥 Employees --}}
    <li>
        <a href="{{ route('employees') }}" 
            class="nav-link {{ request()->routeIs('employees') ? 'active' : '' }}">
            <i class="bi bi-people"></i> 
            <span class="sidebar-text">Employees</span>
        </a>
    </li>

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

    {{-- ✅ Logout at bottom --}}
    <div class="mt-auto">
        <a href="#" class="nav-link text-danger"><i class="bi bi-box-arrow-right"></i> <span class="sidebar-text">Logout</span></a>
    </div>
</div>


    {{-- ✅ Main Content Section --}}
    <div id="content">
        {{-- Top Navbar --}}
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                {{-- Toggle Sidebar Button --}}
                <button class="btn btn-outline-secondary" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>

                {{-- User Info --}}
                <div class="ms-auto d-flex align-items-center">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <span>Welcome, Admin</span>
                </div>
            </div>
        </nav>

        {{-- Page Content --}}
        <main class="container-fluid mt-4">
            @yield('content') {{-- This is where each page’s content goes --}}
        </main>
    </div>

    {{-- ✅ Sidebar Toggle Script --}}
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        // When button is clicked, collapse or expand the sidebar
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
</body>
</html>
