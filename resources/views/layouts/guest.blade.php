<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Otirasor Beach and Resort') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Pinalitan ang bg-gray-100 ng magandang gradient -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-[#0077b6] via-[#00b4d8] to-[#023e8a]">
            
            <!-- Logo para sa mobile (nasaa labas ng card) -->
            <div class="sm:hidden mb-6">
                <a href="/">
                    <img src="{{ asset('images/otirasor-logo.png') }}" alt="Otirasor Logo" class="w-24 h-24 object-contain drop-shadow-lg">
                </a>
            </div>

            <!-- White Card Container -->
            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border border-gray-100">
                
                <!-- Logo para sa desktop (nasa loob ng card) -->
                <div class="hidden sm:flex justify-center mb-6">
                    <a href="/">
                        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Otirasor Logo" class="w-20 h-20 object-contain">
                    </a>
                </div>

                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-sm text-white/80">
                &copy; {{ date('Y') }} Otirasor Beach and Resort. All rights reserved.
            </div>
        </div>
    </body>
</html>