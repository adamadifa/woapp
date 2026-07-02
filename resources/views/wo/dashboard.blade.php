<x-wo-layout>
    <div class="space-y-6">
        <!-- Welcome Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('Dashboard Wedding Organizer') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Selamat datang kembali! Berikut adalah ringkasan perkembangan bisnis persiapan pernikahan Anda.</p>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Active Projects -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-between">
                <div class="space-y-2">
                    <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Project Aktif</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ $activeProjectsCount }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-pink-50 dark:bg-pink-950/20 flex items-center justify-center text-pink-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>

            <!-- Active Clients -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-between">
                <div class="space-y-2">
                    <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Klien Terdaftar</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ $clientsCount }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/20 flex items-center justify-center text-indigo-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>

            <!-- Budget Summary -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-between sm:col-span-2 lg:col-span-1">
                <div class="space-y-2">
                    <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Total Kelola Budget</span>
                    <h3 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">Rp{{ number_format($totalBudget, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/20 flex items-center justify-center text-emerald-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>

            <!-- Total Packages & Vendors -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-between sm:col-span-2 lg:col-span-1">
                <div class="space-y-2">
                    <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Paket / Vendor</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ $packagesCount }} <span class="text-xs text-gray-400 font-normal">/ {{ $vendorsCount }}</span></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/20 flex items-center justify-center text-amber-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Upcoming Weddings & Recent Clients -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Upcoming Weddings -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-50 dark:border-gray-700/50 pb-3">
                        <h3 class="font-bold text-sm text-gray-900 dark:text-white">Jadwal Wedding Terdekat</h3>
                        <span class="text-[10px] text-gray-400">Menampilkan 5 terdekat</span>
                    </div>

                    <div class="space-y-3">
                        @forelse($upcomingProjects as $project)
                            <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors border border-gray-50 dark:border-gray-700/20">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-pink-50 dark:bg-pink-950/20 flex items-center justify-center text-pink-500 font-semibold text-xs shrink-0">
                                        {{ date('d', strtotime($project->wedding_date)) }}
                                        {{ date('M', strtotime($project->wedding_date)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-900 dark:text-white">{{ $project->name }}</h4>
                                        <p class="text-[10px] text-gray-400">Klien: {{ $project->client->groom_name }} & {{ $project->client->bride_name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold tracking-wider uppercase {{ $project->status === 'planning' ? 'bg-amber-50 text-amber-600 dark:bg-amber-950/20 dark:text-amber-400' : 'bg-indigo-50 text-indigo-600 dark:bg-indigo-950/20 dark:text-indigo-400' }}">
                                        {{ $project->status }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-gray-400">Belum ada agenda pernikahan terdekat.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Clients -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-50 dark:border-gray-700/50 pb-3">
                        <h3 class="font-bold text-sm text-gray-900 dark:text-white">Klien Baru Terdaftar</h3>
                        <span class="text-[10px] text-gray-400">Pendaftaran terbaru</span>
                    </div>

                    <div class="space-y-3">
                        @forelse($recentClients as $client)
                            <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors border border-gray-50 dark:border-gray-700/20">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-indigo-50 dark:bg-indigo-950/20 flex items-center justify-center text-indigo-500 font-bold text-xs shrink-0">
                                        {{ substr($client->groom_name, 0, 1) }}{{ substr($client->bride_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-900 dark:text-white">{{ $client->groom_name }} & {{ $client->bride_name }}</h4>
                                        <p class="text-[10px] text-gray-400">Paket: {{ $client->package->name ?? 'Belum memilih' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-medium text-gray-900 dark:text-white">{{ date('d M Y', strtotime($client->wedding_date)) }}</p>
                                    <p class="text-[9px] text-gray-400">{{ $client->phone ?? '-' }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-gray-400">Belum ada klien yang terdaftar.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right: Quick Actions & Subscription -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white border-b border-gray-50 dark:border-gray-700/50 pb-3">Aksi Cepat</h3>
                    
                    <div class="grid grid-cols-1 gap-2">
                        <a href="{{ route('wo.clients.index') }}" class="flex items-center gap-3 p-3 rounded-xl bg-pink-50/50 hover:bg-pink-50 dark:bg-pink-950/10 dark:hover:bg-pink-950/20 text-pink-600 dark:text-pink-400 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-pink-500 text-white flex items-center justify-center font-bold text-sm shrink-0">+</div>
                            <div>
                                <h4 class="text-xs font-bold">Tambah Klien Baru</h4>
                                <p class="text-[9px] text-pink-500/80">Input data calon mempelai & buat akun</p>
                            </div>
                        </a>

                        <a href="{{ route('wo.packages.index') }}" class="flex items-center gap-3 p-3 rounded-xl bg-indigo-50/50 hover:bg-indigo-50 dark:bg-indigo-950/10 dark:hover:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500 text-white flex items-center justify-center font-bold text-sm shrink-0">+</div>
                            <div>
                                <h4 class="text-xs font-bold">Buat Paket Wedding</h4>
                                <p class="text-[9px] text-indigo-500/80">Kelola paket penawaran & pricing</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Business Profile Card -->
                <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl shadow-md text-white p-6 space-y-4 relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>

                    <div class="space-y-1">
                        <span class="text-[9px] uppercase tracking-wider font-extrabold bg-white/20 px-2 py-0.5 rounded-full inline-block">Merek Wedding Organizer</span>
                        <h3 class="text-lg font-bold truncate">{{ Auth::user()->woProfile->business_name ?? Auth::user()->name }}</h3>
                        <p class="text-xs opacity-90 truncate">{{ Auth::user()->woProfile->address ?? 'Alamat belum diatur' }}</p>
                    </div>

                    <div class="pt-4 border-t border-white/20 flex justify-between items-center text-xs">
                        <span>Layanan Status:</span>
                        <span class="font-bold bg-white text-pink-600 px-2 py-0.5 rounded uppercase tracking-wider text-[10px]">
                            {{ Auth::user()->woProfile->subscription_plan ?? 'FREE' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-wo-layout>
