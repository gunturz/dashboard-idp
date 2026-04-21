<x-guest-layout>
    @if (session('status'))
        <div class="flex flex-col items-center text-center p-4">
            <div class="mb-6 flex justify-center">
                <div style="background-color: #2ecc71;" class="w-20 h-20 rounded-full flex items-center justify-center text-white shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
            </div>

            <h1 class="text-2xl font-extrabold text-gray-900 mb-4">
                Password berhasil<br>diperbarui
            </h1>
            
            <p class="text-gray-500 text-sm leading-relaxed mb-8">
                Password Anda telah berhasil direset.<br>Silahkan login kembali dengan<br>password baru.
            </p>

            <a href="{{ route('login') }}" class="w-full py-3 bg-[#1ed700] hover:bg-[#1abf00] text-white font-bold rounded-lg text-center transition-colors shadow-sm no-underline inline-block">
                Kembali ke Login
            </a>
        </div>

    @else
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-white">Reset Password</h1>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

            {{-- Password Baru --}}
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password Baru')" class="mb-1 text-white" />
                <div class="relative">
                    {{-- Ikon gembok kiri --}}
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" type="password" name="password"
                        class="block w-full pl-10 pr-11 py-3 border-2 border-cyan-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 focus:ring-opacity-60 rounded-xl shadow-sm bg-white text-gray-900 font-medium placeholder-gray-400 tracking-wide transition-all"
                        placeholder="Masukkan password baru" required autocomplete="new-password" />
                    {{-- Tombol mata kanan --}}
                    <button type="button" id="toggle-password"
                        onclick="toggleVisibility('password', 'eye-icon-password')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-cyan-600 transition-colors focus:outline-none"
                        tabindex="-1" aria-label="Toggle password visibility">
                        <svg id="eye-icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="mb-1 text-white" />
                <div class="relative">
                    {{-- Ikon gembok kiri --}}
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="block w-full pl-10 pr-11 py-3 border-2 border-cyan-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 focus:ring-opacity-60 rounded-xl shadow-sm bg-white text-gray-900 font-medium placeholder-gray-400 tracking-wide transition-all"
                        placeholder="Ulangi password baru" required autocomplete="new-password" />
                    {{-- Tombol mata kanan --}}
                    <button type="button" id="toggle-password-confirm"
                        onclick="toggleVisibility('password_confirmation', 'eye-icon-confirm')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-cyan-600 transition-colors focus:outline-none"
                        tabindex="-1" aria-label="Toggle confirm password visibility">
                        <svg id="eye-icon-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-4">
                <button type="submit" class="w-full py-3 bg-[#1ed700] hover:bg-[#1abf00] text-white font-bold rounded-xl transition-all shadow-md active:scale-95">
                    {{ __('Simpan Password') }}
                </button>
            </div>
        </form>

        {{-- Script toggle show/hide password --}}
        <script>
            function toggleVisibility(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon  = document.getElementById(iconId);
                const isHidden = input.type === 'password';

                input.type = isHidden ? 'text' : 'password';

                // Ganti ikon: mata terbuka ↔ mata dicoret
                icon.innerHTML = isHidden
                    ? `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M6.634 6.634A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.978 9.978 0 01-4.176 5.191M15 12a3 3 0 11-4.243-4.243M3 3l18 18" />`
                    : `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        </script>
    @endif
</x-guest-layout>