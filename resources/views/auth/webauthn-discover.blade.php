<x-guest-layout>
    <h2 class="text-2xl font-semibold text-white mb-6">Masuk dengan Passkey</h2>
    <p class="text-gray-400 mb-6 text-sm">Masukkan email Anda untuk menemukan Passkey yang terhubung.</p>

    <form method="POST" action="{{ route('webauthn.discover.user') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="block text-sm text-gray-300 mb-1">Email</label>
            <input id="email" name="email" type="email" required autofocus
                   class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-shadow">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-pink-400 text-xs" />
        </div>
        <button type="submit"
                class="w-full py-3 font-semibold text-white bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full shadow-lg shadow-cyan-500/25 hover:scale-105 active:scale-95 transition-all duration-200">
            Lanjutkan
        </button>
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors">Kembali ke Login Password</a>
        </div>
    </form>
</x-guest-layout>
