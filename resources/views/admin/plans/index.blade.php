<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('Paket Langganan Platform') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kelola daftar paket langganan SaaS, harga bulanan, batasan sistem, dan fitur aktif.</p>
            </div>
            <div>
                <a href="{{ route('admin.plans.create') }}" class="bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md shadow-rose-100 dark:shadow-none transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Paket Baru
                </a>
            </div>
        </div>

        <!-- Alerts -->
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

        <!-- Plans Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-gray-700/20 text-gray-400 dark:text-gray-500 font-bold border-b border-gray-100 dark:border-gray-700">
                            <th class="p-4">Nama Paket</th>
                            <th class="p-4">Slug</th>
                            <th class="p-4">Harga Bulanan</th>
                            <th class="p-4 text-center">Batas Project</th>
                            <th class="p-4 text-center">Batas Tim</th>
                            <th class="p-4 text-center">Custom Landing</th>
                            <th class="p-4 text-center">Dashboard Klien</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-gray-700 dark:text-gray-300 font-medium">
                        @forelse($plans as $plan)
                            <tr class="hover:bg-gray-50/40 dark:hover:bg-gray-700/10 transition-colors">
                                <td class="p-4 font-bold text-gray-900 dark:text-white">
                                    {{ $plan->name }}
                                </td>
                                <td class="p-4 font-mono text-[10px] uppercase text-gray-400">
                                    {{ $plan->slug }}
                                </td>
                                <td class="p-4 font-bold text-rose-600 dark:text-rose-400">
                                    Rp {{ number_format($plan->price, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-center">
                                    {{ $plan->max_projects === -1 ? 'Unlimited' : $plan->max_projects }}
                                </td>
                                <td class="p-4 text-center">
                                    {{ $plan->max_team_members === -1 ? 'Unlimited' : $plan->max_team_members }}
                                </td>
                                <td class="p-4 text-center">
                                    @if($plan->has_custom_landing)
                                        <span class="inline-flex px-1.5 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 text-[10px]">Aktif</span>
                                    @else
                                        <span class="inline-flex px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-400 text-[10px]">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if($plan->has_client_dashboard)
                                        <span class="inline-flex px-1.5 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 text-[10px]">Aktif</span>
                                    @else
                                        <span class="inline-flex px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-400 text-[10px]">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.plans.edit', $plan) }}" class="text-rose-500 hover:text-rose-600 font-bold">Edit</a>
                                        @if(!in_array($plan->slug, ['free', 'basic', 'pro']))
                                            <span class="text-gray-300 dark:text-gray-700">|</span>
                                            <form method="POST" action="{{ route('admin.plans.destroy', $plan) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket langganan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500 font-bold">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-400">Belum ada paket langganan yang dikonfigurasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
