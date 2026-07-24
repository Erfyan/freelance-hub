<x-guest-layout>
    <div class="text-center">
        <h2 class="text-2xl font-semibold text-white mb-4">Passkey Belum Didaftarkan</h2>
        <p class="text-gray-400 mb-6 text-sm">Akun Anda belum memiliki Passkey yang terdaftar. Silakan login menggunakan password terlebih dahulu, lalu daftarkan Passkey di menu Profil Anda.</p>
        
        <div class="mt-6 space-y-4">
            <a href="{{ route('login') }}" class="block w-full py-3 font-semibold text-white bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full shadow-lg shadow-cyan-500/25 hover:scale-105 active:scale-95 transition-all duration-200">
                Kembali ke Login Password
            </a>
        </div>
    </div>
</x-guest-layout>
