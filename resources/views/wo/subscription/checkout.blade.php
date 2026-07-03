<x-wo-layout>
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Breadcrumb / Header -->
        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
            <a href="{{ route('wo.subscription.index') }}" class="hover:text-pink-500 transition-colors">Langganan & Billing</a>
            <span>&raquo;</span>
            <span class="text-gray-850 dark:text-gray-250 font-bold">Checkout</span>
        </div>

        <div>
            <h1 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">Checkout Upgrade Paket</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Selesaikan transfer manual dan unggah bukti transaksi Anda di bawah ini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Side: Payment Form -->
            <div class="md:col-span-2 space-y-6">
                <!-- Payment Instructions -->
                <div class="bg-white dark:bg-gray-850 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-xs text-gray-900 dark:text-white uppercase tracking-wider">Langkah Pembayaran</h3>
                    
                    <ol class="space-y-3.5 text-xs text-gray-600 dark:text-gray-400 list-decimal pl-4 leading-relaxed">
                        <li>
                            Transfer nominal tepat sebesar 
                            <strong class="text-gray-900 dark:text-white text-sm block my-1">
                                Rp {{ number_format($planData['price'], 0, ',', '.') }}
                            </strong>
                            ke salah satu rekening resmi kami di bawah ini:
                            <div class="mt-3 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-800 text-xs leading-relaxed text-gray-700 dark:text-gray-300 font-semibold whitespace-pre-line">
                                {!! nl2br(e($bankTransferInfo)) !!}
                            </div>
                        </li>
                        <li>Ambil screenshot bukti transfer sukses.</li>
                        <li>Unggah file foto bukti transfer pada form di bawah dan klik kirim.</li>
                    </ol>
                </div>

                <!-- Form Upload -->
                <div class="bg-white dark:bg-gray-850 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                    <form method="POST" action="{{ route('wo.subscription.store', $plan) }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-2">Unggah Bukti Transfer</label>
                            
                            <!-- Custom File Upload Area -->
                            <div x-data="{ fileName: null, filePreview: null }" class="space-y-3">
                                <div class="relative border-2 border-dashed border-gray-200 dark:border-gray-700 hover:border-pink-400 dark:hover:border-pink-500/50 rounded-2xl p-6 flex flex-col items-center justify-center transition-colors cursor-pointer group bg-gray-50/50 dark:bg-gray-900/20">
                                    <input type="file" name="payment_proof" required accept="image/*" 
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                           @change="
                                               const file = $event.target.files[0];
                                               if (file) {
                                                   fileName = file.name;
                                                   filePreview = URL.createObjectURL(file);
                                               }
                                           ">
                                    
                                    <template x-if="!filePreview">
                                        <div class="text-center space-y-2">
                                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500 group-hover:text-pink-500 transition-colors mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Klik atau seret file gambar bukti transfer ke sini</p>
                                            <p class="text-[10px] text-gray-400 dark:text-gray-500">Mendukung format JPG, PNG (Maks. 2MB)</p>
                                        </div>
                                    </template>

                                    <template x-if="filePreview">
                                        <div class="text-center space-y-3">
                                            <img :src="filePreview" class="max-h-40 object-contain rounded-xl border border-gray-250 mx-auto">
                                            <p class="text-xs font-bold text-gray-700 dark:text-gray-300" x-text="fileName"></p>
                                            <span class="text-[10px] text-pink-500 hover:underline">Ganti Gambar</span>
                                        </div>
                                    </template>
                                </div>
                                <x-input-error :messages="$errors->get('payment_proof')" class="text-xs text-rose-500 mt-1" />
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-3">
                            <a href="{{ route('wo.subscription.index') }}" class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-300 text-xs font-bold py-2.5 px-6 rounded-xl transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-6 rounded-xl shadow-md transition-colors">
                                Kirim Bukti Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Side: Invoice Info -->
            <div class="space-y-4">
                <div class="bg-white dark:bg-gray-850 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-xs text-gray-900 dark:text-white uppercase tracking-wider border-b border-gray-50 dark:border-gray-800 pb-2">Ringkasan Invoice</h3>
                    
                    <div class="space-y-2">
                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider block">Paket Upgrade</span>
                        <span class="text-lg font-black text-gray-900 dark:text-white uppercase">{{ $planData['name'] }} Plan</span>
                    </div>

                    <div class="space-y-3.5 text-xs border-t border-gray-100 dark:border-gray-800 pt-4">
                        <div class="flex items-center justify-between text-gray-500 dark:text-gray-400">
                            <span>Masa Aktif</span>
                            <span class="font-bold text-gray-800 dark:text-gray-200">30 Hari</span>
                        </div>
                        <div class="flex items-center justify-between text-gray-500 dark:text-gray-400">
                            <span>Harga Paket</span>
                            <span class="font-bold text-gray-850 dark:text-gray-200">Rp {{ number_format($planData['price'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-gray-500 dark:text-gray-400">
                            <span>PPN (0%)</span>
                            <span class="font-bold text-gray-850 dark:text-gray-200">Rp 0</span>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-800 pt-3.5 text-sm font-black text-gray-900 dark:text-white">
                            <span>Total Bayar</span>
                            <span class="text-pink-500">Rp {{ number_format($planData['price'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-wo-layout>
