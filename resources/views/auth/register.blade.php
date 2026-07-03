<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-white tracking-tight">Daftarkan Bisnis WO Anda</h2>
        <p class="text-xs text-gray-400 mt-1">Buat akun untuk mengelola tim, vendor, dan proyek klien Anda.</p>
        
        @if(isset($plan) && $plan !== 'free')
            <div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-500/10 border border-pink-500/30 text-pink-400 text-[10px] font-extrabold uppercase tracking-wider">
                🎁 Paket Terpilih: {{ ucfirst($plan) }}
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="plan" value="{{ $plan ?? 'free' }}">

        <!-- Name -->
        <div>
            <label for="name" class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1.5">Nama Lengkap Owner</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                   class="w-full bg-[#0b0c10]/60 border border-gray-800 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-white transition-all placeholder-gray-600"
                   placeholder="Contoh: Aditya Pratama">
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-[11px] text-rose-500" />
        </div>

        <!-- Business Name -->
        <div>
            <label for="business_name" class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1.5">Nama Wedding Organizer / Bisnis</label>
            <input id="business_name" type="text" name="business_name" :value="old('business_name')" required autocomplete="business_name"
                   class="w-full bg-[#0b0c10]/60 border border-gray-800 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-white transition-all placeholder-gray-600"
                   placeholder="Contoh: Eternal Love Organizer">
            <x-input-error :messages="$errors->get('business_name')" class="mt-1 text-[11px] text-rose-500" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1.5">Email Bisnis</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                   class="w-full bg-[#0b0c10]/60 border border-gray-800 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-white transition-all placeholder-gray-600"
                   placeholder="owner@eternalorganizer.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-[11px] text-rose-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1.5">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full bg-[#0b0c10]/60 border border-gray-800 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-white transition-all placeholder-gray-600"
                   placeholder="Min. 8 karakter">
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-[11px] text-rose-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1.5">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full bg-[#0b0c10]/60 border border-gray-800 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-white transition-all placeholder-gray-600"
                   placeholder="Ketik ulang password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-[11px] text-rose-500" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white text-xs font-bold py-3 px-4 rounded-xl shadow-lg shadow-pink-500/20 transition-all transform hover:-translate-y-0.5">
                Daftar & Mulai Kelola WO
            </button>
        </div>

        <div class="text-center pt-4 border-t border-gray-800/60 mt-6">
            <p class="text-xs text-gray-400">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-pink-400 hover:text-pink-300 font-bold transition-colors">Masuk di sini</a></p>
        </div>
    </form>
</x-guest-layout>
