<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Koleksi Buku Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form method="POST" action="{{ route('buku.store') }}">
                    @csrf

                    <div class="mb-6">
                        <x-input-label for="kode_buku" :value="__('Kode Buku')" />
                        <x-text-input id="kode_buku" class="block mt-1 w-full bg-gray-50 font-bold {{ $errors->has('kode_buku') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" type="text" name="kode_buku" :value="old('kode_buku')" required placeholder="Contoh: BK-001" autofocus />
                        <x-input-error :messages="$errors->get('kode_buku')" class="mt-2 text-red-600 font-bold" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="judul" :value="__('Judul Buku')" />
                        <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul')" required />
                        <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <x-input-label for="penulis" :value="__('Penulis')" />
                            <x-text-input id="penulis" class="block mt-1 w-full" type="text" name="penulis" :value="old('penulis')" required />
                            <x-input-error :messages="$errors->get('penulis')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="penerbit" :value="__('Penerbit')" />
                            <x-text-input id="penerbit" class="block mt-1 w-full" type="text" name="penerbit" :value="old('penerbit')" required />
                            <x-input-error :messages="$errors->get('penerbit')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="kategori" :value="__('Kategori')" />
                        <x-text-input id="kategori" class="block mt-1 w-full" type="text" name="kategori" :value="old('kategori')" required placeholder="Misal: Novel, Edukasi, dll" />
                        <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <x-input-label for="tahun_terbit" :value="__('Tahun Terbit')" />
                            <x-text-input id="tahun_terbit" class="block mt-1 w-full" type="number" name="tahun_terbit" :value="old('tahun_terbit')" required />
                            <x-input-error :messages="$errors->get('tahun_terbit')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="stok" :value="__('Jumlah Stok')" />
                            <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok" :value="old('stok')" required />
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4 border-t pt-6">
                        <a href="{{ route('buku.index') }}" class="text-sm text-gray-600 underline hover:text-gray-900 mr-4">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                            {{ __('Simpan Koleksi') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>