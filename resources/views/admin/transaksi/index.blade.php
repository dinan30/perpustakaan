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

                <div class="overflow-x-auto overflow-y-auto max-h-[500px] rounded-xl border border-gray-100 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200 relative">
                        <thead class="bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200 sticky top-0 z-20">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-wider bg-indigo-50/90 backdrop-blur-sm">Peminjam</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-wider bg-indigo-50/90 backdrop-blur-sm">Buku</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-wider bg-indigo-50/90 backdrop-blur-sm">Tgl Pinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-wider bg-indigo-50/90 backdrop-blur-sm">Batas Kembali</th>
                                <th class="px-6 py-4 text-center text-xs font-black text-indigo-800 uppercase tracking-wider bg-indigo-50/90 backdrop-blur-sm">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-wider bg-indigo-50/90 backdrop-blur-sm">Denda</th>
                                <th class="px-6 py-4 text-center text-xs font-black text-indigo-800 uppercase tracking-wider border-l border-gray-200 bg-indigo-100/90 backdrop-blur-sm sticky right-0 z-30">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($transaksi as $item)
                            <tr class="hover:bg-indigo-50/50 transition-colors even:bg-slate-50/50">
                                {{-- Nama Peminjam --}}
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
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
                                @elseif($item->status == 'menunggu_kembali')
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">VERIFIKASI KEMBALI</span>
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
                            <td class="px-6 py-4 text-center text-sm font-medium border-l border-gray-100 bg-white group-hover:bg-indigo-50/50 sticky right-0 z-10">
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

                                    {{-- TOMBOL PENGEMBALIAN (Hanya muncul jika status 'pinjam' atau 'menunggu_kembali') --}}
                                    @if(in_array($item->status, ['pinjam', 'menunggu_kembali']))
                                        <button type="button" onclick="openKembaliModal({{ $item->id }}, '{{ $item->buku->judul }}', '{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('Y-m-d') }}')" class="bg-green-500 hover:bg-green-600 text-white text-[11px] px-3 py-1 rounded shadow-sm transition">
                                            @if($item->status == 'menunggu_kembali') Verifikasi @else Kembalikan @endif
                                        </button>
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
    </div>

    {{-- MODAL PENGEMBALIAN BUKU --}}
    <div id="kembaliModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeKembaliModal()"></div>

            <!-- Modal panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-green-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                            Proses Pengembalian Buku
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-4">
                                Buku: <strong id="modal-buku-judul" class="text-gray-800"></strong><br>
                                Batas Kembali: <strong id="modal-batas-kembali" class="text-gray-800"></strong>
                            </p>
                            
                            <form id="formKembaliBuku" method="POST" action="">
                                @csrf
                                <div class="mb-4">
                                    <label for="tanggal_dikembalikan" class="block text-sm font-medium text-gray-700">Tanggal Dikembalikan (Aktual)</label>
                                    <input type="date" name="tanggal_dikembalikan" id="tanggal_dikembalikan" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white border border-transparent rounded-md shadow-sm bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Simpan Pengembalian
                                    </button>
                                    <button type="button" onclick="closeKembaliModal()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openKembaliModal(id, judul, batasKembali) {
            document.getElementById('kembaliModal').classList.remove('hidden');
            document.getElementById('modal-buku-judul').innerText = judul;
            document.getElementById('modal-batas-kembali').innerText = batasKembali;
            
            // Set action URL form
            let form = document.getElementById('formKembaliBuku');
            form.action = '/admin/transaksi/' + id + '/kembali';
        }

        function closeKembaliModal() {
            document.getElementById('kembaliModal').classList.add('hidden');
        }
    </script>
</x-app-layout>