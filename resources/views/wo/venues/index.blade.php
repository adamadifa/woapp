<x-wo-layout>
    <div class="space-y-6" x-data="{ 
        showCreateModal: false, 
        showEditModal: false,
        editData: {
            id: '',
            name: '',
            address: '',
            capacity: '',
            price: '',
            contact_phone: '',
            facilities: [],
            action: ''
        },
        openEditModal(venue, actionUrl) {
            this.editData.id = venue.id;
            this.editData.name = venue.name;
            this.editData.address = venue.address || '';
            this.editData.capacity = venue.capacity || '';
            this.editData.price = Math.round(venue.price);
            this.editData.contact_phone = venue.contact_phone || '';
            this.editData.facilities = Array.isArray(venue.facilities) ? venue.facilities : [];
            this.editData.action = actionUrl;
            this.showEditModal = true;
        }
    }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('Venues Management') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kelola daftar gedung, taman, maupun lokasi pernikahan mitra beserta kapasitas dan harga sewa.</p>
            </div>
            <div>
                <button @click="showCreateModal = true" class="flex items-center gap-2 bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-md transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Venue Baru</span>
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

        <!-- Search Bar -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between gap-4">
            <form method="GET" action="{{ route('wo.venues.index') }}" class="flex items-center gap-2 w-full">
                <div class="relative w-full max-w-xs">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau alamat venue..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 pl-9 pr-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                </div>
                <button type="submit" class="bg-gray-900 text-white dark:bg-gray-700 hover:bg-gray-800 dark:hover:bg-gray-600 px-4 py-2 rounded-xl text-xs font-bold transition-all">Filter</button>
            </form>
        </div>

        <!-- Venue Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($venues as $venue)
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group overflow-hidden">
                    <div>
                        <!-- Image Gallery (displays first or fallback) -->
                        <div class="h-44 bg-gray-100 dark:bg-gray-700 relative overflow-hidden">
                            @if($venue->images && count($venue->images) > 0)
                                <img src="{{ asset('storage/' . $venue->images[0]) }}" alt="{{ $venue->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                            @endif
                            <div class="absolute bottom-3 left-3 bg-black/60 backdrop-blur-sm text-white px-2 py-0.5 rounded text-[10px] font-bold">
                                Kapasitas: {{ $venue->capacity ?? '-' }} Pax
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 space-y-4">
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-white text-base group-hover:text-pink-500 transition-colors">{{ $venue->name }}</h3>
                                <p class="text-xs text-gray-400 mt-1 flex items-start gap-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>{{ $venue->address ?? 'Alamat belum diatur.' }}</span>
                                </p>
                            </div>

                            <!-- Facilities checkmarks -->
                            @if($venue->facilities && count($venue->facilities) > 0)
                                <div class="space-y-1">
                                    <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Fasilitas</span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($venue->facilities as $fac)
                                            <span class="px-2 py-0.5 rounded bg-gray-50 dark:bg-gray-700/50 text-[10px] text-gray-600 dark:text-gray-300 font-medium">✓ {{ $fac }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Phone contacts -->
                            @if($venue->contact_phone)
                                <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5 pt-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span class="font-mono">{{ $venue->contact_phone }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Pricing & Actions -->
                    <div class="p-5 bg-gray-50/50 dark:bg-gray-800/40 border-t border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <div>
                            <span class="text-[9px] text-gray-400 uppercase tracking-wider block">Harga Sewa</span>
                            <span class="font-extrabold text-gray-900 dark:text-white text-sm">Rp{{ number_format($venue->price, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('wo.venues.availability', $venue) }}" class="p-1.5 bg-pink-50 hover:bg-pink-100 dark:bg-pink-950/20 dark:hover:bg-pink-900/30 text-pink-600 dark:text-pink-400 rounded-lg transition-colors" title="Kalender Ketersediaan">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </a>
                            <button @click="openEditModal({{ json_encode($venue) }}, '{{ route('wo.venues.update', $venue) }}')" class="p-1.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 rounded-lg transition-colors" title="Edit Venue">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('wo.venues.destroy', $venue) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-950/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg transition-colors" onclick="return confirm('Apakah anda yakin ingin menghapus venue ini?')" title="Hapus Venue">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white dark:bg-gray-800 p-12 text-center rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada data venue terdaftar.</p>
                </div>
            @endforelse
        </div>

        @if($venues->hasPages())
            <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm mt-6">
                {{ $venues->links() }}
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
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Venue Baru</h3>
                        <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('wo.venues.store') }}" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                        @csrf
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Venue</label>
                            <input type="text" name="name" required placeholder="Contoh: Gedung Sasana Kriya" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Alamat Lokasi</label>
                            <textarea name="address" placeholder="Tulis alamat lengkap gedung..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all h-20 resize-none"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Kapasitas Tamu (Pax)</label>
                                <input type="number" name="capacity" placeholder="Contoh: 1000" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Harga Sewa (Rp)</label>
                                <input type="number" name="price" required placeholder="Contoh: 25000000" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">No Kontak Gedung</label>
                            <input type="text" name="contact_phone" placeholder="Contoh: 021-xxxxxx" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <!-- Facilities checklist -->
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Fasilitas Penunjang</label>
                            <div class="grid grid-cols-2 gap-2 text-xs text-gray-700 dark:text-gray-300">
                                @foreach(['AC Central', 'Catering Area', 'Ruang Rias', 'Panggung Utama', 'Parking Area', 'Sound System', 'Lighting Standar', 'Listrik Cadangan'] as $fac)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="facilities[]" value="{{ $fac }}" class="rounded text-pink-500 focus:ring-pink-500 dark:bg-gray-900 border-gray-300 dark:border-gray-700">
                                        <span>{{ $fac }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Upload Foto Gedung (Multiple)</label>
                            <input type="file" name="images[]" multiple class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-4 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showCreateModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Simpan Venue
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
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Venue</h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" :action="editData.action" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Venue</label>
                            <input type="text" name="name" x-model="editData.name" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Alamat Lokasi</label>
                            <textarea name="address" x-model="editData.address" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all h-20 resize-none"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Kapasitas Tamu (Pax)</label>
                                <input type="number" name="capacity" x-model="editData.capacity" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Harga Sewa (Rp)</label>
                                <input type="number" name="price" x-model="editData.price" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">No Kontak Gedung</label>
                            <input type="text" name="contact_phone" x-model="editData.contact_phone" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <!-- Facilities checklist -->
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Fasilitas Penunjang</label>
                            <div class="grid grid-cols-2 gap-2 text-xs text-gray-700 dark:text-gray-300">
                                @foreach(['AC Central', 'Catering Area', 'Ruang Rias', 'Panggung Utama', 'Parking Area', 'Sound System', 'Lighting Standar', 'Listrik Cadangan'] as $fac)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="facilities[]" value="{{ $fac }}" x-model="editData.facilities" class="rounded text-pink-500 focus:ring-pink-500 dark:bg-gray-900 border-gray-300 dark:border-gray-700">
                                        <span>{{ $fac }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Tambah Foto Gedung Baru (Biarkan kosong jika tidak diubah)</label>
                            <input type="file" name="images[]" multiple class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-4 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showEditModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Perbarui Venue
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-wo-layout>
