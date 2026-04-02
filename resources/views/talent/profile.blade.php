<x-talent.layout title="Profile" bodyClass="bg-gray-50 min-h-screen flex flex-col pt-[80px]" :showProfileCard="false" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            .section-header {
                display: inline-block;
                background: #2e3746; color: white;
                font-weight: 600; font-size: 0.875rem;
                padding: 0.35rem 1.25rem;
                border-radius: 6px 6px 0 0;
                margin-bottom: -1px;
            }
            .prof-input {
                border: 1.5px solid #cbd5e1; border-radius: 8px;
                padding: 0.45rem 0.75rem; font-size: 0.875rem;
                width: 100%; background: #fff;
                transition: border-color 0.2s, box-shadow 0.2s;
                color: #1e293b;
            }
            .prof-input:focus { outline: none; border-color: #2e3746; box-shadow: 0 0 0 3px rgba(46,55,70,0.1); }
            .prof-input:disabled { background: #f8fafc; color: #94a3b8; cursor: not-allowed; }
            .modal-backdrop {
                position: fixed; inset: 0; z-index: 100;
                background: rgba(0,0,0,0.45);
                display: flex; align-items: center; justify-content: center;
            }
                    .btn-back {
                padding: 8px 16px;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                background: white;
                color: #475569;
                font-weight: 500;
                font-size: 0.875rem;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: all 0.2s;
                width: fit-content;
            }
            .btn-back:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }
        </style>
    </x-slot>

{{-- MAIN CONTENT --}}
    <div class="w-full max-w-3xl mx-auto px-6 pb-8 pt-0 flex-grow fade-up">

        {{-- Back Link --}}
        <div class="mb-4">
            <a href="{{ route('talent.dashboard') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
                <span class="text-[#2e3746]">Kembali</span>
            </a>
        </div>

        <div class="flex items-center gap-3 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
            </svg>
            <h1 class="text-2xl font-bold text-[#2e3746]">Profile Talent</h1>
        </div>

        {{-- Error Display --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-xl shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">Terjadi kesalahan pada data yang Anda masukkan:</p>
                        <ul class="mt-1 list-disc list-inside text-xs text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Success banner --}}
        @if (session('status') === 'profile-updated')
            <div id="success-banner"
                 class="flex items-center justify-between gap-3 bg-white border border-green-400 text-green-700 rounded-xl px-5 py-3 mb-6 shadow-sm">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold">Pengubahan Profile Talent berhasil</span>
                </div>
                <button onclick="document.getElementById('success-banner').remove()"
                        class="text-green-400 hover:text-green-600 transition-colors flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        @endif

        <form id="profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                {{-- ===== DESKTOP LAYOUT (laptop): foto kiri, data kanan ===== --}}
                <div class="hidden md:flex gap-8 p-8">

                    {{-- Kolom Kiri: Foto --}}
                    <div class="flex flex-col items-center gap-4 flex-shrink-0 w-44">
                        <div class="relative w-44 h-44">
                            @if ($user->foto ?? false)
                                <img id="foto-preview"
                                     src="{{ asset('storage/' . $user->foto) }}"
                                     alt="Foto Profil"
                                     class="w-44 h-44 rounded-2xl object-cover border-2 border-gray-200 shadow">
                                <div id="foto-placeholder" class="hidden w-44 h-44 rounded-2xl bg-gray-100 border-2 border-gray-200 shadow flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @else
                                <div id="foto-placeholder" class="w-44 h-44 rounded-2xl bg-gray-100 border-2 border-gray-200 shadow flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                                <img id="foto-preview" src="" alt="Foto Profil"
                                     class="hidden w-44 h-44 rounded-2xl object-cover border-2 border-gray-200 shadow absolute inset-0">
                            @endif
                        </div>

                        {{-- Tombol foto – edit mode only --}}
                        <div id="foto-buttons" class="flex gap-2 hidden w-44">
                            <label for="foto-input"
                                   class="flex-1 flex items-center justify-center gap-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-2 py-2 rounded-lg cursor-pointer transition active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Ganti Foto
                            </label>
                            <input id="foto-input" name="foto" type="file" accept="image/*" class="sr-only" onchange="previewFoto(this)">
                            
                            {{-- Input tersembunyi untuk penanda hapus foto --}}
                            <input type="hidden" name="should_delete_foto" id="should_delete_foto" value="0">
                            
                            <button type="button" onclick="hapusFoto()"
                                    class="flex-1 flex items-center justify-center gap-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-2 py-2 rounded-lg transition active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Hapus Foto
                            </button>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Data --}}
                    <div class="flex-1 space-y-6 min-w-0">

                        {{-- Info Akun --}}
                        <div>
                            <span class="section-header">Info Akun</span>
                            <div class="border border-gray-200 rounded-b-xl rounded-tr-xl">
                                @php
                                    $akunFields = [
                                        ['label' => 'Username', 'key' => 'username', 'type' => 'text'],
                                        ['label' => 'Email',    'key' => 'email',    'type' => 'email']
                                    ];
                                @endphp
                                @foreach ($akunFields as $i => $field)
                                    <div class="flex items-center gap-4 px-5 py-3 {{ $i > 0 ? 'border-t border-gray-100' : '' }}">
                                        <span class="text-sm font-semibold text-[#3d4f62] w-32 flex-shrink-0">{{ $field['label'] }}</span>
                                        <span class="view-field text-sm text-gray-700">{{ $field['label'] === 'Password' ? '•••••••' : ($user->{$field['key']} ?? '-') }}</span>
                                        <input type="{{ $field['type'] }}"
                                               name="{{ $field['key'] }}"
                                               value="{{ $field['key'] === 'password' ? '' : ($user->{$field['key']} ?? '') }}"
                                               placeholder="{{ $field['placeholder'] ?? '' }}"
                                               {{ $field['disabled'] ?? false ? 'disabled' : '' }}
                                               class="edit-field prof-input hidden">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Profil --}}
                        <div>
                            <span class="section-header">Profil</span>
                            <div class="border border-gray-200 rounded-b-xl rounded-tr-xl">
                                @php
                                    $profilFields = [
                                        ['label' => 'Nama',               'key' => 'nama',               'type' => 'text',   'val' => $user->nama ?? '-'],
                                        ['label' => 'Perusahaan',         'key' => 'company_id',         'type' => 'select', 'options' => $companies ?? [],   'val' => $user->company->nama_company ?? '-'],
                                        ['label' => 'Departemen',         'key' => 'department_id',      'type' => 'select', 'options' => $departments ?? [], 'val' => $user->department->nama_department ?? '-'],
                                        ['label' => 'Role',               'key' => 'role_id',            'type' => 'select', 'options' => $roles ?? [],       'val' => ucwords(str_replace('_', ' ', $activeRoleName ?? $user->role->role_name ?? '-'))],
                                        ['label' => 'Posisi Sekarang',    'key' => 'position_id',        'type' => 'select', 'options' => $positions ?? [],   'val' => $user->position->position_name ?? '-'],
                                        ['label' => 'Mentor',             'type' => 'readonly', 'val' => collect(optional($user->promotion_plan)->mentor_models)->pluck('nama')->join(', ') ?: (optional($user->mentor)->nama ?? '-')],
                                        ['label' => 'Atasan',             'type' => 'readonly', 'val' => optional($user->atasan)->nama ?? '-'],
                                        ['label' => 'Posisi Yang Dituju', 'type' => 'readonly', 'val' => optional(optional($user->promotion_plan)->targetPosition)->position_name ?? '-'],
                                    ];
                                @endphp
                                @foreach ($profilFields as $i => $field)
                                    <div class="flex items-center gap-4 px-5 py-3 {{ $i > 0 ? 'border-t border-gray-100' : '' }}">
                                        <span class="text-sm font-semibold text-[#2e3746] w-32 flex-shrink-0">{{ $field['label'] }}</span>
                                        <span class="view-field text-sm text-gray-700">{{ $field['val'] }}</span>
                                        
                                        @if (($field['type'] ?? '') === 'text')
                                            <input type="text"
                                                   name="{{ $field['key'] }}"
                                                   value="{{ $user->{$field['key']} ?? '' }}"
                                                   class="edit-field prof-input hidden">
                                        @elseif (($field['type'] ?? '') === 'select')
                                            <select name="{{ $field['key'] }}" class="edit-field prof-input hidden">
                                                <option value="" disabled>Pilih {{ $field['label'] }}</option>
                                                @foreach ($field['options'] as $opt)
                                                    @php
                                                        if ($field['key'] === 'role_id') {
                                                            $optName = ucwords(str_replace('_', ' ', $opt->role_name));
                                                        } elseif ($field['key'] === 'company_id') {
                                                            $optName = $opt->nama_company;
                                                        } elseif ($field['key'] === 'department_id') {
                                                            $optName = $opt->nama_department;
                                                        } elseif (in_array($field['key'], ['position_id', 'target_position_id'])) {
                                                            $optName = $opt->position_name;
                                                        } else {
                                                            $optName = $opt->name ?? $opt->position_name ?? $opt->nama ?? '';
                                                        }
                                                        $selectedId = $field['key'] === 'target_position_id'
                                                            ? ($user->promotion_plan->target_position_id ?? null)
                                                            : ($user->{$field['key']} ?? null);
                                                    @endphp
                                                    <option value="{{ $opt->id }}" {{ $selectedId == $opt->id ? 'selected' : '' }}>
                                                        {{ $optName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <span class="edit-field text-sm text-gray-400 hidden">{{ $field['val'] }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== MOBILE LAYOUT (HP): foto atas, data bawah ===== --}}
                <div class="md:hidden flex flex-col gap-5 p-4">
                    {{-- Foto --}}
                    <div class="flex flex-col items-center gap-4">
                        <div class="relative w-36 h-36">
                            @if ($user->foto ?? false)
                                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil"
                                     class="w-36 h-36 rounded-2xl object-cover border-2 border-gray-200 shadow foto-preview-mobile">
                                <div class="hidden w-36 h-36 rounded-2xl bg-gray-100 border-2 border-gray-200 shadow flex items-center justify-center foto-placeholder-mobile">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @else
                                <div class="w-36 h-36 rounded-2xl bg-gray-100 border-2 border-gray-200 shadow flex items-center justify-center foto-placeholder-mobile">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                                <img src="" alt="Foto Profil"
                                     class="hidden w-36 h-36 rounded-2xl object-cover border-2 border-gray-200 shadow absolute inset-0 foto-preview-mobile">
                            @endif
                        </div>
                        <div class="flex gap-2 hidden w-36 foto-buttons-mobile">
                            <label for="foto-input"
                                   class="flex-1 flex items-center justify-center gap-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-2 py-2 rounded-lg cursor-pointer transition active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Ganti
                            </label>
                            <button type="button" onclick="hapusFoto()"
                                    class="flex-1 flex items-center justify-center gap-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-2 py-2 rounded-lg transition active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </div>

                    {{-- Data --}}
                    <div class="space-y-5">
                        {{-- Info Akun --}}
                        <div>
                            <span class="section-header">Info Akun</span>
                            <div class="border border-gray-200 rounded-b-xl rounded-tr-xl">
                                @foreach ($akunFields as $i => $field)
                                    <div class="flex items-center gap-3 px-4 py-3 {{ $i > 0 ? 'border-t border-gray-100' : '' }}">
                                        <span class="text-sm font-semibold text-[#3d4f62] w-28 flex-shrink-0">{{ $field['label'] }}</span>
                                        <span class="view-field text-sm text-gray-700">{{ $field['label'] === 'Password' ? '•••••••' : ($user->{$field['key']} ?? '-') }}</span>
                                        <input type="{{ $field['type'] }}"
                                               name="{{ $field['key'] }}"
                                               value="{{ $field['key'] === 'password' ? '' : ($user->{$field['key']} ?? '') }}"
                                               placeholder="{{ $field['placeholder'] ?? '' }}"
                                               {{ $field['disabled'] ?? false ? 'disabled' : '' }}
                                               class="edit-field prof-input hidden">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Profil --}}
                        <div>
                            <span class="section-header">Profil</span>
                            <div class="border border-gray-200 rounded-b-xl rounded-tr-xl">
                                @foreach ($profilFields as $i => $field)
                                    <div class="flex items-center gap-3 px-4 py-3 {{ $i > 0 ? 'border-t border-gray-100' : '' }}">
                                        <span class="text-sm font-semibold text-[#2e3746] w-28 flex-shrink-0">{{ $field['label'] }}</span>
                                        <span class="view-field text-sm text-gray-700">{{ $field['val'] }}</span>
                                        @if (($field['type'] ?? '') === 'text')
                                            <input type="text" name="{{ $field['key'] }}" value="{{ $user->{$field['key']} ?? '' }}" class="edit-field prof-input hidden">
                                        @elseif (($field['type'] ?? '') === 'select')
                                            <select name="{{ $field['key'] }}" class="edit-field prof-input hidden">
                                                <option value="" disabled>Pilih {{ $field['label'] }}</option>
                                                @foreach ($field['options'] as $opt)
                                                    @php
                                                        if ($field['key'] === 'role_id') $optName = ucwords(str_replace('_', ' ', $opt->role_name));
                                                        elseif ($field['key'] === 'company_id') $optName = $opt->nama_company;
                                                        elseif ($field['key'] === 'department_id') $optName = $opt->nama_department;
                                                        elseif (in_array($field['key'], ['position_id', 'target_position_id'])) $optName = $opt->position_name;
                                                        else $optName = $opt->name ?? $opt->position_name ?? $opt->nama ?? '';
                                                        $selectedId = $field['key'] === 'target_position_id'
                                                            ? ($user->promotion_plan->target_position_id ?? null)
                                                            : ($user->{$field['key']} ?? null);
                                                    @endphp
                                                    <option value="{{ $opt->id }}" {{ $selectedId == $opt->id ? 'selected' : '' }}>{{ $optName }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <span class="edit-field text-sm text-gray-400 hidden">{{ $field['val'] }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer aksi --}}
                <div class="border-t border-gray-100 px-8 py-5 flex justify-end gap-3">
                    <button type="button" id="btn-edit"
                            onclick="enterEditMode()"
                            class="bg-green-500 hover:bg-green-600 text-white font-semibold px-8 py-2.5 rounded-xl shadow transition-all hover:shadow-md active:scale-95">
                        Edit
                    </button>
                    <button type="button" id="btn-simpan"
                            onclick="openConfirmModal()"
                            class="hidden bg-green-500 hover:bg-green-600 text-white font-semibold px-8 py-2.5 rounded-xl shadow transition-all hover:shadow-md active:scale-95">
                        Simpan
                    </button>
                    <button type="button" id="btn-batal"
                            onclick="exitEditMode()"
                            class="hidden border border-gray-300 text-gray-600 bg-white hover:bg-gray-50 hover:text-gray-800 font-semibold px-8 py-2.5 rounded-xl transition-all active:scale-95">
                        Batal
                    </button>
                </div>
            </div>
        </form>
    </div>

    
{{-- MODAL KONFIRMASI --}}
<div id="confirm-modal" class="modal-backdrop hidden">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-80 flex flex-col items-center text-center gap-4">
            <div class="w-16 h-16 rounded-full bg-amber-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-gray-800">Konfirmasi</p>
                <p class="text-sm text-gray-500 mt-1">Apakah Anda yakin menyimpan data ini?</p>
            </div>
            <div class="flex gap-3 w-full mt-1">
                <button type="button" onclick="closeConfirmModal()"
                        class="flex-1 border border-gray-300 text-gray-600 font-semibold py-2.5 rounded-xl hover:bg-gray-50 transition active:scale-95">
                    Batalkan
                </button>
                <button type="button" onclick="submitForm()"
                        class="flex-1 bg-[#2e3746] hover:bg-[#1e2a36] text-white font-semibold py-2.5 rounded-xl shadow transition active:scale-95">
                    Ya, Yakin
                </button>
            </div>
        </div>
    </div>

<script>
// Dropdown
        function toggleDropdown(id) {
            const el = document.getElementById(id);
            const isHidden = el.classList.contains('hidden');
            document.querySelectorAll('.dropdown-panel').forEach(d => d.classList.add('hidden'));
            if (isHidden) el.classList.remove('hidden');
        }
        document.addEventListener('click', function(e) {
            const inside = ['bell-wrapper','profile-wrapper','mobile-menu-wrapper'].some(id => {
                const el = document.getElementById(id);
                return el && el.contains(e.target);
            });
            if (!inside) document.querySelectorAll('.dropdown-panel').forEach(d => d.classList.add('hidden'));
        });

        // Edit mode
        function enterEditMode() {
            document.querySelectorAll('.view-field').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.edit-field').forEach(el => el.classList.remove('hidden'));
            document.getElementById('foto-buttons').classList.remove('hidden');
            document.querySelectorAll('.foto-buttons-mobile').forEach(el => el.classList.remove('hidden'));
            document.getElementById('btn-edit').classList.add('hidden');
            document.getElementById('btn-simpan').classList.remove('hidden');
            document.getElementById('btn-batal').classList.remove('hidden');
        }

        function exitEditMode() {
            document.querySelectorAll('.view-field').forEach(el => el.classList.remove('hidden'));
            document.querySelectorAll('.edit-field').forEach(el => el.classList.add('hidden'));
            document.getElementById('foto-buttons').classList.add('hidden');
            document.querySelectorAll('.foto-buttons-mobile').forEach(el => el.classList.add('hidden'));
            document.getElementById('btn-edit').classList.remove('hidden');
            document.getElementById('btn-simpan').classList.add('hidden');
            document.getElementById('btn-batal').classList.add('hidden');
            document.getElementById('foto-input').value = '';
        }

        // Foto preview
        function previewFoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('foto-preview');
                    const placeholder = document.getElementById('foto-placeholder');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function hapusFoto() {
            const preview = document.getElementById('foto-preview');
            const placeholder = document.getElementById('foto-placeholder');
            if (preview) { preview.src = ''; preview.classList.add('hidden'); }
            if (placeholder) placeholder.classList.remove('hidden');
            document.getElementById('foto-input').value = '';
            document.getElementById('should_delete_foto').value = '1';
        }

        // Modal konfirmasi
        function openConfirmModal() {
            document.getElementById('confirm-modal').classList.remove('hidden');
        }
        function closeConfirmModal() {
            document.getElementById('confirm-modal').classList.add('hidden');
        }
        function submitForm() {
            closeConfirmModal();
            document.getElementById('profile-form').submit();
        }
        document.getElementById('confirm-modal').addEventListener('click', function(e) {
            if (e.target === this) closeConfirmModal();
        });
    </script>
</x-talent.layout>
