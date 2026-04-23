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

    {{-- Summary Cards --}}
    @php
        $summaryCards = [
            ['name' => 'Talent',  'count' => $talents->count(),      'color' => 'teal',   'icon' => '<path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />'],
            ['name' => 'Mentor',  'count' => $mentors->count(),      'color' => 'blue',   'icon' => '<path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.22 4.622 1 1 0 01-.89.89 8.969 8.969 0 00-4.66 1.48L10 17z" />'],
            ['name' => 'Atasan',  'count' => $atasans->count(),      'color' => 'purple', 'icon' => '<path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />'],
            ['name' => 'Finance', 'count' => $finances->count(),     'color' => 'green',  'icon' => '<path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>'],
            ['name' => 'Panelis', 'count' => $panelisUsers->count(), 'color' => 'amber',  'icon' => '<path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />'],
        ];
    @endphp
    <div class="prem-stat-grid" style="grid-template-columns: repeat(5, 1fr);">
        @foreach ($summaryCards as $card)
            <div onclick="filterRole('{{ $card['name'] }}')" data-role="{{ $card['name'] }}"
                class="prem-stat clickable prem-stat-{{ $card['color'] }} role-card transition-all">
                <div class="prem-stat-icon si-{{ $card['color'] }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        {!! $card['icon'] !!}
                    </svg>
                </div>
                <div class="prem-stat-value animate-counter" data-target="{{ $card['count'] }}">0</div>
                <div class="prem-stat-label">{{ $card['name'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- Filter Bar --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="md:col-span-2 relative">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="searchInput" oninput="filterUsers()"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                placeholder="Cari Nama">
        </div>
        <div class="md:col-span-1 relative">
            <select id="companyFilter" onchange="filterUsers()"
                class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent bg-white appearance-none transition-all"
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                <option value="">Semua Perusahaan</option>
                @foreach ($companies as $company)
                    <option value="{{ strtolower($company->nama_company) }}">{{ $company->nama_company }}</option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-1 relative">
            <select id="departmentFilter" onchange="filterUsers()"
                class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent bg-white appearance-none transition-all"
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                <option value="">Semua Departemen</option>
                @foreach ($departments as $department)
                    <option value="{{ strtolower($department->nama_department) }}">{{ $department->nama_department }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Data Section --}}
    @php
        $userGroups = [
            ['title' => 'Talent', 'users' => $talents, 'showPosisi' => true, 'showMultiRole' => true],
            ['title' => 'Mentor', 'users' => $mentors, 'showPosisi' => true, 'showMultiRole' => true],
            ['title' => 'Atasan', 'users' => $atasans, 'showPosisi' => true, 'showMultiRole' => true],
            ['title' => 'Finance', 'users' => $finances, 'showPosisi' => false, 'showMultiRole' => false],
            ['title' => 'Panelis', 'users' => $panelisUsers, 'showPosisi' => false, 'showMultiRole' => false],
        ];
    @endphp

    <div class="space-y-8">
        @foreach ($userGroups as $group)
            <div data-table-role="{{ $group['title'] }}"
                class="role-table-container border border-[#e2e8f0] rounded-xl overflow-hidden shadow-sm bg-white">
                {{-- Table Title --}}
                <div class="bg-[#f8fafc] border-b border-[#e2e8f0] py-3 text-center">
                    <h3 class="font-bold text-[#0f172a] leading-none">{{ $group['title'] }}</h3>
                </div>

                {{-- Table Data --}}
                <div class="overflow-x-auto">
                    <table class="um-table" style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr class="bg-white">
                                @if ($group['showMultiRole'])
                                    {{-- 6 columns: Email, Nama, Perusahaan, Posisi, MultiRole, Aksi --}}
                                    <th class="text-sm font-bold text-[#0f172a] p-3" style="width:20%">Email</th>
                                    <th class="text-sm font-bold text-[#0f172a] p-3" style="width:20%">Nama Lengkap</th>
                                    <th class="text-sm font-bold text-[#0f172a] p-3" style="width:20%">Perusahaan</th>
                                    <th class="text-sm font-bold text-[#0f172a] p-3" style="width:15%">Posisi saat ini</th>
                                    <th class="text-sm font-bold text-[#0f172a] p-3" style="width:10%">Multi Role</th>
                                    <th class="text-sm font-bold text-[#0f172a] p-3" style="width:15%">Aksi</th>
                                @else
                                    {{-- 4 columns for Finance/Panelis: Email, Nama, Perusahaan, Aksi --}}
                                    <th class="text-sm font-bold text-[#0f172a] p-3" style="width:30%">Email</th>
                                    <th class="text-sm font-bold text-[#0f172a] p-3" style="width:30%">Nama Lengkap</th>
                                    <th class="text-sm font-bold text-[#0f172a] p-3" style="width:25%">Perusahaan</th>
                                    <th class="text-sm font-bold text-[#0f172a] p-3" style="width:15%">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($group['users'] as $u)
                                <tr class="bg-white hover:bg-gray-50 transition-colors user-row" data-department="{{ strtolower($u->department->nama_department ?? '') }}">
                                    <td class="text-sm font-medium text-[#475569]">{{ $u->email }}</td>
                                    <td class="col-name text-sm font-bold text-[#0f172a]">{{ $u->nama }}</td>
                                    <td class="col-company text-sm font-medium text-[#475569]">
                                        {{ $u->company->nama_company ?? '—' }}</td>
                                    @if ($group['showPosisi'])
                                        <td class="text-sm font-medium text-[#475569]">
                                            {{ $u->position->position_name ?? '—' }}</td>
                                    @endif
                                    @if ($group['showMultiRole'])
                                        <td>
                                            <button type="button"
                                                onclick="openRoleModal({{ $u->id }}, {{ $u->roles->pluck('id') }})"
                                                class="flex items-center justify-center w-16 h-8 mx-auto bg-[#F5A623] hover:bg-[#e0961e] rounded-md transition-colors shadow-sm"
                                                title="Multi Role">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-5 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                                </svg>
                                            </button>
                                        </td>
                                    @endif
                                    <td>
                                        <div class="flex flex-row items-center justify-center gap-2">
                                            <button type="button" onclick="openDeleteModal({{ $u->id }})"
                                                class="flex items-center justify-center w-16 h-8 bg-[#EF4444] hover:bg-[#dc2626] rounded-md transition-colors shadow-sm"
                                                title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                            <button type="button"
                                                onclick="openResetPasswordModal({{ $u->id }})"
                                                class="flex items-center justify-center w-16 h-8 bg-[#F4F1EA] hover:bg-[#eadecc] border border-[#e5e1d8] rounded-md transition-colors shadow-sm"
                                                title="Reset Password">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#475569]"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    @php
                                        $cols = 4;
                                        if ($group['showPosisi']) {
                                            $cols++;
                                        }
                                        if ($group['showMultiRole']) {
                                            $cols++;
                                        }
                                    @endphp
                                    <td colspan="{{ $cols }}"
                                        class="py-10 text-center text-sm text-gray-400 italic">Belum ada user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination Wrapper --}}
                <div class="px-6 py-4 border-t border-[#e2e8f0] flex items-center justify-between bg-gray-50/50 pagination-wrapper" style="display: none;">
                    <span class="text-sm text-gray-500 font-medium pagination-info"></span>
                    <div class="flex gap-1.5 pagination-buttons"></div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Role Assignment Modal --}}
    <div id="roleModal" class="fixed inset-0 bg-black/50 z-[100] items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80">
                <h3 class="text-lg font-bold text-[#0f172a]">Assign Role</h3>
                <button type="button" onclick="closeRoleModal()"
                    class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="roleForm" method="POST" action="">
                @csrf
                <div class="px-6 py-5">
                    <p class="text-sm text-gray-500 mb-4">Pilih role yang akan ditetapkan untuk user ini (bisa lebih
                        dari satu).</p>
                    <div class="space-y-3">
                        @foreach ($rolesData as $roleData)
                            @if (!in_array(strtolower($roleData->role_name), ['admin', 'pdc admin', 'pdc_admin']))
                                <label
                                    class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors m-0">
                                    <input type="checkbox" name="roles[]" value="{{ $roleData->id }}"
                                        class="role-checkbox w-5 h-5 text-[#14b8a6] border-gray-300 rounded focus:ring-[#14b8a6]">
                                    <span
                                        class="ml-3 font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $roleData->role_name) }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                    <button type="button" onclick="closeRoleModal()"
                        class="px-5 py-2.5 text-sm font-medium text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-bold text-white bg-[#14b8a6] rounded-xl hover:bg-[#0d9488] transition-colors shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Reset Password Modal --}}
    <div id="resetPasswordModal" class="fixed inset-0 bg-black/50 z-[100] items-center justify-center p-4 hidden">
        <form id="resetPasswordForm" method="POST" action="" class="w-full max-w-[400px]">
            @csrf
            <div
                class="bg-white rounded-2xl w-full shadow-2xl p-8 flex flex-col items-center text-center transform transition-all">
                <div class="w-20 h-20 rounded-full bg-[#E5B224] flex items-center justify-center mb-5">
                    <span class="text-white text-5xl font-bold">!</span>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Konfirmasi</h3>
                <p class="text-gray-900 text-[15px] mb-8">Apakah Anda yakin untuk mereset password user?</p>

                <div class="flex gap-4 w-full">
                    <button type="button" onclick="closeResetPasswordModal()"
                        class="flex-1 py-2.5 px-4 text-sm font-semibold text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batalkan</button>
                    <button type="submit"
                        class="flex-1 py-2.5 px-4 text-sm font-semibold text-white bg-[#4e5a6a] rounded-xl hover:bg-[#3d4756] transition-colors shadow-sm">Ya,
                        Yakin</button>
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
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 py-3 px-4 text-sm font-semibold text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batalkan</button>
                    <button type="submit"
                        class="flex-1 py-3 px-4 text-sm font-bold text-white bg-[#EF4444] rounded-xl hover:bg-[#dc2626] transition-colors shadow-sm">Ya, Hapus</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function openRoleModal(userId, currentRoleIds) {
            const form = document.getElementById('roleForm');
            form.action = `/pdc-admin/assign-role/${userId}`;

            // Reset checkboxes
            document.querySelectorAll('.role-checkbox').forEach(cb => {
                cb.checked = false;
            });

            // Check current roles
            if (currentRoleIds && currentRoleIds.length) {
                document.querySelectorAll('.role-checkbox').forEach(cb => {
                    if (currentRoleIds.includes(parseInt(cb.value))) {
                        cb.checked = true;
                    }
                });
            }

            const modal = document.getElementById('roleModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function closeRoleModal() {
            const modal = document.getElementById('roleModal');
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }

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

        function openDeleteModal(userId) {
            const form = document.getElementById('deleteForm');
            // Ganti route ini dengan route delete user yang sebenarnya
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
        let activeRole = null;

        function filterRole(roleName) {
            // Toggle logic
            if (activeRole === roleName) {
                // Deselect if already selected
                activeRole = null;
            } else {
                // Select new role
                activeRole = roleName;
            }

            // Update cards styling
            document.querySelectorAll('.role-card').forEach(card => {
                if (card.dataset.role === activeRole) {
                    card.style.borderColor = '#14b8a6';
                    card.style.boxShadow = '0 8px 24px rgba(20,184,166,0.18)';
                    card.style.transform = 'translateY(-4px)';
                } else {
                    card.style.borderColor = '#e2e8f0';
                    card.style.boxShadow = '';
                    card.style.transform = '';
                }
            });

            // Terapkan ulang pencarian agar bisa menyembunyikan/menampilkan sesuai role aktif
            filterUsers();
        }

        function filterUsers() {
            let searchValue = document.getElementById('searchInput').value.toLowerCase();
            let companyValue = document.getElementById('companyFilter').value.toLowerCase();
            let departmentValue = document.getElementById('departmentFilter').value.toLowerCase();

            let isAnyFilterActive = searchValue !== "" || companyValue !== "" || departmentValue !== "";

            document.querySelectorAll('.role-table-container').forEach(container => {
                // Jika sedang memilih role spesifik dan box ini bukan role tersebut, langsung sembunyikan
                if (activeRole !== null && container.dataset.tableRole !== activeRole) {
                    container.classList.add('hidden');
                    return;
                }

                let tbody = container.querySelector('.um-table tbody');
                let rows = tbody.querySelectorAll('tr.user-row');
                let hasVisibleRow = false;
                let visibleRows = [];

                rows.forEach(row => {
                    let name = row.querySelector('.col-name')?.innerText.toLowerCase() || "";
                    let company = row.querySelector('.col-company')?.innerText.toLowerCase() || "";
                    let department = row.dataset.department || "";

                    let matchSearch = name.includes(searchValue);
                    let matchCompany = companyValue === "" || company.includes(companyValue) || company ===
                        companyValue;
                    let matchDepartment = departmentValue === "" || department.includes(departmentValue) ||
                        department === departmentValue;

                    if (matchSearch && matchCompany && matchDepartment) {
                        visibleRows.push(row);
                        hasVisibleRow = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                container.visibleRows = visibleRows;
                renderTablePage(container, 1);

                // Tampilkan container jika ada filter aktif dan terdapat baris hasil filter,
                // atau jika tidak ada filter aktif sama sekali (dan activeRole match di atas)
                if (isAnyFilterActive) {
                    if (hasVisibleRow) {
                        container.classList.remove('hidden');
                    } else {
                        container.classList.add('hidden');
                    }
                } else {
                    container.classList.remove('hidden');
                }
            });
        }

        const ITEMS_PER_PAGE = 7;

        function renderTablePage(container, page) {
            let visibleRows = container.visibleRows || [];
            let totalRows = visibleRows.length;
            let totalPages = Math.ceil(totalRows / ITEMS_PER_PAGE) || 1;
            
            if (page < 1) page = 1;
            if (page > totalPages) page = totalPages;
            container.currentPage = page;

            // Sembunyikan semua row dari view ini
            let allRows = container.querySelectorAll('tr.user-row');
            allRows.forEach(r => r.style.display = 'none');

            // Tampilkan page ke-N
            let startIndex = (page - 1) * ITEMS_PER_PAGE;
            let endIndex = Math.min(startIndex + ITEMS_PER_PAGE, totalRows);
            for (let i = startIndex; i < endIndex; i++) {
                visibleRows[i].style.display = '';
            }

            // Tampilkan pagination buttons
            let paginationWrapper = container.querySelector('.pagination-wrapper');
            if (!paginationWrapper) return;

            if (totalRows <= ITEMS_PER_PAGE) {
                paginationWrapper.style.display = 'none';
            } else {
                paginationWrapper.style.display = 'flex';
                let info = paginationWrapper.querySelector('.pagination-info');
                info.textContent = `Menampilkan ${totalRows === 0 ? 0 : startIndex + 1}-${endIndex} dari ${totalRows}`;

                let btnContainer = paginationWrapper.querySelector('.pagination-buttons');
                btnContainer.innerHTML = '';
                
                // Prev button
                let prevBtn = document.createElement('button');
                prevBtn.type = 'button';
                prevBtn.innerHTML = '&laquo; Prev';
                prevBtn.className = 'px-3 py-1.5 border rounded-lg text-xs font-semibold transition-colors ' + (page === 1 ? 'text-gray-400 bg-gray-50 border-gray-200 cursor-not-allowed' : 'text-[#14b8a6] bg-white hover:bg-teal-50 border-[#14b8a6]');
                prevBtn.disabled = page === 1;
                prevBtn.onclick = () => renderTablePage(container, page - 1);
                btnContainer.appendChild(prevBtn);

                for (let i = 1; i <= totalPages; i++) {
                    if (i === 1 || i === totalPages || (i >= page - 1 && i <= page + 1)) {
                        let btn = document.createElement('button');
                        btn.type = 'button';
                        btn.textContent = i;
                        if (i === page) {
                            btn.className = 'px-3 py-1.5 border rounded-lg text-xs font-bold text-white bg-[#14b8a6] border-[#14b8a6]';
                        } else {
                            btn.className = 'px-3 py-1.5 border rounded-lg text-xs font-semibold text-[#14b8a6] bg-white hover:bg-teal-50 border-[#14b8a6] transition-colors';
                            btn.onclick = () => renderTablePage(container, i);
                        }
                        btnContainer.appendChild(btn);
                    } else if (i === page - 2 || i === page + 2) {
                        // ellipsis
                        let span = document.createElement('span');
                        span.textContent = '...';
                        span.className = 'px-2 py-1.5 text-xs text-gray-500 font-bold';
                        btnContainer.appendChild(span);
                    }
                }

                // Next button
                let nextBtn = document.createElement('button');
                nextBtn.type = 'button';
                nextBtn.innerHTML = 'Next &raquo;';
                nextBtn.className = 'px-3 py-1.5 border rounded-lg text-xs font-semibold transition-colors ' + (page === totalPages ? 'text-gray-400 bg-gray-50 border-gray-200 cursor-not-allowed' : 'text-[#14b8a6] bg-white hover:bg-teal-50 border-[#14b8a6]');
                nextBtn.disabled = page === totalPages;
                nextBtn.onclick = () => renderTablePage(container, page + 1);
                btnContainer.appendChild(nextBtn);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // ── Animated Counter ──
            const counters = document.querySelectorAll('.animate-counter');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target') || '0', 10);
                const duration = 1000;
                const start = performance.now();
                const step = (now) => {
                    const p = Math.min((now - start) / duration, 1);
                    const ease = 1 - Math.pow(1 - p, 3);
                    counter.innerText = Math.round(ease * target);
                    if (p < 1) requestAnimationFrame(step);
                };
                requestAnimationFrame(step);
            });

            filterUsers();
        });
    </script>
</x-pdc_admin.layout>
