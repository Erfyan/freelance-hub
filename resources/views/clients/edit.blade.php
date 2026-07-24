<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Edit Klien') }}
        </h2>
    </x-slot>

    <div class="py-12 relative z-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl shadow-2xl border border-white/10 p-8">
            <form action="{{ route('clients.update', $client) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Klien / Perusahaan</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $client->name) }}"
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none transition-colors @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">No. Telepon / WhatsApp</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $client->phone) }}"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none transition-colors @error('phone') border-rose-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $client->email) }}"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none transition-colors @error('email') border-rose-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">Catatan Tambahan</label>
                    <textarea name="notes" id="notes" rows="4"
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none transition-colors @error('notes') border-rose-500 @enderror">{{ old('notes', $client->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex gap-4">
                    <a href="{{ route('clients.index') }}" class="flex-1 text-center py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl text-sm font-medium text-white transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 hover:scale-[1.02] active:scale-[0.98] text-white font-medium rounded-2xl transition-all shadow-lg shadow-cyan-500/20">
                        Perbarui Klien
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
