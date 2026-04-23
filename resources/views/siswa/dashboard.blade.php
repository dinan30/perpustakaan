<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 leading-tight">
            {{ __('👋 Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="bg-emerald-50 text-emerald-600 p-5 rounded-2xl border border-emerald-100 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 text-red-600 p-5 rounded-2xl border border-red-100 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Alert Denda --}}
            @if(isset($totalDenda) && $totalDenda > 0)
                <div class="bg-gradient-to-r from-red-500 to-rose-600 text-white p-6 rounded-2xl shadow-lg flex flex-col md:flex-row items-center justify-between gap-4 animate-bounce-subtle">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-white/20 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-black tracking-wide">Pemberitahuan Denda</h4>
                            <p class="text-sm font-medium text-red-100 mt-1">Anda memiliki <strong class="text-white">{{ $transaksiBerdenda }}</strong> riwayat pengembalian buku yang terlambat.</p>
                        </div>
                    </div>
                    <div class="text-center md:text-right bg-white/10 px-6 py-3 rounded-xl border border-white/20">
                        <p class="text-xs uppercase tracking-widest font-bold text-red-100 mb-1">Total Tagihan</p>
                        <p class="text-3xl font-black">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Total Pinjaman</p>
                        <h4 class="text-4xl font-black text-gray-800 mt-1">{{ $pinjamanSaya->count() }} <span class="text-lg font-medium text-gray-400">Buku</span></h4>
                    </div>
                    <div class="p-4 bg-indigo-50 rounded-2xl text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h3 class="font-black text-gray-800 uppercase text-sm tracking-widest">Riwayat Terakhir</h3>
                    <a href="{{ route('siswa.riwayat') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest transition-colors">Lihat Semua &rarr;</a>
                </div>
                
                <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200">
                            <tr>
                                <th class="px-8 py-4 text-xs font-black text-indigo-800 uppercase tracking-widest border-b border-gray-100">Buku</th>
                                <th class="px-8 py-4 text-xs font-black text-indigo-800 uppercase tracking-widest border-b border-gray-100">Tgl Pinjam</th>
                                <th class="px-8 py-4 text-xs font-black text-indigo-800 uppercase tracking-widest border-b border-gray-100">Status</th>
                                <th class="px-8 py-4 text-xs font-black text-indigo-800 uppercase tracking-widest border-b border-gray-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pinjamanSaya->take(5) as $item)
                            <tr class="hover:bg-indigo-50/50 transition-colors even:bg-slate-50/50 group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4 min-w-[200px]">
                                        <div class="px-3 py-2 shrink-0 bg-indigo-50 rounded-xl flex flex-col items-center justify-center text-indigo-600 shadow-sm border border-indigo-100 min-w-[60px]">
                                            <span class="text-[8px] font-black leading-none uppercase tracking-widest mb-1 opacity-80">Kode</span>
                                            <span class="text-xs font-black leading-none">{{ $item->buku->kode_buku ?? '-' }}</span>
                                        </div>
                                        <div class="truncate">
                                            <p class="text-sm font-bold text-gray-800 leading-tight truncate">{{ $item->buku->judul ?? 'Buku Dihapus' }}</p>
                                            <p class="text-[10px] text-gray-400 font-medium mt-1 uppercase tracking-widest truncate">
                                                {{ $item->buku->kategori ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-600 font-medium whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    @if($item->status === 'menunggu')
                                        <span class="px-4 py-2 bg-yellow-50 text-yellow-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-yellow-100">Menunggu</span>
                                    @elseif($item->status === 'pinjam')
                                        <span class="px-4 py-2 bg-orange-50 text-orange-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-orange-100">Dipinjam</span>
                                    @elseif($item->status === 'menunggu_kembali')
                                        <span class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-blue-100">Proses Kembali</span>
                                    @elseif($item->status === 'ditolak')
                                        <span class="px-4 py-2 bg-red-50 text-red-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-red-100">Ditolak</span>
                                    @else
                                        <span class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100">Dikembalikan</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-center whitespace-nowrap">
                                    @if($item->status === 'pinjam')
                                        <form action="{{ route('siswa.kembali', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan buku ini sekarang?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black px-4 py-2 rounded-xl shadow-sm transition-all uppercase tracking-widest">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @elseif($item->status === 'menunggu_kembali')
                                        <span class="text-blue-500 text-[10px] font-black uppercase tracking-widest bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100">Menunggu Verifikasi</span>
                                    @else
                                        <span class="text-gray-300 text-xs font-medium">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-sm font-bold uppercase tracking-widest">Belum Ada Riwayat</p>
                                        <p class="text-xs mt-1">Pinjam buku pertamamu sekarang!</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>