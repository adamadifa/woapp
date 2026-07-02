<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('Kategori Vendor') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kelola master kategori vendor pernikahan global yang tersedia di platform.</p>
            </div>
        </div>

        <!-- Session Message Alerts -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 text-xs rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <!-- Left: Table list -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden lg:col-span-2">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-gray-700/20 text-gray-400 dark:text-gray-500 font-bold border-b border-gray-100 dark:border-gray-700">
                                <th class="p-4">Kategori</th>
                                <th class="p-4">Slug</th>
                                <th class="p-4">Icon Key</th>
                                <th class="p-4">Deskripsi</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-gray-700 dark:text-gray-300 font-medium">
                            @forelse($categories as $category)
                            <tr x-data="{ editing: false, name: '{{ $category->name }}', icon: '{{ $category->icon }}', desc: '{{ $category->description }}' }" class="hover:bg-gray-50/40 dark:hover:bg-gray-700/10 transition-colors">
                                <!-- View mode -->
                                <td class="p-4" x-show="!editing">
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $category->name }}</span>
                                </td>
                                <td class="p-4 text-gray-400" x-show="!editing">{{ $category->slug }}</td>
                                <td class="p-4 text-gray-500" x-show="!editing">
                                    <span class="px-2 py-0.5 rounded bg-rose-50 text-rose-600 dark:bg-rose-950/20 dark:text-rose-400 font-mono text-[10px]">{{ $category->icon }}</span>
                                </td>
                                <td class="p-4 text-gray-500 dark:text-gray-400 max-w-xs truncate" x-show="!editing" title="{{ $category->description }}">{{ $category->description ?? '-' }}</td>

                                <!-- Edit inline mode -->
                                <td colspan="4" class="p-4" x-show="editing">
                                    <form method="POST" action="{{ route('admin.vendor-categories.update', $category) }}" class="grid grid-cols-3 gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" x-model="name" required class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg p-2 text-xs text-gray-900 dark:text-white focus:outline-none">
                                        <input type="text" name="icon" x-model="icon" class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg p-2 text-xs text-gray-900 dark:text-white focus:outline-none">
                                        <input type="text" name="description" x-model="desc" class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg p-2 text-xs text-gray-900 dark:text-white focus:outline-none">
                                        <div class="col-span-3 flex justify-end gap-2 mt-1">
                                            <button type="button" @click="editing = false" class="text-[10px] text-gray-400 font-bold px-2 py-1 rounded">Batal</button>
                                            <button type="submit" class="text-[10px] bg-rose-500 text-white font-bold px-3 py-1 rounded shadow">Simpan</button>
                                        </div>
                                    </form>
                                </td>

                                <td class="p-4 text-center" x-show="!editing">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="editing = true" class="p-1.5 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 text-gray-500 dark:text-gray-300 rounded-lg transition-colors" title="Edit inline">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <form method="POST" action="{{ route('admin.vendor-categories.destroy', $category) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 bg-red-50 dark:bg-red-950/20 hover:bg-red-100 text-red-600 dark:text-red-400 rounded-lg transition-colors" onclick="return confirm('Apakah anda yakin ingin menghapus kategori vendor ini?')" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400 dark:text-gray-500">
                                    Belum ada kategori vendor terdaftar.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($categories->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>

            <!-- Right: Create Box -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-4">
                <h3 class="font-bold text-sm text-gray-900 dark:text-white border-b border-gray-50 dark:border-gray-700 pb-3">Tambah Kategori</h3>
                
                <form method="POST" action="{{ route('admin.vendor-categories.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Kategori</label>
                        <input type="text" name="name" required placeholder="Contoh: MC / Host" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Icon Key (Heroicon/SVG)</label>
                        <input type="text" name="icon" placeholder="Contoh: user-group" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Deskripsi Singkat</label>
                        <textarea name="description" rows="3" placeholder="Deskripsikan layanan vendor ini..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-md shadow-rose-100 dark:shadow-none transition-all">
                        Simpan Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
