<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Daftar Klien') }}
            </h2>
            <a href="{{ route('clients.create') }}" class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-medium rounded-xl hover:scale-105 transition-transform shadow-lg shadow-cyan-500/20">
                + Klien Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12 relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 rounded-2xl backdrop-blur-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($clients as $client)
                <div class="rounded-3xl bg-gray-900/60 backdrop-blur-xl shadow-2xl border border-white/10 p-6 flex flex-col justify-between hover:shadow-cyan-500/10 hover:border-white/20 transition-all duration-300">
                    <div>
                        <div class="flex items-start justify-between">
                            <div class="h-12 w-12 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 font-bold text-lg">
                                {{ strtoupper(substr($client->name, 0, 2)) }}
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/5 border border-white/10 text-gray-300">
                                {{ $client->projects_count }} Proyek
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-white mt-4">{{ $client->name }}</h3>
                        
                        <div class="mt-4 space-y-2 text-sm text-gray-400">
                            @if ($client->phone)
                                <div class="flex items-center gap-2">
                                    <svg class="h-4 w-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ $client->phone }}</span>
                                </div>
                            @endif
                            @if ($client->email)
                                <div class="flex items-center gap-2">
                                    <svg class="h-4 w-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $client->email }}</span>
                                </div>
                            @endif
                            @if ($client->notes)
                                <p class="mt-3 text-xs bg-white/5 p-3 rounded-xl border border-white/5 line-clamp-2">
                                    {{ $client->notes }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-white/5 flex gap-3">
                        <a href="{{ route('clients.show', $client) }}" class="flex-1 text-center py-2 bg-gradient-to-r from-cyan-500/10 to-blue-600/10 hover:from-cyan-500/20 hover:to-blue-600/20 border border-cyan-500/30 rounded-xl text-sm font-medium text-cyan-300 transition-colors">
                            Detail
                        </a>
                        <a href="{{ route('clients.edit', $client) }}" class="px-3 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-sm font-medium text-white transition-colors flex items-center justify-center">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                        <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus klien ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-2 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 rounded-xl text-sm font-medium text-rose-400 transition-colors flex items-center justify-center">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-3xl bg-gray-900/60 backdrop-blur-xl border border-white/10 p-12 text-center">
                    <p class="text-gray-400">Belum ada klien yang terdaftar. Klik "+ Klien Baru" untuk menambahkan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $clients->links() }}
        </div>
    </div>
</x-app-layout>
