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
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dataTables.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}"> --}}
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/animsition/css/animsition.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/daterangepicker/daterangepicker.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('assets/css/util.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!--===============================================================================================-->


    <script src="{{ asset('assets/js/flowbite.min.js') }}"></script>


    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.js') }}"></script>

    {{-- <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script> --}}
    <!--===============================================================================================-->
    <script src="{{ asset('assets/vendor/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/vendor/countdowntime/countdowntime.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>
