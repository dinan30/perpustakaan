<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="font-bold tracking-tight">
                        {{ __('🏠 Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('transaksi.index')" :active="request()->routeIs('transaksi.index')"
                            class="font-bold tracking-tight">
                            {{ __('💸 Transaksi') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('buku.index')" :active="request()->routeIs('buku.index')"
                            class="font-bold tracking-tight">
                            {{ __('📚 Buku') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')"
                            class="font-bold tracking-tight text-orange-600">
                            {{ __('👥 Users') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'siswa')
                        <x-nav-link :href="route('siswa.peminjaman')" :active="request()->routeIs('siswa.peminjaman')">
                            {{ __('📖 Pinjam Buku') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'siswa')
                        <x-nav-link :href="route('siswa.riwayat')" :active="request()->routeIs('siswa.riwayat')">
                            {{ __('📖 Riwayat Peminjaman') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm leading-4 font-bold rounded-xl text-gray-700 bg-gray-50 hover:bg-white hover:border-indigo-300 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    {{ Auth::user()->name }}
                                    <span
                                        class="text-[10px] bg-indigo-600 text-white px-2 py-0.5 rounded-md uppercase tracking-tighter">
                                        {{ Auth::user()->role }}
                                    </span>
                                </div>

                                <div class="ms-2 text-gray-400">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div
                                class="px-4 py-2 text-xs text-gray-400 font-black uppercase tracking-widest border-b border-gray-100">
                                Pengaturan Akun
                            </div>
                            <x-dropdown-link :href="route('profile.edit')" class="font-bold">
                                {{ __('My Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <x-dropdown-link href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="text-red-600 font-black">
                                    {{ __('Keluar Aplikasi') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-gray-500 bg-gray-50 hover:text-indigo-600 hover:bg-indigo-50 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="font-bold">
                {{ __('🏠 Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('transaksi.index')" :active="request()->routeIs('transaksi.index')"
                class="font-bold">
                {{ __('💸 Transaksi') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('buku.index')" :active="request()->routeIs('buku.index')"
                class="font-bold">
                {{ __('📚 Buku') }}
            </x-responsive-nav-link>
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')"
                    class="font-bold text-orange-600">
                    {{ __('👥 Users') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 bg-gray-50">
            <div class="px-4 flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-black">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-black text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="font-bold">
                    {{ __('Settings') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}" id="mobile-logout-form">
                    @csrf
                    <x-responsive-nav-link href="#"
                        onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();"
                        class="font-black text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>