<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Kelola Passkey') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Gunakan Passkey (seperti sidik jari atau wajah) untuk login lebih cepat dan aman tanpa password.') }}
        </p>
    </header>

    @webauthnScripts

    <div class="mt-6 space-y-6">
        @if(auth()->user()->webauthnCredentials->isNotEmpty())
            <div class="space-y-4">
                @foreach(auth()->user()->webauthnCredentials as $credential)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $credential->id }}
                            </p>
                            <p class="text-xs text-gray-500">
                                Ditambahkan pada {{ $credential->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        
                        <form method="POST" action="{{ route('webauthn.delete') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="credential_id" value="{{ $credential->id }}">
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 italic">Belum ada Passkey yang didaftarkan.</p>
        @endif

        <div class="flex items-center gap-4 mt-6">
            <button id="add-passkey-btn" onclick="addPasskey()" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Tambah Passkey
            </button>
            <p id="passkey-status" class="text-sm text-gray-600 hidden"></p>
        </div>
    </div>

    <script>
        function addPasskey() {
            const btn = document.getElementById('add-passkey-btn');
            const status = document.getElementById('passkey-status');
            
            btn.disabled = true;
            status.textContent = 'Menunggu konfirmasi perangkat...';
            status.classList.remove('hidden', 'text-red-600', 'text-green-600');
            status.classList.add('text-gray-600');

            new WebAuthn().register()
                .then(response => {
                    status.textContent = 'Passkey berhasil didaftarkan! Memuat ulang...';
                    status.classList.replace('text-gray-600', 'text-green-600');
                    setTimeout(() => window.location.reload(), 1500);
                })
                .catch(error => {
                    status.textContent = 'Gagal mendaftar: ' + error.message;
                    status.classList.replace('text-gray-600', 'text-red-600');
                    btn.disabled = false;
                });
        }
    </script>
</section>
