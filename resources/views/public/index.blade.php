<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Public Showcase & Status Proyek | Freelance Hub</title>
    <meta name="description" content="Platform resmi pemantauan status pengerjaan sistem aplikasi, joki koding, dan proyek freelance. Transparan, terstruktur, dan terpantau secara langsung.">
    <meta property="og:title" content="Public Showcase & Status Proyek | Freelance Hub">
    <meta property="og:description" content="Platform resmi pemantauan status pengerjaan sistem aplikasi, joki koding, dan proyek freelance.">
    <meta property="og:image" content="{{ asset('images/og-showcase.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/robot-dashboard.js'])
</head>
<body class="bg-gray-950 text-gray-300 font-sans antialiased overflow-x-hidden min-h-screen flex flex-col selection:bg-cyan-500 selection:text-white">

    <!-- Canvas Robot 3D / Partikel Background -->
    <div id="dashboard-bg" class="fixed top-0 left-0 w-full h-full -z-10 pointer-events-none"></div>

    <!-- Navigation Header -->
    @include('layouts.guest-navigation')

    <!-- Main Content Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 relative z-10">

        <!-- Hero Section -->
        <div class="text-center max-w-3xl mx-auto mb-12 animate-fade-in-up">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 mb-4">
                <span class="h-2 w-2 rounded-full bg-cyan-400 animate-ping"></span>
                Status Proyek Real-Time
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight mb-4">
                Pantau Progres Tugas & <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">Jasa Joki Tugas</span>
            </h2>
            <p class="text-base sm:text-lg text-zinc-400 mb-6 leading-relaxed">
                Platform resmi pemantauan status pengerjaan sistem aplikasi, joki koding, dan proyek freelance. Transparan, terstruktur, dan terpantau secara langsung.
            </p>
            <div class="flex items-center justify-center gap-4 flex-wrap">
                <a href="https://wa.me/6287842166300?text=Halo%20Erfyan,%20saya%20tertarik%20untuk%20diskusi%20proyek" target="_blank" rel="noopener noreferrer"
                   class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold rounded-2xl text-sm shadow-lg shadow-emerald-500/25 hover:scale-105 transition-all flex items-center gap-2">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Konsultasi & Order Proyek</span>
                </a>

                <!-- Scroll to Project List Button -->
                <a href="#daftar-tugas"
                   onclick="event.preventDefault(); document.getElementById('daftar-tugas').scrollIntoView({ behavior: 'smooth', block: 'start' });"
                   class="px-6 py-3 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-cyan-500/40 text-white font-bold rounded-2xl text-sm hover:scale-105 transition-all flex items-center gap-2 group">
                    <svg class="h-5 w-5 text-cyan-400 group-hover:translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <span>Pantau Tugas</span>
                </a>
            </div>
        </div>

        <!-- Kartu Ringkasan Publik -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            <!-- Proyek Selesai -->
            <div class="glass-panel p-6 rounded-2xl flex items-center justify-between border border-zinc-800">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Proyek Selesai</p>
                    <p class="text-3xl font-extrabold text-white mt-1">{{ $totalDone }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Proyek Dalam Progres -->
            <div class="glass-panel p-6 rounded-2xl flex items-center justify-between border border-zinc-800">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Sedang Dikerjakan</p>
                    <p class="text-3xl font-extrabold text-cyan-400 mt-1">{{ $totalInProgress }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>

            <!-- Total Klien Terlayani -->
            <div class="glass-panel p-6 rounded-2xl flex items-center justify-between border border-zinc-800">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Klien Terlayani</p>
                    <p class="text-3xl font-extrabold text-white mt-1">{{ $totalClients }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div id="daftar-tugas" class="glass-panel p-6 rounded-3xl mb-8 border border-zinc-900 scroll-mt-20">
            <form action="{{ route('public.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Search Input -->
                <div>
                    <label for="search" class="block text-xs font-semibold text-zinc-400 uppercase mb-2">Cari Nama Proyek</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..."
                           class="w-full bg-zinc-900/60 border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-cyan-500 focus:ring-cyan-500 focus:outline-none placeholder-zinc-500 transition-colors">
                </div>

                <!-- Type Filter -->
                <div>
                    <label for="type" class="block text-xs font-semibold text-zinc-400 uppercase mb-2">Tipe Proyek</label>
                    <select name="type" id="type" onchange="this.form.submit()"
                            class="w-full bg-zinc-900/60 border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-cyan-500 focus:ring-cyan-500 focus:outline-none transition-colors">
                        <option value="">Semua Tipe</option>
                        <option value="aplikasi" {{ request('type') === 'aplikasi' ? 'selected' : '' }}>Pengembangan Aplikasi</option>
                        <option value="joki" {{ request('type') === 'joki' ? 'selected' : '' }}>Joki / Tugas Koding</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-xs font-semibold text-zinc-400 uppercase mb-2">Status Pengerjaan</label>
                    <select name="status" id="status" onchange="this.form.submit()"
                            class="w-full bg-zinc-900/60 border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-cyan-500 focus:ring-cyan-500 focus:outline-none transition-colors">
                        <option value="">Semua Status</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>⚡ Sedang Dikerjakan (In Progress)</option>
                        <option value="on_hold" {{ request('status') === 'on_hold' ? 'selected' : '' }}>⏸️ Tertunda (On Hold)</option>
                        <option value="done" {{ request('status') === 'done' ? 'selected' : '' }}>✅ Selesai (Done)</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Catalog / Project Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @forelse ($projects as $project)
                <div class="glass-panel glass-panel-hover p-6 rounded-2xl flex flex-col justify-between border border-zinc-800 group">
                    <div>
                        <!-- Top Badges -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider
                                {{ $project->status === 'done' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' :
                                   ($project->status === 'in_progress' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 animate-pulse' :
                                   ($project->status === 'on_hold' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' :
                                   ($project->status === 'cancelled' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : 'bg-zinc-800 text-zinc-400 border border-zinc-700'))) }}">
                                {{ ['todo' => '📋 To Do', 'in_progress' => '⚡ In Progress', 'on_hold' => '⏸️ On Hold', 'done' => '✅ Selesai', 'cancelled' => '❌ Batal'][$project->status] ?? $project->status }}
                            </span>
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-semibold uppercase tracking-wider bg-zinc-900 text-zinc-400 border border-zinc-800">
                                {{ $project->type === 'joki' ? '💻 Joki' : '🚀 Aplikasi' }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-bold text-white group-hover:text-cyan-400 transition-colors mb-2 leading-snug">
                            {{ $project->title }}
                        </h3>

                        <!-- Client / Category Badge -->
                        <p class="text-xs text-zinc-400 flex items-center gap-2 mb-4">
                            <svg class="h-3.5 w-3.5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            @if($project->category === 'personal')
                                <span class="font-medium text-purple-400">🧑‍💻 Proyek Personal</span>
                            @else
                                <span class="font-medium text-zinc-300">{{ $project->client?->name ?? 'Klien Mitra' }}</span>
                            @endif
                        </p>
                    </div>

                    <!-- Card Footer info -->
                    <div class="pt-4 border-t border-zinc-900 flex items-center justify-between text-xs text-zinc-400">
                        <div class="flex items-center gap-1.5">
                            <svg class="h-3.5 w-3.5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Deadline: {{ $project->deadline?->format('d M Y') ?? 'Tanpa deadline' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full glass-panel p-12 text-center rounded-3xl border border-zinc-900">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-zinc-900 mb-4">
                        <svg class="h-8 w-8 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <p class="text-white font-semibold text-lg">Tidak ada proyek yang cocok.</p>
                    <p class="text-sm text-zinc-400 mt-1">Coba sesuaikan kata kunci pencarian atau filter pilihan Anda.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mb-12">
            {{ $projects->links() }}
        </div>

        <!-- Testimoni / Portfolio Section -->
        <div class="mt-20 mb-10 text-center animate-fade-in-up">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-4">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                Kredibilitas & Kepercayaan
            </span>
            <h2 class="text-3xl font-extrabold text-white tracking-tight mb-4">Portofolio & Apa Kata Klien</h2>
            <p class="text-zinc-400 max-w-2xl mx-auto mb-10">Beberapa umpan balik dari klien yang telah mempercayakan proyek pengembangan sistem dan penyelesaian tugas mereka kepada kami.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-left">
                <!-- Testimonial 1 -->
                <div class="glass-panel p-8 rounded-3xl border border-zinc-800 relative">
                    <div class="absolute -top-5 -left-2 text-6xl text-zinc-800 font-serif">"</div>
                    <p class="text-sm text-zinc-300 relative z-10 italic mb-6">"Pengerjaannya sangat cepat dan rapi. Sistem kasir yang dibuatkan sangat membantu operasional toko saya. Dokumentasinya juga lengkap!"</p>
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center text-white font-bold">A</div>
                        <div>
                            <p class="text-sm font-bold text-white">Andi S.</p>
                            <p class="text-xs text-zinc-500">Pemilik Toko Retail</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="glass-panel p-8 rounded-3xl border border-zinc-800 relative">
                    <div class="absolute -top-5 -left-2 text-6xl text-zinc-800 font-serif">"</div>
                    <p class="text-sm text-zinc-300 relative z-10 italic mb-6">"Tugas koding saya selesai sebelum deadline dengan hasil yang di luar ekspektasi. Penjelasannya juga mudah dipahami untuk presentasi."</p>
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold">B</div>
                        <div>
                            <p class="text-sm font-bold text-white">Budi Santoso</p>
                            <p class="text-xs text-zinc-500">Mahasiswa Informatika</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="glass-panel p-8 rounded-3xl border border-zinc-800 relative md:col-span-2 lg:col-span-1">
                    <div class="absolute -top-5 -left-2 text-6xl text-zinc-800 font-serif">"</div>
                    <p class="text-sm text-zinc-300 relative z-10 italic mb-6">"Sangat profesional! Update progress secara berkala dan fitur yang direquest diimplementasikan dengan sempurna tanpa bug."</p>
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-rose-400 to-red-500 flex items-center justify-center text-white font-bold">C</div>
                        <div>
                            <p class="text-sm font-bold text-white">Citra Lestari</p>
                            <p class="text-xs text-zinc-500">Startup Founder</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-zinc-950 border-t border-zinc-900 py-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-xs text-zinc-500">
                &copy; {{ date('Y') }} Freelance Hub. All rights reserved. Managed by Erfyan.
            </p>
            <div class="flex items-center gap-4 text-xs text-zinc-400">
                <a href="https://github.com/Erfyan" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">GitHub</a>
                <span class="text-zinc-700">&bull;</span>
                <a href="https://instagram.com/erft.09" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">Instagram</a>
                <span class="text-zinc-700">&bull;</span>
                <a href="https://wa.me/6287842166300" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">WhatsApp</a>
            </div>
        </div>
    </footer>

</body>
</html>
