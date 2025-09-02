<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('img/icono.ico') }}">

    <!-- Estilos de bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/sass/app.scss')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Estilos css generales -->
    <link href="{{ asset('css/base/css/general.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base/css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base/css/footer.css') }}" rel="stylesheet">

    <!-- Estilos cambiantes -->
    @yield('styles')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
</head>

<body>

    <div class="content">
        <!-- Incluir menú -->
        @include('layouts.menu')

        <section class="section">
        @yield('content')   
        </section>

        <!-- Incluir footer -->
        @include('layouts.footer')
    </div>
    @yield('scripts')
    <!-- Scripts de bootstrap -->
    {{-- @vite(['resources/js/app.js']) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>