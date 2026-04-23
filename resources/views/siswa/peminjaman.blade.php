<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-500 text-white p-5 rounded-2xl shadow-lg mb-6 flex items-center gap-3 animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500 text-white p-5 rounded-2xl shadow-lg mb-6 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-[2rem] border border-gray-100 overflow-hidden">
                <div class="p-10">
                    <div class="text-center mb-10">
                        <div class="inline-block p-4 bg-indigo-100 rounded-3xl text-indigo-600 mb-4 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Pilih Buku</h3>
                        <p class="text-gray-500 font-medium mt-2">Pilih buku yang ingin Anda pinjam dari daftar koleksi kami di bawah ini.</p>
                    </div>

                    <form action="{{ route('siswa.pinjam') }}" method="POST" id="form-peminjaman" class="space-y-8">
                        @csrf
                        <input type="hidden" name="buku_id" id="buku_id_input" required>
                        
                        <div class="space-y-4">
                            <label class="text-sm font-black text-gray-600 uppercase tracking-widest">Koleksi Buku Tersedia</label>
                            
                            <!-- Grid Container untuk Buku -->
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-h-[600px] overflow-y-auto p-2 border-y border-gray-100 py-6 scrollbar-thin scrollbar-thumb-indigo-200 scrollbar-track-gray-50">
                                @forelse($semuaBuku as $buku)
                                    <div class="buku-card relative bg-white border-2 border-gray-100 rounded-2xl p-4 cursor-pointer hover:border-indigo-400 hover:shadow-xl transition-all transform hover:-translate-y-1 group flex flex-col h-full" data-id="{{ $buku->id }}" onclick="selectBuku(this, {{ $buku->id }})">
                                        <!-- Indikator Checkmark -->
                                        <div class="absolute top-3 right-3 bg-indigo-600 text-white rounded-full p-1 opacity-0 scale-50 transition-all duration-300 check-icon z-10 shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>

                                        <!-- Cover Gambar -->
                                        <div class="w-full h-64 mb-4 rounded-xl overflow-hidden bg-gray-100/50 flex-shrink-0 flex items-center justify-center border border-gray-100 p-2 group-hover:bg-white transition-colors">
                                            @if($buku->cover)
                                                <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}" class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-500 shadow-sm rounded">
                                            @else
                                                <div class="text-center text-gray-400 p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="text-xs font-black uppercase tracking-widest">No Cover</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Informasi Buku -->
                                        <div class="flex-grow flex flex-col justify-between">
                                            <div>
                                                <h4 class="text-sm font-black text-gray-800 leading-tight mb-1 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $buku->judul }}</h4>
                                                <p class="text-xs text-gray-500 mb-2 truncate">{{ $buku->penulis }}</p>
                                            </div>
                                            <div class="mt-auto pt-3 border-t border-gray-50 flex justify-between items-center">
                                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $buku->kategori }}</span>
                                                <span class="text-xs font-bold px-2 py-1 bg-green-50 text-green-700 rounded-lg">Stok: {{ $buku->stok }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-full text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                                        <p class="text-gray-500 font-medium">Belum ada buku yang tersedia untuk dipinjam saat ini.</p>
                                    </div>
                                @endforelse
                            </div>
                            
                            @error('buku_id')
                                <p class="text-red-500 text-sm font-bold mt-2">{{ $message }}</p>
                            @enderror
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

                        <!-- Panel Tombol (Sticky di bawah) -->
                        <div class="sticky bottom-0 pt-4 pb-2 bg-white/90 backdrop-blur-sm border-t border-gray-50">
                            <button type="submit" id="btn-submit" disabled class="w-full bg-gray-300 text-white font-black py-5 rounded-2xl shadow-sm transition-all uppercase tracking-widest text-sm flex items-center justify-center gap-3 cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <span id="btn-text">Pilih Buku Terlebih Dahulu</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk interaksi Card Buku -->
    <script>
        function selectBuku(element, bukuId) {
            // Hapus kelas aktif dari semua card
            document.querySelectorAll('.buku-card').forEach(card => {
                card.classList.remove('border-indigo-500', 'bg-indigo-50/30', 'ring-4', 'ring-indigo-100');
                card.classList.add('border-gray-100');
                
                // Sembunyikan check icon
                const icon = card.querySelector('.check-icon');
                icon.classList.remove('opacity-100', 'scale-100');
                icon.classList.add('opacity-0', 'scale-50');
            });

            // Tambahkan kelas aktif ke card yang dipilih
            element.classList.remove('border-gray-100');
            element.classList.add('border-indigo-500', 'bg-indigo-50/30', 'ring-4', 'ring-indigo-100');
            
            // Tampilkan check icon
            const activeIcon = element.querySelector('.check-icon');
            activeIcon.classList.remove('opacity-0', 'scale-50');
            activeIcon.classList.add('opacity-100', 'scale-100');

            // Set nilai input hidden
            document.getElementById('buku_id_input').value = bukuId;

            // Aktifkan tombol submit
            const btnSubmit = document.getElementById('btn-submit');
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('bg-gray-300', 'cursor-not-allowed', 'shadow-sm');
            btnSubmit.classList.add('bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'hover:from-indigo-700', 'hover:to-purple-700', 'shadow-xl', 'shadow-indigo-100', 'transform', 'hover:-translate-y-1', 'active:scale-95');
            
            document.getElementById('btn-text').innerText = "Konfirmasi Pinjam Buku";
        }
    </script>
</x-app-layout>