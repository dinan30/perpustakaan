<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Koleksi Buku') }}
            </h2>
            <a href="{{ route('buku.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                + Tambah Buku
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-widest">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-widest">Judul</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-widest">Penulis</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-widest">Penerbit</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-widest">Tahun Terbit</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-widest">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-widest">Stok</th>
                                <th class="px-6 py-4 text-center text-xs font-black text-indigo-800 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($buku as $item)
                                <tr class="hover:bg-indigo-50/50 transition-colors even:bg-slate-50/50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">{{ $item->kode_buku }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $item->judul }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->penulis }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->penerbit }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->tahun_terbit }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 italic">{{ $item->kategori }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 py-1 {{ $item->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-lg text-xs font-bold">
                                            {{ $item->stok }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('buku.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Edit</a>
                                            <form action="{{ route('buku.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus buku ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center text-gray-500 font-medium italic">Belum ada koleksi buku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>