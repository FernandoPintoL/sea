<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('assets/img/favicon.ico') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/webfonts/fa-regular-400.ttf') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/webfonts/fa-regular-400.woff2') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/webfonts/fa-solid-900.ttf') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/webfonts/fa-solid-900.woff2') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/css/v5-font-face.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/css/brands.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/css/solid.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/css/regular.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flowbite.min.css') }}">
    <script src="{{ asset('assets/js/flowbite.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dataTables.css') }}">


    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.js') }}"></script>
</body>
</html>
