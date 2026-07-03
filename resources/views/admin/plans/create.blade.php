<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.plans.index') }}" class="p-2 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('Tambah Paket Baru') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Buat opsi paket langganan SaaS baru untuk Wedding Organizer.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="max-w-3xl bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <form method="POST" action="{{ route('admin.plans.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Nama Paket</label>
                        <input type="text" name="name" required placeholder="Contoh: Pro Plus" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                        <x-input-error :messages="$errors->get('name')" class="text-xs text-rose-500 mt-1" />
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Slug Paket (Identifikasi Sistem)</label>
                        <input type="text" name="slug" required placeholder="Contoh: pro-plus" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                        <x-input-error :messages="$errors->get('slug')" class="text-xs text-rose-500 mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Price -->
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Harga Bulanan (Rupiah)</label>
                        <input type="number" name="price" required placeholder="Contoh: 750000" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                        <x-input-error :messages="$errors->get('price')" class="text-xs text-rose-500 mt-1" />
                    </div>

                    <!-- Max Active Projects -->
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Batas Proyek Aktif (-1 = Tanpa Batas)</label>
                        <input type="number" name="max_projects" required placeholder="-1" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                        <x-input-error :messages="$errors->get('max_projects')" class="text-xs text-rose-500 mt-1" />
                    </div>

                    <!-- Max Team Members -->
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Batas Anggota Tim (-1 = Tanpa Batas)</label>
                        <input type="number" name="max_team_members" required placeholder="-1" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all">
                        <x-input-error :messages="$errors->get('max_team_members')" class="text-xs text-rose-500 mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Has Custom Landing Page -->
                    <div class="flex items-center gap-3 bg-gray-50 dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-800">
                        <input type="checkbox" name="has_custom_landing" id="has_custom_landing" value="1" class="rounded text-rose-500 focus:ring-rose-500 bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700">
                        <label for="has_custom_landing" class="text-xs font-bold text-gray-700 dark:text-gray-300 cursor-pointer">Bisa Mengatur Landing Page Promosi Publik</label>
                    </div>

                    <!-- Has Client Dashboard -->
                    <div class="flex items-center gap-3 bg-gray-50 dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-800">
                        <input type="checkbox" name="has_client_dashboard" id="has_client_dashboard" value="1" class="rounded text-rose-500 focus:ring-rose-500 bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700">
                        <label for="has_client_dashboard" class="text-xs font-bold text-gray-700 dark:text-gray-300 cursor-pointer">Akses Dashboard Klien Pengantin</label>
                    </div>
                </div>

                <!-- Features List -->
                <div>
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Fitur Unggulan (Tulis 1 per baris untuk Landing Page)</label>
                    <textarea name="features" rows="5" required placeholder="Contoh:&#10;Proyek Aktif Tanpa Batas&#10;Landing Page Kustom&#10;Dedicated Support 24/7" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:ring-offset-gray-900 focus:outline-none text-gray-900 dark:text-white transition-all"></textarea>
                    <x-input-error :messages="$errors->get('features')" class="text-xs text-rose-500 mt-1" />
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-gray-700">
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold py-2.5 px-6 rounded-xl shadow-md shadow-rose-100 dark:shadow-none transition-all">
                        Buat Paket Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
