<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @vite(['resources/vendor/fontawesome-free/css/all.min.css', 'resources/css/sb-admin-2.min.css', 'resources/vendor/jquery/jquery.min.js', 'resources/vendor/bootstrap/js/bootstrap.bundle.min.js', 'resources/vendor/jquery-easing/jquery.easing.min.js', 'resources/js/sb-admin-2.min.js', 'resources/vendor/chart.js/Chart.min.js', 'resources/js/demo/chart-area-demo.js', 'resources/js/demo/chart-pie-demo.js'])
</head>
<body>
    <div class="container">
        @include('partials.navbar')
        @include('layouts.navigation')
        <div class="row w-30 sm-w-50 mt-3 p-5 bg-dark bg-dark text-light shadow-sm rounded d-flex align-items-center justify-content-center h-100">
            {{ $slot }}
        </div>
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
