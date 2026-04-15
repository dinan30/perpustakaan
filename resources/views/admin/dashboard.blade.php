<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-gray-800 leading-tight flex items-center gap-2">
            <span class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </span>
            {{ __('Admin Control Panel') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-3xl font-black">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="mt-2 text-indigo-100 font-medium opacity-90">Pantau aktivitas perpustakaan dan kelola data operasional dalam satu layar.</p>
                </div>
                <div class="absolute top-0 right-0 -mr-10 -mt-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Koleksi Buku</p>
                            <h4 class="text-4xl font-black text-gray-800 mt-2">{{ \App\Models\Buku::count() }}</h4>
                        </div>
                        <div class="p-4 bg-blue-50 rounded-2xl text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs font-bold text-blue-600 bg-blue-50 py-1 px-3 rounded-full w-fit">
                        Total Judul Terdaftar
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Peminjaman</p>
                            <h4 class="text-4xl font-black text-gray-800 mt-2">{{ \App\Models\Transaksi::where('status', 'pinjam')->count() }}</h4>
                        </div>
                        <div class="p-4 bg-orange-50 rounded-2xl text-orange-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs font-bold text-orange-600 bg-orange-50 py-1 px-3 rounded-full w-fit">
                        Sedang Berjalan
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Total Anggota</p>
                            <h4 class="text-4xl font-black text-gray-800 mt-2">{{ \App\Models\User::where('role', 'siswa')->count() }}</h4>
                        </div>
                        <div class="p-4 bg-green-50 rounded-2xl text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs font-bold text-green-600 bg-green-50 py-1 px-3 rounded-full w-fit">
                        Siswa Aktif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-tighter">Aktivitas Sistem</h3>
                    <span class="text-xs font-bold text-gray-400 bg-gray-100 px-3 py-1 rounded-full uppercase">Realtime Status</span>
                </div>
                <div class="border-l-4 border-indigo-500 pl-4 py-2">
                    <p class="text-gray-600 leading-relaxed">
                        Anda sedang login sebagai <span class="font-bold text-indigo-600">Administrator</span>. 
                        Gunakan menu navigasi di atas untuk melakukan manajemen data buku, verifikasi pengembalian, atau mengelola akun pengguna.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>