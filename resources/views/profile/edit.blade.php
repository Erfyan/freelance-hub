<x-app-layout>
    <div class="relative z-10 max-w-3xl mx-auto space-y-6">

        <!-- Update Profile Info -->
        <div class="glass-panel p-6 rounded-2xl border border-zinc-800">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password -->
        <div class="glass-panel p-6 rounded-2xl border border-zinc-800">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Passkey / Biometrik -->
        <div class="glass-panel p-6 rounded-2xl border border-zinc-800">
            @include('profile.partials.manage-passkeys')
        </div>

        <!-- Hapus Akun -->
        <div class="glass-panel p-6 rounded-2xl border border-zinc-800">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</x-app-layout>
