<div x-data>
    @php
        $roleConfig = [
            'talent' => ['label' => 'Talent', 'color' => 'teal', 'hex' => '#14b8a6'],
            'mentor' => ['label' => 'Mentor', 'color' => 'blue', 'hex' => '#3b82f6'],
            'atasan' => ['label' => 'Atasan', 'color' => 'purple', 'hex' => '#a855f7'],
            'finance' => ['label' => 'Finance', 'color' => 'green', 'hex' => '#22c55e'],
            'panelis' => ['label' => 'Panelis', 'color' => 'amber', 'hex' => '#f59e0b'],
        ];

        $roleIcons = [
            'talent' =>
                '<path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>',
            'mentor' =>
                '<path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/><path d="M5.6 10.93a1 1 0 00-.919 1.488 4.12 4.12 0 00.302.39c.857.96 2.425 1.692 4.018 1.692 1.593 0 3.161-.732 4.018-1.692.115-.13.216-.26.302-.39A1 1 0 0014.4 10.93h-8.8z"/>',
            'atasan' =>
                '<path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>',
            'finance' =>
                '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>',
            'panelis' =>
                '<path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>',
        ];
    @endphp

    <div>
        <style>
            /* ── Archive Stats Cards (Aligned with progress-archive) ── */
            .archive-stats-grid {
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 16px;
            }

            @media (max-width: 1100px) {
                .archive-stats-grid {
                    grid-template-columns: repeat(3, 1fr);
                }
            }

            @media (max-width: 640px) {
                .archive-stats-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            .archive-stat-card {
                background: #fff;
                border-radius: 16px;
                padding: 20px 18px 16px;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
                gap: 10px;
                border: 1.5px solid #e2e8f0;
                box-shadow: 0 1px 4px rgba(0,0,0,0.06);
                position: relative;
                overflow: hidden;
                transition: transform .18s, box-shadow .18s, border-color .18s, background-color .18s;
                width: 100%;
                outline: none !important;
            }

            .archive-stat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 18px rgba(0,0,0,0.10);
            }

            /* top accent bar */
            .archive-stat-card::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 4px;
                border-radius: 16px 16px 0 0;
            }

            .archive-stat-card--teal::before   { background: linear-gradient(90deg,#14b8a6,#0d9488); }
            .archive-stat-card--blue::before   { background: linear-gradient(90deg,#3b82f6,#2563eb); }
            .archive-stat-card--purple::before { background: linear-gradient(90deg,#8b5cf6,#a78bfa); }
            .archive-stat-card--green::before  { background: linear-gradient(90deg,#22c55e,#16a34a); }
            .archive-stat-card--amber::before  { background: linear-gradient(90deg,#f59e0b,#fcd34d); }

            .archive-stat-icon {
                width: 38px;
                height: 38px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .archive-stat-icon svg {
                width: 20px;
                height: 20px;
            }

            /* icon colors */
            .archive-stat-icon--teal   { background: #ccfbf1; color: #0d9488; }
            .archive-stat-icon--blue   { background: #dbeafe; color: #2563eb; }
            .archive-stat-icon--purple { background: #f5f3ff; color: #8b5cf6; }
            .archive-stat-icon--green  { background: #dcfce7; color: #16a34a; }
            .archive-stat-icon--amber  { background: #fef3c7; color: #d97706; }

            .archive-stat-count {
                font-size: 2rem;
                font-weight: 800;
                color: #0f172a;
                line-height: 1;
            }

            .archive-stat-label {
                font-size: 0.78rem;
                color: #64748b;
                font-weight: 500;
                line-height: 1.3;
            }

            /* ── Active / Selected state ── */
            .archive-stat-card--active {
                transform: translateY(-3px);
            }
            .archive-stat-card--teal.archive-stat-card--active {
                border-color: #14b8a6;
                box-shadow: 0 0 0 3px rgba(20,184,166,0.18), 0 6px 20px rgba(20,184,166,0.15);
                background: #f0fdfb;
            }
            .archive-stat-card--blue.archive-stat-card--active {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59,130,246,0.18), 0 6px 20px rgba(59,130,246,0.15);
                background: #eff6ff;
            }
            .archive-stat-card--purple.archive-stat-card--active {
                border-color: #8b5cf6;
                box-shadow: 0 0 0 3px rgba(139,92,246,0.18), 0 6px 20px rgba(139,92,246,0.15);
                background: #faf5ff;
            }
            .archive-stat-card--green.archive-stat-card--active {
                border-color: #22c55e;
                box-shadow: 0 0 0 3px rgba(34,197,94,0.18), 0 6px 20px rgba(34,197,94,0.15);
                background: #f0fdf4;
            }
            .archive-stat-card--amber.archive-stat-card--active {
                border-color: #f59e0b;
                box-shadow: 0 0 0 3px rgba(245,158,11,0.18), 0 6px 20px rgba(245,158,11,0.15);
                background: #fffbeb;
            }
            .archive-stat-card--active .archive-stat-count {
                color: #0f172a;
            }
        </style>

        <div class="archive-stats-grid mb-8">
            @foreach ($roleConfig as $key => $cfg)
                <button type="button" wire:key="stat-{{ $key }}"
                    x-on:click="$wire.selectedRole = ($wire.selectedRole === '{{ $key }}' ? '' : '{{ $key }}')"
                    wire:loading.delay.attr="disabled" wire:target="selectedRole"
                    class="archive-stat-card archive-stat-card--{{ $cfg['color'] }} cursor-pointer select-none disabled:cursor-wait disabled:opacity-90 focus:outline-none {{ $selectedRole === $key ? 'archive-stat-card--active' : '' }}"
                    x-bind:class="{ 'archive-stat-card--active': $wire.selectedRole === '{{ $key }}' }">
                    <div class="archive-stat-icon archive-stat-icon--{{ $cfg['color'] }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            {!! $roleIcons[$key] !!}
                        </svg>
                    </div>
                    <div class="archive-stat-count">{{ $counts[$cfg['label']] }}</div>
                    <div class="archive-stat-label">{{ $cfg['label'] }}</div>
                </button>
            @endforeach
        </div>
    </div>

    <div class="flex flex-col xl:flex-row items-start xl:items-center justify-between gap-4 mb-6">
        <div class="flex flex-col sm:flex-row w-full flex-1 gap-4">
            {{-- Search --}}
            <div class="relative w-full sm:flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama..."
                    class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
            </div>

            {{-- Filter Perusahaan --}}
            <div class="relative w-full sm:w-56">
                <select wire:model.live="company"
                    class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white appearance-none transition-all"
                    style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                    <option value="">Semua Perusahaan</option>
                    @foreach ($companies as $c)
                        <option value="{{ $c->id }}">{{ $c->nama_company }}</option>
                    @endforeach
                </select>
            </div>

            @if ($company)
                <div class="relative w-full sm:w-56">
                    <select wire:model.live="department"
                        class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white appearance-none transition-all"
                        style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                        <option value="">Semua Departemen</option>
                        @foreach ($departments as $d)
                            <option value="{{ $d->nama_department }}">{{ $d->nama_department }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        {{-- Tambah User Button (Atas, Kanan) --}}
        <button type="button" onclick="openAddUserModal()"
            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#2e3746] hover:bg-[#1e2736] text-white text-sm font-semibold rounded-xl transition-colors shadow-sm shrink-0 w-full xl:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah User
        </button>
    </div>

    <div class="flex flex-col gap-8 relative">
        <div wire:loading.delay.flex wire:target="selectedRole,search,company,department,nextPage,previousPage,gotoPage"
            class="absolute inset-0 z-10 hidden items-start justify-center pt-20 bg-white/40 backdrop-blur-[1px] rounded-2xl">
            <div class="animate-spin rounded-full h-10 w-10 border-4 border-gray-200 border-b-[#14b8a6]"></div>
        </div>

        @php
            $totalUsers = 0;
            foreach ($roleConfig as $roleKey => $cfg) {
                if (isset($usersByRole[$roleKey])) {
                    $totalUsers += $usersByRole[$roleKey]->total();
                }
            }
        @endphp

        @if ($totalUsers === 0)
            <div class="empty-prem" style="margin-top: 40px">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto" style="background:linear-gradient(135deg,#ccfbf1,#99f6e4)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        style="color: #0d9488; width: 32px; height: 32px; margin: 0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <h3>{{ $search || $company || $department || $selectedRole ? 'Tidak Ada Data User' : 'Belum Ada Data User' }}</h3>
                <p>{{ $search || $company || $department || $selectedRole ? 'Tidak ada data user yang cocok dengan pencarian atau filter yang dipilih.' : 'Belum ada data pengguna yang terdaftar.' }}</p>
            </div>
        @endif

        @foreach ($roleConfig as $roleKey => $cfg)
            @php
                $showRoleTable = isset($usersByRole[$roleKey]) && $usersByRole[$roleKey]->total() > 0;
            @endphp
            <div wire:key="table-wrapper-{{ $roleKey }}" class="{{ $showRoleTable ? 'block' : 'hidden' }}">
                @if ($showRoleTable)
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
                            <h3 class="text-sm font-bold tracking-widest uppercase" style="color: {{ $cfg['hex'] }}">
                                {{ $cfg['label'] }}</h3>
                        </div>

                        <div class="overflow-x-auto user-management-wrapper">
                            <table class="prem-table">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Nama Lengkap</th>
                                        <th>Perusahaan</th>
                                        @if ($showDepartmentAndPosition)
                                            <th>Departemen</th>
                                            <th>Posisi Saat Ini</th>
                                        @endif
                                        @if ($showMultiRole)
                                            <th>Multi Role</th>
                                        @endif
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $u)
                                        <tr wire:key="user-row-{{ $roleKey }}-{{ $u->id }}"
                                            class="bg-white hover:bg-gray-50/80 transition-colors">
                                            <td class="px-4 py-3 text-center">
                                                <span
                                                    class="block truncate max-w-[150px] mx-auto text-sm font-medium text-[#475569]"
                                                    title="{{ $u->username }}">
                                                    {{ $u->username }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span
                                                    class="block truncate max-w-[180px] mx-auto text-sm text-[#475569]"
                                                    title="{{ $u->email }}">
                                                    {{ $u->email }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span
                                                    class="block truncate max-w-[180px] mx-auto text-sm font-semibold text-[#2e3746]"
                                                    title="{{ $u->nama }}">
                                                    {{ $u->nama }}
                                                </span>
                                            </td>
                                            <td class="text-sm text-[#475569] px-4 py-3 text-center">
                                                {{ $u->company->nama_company ?? '—' }}</td>
                                            @if ($showDepartmentAndPosition)
                                                <td class="text-sm text-[#475569] px-4 py-3 text-center">
                                                    {{ $u->department->nama_department ?? '—' }}</td>
                                                <td class="text-sm text-[#475569] px-4 py-3 text-center">
                                                    {{ $u->position->position_name ?? '—' }}</td>
                                            @endif
                                            @if ($showMultiRole)
                                                <td class="px-4 py-3 text-center">
                                                    <button type="button"
                                                        onclick="openRoleModal({{ $u->id }}, {{ $u->roles->pluck('id') }})"
                                                        class="inline-flex items-center justify-center w-9 h-9 bg-[#F5A623] hover:bg-[#e0961e] rounded-lg transition-colors shadow-sm"
                                                        title="Assign Role">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-4 h-4 text-white">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            @endif
                                            <td class="px-4 py-3">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button"
                                                        onclick="openEditUserModal({{ $u->id }}, '{{ addslashes($u->username) }}', '{{ addslashes($u->nama) }}', '{{ addslashes($u->email) }}', '{{ $u->company_id }}', '{{ $u->department_id }}', '{{ $u->position_id }}', '{{ $roleKey }}')"
                                                        class="inline-flex items-center justify-center w-9 h-9 bg-blue-500 hover:bg-blue-600 border border-blue-600 hover:border-blue-700 rounded-lg transition-colors shadow-sm"
                                                        title="Edit Profile">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4 text-white" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                        onclick="openDeleteModal({{ $u->id }})"
                                                        class="inline-flex items-center justify-center w-9 h-9 bg-[#EF4444] hover:bg-[#dc2626] rounded-lg transition-colors shadow-sm"
                                                        title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4 text-white" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ $emptyStateColspan }}"
                                                class="py-10 text-center text-sm text-gray-400 italic">
                                                <div class="flex flex-col items-center gap-2">
                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center"
                                                        style="background-color: {{ $cfg['hex'] }}15;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5"
                                                            style="color: {{ $cfg['hex'] }}66">
                                                            {!! $roleIcons[$roleKey] !!}
                                                        </svg>
                                                    </div>
                                                    <span>{{ $search || $company || $department ? 'Tidak ada data ' . strtolower($cfg['label']) . ' yang cocok dengan pencarian atau filter yang dipilih.' : 'Belum ada data ' . strtolower($cfg['label']) . '.' }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($users->hasPages())
                            <div
                                class="px-6 py-4 border-t border-[#e2e8f0] bg-gray-50/50 flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    Menampilkan {{ $users->firstItem() }}&ndash;{{ $users->lastItem() }} dari
                                    {{ $users->total() }} pengguna
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

    <style>
        /* ── User Management Table: Perjelas garis & judul kolom Capitalize ── */
        .user-management-wrapper .prem-table th {
            text-transform: none;
            letter-spacing: 0;
            font-size: 0.8rem;
            color: #1e293b;
            border-bottom: 2px solid #cbd5e1;
            background: #f1f5f9;
        }

        .user-management-wrapper .prem-table td {
            border-bottom: 1px solid #d1d5db;
        }

        .user-management-wrapper .prem-table tbody tr:last-child td {
            border-bottom: 1px solid #d1d5db;
        }
    </style>
</div>
