<x-client-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-xl font-extrabold text-gray-950 dark:text-white tracking-tight">Mitra Vendor Pernikahan</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Daftar vendor resmi yang dikontrak untuk melayani hari bahagia pernikahan Anda.</p>
        </div>

        <!-- Vendors Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($vendors as $vendor)
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-0.5 rounded-lg bg-purple-50 dark:bg-purple-950/20 text-purple-600 dark:text-purple-400 text-[10px] font-bold border border-purple-100 dark:border-purple-900/30 uppercase tracking-wider">
                                {{ $vendor->category }}
                            </span>
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-base">{{ $vendor->name }}</h3>
                            <p class="text-xs text-gray-450 mt-1">{{ $vendor->description ?? 'Tidak ada keterangan vendor.' }}</p>
                        </div>
                    </div>

                    <!-- Contact Bar -->
                    <div class="pt-4 border-t border-gray-50 dark:border-gray-700 flex items-center justify-between">
                        <div class="flex flex-col text-[11px] text-gray-450">
                            <span>PIC Vendor</span>
                            <span class="font-bold text-gray-900 dark:text-white mt-0.5">{{ $vendor->contact_person ?? '-' }}</span>
                        </div>
                        
                        @if($vendor->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $vendor->phone) }}" target="_blank" class="flex items-center gap-1 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs py-1.5 px-3 rounded-lg shadow-sm transition-all shrink-0">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.966-1.862-1.865-4.334-2.889-6.969-2.89-5.438 0-9.863 4.373-9.868 9.802-.002 1.761.478 3.483 1.393 5.006L1.874 22l6.002-1.573 border-none"/></svg>
                                <span>Hubungi</span>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-500 dark:text-gray-400">
                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-650 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Belum Ada Vendor Mitra</p>
                    <p class="text-xs text-gray-400 mt-1">Vendor resmi pernikahan Anda belum didaftarkan di sistem oleh WO.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-client-layout>
