<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Pelacak Waktu Kerja') }}
        </h2>
    </x-slot>

    <div class="py-12 relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 rounded-2xl backdrop-blur-md">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 p-4 bg-rose-500/20 border border-rose-500/30 text-rose-300 rounded-2xl backdrop-blur-md">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6">
            <!-- Timer Card -->
            <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-8 text-center space-y-6">
                @if ($runningLog)
                    <div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-500/20 text-rose-300 border border-rose-500/30 animate-pulse">
                            🔴 Sedang Melacak
                        </span>
                        <h3 class="text-2xl font-bold text-white mt-4">{{ $runningLog->project->title }}</h3>
                        <p class="text-sm text-gray-400 mt-1">Klien: {{ $runningLog->project?->client?->name ?? 'Klien Dihapus' }}</p>
                    </div>

                    <!-- Live Counter -->
                    <div class="py-6">
                        <div id="timer-display" class="text-5xl md:text-7xl font-mono font-bold text-cyan-400 tracking-wider">
                            00:00:00
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Mulai sejak: {{ $runningLog->start_time->format('H:i:s, d M Y') }}</p>
                    </div>

                    <form action="{{ route('timer.stop') }}" method="POST" class="space-y-4 max-w-md mx-auto">
                        @csrf
                        <div>
                            <label for="stop-note" class="block text-left text-xs font-semibold text-gray-400 uppercase mb-2">Catatan Pekerjaan (Opsional)</label>
                            <input type="text" name="note" id="stop-note" placeholder="Menulis kode, meeting klien, memperbaiki bug..." value="{{ $runningLog->note }}"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white text-sm focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none">
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-rose-500 to-red-600 hover:scale-105 transition-transform text-white font-bold rounded-2xl text-base shadow-lg shadow-rose-500/20">
                            Hentikan Pelacakan
                        </button>
                    </form>
                @else
                    <div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/5 border border-white/10 text-gray-400">
                            ⏱️ Timer Tidak Aktif
                        </span>
                        <h3 class="text-xl font-bold text-white mt-4">Mulai Sesi Kerja Baru</h3>
                        <p class="text-sm text-gray-400 mt-1">Pilih salah satu proyek aktif untuk mulai melacak durasi kerja Anda.</p>
                    </div>

                    <form action="" id="start-timer-form" method="POST" class="space-y-4 max-w-md mx-auto">
                        @csrf
                        <div class="text-left">
                            <label for="project_id" class="block text-xs font-semibold text-gray-400 uppercase mb-2">Pilih Proyek</label>
                            <select name="project_id" id="project_id" required onchange="updateFormAction(this.value)"
                                class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none">
                                <option value="">Pilih Proyek Aktif</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">
                                        {{ $project->title }} ({{ $project->client?->name ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-left">
                            <label for="start-note" class="block text-xs font-semibold text-gray-400 uppercase mb-2">Catatan Pekerjaan (Opsional)</label>
                            <input type="text" name="note" id="start-note" placeholder="Menulis kode, meeting klien, dll..."
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white text-sm focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none">
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:scale-105 transition-transform text-white font-bold rounded-2xl text-base shadow-lg shadow-cyan-500/20">
                            Mulai Pelacakan Waktu
                        </button>
                    </form>
                @endif
            </div>

            <!-- Today's Logs -->
            <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6">
                <h3 class="text-lg font-bold text-white mb-4">Sesi Kerja Hari Ini</h3>

                <div class="space-y-3">
                    @forelse ($todayLogs as $log)
                        <div class="p-4 bg-white/5 border border-white/5 rounded-2xl flex justify-between items-center">
                            <div>
                                <p class="text-sm font-semibold text-white">{{ $log->project->title }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $log->note ?? 'Tanpa catatan' }}</p>
                                <p class="text-[10px] text-gray-500 mt-0.5">{{ $log->start_time->format('H:i') }} - {{ $log->end_time?->format('H:i') }}</p>
                            </div>
                            <span class="text-xs font-bold text-cyan-400 bg-cyan-500/10 border border-cyan-500/20 px-2 py-1 rounded-lg">
                                {{ $log->duration_minutes }} Menit
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-center py-6 text-sm">Belum ada sesi kerja yang tercatat hari ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @if ($runningLog)
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const timerDisplay = document.getElementById('timer-display');
                    const startTime = new Date('{{ $runningLog->start_time->toIso8601String() }}').getTime();

                    function updateTimer() {
                        const now = new Date().getTime();
                        const difference = now - startTime;

                        if (difference < 0) {
                            timerDisplay.textContent = '00:00:00';
                            return;
                        }

                        const hours = Math.floor(difference / (1000 * 60 * 60));
                        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                        const formattedHours = hours.toString().padStart(2, '0');
                        const formattedMinutes = minutes.toString().padStart(2, '0');
                        const formattedSeconds = seconds.toString().padStart(2, '0');

                        timerDisplay.textContent = `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
                    }

                    updateTimer();
                    setInterval(updateTimer, 1000);
                });
            </script>
        @endpush
    @else
        @push('scripts')
            <script>
                function updateFormAction(projectId) {
                    const form = document.getElementById('start-timer-form');
                    if (projectId) {
                        form.action = `/projects/${projectId}/timer/start`;
                    } else {
                        form.action = '';
                    }
                }
            </script>
        @endpush
    @endif
</x-app-layout>
