<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: window.innerWidth > 768 }" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WOApp') }} - Wedding Organizer</title>

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
                    <div class="w-9 h-9 rounded-xl bg-pink-600 flex items-center justify-center text-white font-bold text-lg shadow-md shadow-pink-100 dark:shadow-none">
                        W
                    </div>
                    <span class="font-bold text-lg text-gray-900 dark:text-white">WOApp</span>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                    <p class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider px-3 mb-2">Organizer Tool</p>
                    
                    <a href="{{ route('wo.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('wo.dashboard') ? 'bg-pink-50 text-pink-600 dark:bg-pink-900/30 dark:text-pink-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('wo.projects.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('wo.projects.*') ? 'bg-pink-50 text-pink-600 dark:bg-pink-900/30 dark:text-pink-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Wedding Projects</span>
                    </a>

                    <a href="{{ route('wo.clients.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('wo.clients.*') ? 'bg-pink-50 text-pink-600 dark:bg-pink-900/30 dark:text-pink-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>Client Profiles</span>
                    </a>

                    <a href="{{ route('wo.team.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('wo.team.*') ? 'bg-pink-50 text-pink-600 dark:bg-pink-900/30 dark:text-pink-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Team Members</span>
                    </a>

                    <p class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider px-3 pt-4 mb-2">Konfigurasi</p>
                    
                    <a href="{{ route('wo.profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('wo.profile.*') ? 'bg-pink-50 text-pink-600 dark:bg-pink-900/30 dark:text-pink-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Business Profile</span>
                    </a>

                    <a href="{{ route('wo.landing_page.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('wo.landing_page.*') ? 'bg-pink-50 text-pink-600 dark:bg-pink-900/30 dark:text-pink-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        <span>Landing Page</span>
                    </a>

                    <a href="{{ route('wo.subscription.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('wo.subscription.*') ? 'bg-pink-50 text-pink-600 dark:bg-pink-900/30 dark:text-pink-400' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Subscription Status</span>
                    </a>
                </nav>

                <!-- Profile Footer Section -->
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-pink-100 dark:bg-pink-900 flex items-center justify-center font-bold text-pink-600 dark:text-pink-400">
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
                        <!-- Search Bar -->
                        <div class="relative hidden sm:block w-72">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input type="text" placeholder="Search project/client..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 pl-10 pr-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:focus:ring-offset-gray-900 focus:outline-none transition-all placeholder:text-gray-400 text-gray-900 dark:text-white">
                        </div>
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
