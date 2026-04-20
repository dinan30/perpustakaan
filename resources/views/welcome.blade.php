<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistem Perpustakaan Digital</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,800,900&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased font-sans bg-gray-50 text-gray-900 selection:bg-indigo-500 selection:text-white">
        
        {{-- Navbar --}}
        <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="font-black text-xl tracking-tight text-gray-800">Perpustakaan <span class="text-indigo-600">DN</span></span>
                </div>
                
                @if (Route::has('login'))
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition-colors">Masuk Dashboard &rarr;</a>
                        @else
                            <a href="{{ route('login') }}" class="font-bold text-gray-600 hover:text-indigo-600 transition-colors">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5">Daftar</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </nav>

        {{-- Hero Section --}}
        <main class="relative flex flex-col items-center justify-center min-h-screen pt-20 pb-12 overflow-hidden bg-white">
            
            {{-- Background Decoration --}}
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-indigo-50 rounded-full blur-3xl opacity-50 -z-10"></div>
            
            <div class="max-w-7xl mx-auto px-6 text-center z-10">
                
                <span class="inline-block py-1.5 px-4 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-sm font-bold tracking-widest uppercase mb-8">
                    Manajemen Perpustakaan Digital
                </span>
                
                <h1 class="text-5xl md:text-7xl font-black tracking-tight text-gray-900 mb-6 leading-tight">
                    Jelajahi Dunia Lewat <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Buku</span>
                </h1>
                
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-indigo-600 text-white font-black tracking-widest uppercase shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:shadow-2xl transition-all transform hover:-translate-y-1">
                        Mulai Sekarang
                    </a>
                </div>
            </div>

            </div>
        </main>

        <footer class="bg-white border-t border-gray-100 py-8">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="font-black text-gray-800">Perpus<span class="text-indigo-600">takaan</span></span>
                </div>
                <p class="text-gray-400 text-sm font-medium">
                    &copy; {{ date('Y') }} Sistem Informasi Perpustakaan Digital.
                </p>
            </div>
        </footer>
    </body>
</html>