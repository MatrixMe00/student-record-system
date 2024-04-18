<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'EduRecordsGH') }} | HomePage</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

        <!-- Scripts -->
        @if (env('APP_URL') == "http://localhost")
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link rel="stylesheet" href="{{ asset('assets/app.css') }}" />
            <script src="{{ asset('assets/app.js') }}"></script>
        @endif
    </head>

    <body class="antialiased">
        <!-- Navigation bar -->
        <x-main-header />

        <!-- Main content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <x-main-footer />
    </body>
</html>
