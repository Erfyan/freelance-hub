<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Daftar Proyek') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-white text-black font-semibold rounded-xl hover:bg-zinc-200 transition-colors shadow-sm">
                + Proyek Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12 relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 rounded-2xl backdrop-blur-md">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter & Search -->
        <div class="mb-8 rounded-3xl glass-panel p-6">
            <form action="{{ route('projects.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="search" class="block text-xs font-semibold text-gray-400 uppercase mb-2">Pencarian</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama proyek..."
                        class="w-full bg-zinc-900/50 border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-zinc-500 focus:ring-zinc-500 focus:outline-none placeholder-zinc-500 transition-colors">
                </div>
                
                <div>
                    <label for="category" class="block text-xs font-semibold text-zinc-400 uppercase mb-2">Kategori</label>
                    <select name="category" id="category" onchange="this.form.submit()"
                        class="w-full bg-zinc-900/50 border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-zinc-500 focus:ring-zinc-500 focus:outline-none transition-colors">
                        <option value="">Semua Kategori</option>
                        <option value="client" {{ request('category') === 'client' ? 'selected' : '' }}>Client</option>
                        <option value="personal" {{ request('category') === 'personal' ? 'selected' : '' }}>Personal</option>
                    </select>
                </div>

                <div>
                    <label for="type" class="block text-xs font-semibold text-zinc-400 uppercase mb-2">Tipe</label>
                    <select name="type" id="type" onchange="this.form.submit()"
                        class="w-full bg-zinc-900/50 border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-zinc-500 focus:ring-zinc-500 focus:outline-none transition-colors">
                        <option value="">Semua Tipe</option>
                        <option value="joki" {{ request('type') === 'joki' ? 'selected' : '' }}>Joki</option>
                        <option value="aplikasi" {{ request('type') === 'aplikasi' ? 'selected' : '' }}>Aplikasi</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xs font-semibold text-zinc-400 uppercase mb-2">Status</label>
                    <select name="status" id="status" onchange="this.form.submit()"
                        class="w-full bg-zinc-900/50 border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-zinc-500 focus:ring-zinc-500 focus:outline-none transition-colors">
                        <option value="">Semua Status</option>
                        <option value="todo" {{ request('status') === 'todo' ? 'selected' : '' }}>To Do</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Progres</option>
                        <option value="on_hold" {{ request('status') === 'on_hold' ? 'selected' : '' }}>Tertunda</option>
                        <option value="done" {{ request('status') === 'done' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full py-2.5 bg-zinc-800 hover:bg-zinc-700 text-white font-medium rounded-xl text-sm transition-colors border border-zinc-700">
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'type', 'status']))
                        <a href="{{ route('projects.index') }}" class="py-2.5 px-4 bg-zinc-900 hover:bg-zinc-800 text-zinc-400 font-medium rounded-xl text-sm transition-colors border border-zinc-800">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Project Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($projects as $project)
                <div class="glass-panel glass-panel-hover p-6 rounded-2xl flex flex-col justify-between group relative overflow-hidden" style="animation-delay: {{ $loop->index * 50 }}ms">
                    <div class="relative z-10">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex gap-2">
                                @if($project->category === 'personal')
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-medium uppercase tracking-wider bg-indigo-500/10 text-indigo-400 border border-indigo-500/20" title="Proyek Personal">
                                        🧑‍💻 Personal
                                    </span>
                                @endif
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-medium uppercase tracking-wider bg-zinc-800/80 text-zinc-400 border border-zinc-700">
                                    {{ $project->type === 'joki' ? 'Joki' : 'Aplikasi' }}
                                </span>
                            </div>

                            <div class="flex flex-col items-end gap-1">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-semibold uppercase tracking-wider
                                    {{ $project->status === 'done' ? 'bg-zinc-900 text-zinc-300 border border-zinc-700' :
                                       ($project->status === 'in_progress' ? 'bg-white text-black border border-white' :
                                       ($project->status === 'on_hold' ? 'bg-zinc-800 text-zinc-400 border border-zinc-700' :
                                       ($project->status === 'cancelled' ? 'bg-zinc-900 text-zinc-500 border border-zinc-800' : 'bg-zinc-900 text-zinc-400 border border-zinc-800'))) }}">
                                    {{ ['todo' => 'To Do', 'in_progress' => 'Progres', 'on_hold' => 'Tertunda', 'done' => 'Selesai', 'cancelled' => 'Batal'][$project->status] ?? $project->status }}
                                </span>
                            </div>
                        </div>

                        <h3 class="text-xl font-semibold text-white mt-4 hover:text-zinc-300 transition-colors">
                            <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                        </h3>
                        <p class="text-sm text-zinc-500 mt-1">
                            @if($project->category === 'personal')
                                Proyek Pribadi
                            @else
                                {{ $project->client?->name ?? 'Klien Dihapus' }}
                            @endif
                        </p>

                        <div class="mt-4 pt-4 border-t border-zinc-800 space-y-2 text-sm text-zinc-400">
                            <div class="flex justify-between items-center">
                                <span>Estimasi Waktu:</span>
                                <span class="text-zinc-300">{{ $project->estimated_hours ?? '-' }} Jam</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Budget:</span>
                                <span class="text-zinc-300 font-medium">Rp {{ number_format($project->budget ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Deadline:</span>
                                <span class="text-zinc-300">{{ $project->deadline?->format('d M Y') ?? 'Tanpa deadline' }}</span>
                            </div>
                        </div>

                        <!-- Deadline Indicators -->
                        @if ($project->status !== 'done' && $project->status !== 'cancelled' && $project->deadline)
                            <div class="mt-3 flex justify-end">
                                @if ($project->deadline->isPast())
                                    <span class="px-2.5 py-0.5 rounded-md text-[10px] font-semibold uppercase tracking-wider bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                        ⚠️ Terlambat
                                    </span>
                                @elseif ($project->deadline->diffInDays(now()) <= 3)
                                    <span class="px-2.5 py-0.5 rounded-md text-[10px] font-semibold uppercase tracking-wider bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                        ⏰ Mendekati Deadline
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-zinc-800 flex gap-3 relative z-10">
                        <a href="{{ route('projects.show', $project) }}" class="flex-1 text-center py-2 bg-zinc-800 hover:bg-zinc-700 border border-zinc-700 rounded-lg text-sm font-medium text-white transition-colors">
                            Detail
                        </a>
                        <a href="{{ route('projects.edit', $project) }}" class="px-3 py-2 bg-zinc-800 hover:bg-zinc-700 border border-zinc-700 rounded-lg text-sm font-medium text-white transition-colors flex items-center justify-center">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-12 text-center">
                    <p class="text-gray-400">Belum ada proyek yang cocok atau terdaftar. Klik "+ Proyek Baru" untuk membuat proyek pertama Anda.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $projects->links() }}
        </div>
    </div>
</x-app-layout>
