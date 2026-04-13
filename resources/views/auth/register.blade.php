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

        {{-- ── EMAIL ───────────────────────────── --}}
        <div style="margin-bottom: 1rem;">
            <label for="email" class="form-label">Email</label>
            <div class="input-wrapper">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input"
                    placeholder="Masukan email" required autocomplete="email" />
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
            <p style="font-size:0.73rem;color:#94a3b8;margin-top:0.35rem;line-height:1.5;">
                Minimal 8 karakter, mengandung huruf kapital dan angka.
            </p>
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

        {{-- ── ROLE ─────────────────────────────── --}}
        <div style="margin-bottom: 1rem;">
            <label for="role_id" class="form-label">Role</label>
            <div class="input-wrapper">
                <select id="role_id" name="role_id" class="form-select" required
                    onchange="handleRoleChange(this)">
                    <option value="" disabled {{ old('role_id') ? '' : 'selected' }}>Pilih role</option>
                    @foreach ($roles as $rl)
                        <option value="{{ $rl->id }}" data-rolename="{{ $rl->role_name }}" {{ old('role_id') == $rl->id ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $rl->role_name)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('role_id')
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

        {{-- ── COMPANY (muncul untuk Finance & panelis) ───────────────────────── --}}
        <div id="field-company" style="margin-bottom: 1rem; display: none;">
            <label for="company_id" class="form-label">Perusahaan</label>
            <div class="input-wrapper">
                <select id="company_id" name="company_id" class="form-select" onchange="loadDepartmentsByCompany(this.value)">
                    <option value="" disabled {{ old('company_id') ? '' : 'selected' }}>Pilih nama perusahaan
                    </option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->nama_company }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('company_id')
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

        {{-- ── DEPARTEMEN (hidden untuk Finance & panelis) ───────────────────────── --}}
        <div id="field-department" style="margin-bottom: 1rem; display: none;">
            <label for="department_id" class="form-label">Departemen</label>
            <div class="input-wrapper">
                <select id="department_id" name="department_id" class="form-select">
                    <option value="" disabled selected>Pilih nama departemen
                    </option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->nama_department }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('department_id')
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

        {{-- ── POSISI SEKARANG (hidden untuk Finance & panelis) ────────────────────── --}}
        <div id="field-position" style="margin-bottom: 1rem; display: none;">
            <label for="position_id" class="form-label">Posisi sekarang</label>
            <div class="input-wrapper">
                <select id="position_id" name="position_id" class="form-select">
                    <option value="" disabled {{ old('position_id') ? '' : 'selected' }}>Pilih posisi sekarang</option>
                    @foreach ($positions as $pos)
                        <option value="{{ $pos->id }}" {{ old('position_id') == $pos->id ? 'selected' : '' }}>
                            {{ $pos->position_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('position_id')
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
        function handleRoleChange(selectElement) {
            const roleName = (selectElement.options[selectElement.selectedIndex].dataset.rolename || '').toLowerCase();
            const isTalent = roleName === 'talent';
            const isFinance = roleName === 'finance';
            const isPanelis = (roleName === 'panelis');

            // Fields khusus talent
            const talentFields = ['field-jabatan-target', 'field-mentor', 'field-atasan'];
            talentFields.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = isTalent ? 'block' : 'none';
            });

            // Company field: tampil untuk Finance, panelis, dan role lain yang butuh company
            const companyEl = document.getElementById('field-company');
            const deptEl = document.getElementById('field-department');
            const posEl = document.getElementById('field-position');

            if (isFinance) {
                // Finance: hanya tampilkan Perusahaan
                if (companyEl) companyEl.style.display = 'block';
                if (deptEl) deptEl.style.display = 'none';
                if (posEl) posEl.style.display = 'none';

                // Set required untuk company, remove untuk dept & position
                document.getElementById('company_id').required = true;
                document.getElementById('department_id').required = false;
                document.getElementById('position_id').required = false;
            } else if (isPanelis) {
                // Panelis: tampilkan Perusahaan dan Posisi, sembunyikan Departemen
                if (companyEl) companyEl.style.display = 'block';
                if (deptEl) deptEl.style.display = 'none';
                if (posEl) posEl.style.display = 'none';

                // Set required untuk company dan position, remove untuk dept
                document.getElementById('company_id').required = true;
                document.getElementById('department_id').required = false;
                document.getElementById('position_id').required = false;
            } else if (roleName) {
                // Role lain (talent, mentor, atasan, pdc_admin): tampilkan semua
                if (companyEl) companyEl.style.display = 'block';
                if (deptEl) deptEl.style.display = 'block';
                if (posEl) posEl.style.display = 'block';

                document.getElementById('company_id').required = true;
                document.getElementById('department_id').required = true;
                document.getElementById('position_id').required = true;
            } else {
                // Belum pilih role: sembunyikan semua
                if (companyEl) companyEl.style.display = 'none';
                if (deptEl) deptEl.style.display = 'none';
                if (posEl) posEl.style.display = 'none';
            }

            // Ubah teks dan ikon tombol
            const label = document.getElementById('btn-label');
            if (label) label.textContent = isTalent ? 'Next' : 'Daftar';

            const warningEl = document.getElementById('non-kandidat-warning');
            if (warningEl) warningEl.style.display = isTalent ? 'none' : 'block';
        }

        // Load departments via AJAX when company changes
        function loadDepartmentsByCompany(companyId) {
            const deptSelect = document.getElementById('department_id');
            deptSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';

            if (!companyId) {
                deptSelect.innerHTML = '<option value="" disabled selected>Pilih nama departemen</option>';
                return;
            }

            fetch(`{{ route('register.departments_by_company') }}?company_id=${companyId}`)
                .then(res => res.json())
                .then(data => {
                    deptSelect.innerHTML = '<option value="" disabled selected>Pilih nama departemen</option>';
                    data.forEach(dept => {
                        const opt = document.createElement('option');
                        opt.value = dept.id;
                        opt.textContent = dept.nama_department;
                        // Re-select old value if validation failed and came back
                        if (dept.id == '{{ old('department_id') }}') {
                            opt.selected = true;
                        }
                        deptSelect.appendChild(opt);
                    });
                    if (data.length === 0) {
                        deptSelect.innerHTML = '<option value="" disabled selected>Tidak ada departemen untuk perusahaan ini</option>';
                    }
                })
                .catch(() => {
                    deptSelect.innerHTML = '<option value="" disabled selected>Gagal memuat departemen</option>';
                });
        }

        // Trigger saat halaman dimuat (untuk kasus old() value setelah validasi error)
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role_id');
            if (roleSelect && roleSelect.value) {
                handleRoleChange(roleSelect);
            }
            // If company was previously selected (e.g. validation error), reload departments
            const companySelect = document.getElementById('company_id');
            if (companySelect && companySelect.value) {
                loadDepartmentsByCompany(companySelect.value);
            }
        });
    </script>
</x-guest-layout>
