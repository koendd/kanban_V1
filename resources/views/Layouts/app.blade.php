<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@if(env('APP_ENV') != 'production' || env('APP_DEBUG')) Debugging @else {{ config('app.name') }} @endif &verbar; @yield('title')</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        @auth
        @include('Layouts.navbar')
        @endauth

        <main id="app" class="container-fluid vh-100">
            @yield('content')
        </main>
    </body>
</html>