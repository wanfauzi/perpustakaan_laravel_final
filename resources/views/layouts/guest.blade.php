<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Perpustakaan') }}</title>

    <link rel="preconnect"
          href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700"
          rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">
</head>

<body class="bg-body-tertiary">

    <main class="min-vh-100 d-flex align-items-center justify-content-center p-3">

        <div class="w-100" style="max-width: 420px;">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4 p-md-5">

                    {{-- Identitas Aplikasi --}}
                    <div class="text-center mb-4">

                        <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-2"
                             style="width: 48px; height: 48px;">

                            <i class="bi bi-book-half fs-4"></i>

                        </div>

                        <h5 class="fw-bold mb-0">
                            Perpustakaan
                        </h5>

                    </div>

                    {{ $slot }}

                </div>

            </div>

        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>