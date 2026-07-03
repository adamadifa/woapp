<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: window.innerWidth > 768 }" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WOApp') }} - Client Panel</title>

        <!-- Google Fonts (Inter) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-200 transition-colors duration-200">
        <div class="h-screen overflow-hidden flex">
            <!-- Sidebar (Referensi Design 2) -->
            <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 flex flex-col transition-all duration-300 shrink-0 md:relative fixed z-30 h-full"
                   :class="{ '-ml-64': !sidebarOpen }">
                <!-- Logo & Brand Header -->
                <div class="h-16 border-b border-gray-100 dark:border-gray-700 flex items-center px-6 gap-3">
                    <div class="w-9 h-9 rounded-xl bg-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-md shadow-purple-100 dark:shadow-none">
                        C
                    </div>
                    <span class="font-bold text-lg text-gray-900 dark:text-white">Client Portal</span>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                    <p class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider px-3 mb-2">My Wedding</p>
                    
                    <a href="{{ route('client.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('client.dashboard') ? 'bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('client.schedule') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('client.schedule') ? 'bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Timeline & Schedule</span>
                    </a>

                    <a href="{{ route('client.budget') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('client.budget') ? 'bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <span>Budget Tracker</span>
                    </a>

                    <a href="{{ route('client.vendors') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('client.vendors') ? 'bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>Vendors</span>
                    </a>

                    <a href="{{ route('client.guests') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('client.guests') ? 'bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 00-2 2H7m12 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        <span>Guest List</span>
                    </a>

                    <a href="{{ route('client.rundown') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('client.rundown') ? 'bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Rundown</span>
                    </a>

                    <p class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider px-3 pt-4 mb-2">Support</p>
                    
                    <a href="{{ route('client.notes') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('client.notes') ? 'bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span>Notes & Chat</span>
                    </a>
                </nav>

                <!-- Profile Footer Section -->
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center font-bold text-purple-600 dark:text-purple-400">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="truncate max-w-[120px]">
                            <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 dark:text-gray-500 dark:hover:text-red-400 p-1.5 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Mobile Sidebar Overlay Backdrop -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="md:hidden fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-20 transition-opacity" x-cloak></div>

            <!-- Main Content Container -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Top Navbar Header (Referensi Design 2) -->
                <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between px-6 z-10 shrink-0">
                    <div class="flex items-center gap-4">
                        <!-- Sidebar Toggle -->
                        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 p-2 rounded-xl transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                    </div>

                    <!-- Topbar Controls (Language, Theme, Alerts, User) -->
                    <div class="flex items-center gap-3">
                        <!-- Dark Mode Toggle -->
                        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 p-2 rounded-xl transition-all">
                            <!-- Moon Icon -->
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                            <!-- Sun Icon -->
                            <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 7a5 5 0 100 10 5 5 0 000-10z"/></svg>
                        </button>
                    </div>
                </header>

                <!-- Page Main Content Slot -->
                <main class="flex-1 overflow-y-auto p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
