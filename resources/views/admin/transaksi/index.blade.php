<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Transaksi Perpustakaan') }}
            </h2>
            
            {{-- TOMBOL TAMBAH TRANSAKSI --}}
            <a href="{{ route('transaksi.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Tambah Transaksi') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg overflow-x-auto border border-gray-100">
                
                {{-- Alert Pesan Sukses --}}
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded border-l-4 border-green-500 font-medium animate-pulse">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Alert Pesan Error --}}
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded border-l-4 border-red-500 font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <table class="min-w-full border divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Buku</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Batas Kembali</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Denda</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($transaksi as $item)
                        <tr class="hover:bg-gray-50 transition">
                            {{-- Nama Peminjam --}}
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                {{ $item->user->name ?? 'User Terhapus' }}
                            </td>

                            {{-- Info Buku --}}
                            <td class="px-4 py-4 text-sm text-gray-600">
                                <span class="block font-bold text-indigo-600 text-[10px] uppercase">
                                    {{ $item->buku->kode_buku ?? 'KODE-??' }}
                                </span>
                                {{ $item->buku->judul ?? 'Buku tidak ditemukan' }}
                            </td>

                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                            </td>
                            
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-4 py-4 text-center">
                                @if($item->status == 'menunggu')
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700">MENUNGGU</span>
                                @elseif($item->status == 'pinjam')
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold bg-orange-100 text-orange-700">PINJAM</span>
                                @elseif($item->status == 'ditolak')
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700">DITOLAK</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-700">KEMBALI</span>
                                @endif
                            </td>

                            {{-- Denda --}}
                            <td class="px-4 py-4 text-sm font-bold {{ $item->denda > 0 ? 'text-red-600' : 'text-gray-500' }}">
                                Rp {{ number_format($item->denda, 0, ',', '.') }}
                            </td>

                            {{-- Grup Tombol Aksi --}}
                            <td class="px-4 py-4 text-center text-sm font-medium">
                                <div class="flex justify-center items-center gap-2">
                                    
                                    {{-- TOMBOL PERSETUJUAN (Hanya muncul jika status 'menunggu') --}}
                                    @if($item->status == 'menunggu')
                                        <form action="{{ route('transaksi.setujui', $item->id) }}" method="POST" onsubmit="return confirm('Setujui peminjaman ini?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-[11px] px-3 py-1 rounded shadow-sm transition">
                                                Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('transaksi.tolak', $item->id) }}" method="POST" onsubmit="return confirm('Tolak peminjaman ini?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-[11px] px-3 py-1 rounded shadow-sm transition">
                                                Tolak
                                            </button>
                                        </form>
                                    @endif

                                    {{-- TOMBOL PENGEMBALIAN (Hanya muncul jika status 'pinjam') --}}
                                    @if($item->status == 'pinjam')
                                        <form action="{{ route('transaksi.kembali', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengembalikan buku ini?')">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-[11px] px-3 py-1 rounded shadow-sm transition">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('transaksi.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">
                                        Edit
                                    </a>

                                    <form action="{{ route('transaksi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini? Stok akan dikembalikan jika status masih PINJAM.')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-gray-500 italic">
                                Belum ada riwayat transaksi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>