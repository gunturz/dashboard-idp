<x-guest-layout>
    <form method="POST" action="{{ route('register.kompetensi.store') }}" id="kompetensi-form">
        @csrf

        {{-- ── JUDUL ────────────────────────────── --}}
        <h2 class="login-title" style="margin-bottom: 0.5rem;">Kompetensi</h2>
        <p style="text-align:center; font-size:0.78rem; color:#94a3b8; margin-bottom:1.5rem;">
            Pilih level kompetensi Anda saat ini
        </p>

        {{-- ── PROGRESS INDICATOR ───────────────── --}}
        <div style="display:flex; align-items:center; justify-content:center; gap:0.5rem; margin-bottom:1.75rem;">
            <div
                style="width:28px;height:28px;border-radius:50%;background:#e2e8f0;display:flex;align-items:center;justify-content:center;font-size:0.72rem;font-weight:700;color:#94a3b8;">
                1</div>
            <div
                style="flex:1;max-width:60px;height:2px;background:linear-gradient(to right,#22c55e,#22c55e);border-radius:99px;">
            </div>
            <div
                style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#22c55e,#16a34a);display:flex;align-items:center;justify-content:center;font-size:0.72rem;font-weight:700;color:#fff;box-shadow:0 2px 8px rgba(34,197,94,.4);">
                2</div>
        </div>

        {{-- ── ERROR GLOBAL ─────────────────────── --}}
        @if ($errors->any())
            <div
                style="background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;padding:0.6rem 1rem;margin-bottom:1rem;">
                <ul style="margin:0;padding:0 0 0 1rem;font-size:0.78rem;color:#dc2626;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ── DAFTAR KOMPETENSI ────────────────── --}}
        @foreach ($kompetensi as $key => $label)
            <div style="margin-bottom: 0.85rem;">
                <label for="{{ $key }}" class="form-label">{{ $label }}</label>
                <div class="input-wrapper">
                    <select id="{{ $key }}" name="{{ $key }}"
                        class="form-select {{ $errors->has($key) ? 'select-error' : '' }}" required>
                        <option value="" disabled {{ old($key) ? '' : 'selected' }}>Pilih</option>
                        @foreach ($levels as $value => $levelLabel)
                            <option value="{{ $value }}" {{ old($key) == $value ? 'selected' : '' }}>
                                {{ $levelLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error($key)
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
        @endforeach

        {{-- ── TOMBOL NEXT ──────────────────────── --}}
        <button type="submit" id="kompetensi-next-btn" class="btn-login" style="margin-top: 1.2rem;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                stroke="currentColor" style="width:18px;height:18px;">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg>
            Next
        </button>

        {{-- ── BACK LINK ────────────────────────── --}}
        <p class="register-link-text" style="margin-top:0.8rem;">
            <a href="{{ route('register') }}" style="color:#94a3b8; font-size:0.78rem; text-decoration:none;">
                ← Kembali ke halaman registrasi
            </a>
        </p>
    </form>

    <style>
        .select-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }
    </style>
</x-guest-layout>
