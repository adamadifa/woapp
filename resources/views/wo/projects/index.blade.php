<x-wo-layout>
    <div class="space-y-6" x-data="{ 
        showCreateModal: false, 
        showEditModal: false,
        editData: {
            id: '',
            name: '',
            client_id: '',
            wedding_date: '',
            venue_id: '',
            total_budget: '',
            status: 'planning',
            action: ''
        },
        openEditModal(project, actionUrl) {
            this.editData.id = project.id;
            this.editData.name = project.name;
            this.editData.client_id = project.client_id;
            this.editData.wedding_date = project.wedding_date;
            this.editData.venue_id = project.venue_id || '';
            this.editData.total_budget = Math.round(project.total_budget);
            this.editData.status = project.status;
            this.editData.action = actionUrl;
            this.showEditModal = true;
        }
    }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('Wedding Projects') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kelola seluruh agenda acara pernikahan klien yang sedang direncanakan maupun berlangsung.</p>
            </div>
            <div>
                <button @click="showCreateModal = true" class="flex items-center gap-2 bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-md transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Buat Project Baru</span>
                </button>
            </div>
        </div>

        <!-- Session Message Alerts -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 text-xs rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter and Search Bar -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Filter Status Links -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('wo.projects.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all border {{ !request('status') ? 'bg-pink-500 text-white border-pink-500' : 'bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 border-gray-100 dark:border-gray-600' }}">
                    Semua Status
                </a>
                @foreach(['planning', 'ongoing', 'completed', 'cancelled'] as $st)
                    <a href="{{ route('wo.projects.index', ['status' => $st, 'search' => request('search')]) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all border uppercase tracking-wider text-[10px] {{ request('status') === $st ? 'bg-pink-500 text-white border-pink-500' : 'bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 border-gray-100 dark:border-gray-600' }}">
                        {{ $st }}
                    </a>
                @endforeach
            </div>

            <!-- Search Field -->
            <form method="GET" action="{{ route('wo.projects.index') }}" class="flex items-center gap-2">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="relative w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama project..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 pl-9 pr-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                </div>
                <button type="submit" class="bg-gray-900 text-white dark:bg-gray-700 hover:bg-gray-800 dark:hover:bg-gray-600 px-4 py-2 rounded-xl text-xs font-bold transition-all">Cari</button>
            </form>
        </div>

        <!-- Project Grid List -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                    <div class="p-6 space-y-4">
                        <!-- Header and status -->
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="font-bold text-gray-950 dark:text-white group-hover:text-pink-500 transition-colors text-base">{{ $project->name }}</h3>
                                <p class="text-[10px] text-gray-400 mt-1">Klien: {{ $project->client->groom_name }} & {{ $project->client->bride_name }}</p>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-lg text-[9px] font-bold uppercase tracking-wider 
                                @if($project->status === 'planning') bg-amber-500 text-white
                                @elseif($project->status === 'ongoing') bg-indigo-500 text-white
                                @elseif($project->status === 'completed') bg-emerald-500 text-white
                                @else bg-gray-500 text-white @endif">
                                {{ $project->status }}
                            </span>
                        </div>

                        <!-- Info details -->
                        <div class="space-y-2 text-xs text-gray-500 dark:text-gray-400 pt-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">{{ date('d M Y', strtotime($project->wedding_date)) }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ $project->venue->name ?? 'Venue Belum Ditentukan' }}</span>
                            </div>
                        </div>

                        <!-- Budget details -->
                        <div class="pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Total Kelola Budget</span>
                            <span class="font-extrabold text-gray-950 dark:text-white text-base">Rp{{ number_format($project->total_budget, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-800/40 border-t border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <a href="{{ route('wo.projects.show', $project) }}" class="inline-flex items-center gap-1 bg-pink-500 hover:bg-pink-600 text-white text-[10px] font-bold py-1.5 px-3 rounded-lg shadow-sm shadow-pink-100 dark:shadow-none transition-all transform hover:-translate-y-0.5">
                            <span>Kelola Detail</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>

                        <div class="flex items-center gap-1.5">
                            <form method="POST" action="{{ route('wo.projects.duplicate', $project) }}" class="inline">
                                @csrf
                                <button type="submit" class="p-1.5 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/20 dark:hover:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg transition-colors" title="Duplikasi Project">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
                                </button>
                            </form>
                            <button @click="openEditModal({{ json_encode($project) }}, '{{ route('wo.projects.update', $project) }}')" class="p-1.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 rounded-lg transition-colors" title="Edit Project">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('wo.projects.destroy', $project) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-950/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg transition-colors" onclick="return confirm('Apakah anda yakin ingin menghapus project ini?')" title="Hapus Project">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white dark:bg-gray-800 p-12 text-center rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada wedding project terdaftar.</p>
                </div>
            @endforelse
        </div>

        @if($projects->hasPages())
            <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm mt-6">
                {{ $projects->links() }}
            </div>
        @endif

        <!-- Create Modal -->
        <div x-show="showCreateModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showCreateModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Buat Project Baru</h3>
                        <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('wo.projects.store') }}" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                        @csrf
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Event / Project</label>
                            <input type="text" name="name" required placeholder="Contoh: Budi & Rina Wedding Event" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Hubungkan Klien</label>
                                <select name="client_id" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="">Pilih Klien</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->groom_name }} & {{ $client->bride_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Tanggal Pernikahan</label>
                                <input type="date" name="wedding_date" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Venue</label>
                                <select name="venue_id" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="">Pilih Venue (Opsional)</option>
                                    @foreach($venues as $venue)
                                        <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Total Budget (Rp)</label>
                                <input type="number" name="total_budget" required placeholder="Contoh: 100000000" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Status Project</label>
                            <select name="status" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                <option value="planning">Planning (Persiapan Awal)</option>
                                <option value="ongoing">Ongoing (Proses Berlangsung)</option>
                                <option value="completed">Completed (Selesai)</option>
                                <option value="cancelled">Cancelled (Dibatalkan)</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showCreateModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Buat Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="showEditModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-sm" @click="showEditModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Wedding Project</h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" :action="editData.action" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Event / Project</label>
                            <input type="text" name="name" x-model="editData.name" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Hubungkan Klien</label>
                                <select name="client_id" x-model="editData.client_id" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="">Pilih Klien</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->groom_name }} & {{ $client->bride_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Tanggal Pernikahan</label>
                                <input type="date" name="wedding_date" x-model="editData.wedding_date" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Venue</label>
                                <select name="venue_id" x-model="editData.venue_id" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                    <option value="">Pilih Venue (Opsional)</option>
                                    @foreach($venues as $venue)
                                        <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Total Budget (Rp)</label>
                                <input type="number" name="total_budget" x-model="editData.total_budget" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Status Project</label>
                            <select name="status" x-model="editData.status" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                <option value="planning">Planning (Persiapan Awal)</option>
                                <option value="ongoing">Ongoing (Proses Berlangsung)</option>
                                <option value="completed">Completed (Selesai)</option>
                                <option value="cancelled">Cancelled (Dibatalkan)</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showEditModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Perbarui Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-wo-layout>
