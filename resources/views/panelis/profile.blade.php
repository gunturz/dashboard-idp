<x-panelis.layout title="Profile" bodyClass="bg-gray-50 min-h-screen flex flex-col pt-[80px]" :showProfileCard="false"
    :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            /* ══ Profile Page ══ */
            .prof-page { max-width: 960px }

            /* Avatar */
            .avatar-wrap {
                position: relative;
                width: 120px; height: 120px;
                flex-shrink: 0;
            }
            .avatar-img {
                width: 120px; height: 120px;
                border-radius: 24px;
                object-fit: cover;
                border: 3px solid #e2e8f0;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }
            .avatar-placeholder {
                width: 120px; height: 120px;
                border-radius: 24px;
                background: #0f172a;
                font-size: 2.6rem; font-weight: 800;
                color: white;
                box-shadow: 0 4px 20px rgba(15, 23, 42,0.3);
                letter-spacing: -1px;
            }
            .avatar-placeholder:not(.hidden) {
                display: flex; align-items: center; justify-content: center;
            }
            .avatar-upload-btn {
                position: absolute;
                bottom: -8px; right: -8px;
                width: 32px; height: 32px;
                border-radius: 10px;
                background: #14b8a6;
                box-shadow: 0 2px 8px rgba(20,184,166,0.4);
                cursor: pointer;
                border: 2px solid white;
                transition: transform .15s, background .15s;
            }
            .avatar-upload-btn:not(.hidden) {
                display: flex; align-items: center; justify-content: center;
            }
            .avatar-upload-btn:hover { background: #0d9488; transform: scale(1.08); }
            .avatar-upload-btn svg { width: 14px; height: 14px; color: white; }

            /* Hero Banner */
            .prof-hero {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #2a4060 100%);
                border-radius: 20px;
                padding: 32px 36px;
                display: flex;
                align-items: center;
                gap: 28px;
                margin-bottom: 24px;
                position: relative;
                overflow: hidden;
            }
            .prof-hero::before {
                content: '';
                position: absolute;
                top: -40px; right: -40px;
                width: 200px; height: 200px;
                border-radius: 50%;
                background: rgba(20,184,166,0.08);
            }
            .prof-hero::after {
                content: '';
                position: absolute;
                bottom: -60px; left: 30%;
                width: 250px; height: 250px;
                border-radius: 50%;
                background: rgba(255,255,255,0.04);
            }
            .prof-hero-info { flex: 1; min-width: 0; position: relative; z-index: 1; }
            .prof-hero-name {
                font-size: 1.5rem; font-weight: 800;
                color: #ffffff;
                line-height: 1.2;
            }
            .prof-hero-email { font-size: 0.85rem; color: rgba(255,255,255,0.6); margin-top: 4px; }
            .prof-hero-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: rgba(20,184,166,0.18);
                border: 1px solid rgba(20,184,166,0.3);
                color: #5eead4;
                font-size: 0.75rem;
                font-weight: 700;
                padding: 4px 12px;
                border-radius: 99px;
                margin-top: 10px;
                letter-spacing: .04em;
            }
            .prof-hero-badge::before {
                content: '';
                width: 7px; height: 7px;
                border-radius: 50%;
                background: #14b8a6;
                animation: pulse-dot 2s ease infinite;
            }
            @keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:.4} }

            /* Form Sections */
            .prof-section {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                box-shadow: 0 2px 12px rgba(0,0,0,.03);
                overflow: hidden;
                margin-bottom: 20px;
            }
            .prof-section-header {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 16px 24px;
                border-bottom: 1px solid #f1f5f9;
                background: #fafbfc;
            }
            .prof-section-icon {
                width: 32px; height: 32px;
                border-radius: 9px;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            }
            .prof-section-icon svg { width: 16px; height: 16px; }
            .prof-section-title { font-size: 0.9rem; font-weight: 700; color: #1e293b; }

            /* Field rows */
            .prof-field-row {
                display: flex;
                align-items: center;
                gap: 16px;
                padding: 14px 24px;
                border-bottom: 1px solid #f8fafc;
                transition: background .15s;
            }
            .prof-field-row:last-child { border-bottom: none; }
            .prof-field-row:hover { background: #fafbfc; }
            .prof-field-label {
                width: 160px;
                flex-shrink: 0;
                font-size: 0.82rem;
                font-weight: 600;
                color: #475569;
            }
            .prof-field-value { font-size: 0.875rem; color: #1e293b; flex: 1; }
            .prof-input {
                flex: 1;
                border: 1.5px solid #e2e8f0;
                border-radius: 10px;
                padding: 8px 12px;
                font-size: 0.875rem;
                color: #1e293b;
                background: #f8fafc;
                transition: border-color .2s, box-shadow .2s, background .2s;
                outline: none;
                font-family: 'Poppins', sans-serif;
            }
            .prof-input:focus {
                border-color: #14b8a6;
                box-shadow: 0 0 0 3px rgba(20,184,166,0.12);
                background: #fff;
            }
            .prof-input:disabled { color: #94a3b8; cursor: not-allowed; background: #f1f5f9; }

            /* Footer actions */
            .prof-footer {
                display: flex;
                justify-content: flex-end;
                gap: 12px;
                padding: 20px 24px;
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                box-shadow: 0 2px 12px rgba(0,0,0,.03);
            }

            /* Buttons */
            .btn-prem {
                align-items: center;
                gap: 8px;
                padding: 10px 20px;
                border-radius: 12px;
                font-size: 0.875rem;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s;
                border: none;
            }
            .btn-prem:not(.hidden) {
                display: inline-flex;
            }
            .btn-prem svg { width: 18px; height: 18px; }
            .btn-teal {
                background: #14b8a6; color: white;
                box-shadow: 0 4px 12px rgba(20,184,166,0.25);
            }
            .btn-teal:hover { background: #0d9488; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(20,184,166,0.3); }
            .btn-ghost {
                background: white; color: #475569; border: 1px solid #e2e8f0;
            }
            .btn-ghost:hover { background: #f8fafc; color: #1e293b; }

            /* Modal */
            .modal-backdrop {
                position: fixed; inset: 0; z-index: 200;
                background: rgba(0,0,0,0.5);
                padding: 16px;
                backdrop-filter: blur(4px);
            }
            .modal-backdrop:not(.hidden) {
                display: flex; align-items: center; justify-content: center;
            }

            /* Alerts */
            .prof-alert-success {
                display: flex; align-items: center; justify-content: space-between; gap: 12px;
                background: rgba(20,184,166,0.08);
                border: 1px solid rgba(20,184,166,0.3);
                border-radius: 14px;
                padding: 14px 18px;
                margin-bottom: 20px;
            }
            .prof-alert-error {
                background: rgba(239,68,68,0.07);
                border: 1px solid rgba(239,68,68,0.25);
                border-radius: 14px;
                padding: 14px 18px;
                margin-bottom: 20px;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .prof-hero { flex-direction: column; align-items: flex-start; gap: 16px; padding: 24px; }
                .avatar-wrap { width: 80px; height: 80px; }
                .avatar-img, .avatar-placeholder { width: 80px; height: 80px; }
                .prof-field-row { flex-direction: column; align-items: flex-start; gap: 6px; }
                .prof-field-label { width: 100%; }
                .prof-input { width: 100%; }
            }
        </style>
    </x-slot>

    <div class="prof-page mx-auto w-full animate-title pb-8 px-6">

        {{-- ── Page Header ── --}}
        <div class="page-header animate-title mt-2">
            <div class="page-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <h1 class="page-header-title">Profil Saya</h1>
                <p class="page-header-sub">Kelola informasi profil dan keamanan akun Anda</p>
            </div>
        </div>

        {{-- Alerts --}}
        @if ($errors->any())
            <div class="prof-alert-error">
                <p class="text-sm font-semibold text-red-700 mb-1">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside text-xs text-red-600 space-y-0.5">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif
        @if (session('status') === 'profile-updated')
            <div id="success-banner" class="prof-alert-success">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" width="20" height="20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold text-teal-800">Profile berhasil diperbarui!</span>
                </div>
                <button onclick="document.getElementById('success-banner').remove()" class="text-teal-500 hover:text-teal-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        @endif

        {{-- FORM --}}
        <form id="profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PATCH')
            <input type="hidden" name="should_delete_foto" id="should_delete_foto" value="0">

        {{-- Hero Banner --}}
        <div class="prof-hero">
            {{-- Avatar --}}
            <div class="avatar-wrap" style="position:relative">
                @if ($user->foto ?? false)
                    <img id="foto-preview" src="{{ asset('storage/' . $user->foto) }}" alt="Foto" class="avatar-img">
                    <div id="foto-placeholder" class="avatar-placeholder hidden">{{ strtoupper(substr($user->nama ?? 'A', 0, 1)) }}</div>
                @else
                    <div id="foto-placeholder" class="avatar-placeholder">{{ strtoupper(substr($user->nama ?? 'A', 0, 1)) }}</div>
                    <img id="foto-preview" src="" alt="Foto" class="avatar-img hidden" style="position:absolute;inset:0">
                @endif

                {{-- Upload button (visible in edit mode) --}}
                <label for="foto-input" id="foto-upload-btn" class="avatar-upload-btn hidden" title="Ganti Foto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="14" height="14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/>
                    </svg>
                </label>
                <input id="foto-input" name="foto" type="file" accept="image/*" class="sr-only" form="profile-form" onchange="previewFoto(this)">
            </div>

            <div class="prof-hero-info">
                <div class="prof-hero-name">{{ $user->nama ?? 'Nama Panelis' }}</div>
                @php $roleName = ucwords(str_replace('_', ' ', $activeRoleName ?? $user->role->role_name ?? 'Panelis')); @endphp
                <div class="prof-hero-badge">{{ $roleName }}</div>
            </div>
        </div>

            {{-- Info Akun --}}
            <div class="prof-section">
                <div class="prof-section-header">
                    <div class="prof-section-icon" style="background:rgba(20,184,166,0.1)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#14b8a6" width="16" height="16">
                            <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="prof-section-title">Info Akun</span>
                </div>
                @php $akunFields = [
                    ['label'=>'Username','key'=>'username','type'=>'text'],
                    ['label'=>'Email',   'key'=>'email',   'type'=>'email'],
                ]; @endphp
                @foreach ($akunFields as $field)
                <div class="prof-field-row">
                    <span class="prof-field-label">{{ $field['label'] }}</span>
                    <span class="view-field prof-field-value">{{ $user->{$field['key']} ?? '—' }}</span>
                    <input type="{{ $field['type'] }}" name="{{ $field['key'] }}" value="{{ $user->{$field['key']} ?? '' }}"
                           class="edit-field prof-input hidden">
                </div>
                @endforeach
            </div>

            {{-- Data Profil --}}
            <div class="prof-section">
                <div class="prof-section-header">
                    <div class="prof-section-icon" style="background:rgba(59,130,246,0.1)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#3b82f6" width="16" height="16">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="prof-section-title">Data Profil</span>
                </div>
                @php
                    $profilFields = [
                        ['label'=>'Nama Lengkap',         'key'=>'nama',          'type'=>'text',     'val'=>$user->nama ?? '—'],
                        ['label'=>'Perusahaan',           'key'=>'company_id',    'type'=>'select',   'options'=>$companies ?? [],   'val'=>$user->company->nama_company ?? '—'],
                        ['label'=>'Role',                 'key'=>'role_id',       'type'=>'readonly', 'val'=>ucwords(str_replace('_',' ',$activeRoleName ?? $user->role->role_name ?? '—'))],
                    ];
                @endphp
                @foreach ($profilFields as $field)
                <div class="prof-field-row">
                    <span class="prof-field-label">{{ $field['label'] }}</span>
                    <span class="view-field prof-field-value">
                        @if(($field['type'] === 'readonly'))
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold border border-gray-200 inline-block">{{ $field['val'] }}</span>
                        @else
                            {{ $field['val'] }}
                        @endif
                    </span>

                    @if ($field['type'] === 'text')
                        <input type="text" name="{{ $field['key'] }}" value="{{ $user->{$field['key']} ?? '' }}"
                               class="edit-field prof-input hidden">
                    @elseif ($field['type'] === 'select')
                        <select name="{{ $field['key'] }}" class="edit-field prof-input hidden"
                                {{ $field['key'] === 'company_id' ? 'onchange=loadDepartmentsByCompanyProfile(this)' : '' }}>
                            <option value="" disabled>Pilih {{ $field['label'] }}</option>
                            @foreach ($field['options'] as $opt)
                                @php
                                    if ($field['key'] === 'company_id')    $optName = $opt->nama_company;
                                    else                                       $optName = $opt->name ?? '';
                                    $selId = $user->{$field['key']} ?? null;
                                @endphp
                                <option value="{{ $opt->id }}" {{ $selId == $opt->id ? 'selected' : '' }}>{{ $optName }}</option>
                            @endforeach
                        </select>
                    @elseif ($field['type'] === 'readonly')
                        <span class="edit-field prof-field-value hidden">
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold border border-gray-200 inline-block">{{ $field['val'] }}</span>
                        </span>
                    @endif
                </div>
                @endforeach
            </div>

            {{-- Keamanan & Password --}}
            <div class="prof-section">
                <div class="prof-section-header">
                    <div class="prof-section-icon" style="background:rgba(245,158,11,0.1)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#f59e0b" width="16" height="16">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="prof-section-title">Keamanan & Password</span>
                </div>
                <div class="prof-field-row">
                    <span class="prof-field-label">Password</span>
                    
                    {{-- View Mode --}}
                    <div class="view-field flex-1 relative">
                        <input type="password" value="password1234" readonly class="prof-input w-full pr-10 text-slate-600 bg-[#eff6ff] border-none shadow-sm cursor-default" style="pointer-events: none;">
                    </div>

                    {{-- Edit Mode --}}
                    <div class="edit-field hidden flex-1 relative">
                        <input type="password" name="password" value="" placeholder="Abaikan jika tidak diubah" class="prof-input w-full pr-10 text-slate-600 outline-none">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePasswordVisibility(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 hover:text-slate-700 toggle-icon" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="prof-footer">
                <button type="button" id="btn-edit" onclick="enterEditMode()" class="btn-prem btn-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="18" height="18">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z"/>
                    </svg>
                    Edit Profil
                </button>
                <button type="button" id="btn-hapus-foto" onclick="hapusFoto()"
                        class="btn-prem btn-ghost hidden" style="color:#ef4444;border-color:#fecaca">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Hapus Foto
                </button>
                <button type="button" id="btn-batal" onclick="exitEditMode()" class="btn-prem btn-ghost hidden">
                    Batal
                </button>
                <button type="button" id="btn-simpan" onclick="openConfirmModal()" class="btn-prem btn-teal hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="18" height="18">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- Confirm Modal --}}
    <div id="confirm-modal" class="modal-backdrop hidden">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-sm flex flex-col items-center text-center gap-5">
            <div class="w-16 h-16 rounded-full bg-teal-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="36" height="36">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-gray-800">Simpan Perubahan?</p>
                <p class="text-sm text-gray-500 mt-1">Data profil Anda akan diperbarui. Lanjutkan?</p>
            </div>
            <div class="flex gap-3 w-full">
                <button type="button" onclick="closeConfirmModal()"
                        class="flex-1 border border-gray-200 text-gray-600 font-semibold py-2.5 rounded-xl hover:bg-gray-50 transition active:scale-95">
                    Batalkan
                </button>
                <button type="button" onclick="submitForm()"
                        class="flex-1 bg-[#14b8a6] hover:bg-[#0d9488] text-white font-semibold py-2.5 rounded-xl shadow transition active:scale-95">
                    Ya, Simpan
                </button>
            </div>
        </div>
    </div>

    @include('profile.partials.cropper-modal')

    <x-slot name="scripts">
    <script>
        // Dropdown menu handling outside
        document.addEventListener('click', function(e) {
            const inside = ['bell-wrapper', 'profile-wrapper', 'mobile-menu-wrapper'].some(id => {
                const el = document.getElementById(id);
                return el && el.contains(e.target);
            });
            if (!inside) {
                document.querySelectorAll('.dropdown-panel').forEach(d => d.classList.add('hidden'));
            }
        });

        // AJAX Load Department
        function loadDepartmentsByCompanyProfile(selectElement) {
            const companyId = selectElement.value;
            const deptSelects = document.querySelectorAll('select[name="department_id"]');
            deptSelects.forEach(s => {
                s.innerHTML = '<option value="" disabled selected>Memuat...</option>';
            });

            if (!companyId) return;

            fetch(`{{ route('register.departments_by_company') }}?company_id=${companyId}`)
                .then(r => r.json())
                .then(data => {
                    let html = '<option value="" disabled selected>Pilih Departemen</option>';
                    if (data.length === 0) html = '<option value="" disabled selected>Tidak ada</option>';
                    else data.forEach(d => html += `<option value="${d.id}">${d.nama_department}</option>`);
                    deptSelects.forEach(s => s.innerHTML = html);
                })
                .catch(() => deptSelects.forEach(s => s.innerHTML = '<option value="" disabled selected>Error</option>'));
        }

        function enterEditMode() {
            document.querySelectorAll('.view-field').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.edit-field').forEach(el => el.classList.remove('hidden'));
            document.getElementById('foto-upload-btn').classList.remove('hidden');
            document.getElementById('btn-edit').classList.add('hidden');
            document.getElementById('btn-simpan').classList.remove('hidden');
            document.getElementById('btn-batal').classList.remove('hidden');
            document.getElementById('btn-hapus-foto').classList.remove('hidden');
        }
        function exitEditMode() {
            document.querySelectorAll('.view-field').forEach(el => el.classList.remove('hidden'));
            document.querySelectorAll('.edit-field').forEach(el => el.classList.add('hidden'));
            document.getElementById('foto-upload-btn').classList.add('hidden');
            document.getElementById('btn-edit').classList.remove('hidden');
            document.getElementById('btn-simpan').classList.add('hidden');
            document.getElementById('btn-batal').classList.add('hidden');
            document.getElementById('btn-hapus-foto').classList.add('hidden');
            document.getElementById('foto-input').value = '';
            document.getElementById('should_delete_foto').value = '0';
        }
        function previewFoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    const pr    = document.getElementById('foto-preview');
                    const ph    = document.getElementById('foto-placeholder');
                    pr.src = e.target.result;
                    pr.classList.remove('hidden');
                    if (ph) ph.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function hapusFoto() {
            const pr = document.getElementById('foto-preview');
            const ph = document.getElementById('foto-placeholder');
            if (pr) { pr.src = ''; pr.classList.add('hidden'); }
            if (ph) ph.classList.remove('hidden');
            document.getElementById('foto-input').value = '';
            document.getElementById('should_delete_foto').value = '1';
        }
        function openConfirmModal()  { document.getElementById('confirm-modal').classList.remove('hidden'); }
        function closeConfirmModal() { document.getElementById('confirm-modal').classList.add('hidden'); }
        function submitForm() { 
            closeConfirmModal(); 
            document.getElementById('profile-form').submit(); 
        }
        
        function togglePasswordVisibility(button) {
            const input = button.previousElementSibling;
            const icon = button.querySelector('.toggle-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" /><path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />';
            }
        }

        document.getElementById('confirm-modal').addEventListener('click', e => { if (e.target === document.getElementById('confirm-modal')) closeConfirmModal(); });
    </script>
    </x-slot>
</x-panelis.layout>
