<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Peminjaman Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Notifikasi Error (Jika stok habis atau validasi gagal) --}}
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg border-l-4 border-red-500 font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <form method="POST" action="{{ route('transaksi.store') }}">
                        @csrf

                        {{-- Input Siswa --}}
                        <div class="mb-6">
                            <x-input-label for="user_id" :value="__('Pilih Siswa (Peminjam)')" />
                            <select name="user_id" id="user_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>-- Cari Nama Siswa --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                        </div>

                        {{-- Input Buku --}}
                        <div class="mb-6">
                            <x-input-label for="buku_id" :value="__('Pilih Buku')" />
                            <select name="buku_id" id="buku_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>-- Pilih Judul Buku --</option>
                                @foreach($buku as $item)
                                    <option value="{{ $item->id }}" {{ old('buku_id') == $item->id ? 'selected' : '' }}>
                                        [{{ $item->kode_buku ?? 'N/A' }}] - {{ $item->judul }} (Tersedia: {{ $item->stok }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('buku_id')" class="mt-2" />
                        </div>

                        {{-- Input Tanggal --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label for="tgl_pinjam" :value="__('Tanggal Pinjam')" />
                                <x-text-input id="tgl_pinjam" class="block mt-1 w-full bg-gray-50 border-gray-300" type="date" name="tgl_pinjam" :value="old('tgl_pinjam', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('tgl_pinjam')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tgl_kembali" :value="__('Batas Pengembalian')" />
                                <x-text-input id="tgl_kembali" class="block mt-1 w-full bg-gray-50 border-gray-300" type="date" name="tgl_kembali" :value="old('tgl_kembali', date('Y-m-d', strtotime('+7 days')))" required />
                                <x-input-error :messages="$errors->get('tgl_kembali')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end mt-8 border-t pt-6 gap-4">
                            <a href="{{ route('transaksi.index') }}" class="text-sm text-gray-600 hover:text-indigo-600 transition font-medium">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 shadow-lg shadow-indigo-200 py-3">
                                {{ __('Simpan Transaksi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- Tips Buat User --}}
            <div class="mt-4 text-center">
                <p class="text-xs text-gray-400 italic">
                    * Pastikan stok buku tersedia sebelum memproses peminjaman.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>