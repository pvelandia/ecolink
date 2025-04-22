<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'EcoLink')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSS de Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Tu archivo CSS personalizado --}}
    <link rel="stylesheet" href="{{ asset('css/hogar.css') }}">
</head>

<body>
    @include('partials.navbar')

    <main class="py-4">
        @yield('content')
    </main>

    {{-- JS de Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
