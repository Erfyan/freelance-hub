<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Freelance Hub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Animasi untuk global timer */
        @@keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 5px rgba(6, 182, 212, 0.5); }
            50% { box-shadow: 0 0 20px rgba(6, 182, 212, 0.8); }
        }
        .timer-glow {
            animation: pulse-glow 2s infinite;
        }
    </style>
</head>
<body class="bg-gray-950 text-gray-300 font-sans antialiased overflow-x-hidden" x-data="{ sidebarOpen: false }">
    <!-- Canvas untuk robot 3D & partikel (Global) -->
    <div id="dashboard-bg" class="fixed top-0 left-0 w-full h-full -z-10 pointer-events-none"></div>

    <div class="flex min-h-screen bg-transparent relative z-10">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" 
             class="fixed inset-0 z-40 bg-black/80 backdrop-blur-sm transition-opacity md:hidden"
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar -->
        <aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" 
               class="fixed inset-y-0 left-0 z-50 w-64 bg-zinc-950 border-r border-zinc-900 text-zinc-300 flex flex-col flex-shrink-0 transition-transform duration-300 ease-in-out md:relative md:translate-x-0">
            <div class="p-6 border-b border-zinc-900">
                <h1 class="text-xl font-semibold text-white tracking-tight">
                    Freelance Hub
                </h1>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-zinc-900 text-white' : 'text-zinc-400 hover:bg-zinc-900/50 hover:text-zinc-200' }}">
                    <svg class="h-5 w-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-zinc-300' : 'text-zinc-500 group-hover:text-zinc-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('projects.index') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('projects.*') ? 'bg-zinc-900 text-white' : 'text-zinc-400 hover:bg-zinc-900/50 hover:text-zinc-200' }}">
                    <svg class="h-5 w-5 mr-3 {{ request()->routeIs('projects.*') ? 'text-zinc-300' : 'text-zinc-500 group-hover:text-zinc-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Proyek
                </a>
                <a href="{{ route('clients.index') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('clients.*') ? 'bg-zinc-900 text-white' : 'text-zinc-400 hover:bg-zinc-900/50 hover:text-zinc-200' }}">
                    <svg class="h-5 w-5 mr-3 {{ request()->routeIs('clients.*') ? 'text-zinc-300' : 'text-zinc-500 group-hover:text-zinc-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Klien
                </a>
                <a href="{{ route('timer.index') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('timer.*') ? 'bg-zinc-900 text-white' : 'text-zinc-400 hover:bg-zinc-900/50 hover:text-zinc-200' }}">
                    <svg class="h-5 w-5 mr-3 {{ request()->routeIs('timer.*') ? 'text-zinc-300' : 'text-zinc-500 group-hover:text-zinc-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Timer Kerja
                </a>
                <a href="{{ route('statistics.index') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('statistics.*') ? 'bg-zinc-900 text-white' : 'text-zinc-400 hover:bg-zinc-900/50 hover:text-zinc-200' }}">
                    <svg class="h-5 w-5 mr-3 {{ request()->routeIs('statistics.*') ? 'text-zinc-300' : 'text-zinc-500 group-hover:text-zinc-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Statistik
                </a>
                <a href="{{ route('webauthn.register.page') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('webauthn.register.page') ? 'bg-zinc-900 text-white' : 'text-zinc-400 hover:bg-zinc-900/50 hover:text-zinc-200' }}">
                    <svg class="h-5 w-5 mr-3 {{ request()->routeIs('webauthn.register.page') ? 'text-zinc-300' : 'text-zinc-500 group-hover:text-zinc-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    Passkey
                </a>
            </nav>
            <div class="p-4 border-t border-zinc-900 space-y-3">
                <div class="flex items-center gap-3 px-2">
                    <div class="h-8 w-8 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-300 font-semibold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <a href="{{ route('profile.edit') }}" class="text-[10px] text-zinc-500 hover:text-white transition-colors uppercase font-medium tracking-wide">Edit Profil</a>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-2 py-2 text-xs text-zinc-400 hover:text-zinc-200 transition-colors">
                        <svg class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="min-h-screen bg-transparent relative z-10 flex-1 flex flex-col w-full overflow-hidden">

            @php
                $runningTimer = \App\Models\TimeLog::where('is_running', true)->with('project')->first();
            @endphp
            @if ($runningTimer)
                <div class="bg-gradient-to-r from-amber-500/90 to-orange-600/90 backdrop-blur-md border-b border-amber-500/20 text-white py-3 px-4 shadow-lg relative z-20">
                    <div class="max-w-7xl mx-auto flex justify-between items-center text-sm">
                        <div class="flex items-center gap-2">
                            <span class="animate-pulse">🔴</span>
                            <span>Pelacakan waktu aktif: <strong>{{ $runningTimer->project->title ?? 'Tanpa Nama' }}</strong> berjalan sejak {{ $runningTimer->start_time->format('H:i, d M Y') }}.</span>
                        </div>
                        <a href="{{ route('timer.index') }}" class="px-3 py-1 bg-white/20 hover:bg-white/30 rounded-lg font-bold text-xs uppercase transition-colors shrink-0">
                            Kelola
                        </a>
                    </div>
                </div>
            @endif

            <!-- Page Heading -->
            <header class="bg-zinc-950/90 backdrop-blur-md border-b border-zinc-900 px-4 md:px-8 py-4 md:py-5 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center gap-4 w-full">
                    <button @click="sidebarOpen = true" class="md:hidden p-2 -ml-2 text-zinc-400 hover:text-white focus:outline-none shrink-0">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex-1 w-full">
                        @if (isset($header))
                            {{ $header }}
                        @else
                            <h2 class="text-xl font-semibold text-white">Selamat datang, {{ auth()->user()->name }}</h2>
                            <p class="text-sm text-zinc-500 mt-0.5">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-4 md:p-8 animate-fade-in-up overflow-x-hidden">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Global Timer Indicator -->
    @if(isset($runningTimer) && $runningTimer)
        <x-global-timer 
            :project="$runningTimer->project"
            :startTime="$runningTimer->start_time->toIso8601String()"
        />
    @endif

    <!-- Global Interactive Draggable Collapsible Dock -->
    <div id="interactive-dock" class="fixed top-24 right-8 z-50 flex flex-col items-center gap-3" style="touch-action: none;">
        <!-- Toggle & Drag Main Button -->
        <button id="dock-toggle-btn" class="w-12 h-12 bg-zinc-900 border border-zinc-700 rounded-full shadow-lg flex items-center justify-center text-zinc-300 cursor-grab hover:bg-white hover:text-black transition-colors z-50 relative">
            <svg id="dock-icon" class="w-5 h-5 transition-transform duration-300 ease-out" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <!-- Hamburger Icon -->
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Collapsible Menu -->
        <div id="dock-menu" class="flex flex-col gap-2 p-2 bg-zinc-900/95 backdrop-blur-xl border border-zinc-800 rounded-2xl shadow-xl transition-all duration-300 origin-top opacity-0 scale-y-0 pointer-events-none">
            <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-zinc-800/50 hover:bg-zinc-100 hover:text-black text-zinc-400 transition-colors dock-btn" title="Mode Robot">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4h6m-3-1v3M4 7h6m-3-1v3M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                </svg>
            </button>
            <a href="{{ route('projects.create') }}" class="w-10 h-10 flex items-center justify-center rounded-lg bg-zinc-800/50 hover:bg-zinc-100 hover:text-black text-zinc-400 transition-colors dock-btn" title="Proyek Baru">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
            <a href="{{ route('timer.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg bg-zinc-800/50 hover:bg-zinc-100 hover:text-black text-zinc-400 transition-colors dock-btn" title="Mulai Timer">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </a>
            <a href="{{ route('statistics.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg bg-zinc-800/50 hover:bg-zinc-100 hover:text-black text-zinc-400 transition-colors dock-btn" title="Statistik">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </a>
        </div>
    </div>

    @stack('scripts')
    @vite(['resources/js/robot-dashboard.js'])
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dock = document.getElementById('interactive-dock');
            const toggleBtn = document.getElementById('dock-toggle-btn');
            const menu = document.getElementById('dock-menu');
            const icon = document.getElementById('dock-icon');
            
            let isDragging = false;
            let hasMoved = false;
            let currentX = 0, currentY = 0, initialX = 0, initialY = 0, xOffset = 0, yOffset = 0;
            let menuOpen = false;

            toggleBtn.addEventListener('mousedown', dragStart);
            document.addEventListener('mouseup', dragEnd);
            document.addEventListener('mousemove', drag);

            toggleBtn.addEventListener('touchstart', dragStart, { passive: false });
            document.addEventListener('touchend', dragEnd);
            document.addEventListener('touchmove', drag, { passive: false });

            function dragStart(e) {
                if (e.type === 'touchstart') {
                    initialX = e.touches[0].clientX - xOffset;
                    initialY = e.touches[0].clientY - yOffset;
                } else {
                    initialX = e.clientX - xOffset;
                    initialY = e.clientY - yOffset;
                }

                if (e.target === toggleBtn || toggleBtn.contains(e.target)) {
                    isDragging = true;
                    hasMoved = false;
                    toggleBtn.classList.add('cursor-grabbing');
                    toggleBtn.classList.remove('cursor-grab');
                }
            }

            function dragEnd(e) {
                initialX = currentX;
                initialY = currentY;
                
                if (isDragging && !hasMoved) {
                    toggleMenu();
                }
                
                isDragging = false;
                toggleBtn.classList.remove('cursor-grabbing');
                toggleBtn.classList.add('cursor-grab');
            }

            function drag(e) {
                if (isDragging) {
                    e.preventDefault();
                    
                    let clientX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
                    let clientY = e.type === 'touchmove' ? e.touches[0].clientY : e.clientY;
                    
                    currentX = clientX - initialX;
                    currentY = clientY - initialY;

                    if (Math.abs(currentX - xOffset) > 3 || Math.abs(currentY - yOffset) > 3) {
                        hasMoved = true;
                    }

                    xOffset = currentX;
                    yOffset = currentY;
                    setTranslate(currentX, currentY, dock);
                }
            }

            function toggleMenu() {
                menuOpen = !menuOpen;
                if (menuOpen) {
                    menu.classList.remove('opacity-0', 'scale-y-0', 'pointer-events-none');
                    menu.classList.add('opacity-100', 'scale-y-100', 'pointer-events-auto');
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                    icon.classList.add('rotate-90');
                } else {
                    menu.classList.add('opacity-0', 'scale-y-0', 'pointer-events-none');
                    menu.classList.remove('opacity-100', 'scale-y-100', 'pointer-events-auto');
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                    icon.classList.remove('rotate-90');
                }
            }

            function setTranslate(xPos, yPos, el) {
                el.style.transform = `translate3d(${xPos}px, ${yPos}px, 0)`;
            }
            
            const buttons = dock.querySelectorAll('.dock-btn');
            buttons.forEach(btn => {
                btn.addEventListener('mousedown', function(e) {
                    e.stopPropagation();
                    this.style.transform = 'scale(0.9)';
                });
                btn.addEventListener('mouseup', function(e) {
                    e.stopPropagation();
                    this.style.transform = 'scale(1)';
                });
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
                btn.addEventListener('click', function(e) {
                    // Robot mode button interaction
                    if (this.title === 'Mode Robot') {
                        e.stopPropagation();
                        const ripple = document.createElement('div');
                        ripple.classList.add('absolute', 'bg-white/30', 'rounded-full', 'w-full', 'h-full', 'animate-ping');
                        this.appendChild(ripple);
                        setTimeout(() => ripple.remove(), 1000);
                    }
                });
            });
        });
    </script>
</body>
</html>