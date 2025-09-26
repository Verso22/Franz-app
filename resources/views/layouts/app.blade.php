<!DOCTYPE html>
<html>
<head>
    <title>My Product App</title>
    <!-- 🧩 This line pulls Bootstrap from the internet (CSS library that makes things look nice) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <!-- 🧩 Big title for your app -->
    <h1 class="mb-4">My Product App</h1>

    <!-- 🧩 This is where each page’s unique content will go -->
    @yield('content')
</body>
</html>
