<x-guest-layout>
    <div class="text-center">
        <h2 class="text-2xl font-semibold text-white mb-4">Autentikasi Passkey</h2>
        <p class="text-gray-400 mb-6 text-sm">Silakan gunakan sidik jari, wajah, atau PIN Anda untuk masuk.</p>
        
        <div id="webauthn-status" class="mb-4 text-cyan-400 animate-pulse">Menunggu autentikasi...</div>
        <x-input-error :messages="$errors->get('response')" class="mb-4 text-pink-400 text-sm" />

        {{-- Laravel WebAuthn Scripts from Laragear --}}
        @webauthnScripts

        <form id="webauthn-form" method="POST" action="{{ route('webauthn.login') }}" style="display: none;">
            @csrf
        </form>

        <button id="retry-btn" class="hidden w-full py-3 font-semibold text-white bg-white/10 border border-white/20 rounded-full hover:bg-white/20 transition-all duration-200" onclick="startWebAuthn()">Coba Lagi</button>
        
        <div class="mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Batal</a>
        </div>
    </div>

    <script>
        function startWebAuthn() {
            document.getElementById('retry-btn').classList.add('hidden');
            const status = document.getElementById('webauthn-status');
            status.textContent = 'Menunggu autentikasi...';
            status.classList.remove('text-pink-400');
            status.classList.add('text-cyan-400', 'animate-pulse');

            // Trigger Laragear WebAuthn Login
            new WebAuthn().signIn({
                // You can specify user id if you want to limit it to the discovered user
                // but Laragear handles the standard API which automatically gets it from backend via /webauthn/login/options
            }).then(response => {
                status.textContent = 'Berhasil! Sedang mengalihkan...';
                // The package automatically posts to the backend and logs the user in if successful
                window.location.href = '/projects'; // Redirect to dashboard
            }).catch(error => {
                status.textContent = 'Gagal: ' + error.message;
                status.classList.remove('text-cyan-400', 'animate-pulse');
                status.classList.add('text-pink-400');
                document.getElementById('retry-btn').classList.remove('hidden');
            });
        }
        
        // Start automatically
        document.addEventListener('DOMContentLoaded', startWebAuthn);
    </script>
</x-guest-layout>
