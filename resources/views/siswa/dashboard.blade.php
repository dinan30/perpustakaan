<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 leading-tight">
            {{ __('👋 Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Total Pinjaman</p>
                        <h4 class="text-4xl font-black text-gray-800 mt-1">{{ $pinjamanSaya->count() }} <span class="text-lg font-medium text-gray-400">Buku</span></h4>
                    </div>
                    <div class="p-4 bg-indigo-50 rounded-2xl text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Belum Kembali</p>
                        <h4 class="text-4xl font-black text-orange-600 mt-1">{{ $pinjamanSaya->where('status', 'pinjam')->count() }} <span class="text-lg font-medium text-gray-400">Buku</span></h4>
                    </div>
                    <div class="p-4 bg-orange-50 rounded-2xl text-orange-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-2xl font-black">Mau baca buku apa hari ini?</h3>
                    <p class="text-indigo-100 opacity-80 mt-1 font-medium">Temukan koleksi buku terbaru dan pinjam secara mandiri di sini.</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100 p-8">
                <h3 class="font-black text-gray-800 mb-6 uppercase text-sm tracking-widest border-b pb-4">Riwayat Terakhir</h3>
                </div>
        </div>
    </div>
</x-app-layout>