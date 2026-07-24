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
        <!-- Quick Links / Media Sosial -->
        <div class="mb-8 p-4 rounded-2xl glass-panel flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-zinc-800/80 border border-zinc-700 flex items-center justify-center text-zinc-300">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white">Tautan Sosial & Kontak</h4>
                    <p class="text-xs text-zinc-400">Akses cepat ke akun media sosial dan WhatsApp Anda</p>
                </div>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                <!-- GitHub -->
                <a href="https://github.com/Erfyan" target="_blank" rel="noopener noreferrer" 
                   class="flex items-center gap-2 px-4 py-2 bg-zinc-900/80 hover:bg-zinc-800 border border-zinc-800 hover:border-zinc-600 text-zinc-200 hover:text-white rounded-xl text-xs font-medium transition-all group">
                    <svg class="h-4 w-4 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                    </svg>
                    <span>GitHub</span>
                </a>

                <!-- Instagram -->
                <a href="https://instagram.com/erft.09" target="_blank" rel="noopener noreferrer" 
                   class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-pink-500/10 to-rose-500/10 hover:from-pink-500/20 hover:to-rose-500/20 border border-pink-500/20 text-pink-300 hover:text-pink-200 rounded-xl text-xs font-medium transition-all group">
                    <svg class="h-4 w-4 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2c2.717 0 3.056.01 4.122.06 1.065.048 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 011.153 1.772c.247.637.416 1.363.465 2.428.048 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.049 1.065-.218 1.79-.465 2.428a4.883 4.883 0 01-1.153 1.772 4.915 4.915 0 01-1.772 1.153c-.637.247-1.363.416-2.428.465-1.066.048-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.049-1.79-.218-2.428-.465a4.89 4.89 0 01-1.772-1.153 4.904 4.904 0 01-1.153-1.772c-.248-.637-.417-1.363-.465-2.428C2.01 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.048-1.065.217-1.79.465-2.428a4.88 4.88 0 011.153-1.772A4.897 4.897 0 015.45 2.525c.638-.248 1.362-.417 2.428-.465C8.944 2.01 9.283 2 12 2zm0 1.802c-2.67 0-2.987.01-4.042.059-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.048 1.055-.058 1.372-.058 4.041 0 2.67.01 2.987.058 4.042.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058 2.67 0 2.987-.01 4.042-.058.975-.045 1.504-.207 1.857-.344.467-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.372.058-4.042 0-2.67-.01-2.986-.058-4.041-.045-.975-.207-1.504-.344-1.857a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.055-.048-1.371-.058-4.042-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/>
                    </svg>
                    <span>Instagram</span>
                </a>

                <!-- WhatsApp -->
                <a href="https://wa.me/6287842166300" target="_blank" rel="noopener noreferrer" 
                   class="flex items-center gap-2 px-4 py-2 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 text-emerald-300 hover:text-emerald-200 rounded-xl text-xs font-medium transition-all group">
                    <svg class="h-4 w-4 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>WhatsApp</span>
                </a>
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