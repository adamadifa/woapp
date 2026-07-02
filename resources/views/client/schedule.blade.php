<x-client-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-extrabold text-gray-950 dark:text-white tracking-tight">Timeline & Milestones Persiapan</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Jadwal target dan tahapan milestones persiapan pernikahan Anda.</p>
            </div>
        </div>

        <!-- Timeline Grid -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="relative border-l-2 border-purple-100 dark:border-gray-700 ml-4 md:ml-32 space-y-8 py-4">
                @forelse($milestones as $ms)
                    <div class="relative">
                        <!-- Dot Indicator -->
                        <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-purple-500 border-4 border-white dark:border-gray-800 shadow"></div>
                        
                        <!-- Desktop Date Left Column -->
                        <div class="hidden md:block absolute -left-32 top-1 text-right w-24">
                            <span class="font-extrabold text-gray-900 dark:text-white text-xs block">
                                {{ \Carbon\Carbon::parse($ms->due_date)->translatedFormat('d M Y') }}
                            </span>
                            <span class="text-[9px] text-gray-400 uppercase font-bold block mt-0.5">
                                {{ \Carbon\Carbon::parse($ms->due_date)->diffForHumans() }}
                            </span>
                        </div>

                        <!-- Card Content -->
                        <div class="ml-6 bg-gray-50/50 dark:bg-gray-900/30 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <div class="space-y-2">
                                <!-- Mobile Date Display -->
                                <div class="md:hidden flex items-center gap-1.5 text-[10px] font-bold text-gray-400">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>Target: {{ \Carbon\Carbon::parse($ms->due_date)->translatedFormat('d M Y') }}</span>
                                </div>

                                <h3 class="font-bold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                                    <span>{{ $ms->title }}</span>
                                    <span class="px-2 py-0.5 text-[9px] font-bold uppercase rounded-full tracking-wider 
                                        @if($ms->status === 'done') bg-emerald-500 text-white
                                        @else bg-amber-500 text-white @endif">
                                        {{ $ms->status === 'done' ? 'Selesai' : 'Belum Selesai' }}
                                    </span>
                                </h3>

                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $ms->description ?? 'Tidak ada keterangan tambahan.' }}</p>

                                <!-- Subtasks (Read-only list) -->
                                @if($ms->tasks && $ms->tasks->count() > 0)
                                    <div class="pt-3 border-t border-gray-100 dark:border-gray-700 space-y-1.5">
                                        <h4 class="text-[10px] uppercase font-bold tracking-wider text-gray-400">Daftar Task:</h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            @foreach($ms->tasks as $task)
                                                <div class="flex items-center gap-2 text-xs">
                                                    @if($task->status === 'done')
                                                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                    @else
                                                        <div class="w-4 h-4 rounded-full border border-gray-300 dark:border-gray-600 shrink-0"></div>
                                                    @endif
                                                    <span class="{{ $task->status === 'done' ? 'line-through text-gray-400 dark:text-gray-505' : 'text-gray-700 dark:text-gray-300' }}">
                                                        {{ $task->title }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                        <svg class="w-12 h-12 text-gray-300 dark:text-gray-650 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Belum Ada Timeline</p>
                        <p class="text-xs text-gray-400 mt-1">Timeline persiapan wedding Anda belum dirilis oleh WO.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-client-layout>
