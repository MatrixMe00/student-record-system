@props(['showLogo' => true])

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
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 relative">
            @if($showLogo)
                {{-- Centered Layout for Login Pages --}}
                <div class="flex flex-col sm:justify-center min-h-screen py-6">
                    {{-- Logo Section --}}
                    <div class="flex flex-col items-center mb-6">
                        <div>
                            @yield("logo")
                        </div>
                    </div>

                    {{-- Main Content --}}
                    <div class="px-6 w-full max-w-md mx-auto">
                        {{ $slot }}
                    </div>
                </div>
            @else
                {{-- Full Screen Layout for Registration Pages --}}
                {{ $slot }}
            @endif
        </div>
    </body>
</html>
