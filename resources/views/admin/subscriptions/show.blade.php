<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.subscriptions.index') }}" class="p-2 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    Invoice #SUB{{ str_pad($subscription->id, 6, '0', STR_PAD_LEFT) }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Detail transaksi pembayaran & persetujuan invoice manual transfer.</p>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Invoice Sheet -->
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm lg:col-span-2 space-y-6">
                <div class="flex justify-between items-start border-b border-gray-50 dark:border-gray-700 pb-6">
                    <div>
                        <span class="w-9 h-9 rounded-xl bg-rose-600 flex items-center justify-center text-white font-bold text-lg shadow-md mb-3">W</span>
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white">WOApp SaaS</h4>
                        <p class="text-[10px] text-gray-400">admin@woapp.com</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Status Bayar</span>
                        <div class="mt-1">
                            @if($subscription->status === 'active')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-950/20 dark:text-emerald-400">Terverifikasi (Active)</span>
                            @elseif($subscription->status === 'pending')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 dark:bg-amber-950/20 dark:text-amber-400">Pending Review</span>
                            @elseif($subscription->status === 'expired')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 dark:bg-gray-700/20 dark:text-gray-400">Expired</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-600 dark:bg-red-950/20 dark:text-red-400">Dibatalkan</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Invoice Billing Info -->
                <div class="grid grid-cols-2 gap-6 text-xs pb-6 border-b border-gray-50 dark:border-gray-700">
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Ditagih Kepada:</span>
                        <p class="font-bold text-gray-800 dark:text-gray-200 mt-1.5">{{ $subscription->woProfile->business_name ?? 'N/A' }}</p>
                        <p class="text-gray-500 mt-1">Owner: {{ $subscription->woProfile->user->name ?? 'N/A' }}</p>
                        <p class="text-gray-500">{{ $subscription->woProfile->user->email ?? '' }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Metode Pembayaran:</span>
                        <p class="font-semibold text-gray-800 dark:text-gray-200 mt-1.5">{{ str_replace('_', ' ', ucfirst($subscription->payment_method)) }}</p>
                        
                        <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mt-4">Tanggal Tagihan:</span>
                        <p class="font-semibold text-gray-800 dark:text-gray-200 mt-1.5">{{ $subscription->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                </div>

                <!-- Invoice Items -->
                <div class="space-y-4">
                    <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block">Rincian Paket</span>
                    <div class="flex items-center justify-between text-xs py-3 border-b border-gray-50 dark:border-gray-700">
                        <div>
                            <p class="font-bold text-gray-800 dark:text-gray-200">Upgrade Plan - {{ ucfirst($subscription->plan) }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Masa aktif langganan platform selama 30 hari ke depan.</p>
                        </div>
                        <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($subscription->amount, 0, ',', '.') }}</span>
                    </div>

                    <!-- Total Row -->
                    <div class="flex justify-between items-center text-sm font-bold pt-2">
                        <span>Total Pembayaran</span>
                        <span class="text-rose-600 dark:text-rose-400 text-lg">Rp {{ number_format($subscription->amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Right: Payment Proof & Actions -->
            <div class="space-y-6">
                <!-- Bukti Transfer -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-4">
                    <h4 class="font-bold text-sm text-gray-900 dark:text-white border-b border-gray-50 dark:border-gray-700 pb-3">Bukti Transfer Bank</h4>
                    
                    @if($subscription->payment_proof)
                        <div class="rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-2">
                            <img src="{{ asset('storage/' . $subscription->payment_proof) }}" alt="Bukti Transfer" class="w-full h-auto rounded-lg max-h-60 object-contain">
                        </div>
                        <div class="text-center">
                            <a href="{{ asset('storage/' . $subscription->payment_proof) }}" target="_blank" class="text-xs text-rose-500 font-bold hover:underline">Buka Gambar Bukti di Tab Baru</a>
                        </div>
                    @else
                        <div class="p-6 text-center border border-dashed border-gray-200 dark:border-gray-700 rounded-xl">
                            <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-xs text-gray-400">Bukti pembayaran belum diunggah oleh WO.</p>
                        </div>
                    @endif
                </div>

                <!-- Approval Actions -->
                @if($subscription->status === 'pending')
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm space-y-3">
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white border-b border-gray-50 dark:border-gray-700 pb-3">Tindakan Persetujuan</h4>
                        
                        <div class="flex flex-col gap-2.5">
                            <!-- Approve Form -->
                            <form method="POST" action="{{ route('admin.subscriptions.approve', $subscription) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-md shadow-emerald-100 dark:shadow-none transition-all flex items-center justify-center gap-1.5" onclick="return confirm('Apakah Anda yakin data transfer ini valid dan ingin menyetujui langganan WO?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Terima Pembayaran
                                </button>
                            </form>

                            <!-- Reject Form -->
                            <form method="POST" action="{{ route('admin.subscriptions.reject', $subscription) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full bg-rose-50 dark:bg-rose-950/20 hover:bg-rose-100 text-rose-600 dark:text-rose-400 text-xs font-bold py-2.5 px-4 rounded-xl transition-all flex items-center justify-center gap-1.5" onclick="return confirm('Apakah Anda yakin ingin menolak transaksi transfer pembayaran ini?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Tolak & Batalkan
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
