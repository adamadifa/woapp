<x-client-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-xl font-extrabold text-gray-950 dark:text-white tracking-tight">Rundown & Susunan Acara Hari-H</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Timeline kegiatan lengkap dari sesi makeup, akad/pemberkatan, hingga resepsi pernikahan.</p>
        </div>

        <!-- Visual Timeline View -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="relative border-l-2 border-purple-100 dark:border-gray-700 ml-4 md:ml-32 space-y-8 py-4">
                @forelse($rundownItems as $item)
                    <div class="relative">
                        <!-- Dot indicator -->
                        <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-purple-500 border-4 border-white dark:border-gray-800 shadow"></div>
                        
                        <!-- Time display on desktop (shifts left of timeline) -->
                        <div class="hidden md:block absolute -left-32 top-1 text-right w-24">
                            <span class="font-bold text-gray-900 dark:text-white font-mono text-sm block">
                                {{ date('H:i', strtotime($item->time_start)) }}
                            </span>
                            <span class="text-[10px] text-gray-400 font-mono block">
                                s/d {{ date('H:i', strtotime($item->time_end)) }}
                            </span>
                        </div>

                        <!-- Content Card -->
                        <div class="ml-6 bg-gray-50 dark:bg-gray-900/30 p-4 rounded-xl border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row md:items-start md:justify-between gap-3">
                            <div class="space-y-1">
                                <!-- Time display on mobile -->
                                <div class="md:hidden flex items-center gap-1 text-[11px] font-bold text-gray-450 font-mono mb-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ date('H:i', strtotime($item->time_start)) }} - {{ date('H:i', strtotime($item->time_end)) }}</span>
                                </div>

                                <h4 class="font-bold text-gray-900 dark:text-white text-sm">{{ $item->activity }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->notes ?? 'Tidak ada catatan tambahan.' }}</p>
                            </div>

                            <div class="flex items-center justify-between md:justify-end gap-3 shrink-0 pt-2 md:pt-0 border-t border-dashed border-gray-100 dark:border-gray-750 md:border-none">
                                @if($item->pic)
                                    <span class="px-2.5 py-0.5 rounded-lg bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 text-[10px] font-bold border border-purple-100 dark:border-purple-900/30">
                                        PIC: {{ $item->pic }}
                                    </span>
                                @else
                                    <span class="text-[10px] text-gray-400">Tanpa PIC</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                        <svg class="w-12 h-12 text-gray-300 dark:text-gray-650 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Belum Ada Rundown Acara</p>
                        <p class="text-xs text-gray-400 mt-1">Susunan rundown hari-H pernikahan Anda belum diunggah oleh WO.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-client-layout>
