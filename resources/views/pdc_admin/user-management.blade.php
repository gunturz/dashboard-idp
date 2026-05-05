<x-pdc_admin.layout title="User Management – PDC Admin" :user="$user">

    <x-slot name="styles">
        <style>
            .um-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
            }

            .um-table th,
            .um-table td {
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                padding: 12px 16px;
                text-align: center;
                vertical-align: middle;
            }

            .um-table th:last-child,
            .um-table td:last-child {
                border-right: none;
            }

            .um-table tbody tr:last-child td {
                border-bottom: none;
            }

            .um-email-cell {
                max-width: 220px;
            }

            .um-email-text {
                display: block;
                max-width: 100%;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
        </style>
    </x-slot>

    {{-- Page Header --}}
    <div class="page-header animate-title mb-8">
        <div class="page-header-icon shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">User Management</div>
            <div class="page-header-sub">Kelola pengguna sistem, peran, dan pengaturan akses keamanan.</div>
        </div>
    </div>

    <livewire:pdc-user-management-table />

    {{-- ════════════════════════════════════════════════ --}}
    {{-- Tambah User Modal --}}
    {{-- ════════════════════════════════════════════════ --}}
    <div id="addUserModal" class="fixed inset-0 bg-black/50 z-[100] items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all flex flex-col max-h-[92vh]">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-[#2e3746] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#2e3746]">Tambah User Baru</h3>
                </div>
                <button type="button" onclick="closeAddUserModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="mx-6 mt-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Body --}}
            <form id="addUserForm" method="POST" action="{{ route('pdc_admin.user.store') }}" class="overflow-y-auto flex-1" autocomplete="off">
                @csrf
                <div class="px-6 py-5 space-y-4">

                    {{-- Username --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Username</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                            <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukan username" required autocomplete="off"
                                class="w-full border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Email</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukan email" required
                                class="w-full border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Password</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                            <input type="password" id="add_password" name="password" placeholder="Masukan password" required autocomplete="new-password"
                                class="w-full border border-gray-200 rounded-xl py-2.5 pl-10 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
                            <button type="button" onclick="toggleAddPassword('add_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg class="eye-open h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <svg class="eye-closed h-4 w-4 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Minimal 8 karakter, mengandung huruf kapital dan angka.</p>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                            <input type="password" id="add_password_confirmation" name="password_confirmation" placeholder="Konfirmasi password" required autocomplete="new-password"
                                class="w-full border border-gray-200 rounded-xl py-2.5 pl-10 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
                            <button type="button" onclick="toggleAddPassword('add_password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg class="eye-open h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <svg class="eye-closed h-4 w-4 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukan nama lengkap" required
                                class="w-full border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
                        </div>
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Role</label>
                        <select name="role_id" id="add_role_id" required onchange="handleAddRoleChange(this)"
                            class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white appearance-none transition-all">
                            <option value="" disabled {{ old('role_id') ? '' : 'selected' }}>Pilih role</option>
                            @foreach($rolesData as $rl)
                                @if(!in_array(strtolower($rl->role_name), ['admin', 'pdc admin', 'pdc_admin']))
                                    <option value="{{ $rl->id }}" data-rolename="{{ $rl->role_name }}" {{ old('role_id') == $rl->id ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('_', ' ', $rl->role_name)) }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    {{-- Perusahaan --}}
                    <div id="add-field-company">
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Perusahaan</label>
                        <select name="company_id" id="add_company_id" onchange="loadAddDepartments(this.value)"
                            class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white appearance-none transition-all">
                            <option value="" disabled selected>Pilih perusahaan</option>
                            @foreach($companies as $c)
                                <option value="{{ $c->id }}" {{ old('company_id') == $c->id ? 'selected' : '' }}>{{ $c->nama_company }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Departemen --}}
                    <div id="add-field-department">
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Departemen</label>
                        <select name="department_id" id="add_department_id"
                            class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white appearance-none transition-all">
                            <option value="" disabled selected>Pilih departemen</option>
                        </select>
                    </div>

                    {{-- Posisi --}}
                    <div id="add-field-position">
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Posisi Saat Ini</label>
                        <select name="position_id" id="add_position_id"
                            class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white appearance-none transition-all">
                            <option value="" disabled selected>Pilih posisi</option>
                            @foreach($positions as $pos)
                                <option value="{{ $pos->id }}" {{ old('position_id') == $pos->id ? 'selected' : '' }}>{{ $pos->position_name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- Footer Buttons --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 shrink-0">
                    <button type="button" onclick="closeAddUserModal()" class="px-5 py-2.5 text-sm font-medium text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-[#2e3746] rounded-xl hover:bg-[#1e2736] transition-colors shadow-sm">
                        + Tambah User
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Role Assignment Modal --}}
    <div id="roleModal" class="fixed inset-0 bg-black/50 z-[100] items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80">
                <h3 class="text-lg font-bold text-[#2e3746]">Assign Role</h3>
                <button type="button" onclick="closeRoleModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="roleForm" method="POST" action="">
                @csrf
                <div class="px-6 py-5">
                    <p class="text-sm text-gray-500 mb-4">Pilih role yang akan ditetapkan untuk user ini (bisa lebih dari satu).</p>
                    <div class="space-y-3">
                        @foreach ($rolesData as $roleData)
                            @if (!in_array(strtolower($roleData->role_name), ['admin', 'pdc admin', 'pdc_admin', 'finance', 'panelis']))
                                <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors m-0">
                                    <input type="checkbox" name="roles[]" value="{{ $roleData->id }}"
                                        class="role-checkbox w-5 h-5 text-[#14b8a6] border-gray-300 rounded focus:ring-[#14b8a6]">
                                    <span class="ml-3 font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $roleData->role_name) }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                    <button type="button" onclick="closeRoleModal()" class="px-5 py-2.5 text-sm font-medium text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-[#14b8a6] rounded-xl hover:bg-[#0d9488] transition-colors shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit User Modal --}}
    <div id="editUserModal" class="fixed inset-0 bg-black/50 z-[100] items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden transform transition-all flex flex-col max-h-[90vh]">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80">
                <h3 id="editUserModalTitle" class="text-lg font-bold text-[#2e3746]">Edit Profile Talent</h3>
                <button type="button" onclick="closeEditUserModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="flex-1 overflow-y-auto p-6">
                <form id="editUserForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-5 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <input type="text" name="username" id="edit_username" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#14b8a6] focus:border-[#14b8a6]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama" id="edit_nama" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#14b8a6] focus:border-[#14b8a6]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="edit_email" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#14b8a6] focus:border-[#14b8a6]" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Perusahaan</label>
                            <select name="company_id" id="edit_company_id" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#14b8a6] focus:border-[#14b8a6]" onchange="updateDepartmentsDropdown()" required>
                                <option value="">Pilih Perusahaan</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->nama_company }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Departemen</label>
                            <select name="department_id" id="edit_department_id" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#14b8a6] focus:border-[#14b8a6]" required>
                                <option value="">Pilih Departemen</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Posisi Saat Ini</label>
                            <select name="position_id" id="edit_position_id" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#14b8a6] focus:border-[#14b8a6]" required>
                                <option value="">Pilih Posisi</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->position_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
                
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keamanan</label>
                    <button type="button" onclick="triggerResetPassword()" class="px-4 py-2 bg-[#fef3c7] text-[#d97706] hover:bg-[#fde68a] font-medium rounded-xl text-sm transition-colors flex items-center gap-2">
                        <!-- Key inside a refresh circle -->
                        <div class="relative w-5 h-5 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-5 h-5 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                        </div>
                        Reset Password
                    </button>
                </div>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 shrink-0">
                <button type="button" onclick="closeEditUserModal()" class="px-5 py-2.5 text-sm font-medium text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batal</button>
                <button type="button" onclick="document.getElementById('editUserForm').submit()" class="px-5 py-2.5 text-sm font-bold text-white bg-[#14b8a6] rounded-xl hover:bg-[#0d9488] transition-colors shadow-sm">Simpan</button>
            </div>
        </div>
    </div>

    {{-- Reset Password Modal --}}
    <div id="resetPasswordModal" class="fixed inset-0 bg-black/50 z-[100] items-center justify-center p-4 hidden">
        <form id="resetPasswordForm" method="POST" action="" class="w-full max-w-[400px]">
            @csrf
            <div class="bg-white rounded-2xl w-full shadow-2xl p-8 flex flex-col items-center text-center transform transition-all">
                <div class="w-20 h-20 rounded-full bg-[#E5B224] flex items-center justify-center mb-5">
                    <span class="text-white text-5xl font-bold">!</span>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Konfirmasi</h3>
                <p class="text-gray-900 text-[15px] mb-8">Apakah Anda yakin untuk mereset password user ini menjadi "Password123"?</p>
                <div class="flex gap-4 w-full">
                    <button type="button" onclick="closeResetPasswordModal()" class="flex-1 py-2.5 px-4 text-sm font-semibold text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batalkan</button>
                    <button type="submit" class="flex-1 py-2.5 px-4 text-sm font-semibold text-white bg-[#4e5a6a] rounded-xl hover:bg-[#3d4756] transition-colors shadow-sm">Ya, Yakin</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteModal" class="fixed inset-0 bg-black/50 z-[100] items-center justify-center p-4 hidden">
        <form id="deleteForm" method="POST" action="" class="w-full max-w-[400px]">
            @csrf
            @method('DELETE')
            <div class="bg-white rounded-2xl w-full flex flex-col items-center shadow-2xl p-8 text-center transform transition-all">
                <div class="w-16 h-16 rounded-full bg-[#EF4444] flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Hapus User?</h3>
                <p class="text-gray-500 text-[15px] mb-8">Data user ini akan dihapus secara permanen dan tidak dapat dikembalikan.</p>
                <div class="flex gap-4 w-full">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 py-3 px-4 text-sm font-semibold text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batalkan</button>
                    <button type="submit" class="flex-1 py-3 px-4 text-sm font-bold text-white bg-[#EF4444] rounded-xl hover:bg-[#dc2626] transition-colors shadow-sm">Ya, Hapus</button>
                </div>
            </div>
        </form>
    </div>

    <x-slot name="scripts">
        <script>
            // ── Edit Modal ──
            let currentEditUserId = null;
            
            async function updateDepartmentsDropdown(selectedDeptId = null) {
                const companyId = document.getElementById('edit_company_id').value;
                const deptSelect = document.getElementById('edit_department_id');
                
                deptSelect.innerHTML = '<option value="">Memuat departemen...</option>';
                deptSelect.disabled = true;
                
                if (!companyId) {
                    deptSelect.innerHTML = '<option value="">Pilih Departemen</option>';
                    deptSelect.disabled = false;
                    return;
                }
                
                try {
                    const response = await fetch(`/register/departments?company_id=${companyId}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const departments = await response.json();
                    
                    deptSelect.innerHTML = '<option value="">Pilih Departemen</option>';
                    
                    departments.forEach(dept => {
                        const option = document.createElement('option');
                        option.value = dept.id;
                        option.textContent = dept.nama_department;
                        if (selectedDeptId && selectedDeptId == dept.id) {
                            option.selected = true;
                        }
                        deptSelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error fetching departments:', error);
                    deptSelect.innerHTML = '<option value="">Gagal memuat departemen</option>';
                } finally {
                    deptSelect.disabled = false;
                }
            }

            function openEditUserModal(userId, username, nama, email, companyId, departmentId, positionId) {
                currentEditUserId = userId;
                const form = document.getElementById('editUserForm');
                form.action = `/pdc-admin/user/${userId}`;
                
                document.getElementById('editUserModalTitle').textContent = `Edit Profile ${nama || 'User'}`;
                
                document.getElementById('edit_username').value = username || '';
                document.getElementById('edit_nama').value = nama || '';
                document.getElementById('edit_email').value = email || '';
                document.getElementById('edit_company_id').value = companyId || '';
                
                updateDepartmentsDropdown(departmentId);
                
                document.getElementById('edit_position_id').value = positionId || '';
                
                const modal = document.getElementById('editUserModal');
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }
            
            function closeEditUserModal() {
                const modal = document.getElementById('editUserModal');
                modal.style.display = 'none';
                modal.classList.add('hidden');
            }

            function triggerResetPassword() {
                if (currentEditUserId) {
                    closeEditUserModal();
                    openResetPasswordModal(currentEditUserId);
                }
            }

            // ── Reset Password Modal ──
            function openResetPasswordModal(userId) {
                const form = document.getElementById('resetPasswordForm');
                form.action = `/pdc-admin/reset-password/${userId}`;
                const modal = document.getElementById('resetPasswordModal');
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }
            function closeResetPasswordModal() {
                const modal = document.getElementById('resetPasswordModal');
                modal.style.display = 'none';
                modal.classList.add('hidden');
            }

            // ── Role Modal ──
            function openRoleModal(userId, currentRoleIds) {
                const form = document.getElementById('roleForm');
                form.action = `/pdc-admin/assign-role/${userId}`;
                const modal = document.getElementById('roleModal');
                document.querySelectorAll('.role-checkbox').forEach(cb => {
                    cb.checked = Array.isArray(currentRoleIds)
                        ? currentRoleIds.includes(parseInt(cb.value))
                        : false;
                });
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }
            function closeRoleModal() {
                const modal = document.getElementById('roleModal');
                modal.style.display = 'none';
                modal.classList.add('hidden');
            }

            // ── Delete Modal ──
            function openDeleteModal(userId) {
                const form = document.getElementById('deleteForm');
                form.action = `/pdc-admin/user/${userId}`;
                const modal = document.getElementById('deleteModal');
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }
            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                modal.style.display = 'none';
                modal.classList.add('hidden');
            }

            function openAddUserModal() {
                const modal = document.getElementById('addUserModal');
                const form = document.getElementById('addUserForm');
                
                @if(!$errors->any())
                    // Jika tidak ada error (bukan dari submit gagal), bersihkan isi form
                    form.reset();
                    // Pastikan departemen kosong
                    document.getElementById('add_department_id').innerHTML = '<option value="" disabled selected>Pilih departemen</option>';
                    // Sembunyikan field yang dinamis kecuali role dipilih (yang mana awalnya kosong)
                    ['add-field-company', 'add-field-department', 'add-field-position'].forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.style.display = 'none';
                    });
                @endif

                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }
            function closeAddUserModal() {
                const modal = document.getElementById('addUserModal');
                modal.style.display = 'none';
                modal.classList.add('hidden');
            }

            // Auto-open if there were validation errors (form was submitted)
            @if($errors->any() && old('_token'))
                document.addEventListener('DOMContentLoaded', () => openAddUserModal());
            @endif

            function handleAddRoleChange(select) {
                const roleName = (select.options[select.selectedIndex].dataset.rolename || '').toLowerCase();
                const isFinanceOrPanelis = roleName === 'finance' || roleName === 'panelis' || roleName === 'bo_director' || roleName === 'board_of_directors' || roleName === 'board_of_director';

                const companyEl = document.getElementById('add-field-company');
                const deptEl = document.getElementById('add-field-department');
                const posEl = document.getElementById('add-field-position');

                if (isFinanceOrPanelis) {
                    if (companyEl) companyEl.style.display = 'block';
                    if (deptEl) deptEl.style.display = 'none';
                    if (posEl) posEl.style.display = 'none';
                } else if (select.value) {
                    if (companyEl) companyEl.style.display = 'block';
                    if (deptEl) deptEl.style.display = 'block';
                    if (posEl) posEl.style.display = 'block';
                } else {
                    if (companyEl) companyEl.style.display = 'none';
                    if (deptEl) deptEl.style.display = 'none';
                    if (posEl) posEl.style.display = 'none';
                }
                // Reset departments when role changes
                const deptSelect = document.getElementById('add_department_id');
                deptSelect.innerHTML = '<option value="" disabled selected>Pilih departemen</option>';
                // Reset company selection
                document.getElementById('add_company_id').value = '';
            }

            function loadAddDepartments(companyId) {
                const deptSelect = document.getElementById('add_department_id');
                deptSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';
                deptSelect.disabled = true;

                if (!companyId) {
                    deptSelect.innerHTML = '<option value="" disabled selected>Pilih departemen</option>';
                    deptSelect.disabled = false;
                    return;
                }

                fetch(`/register/departments?company_id=${companyId}`)
                    .then(res => res.json())
                    .then(data => {
                        deptSelect.innerHTML = '<option value="" disabled selected>Pilih departemen</option>';
                        if (data.length === 0) {
                            deptSelect.innerHTML = '<option value="" disabled selected>Tidak ada departemen</option>';
                        } else {
                            data.forEach(dept => {
                                const opt = document.createElement('option');
                                opt.value = dept.id;
                                opt.textContent = dept.nama_department;
                                deptSelect.appendChild(opt);
                            });
                        }
                    })
                    .catch(() => {
                        deptSelect.innerHTML = '<option value="" disabled selected>Gagal memuat departemen</option>';
                    })
                    .finally(() => { deptSelect.disabled = false; });
            }

            function toggleAddPassword(inputId, btn) {
                const input = document.getElementById(inputId);
                const eyeOpen = btn.querySelector('.eye-open');
                const eyeClosed = btn.querySelector('.eye-closed');
                if (input.type === 'password') {
                    input.type = 'text';
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                } else {
                    input.type = 'password';
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                }
            }

            // Initialize field visibility on page load
            document.addEventListener('DOMContentLoaded', () => {
                const roleSelect = document.getElementById('add_role_id');
                if (roleSelect && roleSelect.value) handleAddRoleChange(roleSelect);
                const companySelect = document.getElementById('add_company_id');
                if (companySelect && companySelect.value) loadAddDepartments(companySelect.value);
            });

        </script>
    </x-slot>
</x-pdc_admin.layout>
