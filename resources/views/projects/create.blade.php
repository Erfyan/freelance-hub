<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Tambah Proyek Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 relative z-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl shadow-2xl border border-white/10 p-8">
            <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Kategori Proyek --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-3">Kategori Proyek</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="category" value="client" {{ old('category', 'client') === 'client' ? 'checked' : '' }}
                                class="peer sr-only" onchange="toggleClientField()">
                            <div class="p-4 rounded-2xl border border-white/10 bg-white/5 text-center transition-all
                                peer-checked:border-white peer-checked:bg-white/10">
                                <div class="text-2xl mb-1">👤</div>
                                <p class="text-sm font-semibold text-white">Project Client</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Proyek untuk klien</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="category" value="personal" {{ old('category') === 'personal' ? 'checked' : '' }}
                                class="peer sr-only" onchange="toggleClientField()">
                            <div class="p-4 rounded-2xl border border-white/10 bg-white/5 text-center transition-all
                                peer-checked:border-white peer-checked:bg-white/10">
                                <div class="text-2xl mb-1">🧑‍💻</div>
                                <p class="text-sm font-semibold text-white">Project Personal</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Proyek pribadi / belajar</p>
                            </div>
                        </label>
                    </div>
                    @error('category')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Klien (hanya tampil jika category = client) --}}
                <div id="client-field" style="{{ old('category') === 'personal' ? 'display:none' : '' }}">
                    <label for="client_id" class="block text-sm font-medium text-gray-300 mb-2">Klien</label>
                    <select name="client_id" id="client_id"
                        class="w-full bg-gray-900 border border-white/10 rounded-2xl px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none transition-colors @error('client_id') border-rose-500 @enderror">
                        <option value="">Pilih Klien</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                    <div class="mt-2 text-xs text-gray-400">
                        Klien tidak terdaftar? <a href="{{ route('clients.create') }}" class="text-cyan-400 hover:underline">Tambah klien baru terlebih dahulu</a>.
                    </div>
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Nama Proyek</label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="Contoh: Website e-Commerce PT X"
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none transition-colors @error('title') border-rose-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-300 mb-2">Tipe Proyek</label>
                        <select name="type" id="type" required
                            class="w-full bg-gray-900 border border-white/10 rounded-2xl px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none transition-colors @error('type') border-rose-500 @enderror">
                            <option value="aplikasi" {{ old('type') === 'aplikasi' ? 'selected' : '' }}>Aplikasi</option>
                            <option value="joki" {{ old('type') === 'joki' ? 'selected' : '' }}>Joki</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status Proyek</label>
                        <select name="status" id="status" required
                            class="w-full bg-gray-900 border border-white/10 rounded-2xl px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none transition-colors @error('status') border-rose-500 @enderror">
                            <option value="todo" {{ old('status') === 'todo' ? 'selected' : '' }}>To Do</option>
                            <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>Progres (In Progress)</option>
                            <option value="on_hold" {{ old('status') === 'on_hold' ? 'selected' : '' }}>Tertunda (On Hold)</option>
                            <option value="done" {{ old('status') === 'done' ? 'selected' : '' }}>Selesai (Done)</option>
                            <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Batal (Cancelled)</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="estimated_hours" class="block text-sm font-medium text-gray-300 mb-2">Estimasi (Jam)</label>
                        <input type="number" name="estimated_hours" id="estimated_hours" value="{{ old('estimated_hours') }}" min="0" placeholder="0"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none transition-colors @error('estimated_hours') border-rose-500 @enderror">
                        @error('estimated_hours')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label for="budget" class="block text-sm font-medium text-gray-300 mb-2">Budget (Rp)</label>
                        <input type="number" name="budget" id="budget" value="{{ old('budget') }}" min="0" placeholder="0"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none transition-colors @error('budget') border-rose-500 @enderror">
                        @error('budget')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label for="deadline" class="block text-sm font-medium text-gray-300 mb-2">Deadline</label>
                        <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none transition-colors @error('deadline') border-rose-500 @enderror">
                        @error('deadline')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 flex gap-4">
                    <a href="{{ route('projects.index') }}" class="flex-1 text-center py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl text-sm font-medium text-white transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 hover:scale-[1.02] active:scale-[0.98] text-white font-medium rounded-2xl transition-all shadow-lg shadow-cyan-500/20">
                        Buat Proyek
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function toggleClientField() {
            const category = document.querySelector('input[name="category"]:checked')?.value;
            const clientField = document.getElementById('client-field');
            const clientSelect = document.getElementById('client_id');
            if (category === 'personal') {
                clientField.style.display = 'none';
                clientSelect.value = '';
            } else {
                clientField.style.display = '';
            }
        }
        document.addEventListener('DOMContentLoaded', toggleClientField);
    </script>
</x-app-layout>
