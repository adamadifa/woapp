<x-client-layout>
    <div class="space-y-6">
        <!-- Hero Banner Header -->
        <div class="relative bg-gradient-to-r from-purple-600 to-indigo-700 rounded-3xl p-6 md:p-8 shadow-xl text-white overflow-hidden">
            <!-- Background sparkles decorative pattern -->
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest bg-white/20 px-3 py-1 rounded-full inline-block">Client Portal</span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ $project->client->groom_name }} & {{ $project->client->bride_name }}! 👋</h1>
                    <p class="text-sm opacity-90 max-w-xl">Kami sangat senang mendampingi Anda merancang hari bahagia pernikahan impian Anda.</p>
                </div>
                
                <!-- Countdown Box (Alpine.js) -->
                <div x-data="{
                        targetDate: new Date('{{ $project->wedding_date }} 08:00:00').getTime(),
                        days: 0, hours: 0, minutes: 0, seconds: 0,
                        init() {
                            this.updateTimer();
                            setInterval(() => this.updateTimer(), 1000);
                        },
                        updateTimer() {
                            const now = new Date().getTime();
                            const diff = this.targetDate - now;
                            if (diff <= 0) return;
                            this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                            this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                            this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                        }
                     }" 
                     class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 shrink-0 flex items-center gap-3 text-center md:self-end">
                    <div class="space-y-1">
                        <span class="block text-xl font-extrabold font-mono" x-text="days">0</span>
                        <span class="block text-[9px] uppercase tracking-wider font-medium opacity-80">Hari</span>
                    </div>
                    <div class="text-lg opacity-40 font-bold">:</div>
                    <div class="space-y-1">
                        <span class="block text-xl font-extrabold font-mono" x-text="hours">0</span>
                        <span class="block text-[9px] uppercase tracking-wider font-medium opacity-80">Jam</span>
                    </div>
                    <div class="text-lg opacity-40 font-bold">:</div>
                    <div class="space-y-1">
                        <span class="block text-xl font-extrabold font-mono" x-text="minutes">0</span>
                        <span class="block text-[9px] uppercase tracking-wider font-medium opacity-80">Menit</span>
                    </div>
                    <div class="text-lg opacity-40 font-bold">:</div>
                    <div class="space-y-1">
                        <span class="block text-xl font-extrabold font-mono" x-text="seconds">0</span>
                        <span class="block text-[9px] uppercase tracking-wider font-medium opacity-80">Detik</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Stats Cards & Progress Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Preparation Completion Progress Card -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col justify-between space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-sm">Persiapan Pernikahan</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Persentase checklist yang selesai.</p>
                    </div>
                    <span class="text-2xl font-extrabold text-purple-600 dark:text-purple-400 font-mono">{{ $prepPercent }}%</span>
                </div>
                <div class="space-y-1.5">
                    <div class="w-full bg-gray-100 dark:bg-gray-700 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-purple-600 h-full rounded-full transition-all duration-500" style="width: {{ $prepPercent }}%"></div>
                    </div>
                    <span class="text-[10px] text-gray-450 block">Lihat detail di tab Timeline.</span>
                </div>
            </div>

            <!-- Budget Spent Progress Card -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col justify-between space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-sm">Dana Terpakai</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Dari total anggaran Rp {{ number_format($totalBudget, 0, ',', '.') }}</p>
                    </div>
                    <span class="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400 font-mono">{{ $budgetPercent }}%</span>
                </div>
                <div class="space-y-1.5">
                    <div class="w-full bg-gray-100 dark:bg-gray-700 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $budgetPercent }}%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-gray-450">
                        <span>Sisa: Rp {{ number_format($remainingBudget, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Guests Attending Card -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col justify-between space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-sm">Konfirmasi Tamu</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Jumlah undangan yang RSVP hadir.</p>
                    </div>
                    <span class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 font-mono">{{ $confirmedGuests }} <span class="text-xs font-normal text-gray-450">Pax</span></span>
                </div>
                <div class="space-y-1.5">
                    <div class="w-full bg-gray-100 dark:bg-gray-700 h-2.5 rounded-full overflow-hidden">
                        @php
                            $guestPercent = $totalGuests > 0 ? min(100, round(($confirmedGuests / $totalGuests) * 100)) : 0;
                        @endphp
                        <div class="bg-emerald-600 h-full rounded-full transition-all duration-500" style="width: {{ $guestPercent }}%"></div>
                    </div>
                    <span class="text-[10px] text-gray-450 block">Total respon RSVP terkumpul: {{ $totalGuests }} Pax.</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Upcoming Milestones -->
            <div class="lg:col-span-1 bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-50 dark:border-gray-700/50 pb-3">
                    <h3 class="font-bold text-gray-900 dark:text-white text-sm">Target Terdekat</h3>
                    <a href="{{ route('client.schedule') }}" class="text-[11px] font-bold text-purple-600 hover:underline">Semua →</a>
                </div>

                <div class="space-y-4">
                    @forelse($upcomingMilestones as $ms)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="space-y-0.5">
                                <h4 class="font-bold text-gray-900 dark:text-white text-xs">{{ $ms->title }}</h4>
                                <p class="text-[10px] text-red-500 font-bold">Batas: {{ \Carbon\Carbon::parse($ms->due_date)->translatedFormat('d M Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400 text-xs">
                            Tidak ada target milestone terdekat.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right: Activity Feed Log -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-4">
                <h3 class="font-bold text-gray-900 dark:text-white text-sm border-b border-gray-50 dark:border-gray-700/50 pb-3">Aktivitas Terkini (Activity Feed)</h3>
                
                <div class="relative border-l border-gray-100 dark:border-gray-700 space-y-6 pl-4 ml-2 py-2">
                    @forelse($recentActivities as $act)
                        <div class="relative">
                            <!-- Bullet Indicator -->
                            <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-white dark:bg-gray-800 border-2 border-purple-500 shadow-sm"></div>
                            
                            <div class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-gray-900 dark:text-white text-xs">{{ $act['title'] }}</h4>
                                    <span class="text-[9px] text-gray-400 font-mono">{{ \Carbon\Carbon::parse($act['time'])->diffForHumans() }}</span>
                                </div>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400">{{ $act['desc'] }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400 text-xs">
                            Belum ada log aktivitas pengerjaan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-client-layout>
