<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Google Fonts: Outfit -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
        </style>
    </head>
    <body class="bg-[#0b0c10] text-[#c5c6c7] antialiased overflow-x-hidden">
        <div class="min-h-screen flex flex-col justify-center items-center p-4 relative bg-radial from-[#1e111b] via-[#0b0c10] to-[#0b0c10]">
            <!-- Glow background decoration -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] h-[350px] bg-pink-500/10 rounded-full blur-[100px] pointer-events-none"></div>

            <div class="relative z-10 w-full sm:max-w-md bg-gray-900/40 border border-gray-800 p-8 rounded-2xl shadow-2xl backdrop-blur-md">
                <div class="flex flex-col items-center mb-8">
                    <a href="/" class="flex items-center gap-2 mb-2">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-pink-500 to-rose-600 flex items-center justify-center shadow-lg shadow-pink-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </div>
                        <span class="text-xl font-black tracking-tight text-white">WO<span class="text-pink-500">App</span></span>
                    </a>
                </div>

                {{ $slot }}
            </div>
        </div>
    </body>
</html>
