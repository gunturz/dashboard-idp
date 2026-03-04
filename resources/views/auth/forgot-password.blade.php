<x-guest-layout>
    {{-- Bagian State Sukses (Muncul setelah klik kirim link) --}}
    @if (session('status'))
        <div class="flex flex-col items-center text-center p-4">
            <div class="mb-8 flex justify-center">
                <div style="background-color: #2ecc71;" class="w-20 h-20 rounded-full flex items-center justify-center text-white shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
            </div>

            <h1 class="text-2xl font-extrabold text-gray-900 mb-4">
                Link reset password<br>telah dikirim
            </h1>
            
            <p class="text-gray-500 text-sm leading-relaxed mb-10">
                Silahkan cek email Anda dan ikuti<br>instruksi yang diberikan.
            </p>

            <a href="{{ route('login') }}" class="w-full py-3 px-4 bg-[#1ed700] hover:bg-[#1abf00] text-white font-bold rounded-lg text-center transition-colors duration-200">
                Kembali ke Login
            </a>
        </div>

    @else
        {{-- Bagian Form Input (Tampilan Awal) --}}
        <div class="fp-header">
            <div class="fp-icon-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 0 1 21.75 8.25Z" />
                </svg>
            </div>
            <h1 class="fp-title">Lupa Password</h1>
            <p class="fp-subtitle">Masukkan username atau email Anda untuk<br>menerima link reset password</p>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-6">
                {{-- Menggunakan komponen input-label yang ada di folder components --}}
                <x-input-label for="login" :value="__('Username / Email')" class="form-label" />
                
                <div class="input-wrapper">
                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <input id="login" type="text" name="login" value="{{ old('login') }}" class="form-input" placeholder="Masukan username atau email" required autofocus />
                </div>
                
                {{-- Menggunakan komponen input-error yang ada di folder components --}}
                <x-input-error :messages="$errors->get('login')" class="mt-2" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <button type="submit" class="btn-login flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                </svg>
                {{ __('Kirim Link Reset') }}
            </button>

            <p class="register-link-text mt-4">
                <a href="{{ route('login') }}" class="hover:underline text-sm">{{ __('Kembali ke Login') }}</a>
            </p>
        </form>
    @endif
</x-guest-layout>