<x-pdc_admin.layout title="Panelis Review – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* ── Summary Cards ── */
            .panelis-stat-card {
                border-radius: 16px;
                padding: 20px 24px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                border: 2px solid;
                background: white;
                min-width: 160px;
                flex: 1;
            }

            .panelis-stat-card.teal  { border-color: #14b8a6; }
            .panelis-stat-card.amber { border-color: #f59e0b; }
            .panelis-stat-card.green { border-color: #22c55e; }
            .panelis-stat-num {
                font-size: 2.5rem;
                font-weight: 800;
                line-height: 1;
                margin-bottom: 6px;
            }
            .panelis-stat-card.teal  .panelis-stat-num { color: #14b8a6; }
            .panelis-stat-card.amber .panelis-stat-num { color: #f59e0b; }
            .panelis-stat-card.green .panelis-stat-num { color: #22c55e; }
            .panelis-stat-label {
                font-size: 0.8rem;
                color: #64748b;
                font-weight: 500;
                line-height: 1.3;
            }

            /* ── Filters ── */
            .panelis-filter-input,
            .panelis-filter-select {
                height: 40px;
                padding: 0 12px;
                border: 1.5px solid #e2e8f0;
                border-radius: 10px;
                font-size: 0.85rem;
                color: #334155;
                background: white;
                outline: none;
                transition: border-color 0.2s, box-shadow 0.2s;
                font-family: 'Poppins', sans-serif;
            }
            .panelis-filter-input:focus,
            .panelis-filter-select:focus {
                border-color: #14b8a6;
                box-shadow: 0 0 0 3px rgba(20,184,166,0.12);
            }
            .panelis-filter-select {
                padding-right: 32px;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 10px center;
                background-size: 16px;
            }

            /* ── Company Section ── */
            .company-header {
                font-size: 1.05rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 10px;
                margin-top: 28px;
                padding-left: 4px;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .company-header::before {
                content: '';
                display: inline-block;
                width: 4px;
                height: 18px;
                background: linear-gradient(180deg, #14b8a6, #0d9488);
                border-radius: 99px;
                flex-shrink: 0;
            }

            /* ── Table ── */
            .panelis-table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 14px;
                overflow: hidden;
                box-shadow: 0 1px 4px rgba(0,0,0,0.08);
                border: 1px solid #e2e8f0;
            }
            .panelis-table th {
                background: #f8fafc;
                color: #1e293b;
                font-weight: 700;
                text-align: center;
                padding: 13px 14px;
                border: 1px solid #e2e8f0;
                font-size: 0.82rem;
                white-space: nowrap;
            }
            .panelis-table td {
                text-align: center;
                padding: 14px 14px;
                border: 1px solid #e2e8f0;
                font-size: 0.85rem;
                color: #334155;
                vertical-align: middle;
                white-space: nowrap;
            }
            .target-position {
                font-weight: 700;
                color: #1e293b;
                display: block;
                font-size: 0.92rem;
            }
            .target-dept {
                font-size: 0.73rem;
                color: #64748b;
                font-style: italic;
                display: block;
                margin-top: 2px;
            }
            .talent-name {
                font-weight: 700;
                color: #1e293b;
                display: block;
            }
            .talent-role {
                font-size: 0.73rem;
                color: #64748b;
                font-style: italic;
                display: block;
            }

            /* ── Action Buttons ── */
            .btn-kirim-panelis {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
                color: white;
                font-size: 0.75rem;
                font-weight: 700;
                padding: 7px 14px;
                border-radius: 8px;
                border: none;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 2px 6px rgba(20,184,166,0.3);
                white-space: nowrap;
                text-decoration: none;
            }
            .btn-kirim-panelis:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(20,184,166,0.4);
            }
            .btn-kirim-panelis:active { transform: scale(0.96); }

            .btn-sudah-panelis {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                background: #f1f5f9;
                color: #64748b;
                font-size: 0.75rem;
                font-weight: 600;
                padding: 7px 14px;
                border-radius: 8px;
                border: 1px solid #e2e8f0;
                white-space: nowrap;
            }

            .btn-lihat-penilaian {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                background: white;
                color: #2e3746;
                font-size: 0.75rem;
                font-weight: 700;
                padding: 7px 14px;
                border-radius: 8px;
                border: 1.5px solid #2e3746;
                white-space: nowrap;
                text-decoration: none;
                transition: all 0.2s;
            }
            .btn-lihat-penilaian:hover {
                background: #2e3746;
                color: white;
            }

            /* ── Empty State ── */
            .empty-state {
                background: white;
                padding: 60px 20px;
                border-radius: 16px;
                border: 2px dashed #e2e8f0;
                text-align: center;
                margin-top: 20px;
            }

            /* Status badges (Finance Validation) */
            .status-dot {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 0.825rem;
                font-weight: 600;
            }

            .status-dot::before {
                content: '';
                width: 9px;
                height: 9px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            .status-approve::before {
                background: #22c55e;
            }

            .status-pending::before {
                background: #f59e0b;
            }

            .status-rejected::before {
                background: #ef4444;
            }

            /* ── Send Panelis Modal ── */
            #panelisWizardModal {
                display: none;
            }
            .modal-step {
                display: none;
            }
            .modal-step.active {
                display: block;
            }
            .checkbox-item {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px 14px;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                cursor: pointer;
                transition: all 0.2s;
                margin-bottom: 8px;
            }
            .checkbox-item:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }
            .checkbox-item input[type="checkbox"] {
                width: 18px;
                height: 18px;
                cursor: pointer;
                accent-color: #14b8a6;
            }
        </style>
    </x-slot>

    {{-- ── Page Header ── --}}
    <div class="page-header animate-title">
        <div class="page-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">Panelis Review</div>
            <div class="page-header-sub">Pantau & kirim talent untuk penilaian panelis</div>
        </div>
    </div>

    {{-- ── Success Message ── --}}
    @if (session('success'))
        <div class="flex items-center gap-3 mb-5 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Summary Cards ── --}}
    <div class="prem-stat-grid" style="grid-template-columns:repeat(3,1fr)">
        <div class="prem-stat prem-stat-teal">
            <div class="prem-stat-icon si-teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M7.5 5.25a3 3 0 0 1 3-3h3a3 3 0 0 1 3 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0 1 12 15.75c-2.73 0-5.36-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 0 1 7.5 5.455V5.25Zm3 0v.25c0 .414.336.75.75.75h1.5a.75.75 0 0 0 .75-.75v-.25a1.5 1.5 0 0 0-1.5-1.5h-1.5a1.5 1.5 0 0 0-1.5 1.5Z" clip-rule="evenodd" /><path d="M3 16.02v2.73a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-2.73a26.12 26.12 0 0 1-9 1.73 26.12 26.12 0 0 1-9-1.73Z" /></svg>
            </div>
            <div class="prem-stat-value">{{ $totalProjectImprovement }}</div>
            <div class="prem-stat-label">Project Improvement</div>
        </div>
        <div class="prem-stat prem-stat-amber">
            <div class="prem-stat-icon si-amber">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" /></svg>
            </div>
            <div class="prem-stat-value">{{ $belumDinilai }}</div>
            <div class="prem-stat-label">Belum Dinilai Panelis</div>
        </div>
        <div class="prem-stat prem-stat-green">
            <div class="prem-stat-icon si-green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 11.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" /></svg>
            </div>
            <div class="prem-stat-value">{{ $sudahDinilai }}</div>
            <div class="prem-stat-label">Sudah Dinilai Panelis</div>
        </div>
    </div>

    {{-- ── Filters ── --}}
    <div class="flex flex-col sm:flex-row items-center gap-4 mb-6 mt-8" id="panelis-filter-bar">
        {{-- Live Search --}}
        <div class="relative w-full sm:w-[25%]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="live-search-input" placeholder="Cari Nama Talent…" 
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all" 
                oninput="filterPanelisList()">
        </div>

        {{-- Perusahaan --}}
        <div class="relative w-full sm:w-[20%]">
            <select id="live-company-filter" class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent appearance-none transition-all" 
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;" 
                onchange="filterPanelisList()">
                <option value="">Semua Perusahaan</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->nama_company }}</option>
                @endforeach
            </select>
        </div>

        {{-- Jabatan --}}
        <div class="relative w-full sm:w-[20%]">
            <select id="live-position-filter" class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent appearance-none transition-all" 
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;" 
                onchange="filterPanelisList()">
                <option value="">Semua Jabatan</option>
                @foreach ($positions as $pos)
                    <option value="{{ $pos->id }}">{{ $pos->position_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Departemen --}}
        <div class="relative w-full sm:w-[20%]">
            <select id="live-department-filter" class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent appearance-none transition-all" 
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;" 
                onchange="filterPanelisList()">
                <option value="">Semua Departemen</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->nama_department }}</option>
                @endforeach
            </select>
        </div>

        {{-- Reset Button --}}
        <button type="button" onclick="resetPanelisFilters()" class="btn-prem btn-ghost w-full sm:w-auto mt-2 sm:mt-0" id="reset-filter-btn" style="white-space:nowrap; display:none;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1 inline-block">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Reset
        </button>
    </div>

    {{-- ── Data Table grouped by Company ── --}}
    @forelse ($groupedData as $companyId => $companyData)
        <div class="mb-8 company-section" data-company-id="{{ $companyId }}">
            <h3 class="company-section-title">
                {{ $companyData['company']->nama_company ?? 'Unassigned' }}
            </h3>
            <div class="prem-card">
                <div class="overflow-x-auto">
                    <table class="prem-table">
                        <thead>
                            <tr>
                                <th class="w-[20%] text-left pl-6">Posisi yang Dituju</th>
                                <th class="w-[18%]">Talent</th>
                                <th class="w-[16%]">Departemen</th>
                                <th class="w-[15%]">Validasi Finance</th>
                                <th class="w-[13%]">Lock Progress</th>
                                <th class="w-[18%]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companyData['positions'] as $positionId => $posData)
                                @foreach ($posData['talents'] as $index => $talent)
                                    <tr class="talent-row" 
                                        data-name="{{ strtolower($talent->nama) }}" 
                                        data-company="{{ $talent->company_id }}" 
                                        data-position="{{ $positionId }}" 
                                        data-dept="{{ $talent->department_id }}"
                                        data-pos-group="{{ $companyId }}-{{ $positionId }}">
                                        {{-- Posisi (rowspan) --}}
                                        @if ($index === 0)
                                            <td rowspan="{{ count($posData['talents']) }}" class="text-left pl-6">
                                                <span class="font-bold text-[#1e293b] block text-sm">
                                                    {{ optional($posData['targetPosition'])->position_name ?? '-' }}
                                                </span>
                                                <span class="text-xs text-[#64748b] italic block mt-0.5">
                                                    {{ optional($posData['targetPosition'])->department->nama_department ?? optional($talent->department)->nama_department ?? '-' }}
                                                </span>
                                            </td>
                                        @endif

                                        {{-- Talent --}}
                                        <td>
                                            <span class="font-bold text-[#1e293b] block text-sm">{{ $talent->nama }}</span>
                                            <span class="text-xs text-[#64748b] italic block mt-0.5">{{ optional($talent->position)->position_name ?? 'Officer' }}</span>
                                        </td>

                                        {{-- Departemen --}}
                                        <td>
                                            <span class="text-sm text-[#475569]">{{ optional($talent->department)->nama_department ?? '-' }}</span>
                                        </td>

                                    {{-- Validasi Finance --}}
                                    <td>
                                        @php
                                            $latestProject = $talent->improvementProjects->sortByDesc('created_at')->first();
                                            $financeStatus = $latestProject ? $latestProject->status : 'Belum Ada';
                                        @endphp
                                        @if ($financeStatus === 'Verified')
                                            <span class="badge badge-green">Approved</span>
                                        @elseif($financeStatus === 'Rejected')
                                            <span class="badge badge-red">Rejected</span>
                                        @else
                                            <span class="badge badge-amber">Pending</span>
                                        @endif
                                    </td>

                                    {{-- Lock Progress --}}
                                    <td>
                                        @php
                                            $isLocked = optional($talent->promotion_plan)->is_locked ?? false;
                                        @endphp
                                        <form method="POST" action="{{ route('pdc_admin.panelis_review.toggle_lock', $talent->id) }}">
                                            @csrf
                                            <button type="submit" class="btn-prem {{ $isLocked ? 'btn-red' : 'btn-dark' }} text-[11px] px-2.5 py-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    @if($isLocked)
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                                    @endif
                                                </svg>
                                                {{ $isLocked ? 'Locked' : 'Unlocked' }}
                                            </button>
                                        </form>
                                    </td>

                                    {{-- Aksi --}}
                                    <td>
                                        @php
                                            $alreadySent = in_array(
                                                optional($talent->promotion_plan)->status_promotion,
                                                ['Pending Panelis', 'Approved Panelis', 'Rejected Panelis']
                                            );
                                            $isReviewedByPanelis = \App\Models\PanelisAssessment::where('user_id_talent', $talent->id)->whereNotNull('panelis_score')->exists();
                                        @endphp
                                        @if ($isReviewedByPanelis)
                                            {{-- Panelis sudah menilai → selalu tampilkan Lihat Penilaian --}}
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('pdc_admin.panelis_review.detail', $talent->id) }}" class="btn-prem btn-ghost text-xs px-3 py-1.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    Lihat Penilaian
                                                </a>
                                                @if (optional($talent->promotion_plan)->status_promotion === 'Approved Panelis')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 24 24" fill="currentColor" title="Selesai">
                                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                                    </svg>
                                                @else
                                                    <div class="w-5"></div>
                                                @endif
                                            </div>
                                        @elseif ($alreadySent && !$isReviewedByPanelis)
                                            {{-- Sudah dikirim ke Panelis tapi belum dinilai --}}
                                            <button type="button" class="btn-prem btn-ghost text-xs px-3 py-1.5 opacity-60 cursor-not-allowed mx-auto" disabled title="Menunggu penilaian dari Panelis">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Menunggu
                                            </button>
                                        @else
                                            {{-- Belum dikirim ke Panelis --}}
                                            <button type="button" onclick="openPanelisModal({{ $talent->id }}, '{{ addslashes($talent->nama) }}')" class="btn-prem btn-teal text-xs px-3 py-1.5 mx-auto {{ !optional($talent->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed' : '' }}" {{ !optional($talent->promotion_plan)->is_locked ? 'disabled title="Progress harus dikunci terlebih dahulu"' : '' }}>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                                </svg>
                                                Kirim Panelis
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                </div>{{-- /overflow-x-auto --}}
            </div>{{-- /prem-card --}}
        </div>
    @empty
        <div class="empty-prem" style="margin-top: 40px">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3>Belum Ada Data Talent</h3>
            <p>Data akan muncul setelah talent memiliki development plan aktif.</p>
        </div>
    @endforelse

    {{-- ── Kirim Panelis Wizard Modal ── --}}
    <div id="panelisWizardModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            {{-- Background overlay --}}
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closePanelisModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Modal panel --}}
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle w-full" style="max-width: 460px;">
                <form id="wizardForm" method="POST" action="">
                    @csrf
                    
                    {{-- HEADER --}}
                    <div class="bg-white px-6 pt-6 pb-4 flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Kirim Panelis</h3>
                            <p class="text-sm text-gray-600 mt-0.5" id="wizardSubtitle">Pilih Perusahaan</p>
                        </div>
                        <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors mt-1" onclick="closePanelisModal()">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- BODY --}}
                    <div class="px-6 pb-2" style="min-height: 280px;">
                        
                        {{-- STEP 1: Pilih Perusahaan --}}
                        <div id="step-1" class="modal-step active">
                            <div class="flex justify-end mb-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" id="selectAllCompanies" onchange="toggleAllCompanies(this)" class="w-4 h-4 rounded border-gray-400 text-teal-600 focus:ring-teal-500">
                                    <span class="text-sm text-gray-600">Pilih semua</span>
                                </label>
                            </div>
                            <div class="space-y-2 max-h-72 overflow-y-auto">
                                @forelse($companies as $comp)
                                    <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors [&:has(:checked)]:border-teal-500 [&:has(:checked)]:bg-teal-50">
                                        <input type="checkbox" name="selected_companies[]" value="{{ $comp->id }}" class="w-5 h-5 rounded border-gray-300 text-teal-600 focus:ring-teal-500 company-checkbox" onchange="updateCompanySelectAll()">
                                        <span class="text-sm font-medium text-gray-800">{{ $comp->nama_company }}</span>
                                    </label>
                                @empty
                                    <div class="text-sm text-gray-500 italic">Belum ada data perusahaan.</div>
                                @endforelse
                            </div>
                            <div id="step-1-error" class="hidden text-red-500 text-xs mt-2">* Pilih minimal satu perusahaan.</div>
                        </div>

                        {{-- STEP 2: Pilih Panelis per Perusahaan (Generated by JS) --}}
                        <div id="step-2-container"></div>

                        {{-- STEP 3: Confirmation --}}
                        <div id="step-final" class="modal-step">
                            <div id="final-panelis-list" class="space-y-3 max-h-72 overflow-y-auto pr-1">
                                {{-- JS populated --}}
                            </div>
                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="px-6 py-4 flex justify-end gap-3">
                        <button type="button" id="btn-cancel" class="px-5 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 focus:outline-none transition-colors" onclick="closePanelisModal()">
                            Batal
                        </button>
                        <button type="button" id="btn-prev" class="hidden px-5 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 focus:outline-none transition-colors" onclick="prevStep()">
                            Sebelumnya
                        </button>
                        <button type="button" id="btn-next" class="px-6 py-2 text-sm font-bold text-white bg-teal-500 rounded-xl hover:bg-teal-600 focus:outline-none transition-colors" onclick="nextStep()">
                            Next
                        </button>
                        <button type="submit" id="btn-submit" class="hidden px-6 py-2 text-sm font-bold text-white bg-teal-500 rounded-xl hover:bg-teal-600 focus:outline-none transition-colors">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function filterPanelisList() {
                const search = document.getElementById('live-search-input').value.toLowerCase();
                const companyId = document.getElementById('live-company-filter').value;
                const positionId = document.getElementById('live-position-filter').value;
                const departmentId = document.getElementById('live-department-filter').value;
                
                const rows = document.querySelectorAll('.talent-row');
                const resetBtn = document.getElementById('reset-filter-btn');
                
                // Show/hide reset button
                resetBtn.style.display = (search || companyId || positionId || departmentId) ? 'inline-flex' : 'none';

                // Track results per position group to handle rowspan
                const groupVisibility = {};

                rows.forEach(row => {
                    const name = row.dataset.name;
                    const rowComp = row.dataset.company;
                    const rowPos = row.dataset.position;
                    const rowDept = row.dataset.dept;
                    const groupKey = row.dataset.pos-group;

                    const matchSearch = !search || name.includes(search);
                    const matchComp = !companyId || rowComp === companyId;
                    const matchPos = !positionId || rowPos === positionId;
                    const matchDept = !departmentId || rowDept === departmentId;

                    if (matchSearch && matchComp && matchPos && matchDept) {
                        row.style.display = '';
                        if (!groupVisibility[groupKey]) groupVisibility[groupKey] = [];
                        groupVisibility[groupKey].push(row);
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Adjust rowspans and move the position cell if needed
                for (const groupKey in groupVisibility) {
                    const visibleRows = groupVisibility[groupKey];
                    const firstRow = visibleRows[0];
                    
                    // Hide all potential position cells in this group first
                    const allInGroup = document.querySelectorAll(`.talent-row[data-pos-group="${groupKey}"]`);
                    allInGroup.forEach(r => {
                        const posCell = r.querySelector('td[rowspan]');
                        if (posCell) posCell.style.display = 'none';
                    });

                    // Show position cell on the NEW first visible row and set its rowspan
                    let posCell = firstRow.querySelector('td[rowspan]');
                    if (!posCell) {
                        // If the first visible row wasn't the original index 0, it doesn't have the cell.
                        // We need to 'find' it from the original index 0 of this group.
                        const originalFirst = allInGroup[0];
                        posCell = originalFirst.querySelector('td[rowspan]');
                        // Move it conceptually or just show it (here we just ensure the cell is available/shown)
                        firstRow.prepend(posCell);
                    }
                    posCell.style.display = '';
                    posCell.setAttribute('rowspan', visibleRows.length);
                }

                // Hide empty company sections
                document.querySelectorAll('.company-section').forEach(section => {
                    const hasVisible = section.querySelector('.talent-row[style="display: ;"]') || 
                                       section.querySelector('.talent-row:not([style*="display: none"])');
                    section.style.display = hasVisible ? '' : 'none';
                });
            }

            function resetPanelisFilters() {
                document.getElementById('live-search-input').value = '';
                document.getElementById('live-company-filter').value = '';
                document.getElementById('live-position-filter').value = '';
                document.getElementById('live-department-filter').value = '';
                filterPanelisList();
            }

            // ... Modal logic below ...
            const panelisUsers = @json($panelisUsers);
            const panelisCompanies = @json($companies);
            
            let currentStep = 0; // 0 = company select, 1...n = per company select, n+1 = final
            let selectedCompanyIds = [];
            let totalSteps = 0;

            const modal = document.getElementById('panelisWizardModal');
            const step1 = document.getElementById('step-1');
            const step2Container = document.getElementById('step-2-container');
            const stepFinal = document.getElementById('step-final');
            const btnPrev = document.getElementById('btn-prev');
            const btnNext = document.getElementById('btn-next');
            const btnSubmit = document.getElementById('btn-submit');
            const btnCancel = document.getElementById('btn-cancel');
            const wizardForm = document.getElementById('wizardForm');

            function openPanelisModal(talentId, talentName) {
                wizardForm.action = `/pdc-admin/panelis-review/send/${talentId}`;
                
                // Reset form
                wizardForm.reset();
                document.querySelectorAll('.company-checkbox').forEach(cb => cb.checked = false);
                document.getElementById('selectAllCompanies').checked = false;
                step2Container.innerHTML = '';
                document.getElementById('final-panelis-list').innerHTML = '';
                document.getElementById('step-1-error').classList.add('hidden');
                
                currentStep = 0;
                updateView();
                modal.style.display = 'block';
            }

            function closePanelisModal() {
                modal.style.display = 'none';
            }

            function updateView() {
                // Hide all steps
                step1.classList.remove('active');
                stepFinal.classList.remove('active');
                document.querySelectorAll('.company-step').forEach(el => el.classList.remove('active'));

                let subtitle = document.getElementById('wizardSubtitle');

                // Show step
                if (currentStep === 0) {
                    subtitle.innerText = 'Pilih Perusahaan';
                    step1.classList.add('active');
                    btnPrev.classList.add('hidden');
                    btnNext.classList.remove('hidden');
                    btnSubmit.classList.add('hidden');
                    btnCancel.classList.remove('hidden');
                } else if (currentStep > 0 && currentStep <= selectedCompanyIds.length) {
                    subtitle.innerText = 'Pilih Panelis';
                    document.getElementById(`step-comp-${selectedCompanyIds[currentStep - 1]}`).classList.add('active');
                    btnPrev.classList.remove('hidden');
                    btnNext.classList.remove('hidden');
                    btnSubmit.classList.add('hidden');
                    btnCancel.classList.add('hidden');
                } else if (currentStep === selectedCompanyIds.length + 1) {
                    subtitle.innerText = 'Konfirmasi Panelis';
                    populateFinalSummary();
                    stepFinal.classList.add('active');
                    btnPrev.classList.remove('hidden');
                    btnNext.classList.add('hidden');
                    btnSubmit.classList.remove('hidden');
                    btnCancel.classList.add('hidden');
                }
            }

            function nextStep() {
                if (currentStep === 0) {
                    // Validation: MUST select at least one company
                    const checkedComps = document.querySelectorAll('.company-checkbox:checked');
                    if (checkedComps.length === 0) {
                        document.getElementById('step-1-error').classList.remove('hidden');
                        return;
                    }
                    document.getElementById('step-1-error').classList.add('hidden');
                    
                    selectedCompanyIds = Array.from(checkedComps).map(cb => cb.value);
                    generateCompanySteps();
                }
                currentStep++;
                updateView();
            }

            function prevStep() {
                currentStep--;
                updateView();
            }

            function toggleAllCompanies(selectAllCb) {
                const checkboxes = document.querySelectorAll('.company-checkbox');
                checkboxes.forEach(cb => cb.checked = selectAllCb.checked);
            }

            function updateCompanySelectAll() {
                const all = document.querySelectorAll('.company-checkbox');
                const checked = document.querySelectorAll('.company-checkbox:checked');
                document.getElementById('selectAllCompanies').checked = (all.length > 0 && all.length === checked.length);
            }

            function generateCompanySteps() {
                // Preserve previous selections if revisiting, otherwise rebuild container
                const currentSelections = getSelectedPanelisIds();
                step2Container.innerHTML = '';

                selectedCompanyIds.forEach((compId, index) => {
                    const companyName = panelisCompanies.find(c => c.id == compId)?.nama_company || 'Unknown Company';
                    const compPanelis = panelisUsers.filter(u => u.company_id == compId);
                    
                    let htmlList = '';
                    let selectAllHtml = '';
                    if (compPanelis.length === 0) {
                        htmlList = `<div class="text-sm text-gray-500 italic px-2">Tidak ada panelis di perusahaan ini.</div>`;
                    } else {
                        selectAllHtml = `
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="selectAllPanelis_${compId}" onchange="toggleAllPanelis(this, ${compId})" class="w-4 h-4 rounded border-gray-400 text-teal-600 focus:ring-teal-500">
                                <span class="text-sm text-gray-600">Pilih semua</span>
                            </label>
                        `;
                        compPanelis.forEach(panelis => {
                            const isChecked = currentSelections.includes(panelis.id.toString()) ? 'checked' : '';
                            const roleName = panelis.position?.position_name || 'Panelis';
                            htmlList += `
                                <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors [&:has(:checked)]:border-teal-500 [&:has(:checked)]:bg-teal-50">
                                    <input type="checkbox" name="panelis_ids[]" value="${panelis.id}" class="w-5 h-5 rounded border-gray-300 text-teal-600 focus:ring-teal-500 panelis-checkbox-${compId} panelis-checkbox-global" ${isChecked} onchange="updatePanelisSelectAll(${compId})">
                                    <span class="text-sm font-medium text-gray-800">${panelis.nama} - ${roleName}</span>
                                </label>
                            `;
                        });
                    }

                    const stepHtml = `
                        <div id="step-comp-${compId}" class="modal-step company-step">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-base font-bold text-gray-900">${companyName}</h4>
                                <div>${selectAllHtml}</div>
                            </div>
                            <div class="space-y-2 max-h-72 overflow-y-auto">
                                ${htmlList}
                            </div>
                        </div>
                    `;
                    step2Container.insertAdjacentHTML('beforeend', stepHtml);
                });
            }

            function toggleAllPanelis(selectAllCb, compId) {
                const checkboxes = document.querySelectorAll(`.panelis-checkbox-${compId}`);
                checkboxes.forEach(cb => cb.checked = selectAllCb.checked);
            }

            function updatePanelisSelectAll(compId) {
                const all = document.querySelectorAll(`.panelis-checkbox-${compId}`);
                const checked = document.querySelectorAll(`.panelis-checkbox-${compId}:checked`);
                const sa = document.getElementById(`selectAllPanelis_${compId}`);
                if(sa) sa.checked = (all.length > 0 && all.length === checked.length);
            }

            function getSelectedPanelisIds() {
                const checkboxes = document.querySelectorAll('.panelis-checkbox-global:checked');
                return Array.from(checkboxes).map(cb => cb.value);
            }

            function populateFinalSummary() {
                const container = document.getElementById('final-panelis-list');
                container.innerHTML = '';
                
                const selectedIds = getSelectedPanelisIds();
                if (selectedIds.length === 0) {
                    container.innerHTML = '<div class="text-gray-500 italic">Tidak ada panelis yang dipilih. Data tidak dapat dikirim.</div>';
                    btnSubmit.disabled = true;
                    btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    btnSubmit.disabled = false;
                    btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
                    
                    selectedCompanyIds.forEach(compId => {
                        const compPanelis = panelisUsers.filter(u => u.company_id == compId && selectedIds.includes(u.id.toString()));
                        if (compPanelis.length > 0) {
                            const companyName = panelisCompanies.find(c => c.id == compId)?.nama_company || 'Unknown Company';
                            
                            let listHtml = '';
                            compPanelis.forEach(p => {
                                const roleName = p.position?.position_name || 'Panelis';
                                listHtml += `
                                    <div class="px-4 py-2.5 border-b border-gray-100 last:border-0">
                                        <span class="text-sm font-medium text-gray-800">${p.nama} - ${roleName}</span>
                                    </div>
                                `;
                            });
                            
                            container.innerHTML += `
                                <div class="border border-gray-200 rounded-xl overflow-hidden">
                                    <div class="bg-gray-50 border-b border-gray-200 px-4 py-3">
                                        <h5 class="text-sm font-bold text-gray-900">${companyName}</h5>
                                    </div>
                                    <div class="bg-white">
                                        ${listHtml}
                                    </div>
                                </div>
                            `;
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-pdc_admin.layout>
