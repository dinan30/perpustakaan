<x-app-layout>
    <div class="py-12 bg-[#f8fafc] min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-black text-gray-800 tracking-tighter">Histori Peminjaman</h2>
                    <p class="text-gray-500 text-sm font-medium">Pantau status buku dan batas waktu pengembalian Anda.</p>
                </div>
                <a href="{{ route('siswa.peminjaman') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-indigo-100">
                    + Pinjam Buku Baru
                </a>
            </div>

            <div class="bg-white shadow-[0_20px_50px_rgba(8,_112,_184,_0.05)] rounded-[2.5rem] border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Buku</th>
                                <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Tanggal Pinjam</th>
                                <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Tenggat</th>
                                <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                                <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($pinjamanSaya as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-14 bg-indigo-100 rounded-lg flex-shrink-0 flex items-center justify-center text-indigo-600 font-bold shadow-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800 leading-tight">{{ $item->buku->judul }}</p>
                                            <p class="text-[10px] text-gray-400 font-medium uppercase tracking-tighter mt-1">ID Transaksi: #{{ $item->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-sm font-semibold text-gray-600">
                                    {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-6 text-sm font-semibold text-gray-600">
                                    {{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-6">
                                    @if($item->status === 'pinjam')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-amber-100 text-amber-600 border border-amber-200">
                                            Dipinjam
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-600 border border-emerald-200">
                                            Dikembalikan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-6">
                                    @if($item->status === 'pinjam')
                                        <form action="{{ route('siswa.kembali', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-xs font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-widest underline decoration-2 underline-offset-4">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs font-bold text-gray-300 uppercase tracking-widest italic">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center opacity-30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-lg font-black uppercase tracking-[0.2em]">Belum ada riwayat</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em]">Menampilkan semua riwayat peminjaman mandiri</p>
            </div>
        </div>
    </div>
</x-app-layout>