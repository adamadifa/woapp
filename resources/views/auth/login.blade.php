<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-xs text-emerald-400 font-bold" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-white tracking-tight">Selamat Datang Kembali</h2>
        <p class="text-xs text-gray-400 mt-1">Masuk untuk mengelola bisnis Wedding Organizer Anda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="text-[10px] font-bold text-gray-450 uppercase tracking-wider block mb-1.5">Email Bisnis</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                   class="w-full bg-[#0b0c10]/60 border border-gray-800 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-white transition-all placeholder-gray-600"
                   placeholder="nama@bisniswo.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-[11px] text-rose-500" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="text-[10px] font-bold text-gray-450 uppercase tracking-wider block">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] text-pink-400 hover:text-pink-300 transition-colors" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full bg-[#0b0c10]/60 border border-gray-800 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-white transition-all placeholder-gray-600"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-[11px] text-rose-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" 
                   class="rounded border-gray-800 bg-[#0b0c10] text-pink-500 focus:ring-pink-500 focus:ring-offset-gray-900 focus:ring-2 w-3.5 h-3.5 transition-all">
            <label for="remember_me" class="ms-2 text-xs text-gray-400 select-none cursor-pointer">Ingat saya di perangkat ini</label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white text-xs font-bold py-3 px-4 rounded-xl shadow-lg shadow-pink-500/20 transition-all transform hover:-translate-y-0.5">
                Masuk ke Dashboard
            </button>
        </div>

        @if (Route::has('register'))
            <div class="text-center pt-4 border-t border-gray-800/60 mt-6">
                <p class="text-xs text-gray-400">Belum punya akun WOApp? <a href="{{ route('register') }}" class="text-pink-400 hover:text-pink-300 font-bold transition-colors">Daftar sekarang</a></p>
            </div>
        @endif
    </form>
</x-guest-layout>
