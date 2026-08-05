<x-guest-layout>
    <h2 class="text-3xl font-bold text-white mb-2">Buat Akun Baru</h2>
    <p class="text-sm text-gray-300 mb-8">Mulai kelola proyek dengan lebih profesional.</p>

    <form method="POST" action="{{ route('register') }}" id="register-form" class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-200 mb-1">Nama Lengkap</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </span>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                       class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all duration-200"
                       placeholder="Nama kamu">
            </div>
            @error('name') <p class="mt-1.5 text-pink-300 text-xs flex items-center animate-shake">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-200 mb-1">Alamat Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </span>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                       class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all duration-200"
                       placeholder="anda@email.com">
            </div>
            @error('email') <p class="mt-1.5 text-pink-300 text-xs flex items-center animate-shake">{{ $message }}</p> @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-200 mb-1">Password</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input id="password" name="password" type="password" required
                       class="w-full pl-10 pr-12 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all duration-200"
                       placeholder="Minimal 8 karakter">
                <button type="button" id="toggle-password-register" tabindex="-1"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200 transition-colors">
                    <svg id="eye-icon-register" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            {{-- Strength meter --}}
            <div class="mt-2 flex items-center space-x-1" id="password-strength-container" style="display: none;">
                <span class="text-xs text-gray-400 mr-2">Kekuatan:</span>
                <div class="w-full h-1.5 bg-gray-700 rounded-full overflow-hidden flex space-x-0.5">
                    <div id="strength-bar-1" class="h-full w-1/4 bg-gray-600 rounded-full transition-all duration-300"></div>
                    <div id="strength-bar-2" class="h-full w-1/4 bg-gray-600 rounded-full transition-all duration-300"></div>
                    <div id="strength-bar-3" class="h-full w-1/4 bg-gray-600 rounded-full transition-all duration-300"></div>
                    <div id="strength-bar-4" class="h-full w-1/4 bg-gray-600 rounded-full transition-all duration-300"></div>
                </div>
                <span id="strength-text" class="text-xs text-gray-400 ml-2"></span>
            </div>
            @error('password') <p class="mt-1.5 text-pink-300 text-xs flex items-center animate-shake">{{ $message }}</p> @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-200 mb-1">Konfirmasi Password</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                    </svg>
                </span>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all duration-200"
                       placeholder="Ulangi password">
            </div>
            @error('password_confirmation') <p class="mt-1.5 text-pink-300 text-xs flex items-center animate-shake">{{ $message }}</p> @enderror
        </div>

        {{-- Tombol Register --}}
        <button type="submit" id="submit-btn-register"
                class="w-full py-3.5 font-semibold text-white bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full shadow-lg shadow-cyan-500/25 hover:shadow-cyan-500/40 hover:scale-[1.02] active:scale-95 transition-all duration-200 flex items-center justify-center relative overflow-hidden group mt-2">
            <span id="btn-text-register">Buat Akun</span>
            <span id="btn-spinner-register" class="hidden absolute inset-0 flex items-center justify-center">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        </button>

        <p class="text-center text-sm text-gray-400 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-cyan-400 hover:text-cyan-300 transition-colors font-semibold">Masuk</a>
        </p>
    </form>

    <script>
        // Toggle password register
        const toggleBtnReg = document.getElementById('toggle-password-register');
        const passwordInputReg = document.getElementById('password');
        const eyeIconReg = document.getElementById('eye-icon-register');
        toggleBtnReg.addEventListener('click', function() {
            const type = passwordInputReg.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInputReg.setAttribute('type', type);
            if (type === 'text') {
                eyeIconReg.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
            } else {
                eyeIconReg.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        });

        // Password strength meter
        const pwdInput = document.getElementById('password');
        const strengthContainer = document.getElementById('password-strength-container');
        const bars = [
            document.getElementById('strength-bar-1'),
            document.getElementById('strength-bar-2'),
            document.getElementById('strength-bar-3'),
            document.getElementById('strength-bar-4')
        ];
        const strengthText = document.getElementById('strength-text');
        pwdInput.addEventListener('input', function() {
            const val = pwdInput.value;
            if (val.length === 0) {
                strengthContainer.style.display = 'none';
                return;
            }
            strengthContainer.style.display = 'flex';
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            const colors = ['bg-gray-600', 'bg-red-500', 'bg-yellow-500', 'bg-emerald-500'];
            const labels = ['', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
            bars.forEach((bar, i) => {
                bar.className = 'h-full w-1/4 rounded-full transition-all duration-300';
                if (i < score) {
                    bar.classList.add(colors[score]);
                } else {
                    bar.classList.add('bg-gray-600');
                }
            });
            strengthText.textContent = labels[score];
            strengthText.className = 'text-xs ml-2';
            if (score <= 1) strengthText.classList.add('text-red-400');
            else if (score === 2) strengthText.classList.add('text-yellow-400');
            else strengthText.classList.add('text-emerald-400');
        });

        // Loading state register
        const formReg = document.getElementById('register-form');
        const submitBtnReg = document.getElementById('submit-btn-register');
        const btnTextReg = document.getElementById('btn-text-register');
        const btnSpinnerReg = document.getElementById('btn-spinner-register');
        formReg.addEventListener('submit', function() {
            btnTextReg.classList.add('invisible');
            btnSpinnerReg.classList.remove('hidden');
            submitBtnReg.disabled = true;
            submitBtnReg.classList.add('opacity-80');
        });
    </script>
</x-guest-layout>