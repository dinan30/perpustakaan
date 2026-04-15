<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-500 text-white p-5 rounded-2xl shadow-lg mb-6 flex items-center gap-3 animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-[2rem] border border-gray-100 overflow-hidden">
                <div class="p-10">
                    <div class="text-center mb-10">
                        <div class="inline-block p-4 bg-indigo-100 rounded-3xl text-indigo-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-800 uppercase tracking-tighter">Formulir Peminjaman</h3>
                        <p class="text-gray-500 font-medium">Sistem akan mencatat peminjaman secara otomatis sesuai data login Anda.</p>
                    </div>

                    <form action="{{ route('siswa.pinjam') }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="space-y-3">
                            <label for="buku_id" class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Cari Judul Buku</label>
                            <div class="relative">
                                <select name="buku_id" id="buku_id" class="block w-full rounded-2xl border-gray-200 bg-gray-50 py-4 px-5 text-gray-700 font-bold focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition appearance-none shadow-sm" required>
                                    <option value="">-- Pilih Buku Tersedia --</option>
                                    @foreach($semuaBuku as $buku)
                                        <option value="{{ $buku->id }}">{{ $buku->judul }} (Stok: {{ $buku->stok }})</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-400">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100 flex items-start gap-4">
                            <div class="text-indigo-600 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-xs text-indigo-700 font-medium leading-relaxed">
                                <strong>Ketentuan:</strong> Masa peminjaman berlaku selama 7 hari sejak tanggal hari ini. Harap mengembalikan buku tepat waktu untuk menghindari denda atau sanksi.
                            </p>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-black py-5 rounded-2xl shadow-xl shadow-indigo-100 transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-sm flex items-center justify-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Konfirmasi Pinjam Buku
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>