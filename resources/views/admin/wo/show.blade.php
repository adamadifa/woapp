<x-admin-layout>
    <div class="space-y-6">
        <!-- Header / Back button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.wo.index') }}" class="p-2 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ $wo->business_name }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Detail Profil, Statistik Performa & Riwayat Project WO.</p>
            </div>
        </div>

        <!-- 3 Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Clients -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total Client Terdaftar</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_clients'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-900/20 text-rose-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>

            <!-- Total Projects -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total Project Keseluruhan</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total_projects'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/20 text-amber-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 00-2 2H7m12 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>

            <!-- Active Projects -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Project Sedang Berjalan (Active)</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['active_projects'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Detail Profile Card -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Info column -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-6">
                <h4 class="font-bold text-sm text-gray-900 dark:text-white border-b border-gray-50 dark:border-gray-700 pb-3">Profil Bisnis</h4>
                
                <div>
                    <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Nama Owner</span>
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 mt-1 block">{{ $wo->user->name ?? 'N/A' }}</span>
                </div>

                <div>
                    <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Email Owner</span>
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 mt-1 block">{{ $wo->user->email ?? 'N/A' }}</span>
                </div>

                <div>
                    <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Nomor Telepon</span>
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 mt-1 block">{{ $wo->phone ?? 'N/A' }}</span>
                </div>

                <div>
                    <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Alamat Kantor / Studio</span>
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 mt-1 block">{{ $wo->address ?? 'N/A' }}</span>
                </div>

                <div>
                    <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Paket Langganan Platform</span>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 dark:bg-rose-950/20 dark:text-rose-400 mt-1.5 inline-block">
                        {{ ucfirst($wo->subscription_plan) }}
                    </span>
                </div>
            </div>

            <!-- Right Projects / Client list column -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm lg:col-span-2 space-y-6">
                <h4 class="font-bold text-sm text-gray-900 dark:text-white border-b border-gray-50 dark:border-gray-700 pb-3">Wedding Projects Terbaru</h4>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="text-gray-400 dark:text-gray-500 font-bold border-b border-gray-100 dark:border-gray-700 pb-2">
                                <th class="pb-2">Nama Project</th>
                                <th class="pb-2">Tanggal Pernikahan</th>
                                <th class="pb-2">Total Budget</th>
                                <th class="pb-2">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-gray-700 dark:text-gray-300">
                            @forelse($wo->projects->take(5) as $project)
                            <tr>
                                <td class="py-3 font-semibold">{{ $project->name }}</td>
                                <td class="py-3">{{ \Carbon\Carbon::parse($project->wedding_date)->format('d M Y') }}</td>
                                <td class="py-3 font-bold">Rp {{ number_format($project->total_budget, 0, ',', '.') }}</td>
                                <td class="py-3">
                                    @if($project->status === 'completed')
                                        <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 dark:bg-emerald-950/20 dark:text-emerald-400 text-[10px] font-bold">Selesai</span>
                                    @elseif($project->status === 'ongoing')
                                        <span class="px-2 py-0.5 rounded bg-indigo-50 text-indigo-600 dark:bg-indigo-950/20 dark:text-indigo-400 text-[10px] font-bold">Berjalan</span>
                                    @elseif($project->status === 'cancelled')
                                        <span class="px-2 py-0.5 rounded bg-red-50 text-red-600 dark:bg-red-950/20 dark:text-red-400 text-[10px] font-bold">Batal</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-600 dark:bg-amber-950/20 dark:text-amber-400 text-[10px] font-bold">Perencanaan</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-gray-400 dark:text-gray-500">
                                    WO ini belum mengelola project pernikahan apapun.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
