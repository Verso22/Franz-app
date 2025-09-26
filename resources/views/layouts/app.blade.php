<!DOCTYPE html>
<html>
<head>
    <title>My Product App</title>
    <!-- 🧩 Load Bootstrap CSS (modern design) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <!-- 🧩 Big title for your app -->
    <h1 class="mb-4">My Product App</h1>

    <!-- 🧩 Load Bootstrap JS (for buttons, dropdowns, modals, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- 🧩 This is where each page’s unique content will go -->
    @yield('content')
</body>
</html>
