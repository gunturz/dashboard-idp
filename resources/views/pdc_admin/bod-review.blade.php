<x-pdc_admin.layout title="BOD Review – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* ── Summary Cards ── */
            .bod-stat-card {
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
                transition: box-shadow 0.2s, transform 0.2s;
            }
            .bod-stat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            }
            .bod-stat-card.teal  { border-color: #14b8a6; }
            .bod-stat-card.amber { border-color: #f59e0b; }
            .bod-stat-card.green { border-color: #22c55e; }
            .bod-stat-num {
                font-size: 2.5rem;
                font-weight: 800;
                line-height: 1;
                margin-bottom: 6px;
            }
            .bod-stat-card.teal  .bod-stat-num { color: #14b8a6; }
            .bod-stat-card.amber .bod-stat-num { color: #f59e0b; }
            .bod-stat-card.green .bod-stat-num { color: #22c55e; }
            .bod-stat-label {
                font-size: 0.8rem;
                color: #64748b;
                font-weight: 500;
                line-height: 1.3;
            }

            /* ── Filters ── */
            .bod-filter-input,
            .bod-filter-select {
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
            .bod-filter-input:focus,
            .bod-filter-select:focus {
                border-color: #14b8a6;
                box-shadow: 0 0 0 3px rgba(20,184,166,0.12);
            }
            .bod-filter-select {
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
            .bod-table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 14px;
                overflow: hidden;
                box-shadow: 0 1px 4px rgba(0,0,0,0.08);
                border: 1px solid #e2e8f0;
            }
            .bod-table th {
                background: #f8fafc;
                color: #1e293b;
                font-weight: 700;
                text-align: center;
                padding: 13px 14px;
                border: 1px solid #e2e8f0;
                font-size: 0.82rem;
                white-space: nowrap;
            }
            .bod-table td {
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
            .btn-kirim-bod {
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
            .btn-kirim-bod:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(20,184,166,0.4);
            }
            .btn-kirim-bod:active { transform: scale(0.96); }

            .btn-sudah-bod {
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
        </style>
    </x-slot>

    {{-- ── Page Header ── --}}
    <div class="flex items-center gap-3 animate-title mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-8 w-8 text-[#2e3746]">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
        </svg>
        <h2 class="text-2xl font-extrabold text-[#2e3746]">BOD Review</h2>
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
    <div class="flex flex-wrap gap-4 mb-7">
        <div class="bod-stat-card teal">
            <div class="bod-stat-num">{{ $totalProjectImprovement }}</div>
            <div class="bod-stat-label">Project<br>Improvement</div>
        </div>
        <div class="bod-stat-card amber">
            <div class="bod-stat-num">{{ $belumDinilai }}</div>
            <div class="bod-stat-label">Belum Dinilai BOD</div>
        </div>
        <div class="bod-stat-card green">
            <div class="bod-stat-num">{{ $sudahDinilai }}</div>
            <div class="bod-stat-label">Sudah Dinilai BOD</div>
        </div>
    </div>

    {{-- ── Filters ── --}}
    <form method="GET" action="{{ route('pdc_admin.bod_review') }}" class="flex flex-wrap gap-2 mb-6" id="bod-filter-form">
        <input
            type="text"
            name="search"
            placeholder="Cari Nama Talent…"
            value="{{ request('search') }}"
            class="bod-filter-input flex-1 w-full sm:min-w-[200px]"
            id="bod-search-input"
        >
        <select name="company_id" class="bod-filter-select" id="bod-company-filter" onchange="this.form.submit()">
            <option value="">Semua Perusahaan</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                    {{ $company->nama_company }}
                </option>
            @endforeach
        </select>
        <select name="position_id" class="bod-filter-select" id="bod-position-filter" onchange="this.form.submit()">
            <option value="">Semua Jabatan</option>
            @foreach ($positions as $pos)
                <option value="{{ $pos->id }}" {{ request('position_id') == $pos->id ? 'selected' : '' }}>
                    {{ $pos->position_name }}
                </option>
            @endforeach
        </select>
        <select name="department_id" class="bod-filter-select" id="bod-department-filter" onchange="this.form.submit()">
            <option value="">Semua Departemen</option>
            @foreach ($departments as $dept)
                <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                    {{ $dept->nama_department }}
                </option>
            @endforeach
        </select>
        {{-- Hidden submit on search blur --}}
        <button type="submit" class="hidden" id="bod-search-btn"></button>
    </form>

    {{-- ── Data Table grouped by Company ── --}}
    @forelse ($groupedData as $companyId => $companyData)
        <div class="mb-10">
            <h3 class="company-header">
                {{ $companyData['company']->nama_company ?? 'Unassigned' }}
            </h3>
            <div class="overflow-x-auto rounded-xl shadow-sm">
                <table class="bod-table">
                    <thead>
                        <tr>
                            <th class="w-[20%]">Posisi yang Dituju</th>
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
                                <tr>
                                    {{-- Posisi (rowspan) --}}
                                    @if ($index === 0)
                                        <td rowspan="{{ count($posData['talents']) }}" class="bg-white">
                                            <span class="target-position">
                                                {{ optional($posData['targetPosition'])->position_name ?? '-' }}
                                            </span>
                                            <span class="target-dept">
                                                {{ optional($posData['targetPosition'])->department->nama_department ?? optional($talent->department)->nama_department ?? '-' }}
                                            </span>
                                        </td>
                                    @endif

                                    {{-- Talent --}}
                                    <td>
                                        <span class="talent-name">{{ $talent->nama }}</span>
                                        <span class="talent-role">{{ optional($talent->position)->position_name ?? 'Officer' }}</span>
                                    </td>

                                    {{-- Departemen --}}
                                    <td class="bg-white">
                                        {{ optional($talent->department)->nama_department ?? '-' }}
                                    </td>

                                    {{-- Validasi Finance --}}
                                    <td>
                                        @php
                                            $latestProject = $talent->improvementProjects->sortByDesc('created_at')->first();
                                            $financeStatus = $latestProject ? $latestProject->status : 'Belum Ada';
                                        @endphp
                                        @if ($financeStatus === 'Verified')
                                            <span class="status-dot status-approve">Approved</span>
                                        @elseif($financeStatus === 'Rejected')
                                            <span class="status-dot status-rejected">Rejected</span>
                                        @else
                                            <span class="status-dot status-pending">Pending</span>
                                        @endif
                                    </td>

                                    {{-- Lock Progress --}}
                                    <td>
                                        @php
                                            $isLocked = optional($talent->promotion_plan)->is_locked ?? false;
                                        @endphp
                                        <form method="POST" action="{{ route('pdc_admin.bod_review.toggle_lock', $talent->id) }}">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-semibold rounded-md shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $isLocked ? 'bg-red-600 hover:bg-red-700 focus:ring-red-500' : 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                    <td class="bg-white">
                                        @php
                                            $alreadySent = in_array(
                                                optional($talent->promotion_plan)->status_promotion,
                                                ['Pending BOD', 'Approved BOD', 'Rejected BOD']
                                            );
                                        @endphp
                                        @if (!$alreadySent)
                                            <form method="POST" action="{{ route('pdc_admin.bod_review.send', $talent->id) }}">
                                                @csrf
                                                <button type="submit" class="btn-kirim-bod {{ !optional($talent->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed' : '' }}" {{ !optional($talent->promotion_plan)->is_locked ? 'disabled title="Progress harus dikunci terlebih dahulu"' : '' }}>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                                    </svg>
                                                    Kirim BOD
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('pdc_admin.bod_review.detail', $talent->id) }}" class="btn-lihat-penilaian">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Lihat Penilaian
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <p class="text-gray-500 font-semibold">Belum ada data talent untuk BOD Review.</p>
            <p class="text-gray-400 text-sm mt-1">Data akan muncul setelah talent memiliki development plan aktif.</p>
        </div>
    @endforelse

    <x-slot name="scripts">
        <script>
            // Submit search on Enter
            document.getElementById('bod-search-input').addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('bod-filter-form').submit();
                }
            });
        </script>
    </x-slot>
</x-pdc_admin.layout>
