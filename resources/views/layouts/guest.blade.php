<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EduRecordsGH') }} {{ " | " }} @yield('title', "Document")</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            {{-- Logo Section (only if not setup page) --}}
            @if(!request()->routeIs('setup'))
                <div class="flex flex-col sm:justify-center items-center py-6 sm:pt-0">
                    <div>
                        @yield("logo")
                    </div>
                </div>
            @endif

            {{-- Main Content --}}
            <div class="@if(!request()->routeIs('setup')) px-6 py-4 @endif">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
