<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="register-form">
        @csrf

        {{-- Title khusus halaman register --}}
        <h2 class="login-title" style="margin-bottom: 1.5rem;">Registrasi</h2>

        {{-- ── USERNAME ─────────────────────────── --}}
        <div style="margin-bottom: 1rem;">
            <label for="username" class="form-label">Username</label>
            <div class="input-wrapper">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <input id="username" type="text" name="username" value="{{ old('username') }}" class="form-input"
                    placeholder="Masukan username" required autofocus autocomplete="username" />
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

        {{-- ── PASSWORD ─────────────────────────── --}}
        <div style="margin-bottom: 1rem;">
            <label for="password" class="form-label">Password</label>
            <div class="input-wrapper">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                <input id="password" type="password" name="password" class="form-input" placeholder="Masukan password"
                    required autocomplete="new-password" style="padding-right: 2.8rem;" />
                <button type="button" class="password-toggle" onclick="togglePassword('password', this)"
                    aria-label="Toggle password">
                    <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg class="eye-closed hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            @error('password')
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

        {{-- ── KONFIRMASI PASSWORD ───────────────── --}}
        <div style="margin-bottom: 1rem;">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-wrapper">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-input"
                    placeholder="Konfirmasi password" required autocomplete="new-password"
                    style="padding-right: 2.8rem;" />
                <button type="button" class="password-toggle"
                    onclick="togglePassword('password_confirmation', this)" aria-label="Toggle konfirmasi password">
                    <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg class="eye-closed hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── NAMA LENGKAP ─────────────────────── --}}
        <div style="margin-bottom: 1rem;">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <div class="input-wrapper">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <input id="nama" type="text" name="nama" value="{{ old('nama') }}" class="form-input"
                    placeholder="Masukan nama lengkap" required />
            </div>
            @error('nama')
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

        {{-- ── PERUSAHAAN ───────────────────────── --}}
        <div style="margin-bottom: 1rem;">
            <label for="perusahaan" class="form-label">Perusahaan</label>
            <div class="input-wrapper">
                <select id="perusahaan" name="perusahaan" class="form-select" required>
                    <option value="" disabled {{ old('perusahaan') ? '' : 'selected' }}>Pilih nama perusahaan
                    </option>
                    <option value="PT Maju Bersama" {{ old('perusahaan') == 'PT Maju Bersama' ? 'selected' : '' }}>
                        PT Maju Bersama</option>
                    <option value="PT Sukses Mandiri" {{ old('perusahaan') == 'PT Sukses Mandiri' ? 'selected' : '' }}>
                        PT Sukses Mandiri</option>
                    <option value="PT Nusantara Jaya" {{ old('perusahaan') == 'PT Nusantara Jaya' ? 'selected' : '' }}>
                        PT Nusantara Jaya</option>
                    <option value="PT Karya Utama" {{ old('perusahaan') == 'PT Karya Utama' ? 'selected' : '' }}>
                        PT Karya Utama</option>
                </select>
            </div>
            @error('perusahaan')
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

        {{-- ── DEPARTEMEN ───────────────────────── --}}
        <div style="margin-bottom: 1rem;">
            <label for="departemen" class="form-label">Departemen</label>
            <div class="input-wrapper">
                <select id="departemen" name="departemen" class="form-select" required>
                    <option value="" disabled {{ old('departemen') ? '' : 'selected' }}>Pilih nama departemen
                    </option>
                    <option value="Human Resources" {{ old('departemen') == 'Human Resources' ? 'selected' : '' }}>
                        Human Resources</option>
                    <option value="Finance" {{ old('departemen') == 'Finance' ? 'selected' : '' }}>
                        Finance</option>
                    <option value="Operations" {{ old('departemen') == 'Operations' ? 'selected' : '' }}>
                        Operations</option>
                    <option value="Marketing" {{ old('departemen') == 'Marketing' ? 'selected' : '' }}>
                        Marketing</option>
                    <option
                        value="Information Technology"{{ old('departemen') == 'Information Technology' ? 'selected' : '' }}>
                        Information Technology</option>
                    <option value="Legal" {{ old('departemen') == 'Legal' ? 'selected' : '' }}>Legal
                    </option>
                    <option value="Business Development"
                        {{ old('departemen') == 'Business Development' ? 'selected' : '' }}>Business Development
                    </option>
                </select>
            </div>
            @error('departemen')
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

        {{-- ── ROLE ─────────────────────────────── --}}
        <div style="margin-bottom: 1rem;">
            <label for="role" class="form-label">Role</label>
            <div class="input-wrapper">
                <select id="role" name="role" class="form-select" required
                    onchange="handleRoleChange(this.value)">
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role</option>
                    <option value="kandidat" {{ old('role') == 'kandidat' ? 'selected' : '' }}>Kandidat</option>
                    <option value="atasan" {{ old('role') == 'atasan' ? 'selected' : '' }}>Atasan</option>
                    <option value="mentor" {{ old('role') == 'mentor' ? 'selected' : '' }}>Mentor</option>
                    <option value="finance" {{ old('role') == 'finance' ? 'selected' : '' }}>Finance</option>
                    <option value="admin_pdc" {{ old('role') == 'admin_pdc' ? 'selected' : '' }}>Admin PDC</option>
                    <option value="bo_director" {{ old('role') == 'bo_director' ? 'selected' : '' }}>BO Director
                    </option>
                </select>
            </div>
            @error('role')
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

        {{-- ── ROLE TARGET (hanya tampil untuk Kandidat) ─── --}}
        <div id="field-jabatan-target"
            style="margin-bottom: 1rem; display: {{ old('role') == 'kandidat' ? 'block' : 'none' }}">
            <label for="jabatan_target" class="form-label">Role Target</label>
            <div class="input-wrapper">
                <select id="jabatan_target" name="jabatan_target" class="form-select">
                    <option value="" disabled {{ old('jabatan_target') ? '' : 'selected' }}>Pilih role target
                    </option>
                    <option value="Manager" {{ old('jabatan_target') == 'Manager' ? 'selected' : '' }}>
                        Manager</option>
                    <option value="Senior Manager" {{ old('jabatan_target') == 'Senior Manager' ? 'selected' : '' }}>
                        Senior Manager</option>
                    <option value="General Manager"
                        {{ old('jabatan_target') == 'General Manager' ? 'selected' : '' }}>General Manager</option>
                    <option value="Director" {{ old('jabatan_target') == 'Director' ? 'selected' : '' }}>
                        Director</option>
                    <option value="VP" {{ old('jabatan_target') == 'VP' ? 'selected' : '' }}>Vice
                        President</option>
                    <option value="C-Level" {{ old('jabatan_target') == 'C-Level' ? 'selected' : '' }}>
                        C-Level</option>
                </select>
            </div>
        </div>

        {{-- ── MENTOR (hanya tampil untuk Kandidat) ─────── --}}
        <div id="field-mentor"
            style="margin-bottom: 1rem; display: {{ old('role') == 'kandidat' ? 'block' : 'none' }}">
            <label for="mentor_id" class="form-label">Mentor</label>
            <div class="input-wrapper">
                <select id="mentor_id" name="mentor_id" class="form-select">
                    <option value="">Pilih mentor</option>
                    @foreach ($mentors as $mentor)
                        <option value="{{ $mentor->id }}" {{ old('mentor_id') == $mentor->id ? 'selected' : '' }}>
                            {{ $mentor->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- ── ATASAN (hanya tampil untuk Kandidat) ─────── --}}
        <div id="field-atasan"
            style="margin-bottom: 1rem; display: {{ old('role') == 'kandidat' ? 'block' : 'none' }}">
            <label for="atasan_id" class="form-label">Atasan</label>
            <div class="input-wrapper">
                <select id="atasan_id" name="atasan_id" class="form-select">
                    <option value="">Pilih atasan</option>
                    @foreach ($atasans as $atasan)
                        <option value="{{ $atasan->id }}" {{ old('atasan_id') == $atasan->id ? 'selected' : '' }}>
                            {{ $atasan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- ── TOMBOL DAFTAR / NEXT ──────────────────────── --}}
        <button type="submit" id="register-btn" class="btn-login">
            <svg id="btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="2.5" stroke="currentColor" style="width:18px;height:18px;">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg>
            <span id="btn-label">Daftar</span>
        </button>

        {{-- ── LINK LOGIN ───────────────────────── --}}
        <p class="register-link-text">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a>
        </p>
    </form>

    {{-- Script: show/hide field berdasarkan role --}}
    <script>
        function handleRoleChange(role) {
            const kandidatFields = ['field-jabatan-target', 'field-mentor', 'field-atasan'];
            const isKandidat = role === 'kandidat';

            kandidatFields.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = isKandidat ? 'block' : 'none';
            });

            // Ubah teks dan ikon tombol
            const label = document.getElementById('btn-label');
            if (label) label.textContent = isKandidat ? 'Next' : 'Daftar';
        }

        // Trigger saat halaman dimuat (untuk kasus old() value setelah validasi error)
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            if (roleSelect && roleSelect.value) {
                handleRoleChange(roleSelect.value);
            }
        });
    </script>
</x-guest-layout>
