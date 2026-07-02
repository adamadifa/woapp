<x-client-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-xl font-extrabold text-gray-950 dark:text-white tracking-tight">Budget Tracker Pernikahan</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Lacak pengeluaran, estimasi, dan dana tersisa untuk pesta pernikahan Anda.</p>
        </div>

        <!-- Budget Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Budget Allocation -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Total Anggaran Pesta</span>
                    <h3 class="text-xl font-extrabold text-gray-950 dark:text-white">Rp {{ number_format($totalBudget, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/20 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>

            <!-- Total Cost Spent -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Total Terpakai (Aktual)</span>
                    <h3 class="text-xl font-extrabold text-gray-950 dark:text-white">Rp {{ number_format($usedBudget, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
            </div>

            <!-- Remaining Budget -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Sisa Anggaran</span>
                    <h3 class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($remainingBudget, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Progress bar card -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-3">
            <div class="flex items-center justify-between text-xs">
                <span class="font-bold text-gray-700 dark:text-gray-300">Penggunaan Anggaran</span>
                <span class="font-mono font-bold text-purple-600">{{ $budgetPercent }}% Terpakai</span>
            </div>
            <div class="w-full bg-gray-100 dark:bg-gray-700 h-3 rounded-full overflow-hidden">
                <div class="bg-purple-600 h-full rounded-full transition-all duration-500" style="width: {{ $budgetPercent }}%"></div>
            </div>
        </div>

        <!-- Budget Table details -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 dark:border-gray-700/50">
                <h3 class="font-bold text-gray-900 dark:text-white text-sm">Rincian Pos Anggaran (Read-Only)</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-gray-900/40 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider border-b border-gray-55 dark:border-gray-750">
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6">Deskripsi / Vendor</th>
                            <th class="py-4 px-6 text-right">Estimasi Biaya</th>
                            <th class="py-4 px-6 text-right">Biaya Aktual</th>
                            <th class="py-4 px-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-750 text-xs">
                        @forelse($budgetItems as $item)
                            <tr class="hover:bg-gray-50/30 dark:hover:bg-gray-900/10 transition-colors text-gray-700 dark:text-gray-300">
                                <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">{{ $item->category }}</td>
                                <td class="py-4 px-6">
                                    <div class="space-y-0.5">
                                        <span class="block text-gray-900 dark:text-white font-medium">{{ $item->description }}</span>
                                        @if($item->vendor)
                                            <span class="block text-[10px] text-gray-400">Vendor: {{ $item->vendor->name }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-right font-mono text-gray-500">Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}</td>
                                <td class="py-4 px-6 text-right font-mono font-bold text-gray-900 dark:text-white">Rp {{ number_format($item->actual_cost, 0, ',', '.') }}</td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider 
                                        @if($item->payment_status === 'paid') bg-emerald-500 text-white
                                        @elseif($item->payment_status === 'dp') bg-amber-500 text-white
                                        @else bg-rose-500 text-white @endif">
                                        {{ strtoupper($item->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-400">
                                    Belum ada pos anggaran terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-client-layout>
