<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Perpustakaan Digital</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased font-sans bg-gray-50 text-gray-900">
        
        @if (Route::has('login'))
            <div class="fixed top-0 right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-blue-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-blue-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-blue-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="relative flex flex-col items-center justify-center min-h-screen overflow-hidden bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
                <div class="mb-8 flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                
                <h1 class="text-5xl font-extrabold tracking-tight text-gray-900 sm:text-6xl mb-6">
                    Selamat Datang di <span class="text-blue-600">Perpustakaan DN</span>
                </h1>
                <p class="text-lg leading-8 text-gray-600 max-w-2xl mx-auto mb-10">
                    Akses ribuan koleksi buku, jurnal, dan literatur digital kapan saja dan di mana saja. Tingkatkan pengetahuan Anda dengan kemudahan peminjaman digital.
                </p>
                
                <div class="flex items-center justify-center gap-x-6">
                    <a href="{{ route('login') }}" class="rounded-md bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition">
                        Mulai Membaca
                    </a>
                    <a href="#features" class="text-sm font-semibold leading-6 text-gray-900">Lihat Layanan <span aria-hidden="true">→</span></a>
                </div>
            </div>

            <div class="mt-20 grid grid-cols-1 gap-8 sm:grid-cols-3 w-full max-w-4xl px-6">
                <div class="flex flex-col items-center p-6 bg-gray-50 rounded-xl border border-gray-100">
                    <dt class="text-sm font-medium leading-6 text-gray-600">Total Koleksi</dt>
                    <dd class="text-3xl font-bold tracking-tight text-blue-600">5,000+</dd>
                </div>
                <div class="flex flex-col items-center p-6 bg-gray-50 rounded-xl border border-gray-100">
                    <dt class="text-sm font-medium leading-6 text-gray-600">Anggota Aktif</dt>
                    <dd class="text-3xl font-bold tracking-tight text-blue-600">1,200+</dd>
                </div>
                <div class="flex flex-col items-center p-6 bg-gray-50 rounded-xl border border-gray-100">
                    <dt class="text-sm font-medium leading-6 text-gray-600">Buku Dipinjam</dt>
                    <dd class="text-3xl font-bold tracking-tight text-blue-600">450+</dd>
                </div>
            </div>
        </div>

        <div id="features" class="bg-gray-50 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-blue-600">Layanan Kami</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Segala kemudahan untuk literasi Anda</p>
                </div>
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                        <div class="relative pl-16">
                            <dt class="text-base font-semibold leading-7 text-gray-900">
                                <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                Pencarian Cepat
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">Temukan buku favorit Anda hanya dengan memasukkan judul, penulis, atau kategori dalam hitungan detik.</dd>
                        </div>
                        <div class="relative pl-16">
                            <dt class="text-base font-semibold leading-7 text-gray-900">
                                <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                </div>
                                Manajemen Peminjaman
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">Pantau tanggal pengembalian dan riwayat peminjaman Anda secara transparan melalui dashboard anggota.</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <footer class="bg-white border-t border-gray-200 py-10">
            <div class="max-w-7xl mx-auto px-6 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} E-Perpus. Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </footer>
    </body>
</html>