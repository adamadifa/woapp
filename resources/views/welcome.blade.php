<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WOApp - Aplikasi Manajemen & Promosi Bisnis Wedding Organizer</title>

        <!-- Google Fonts: Outfit -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Tailwind CSS & JS -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
        @endif

        <!-- AlpineJS CDN for interactive components -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
        </style>
    </head>
    <body class="bg-[#0b0c10] text-[#c5c6c7] antialiased overflow-x-hidden">

        <!-- Navigation -->
        <nav class="sticky top-0 z-50 backdrop-blur-md bg-[#0b0c10]/80 border-b border-gray-800 transition-all">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-pink-500 to-rose-600 flex items-center justify-center shadow-lg shadow-pink-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </div>
                        <span class="text-lg font-black tracking-tight text-white">WO<span class="text-pink-500">App</span></span>
                    </div>

                    <div class="hidden md:flex items-center gap-8 text-xs font-semibold text-gray-400">
                        <a href="#features" class="hover:text-pink-500 transition-colors">Fitur</a>
                        <a href="#pricing" class="hover:text-pink-500 transition-colors">Harga Paket</a>
                        <a href="#faq" class="hover:text-pink-500 transition-colors">FAQ</a>
                    </div>

                    <div class="flex items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white text-xs font-bold py-2 px-5 rounded-xl shadow-lg shadow-pink-500/20 transition-all transform hover:-translate-y-0.5">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-xs font-bold text-gray-400 hover:text-white px-3 py-2 transition-colors">
                                    Log In
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-gray-800 hover:bg-gray-700 text-white border border-gray-700 text-xs font-bold py-2 px-4 rounded-xl transition-all">
                                        Daftar Sekarang
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-24 pb-20 md:pt-32 md:pb-28 overflow-hidden bg-radial from-[#1e111b] via-[#0b0c10] to-[#0b0c10]">
            <!-- Decorative Glow -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-pink-500/10 rounded-full blur-[120px] pointer-events-none"></div>

            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-pink-500/10 border border-pink-500/30 text-pink-400 text-[10px] font-extrabold uppercase tracking-widest mb-6">
                    🚀 ALL-IN-ONE SAAS PLATFORM FOR WEDDING ORGANIZERS
                </span>
                
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-white leading-tight">
                    Kelola Project Pernikahan & <br />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-rose-400">Promosikan Jasa WO Anda</span>
                </h1>

                <p class="mt-6 text-sm md:text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
                    Sistem manajemen modern untuk Wedding Organizer. Mulai dari kelola checklist, estimasi budget, rundown acara, daftar tamu, hingga memiliki halaman portofolio publik sendiri untuk memikat calon pengantin.
                </p>

                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white text-xs font-extrabold py-3.5 px-8 rounded-xl shadow-xl shadow-pink-500/25 transition-all transform hover:-translate-y-0.5">
                        Coba Gratis Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a href="#features" class="w-full sm:w-auto inline-flex items-center justify-center bg-gray-900/60 hover:bg-gray-800/80 text-white border border-gray-800 text-xs font-bold py-3.5 px-8 rounded-xl transition-all">
                        Pelajari Fitur
                    </a>
                </div>

                <div class="mt-4 flex items-center justify-center gap-6 text-[11px] text-gray-500">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Gratis Uji Coba
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Fitur B2C Promosi Mandiri
                    </span>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 bg-[#08090d] border-y border-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-white">Satu Dashboard untuk Semua Kebutuhan Acara</h2>
                    <p class="text-xs md:text-sm text-gray-400 mt-3">Hemat waktu koordinasi, minimalkan kesalahan teknis, dan tingkatkan kepuasan pengantin dengan sistem kerja yang serba rapi dan digital.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Feature 1 -->
                    <div class="bg-gray-900/30 border border-gray-850 p-6 rounded-2xl hover:border-pink-500/30 transition-all duration-300 group">
                        <div class="w-10 h-10 rounded-xl bg-pink-500/10 text-pink-400 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801-12c.065.21.1.433.1.664a3.25 3.25 0 11-6.5 0c0-.23.035-.454.1-.664M6.75 7.5H4.853c-1.131 0-1.976.923-1.976 2.057v10.193C2.877 21.077 3.89 22 5.017 22H18.75m-12-14.5v14.5"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-white mb-2">Checklist & Timeline</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">Pantau setiap tugas persiapan pernikahan secara real-time. Jangan biarkan ada vendor atau jadwal yang terlewat.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-gray-900/30 border border-gray-850 p-6 rounded-2xl hover:border-pink-500/30 transition-all duration-300 group">
                        <div class="w-10 h-10 rounded-xl bg-pink-500/10 text-pink-400 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.251-.251a1.5 1.5 0 012.122 0L12 15l.628-.628a1.5 1.5 0 012.122 0l.251.251M18 12a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-white mb-2">Kalkulator Anggaran & Budgeting</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">Rancang alokasi budget belanja pernikahan dengan praktis. Catat pembayaran uang muka dan sisa pelunasan vendor.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-gray-900/30 border border-gray-850 p-6 rounded-2xl hover:border-pink-500/30 transition-all duration-300 group">
                        <div class="w-10 h-10 rounded-xl bg-pink-500/10 text-pink-400 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.969 5.969 0 01-5.384-3.358m0 0a5.969 5.969 0 01-5.385 3.358m10.77 0c.013-.101.018-.204.018-.309a4.5 4.5 0 00-8.917-.991m9.005.485a3.75 3.75 0 00-6.197-3.006m-9.3 3.006a3.75 3.75 0 01-6.2-3.006M3 18.72a9.094 9.094 0 013.741-.479 3 3 0 01-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0012 21c2.17 0 4.207-.576 5.963-1.584A6.062 6.062 0 0018 18.722m-12 0a5.969 5.969 0 005.384-3.358m0 0a5.969 5.969 0 005.385 3.358m-10.77 0c-.013-.101-.018-.204-.018-.309a4.5 4.5 0 018.917-.991m-9.005.485a3.75 3.75 0 016.197-3.006m-9.3 3.006a3.75 3.75 0 00-6.2-3.006M12 12a3 3 0 100-6 3 3 0 000 6zm0 0a3 3 0 100-6 3 3 0 000 6z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-white mb-2">Manajemen Daftar Tamu & Undangan</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">Kelola daftar undangan yang akan hadir, kategori tamu (VIP/Reguler), serta checklist konfirmasi kedatangan.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-gray-900/30 border border-gray-850 p-6 rounded-2xl hover:border-pink-500/30 transition-all duration-300 group">
                        <div class="w-10 h-10 rounded-xl bg-pink-500/10 text-pink-400 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-white mb-2">Rundown Detik demi Detik</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">Rancang tata tertib rundown acara untuk panitia dan pengisi acara. Print atau share rundown digital dengan satu klik.</p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="bg-gray-900/30 border border-gray-850 p-6 rounded-2xl hover:border-pink-500/30 transition-all duration-300 group">
                        <div class="w-10 h-10 rounded-xl bg-pink-500/10 text-pink-400 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-white mb-2">Landing Page Publik (B2C Promo)</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">Dapatkan halaman portofolio mandiri berdomain `woapp.com/wo/nama-wo` untuk mempromosikan foto, paket, dan mengumpulkan formulir inquiry calon klien.</p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="bg-gray-900/30 border border-gray-850 p-6 rounded-2xl hover:border-pink-500/30 transition-all duration-300 group">
                        <div class="w-10 h-10 rounded-xl bg-pink-500/10 text-pink-400 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 20H10v-.012a11.378 11.378 0 01-4.821-2.482m0 0a11.38 11.38 0 01-2.613-5.32M4.562 10.81a9.03 9.03 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M4.562 10.81c0-1.11.285-2.16.786-3.07M4.562 10.81v.11A11.386 11.386 0 009.91 16H10v-.012c1.782-.032 3.447-.564 4.857-1.482m0 0a11.38 11.38 0 002.613-5.32M15 10.81a9.03 9.03 0 01-2.625.372c-1.455 0-2.825-.343-4.12-.952a4.125 4.125 0 017.533-2.493M12 15a3 3 0 100-6 3 3 0 000 6z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-white mb-2">Kolaborasi Client & Tim WO</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">Berikan akses masuk khusus untuk pasangan pengantin agar mereka bisa memantau kemajuan persiapan secara mandiri.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="py-20 bg-[#0b0c10]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-white">Paket Langganan yang Fleksibel</h2>
                    <p class="text-xs md:text-sm text-gray-400 mt-3">Pilih paket terbaik yang sesuai dengan skala bisnis Wedding Organizer Anda.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @foreach($plans as $p)
                        @php
                            $isPro = $p->slug === 'pro';
                        @endphp
                        <div class="bg-gray-900/40 p-6 rounded-2xl flex flex-col justify-between hover:border-gray-750 border transition-all duration-300 relative {{ $isPro ? 'border-pink-500 shadow-xl shadow-pink-500/5 transform md:-translate-y-2' : 'border-gray-850' }}">
                            @if($isPro)
                                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-gradient-to-r from-pink-500 to-rose-600 text-white text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-full">
                                    TERPOPULER
                                </div>
                            @endif
                            <div>
                                <span class="text-[10px] font-extrabold uppercase tracking-widest block mb-1 {{ $isPro ? 'text-pink-400' : 'text-gray-500' }}">
                                    {{ $p->slug === 'free' ? 'Mulai Gratis' : ($p->slug === 'basic' ? 'Scale Up' : ($isPro ? 'Solusi Terbaik' : 'Kustomisasi Penuh')) }}
                                </span>
                                <h3 class="text-lg font-bold text-white mb-2">{{ $p->name }}</h3>
                                <div class="my-4">
                                    <span class="text-2xl font-black text-white">
                                        @if($p->price == 0)
                                            Rp 0
                                        @else
                                            Rp {{ number_format($p->price, 0, ',', '.') }}
                                        @endif
                                    </span>
                                    <span class="text-xs text-gray-505">/ {{ $p->slug === 'free' ? 'selamanya' : 'bulan' }}</span>
                                </div>
                                <p class="text-xs text-gray-400 mb-6">
                                    {{ $p->slug === 'free' ? 'Cocok untuk WO pemula yang baru mulai mengorganisir project digital pertama.' : ($p->slug === 'basic' ? 'Pilihan pas untuk bisnis WO menengah yang mengelola beberapa project aktif.' : ($isPro ? 'Paket lengkap yang paling direkomendasikan dengan unlimited project & Custom Landing Page.' : 'Dirancang khusus untuk agensi Wedding Organizer besar dengan multi-tenant dan domain sendiri.')) }}
                                </p>
                                
                                <ul class="space-y-3 text-xs text-gray-400 border-t border-gray-800 pt-6">
                                    @if(is_array($p->features))
                                        @foreach($p->features as $feature)
                                            <li class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-pink-500 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                {{ $feature }}
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="mt-8">
                                <a href="{{ route('register', ['plan' => $p->slug]) }}" class="w-full inline-flex items-center justify-center text-white text-xs font-bold py-2.5 px-4 rounded-xl transition-all {{ $isPro ? 'bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 shadow-md shadow-pink-500/20 transform hover:-translate-y-0.5' : 'bg-gray-800 hover:bg-gray-700' }}">
                                    {{ $p->slug === 'free' ? 'Daftar Gratis' : 'Pilih ' . $p->name }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq" class="py-20 bg-[#08090d] border-t border-gray-900" x-data="{ activeFaq: null }">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-white">Pertanyaan Umum (FAQ)</h2>
                    <p class="text-xs md:text-sm text-gray-400 mt-3">Beberapa hal yang paling sering ditanyakan mengenai platform WOApp.</p>
                </div>

                <div class="space-y-4">
                    <!-- FAQ 1 -->
                    <div class="bg-gray-900/30 border border-gray-850 rounded-2xl overflow-hidden transition-all duration-300">
                        <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full text-left p-5 flex items-center justify-between font-bold text-white text-xs md:text-sm hover:bg-gray-900/50 transition-colors">
                            <span>Bagaimana cara kerja halaman Landing Page Promosi Publik WO?</span>
                            <svg class="w-4 h-4 text-pink-500 transition-transform duration-300" :class="activeFaq === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div x-show="activeFaq === 1" x-collapse class="px-5 pb-5 text-xs text-gray-400 leading-relaxed border-t border-gray-850 pt-4">
                            Setiap WO yang berlangganan paket Pro ke atas akan mendapatkan subdomain publik berupa `woapp.com/wo/nama-wo-anda`. Halaman ini dapat disesuaikan isinya melalui dashboard Anda (mengganti judul banner, foto gallery, portofolio, ulasan klien, dsb) dan sudah dioptimasi untuk SEO agar mudah ditemukan calon klien di mesin pencari Google.
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="bg-gray-900/30 border border-gray-850 rounded-2xl overflow-hidden transition-all duration-300">
                        <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full text-left p-5 flex items-center justify-between font-bold text-white text-xs md:text-sm hover:bg-gray-900/50 transition-colors">
                            <span>Apakah klien (calon pengantin) harus membayar untuk menggunakan aplikasi?</span>
                            <svg class="w-4 h-4 text-pink-500 transition-transform duration-300" :class="activeFaq === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div x-show="activeFaq === 2" x-collapse class="px-5 pb-5 text-xs text-gray-400 leading-relaxed border-t border-gray-850 pt-4">
                            Tidak. Klien pengantin mengakses dashboard kolaborasi secara gratis melalui akun yang dibuat oleh Wedding Organizer mereka. Klien pengantin dapat melihat rundown, log budget, mengisi checklist tugas, dan berkomunikasi dengan PIC Wedding Organizer Anda tanpa dipungut biaya apa pun.
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="bg-gray-900/30 border border-gray-850 rounded-2xl overflow-hidden transition-all duration-300">
                        <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full text-left p-5 flex items-center justify-between font-bold text-white text-xs md:text-sm hover:bg-gray-900/50 transition-colors">
                            <span>Apakah ada biaya tambahan atau biaya transaksi?</span>
                            <svg class="w-4 h-4 text-pink-500 transition-transform duration-300" :class="activeFaq === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div x-show="activeFaq === 3" x-collapse class="px-5 pb-5 text-xs text-gray-400 leading-relaxed border-t border-gray-850 pt-4">
                            Tidak ada biaya tersembunyi. Anda hanya membayar harga langganan bulanan sesuai dengan paket yang dipilih. Seluruh modul budgeting, rundown, dan media gallery bersifat inklusif tanpa batas bandwidth tambahan.
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="bg-gray-900/30 border border-gray-850 rounded-2xl overflow-hidden transition-all duration-300">
                        <button @click="activeFaq = (activeFaq === 4 ? null : 4)" class="w-full text-left p-5 flex items-center justify-between font-bold text-white text-xs md:text-sm hover:bg-gray-900/50 transition-colors">
                            <span>Dapatkah saya melakukan upgrade atau downgrade paket kapan saja?</span>
                            <svg class="w-4 h-4 text-pink-500 transition-transform duration-300" :class="activeFaq === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div x-show="activeFaq === 4" x-collapse class="px-5 pb-5 text-xs text-gray-400 leading-relaxed border-t border-gray-850 pt-4">
                            Ya, Anda bisa mengubah paket langganan Anda kapan saja langsung melalui menu penagihan di dashboard WO. Sisa saldo billing Anda akan disesuaikan secara prorata ke paket baru yang dipilih.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-tr from-[#1b0d17] to-[#0c0d12] relative overflow-hidden">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <h2 class="text-2xl md:text-4xl font-extrabold text-white leading-tight">Siap Meningkatkan Level Bisnis WO Anda?</h2>
                <p class="mt-4 text-xs md:text-sm text-gray-400 max-w-xl mx-auto leading-relaxed">Bergabunglah dengan ratusan Wedding Organizer profesional lainnya dan ciptakan kenangan pernikahan tak terlupakan dengan pengelolaan serba digital.</p>
                <div class="mt-8">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white text-xs font-extrabold py-3.5 px-10 rounded-xl shadow-xl shadow-pink-500/25 transition-all transform hover:-translate-y-0.5">
                        Daftar Akun WO Sekarang
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-[#06070a] border-t border-gray-900 py-12 text-xs text-gray-500">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 border-b border-gray-900 pb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-pink-500 to-rose-600 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </div>
                        <span class="text-sm font-black tracking-tight text-white">WO<span class="text-pink-500">App</span></span>
                    </div>

                    <div class="flex items-center gap-8 text-[11px]">
                        <a href="#features" class="hover:text-white transition-colors">Fitur</a>
                        <a href="#pricing" class="hover:text-white transition-colors">Harga Paket</a>
                        <a href="#faq" class="hover:text-white transition-colors">FAQ</a>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-8 text-[11px]">
                    <p>&copy; {{ date('Y') }} WOApp. All rights reserved. Platform manajemen Wedding Organizer digital Indonesia.</p>
                    <p>Designed with ❤️ for modern planners.</p>
                </div>
            </div>
        </footer>

    </body>
</html>
