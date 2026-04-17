<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-bold text-gray-700" />
            <x-text-input id="name" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl py-3 px-4 transition-all" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-5">
            <x-input-label for="email" :value="__('Alamat Email')" class="font-bold text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl py-3 px-4 transition-all" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Masukkan alamat email Anda" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <x-input-label for="password" :value="__('Kata Sandi')" class="font-bold text-gray-700" />

            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl py-3 px-4 transition-all"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Buat kata sandi (min. 8 karakter)" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-5">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="font-bold text-gray-700" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl py-3 px-4 transition-all"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang kata sandi" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
            <div class="text-sm text-gray-500 font-medium">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition-colors">Masuk di sini</a>
            </div>

            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 transition-all font-black tracking-widest">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
