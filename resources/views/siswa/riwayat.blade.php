<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 leading-tight">
            {{ __('📜 Riwayat Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="bg-emerald-50 text-emerald-600 p-5 rounded-2xl border border-emerald-100 flex items-center gap-3 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 text-red-600 p-5 rounded-2xl border border-red-100 flex items-center gap-3 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100 p-8">
                <h3 class="font-black text-gray-800 mb-6 uppercase text-sm tracking-widest border-b pb-4">Semua Riwayat</h3>
                
                <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200">
                            <tr>
                                <th class="px-8 py-4 text-xs font-black text-indigo-800 uppercase tracking-widest border-b border-gray-100">Buku</th>
                                <th class="px-8 py-4 text-xs font-black text-indigo-800 uppercase tracking-widest border-b border-gray-100">Tgl Pinjam</th>
                                <th class="px-8 py-4 text-xs font-black text-indigo-800 uppercase tracking-widest border-b border-gray-100">Batas Kembali</th>
                                <th class="px-8 py-4 text-xs font-black text-indigo-800 uppercase tracking-widest border-b border-gray-100 text-center">Status</th>
                                <th class="px-8 py-4 text-xs font-black text-indigo-800 uppercase tracking-widest border-b border-gray-100 text-center">Denda</th>
                                <th class="px-8 py-4 text-xs font-black text-indigo-800 uppercase tracking-widest border-b border-gray-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pinjamanSaya as $item)
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
                                <td class="px-8 py-6 text-sm text-gray-600 font-medium whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                </td>
                                <td class="px-8 py-6 text-center whitespace-nowrap">
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
                                <td class="px-8 py-6 text-center text-sm font-bold whitespace-nowrap {{ $item->denda > 0 ? 'text-red-600' : 'text-gray-400' }}">
                                    Rp {{ number_format($item->denda, 0, ',', '.') }}
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
                                <td colspan="6" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-sm font-bold uppercase tracking-widest">Belum Ada Riwayat</p>
                                        <p class="text-xs mt-1">Anda belum meminjam buku apapun.</p>
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