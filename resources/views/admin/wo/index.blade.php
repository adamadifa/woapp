<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('Wedding Organizers') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kelola data pendaftaran, lisensi, dan status keaktifan akun Wedding Organizer.</p>
            </div>
        </div>

        <!-- Session Message Alerts -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 text-xs rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-rose-50 dark:bg-rose-950/20 border border-rose-100 dark:border-rose-800 text-rose-600 dark:text-rose-400 text-xs rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Filter & Search Toolbar -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <form method="GET" action="{{ route('admin.wo.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Search Business</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama WO atau email owner..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 pl-10 pr-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none transition-all placeholder:text-gray-400 text-gray-900 dark:text-white">
                    </div>
                </div>

                <!-- Plan Filter -->
                <div>
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Plan</label>
                    <select name="plan" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-3 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-700 dark:text-gray-300">
                        <option value="">Semua Plan</option>
                        <option value="free" {{ request('plan') === 'free' ? 'selected' : '' }}>Free</option>
                        <option value="basic" {{ request('plan') === 'basic' ? 'selected' : '' }}>Basic</option>
                        <option value="pro" {{ request('plan') === 'pro' ? 'selected' : '' }}>Pro</option>
                        <option value="enterprise" {{ request('plan') === 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                    </select>
                </div>

                <!-- Action Button -->
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-md shadow-rose-100 dark:shadow-none transition-all">
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'plan']))
                        <a href="{{ route('admin.wo.index') }}" class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-200 text-xs font-bold py-2.5 px-4 rounded-xl transition-all">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Data Table (Soft Pink Layout) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-gray-700/20 text-gray-400 dark:text-gray-500 font-bold border-b border-gray-100 dark:border-gray-700">
                            <th class="p-4">Nama Bisnis WO</th>
                            <th class="p-4">Email Owner</th>
                            <th class="p-4">No. Telp</th>
                            <th class="p-4">Plan</th>
                            <th class="p-4">Tanggal Daftar</th>
                            <th class="p-4">Status Akun</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-gray-700 dark:text-gray-300 font-medium">
                        @forelse($wos as $wo)
                        <tr class="hover:bg-gray-50/40 dark:hover:bg-gray-700/10 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-rose-50 dark:bg-rose-950/20 text-rose-500 flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($wo->business_name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.wo.show', $wo) }}" class="font-bold text-gray-900 dark:text-white hover:text-rose-500 transition-colors">
                                            {{ $wo->business_name }}
                                        </a>
                                        <p class="text-[10px] text-gray-400 dark:text-gray-500 font-normal mt-0.5">Slug: {{ $wo->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-gray-600 dark:text-gray-400">{{ $wo->user->email ?? 'N/A' }}</td>
                            <td class="p-4 text-gray-600 dark:text-gray-400">{{ $wo->phone ?? 'N/A' }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 dark:bg-rose-950/20 dark:text-rose-400">
                                    {{ ucfirst($wo->subscription_plan) }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-400">{{ $wo->created_at->format('d M Y') }}</td>
                            <td class="p-4">
                                @if($wo->user && $wo->user->is_active)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-950/20 dark:text-emerald-400">Aktif</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-600 dark:bg-red-950/20 dark:text-red-400">Suspended</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Detail -->
                                    <a href="{{ route('admin.wo.show', $wo) }}" class="p-1.5 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 text-gray-500 dark:text-gray-300 rounded-lg transition-colors" title="Detail WO">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <!-- Suspend / Activate -->
                                    <form method="POST" action="{{ route('admin.wo.toggle-status', $wo) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        @if($wo->user && $wo->user->is_active)
                                            <button type="submit" class="p-1.5 bg-amber-50 dark:bg-amber-950/20 hover:bg-amber-100 text-amber-600 dark:text-amber-400 rounded-lg transition-colors" title="Suspend Akun" onclick="return confirm('Apakah Anda yakin ingin menangguhkan (suspend) akun WO ini?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            </button>
                                        @else
                                            <button type="submit" class="p-1.5 bg-emerald-50 dark:bg-emerald-950/20 hover:bg-emerald-100 text-emerald-600 dark:text-emerald-400 rounded-lg transition-colors" title="Aktifkan Akun" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan kembali akun WO ini?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </button>
                                        @endif
                                    </form>

                                    <!-- Delete -->
                                    <form method="POST" action="{{ route('admin.wo.destroy', $wo) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-red-50 dark:bg-red-950/20 hover:bg-red-100 text-red-600 dark:text-red-400 rounded-lg transition-colors" title="Hapus WO" onclick="return confirm('Apakah Anda yakin ingin menghapus data WO ini secara permanen?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400 dark:text-gray-500">
                                Tidak ada data Wedding Organizer yang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Wrapper -->
            @if($wos->hasPages())
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    {{ $wos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
