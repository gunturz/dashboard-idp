<div>
    @php
        $roleConfig = [
            'talent'  => ['label' => 'Talent',  'color' => 'teal',   'hex' => '#14b8a6'],
            'mentor'  => ['label' => 'Mentor',  'color' => 'blue',   'hex' => '#3b82f6'],
            'atasan'  => ['label' => 'Atasan',  'color' => 'purple', 'hex' => '#a855f7'],
            'finance' => ['label' => 'Finance', 'color' => 'green',  'hex' => '#22c55e'],
            'panelis' => ['label' => 'Panelis', 'color' => 'amber',  'hex' => '#f59e0b'],
        ];

        $roleIcons = [
            'talent'  => '<path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>',
            'mentor'  => '<path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>',
            'atasan'  => '<path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>',
            'finance' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>',
            'panelis' => '<path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>',
        ];
    @endphp

    <div style="overflow-x: auto; margin: -12px -4px -8px; padding: 12px 4px 8px;">
    <div class="prem-stat-grid mb-6" style="grid-template-columns: repeat(5, minmax(140px, 1fr)); min-width: 700px;">
        @foreach($roleConfig as $key => $cfg)
            <div wire:key="stat-{{ $key }}"
                 wire:click="toggleRole('{{ $key }}')"
                 class="prem-stat clickable prem-stat-{{ $cfg['color'] }} cursor-pointer transition-all select-none
                        {{ $selectedRole === $key ? 'ring-2 ring-offset-1 shadow-lg -translate-y-1' : 'opacity-80 hover:opacity-100' }}"
                 style="{{ $selectedRole === $key ? 'ring-color:' . $cfg['hex'] : '' }}">
                <div class="prem-stat-icon si-{{ $cfg['color'] }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        {!! $roleIcons[$key] !!}
                    </svg>
                </div>
                <div class="prem-stat-value">{{ $counts[$cfg['label']] }}</div>
                <div class="prem-stat-label">{{ $cfg['label'] }}</div>
            </div>
        @endforeach
    </div>{{-- /prem-stat-grid --}}
    </div>{{-- /overflow-x wrapper --}}

    {{-- Tambah User Button (Atas, Kanan) --}}
    <div class="flex justify-end mb-4">
        <button type="button" onclick="openAddUserModal()"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#2e3746] hover:bg-[#1e2736] text-white text-sm font-semibold rounded-xl transition-colors shadow-sm shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah User
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        {{-- Search --}}
        <div class="md:col-span-2 relative">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama..."
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
        </div>

        {{-- Filter Perusahaan --}}
        <div class="relative">
            <select wire:model.live="company"
                class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white appearance-none transition-all">
                <option value="">Semua Perusahaan</option>
                @foreach($companies as $c)
                    <option value="{{ $c->id }}">{{ $c->nama_company }}</option>
                @endforeach
            </select>
        </div>

        @if($company)
            <div class="relative">
                <select wire:model.live="department"
                    class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white appearance-none transition-all">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $d)
                        <option value="{{ $d->nama_department }}">{{ $d->nama_department }}</option>
                    @endforeach
                </select>
            </div>
        @endif

    </div>

    <div class="flex flex-col gap-8 relative">
        <div wire:loading.flex class="absolute inset-0 z-10 hidden items-start justify-center pt-20 bg-white/40 backdrop-blur-[1px] rounded-2xl">
            <div class="animate-spin rounded-full h-10 w-10 border-4 border-gray-200 border-b-[#14b8a6]"></div>
        </div>

        @foreach($roleConfig as $roleKey => $cfg)
            @php
                $showRoleTable = isset($usersByRole[$roleKey]) && $usersByRole[$roleKey]->total() > 0;
            @endphp
            <div wire:key="table-wrapper-{{ $roleKey }}" class="{{ $showRoleTable ? 'block' : 'hidden' }}">
                @if($showRoleTable)
                    @php
                        $users = $usersByRole[$roleKey];
                        $showDepartmentAndPosition = !in_array($roleKey, ['finance', 'panelis']);
                        $showMultiRole = !in_array($roleKey, ['finance', 'panelis']);
                        $emptyStateColspan = 5 + ($showDepartmentAndPosition ? 2 : 0) + ($showMultiRole ? 1 : 0);
                    @endphp

                    <div class="border border-[#e2e8f0] rounded-2xl overflow-hidden shadow-sm bg-white">
                        <div class="relative flex items-center justify-center py-4 border-b-2"
                             style="border-bottom-color: {{ $cfg['hex'] }}; background-color: {{ $cfg['hex'] }}22;">
                            <div class="absolute left-4 flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg flex items-center justify-center bg-white/80 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-4 h-4" style="color: {{ $cfg['hex'] }}">
                                        {!! $roleIcons[$roleKey] !!}
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-500">{{ $users->total() }} pengguna</span>
                            </div>
                            <h3 class="text-sm font-bold tracking-widest uppercase" style="color: {{ $cfg['hex'] }}">{{ $cfg['label'] }}</h3>
                        </div>

                        <div class="overflow-x-auto user-management-wrapper">
                            <table class="prem-table">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Nama Lengkap</th>
                                        <th>Perusahaan</th>
                                        @if($showDepartmentAndPosition)
                                            <th>Departemen</th>
                                            <th>Posisi Saat Ini</th>
                                        @endif
                                        @if($showMultiRole)
                                            <th>Multi Role</th>
                                        @endif
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $u)
                                        <tr wire:key="user-row-{{ $roleKey }}-{{ $u->id }}" class="bg-white hover:bg-gray-50/80 transition-colors">
                                            <td class="px-4 py-3">
                                                <span class="block truncate max-w-[150px] text-sm font-medium text-[#475569]" title="{{ $u->username }}">
                                                    {{ $u->username }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="block truncate max-w-[180px] text-sm text-[#475569]" title="{{ $u->email }}">
                                                    {{ $u->email }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="block truncate max-w-[180px] text-sm font-semibold text-[#2e3746]" title="{{ $u->nama }}">
                                                    {{ $u->nama }}
                                                </span>
                                            </td>
                                            <td class="text-sm text-[#475569] px-4 py-3">{{ $u->company->nama_company ?? '—' }}</td>
                                            @if($showDepartmentAndPosition)
                                                <td class="text-sm text-[#475569] px-4 py-3">{{ $u->department->nama_department ?? '—' }}</td>
                                                <td class="text-sm text-[#475569] px-4 py-3">{{ $u->position->position_name ?? '—' }}</td>
                                            @endif
                                            @if($showMultiRole)
                                                <td class="px-4 py-3 text-center">
                                                    <button type="button"
                                                        onclick="openRoleModal({{ $u->id }}, {{ $u->roles->pluck('id') }})"
                                                        class="inline-flex items-center justify-center w-9 h-9 bg-[#F5A623] hover:bg-[#e0961e] rounded-lg transition-colors shadow-sm" title="Assign Role">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-white">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            @endif
                                            <td class="px-4 py-3">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button" onclick="openEditUserModal({{ $u->id }}, '{{ addslashes($u->username) }}', '{{ addslashes($u->nama) }}', '{{ addslashes($u->email) }}', '{{ $u->company_id }}', '{{ $u->department_id }}', '{{ $u->position_id }}')"
                                                        class="inline-flex items-center justify-center w-9 h-9 bg-white hover:bg-blue-50 text-slate-500 hover:text-blue-600 border border-slate-200 hover:border-blue-200 rounded-lg transition-colors shadow-sm" title="Edit Profile">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[23px] w-[23px]" viewBox="0 0 24 24">
                                                            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                            <path fill="currentColor" fill-opacity="0.25" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                                            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                                            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487L19.5 7.125" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" onclick="openDeleteModal({{ $u->id }})"
                                                        class="inline-flex items-center justify-center w-9 h-9 bg-[#EF4444] hover:bg-[#dc2626] rounded-lg transition-colors shadow-sm" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ $emptyStateColspan }}" class="py-10 text-center text-sm text-gray-400 italic">
                                                <div class="flex flex-col items-center gap-2">
                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: {{ $cfg['hex'] }}15;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                            class="w-5 h-5" style="color: {{ $cfg['hex'] }}66">
                                                            {!! $roleIcons[$roleKey] !!}
                                                        </svg>
                                                    </div>
                                                    <span>Tidak ada {{ $cfg['label'] }} ditemukan</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($users->hasPages())
                            <div class="px-6 py-4 border-t border-[#e2e8f0] bg-gray-50/50 flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    Menampilkan {{ $users->firstItem() }}&ndash;{{ $users->lastItem() }} dari {{ $users->total() }} pengguna
                                </span>
                                <div class="flex gap-1.5">
                                    {{ $users->links('livewire.pagination-simple') }}
                                </div>
                             </div>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

<style>
    /* ── User Management Table: Perjelas garis & judul kolom Capitalize ── */
    .user-management-wrapper .prem-table th {
        text-transform: none;
        letter-spacing: 0;
        font-size: 0.8rem;
        color: #1e293b;
        border-bottom: 2px solid #cbd5e1;
        border-right: 1px solid #d1d5db;
        background: #f1f5f9;
    }
    .user-management-wrapper .prem-table th:last-child {
        border-right: none;
    }
    .user-management-wrapper .prem-table td {
        border-bottom: 1px solid #d1d5db;
        border-right: 1px solid #e5e7eb;
    }
    .user-management-wrapper .prem-table td:last-child {
        border-right: none;
    }
    .user-management-wrapper .prem-table tbody tr:last-child td {
        border-bottom: 1px solid #d1d5db;
    }
</style>
