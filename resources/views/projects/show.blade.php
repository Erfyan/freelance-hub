<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="font-semibold text-xl leading-tight text-white">
                        {{ $project->title }}
                    </h2>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold
                        {{ $project->status === 'done' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 
                           ($project->status === 'in_progress' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30' : 
                           ($project->status === 'on_hold' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 
                           ($project->status === 'cancelled' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : 'bg-gray-500/20 text-gray-300 border border-gray-500/30'))) }}">
                        {{ $project->status === 'todo' ? 'To Do' : ($project->status === 'in_progress' ? 'Progres' : ($project->status === 'on_hold' ? 'Tertunda' : ($project->status === 'cancelled' ? 'Batal' : 'Selesai'))) }}
                    </span>
                    @if($project->category === 'personal')
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                            🧑‍💻 Personal
                        </span>
                    @endif
                </div>
                @if($project->category === 'personal')
                    <p class="text-sm text-gray-400 mt-1">Kategori: <span class="text-indigo-400 font-medium">Proyek Pribadi / Belajar</span></p>
                @else
                    <p class="text-sm text-gray-400 mt-1">Klien: <span class="text-cyan-400 font-medium">{{ $project->client?->name ?? 'Klien Dihapus' }}</span></p>
                @endif
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-medium rounded-xl transition-all">
                    Edit Proyek
                </a>
                <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-rose-400 font-medium rounded-xl transition-all">
                        Hapus Proyek
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12 relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ activeTab: 'overview' }">
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

        <!-- Tab Headers -->
        <div class="mb-8 border-b border-white/10 flex gap-6 text-sm font-medium overflow-x-auto whitespace-nowrap">
            <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'border-cyan-400 text-white' : 'border-transparent text-gray-400 hover:text-gray-200'" class="pb-4 border-b-2 transition-all">
                Ringkasan
            </button>
            <button @click="activeTab = 'finances'" :class="activeTab === 'finances' ? 'border-cyan-400 text-white' : 'border-transparent text-gray-400 hover:text-gray-200'" class="pb-4 border-b-2 transition-all">
                Keuangan (Keuntungan)
            </button>
            <button @click="activeTab = 'files'" :class="activeTab === 'files' ? 'border-cyan-400 text-white' : 'border-transparent text-gray-400 hover:text-gray-200'" class="pb-4 border-b-2 transition-all">
                File & Aset
            </button>
            <button @click="activeTab = 'timelogs'" :class="activeTab === 'timelogs' ? 'border-cyan-400 text-white' : 'border-transparent text-gray-400 hover:text-gray-200'" class="pb-4 border-b-2 transition-all">
                Pelacakan Waktu
            </button>
        </div>

        <!-- TAB CONTENT: OVERVIEW -->
        <div x-show="activeTab === 'overview'" class="space-y-6" x-transition>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Info Utama -->
                <div class="lg:col-span-2 rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6 space-y-4">
                    <h3 class="text-lg font-bold text-white mb-2">Informasi Proyek</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="space-y-1">
                            <span class="text-gray-400 text-xs uppercase">Tipe Proyek</span>
                            <p class="text-white font-medium capitalize">{{ $project->type }}</p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-gray-400 text-xs uppercase">Estimasi Waktu</span>
                            <p class="text-white font-medium">{{ $project->estimated_hours ?? '-' }} Jam</p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-gray-400 text-xs uppercase">Budget Proyek</span>
                            <p class="text-white font-medium">Rp {{ number_format($project->budget ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-gray-400 text-xs uppercase">Deadline</span>
                            <p class="text-white font-medium">{{ $project->deadline?->format('d F Y') ?? 'Tanpa deadline' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Financial Quick Stats -->
                <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-white mb-4">Profitabilitas Proyek</h3>
                        
                        @php
                            $totalIncome = $project->transactions->where('type', 'income')->sum('amount');
                            $totalExpense = $project->transactions->where('type', 'expense')->sum('amount');
                            $profit = ($project->budget ?? 0) - $totalExpense;
                        @endphp
                        
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Budget:</span>
                                <span class="text-white font-medium">Rp {{ number_format($project->budget ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Total Pengeluaran:</span>
                                <span class="text-rose-400 font-medium">- Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-white/10 pt-3 flex justify-between font-bold">
                                <span class="text-gray-300">Estimasi Profit:</span>
                                <span class="{{ $profit >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                    Rp {{ number_format($profit, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <div class="w-full bg-white/5 rounded-full h-2.5 overflow-hidden">
                            @php
                                $percent = ($project->budget && $project->budget > 0) ? min(100, max(0, ($profit / $project->budget) * 100)) : 0;
                            @endphp
                            <div class="bg-cyan-500 h-2.5 rounded-full" style="width: {{ $percent }}%"></div>
                        </div>
                        <p class="text-right text-xs text-gray-400 mt-1">Margin Profit: {{ round($percent) }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB CONTENT: FINANCES -->
        <div x-show="activeTab === 'finances'" class="space-y-6" x-transition>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- List Transaksi -->
                <div class="lg:col-span-2 rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Riwayat Keuangan</h3>
                    
                    <div class="space-y-3">
                        @forelse ($project->transactions as $transaction)
                            <div class="flex items-center justify-between p-4 bg-white/5 border border-white/5 rounded-2xl">
                                <div>
                                    <p class="font-medium text-white">{{ $transaction->description }}</p>
                                    <p class="text-xs text-gray-400">{{ $transaction->transaction_date->format('d M Y') }}</p>
                                    @if ($transaction->payment_proof)
                                        <a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-cyan-400 hover:underline mt-1">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Lihat Bukti Transfer
                                        </a>
                                    @endif
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    <span class="font-bold text-sm {{ $transaction->type === 'income' ? 'text-emerald-400' : 'text-rose-400' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </span>
                                    
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-rose-400 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400 text-center py-6 text-sm">Belum ada transaksi di proyek ini.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Form Tambah Transaksi -->
                <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Catat Transaksi</h3>
                    
                    <form action="{{ route('projects.transactions.store', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Tipe Transaksi</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 text-white text-sm cursor-pointer">
                                    <input type="radio" name="type" value="income" checked class="text-cyan-500 focus:ring-cyan-500 bg-white/5 border-white/10">
                                    Pemasukan (Income)
                                </label>
                                <label class="flex items-center gap-2 text-white text-sm cursor-pointer">
                                    <input type="radio" name="type" value="expense" class="text-cyan-500 focus:ring-cyan-500 bg-white/5 border-white/10">
                                    Pengeluaran (Expense)
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-300 mb-2">Jumlah (Rp)</label>
                            <input type="number" name="amount" id="amount" required placeholder="0" min="0"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white text-sm focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none">
                        </div>

                        <div>
                            <label for="transaction_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal</label>
                            <input type="date" name="transaction_date" id="transaction_date" required value="{{ date('Y-m-d') }}"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white text-sm focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                            <input type="text" name="description" id="description" required placeholder="Contoh: DP 50% atau Pembelian Hosting"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white text-sm focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none">
                        </div>

                        <div>
                            <label for="payment_proof" class="block text-sm font-medium text-gray-300 mb-2">Bukti Pembayaran (Maks 2MB)</label>
                            <input type="file" name="payment_proof" id="payment_proof" accept="image/*"
                                class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20">
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:scale-105 transition-transform text-white font-medium rounded-xl text-sm shadow-lg shadow-cyan-500/20">
                            Simpan Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- TAB CONTENT: FILES -->
        <div x-show="activeTab === 'files'" class="space-y-6" x-transition>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- List File/Aset -->
                <div class="lg:col-span-2 rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Aset Proyek</h3>
                    
                    <div class="space-y-3">
                        @forelse ($project->files as $file)
                            <div class="flex items-center justify-between p-4 bg-white/5 border border-white/5 rounded-2xl">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-cyan-400">
                                        @if ($file->type === 'upload')
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-white">{{ $file->name }}</p>
                                        <p class="text-xs text-gray-400">
                                            @if ($file->type === 'upload')
                                                Upload · {{ $file->mime_type }} · {{ number_format($file->size_bytes / 1024, 1) }} KB
                                            @else
                                                Tautan (Link)
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    @if ($file->type === 'upload')
                                        <a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="text-cyan-400 hover:text-cyan-300 font-semibold text-sm">
                                            Unduh
                                        </a>
                                    @else
                                        <a href="{{ $file->path }}" target="_blank" class="text-cyan-400 hover:text-cyan-300 font-semibold text-sm">
                                            Buka Link
                                        </a>
                                    @endif
                                    
                                    <form action="{{ route('files.destroy', $file) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-rose-400 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400 text-center py-6 text-sm">Belum ada file/tautan aset.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Form Tambah File/Aset -->
                <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6" x-data="{ assetType: 'upload' }">
                    <h3 class="text-lg font-bold text-white mb-4">Tambah File / Aset</h3>
                    
                    <form action="{{ route('projects.files.store', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Tipe Aset</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 text-white text-sm cursor-pointer">
                                    <input type="radio" name="type" value="upload" x-model="assetType" class="text-cyan-500 focus:ring-cyan-500 bg-white/5 border-white/10">
                                    Upload File (Maks 10MB)
                                </label>
                                <label class="flex items-center gap-2 text-white text-sm cursor-pointer">
                                    <input type="radio" name="type" value="link" x-model="assetType" class="text-cyan-500 focus:ring-cyan-500 bg-white/5 border-white/10">
                                    Tautan (URL Link)
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Aset / Label</label>
                            <input type="text" name="name" id="name" required placeholder="Contoh: Figma Design atau Project Proposal"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white text-sm focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none">
                        </div>

                        <div x-show="assetType === 'upload'">
                            <label for="file" class="block text-sm font-medium text-gray-300 mb-2">Pilih File</label>
                            <input type="file" name="file" id="file" ::required="assetType === 'upload'"
                                class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20">
                        </div>

                        <div x-show="assetType === 'link'">
                            <label for="path" class="block text-sm font-medium text-gray-300 mb-2">URL Tautan</label>
                            <input type="url" name="path" id="path" ::required="assetType === 'link'" placeholder="https://example.com"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white text-sm focus:border-cyan-400 focus:ring-cyan-400 focus:outline-none">
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:scale-105 transition-transform text-white font-medium rounded-xl text-sm shadow-lg shadow-cyan-500/20">
                            Simpan Aset
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- TAB CONTENT: TIMELOGS -->
        <div x-show="activeTab === 'timelogs'" class="space-y-6" x-transition>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- List Riwayat Kerja -->
                <div class="lg:col-span-2 rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-white">Riwayat Kerja</h3>
                        @php
                            $totalDuration = $project->timeLogs->where('is_running', false)->sum('duration_minutes');
                        @endphp
                        <span class="text-sm text-cyan-400 font-semibold">Total Jam Kerja: {{ number_format($totalDuration / 60, 1) }} Jam</span>
                    </div>
                    
                    <div class="space-y-3">
                        @forelse ($project->timeLogs->where('is_running', false) as $log)
                            <div class="p-4 bg-white/5 border border-white/5 rounded-2xl space-y-1">
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-medium text-white">{{ $log->note ?? 'Sesi kerja tanpa catatan' }}</p>
                                    <span class="text-xs font-bold text-cyan-400 bg-cyan-500/10 border border-cyan-500/20 px-2 py-0.5 rounded">
                                        {{ $log->duration_minutes }} Menit
                                    </span>
                                </div>
                                <p class="text-xs text-gray-400">
                                    {{ $log->start_time->format('d M Y, H:i') }} - {{ $log->end_time?->format('H:i') }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-400 text-center py-6 text-sm">Belum ada durasi kerja yang tercatat.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Timer / Mulai Pelacakan -->
                <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-6 text-center space-y-4">
                    <h3 class="text-lg font-bold text-white">Pelacak Waktu</h3>
                    
                    <div class="py-6 flex flex-col items-center justify-center bg-white/5 border border-white/5 rounded-2xl">
                        <svg class="h-10 w-10 text-cyan-400 animate-pulse mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-gray-300">Lacak waktu pengerjaan untuk proyek ini secara langsung.</p>
                    </div>

                    <a href="{{ route('timer.index') }}" class="block w-full py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:scale-105 transition-transform text-white font-medium rounded-xl text-sm shadow-lg shadow-cyan-500/20 text-center">
                        Buka Timer Pelacak
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
