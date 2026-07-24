<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Statistik & Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12 relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Income -->
            <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6">
                <p class="text-sm font-medium text-gray-400">Total Pendapatan</p>
                <p class="text-2xl font-bold text-emerald-400 mt-1">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>

            <!-- Total Expense -->
            <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6">
                <p class="text-sm font-medium text-gray-400">Total Pengeluaran</p>
                <p class="text-2xl font-bold text-rose-400 mt-1">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
            </div>

            <!-- Net Profit -->
            @php
                $netProfit = $totalIncome - $totalExpense;
            @endphp
            <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6">
                <p class="text-sm font-medium text-gray-400">Bersih (Net Profit)</p>
                <p class="text-2xl font-bold mt-1 {{ $netProfit >= 0 ? 'text-cyan-400' : 'text-rose-400' }}">
                    Rp {{ number_format($netProfit, 0, ',', '.') }}
                </p>
            </div>

            <!-- Total Hours -->
            <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6">
                <p class="text-sm font-medium text-gray-400">Total Jam Kerja</p>
                <p class="text-2xl font-bold text-purple-400 mt-1">{{ number_format($totalMinutes / 60, 1) }} Jam</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Chart Keuangan (Bar Chart) -->
            <div class="lg:col-span-2 rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6">
                <h3 class="text-lg font-bold text-white mb-4">Arus Kas Keuangan (6 Bulan Terakhir)</h3>
                <div class="h-80 w-full relative">
                    <canvas id="cashflowChart"></canvas>
                </div>
            </div>

            <!-- Status Proyek & Tipe Proyek -->
            <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6 space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-white mb-4">Status Proyek</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <div class="flex justify-between text-gray-400 mb-1">
                                <span>To Do:</span>
                                <span class="text-white">{{ $projectStats['todo'] }}</span>
                            </div>
                            <div class="w-full bg-white/5 rounded-full h-2 overflow-hidden">
                                @php
                                    $totalProj = array_sum($projectStats);
                                    $todoPercent = $totalProj > 0 ? ($projectStats['todo'] / $totalProj) * 100 : 0;
                                    $progressPercent = $totalProj > 0 ? ($projectStats['in_progress'] / $totalProj) * 100 : 0;
                                    $donePercent = $totalProj > 0 ? ($projectStats['done'] / $totalProj) * 100 : 0;
                                @endphp
                                <div class="bg-gray-400 h-2 rounded-full" style="width: {{ $todoPercent }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-gray-400 mb-1">
                                <span>Progres (In Progress):</span>
                                <span class="text-white">{{ $projectStats['in_progress'] }}</span>
                            </div>
                            <div class="w-full bg-white/5 rounded-full h-2 overflow-hidden">
                                <div class="bg-cyan-400 h-2 rounded-full" style="width: {{ $progressPercent }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-gray-400 mb-1">
                                <span>Selesai (Done):</span>
                                <span class="text-white">{{ $projectStats['done'] }}</span>
                            </div>
                            <div class="w-full bg-white/5 rounded-full h-2 overflow-hidden">
                                <div class="bg-emerald-400 h-2 rounded-full" style="width: {{ $donePercent }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-white/10 pt-6">
                    <h3 class="text-lg font-bold text-white mb-4">Tipe Pekerjaan</h3>
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div class="bg-white/5 rounded-2xl p-4 border border-white/5">
                            <span class="text-xs text-gray-400 uppercase">Joki</span>
                            <p class="text-2xl font-bold text-purple-400 mt-1">{{ $projectTypes['joki'] }}</p>
                        </div>
                        <div class="bg-white/5 rounded-2xl p-4 border border-white/5">
                            <span class="text-xs text-gray-400 uppercase">Aplikasi</span>
                            <p class="text-2xl font-bold text-blue-400 mt-1">{{ $projectTypes['aplikasi'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Projects Table -->
        <div class="mt-8 rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6">
            <h3 class="text-lg font-bold text-white mb-4">5 Proyek dengan Pemasukan Terbesar</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-300">
                    <thead class="text-xs text-gray-400 uppercase bg-white/5 rounded-xl">
                        <tr>
                            <th class="px-6 py-3 rounded-l-xl">Nama Proyek</th>
                            <th class="px-6 py-3">Tipe</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 rounded-r-xl text-right">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse ($topProjects as $project)
                            <tr>
                                <td class="px-6 py-4 font-medium text-white">
                                    <a href="{{ route('projects.show', $project) }}" class="hover:text-cyan-400 transition-colors">
                                        {{ $project->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 capitalize">{{ $project->type }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded text-xs font-semibold
                                        {{ $project->status === 'done' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-cyan-500/20 text-cyan-300' }}">
                                        {{ $project->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-emerald-400">
                                    Rp {{ number_format($project->total_income ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada data pemasukan proyek.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const ctx = document.getElementById('cashflowChart').getContext('2d');
                
                const labels = {!! json_encode(array_column($monthlyData, 'month')) !!};
                const incomeData = {!! json_encode(array_column($monthlyData, 'income')) !!};
                const expenseData = {!! json_encode(array_column($monthlyData, 'expense')) !!};
                
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Pendapatan',
                                data: incomeData,
                                backgroundColor: 'rgba(52, 211, 153, 0.6)',
                                borderColor: 'rgba(52, 211, 153, 1)',
                                borderWidth: 1,
                                borderRadius: 8
                            },
                            {
                                label: 'Pengeluaran',
                                data: expenseData,
                                backgroundColor: 'rgba(248, 113, 113, 0.6)',
                                borderColor: 'rgba(248, 113, 113, 1)',
                                borderWidth: 1,
                                borderRadius: 8
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: '#9ca3af'
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)'
                                },
                                ticks: {
                                    color: '#9ca3af'
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)'
                                },
                                ticks: {
                                    color: '#9ca3af',
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
