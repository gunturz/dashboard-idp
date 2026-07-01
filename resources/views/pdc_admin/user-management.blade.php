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

            /* ── User Management Table ── */
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

            /* Pagination design */
            .um-pagination-bar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 16px 24px;
                background-color: #f8fafc;
                border-top: 1px solid #e2e8f0;
            }
            .um-pagination-info {
                font-size: 13px;
                color: #64748b;
                font-weight: 500;
            }
            .um-pagination-controls {
                display: flex;
                align-items: center;
                gap: 6px;
            }
            .um-page-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 32px;
                height: 32px;
                padding: 0 12px;
                border-radius: 6px;
                background: #fff;
                border: 1px solid #e2e8f0;
                color: #64748b;
                font-size: 13px;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s;
            }
            .um-page-btn:hover:not(:disabled) {
                background: #f8fafc;
                border-color: #cbd5e1;
                color: #334155;
            }
            .um-page-active {
                background: #14b8a6 !important;
                border-color: #14b8a6 !important;
                color: #fff !important;
            }
            .um-page-btn:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }
        </style>
    </x-slot>

    {{-- Page Header --}}
    <div class="page-header animate-title mb-8">
        <div class="page-header-icon shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">User Management</div>
            <div class="page-header-sub">Kelola pengguna sistem, peran, dan pengaturan akses keamanan.</div>
        </div>
    </div>

    @if (session('success'))
        <div id="success-alert"
            class="flex items-center gap-3 mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @php
        $roleConfig = [
            'talent' => ['label' => 'Talent', 'color' => 'teal', 'hex' => '#14b8a6'],
            'mentor' => ['label' => 'Mentor', 'color' => 'blue', 'hex' => '#3b82f6'],
            'atasan' => ['label' => 'Atasan', 'color' => 'purple', 'hex' => '#a855f7'],
            'finance' => ['label' => 'Finance', 'color' => 'green', 'hex' => '#22c55e'],
            'panelis' => ['label' => 'Panelis', 'color' => 'amber', 'hex' => '#f59e0b'],
        ];

        $roleIcons = [
            'talent' => '<path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>',
            'mentor' => '<path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/><path d="M5.6 10.93a1 1 0 00-.919 1.488 4.12 4.12 0 00.302.39c.857.96 2.425 1.692 4.018 1.692 1.593 0 3.161-.732 4.018-1.692.115-.13.216-.26.302-.39A1 1 0 0014.4 10.93h-8.8z"/>',
            'atasan' => '<path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>',
            'finance' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>',
            'panelis' => '<path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>',
        ];

        $roleUsers = [
            'talent' => $talents,
            'mentor' => $mentors,
            'atasan' => $atasans,
            'finance' => $finances,
            'panelis' => $panelisUsers,
        ];
    @endphp

    {{-- Stats Cards --}}
    <div class="archive-stats-grid mb-8">
        @foreach ($roleConfig as $key => $cfg)
            <button type="button" class="archive-stat-card archive-stat-card--{{ $cfg['color'] }} cursor-pointer select-none focus:outline-none" id="card-{{ $key }}" onclick="selectRoleFilter('{{ $key }}')">
                <div class="archive-stat-icon archive-stat-icon--{{ $cfg['color'] }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        {!! $roleIcons[$key] !!}
                    </svg>
                </div>
                <div class="archive-stat-count" id="count-{{ $key }}">{{ $counts[ucfirst($key)] }}</div>
                <div class="archive-stat-label">{{ $cfg['label'] }}</div>
            </button>
        @endforeach
    </div>

    {{-- Filters --}}
    <div class="flex flex-col xl:flex-row items-start xl:items-center justify-between gap-4 mb-6">
        <div class="flex flex-col sm:flex-row w-full flex-1 gap-4">
            {{-- Search --}}
            <div class="relative w-full sm:flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="userSearchInput" placeholder="Cari Nama..." oninput="filterUsers()"
                    class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
            </div>

            {{-- Filter Perusahaan --}}
            <div class="relative w-full sm:w-56">
                <select id="userCompanyFilter" onchange="onCompanyFilterChange()"
                    class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white appearance-none transition-all"
                    style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                    <option value="">Semua Perusahaan</option>
                    @foreach ($companies as $c)
                        <option value="{{ $c->id }}">{{ $c->nama_company }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Departemen --}}
            <div class="relative w-full sm:w-56" id="deptFilterWrapper" style="display: none;">
                <select id="userDepartmentFilter" onchange="filterUsers()"
                    class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white appearance-none transition-all"
                    style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;">
                    <option value="">Semua Departemen</option>
                </select>
            </div>
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

    {{-- Tables Container --}}
    <div class="flex flex-col gap-8 relative user-management-wrapper">
        {{-- Global Empty State --}}
        <div id="globalEmptyState" class="empty-prem hidden" style="margin-top: 40px">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto" style="background:linear-gradient(135deg,#ccfbf1,#99f6e4)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    style="color: #0d9488; width: 32px; height: 32px; margin: 0;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>
            <h3 id="globalEmptyTitle">Tidak Ada Data User</h3>
            <p id="globalEmptyDesc">Tidak ada data user yang cocok dengan pencarian atau filter yang dipilih.</p>
        </div>

        @foreach ($roleConfig as $roleKey => $cfg)
            @php
                $users = $roleUsers[$roleKey];
                $showDepartmentAndPosition = !in_array($roleKey, ['finance', 'panelis']);
                $showMultiRole = !in_array($roleKey, ['finance', 'panelis']);
                $emptyStateColspan = 5 + ($showDepartmentAndPosition ? 2 : 0) + ($showMultiRole ? 1 : 0);
            @endphp
            
            <div id="wrapper-{{ $roleKey }}" class="role-table-wrapper border border-[#e2e8f0] rounded-2xl overflow-hidden shadow-sm bg-white mb-6">
                <div class="relative flex items-center justify-center py-4 border-b-2"
                    style="border-bottom-color: {{ $cfg['hex'] }}; background-color: {{ $cfg['hex'] }}22;">
                    <div class="absolute left-4 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center bg-white/80 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-4 h-4" style="color: {{ $cfg['hex'] }}">
                                {!! $roleIcons[$roleKey] !!}
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-500" id="badge-count-{{ $roleKey }}">{{ $users->count() }} pengguna</span>
                    </div>
                    <h3 class="text-sm font-bold tracking-widest uppercase" style="color: {{ $cfg['hex'] }}">
                        {{ $cfg['label'] }}</h3>
                </div>

                <div class="overflow-x-auto">
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
                        <tbody id="tbody-{{ $roleKey }}">
                            @forelse($users as $u)
                                <tr class="user-row" 
                                    data-id="{{ $u->id }}"
                                    data-name="{{ strtolower($u->nama) }}"
                                    data-username="{{ strtolower($u->username) }}"
                                    data-company="{{ $u->company_id }}"
                                    data-department="{{ $u->department->nama_department ?? '' }}"
                                    data-role="{{ $roleKey }}">
                                    <td class="px-4 py-3 text-center">
                                        <span class="block truncate max-w-[150px] mx-auto text-sm font-medium text-[#475569]" title="{{ $u->username }}">
                                            {{ $u->username }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="block truncate max-w-[180px] mx-auto text-sm text-[#475569]" title="{{ $u->email }}">
                                            {{ $u->email }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="block truncate max-w-[180px] mx-auto text-sm font-semibold text-[#2e3746]" title="{{ $u->nama }}">
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
                                <tr class="empty-row-placeholder">
                                    <td colspan="{{ $emptyStateColspan }}"
                                        class="py-10 text-center text-sm text-gray-400 italic">
                                        Belum ada data {{ strtolower($cfg['label']) }}.
                                    </td>
                                </tr>
                            @endforelse
                            <tr class="empty-row-filtered hidden">
                                <td colspan="{{ $emptyStateColspan }}"
                                    class="py-10 text-center text-sm text-gray-400 italic">
                                    Tidak ada data {{ strtolower($cfg['label']) }} yang cocok dengan pencarian atau filter.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination controls --}}
                <div class="um-pagination-bar" id="pagination-bar-{{ $roleKey }}">
                    <span class="um-pagination-info" id="pagination-info-{{ $roleKey }}"></span>
                    <div class="um-pagination-controls" id="pagination-controls-{{ $roleKey }}"></div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ════════════════════════════════════════════════ --}}
    {{-- Tambah User Modal --}}
    {{-- ════════════════════════════════════════════════ --}}
    <div id="addUserModal" class="fixed inset-0 z-[100] items-center justify-center p-4 hidden"
        style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);">
        <div
            class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all flex flex-col max-h-[92vh]">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-[#2e3746] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#2e3746]">Tambah User Baru</h3>
                </div>
                <button type="button" onclick="closeAddUserModal()"
                    class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mx-6 mt-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Body --}}
            <form id="addUserForm" method="POST" action="{{ route('pdc_admin.user.store') }}"
                class="overflow-y-auto flex-1" autocomplete="off">
                @csrf
                <div class="px-6 py-5 space-y-4">

                    {{-- Username --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Username</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <input type="text" name="username" value="{{ old('username') }}"
                                placeholder="Masukan username" required autocomplete="off"
                                class="w-full border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Email</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukan email"
                                required
                                class="w-full border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Password</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <input type="password" id="add_password" name="password" placeholder="Masukan password"
                                required autocomplete="new-password"
                                class="w-full border border-gray-200 rounded-xl py-2.5 pl-10 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
                            <button type="button" onclick="toggleAddPassword('add_password', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg class="eye-open h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg class="eye-closed h-4 w-4 hidden" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Minimal 8 karakter, mengandung huruf kapital dan angka.
                        </p>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <input type="password" id="add_password_confirmation" name="password_confirmation"
                                placeholder="Konfirmasi password" required autocomplete="new-password"
                                class="w-full border border-gray-200 rounded-xl py-2.5 pl-10 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
                            <button type="button" onclick="toggleAddPassword('add_password_confirmation', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg class="eye-open h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg class="eye-closed h-4 w-4 hidden" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                placeholder="Masukan nama lengkap" required
                                class="w-full border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
                        </div>
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#2e3746] mb-1.5">Role</label>
                        <select name="role_id" id="add_role_id" required onchange="handleAddRoleChange(this)"
                            class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white appearance-none transition-all">
                            <option value="" disabled {{ old('role_id') ? '' : 'selected' }}>Pilih role</option>
                            @foreach ($rolesData as $rl)
                                @if (!in_array(strtolower($rl->role_name), ['admin', 'pdc admin', 'pdc_admin']))
                                    <option value="{{ $rl->id }}" data-rolename="{{ $rl->role_name }}"
                                        {{ old('role_id') == $rl->id ? 'selected' : '' }}>
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
                            @foreach ($companies as $c)
                                <option value="{{ $c->id }}"
                                    {{ old('company_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->nama_company }}</option>
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
                            @foreach ($positions as $pos)
                                <option value="{{ $pos->id }}"
                                    {{ old('position_id') == $pos->id ? 'selected' : '' }}>
                                    {{ $pos->position_name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- Footer Buttons --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 shrink-0">
                    <button type="button" onclick="closeAddUserModal()"
                        class="px-5 py-2.5 text-sm font-medium text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-bold text-white bg-[#2e3746] rounded-xl hover:bg-[#1e2736] transition-colors shadow-sm">
                        + Tambah User
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Role Assignment Modal --}}
    <div id="roleModal" class="fixed inset-0 z-[100] items-center justify-center p-4 hidden"
        style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80">
                <h3 class="text-lg font-bold text-[#2e3746]">Assign Role</h3>
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
                            @if (!in_array(strtolower($roleData->role_name), ['admin', 'pdc admin', 'pdc_admin', 'finance', 'panelis']))
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

    {{-- Edit User Modal --}}
    <div id="editUserModal" class="fixed inset-0 z-[100] items-center justify-center p-4 hidden"
        style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);">
        <div
            class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden transform transition-all flex flex-col max-h-[90vh]">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80">
                <h3 id="editUserModalTitle" class="text-lg font-bold text-[#2e3746]">Edit Profile Talent</h3>
                <button type="button" onclick="closeEditUserModal()"
                    class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
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
                            <input type="text" name="username" id="edit_username"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#14b8a6] focus:border-[#14b8a6]"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama" id="edit_nama"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#14b8a6] focus:border-[#14b8a6]"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="edit_email"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#14b8a6] focus:border-[#14b8a6]"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Perusahaan</label>
                            <select name="company_id" id="edit_company_id"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#14b8a6] focus:border-[#14b8a6]"
                                onchange="updateDepartmentsDropdown()" required>
                                <option value="">Pilih Perusahaan</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->nama_company }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="edit-dept-pos-fields">
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Departemen</label>
                                <select name="department_id" id="edit_department_id"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#14b8a6] focus:border-[#14b8a6]">
                                    <option value="">Pilih Departemen</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Posisi Saat Ini</label>
                                <select name="position_id" id="edit_position_id"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#14b8a6] focus:border-[#14b8a6]">
                                    <option value="">Pilih Posisi</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->position_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keamanan</label>
                    <button type="button" onclick="triggerResetPassword()"
                        class="px-4 py-2 bg-[#fef3c7] text-[#d97706] hover:bg-[#fde68a] font-medium rounded-xl text-sm transition-colors flex items-center gap-2">
                        <!-- Key inside a refresh circle -->
                        <div class="relative w-5 h-5 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-5 h-5 opacity-40"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-3.5 h-3.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                        Reset Password
                    </button>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 shrink-0">
                <button type="button" onclick="closeEditUserModal()"
                    class="px-5 py-2.5 text-sm font-medium text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batal</button>
                <button type="button" onclick="document.getElementById('editUserForm').submit()"
                    class="px-5 py-2.5 text-sm font-bold text-white bg-[#14b8a6] rounded-xl hover:bg-[#0d9488] transition-colors shadow-sm">Simpan</button>
            </div>
        </div>
    </div>

    {{-- Reset Password Modal --}}
    <div id="resetPasswordModal" class="fixed inset-0 z-[100] items-center justify-center p-4 hidden"
        style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);">
        <form id="resetPasswordForm" method="POST" action="" class="w-full max-w-[400px]">
            @csrf
            <div
                class="bg-white rounded-2xl w-full shadow-2xl p-8 flex flex-col items-center text-center transform transition-all">
                <div class="w-20 h-20 rounded-full bg-[#E5B224] flex items-center justify-center mb-5">
                    <span class="text-white text-5xl font-bold">!</span>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Konfirmasi</h3>
                <p class="text-gray-900 text-[15px] mb-8">Apakah Anda yakin untuk mereset password user ini menjadi
                    "Password123"?</p>
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
    <div id="deleteModal" class="fixed inset-0 z-[100] items-center justify-center p-4 hidden"
        style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);">
        <form id="deleteForm" method="POST" action="" class="w-full max-w-[400px]">
            @csrf
            @method('DELETE')
            <div
                class="bg-white rounded-2xl w-full flex flex-col items-center shadow-2xl p-8 text-center transform transition-all">
                <div class="w-16 h-16 rounded-full bg-[#EF4444] flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Hapus User?</h3>
                <p class="text-gray-500 text-[15px] mb-8">Data user ini akan dihapus secara permanen dan tidak dapat
                    dikembalikan.</p>
                <div class="flex gap-4 w-full">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 py-3 px-4 text-sm font-semibold text-[#475569] bg-[#F4F1EA] rounded-xl hover:bg-[#eadecc] transition-colors">Batalkan</button>
                    <button type="submit"
                        class="flex-1 py-3 px-4 text-sm font-bold text-white bg-[#EF4444] rounded-xl hover:bg-[#dc2626] transition-colors shadow-sm">Ya,
                        Hapus</button>
                </div>
            </div>
        </form>
    </div>

    <x-slot name="scripts">
        <script>
            // ── Client-side User Management Filtering & Pagination ──
            const departmentsByCompany = @json($departmentsByCompany);
            const ITEMS_PER_PAGE = 7;
            
            let selectedRole = ''; // Currently selected role filter from stats cards
            let currentPages = {
                talent: 1,
                mentor: 1,
                atasan: 1,
                finance: 1,
                panelis: 1
            };
            
            // Map of filtered rows for each role
            let filteredRowsByRole = {
                talent: [],
                mentor: [],
                atasan: [],
                finance: [],
                panelis: []
            };

            function selectRoleFilter(roleKey) {
                const card = document.getElementById(`card-${roleKey}`);
                if (selectedRole === roleKey) {
                    selectedRole = '';
                    card.classList.remove('archive-stat-card--active');
                } else {
                    // Remove active class from all cards
                    document.querySelectorAll('.archive-stat-card').forEach(c => c.classList.remove('archive-stat-card--active'));
                    selectedRole = roleKey;
                    card.classList.add('archive-stat-card--active');
                }
                // Reset page for this role
                if (roleKey) currentPages[roleKey] = 1;
                filterUsers();
            }

            function onCompanyFilterChange() {
                const companyId = document.getElementById('userCompanyFilter').value;
                const deptSelect = document.getElementById('userDepartmentFilter');
                const deptWrapper = document.getElementById('deptFilterWrapper');

                deptSelect.innerHTML = '<option value="">Semua Departemen</option>';

                if (!companyId) {
                    deptWrapper.style.display = 'none';
                } else {
                    const depts = departmentsByCompany[companyId] || [];
                    if (depts.length > 0) {
                        depts.forEach(dept => {
                            const option = document.createElement('option');
                            option.value = dept.nama_department;
                            option.textContent = dept.nama_department;
                            deptSelect.appendChild(option);
                        });
                        deptWrapper.style.display = 'block';
                    } else {
                        deptWrapper.style.display = 'none';
                    }
                }
                // Reset page numbers
                Object.keys(currentPages).forEach(k => currentPages[k] = 1);
                filterUsers();
            }

            function filterUsers() {
                const search = document.getElementById('userSearchInput').value.toLowerCase().trim();
                const companyId = document.getElementById('userCompanyFilter').value;
                const deptName = document.getElementById('userDepartmentFilter').value.toLowerCase().trim();

                // Clear lists of filtered rows
                Object.keys(filteredRowsByRole).forEach(k => filteredRowsByRole[k] = []);

                let totalVisibleUsers = 0;

                // Process each role wrapper
                document.querySelectorAll('.role-table-wrapper').forEach(wrapper => {
                    const roleKey = wrapper.id.replace('wrapper-', '');
                    
                    // Visibility based on selectedRole
                    const isRoleActive = (selectedRole === '' || selectedRole === roleKey);
                    
                    if (!isRoleActive) {
                        wrapper.classList.add('hidden');
                        return;
                    }

                    // Filter row by row
                    const tbody = document.getElementById(`tbody-${roleKey}`);
                    const rows = tbody.querySelectorAll('.user-row');
                    const emptyPlaceholder = tbody.querySelector('.empty-row-placeholder');
                    const emptyFiltered = tbody.querySelector('.empty-row-filtered');
                    
                    rows.forEach(row => {
                        row.classList.add('hidden'); // Hide all first
                        
                        const name = row.getAttribute('data-name') || '';
                        const username = row.getAttribute('data-username') || '';
                        const company = row.getAttribute('data-company') || '';
                        const department = (row.getAttribute('data-department') || '').toLowerCase();

                        const matchSearch = search === '' || name.includes(search) || username.includes(search);
                        const matchCompany = companyId === '' || company === companyId;
                        const matchDept = deptName === '' || department.includes(deptName);

                        if (matchSearch && matchCompany && matchDept) {
                            filteredRowsByRole[roleKey].push(row);
                        }
                    });

                    const totalMatching = filteredRowsByRole[roleKey].length;
                    totalVisibleUsers += totalMatching;

                    // Update counts & visibility
                    document.getElementById(`badge-count-${roleKey}`).textContent = `${totalMatching} pengguna`;

                    if (totalMatching === 0) {
                        wrapper.classList.remove('hidden');
                        if (emptyPlaceholder) emptyPlaceholder.classList.add('hidden');
                        if (emptyFiltered) emptyFiltered.classList.remove('hidden');
                        document.getElementById(`pagination-bar-${roleKey}`).classList.add('hidden');
                    } else {
                        wrapper.classList.remove('hidden');
                        if (emptyPlaceholder) emptyPlaceholder.classList.add('hidden');
                        if (emptyFiltered) emptyFiltered.classList.add('hidden');
                        
                        // Paginate this role's table
                        paginateRole(roleKey);
                    }
                });

                // Update global empty state
                const globalEmpty = document.getElementById('globalEmptyState');
                if (totalVisibleUsers === 0) {
                    globalEmpty.classList.remove('hidden');
                    // Hide all wrappers
                    document.querySelectorAll('.role-table-wrapper').forEach(w => w.classList.add('hidden'));
                } else {
                    globalEmpty.classList.add('hidden');
                }
            }

            function paginateRole(role) {
                const rows = filteredRowsByRole[role];
                const total = rows.length;
                const totalPages = Math.ceil(total / ITEMS_PER_PAGE);
                
                // Ensure current page is in valid range
                if (currentPages[role] < 1) currentPages[role] = 1;
                if (currentPages[role] > totalPages) currentPages[role] = totalPages;
                
                const currentPage = currentPages[role];
                const start = (currentPage - 1) * ITEMS_PER_PAGE;
                const end = Math.min(start + ITEMS_PER_PAGE, total);

                // Show only current page rows
                rows.forEach((row, index) => {
                    if (index >= start && index < end) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });

                // Update pagination controls
                const paginationBar = document.getElementById(`pagination-bar-${role}`);
                const paginationInfo = document.getElementById(`pagination-info-${role}`);
                const paginationCtrls = document.getElementById(`pagination-controls-${role}`);

                if (total > ITEMS_PER_PAGE) {
                    paginationBar.classList.remove('hidden');
                    paginationInfo.textContent = `Menampilkan ${start + 1}–${end} dari ${total} pengguna`;

                    let html = '';
                    // Prev Button
                    html += `<button type="button" class="um-page-btn" ${currentPage === 1 ? 'disabled' : ''} onclick="changeRolePage('${role}', ${currentPage - 1})">&laquo; Prev</button>`;

                    // Pages buttons
                    for (let p = 1; p <= totalPages; p++) {
                        // show at most 5 buttons around current page
                        if (totalPages > 5) {
                            if (p < currentPage - 2 || p > currentPage + 2) {
                                if (p === 1) {
                                    html += `<button type="button" class="um-page-btn" onclick="changeRolePage('${role}', 1)">1</button>`;
                                    html += `<span class="px-1 text-gray-400">...</span>`;
                                } else if (p === totalPages) {
                                    html += `<span class="px-1 text-gray-400">...</span>`;
                                    html += `<button type="button" class="um-page-btn" onclick="changeRolePage('${role}', ${totalPages})">${totalPages}</button>`;
                                }
                                continue;
                            }
                        }
                        html += `<button type="button" class="um-page-btn ${p === currentPage ? 'um-page-active' : ''}" onclick="changeRolePage('${role}', ${p})">${p}</button>`;
                    }

                    // Next Button
                    html += `<button type="button" class="um-page-btn" ${currentPage === totalPages ? 'disabled' : ''} onclick="changeRolePage('${role}', ${currentPage + 1})">Next &raquo;</button>`;

                    paginationCtrls.innerHTML = html;
                } else {
                    paginationBar.classList.add('hidden');
                }
            }

            function changeRolePage(role, page) {
                currentPages[role] = page;
                filterUsers();
                // scroll to role header
                document.getElementById(`wrapper-${role}`).scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

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

            function openEditUserModal(userId, username, nama, email, companyId, departmentId, positionId, roleKey) {
                currentEditUserId = userId;
                const form = document.getElementById('editUserForm');
                form.action = `/pdc-admin/user/${userId}`;

                document.getElementById('editUserModalTitle').textContent = `Edit Profile ${nama || 'User'}`;

                document.getElementById('edit_username').value = username || '';
                document.getElementById('edit_nama').value = nama || '';
                document.getElementById('edit_email').value = email || '';
                document.getElementById('edit_company_id').value = companyId || '';

                // Sembunyikan Departemen & Posisi untuk Finance dan Panelis
                const isFinanceOrPanelis = ['finance', 'panelis', 'bo_director', 'board_of_directors', 'board_of_director']
                    .includes((roleKey || '').toLowerCase());
                const deptPosFields = document.getElementById('edit-dept-pos-fields');
                if (deptPosFields) {
                    deptPosFields.style.display = isFinanceOrPanelis ? 'none' : 'block';
                }

                if (!isFinanceOrPanelis) {
                    updateDepartmentsDropdown(departmentId);
                    document.getElementById('edit_position_id').value = positionId || '';
                } else {
                    // Kosongkan nilainya agar tidak terkirim ke backend
                    const deptSel = document.getElementById('edit_department_id');
                    if (deptSel) {
                        deptSel.innerHTML = '<option value="">Pilih Departemen</option>';
                    }
                    const posSel = document.getElementById('edit_position_id');
                    if (posSel) posSel.value = '';
                }

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
                    cb.checked = Array.isArray(currentRoleIds) ?
                        currentRoleIds.includes(parseInt(cb.value)) :
                        false;
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

                @if (!$errors->any())
                    // Jika tidak ada error (bukan dari submit gagal), bersihkan isi form
                    form.reset();
                    // Pastikan departemen kosong
                    document.getElementById('add_department_id').innerHTML =
                        '<option value="" disabled selected>Pilih departemen</option>';
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
            @if ($errors->any() && old('_token'))
                document.addEventListener('DOMContentLoaded', () => openAddUserModal());
            @endif

            function handleAddRoleChange(select) {
                const roleName = (select.options[select.selectedIndex].dataset.rolename || '').toLowerCase();
                const isFinanceOrPanelis = roleName === 'finance' || roleName === 'panelis' || roleName === 'bo_director' ||
                    roleName === 'board_of_directors' || roleName === 'board_of_director';

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
                    .finally(() => {
                        deptSelect.disabled = false;
                    });
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

                const alert = document.getElementById('success-alert');
                if (alert) {
                    setTimeout(function() {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        setTimeout(function() {
                            alert.remove();
                        }, 500);
                    }, 3000);
                }
                
                // Initialize client-side filtering & pagination
                filterUsers();
            });
        </script>
    </x-slot>
</x-pdc_admin.layout>
