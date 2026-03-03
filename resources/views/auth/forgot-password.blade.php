<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="session-status">
            {{ session('status') }}
        </div>
    @endif

    <!-- Header -->
    <div class="fp-header">
        <!-- Key Icon -->
        <div class="fp-icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 0 1 21.75 8.25Z" />
            </svg>
        </div>
        <h1 class="fp-title">Lupa Password</h1>
        <p class="fp-subtitle">Masukkan username dan email Anda<br>untuk menerima link reset password</p>
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Username Field -->
        <div style="margin-bottom: 1rem;">
            <label for="username" class="form-label">Username</label>
            <div class="input-wrapper">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <input id="username" type="text" name="username" value="{{ old('username') }}" class="form-input"
                    placeholder="Masukan username" required autofocus />
            </div>
            @error('username')
                <p class="error-message">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" style="width:13px;height:13px;flex-shrink:0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Email Field -->
        <div style="margin-bottom: 1.6rem;">
            <label for="email" class="form-label">Email</label>
            <div class="input-wrapper">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input"
                    placeholder="Masukan email" required />
            </div>
            @error('email')
                <p class="error-message">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" style="width:13px;height:13px;flex-shrink:0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" id="fp-submit-btn" class="btn-login">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" style="width:18px;height:18px;">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
            </svg>
            Kirim Link Reset
        </button>

        <!-- Back to Login -->
        <p class="register-link-text">
            <a href="{{ route('login') }}">Kembali ke Login</a>
        </p>
    </form>
</x-guest-layout>
