<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pick a Movie by Mood</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 d-flex flex-column">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">Pick a Movie</a>
            <div>
                <!-- Tambahkan link navigasi lain jika perlu -->
            </div>
        </div>
    </nav>
    <main class="flex-fill">
        @yield('content')
    </main>
    <footer class="bg-white mt-4 py-3 shadow-sm text-center text-muted">
        &copy; {{ date('Y') }} Pick a Movie by Mood
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    </body>
</html>