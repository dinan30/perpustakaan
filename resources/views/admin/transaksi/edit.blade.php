<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('transaksi.update', $transaksi->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label :value="__('Peminjam')" />
                        <x-text-input class="block mt-1 w-full bg-gray-100" type="text" :value="$transaksi->user->name" disabled />
                    </div>

                    <div class="mb-4">
                        <x-input-label :value="__('Buku')" />
                        <x-text-input class="block mt-1 w-full bg-gray-100" type="text" :value="$transaksi->buku->judul" disabled />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <x-input-label for="tanggal_pinjam" :value="__('Tanggal Pinjam')" />
                            <x-text-input id="tanggal_pinjam" class="block mt-1 w-full" type="date" name="tanggal_pinjam" :value="old('tanggal_pinjam', $transaksi->tanggal_pinjam)" required />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tanggal_kembali" :value="__('Batas Tanggal Kembali')" />
                            <x-text-input id="tanggal_kembali" class="block mt-1 w-full" type="date" name="tanggal_kembali" :value="old('tanggal_kembali', $transaksi->tanggal_kembali)" required />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status Transaksi')" />
                        <select name="status" id="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="pinjam" {{ $transaksi->status == 'pinjam' ? 'selected' : '' }}>Masih Dipinjam</option>
                            <option value="kembali" {{ $transaksi->status == 'kembali' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-4 border-t pt-4">
                        <a href="{{ route('transaksi.index') }}" class="text-sm text-gray-600 underline hover:text-gray-900 mr-4">
                            {{ __('Kembali') }}
                        </a>
                        <x-primary-button class="bg-indigo-600">
                            {{ __('Update Transaksi') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>