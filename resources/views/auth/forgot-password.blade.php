<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-white mb-2">Lupa Password?</h2>
        <p class="text-sm text-slate-300">Masukkan alamat email Anda dan kami akan mengirimkan link untuk mereset password Anda.</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-emerald-400 p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-slate-200 mb-1">Alamat Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </span>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                       class="w-full pl-11 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all duration-200"
                       placeholder="anda@email.com">
            </div>
            @error('email')
                <p class="mt-1.5 text-pink-300 text-xs flex items-center animate-shake">
                    <svg class="h-3.5 w-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <button type="submit"
                class="w-full py-3.5 font-semibold text-white bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full shadow-lg shadow-cyan-500/25 hover:shadow-cyan-500/40 hover:scale-[1.02] active:scale-95 transition-all duration-200">
            Kirim Link Reset Password
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors font-medium">Kembali ke Login</a>
        </div>
    </form>
</x-guest-layout>
