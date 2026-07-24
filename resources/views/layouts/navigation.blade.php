<nav x-data="{ open: false }" class="bg-gray-900/60 backdrop-blur-xl border-b border-white/10 relative z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-white hover:text-cyan-400 transition-colors">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-cyan-400 text-white' : 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-600' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('projects.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('projects.*') ? 'border-cyan-400 text-white' : 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-600' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        {{ __('Proyek') }}
                    </a>
                    <a href="{{ route('clients.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('clients.*') ? 'border-cyan-400 text-white' : 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-600' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        {{ __('Klien') }}
                    </a>
                    <a href="{{ route('timer.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('timer.*') ? 'border-cyan-400 text-white' : 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-600' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        {{ __('Timer') }}
                    </a>
                    <a href="{{ route('statistics.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('statistics.*') ? 'border-cyan-400 text-white' : 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-600' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        {{ __('Statistik') }}
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 bg-white/5 hover:text-white hover:bg-white/10 focus:outline-none transition ease-in-out duration-150 border border-white/10 backdrop-blur-md">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-gray-800 border border-white/10 rounded-md shadow-2xl overflow-hidden py-1">
                            <a href="{{ route('profile.edit') }}" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-300 hover:bg-white/10 hover:text-white focus:outline-none focus:bg-white/10 transition duration-150 ease-in-out">
                                {{ __('Profile') }}
                            </a>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-300 hover:bg-white/10 hover:text-white focus:outline-none focus:bg-white/10 transition duration-150 ease-in-out">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-white/10 focus:outline-none focus:bg-white/10 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-900/90 backdrop-blur-xl border-b border-white/10">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('dashboard') ? 'border-cyan-400 text-cyan-300 bg-cyan-900/30' : 'border-transparent text-gray-400 hover:text-gray-200 hover:bg-white/5 hover:border-gray-600' }} text-start text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                {{ __('Dashboard') }}
            </a>
            <a href="{{ route('projects.index') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('projects.*') ? 'border-cyan-400 text-cyan-300 bg-cyan-900/30' : 'border-transparent text-gray-400 hover:text-gray-200 hover:bg-white/5 hover:border-gray-600' }} text-start text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                {{ __('Proyek') }}
            </a>
            <a href="{{ route('clients.index') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('clients.*') ? 'border-cyan-400 text-cyan-300 bg-cyan-900/30' : 'border-transparent text-gray-400 hover:text-gray-200 hover:bg-white/5 hover:border-gray-600' }} text-start text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                {{ __('Klien') }}
            </a>
            <a href="{{ route('timer.index') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('timer.*') ? 'border-cyan-400 text-cyan-300 bg-cyan-900/30' : 'border-transparent text-gray-400 hover:text-gray-200 hover:bg-white/5 hover:border-gray-600' }} text-start text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                {{ __('Timer') }}
            </a>
            <a href="{{ route('statistics.index') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('statistics.*') ? 'border-cyan-400 text-cyan-300 bg-cyan-900/30' : 'border-transparent text-gray-400 hover:text-gray-200 hover:bg-white/5 hover:border-gray-600' }} text-start text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                {{ __('Statistik') }}
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/10">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-gray-400 hover:text-gray-200 hover:bg-white/5 hover:border-gray-600 text-start text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                    {{ __('Profile') }}
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-gray-400 hover:text-gray-200 hover:bg-white/5 hover:border-gray-600 text-start text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>
