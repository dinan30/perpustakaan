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

                {{-- Form Quick Search --}}
                <div class="mb-6 flex justify-between items-center bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <h3 class="text-sm font-black text-gray-500 uppercase tracking-widest">Pencarian Buku</h3>
                    <form action="{{ route('buku.index') }}" method="GET" class="flex w-full max-w-md">
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-l-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Cari judul, penulis, kode, atau kategori...">
                        </div>
                        <button type="submit" class="relative -ml-px inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-r-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('buku.index') }}" class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto overflow-y-auto max-h-[500px] rounded-xl border border-gray-100 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200 relative">
                        <thead class="bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200 sticky top-0 z-20">
                            <tr>
                                <th class="px-4 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-widest bg-indigo-50/90 backdrop-blur-sm">Kode</th>
                                <th class="px-4 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-widest bg-indigo-50/90 backdrop-blur-sm">Judul</th>
                                <th class="px-4 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-widest bg-indigo-50/90 backdrop-blur-sm">Penulis</th>
                                <th class="px-4 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-widest bg-indigo-50/90 backdrop-blur-sm">Penerbit</th>
                                <th class="px-4 py-4 text-center text-xs font-black text-indigo-800 uppercase tracking-widest bg-indigo-50/90 backdrop-blur-sm">Tahun Terbit</th>
                                <th class="px-4 py-4 text-left text-xs font-black text-indigo-800 uppercase tracking-widest bg-indigo-50/90 backdrop-blur-sm">Kategori</th>
                                <th class="px-4 py-4 text-center text-xs font-black text-indigo-800 uppercase tracking-widest bg-indigo-50/90 backdrop-blur-sm">Stok</th>
                                <th class="px-4 py-4 text-center text-xs font-black text-indigo-800 uppercase tracking-widest border-l border-gray-200 bg-indigo-100/90 backdrop-blur-sm sticky right-0 z-30">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($buku as $item)
                                <tr class="hover:bg-indigo-50/50 transition-colors even:bg-slate-50/50 group">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">{{ $item->kode_buku }}</td>
                                    <td class="px-4 py-4 whitespace-normal min-w-[150px] max-w-[200px] text-sm text-gray-900 font-medium leading-tight">{{ $item->judul }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->penulis }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->penerbit }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $item->tahun_terbit }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 italic">{{ $item->kategori }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-center">
                                        <span class="px-2 py-1 {{ $item->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-lg text-xs font-bold">
                                            {{ $item->stok }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium border-l border-gray-100 bg-white group-hover:bg-indigo-50/50 sticky right-0 z-10">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('buku.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold transition-colors">Edit</a>
                                            <form action="{{ route('buku.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus buku ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-bold transition-colors">Hapus</button>
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