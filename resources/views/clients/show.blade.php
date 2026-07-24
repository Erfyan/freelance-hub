<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('clients.index') }}" class="text-gray-400 hover:text-cyan-300 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <h2 class="font-semibold text-xl leading-tight text-white">{{ $client->name }}</h2>
                </div>
                <p class="text-sm text-gray-400 mt-1 ml-8">Detail Klien</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('clients.edit', $client) }}"
                   class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-medium rounded-xl transition-all text-sm">
                    Edit Klien
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 rounded-2xl backdrop-blur-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Client Info Card -->
            <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6 space-y-4">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 font-bold text-2xl">
                        {{ strtoupper(substr($client->name, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">{{ $client->name }}</h3>
                        <p class="text-sm text-gray-400">{{ $client->projects->count() }} proyek</p>
                    </div>
                </div>

                <div class="border-t border-white/10 pt-4 space-y-3 text-sm">
                    @if ($client->phone)
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-cyan-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span class="text-gray-300">{{ $client->phone }}</span>
                        </div>
                    @endif
                    @if ($client->email)
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-cyan-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-gray-300">{{ $client->email }}</span>
                        </div>
                    @endif
                    @if ($client->notes)
                        <div class="border-t border-white/10 pt-3">
                            <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Catatan</p>
                            <p class="text-gray-300 text-sm">{{ $client->notes }}</p>
                        </div>
                    @endif
                </div>

                <div class="border-t border-white/10 pt-4">
                    <a href="{{ route('projects.create') }}?client={{ $client->id }}"
                       class="block w-full text-center py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:scale-105 transition-transform text-white font-medium rounded-xl text-sm shadow-lg shadow-cyan-500/20">
                        + Buat Proyek untuk Klien Ini
                    </a>
                </div>
            </div>

            <!-- Projects List -->
            <div class="lg:col-span-2 space-y-4">
                <h3 class="text-lg font-bold text-white">Proyek dari {{ $client->name }}</h3>

                @forelse ($client->projects as $project)
                    <div class="rounded-2xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-5 hover:border-white/20 transition-all flex justify-between items-center">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <a href="{{ route('projects.show', $project) }}"
                                   class="text-white font-semibold hover:text-cyan-300 transition-colors">
                                    {{ $project->title }}
                                </a>
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $project->status === 'done' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' :
                                       ($project->status === 'in_progress' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30' :
                                       ($project->status === 'on_hold' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' :
                                       ($project->status === 'cancelled' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : 'bg-gray-500/20 text-gray-300 border border-gray-500/30'))) }}">
                                    {{ ['todo' => 'To Do', 'in_progress' => 'Progres', 'on_hold' => 'Tertunda', 'done' => 'Selesai', 'cancelled' => 'Batal'][$project->status] ?? $project->status }}
                                </span>
                            </div>
                            <div class="flex gap-4 text-xs text-gray-400">
                                <span>{{ $project->type === 'joki' ? 'Joki' : 'Aplikasi' }}</span>
                                @if ($project->deadline)
                                    <span>Deadline: {{ $project->deadline->format('d M Y') }}</span>
                                @endif
                                @if ($project->budget)
                                    <span>Budget: Rp {{ number_format($project->budget, 0, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('projects.show', $project) }}"
                           class="px-3 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-xs text-white transition-colors">
                            Detail
                        </a>
                    </div>
                @empty
                    <div class="rounded-2xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-12 text-center">
                        <p class="text-gray-400">Klien ini belum memiliki proyek.</p>
                        <a href="{{ route('projects.create') }}"
                           class="inline-block mt-4 px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-medium rounded-xl text-sm hover:scale-105 transition-transform">
                            Buat Proyek Pertama
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
