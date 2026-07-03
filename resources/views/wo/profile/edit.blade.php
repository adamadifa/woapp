<x-wo-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('Profil Bisnis Wedding Organizer') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kelola identitas publik, deskripsi layanan, dan informasi kontak bisnis Anda.</p>
            </div>
        </div>

        <!-- Session Message Alerts -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 text-xs rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden max-w-4xl">
            <form method="POST" action="{{ route('wo.profile.update') }}" enctype="multipart/form-data" class="divide-y divide-gray-100 dark:divide-gray-700">
                @csrf
                @method('PUT')

                <!-- Logo Section -->
                <div class="p-6 md:p-8 space-y-6" x-data="{ logoUrl: '{{ $profile->logo ? asset('storage/' . $profile->logo) : '' }}', deleteLogo: false }">
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white uppercase tracking-wider text-[11px]">Logo Bisnis</h3>
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <div class="relative w-24 h-24 rounded-2xl overflow-hidden bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 flex items-center justify-center text-gray-400 shrink-0">
                            <template x-if="logoUrl && !deleteLogo">
                                <div class="relative w-full h-full group">
                                    <img :src="logoUrl" alt="Logo" class="w-full h-full object-cover">
                                    <button type="button" @click="deleteLogo = true" class="absolute top-1.5 right-1.5 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-md transition-colors" title="Hapus Logo">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </template>
                            <template x-if="!logoUrl || deleteLogo">
                                <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </template>
                        </div>
                        <div class="space-y-2 text-center sm:text-left">
                            <label class="inline-block bg-pink-50 hover:bg-pink-100 dark:bg-pink-950/30 dark:hover:bg-pink-900/40 text-pink-600 dark:text-pink-400 px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer border border-pink-100 dark:border-pink-900/50">
                                <span>Pilih File Logo</span>
                                <input type="file" name="logo" class="hidden" accept="image/*" @change="deleteLogo = false; logoUrl = URL.createObjectURL($event.target.files[0])">
                            </label>
                            <p class="text-[10px] text-gray-400 dark:text-gray-500">Format yang direkomendasikan: JPG, PNG (Max. 2MB). Rasio 1:1.</p>
                        </div>
                    </div>
                    <input type="hidden" name="delete_logo" :value="deleteLogo ? '1' : '0'">
                </div>

                <!-- Form Fields -->
                <div class="p-6 md:p-8 space-y-6">
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white uppercase tracking-wider text-[11px]">Informasi Bisnis</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Bisnis WO</label>
                            <input type="text" name="business_name" value="{{ old('business_name', $profile->business_name) }}" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" placeholder="Contoh: 08123456789" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Alamat Kantor</label>
                            <textarea name="address" rows="2" placeholder="Masukkan alamat lengkap kantor WO Anda..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">{{ old('address', $profile->address) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Deskripsi Singkat / Tentang Bisnis</label>
                            <textarea name="description" rows="4" placeholder="Ceritakan keunggulan layanan Wedding Organizer Anda kepada calon klien..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">{{ old('description', $profile->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Footer / Action -->
                <div class="p-6 md:p-8 bg-gray-50/50 dark:bg-gray-800/50 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-mono px-2 py-1 rounded bg-pink-100/50 text-pink-700 dark:bg-pink-950/40 dark:text-pink-400 uppercase tracking-wider font-bold">
                            Plan: {{ strtoupper($profile->subscription_plan) }}
                        </span>
                    </div>
                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-6 rounded-xl shadow-md shadow-pink-100 dark:shadow-none transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-wo-layout>
