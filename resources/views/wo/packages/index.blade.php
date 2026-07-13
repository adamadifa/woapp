<x-wo-layout>
    <div class="space-y-6" x-data="{ 
        showCreateModal: false, 
        showEditModal: false,
        createItems: [''],
        editItems: [],
        editData: {
            id: '',
            name: '',
            description: '',
            price: '',
            is_active: true,
            vendor_ids: [],
            action: ''
        },
        openEditModal(pkg, actionUrl) {
            this.editData.id = pkg.id;
            this.editData.name = pkg.name;
            this.editData.description = pkg.description;
            this.editData.price = pkg.price;
            this.editData.is_active = pkg.is_active;
            this.editData.action = actionUrl;
            this.editItems = pkg.items ? [...pkg.items] : [''];
            this.editData.vendor_ids = pkg.vendors ? pkg.vendors.map(v => v.id) : [];
            this.showEditModal = true;
        }
    }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('Paket Pernikahan') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kelola paket pernikahan, harga, dan rincian item layanan yang Anda tawarkan.</p>
            </div>
            <div>
                <button @click="showCreateModal = true" class="flex items-center gap-2 bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-md shadow-pink-100 dark:shadow-none transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Paket Baru</span>
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

        <!-- Card Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($packages as $pkg)
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col justify-between group hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                    
                    <!-- Cover Image Placeholder or Real image -->
                    <div class="h-44 bg-gray-100 dark:bg-gray-900 relative overflow-hidden flex items-center justify-center text-gray-400">
                        @if(!empty($pkg->images) && count($pkg->images) > 0)
                            <img src="{{ asset('storage/' . $pkg->images[0]) }}" alt="{{ $pkg->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-pink-50 to-indigo-50 dark:from-pink-950/20 dark:to-indigo-950/20 flex flex-col items-center justify-center gap-2">
                                <svg class="w-8 h-8 text-pink-300 dark:text-pink-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-[10px] uppercase font-bold tracking-wider text-pink-500/60 dark:text-pink-400/40">Paket Wedding</span>
                            </div>
                        @endif

                        <div class="absolute top-4 right-4">
                            <span class="px-2 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider {{ $pkg->is_active ? 'bg-emerald-500 text-white' : 'bg-gray-500 text-white' }}">
                                {{ $pkg->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <div class="flex items-start justify-between gap-4">
                                <h3 class="font-bold text-gray-950 dark:text-white group-hover:text-pink-500 transition-colors text-base">{{ $pkg->name }}</h3>
                            </div>
                            
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-3">
                                {{ $pkg->description }}
                            </p>
                        </div>

                        <!-- Included items preview -->
                        @if(!empty($pkg->items))
                            <div class="pt-3 border-t border-gray-50 dark:border-gray-700/50 space-y-1.5">
                                <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Fasilitas Termasuk:</span>
                                <div class="flex flex-wrap gap-1">
                                    @foreach(array_slice($pkg->items, 0, 3) as $item)
                                        <span class="px-2 py-0.5 rounded bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-[10px] font-medium border border-gray-100 dark:border-gray-600 truncate max-w-[150px]" title="{{ $item }}">✔ {{ $item }}</span>
                                    @endforeach
                                    @if(count($pkg->items) > 3)
                                        <span class="px-2 py-0.5 rounded bg-pink-50 dark:bg-pink-950/20 text-pink-600 dark:text-pink-400 text-[10px] font-bold border border-pink-100 dark:border-pink-900/30">+{{ count($pkg->items) - 3 }} Lainnya</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Pilihan Vendor Terkait -->
                        @if($pkg->vendors->isNotEmpty())
                            <div class="pt-3 border-t border-gray-50 dark:border-gray-700/50 space-y-1.5">
                                <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Pilihan Vendor Terkait:</span>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($pkg->vendors->groupBy('category') as $category => $categoryVendors)
                                        <span class="px-2 py-0.5 rounded bg-pink-50/50 dark:bg-pink-950/10 text-pink-600 dark:text-pink-400 text-[10px] font-medium border border-pink-100/30 dark:border-pink-900/10 truncate max-w-[200px]" title="{{ $category }}: {{ $categoryVendors->pluck('name')->implode(', ') }}">
                                            <strong>{{ $category }}</strong>: {{ $categoryVendors->count() }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="pt-4 flex items-center justify-between border-t border-gray-50 dark:border-gray-700/50">
                            <div>
                                <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Harga Paket</span>
                                <span class="font-extrabold text-gray-950 dark:text-white text-base">Rp{{ number_format($pkg->price, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex items-center gap-1.5">
                                <button @click="openEditModal({{ json_encode($pkg) }}, '{{ route('wo.packages.update', $pkg) }}')" class="p-1.5 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-500 dark:text-gray-300 rounded-lg transition-colors" title="Edit Paket">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form method="POST" action="{{ route('wo.packages.destroy', $pkg) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 bg-red-50 dark:bg-red-950/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg transition-colors" onclick="return confirm('Apakah anda yakin ingin menghapus paket ini?')" title="Hapus Paket">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white dark:bg-gray-800 p-12 text-center rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada paket pernikahan terdaftar.</p>
                </div>
            @endforelse
        </div>

        @if($packages->hasPages())
            <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm mt-6">
                {{ $packages->links() }}
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

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Paket Wedding</h3>
                        <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('wo.packages.store') }}" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Paket</label>
                                <input type="text" name="name" required placeholder="Contoh: Paket Gold (300 Undangan)" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Harga Paket (Rp)</label>
                                <input type="number" name="price" required placeholder="Contoh: 15000000" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                            <div class="flex items-center pl-4 pt-5">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-pink-600"></div>
                                    <span class="ms-3 text-xs font-semibold text-gray-700 dark:text-gray-300">Aktifkan Paket</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Deskripsi Paket</label>
                            <textarea name="description" rows="3" required placeholder="Tuliskan gambaran umum dari paket pernikahan ini..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all"></textarea>
                        </div>

                        <!-- Dynamic Items Section -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Item / Fasilitas Layanan</label>
                            <div class="space-y-2">
                                <template x-for="(item, index) in createItems" :key="index">
                                    <div class="flex items-center gap-2">
                                        <input type="text" name="items[]" x-model="createItems[index]" placeholder="Contoh: Catering 500 Pax, MUA Wedding, Dekorasi Ballroom" required class="flex-1 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                                        <button type="button" @click="if (createItems.length > 1) createItems.splice(index, 1)" class="p-2.5 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 dark:bg-red-950/20 dark:text-red-400 transition-colors">
                                            ✕
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <button type="button" @click="createItems.push('')" class="text-xs text-pink-600 dark:text-pink-400 font-bold hover:underline flex items-center gap-1 mt-1">
                                + Tambah Item Baru
                            </button>
                        </div>

                        <!-- Pilihan Vendor Terkait -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Pilihan Vendor Terkait (Bisa Dipilih)</label>
                            <div class="p-4 bg-gray-50/50 dark:bg-gray-900/30 rounded-2xl border border-gray-100 dark:border-gray-700/50 space-y-4 max-h-48 overflow-y-auto">
                                @forelse($vendors->groupBy('category') as $category => $categoryVendors)
                                    <div>
                                        <span class="text-[10px] font-extrabold text-pink-600 dark:text-pink-400 uppercase tracking-wider block mb-2">{{ $category }}</span>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            @foreach($categoryVendors as $v)
                                                <label class="inline-flex items-center text-xs text-gray-700 dark:text-gray-300 cursor-pointer">
                                                    <input type="checkbox" name="vendor_ids[]" value="{{ $v->id }}" class="rounded border-gray-300 dark:border-gray-700 text-pink-600 focus:ring-pink-500 mr-2">
                                                    <span>{{ $v->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <span class="text-xs text-gray-400">Belum ada vendor terdaftar. Tambahkan vendor terlebih dahulu.</span>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Foto Paket (Max 2MB)</label>
                            <input type="file" name="images[]" multiple class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-4 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showCreateModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Simpan Paket
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

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-gray-100 dark:border-gray-700"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Paket Wedding</h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" :action="editData.action" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Paket</label>
                                <input type="text" name="name" x-model="editData.name" required placeholder="Contoh: Paket Gold (300 Undangan)" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Harga Paket (Rp)</label>
                                <input type="number" name="price" x-model="editData.price" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>
                            <div class="flex items-center pl-4 pt-5">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" x-model="editData.is_active" class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-pink-600"></div>
                                    <span class="ms-3 text-xs font-semibold text-gray-700 dark:text-gray-300">Aktifkan Paket</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Deskripsi Paket</label>
                            <textarea name="description" rows="3" x-model="editData.description" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all"></textarea>
                        </div>

                        <!-- Dynamic Items Section -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Item / Fasilitas Layanan</label>
                            <div class="space-y-2">
                                <template x-for="(item, index) in editItems" :key="index">
                                    <div class="flex items-center gap-2">
                                        <input type="text" name="items[]" x-model="editItems[index]" placeholder="Contoh: Catering 500 Pax, MUA Wedding, Dekorasi Ballroom" required class="flex-1 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                                        <button type="button" @click="if (editItems.length > 1) editItems.splice(index, 1)" class="p-2.5 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 dark:bg-red-950/20 dark:text-red-400 transition-colors">
                                            ✕
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <button type="button" @click="editItems.push('')" class="text-xs text-pink-600 dark:text-pink-400 font-bold hover:underline flex items-center gap-1 mt-1">
                                + Tambah Item Baru
                            </button>
                        </div>

                        <!-- Pilihan Vendor Terkait -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Pilihan Vendor Terkait (Bisa Dipilih)</label>
                            <div class="p-4 bg-gray-50/50 dark:bg-gray-900/30 rounded-2xl border border-gray-100 dark:border-gray-700/50 space-y-4 max-h-48 overflow-y-auto">
                                @forelse($vendors->groupBy('category') as $category => $categoryVendors)
                                    <div>
                                        <span class="text-[10px] font-extrabold text-pink-600 dark:text-pink-400 uppercase tracking-wider block mb-2">{{ $category }}</span>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            @foreach($categoryVendors as $v)
                                                <label class="inline-flex items-center text-xs text-gray-700 dark:text-gray-300 cursor-pointer">
                                                    <input type="checkbox" name="vendor_ids[]" value="{{ $v->id }}" x-model="editData.vendor_ids" class="rounded border-gray-300 dark:border-gray-700 text-pink-600 focus:ring-pink-500 mr-2">
                                                    <span>{{ $v->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <span class="text-xs text-gray-400">Belum ada vendor terdaftar. Tambahkan vendor terlebih dahulu.</span>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Foto Paket (Biarkan kosong jika tidak ingin mengubah, Max 2MB)</label>
                            <input type="file" name="images[]" multiple class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-4 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                            <button type="button" @click="showEditModal = false" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-bold rounded-xl transition-all">
                                Batal
                            </button>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                                Perbarui Paket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-wo-layout>
