<x-client-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-xl font-extrabold text-gray-950 dark:text-white tracking-tight">Daftar Undangan & RSVP</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Lacak respon kehadiran, kategori undangan, dan pembagian porsi undangan.</p>
        </div>

        <!-- RSVP Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Total Pax -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Total Undangan</span>
                    <h3 class="text-xl font-extrabold text-gray-900 dark:text-white font-mono mt-0.5">{{ $totalGuestsCount }} <span class="text-xs font-normal text-gray-450">Pax</span></h3>
                </div>
                <div class="w-9 h-9 rounded-xl bg-purple-50 dark:bg-purple-950/20 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>

            <!-- Confirmed Present -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Konfirmasi Hadir</span>
                    <h3 class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400 font-mono mt-0.5">{{ $confirmedGuestsCount }} <span class="text-xs font-normal text-gray-450">Pax</span></h3>
                </div>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>

            <!-- Declined -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Berhalangan</span>
                    <h3 class="text-xl font-extrabold text-red-600 dark:text-red-400 font-mono mt-0.5">{{ $declinedGuestsCount }} <span class="text-xs font-normal text-gray-450">Pax</span></h3>
                </div>
                <div class="w-9 h-9 rounded-xl bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-450 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>

            <!-- Pending -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Menunggu Respon</span>
                    <h3 class="text-xl font-extrabold text-amber-600 dark:text-amber-400 font-mono mt-0.5">{{ $pendingGuestsCount }} <span class="text-xs font-normal text-gray-450">Pax</span></h3>
                </div>
                <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar (Alpine.js) -->
        <div x-data="{
                searchQuery: '',
                categoryFilter: '',
                rsvpFilter: '',
                match(name, category, rsvp) {
                    const matchSearch = !this.searchQuery || name.toLowerCase().includes(this.searchQuery.toLowerCase());
                    const matchCategory = !this.categoryFilter || category === this.categoryFilter;
                    const matchRsvp = !this.rsvpFilter || rsvp === this.rsvpFilter;
                    return matchSearch && matchCategory && matchRsvp;
                }
             }" 
             class="space-y-6">
            
            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="relative max-w-xs w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" x-model="searchQuery" placeholder="Cari nama tamu..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 pl-9 pr-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                    </div>

                    <select x-model="categoryFilter" class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-3 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        <option value="">Semua Kategori</option>
                        @foreach($guests->pluck('category')->unique() as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>

                    <select x-model="rsvpFilter" class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-3 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        <option value="">Semua Status RSVP</option>
                        <option value="confirmed">Hadir</option>
                        <option value="declined">Berhalangan</option>
                        <option value="pending">Belum Respon</option>
                    </select>
                </div>
            </div>

            <!-- Guest List Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-gray-900/40 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider border-b border-gray-55 dark:border-gray-750">
                                <th class="py-4 px-6">Nama Undangan</th>
                                <th class="py-4 px-6">Kategori</th>
                                <th class="py-4 px-6 text-center">Jumlah Pax</th>
                                <th class="py-4 px-6 text-center">Nomor Kursi</th>
                                <th class="py-4 px-6">Catatan</th>
                                <th class="py-4 px-6 text-center">Status RSVP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-750 text-xs">
                            @forelse($guests as $g)
                                <tr x-show="match('{{ addslashes($g->name) }}', '{{ addslashes($g->category) }}', '{{ $g->rsvp_status }}')" 
                                    class="hover:bg-gray-50/30 dark:hover:bg-gray-900/10 transition-colors text-gray-700 dark:text-gray-300">
                                    <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">{{ $g->name }}</td>
                                    <td class="py-4 px-6">
                                        <span class="px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-550 dark:text-gray-400 text-[10px] font-semibold border border-gray-200 dark:border-gray-700/50">
                                            {{ $g->category }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center font-mono font-bold">{{ $g->guest_count }} Pax</td>
                                    <td class="py-4 px-6 text-center font-mono font-semibold">{{ $g->seat_number ?? '-' }}</td>
                                    <td class="py-4 px-6 text-gray-400 dark:text-gray-500 truncate max-w-[200px]" title="{{ $g->notes }}">{{ $g->notes ?? '-' }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider 
                                            @if($g->rsvp_status === 'confirmed') bg-emerald-500 text-white
                                            @elseif($g->rsvp_status === 'declined') bg-red-500 text-white
                                            @else bg-amber-500 text-white @endif">
                                            {{ $g->rsvp_status === 'confirmed' ? 'Hadir' : ($g->rsvp_status === 'declined' ? 'Absen' : 'Pending') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-gray-400">
                                        Belum ada tamu undangan yang didaftarkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-client-layout>
