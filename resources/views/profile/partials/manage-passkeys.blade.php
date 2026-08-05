<section class="relative">
    @webauthnScripts

    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
        <div class="h-10 w-10 rounded-xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 flex items-center justify-center shrink-0">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
            </svg>
        </div>
        <div>
            <h2 class="text-base font-semibold text-white">Kelola Passkey</h2>
            <p class="text-xs text-zinc-400">Login lebih cepat & aman dengan sidik jari, wajah, atau PIN perangkat — tanpa password.</p>
        </div>
    </div>

    <!-- Passkey list -->
    <div class="space-y-3 mb-6">
        @if(auth()->user()->webauthnCredentials->isNotEmpty())
            @foreach(auth()->user()->webauthnCredentials as $credential)
                <div class="flex items-center justify-between p-4 bg-zinc-900/60 rounded-xl border border-zinc-800">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Passkey #{{ $loop->iteration }}</p>
                            <p class="text-xs text-zinc-400">Ditambahkan {{ $credential->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('webauthn.delete') }}" onsubmit="return confirm('Hapus passkey ini?')">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="credential_id" value="{{ $credential->id }}">
                        <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-rose-400 hover:text-rose-300 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 rounded-lg transition-all">
                            Hapus
                        </button>
                    </form>
                </div>
            @endforeach
        @else
            <div class="flex items-center gap-3 p-4 bg-zinc-900/40 rounded-xl border border-zinc-800 border-dashed">
                <svg class="h-5 w-5 text-zinc-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                </svg>
                <p class="text-sm text-zinc-500 italic">Belum ada Passkey yang didaftarkan. Tambahkan untuk login tanpa password!</p>
            </div>
        @endif
    </div>

    <!-- Add Passkey button & status -->
    <div class="flex items-center gap-4">
        <button id="add-passkey-btn" onclick="addPasskey()"
                class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-semibold rounded-xl text-sm shadow-lg shadow-cyan-500/20 hover:scale-105 active:scale-95 transition-all">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span id="add-passkey-btn-text">Tambah Passkey Baru</span>
        </button>
        <p id="passkey-status" class="text-xs hidden"></p>
    </div>

    <script>
        function addPasskey() {
            const btn = document.getElementById('add-passkey-btn');
            const btnText = document.getElementById('add-passkey-btn-text');
            const status = document.getElementById('passkey-status');

            btn.disabled = true;
            btnText.textContent = 'Menunggu perangkat...';
            status.textContent = '';
            status.className = 'text-xs text-zinc-400';
            status.classList.remove('hidden');

            new WebAuthn().register()
                .then(() => {
                    status.textContent = '✅ Passkey berhasil didaftarkan! Memuat ulang...';
                    status.className = 'text-xs text-emerald-400';
                    setTimeout(() => window.location.reload(), 1500);
                })
                .catch(error => {
                    status.textContent = '❌ Gagal mendaftar: ' + error.message;
                    status.className = 'text-xs text-rose-400';
                    btn.disabled = false;
                    btnText.textContent = 'Tambah Passkey Baru';
                });
        }
    </script>
</section>
