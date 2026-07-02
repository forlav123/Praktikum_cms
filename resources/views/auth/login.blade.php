<x-guest-layout>
    <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-semibold text-gray-900">Masuk ke Toko Barang</h2>
            <p class="mt-2 text-sm text-gray-600">Silakan gunakan email dan password Anda untuk melanjutkan.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="contoh@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="Masukkan password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4 flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:text-indigo-800" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <div class="mt-6">
                <x-primary-button class="w-full justify-center">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>

            <div class="mt-4 text-center text-sm text-gray-600">
                @if (Route::has('register'))
                    Belum punya akun?
                    <a class="font-medium text-indigo-600 hover:text-indigo-800" href="{{ route('register') }}">
                        Daftar sekarang
                    </a>
                @endif
            </div>
        </form>
    </div>
</x-guest-layout>
