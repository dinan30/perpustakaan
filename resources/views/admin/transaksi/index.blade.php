<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Transaksi Perpustakaan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg overflow-x-auto">
                
                {{-- Alert Pesan Sukses --}}
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded border-l-4 border-green-500 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="min-w-full border divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batas Kembali</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            
                            {{-- KOLOM DENDA DITAMBAHKAN --}}
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Denda</th>
                            
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($transaksi as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $item->user->name }}</td>
                            <td class="px-4 py-4 text-sm text-gray-600">{{ $item->buku->judul }}</td>
                            <td class="px-4 py-4 text-sm text-gray-600">{{ $item->tanggal_pinjam }}</td>
                            <td class="px-4 py-4 text-sm text-gray-600">{{ $item->tanggal_kembali }}</td>
                            <td class="px-4 py-4 text-center">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $item->status == 'pinjam' ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }}">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </td>

                            {{-- MENAMPILKAN DENDA DENGAN FORMAT RUPIAH --}}
                            <td class="px-4 py-4 text-sm font-bold {{ $item->denda > 0 ? 'text-red-600' : 'text-gray-500' }}">
                                Rp {{ number_format($item->denda, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-4 text-center text-sm font-medium">
                                <div class="flex justify-center gap-3">
                            

                                    <a href="{{ route('transaksi.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>

                                    <form action="{{ route('transaksi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini? Stok akan dikembalikan jika status masih PINJAM.')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($transaksi->isEmpty())
                    <div class="text-center py-8 text-gray-500 italic">
                        Belum ada riwayat transaksi.
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>