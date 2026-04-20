<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Buku: ') }} {{ $buku->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form method="POST" action="{{ route('buku.update', $buku->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <x-input-label for="kode_buku" :value="__('Kode Buku')" />
                        <x-text-input id="kode_buku" class="block mt-1 w-full bg-gray-50 font-bold text-indigo-700" type="text" name="kode_buku" :value="old('kode_buku', $buku->kode_buku)" required />
                        <x-input-error :messages="$errors->get('kode_buku')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="judul" :value="__('Judul Buku')" />
                        <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul', $buku->judul)" required />
                        <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <x-input-label for="penulis" :value="__('Penulis')" />
                            <x-text-input id="penulis" class="block mt-1 w-full" type="text" name="penulis" :value="old('penulis', $buku->penulis)" required />
                            <x-input-error :messages="$errors->get('penulis')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="penerbit" :value="__('Penerbit')" />
                            <x-text-input id="penerbit" class="block mt-1 w-full" type="text" name="penerbit" :value="old('penerbit', $buku->penerbit)" required />
                            <x-input-error :messages="$errors->get('penerbit')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="kategori" :value="__('Kategori')" />
                        <x-text-input id="kategori" class="block mt-1 w-full" type="text" name="kategori" :value="old('kategori', $buku->kategori)" required />
                        <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <x-input-label for="tahun_terbit" :value="__('Tahun Terbit')" />
                            <x-text-input id="tahun_terbit" class="block mt-1 w-full" type="number" name="tahun_terbit" :value="old('tahun_terbit', $buku->tahun_terbit)" required />
                            <x-input-error :messages="$errors->get('tahun_terbit')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="stok" :value="__('Jumlah Stok')" />
                            <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok" :value="old('stok', $buku->stok)" required />
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="cover" :value="__('Cover Buku (Biarkan kosong jika tidak ingin mengubah)')" />
                        @if($buku->cover)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover Buku" class="w-32 h-48 object-cover rounded-md shadow-sm border border-gray-200">
                            </div>
                        @endif
                        <input id="cover" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition" type="file" name="cover" accept="image/png, image/jpeg, image/jpg, image/gif">
                        <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPG, JPEG, PNG, GIF. Ukuran maks: 2MB.</p>
                        <x-input-error :messages="$errors->get('cover')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4 border-t pt-6">
                        <a href="{{ route('buku.index') }}" class="text-sm text-gray-600 underline hover:text-gray-900 mr-4">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                            {{ __('Update Koleksi') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>