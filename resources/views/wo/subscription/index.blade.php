<x-wo-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">Status Langganan & Billing</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kelola paket langganan aktif, lakukan upgrade, dan pantau riwayat tagihan bisnis Anda.</p>
        </div>

        <!-- Success & Error Alerts -->
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

        @if($pendingSubscription)
            <div class="p-4 bg-amber-50 dark:bg-amber-950/20 border border-amber-100 dark:border-amber-800 text-amber-700 dark:text-amber-400 text-xs rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <span class="font-bold">Transaksi Tertunda:</span> Pengajuan upgrade ke paket <span class="font-bold uppercase">{{ $pendingSubscription->plan }}</span> (Rp {{ number_format($pendingSubscription->amount, 0, ',', '.') }}) sedang diverifikasi oleh admin. Kami akan mengaktifkan paket Anda segera setelah pembayaran divalidasi.
                </div>
            </div>
        @endif

        <!-- Current Plan Dashboard Card -->
        <div class="bg-white dark:bg-gray-850 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="space-y-2">
                <span class="text-[10px] font-mono px-2 py-1 rounded bg-pink-100 dark:bg-pink-950/40 text-pink-700 dark:text-pink-400 uppercase tracking-wider font-bold">
                    Paket Aktif Saat Ini
                </span>
                <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                    {{ $wo->subscription_plan }} Plan
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    @if($wo->expired_at)
                        Masa aktif berlaku sampai: <span class="font-bold text-gray-800 dark:text-gray-200">{{ $wo->expired_at->format('d M Y') }}</span>
                        @if($wo->expired_at->isPast())
                            <span class="text-red-500 font-bold ml-1">(Kedaluwarsa)</span>
                        @else
                            <span class="text-emerald-500 font-bold ml-1">({{ $wo->expired_at->diffForHumans() }})</span>
                        @endif
                    @else
                        Masa aktif: <span class="font-bold text-emerald-500">Selamanya</span> (Paket Default Free)
                    @endif
                </p>
            </div>
            
            @if($wo->subscription_plan === 'free')
                <div class="bg-pink-50 dark:bg-pink-950/20 p-4 rounded-xl border border-pink-100 dark:border-pink-900/50 max-w-sm">
                    <p class="text-[11px] leading-relaxed text-pink-700 dark:text-pink-400">
                        Anda menggunakan paket Free. Upgrade ke paket <strong>Pro</strong> untuk fitur custom landing page, dashboard klien, dan pembuatan project aktif tanpa batas!
                    </p>
                </div>
            @endif
        </div>

        <!-- Upgrade Subscription Tiers -->
        <div class="space-y-4">
            <h3 class="font-bold text-sm text-gray-900 dark:text-white uppercase tracking-wider text-[11px]">Pilihan Paket Langganan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Basic Plan -->
                <div class="bg-white dark:bg-gray-850 border border-gray-100 dark:border-gray-700 p-6 rounded-2xl flex flex-col justify-between hover:shadow-md transition-all duration-300">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Basic</h4>
                        <div class="my-3">
                            <span class="text-xl font-extrabold text-gray-900 dark:text-white">Rp {{ number_format($prices['basic'], 0, ',', '.') }}</span>
                            <span class="text-xs text-gray-400">/ bulan</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-450 mb-6">Mulai kelola bisnis WO Anda secara semi-digital.</p>
                        
                        <ul class="space-y-2.5 text-xs text-gray-600 dark:text-gray-400 border-t border-gray-100 dark:border-gray-700 pt-5">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Up to 5 Active Projects
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Up to 10 Team Members
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Landing Page Publik ("Powered by")
                            </li>
                        </ul>
                    </div>
                    <div class="mt-8">
                        @if($wo->subscription_plan === 'basic')
                            <button disabled class="w-full bg-gray-100 dark:bg-gray-800 text-gray-400 py-2.5 px-4 rounded-xl text-xs font-bold cursor-not-allowed text-center">
                                Paket Aktif Anda
                            </button>
                        @else
                            <a href="{{ route('wo.subscription.checkout', 'basic') }}" class="w-full inline-flex items-center justify-center bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-300 text-xs font-bold py-2.5 px-4 rounded-xl border border-gray-200 dark:border-gray-700 transition-all text-center">
                                Pilih Basic
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Pro Plan -->
                <div class="bg-white dark:bg-gray-850 border-2 border-pink-500 p-6 rounded-2xl flex flex-col justify-between relative shadow-sm shadow-pink-100 dark:shadow-none">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-gradient-to-r from-pink-500 to-rose-600 text-white text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-full">
                        RECOMMENDED
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Pro</h4>
                        <div class="my-3">
                            <span class="text-xl font-extrabold text-gray-900 dark:text-white">Rp {{ number_format($prices['pro'], 0, ',', '.') }}</span>
                            <span class="text-xs text-gray-400">/ bulan</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-450 mb-6">Paket lengkap & terpopuler untuk agensi planner berkembang.</p>
                        
                        <ul class="space-y-2.5 text-xs text-gray-600 dark:text-gray-400 border-t border-gray-100 dark:border-gray-700 pt-5">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-pink-500 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                <strong>Unlimited Active Projects</strong>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-pink-500 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Unlimited Team Members
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-pink-500 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Custom Public Landing Page (Bebas label)
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-pink-500 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Akses Kolaborasi Klien
                            </li>
                        </ul>
                    </div>
                    <div class="mt-8">
                        @if($wo->subscription_plan === 'pro')
                            <button disabled class="w-full bg-gray-100 dark:bg-gray-800 text-gray-400 py-2.5 px-4 rounded-xl text-xs font-bold cursor-not-allowed text-center">
                                Paket Aktif Anda
                            </button>
                        @else
                            <a href="{{ route('wo.subscription.checkout', 'pro') }}" class="w-full inline-flex items-center justify-center bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-md shadow-pink-100 dark:shadow-none transition-all text-center">
                                Pilih Pro
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Enterprise Plan -->
                <div class="bg-white dark:bg-gray-850 border border-gray-100 dark:border-gray-700 p-6 rounded-2xl flex flex-col justify-between hover:shadow-md transition-all duration-300">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Enterprise</h4>
                        <div class="my-3">
                            <span class="text-xl font-extrabold text-gray-900 dark:text-white">Rp {{ number_format($prices['enterprise'], 0, ',', '.') }}</span>
                            <span class="text-xs text-gray-400">/ bulan</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-450 mb-6">Untuk agensi WO besar dengan multi-tenant & custom domain.</p>
                        
                        <ul class="space-y-2.5 text-xs text-gray-600 dark:text-gray-400 border-t border-gray-100 dark:border-gray-700 pt-5">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Semua Fitur Pro
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Custom Domain Integration
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Multi-Tenant & Dedicated Support
                            </li>
                        </ul>
                    </div>
                    <div class="mt-8">
                        @if($wo->subscription_plan === 'enterprise')
                            <button disabled class="w-full bg-gray-100 dark:bg-gray-800 text-gray-400 py-2.5 px-4 rounded-xl text-xs font-bold cursor-not-allowed text-center">
                                Paket Aktif Anda
                            </button>
                        @else
                            <a href="{{ route('wo.subscription.checkout', 'enterprise') }}" class="w-full inline-flex items-center justify-center bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-300 text-xs font-bold py-2.5 px-4 rounded-xl border border-gray-200 dark:border-gray-700 transition-all text-center">
                                Hubungi Kami
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Billing History Table -->
        <div class="bg-white dark:bg-gray-850 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h3 class="font-bold text-xs text-gray-900 dark:text-white uppercase tracking-wider">Riwayat Pembayaran & Billing</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 text-[10px] text-gray-400 uppercase font-bold tracking-wider border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="py-3 px-6">Tanggal Pengajuan</th>
                            <th class="py-3 px-6">Paket</th>
                            <th class="py-3 px-6">Nominal</th>
                            <th class="py-3 px-6">Metode</th>
                            <th class="py-3 px-6">Bukti Transfer</th>
                            <th class="py-3 px-6 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($subscriptions as $sub)
                            <tr>
                                <td class="py-4 px-6 font-medium text-gray-900 dark:text-white">{{ $sub->created_at->format('d M Y, H:i') }}</td>
                                <td class="py-4 px-6 uppercase font-bold text-gray-850 dark:text-gray-200">{{ $sub->plan }}</td>
                                <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">Rp {{ number_format($sub->amount, 0, ',', '.') }}</td>
                                <td class="py-4 px-6 capitalize">{{ str_replace('_', ' ', $sub->payment_method) }}</td>
                                <td class="py-4 px-6">
                                    @if($sub->payment_proof)
                                        <a href="{{ asset('storage/' . $sub->payment_proof) }}" target="_blank" class="text-pink-500 hover:text-pink-600 hover:underline inline-flex items-center gap-1 font-bold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.43 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            Lihat Bukti
                                        </a>
                                    @else
                                        <span class="text-gray-400">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    @if($sub->status === 'active')
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-450 uppercase">Aktif</span>
                                    @elseif($sub->status === 'pending')
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-450 uppercase">Pending</span>
                                    @elseif($sub->status === 'expired')
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-bold bg-gray-150 dark:bg-gray-800 text-gray-500 dark:text-gray-400 uppercase">Expired</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-50 dark:bg-rose-950/20 text-rose-600 dark:text-rose-450 uppercase">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400 dark:text-gray-500">Belum ada riwayat transaksi pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-wo-layout>
