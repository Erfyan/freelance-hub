<x-app-layout>
    <div class="relative z-10">
        <!-- Kartu Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Proyek Aktif -->
            <div class="glass-panel glass-panel-hover p-6 rounded-2xl group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-400">Proyek Aktif</p>
                        <p class="text-3xl font-bold text-white mt-1">{{ $activeProjects ?? 0 }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-xl bg-zinc-800/80 border border-zinc-700 flex items-center justify-center group-hover:bg-zinc-700 transition-colors">
                        <svg class="h-6 w-6 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Bulan Ini -->
            <div class="glass-panel glass-panel-hover p-6 rounded-2xl group delay-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-400">Pendapatan Bulan Ini</p>
                        <p class="text-2xl lg:text-3xl font-bold text-white mt-1">Rp {{ number_format($monthlyIncome ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-xl bg-zinc-800/80 border border-zinc-700 flex items-center justify-center group-hover:bg-zinc-700 transition-colors shrink-0">
                        <svg class="h-6 w-6 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Jam Kerja Hari Ini -->
            <div class="glass-panel glass-panel-hover p-6 rounded-2xl group delay-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-400">Jam Kerja Hari Ini</p>
                        <p class="text-3xl font-bold text-white mt-1">{{ floor($todayMinutes / 60) }}j {{ $todayMinutes % 60 }}m</p>
                    </div>
                    <div class="h-12 w-12 rounded-xl bg-zinc-800/80 border border-zinc-700 flex items-center justify-center group-hover:bg-zinc-700 transition-colors">
                        <svg class="h-6 w-6 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Proyek Terbaru -->
        <div class="glass-panel p-6 rounded-2xl delay-300">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                Proyek Terbaru
            </h3>
            <div class="space-y-3">
                @forelse ($recentProjects as $project)
                    <a href="{{ route('projects.show', $project) }}" class="group block p-4 bg-zinc-800/30 rounded-xl hover:bg-zinc-800/80 border border-transparent hover:border-zinc-700 transition-colors">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-white transition-colors">{{ $project->title }}</p>
                                <p class="text-xs text-zinc-400 mt-1 flex items-center gap-2">
                                    <svg class="h-3 w-3 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    @if($project->category === 'personal')
                                        🧑‍💻 Proyek Pribadi
                                    @else
                                        {{ $project->client?->name ?? 'Klien Dihapus' }}
                                    @endif
                                    <span class="text-zinc-600">&bull;</span> 
                                    <svg class="h-3 w-3 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $project->deadline?->format('d M Y') ?? 'Tanpa deadline' }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-semibold uppercase tracking-wider
                                    {{ $project->status === 'done' ? 'bg-zinc-900 text-zinc-300 border border-zinc-700' :
                                       ($project->status === 'in_progress' ? 'bg-white text-black border border-white' :
                                       ($project->status === 'on_hold' ? 'bg-zinc-800 text-zinc-400 border border-zinc-700' :
                                       ($project->status === 'cancelled' ? 'bg-zinc-900 text-zinc-500 border border-zinc-800' : 'bg-zinc-900 text-zinc-400 border border-zinc-800'))) }}">
                                    {{ ['todo' => 'To Do', 'in_progress' => 'Progres', 'on_hold' => 'Tertunda', 'done' => 'Selesai', 'cancelled' => 'Batal'][$project->status] ?? $project->status }}
                                </span>
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-medium uppercase tracking-wider bg-zinc-800 text-zinc-400 border border-zinc-700">
                                    {{ $project->type === 'joki' ? 'Joki' : 'Aplikasi' }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 mb-4">
                            <svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <p class="text-gray-400 font-medium">Belum ada proyek aktif.</p>
                        <p class="text-sm text-gray-500 mt-1">Buat proyek pertama Anda untuk mulai bekerja.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- FAB Tambah Proyek -->
    <a href="{{ route('projects.create') }}" title="Tambah Proyek Baru" class="fixed bottom-8 right-8 h-12 w-12 bg-white text-black rounded-full shadow-lg flex items-center justify-center hover:scale-105 hover:bg-zinc-200 transition-all duration-300 z-30 border border-transparent">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
    </a>

</x-app-layout>