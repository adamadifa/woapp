<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('System Settings') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Konfigurasi variabel global platform, email kontak, info rekening, dan profil aplikasi.</p>
            </div>
        </div>

        <!-- Session Message Alerts -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 text-xs rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="max-w-3xl bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                @csrf
                <!-- App Name -->
                <div>
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Aplikasi / Platform</label>
                    <input type="text" name="app_name" value="{{ $settings['app_name'] ?? '' }}" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                </div>

                <!-- Contact & Support Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Email Support Resmi</label>
                        <input type="email" name="company_email" value="{{ $settings['company_email'] ?? '' }}" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Telepon / WhatsApp CS</label>
                        <input type="text" name="company_phone" value="{{ $settings['company_phone'] ?? '' }}" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                    </div>
                </div>

                <!-- Company Address -->
                <div>
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Alamat Kantor Pusat</label>
                    <textarea name="company_address" rows="3" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">{{ $settings['company_address'] ?? '' }}</textarea>
                </div>

                <!-- Subscription Pricing Settings -->
                <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                    <h3 class="font-bold text-xs text-gray-900 dark:text-white uppercase tracking-wider mb-4">Pengaturan Harga Paket Langganan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Harga Paket Basic (IDR)</label>
                            <input type="number" name="plan_basic_price" value="{{ $settings['plan_basic_price'] ?? 199000 }}" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Harga Paket Pro (IDR)</label>
                            <input type="number" name="plan_pro_price" value="{{ $settings['plan_pro_price'] ?? 499000 }}" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Harga Paket Enterprise (IDR)</label>
                            <input type="number" name="plan_enterprise_price" value="{{ $settings['plan_enterprise_price'] ?? 999000 }}" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>
                    </div>
                </div>

                <!-- Bank Info -->
                <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Informasi Rekening Bank Pembayaran Manual</label>
                    <textarea name="bank_transfer_info" rows="3" required placeholder="Bank ... Rekening: ... A/n: ..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">{{ $settings['bank_transfer_info'] ?? '' }}</textarea>
                    <span class="text-[10px] text-gray-400 dark:text-gray-500 mt-1 block">Catatan: Info rekening ini akan ditampilkan pada panel WO saat mereka melakukan pengajuan/upgrade paket langganan manual.</span>
                </div>

                <div class="flex justify-end pt-2 border-t border-gray-50 dark:border-gray-700">
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold py-2.5 px-6 rounded-xl shadow-md shadow-rose-100 dark:shadow-none transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
