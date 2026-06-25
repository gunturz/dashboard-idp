<x-pdc_admin.layout title="Progress Archive – PDC Admin" :user="$user">

    <div class="px-2 pb-10">
        {{-- Page Header --}}
        <div class="page-header animate-title mb-8">
            <div class="page-header-icon shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                    <path
                        d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                    <path fill-rule="evenodd"
                        d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087ZM12 10.5a.75.75 0 0 1 .75.75v4.94l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72v-4.94a.75.75 0 0 1 .75-.75Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <div class="page-header-title">Progress Archive</div>
                <div class="page-header-sub">Arsip rekam jejak pengembangan talent serta kemudahan export data PDF.
                </div>
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

        {{-- Stats Cards --}}
        @php
            $allArchiveRows = collect($groupedData)
                ->flatMap(function ($group) {
                    $companyName = $group['company']->nama_company ?? '-';
                    return $group['talents']->map(function ($talent) use ($companyName) {
                        $talent->archive_company_name = $companyName;
                        return $talent;
                    });
                });

            $statCompleted   = $allArchiveRows->count();
            $statReadyNow    = $allArchiveRows->filter(fn($t) => optional($t->promotion_plan)->status_promotion === 'Promoted')->count();
            $statReady12     = $allArchiveRows->filter(fn($t) => optional($t->promotion_plan)->status_promotion === 'Ready in 1-2 Years')->count();
            $statReadyOver2  = $allArchiveRows->filter(fn($t) => optional($t->promotion_plan)->status_promotion === 'Ready in > 2 Years')->count();
            $statNotReady    = $allArchiveRows->filter(fn($t) => optional($t->promotion_plan)->status_promotion === 'Not Ready')->count();
        @endphp

        <div class="archive-stats-grid mb-8">
            {{-- Progress Completed --}}
            <div class="archive-stat-card archive-stat-card--teal" data-filter="" onclick="filterByCard(this)" style="cursor:pointer;">
                <div class="archive-stat-icon archive-stat-icon--teal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                        <circle cx="12" cy="12" r="12" fill="currentColor" />
                        <path fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="m8 12.5 2.5 2.5 5.5-5.5" />
                    </svg>
                </div>
                <div class="archive-stat-count">{{ $statCompleted }}</div>
                <div class="archive-stat-label">Progress Completed</div>
            </div>

            {{-- Ready Now --}}
            <div class="archive-stat-card archive-stat-card--green" data-filter="Promoted" onclick="filterByCard(this)" style="cursor:pointer;">
                <div class="archive-stat-icon archive-stat-icon--green">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                        <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 01.359.852L12.982 9.75h7.268a.75.75 0 01.548 1.262l-10.5 11.25a.75.75 0 01-1.272-.71l1.992-7.302H3.75a.75.75 0 01-.548-1.262l10.5-11.25a.75.75 0 01.913-.143z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="archive-stat-count">{{ $statReadyNow }}</div>
                <div class="archive-stat-label">Ready Now</div>
            </div>

            {{-- Ready in 1-2 Years --}}
            <div class="archive-stat-card archive-stat-card--blue" data-filter="Ready in 1-2 Years" onclick="filterByCard(this)" style="cursor:pointer;">
                <div class="archive-stat-icon archive-stat-icon--blue">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                        <circle cx="12" cy="12" r="12" fill="currentColor" />
                        <path fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M12 7.5v4.5h3.5" />
                    </svg>
                </div>
                <div class="archive-stat-count">{{ $statReady12 }}</div>
                <div class="archive-stat-label">Ready in 1 – 2 Years</div>
            </div>

            {{-- Ready in > 2 Years --}}
            <div class="archive-stat-card archive-stat-card--orange" data-filter="Ready in > 2 Years" onclick="filterByCard(this)" style="cursor:pointer;">
                <div class="archive-stat-icon archive-stat-icon--orange">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                        <circle cx="12" cy="12" r="12" fill="currentColor" />
                        <g fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8.5 6h7M8.5 18h7" />
                            <path d="M14 18v-3.5l-2-2.5 2-2.5V6" />
                            <path d="M10 18v-3.5l2-2.5-2-2.5V6" />
                        </g>
                    </svg>
                </div>
                <div class="archive-stat-count">{{ $statReadyOver2 }}</div>
                <div class="archive-stat-label">Ready in &gt; 2 Years</div>
            </div>

            {{-- Not Ready --}}
            <div class="archive-stat-card archive-stat-card--red" data-filter="Not Ready" onclick="filterByCard(this)" style="cursor:pointer;">
                <div class="archive-stat-icon archive-stat-icon--red">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                        <circle cx="12" cy="12" r="12" fill="currentColor" />
                        <path fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M12 7v6" />
                        <circle cx="12" cy="16.5" r="1.25" fill="#fff" />
                    </svg>
                </div>
                <div class="archive-stat-count">{{ $statNotReady }}</div>
                <div class="archive-stat-label">Not Ready</div>
            </div>
        </div>

        {{-- Filters (Re-styled to match Panelis Review) --}}
        <div class="flex flex-col sm:flex-row items-center gap-4 mb-8 mt-4" id="archive-filter-bar">
            {{-- Search --}}
            <div class="relative w-full sm:flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="searchInput" placeholder="Cari Nama Talent…"
                    class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                    oninput="filterTalents()">
            </div>

            {{-- Period Filter --}}
            <div class="relative w-full sm:w-56">
                <select id="periodFilter"
                    class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent bg-white appearance-none transition-all"
                    style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;"
                    onchange="filterTalents()">
                    <option value="">Semua Periode</option>
                    @php
                        $uniquePeriods = collect();
                        foreach ($groupedData as $group) {
                            foreach ($group['talents'] as $t) {
                                $dueDate = optional($t->promotion_plan)->target_date;
                                if ($dueDate) {
                                    $uniquePeriods->push(\Carbon\Carbon::parse($dueDate)->format('Y'));
                                }
                            }
                        }
                        $uniquePeriods = $uniquePeriods->unique()->sort();
                    @endphp
                    @foreach ($uniquePeriods as $period)
                        <option value="{{ $period }}">{{ $period }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Company Filter --}}
            <div class="relative w-full sm:w-56">
                <select id="companyFilter"
                    class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent bg-white appearance-none transition-all"
                    style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;"
                    onchange="filterTalents()">
                    <option value="">Semua Perusahaan</option>
                    @php
                        $uniqueCompanies = collect($groupedData)
                            ->map(fn($group) => $group['company']->nama_company ?? null)
                            ->filter()
                            ->unique()
                            ->values();
                    @endphp
                    @foreach ($uniqueCompanies as $comp)
                        <option value="{{ $comp }}">{{ $comp }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Status Filter (Hidden because it's controlled by Stats Cards) --}}
            <input type="hidden" id="statusFilter" value="">
        </div>

        {{-- Table grouped by Title (as Section) then data --}}
        @php
            $archiveRows = collect($groupedData)
                ->flatMap(function ($group) {
                    $companyName = $group['company']->nama_company ?? '-';

                    return $group['talents']->map(function ($talent) use ($companyName) {
                        $talent->archive_company_name = $companyName;

                        return $talent;
                    });
                })
                ->sortByDesc(function ($talent) {
                    return optional(optional($talent->promotion_plan)->developmentSession)->completed_at ??
                        (optional($talent->promotion_plan)->updated_at ??
                            optional($talent->promotion_plan)->created_at);
                })
                ->values();
        @endphp

        <div class="progress-archive-wrapper">
            <div id="archiveTableContainer"
                class="w-full border border-gray-200 rounded-2xl shadow-sm bg-white overflow-hidden {{ $archiveRows->isEmpty() ? 'hidden' : '' }}">
                <div class="overflow-x-auto w-full">
                    <table class="w-full table-auto text-left" id="archiveTable">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                Talent</th>
                            <th class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                Perusahaan</th>
                            <th class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                Start Date</th>
                            <th class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                Due Date</th>
                            <th class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                Rekomendasi</th>
                            <th class="py-4 px-6 text-[13px] font-bold text-slate-700 text-center whitespace-nowrap">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="archiveTbody" class="divide-y divide-gray-100">
                        @foreach ($archiveRows as $talent)
                            @php
                                $compName = $talent->archive_company_name ?? '-';
                                $startDate = optional($talent->promotion_plan)->start_date
                                    ? \Carbon\Carbon::parse($talent->promotion_plan->start_date)->locale('id')->translatedFormat(
                                        'd F Y',
                                    )
                                    : '-';
                                $dueDate = optional($talent->promotion_plan)->target_date
                                    ? \Carbon\Carbon::parse($talent->promotion_plan->target_date)->locale('id')->translatedFormat(
                                        'd F Y',
                                    )
                                    : '-';
                                $currentPos =
                                    $talent->archive_source_position_name ?? ($talent->position->position_name ?? '-');
                                $targetPos = optional($talent->promotion_plan)->targetPosition->position_name ?? '-';
                                $periodLabel = '';
                                if (optional($talent->promotion_plan)->target_date) {
                                    $periodLabel = \Carbon\Carbon::parse($talent->promotion_plan->target_date)->format(
                                        'Y',
                                    );
                                }
                            @endphp
                            <tr class="archive-row hover:bg-teal-50/50 transition-colors"
                                data-name="{{ strtolower($talent->nama) }}" data-company="{{ $compName }}"
                                data-period="{{ $periodLabel }}"
                                data-status="{{ optional($talent->promotion_plan)->status_promotion }}">
                                <td class="py-4 px-6 text-center">
                                    <p class="font-bold text-[#0f172a]">{{ $talent->nama }}</p>
                                    <p class="text-xs text-slate-500 italic mt-0.5">{{ $currentPos }} &rarr;
                                        {{ $targetPos }}
                                    </p>
                                </td>
                                <td class="py-4 px-6 text-center text-slate-600 text-sm">{{ $compName }}</td>
                                <td class="py-4 px-6 text-center text-slate-600 text-sm">{{ $startDate }}</td>
                                <td class="py-4 px-6 text-center text-slate-600 text-sm">{{ $dueDate }}</td>
                                <td class="py-4 px-6 text-center">
                                    @php $promoStatus = optional($talent->promotion_plan)->status_promotion; @endphp
                                    @if ($promoStatus === 'Promoted')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 flex-shrink-0"></span>
                                            Ready Now
                                        </span>
                                    @elseif ($promoStatus === 'Ready in 1-2 Years')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 flex-shrink-0"></span>
                                            Ready 1–2 Years
                                        </span>
                                    @elseif ($promoStatus === 'Ready in > 2 Years')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 flex-shrink-0"></span>
                                            Ready &gt;2 Years
                                        </span>
                                    @elseif ($promoStatus === 'Not Ready')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 flex-shrink-0"></span>
                                            Not Ready
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200 shadow-sm">
                                            {{ $promoStatus ?? '-' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('pdc_admin.progress_archive.detail', ['talent_id' => $talent->id, 'session_id' => $talent->archive_session_id]) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#14b8a6] border border-[#14b8a6] rounded-lg text-xs font-bold text-white hover:bg-[#0d9488] hover:border-[#0d9488] transition-colors shadow-sm whitespace-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            Detail
                                        </a>
                                        <a href="{{ route('pdc_admin.export_pdf', ['talent_id' => $talent->id, 'session_id' => $talent->archive_session_id]) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#EE5353] border border-[#EE5353] rounded-lg text-xs font-bold text-white hover:bg-[#d94444] hover:border-[#d94444] transition-colors shadow-sm whitespace-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3">
                                                </line>
                                            </svg>
                                            Export
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>

                {{-- Pagination Bar --}}
                <div id="archivePaginationBar" class="archive-pagination-bar hidden">
                    <span id="archivePaginationInfo" class="archive-pagination-info"></span>
                    <div id="archivePaginationControls" class="archive-pagination-controls"></div>
                </div>
            </div>

            {{-- Empty State Outside Table --}}
            <div id="emptyStateContainer" class="{{ $archiveRows->isEmpty() ? '' : 'hidden' }} mt-8 mb-12">
                <div class="empty-prem" style="border: none; padding: 20px;">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto"
                        style="background:linear-gradient(135deg,#ccfbf1,#99f6e4)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            style="color: #0d9488; width: 32px; height: 32px; margin: 0;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 id="emptyTitle">Belum Ada Arsip Progress Talent</h3>
                    <p id="emptyText">Data akan muncul setelah ada talent yang masuk ke dalam arsip.</p>
                </div>
            </div>

        </div>{{-- /progress-archive-wrapper --}}

    </div>

    <x-slot name="scripts">
        <script>
            const ROWS_PER_PAGE = 10;
            let archiveCurrentPage = 1;
            let archiveFilteredRows = [];

            function filterTalents() {
                const searchTxt = document.getElementById('searchInput').value.toLowerCase().trim();
                const compVal   = document.getElementById('companyFilter').value;
                const periodVal = document.getElementById('periodFilter').value;
                const statusVal = document.getElementById('statusFilter').value;

                // Collect matching rows (but hide all first)
                archiveFilteredRows = [];
                document.querySelectorAll('.archive-row').forEach(row => {
                    row.style.display = 'none';
                    const name   = row.getAttribute('data-name')    || '';
                    const comp   = row.getAttribute('data-company')  || '';
                    const period = row.getAttribute('data-period')   || '';
                    const status = row.getAttribute('data-status')   || '';

                    const matchName   = name.includes(searchTxt);
                    const matchComp   = compVal   === '' || comp   === compVal;
                    const matchPeriod = periodVal === '' || period === periodVal;
                    const matchStatus = statusVal === '' || status === statusVal;

                    if (matchName && matchComp && matchPeriod && matchStatus) {
                        archiveFilteredRows.push(row);
                    }
                });

                // Reset to page 1 whenever filter changes
                archiveCurrentPage = 1;
                renderArchivePage();
            }

            function renderArchivePage() {
                const total      = archiveFilteredRows.length;
                const totalPages = Math.ceil(total / ROWS_PER_PAGE);
                const start      = (archiveCurrentPage - 1) * ROWS_PER_PAGE;
                const end        = Math.min(start + ROWS_PER_PAGE, total);

                // Hide all rows, then show current page slice
                document.querySelectorAll('.archive-row').forEach(r => r.style.display = 'none');
                archiveFilteredRows.slice(start, end).forEach(r => r.style.display = '');

                const tableContainer    = document.getElementById('archiveTableContainer');
                const emptyState        = document.getElementById('emptyStateContainer');
                const emptyTitle        = document.getElementById('emptyTitle');
                const emptyText         = document.getElementById('emptyText');
                const paginationBar     = document.getElementById('archivePaginationBar');
                const paginationInfo    = document.getElementById('archivePaginationInfo');
                const paginationCtrls   = document.getElementById('archivePaginationControls');

                if (total === 0) {
                    tableContainer.classList.add('hidden');
                    paginationBar.classList.add('hidden');
                    emptyState.classList.remove('hidden');

                    const searchTxt = document.getElementById('searchInput').value.trim();
                    const compVal   = document.getElementById('companyFilter').value;
                    const periodVal = document.getElementById('periodFilter').value;
                    const statusVal = document.getElementById('statusFilter').value;

                    if (searchTxt || compVal || periodVal || statusVal) {
                        emptyTitle.innerHTML = 'Tidak Ada Data Talent';
                        emptyText.innerHTML  = searchTxt
                            ? `Tidak ada hasil pencarian yang cocok untuk "<strong>${document.getElementById('searchInput').value}</strong>"`
                            : 'Tidak ada hasil untuk filter yang dipilih.';
                    } else {
                        emptyTitle.innerHTML = 'Belum Ada Arsip Progress Talent';
                        emptyText.innerHTML  = 'Data akan muncul setelah ada talent yang masuk ke dalam arsip.';
                    }
                    return;
                }

                tableContainer.classList.remove('hidden');
                emptyState.classList.add('hidden');

                // Pagination bar visibility (only when > 10 rows)
                if (total > ROWS_PER_PAGE) {
                    paginationBar.classList.remove('hidden');
                    paginationInfo.textContent = `Menampilkan ${start + 1}-${end} dari ${total} pengguna`;

                    // Build page buttons
                    let html = '';

                    // Prev
                    html += `<button class="arch-page-btn arch-page-prev" ${archiveCurrentPage === 1 ? 'disabled' : ''} onclick="goArchivePage(${archiveCurrentPage - 1})">&laquo; Prev</button>`;

                    // Page numbers (show max 5 around current)
                    const delta = 2;
                    let pages = [];
                    for (let p = Math.max(1, archiveCurrentPage - delta); p <= Math.min(totalPages, archiveCurrentPage + delta); p++) {
                        pages.push(p);
                    }
                    // Always show first & last with ellipsis
                    if (pages[0] > 1) {
                        html += `<button class="arch-page-btn" onclick="goArchivePage(1)">1</button>`;
                        if (pages[0] > 2) html += `<span class="arch-page-ellipsis">&hellip;</span>`;
                    }
                    pages.forEach(p => {
                        html += `<button class="arch-page-btn ${p === archiveCurrentPage ? 'arch-page-active' : ''}" onclick="goArchivePage(${p})">${p}</button>`;
                    });
                    if (pages[pages.length - 1] < totalPages) {
                        if (pages[pages.length - 1] < totalPages - 1) html += `<span class="arch-page-ellipsis">&hellip;</span>`;
                        html += `<button class="arch-page-btn" onclick="goArchivePage(${totalPages})">${totalPages}</button>`;
                    }

                    // Next
                    html += `<button class="arch-page-btn arch-page-next" ${archiveCurrentPage === totalPages ? 'disabled' : ''} onclick="goArchivePage(${archiveCurrentPage + 1})">Next &raquo;</button>`;

                    paginationCtrls.innerHTML = html;
                } else {
                    paginationBar.classList.add('hidden');
                }
            }

            function goArchivePage(page) {
                const totalPages = Math.ceil(archiveFilteredRows.length / ROWS_PER_PAGE);
                if (page < 1 || page > totalPages) return;
                archiveCurrentPage = page;
                renderArchivePage();
                // Scroll to top of table
                document.getElementById('archiveTableContainer').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            function filterByCard(card) {
                const filterVal    = card.getAttribute('data-filter');
                const statusSelect = document.getElementById('statusFilter');

                if (card.classList.contains('archive-stat-card--active')) {
                    card.classList.remove('archive-stat-card--active');
                    statusSelect.value = '';
                } else {
                    document.querySelectorAll('.archive-stat-card').forEach(c => c.classList.remove('archive-stat-card--active'));
                    card.classList.add('archive-stat-card--active');
                    statusSelect.value = filterVal;
                }

                filterTalents();

                const tableWrapper = document.getElementById('archiveTableContainer');
                if (tableWrapper) tableWrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            function initArchive() {
                filterTalents();

                document.getElementById('statusFilter').addEventListener('change', () => {
                    document.querySelectorAll('.archive-stat-card').forEach(c => c.classList.remove('archive-stat-card--active'));
                    const val = document.getElementById('statusFilter').value;
                    if (val !== '') {
                        document.querySelectorAll('.archive-stat-card').forEach(c => {
                            if (c.getAttribute('data-filter') === val) c.classList.add('archive-stat-card--active');
                        });
                    }
                });

                function syncSelectColor(sel) {
                    sel.style.color = sel.value === '' ? '#94a3b8' : '#334155';
                }
                document.querySelectorAll('.archive-select').forEach(sel => {
                    syncSelectColor(sel);
                    sel.addEventListener('change', () => syncSelectColor(sel));
                });
            }

            document.addEventListener('DOMContentLoaded', initArchive);
            document.addEventListener('livewire:navigated', initArchive);
        </script>
        <style>
            .archive-row td {
                vertical-align: middle;
            }

            /* ── Progress Archive Table: Perjelas garis & judul kolom Capitalize ── */
            .progress-archive-wrapper .prem-table th {
                text-transform: none;
                letter-spacing: 0;
                font-size: 0.8rem;
                color: #1e293b;
                border-bottom: 2px solid #cbd5e1;
                background: #f1f5f9;
            }

            .progress-archive-wrapper .prem-table tbody tr:last-child td {
                border-bottom: 1px solid #d1d5db;
            }

            .progress-archive-wrapper .prem-table td {
                border-bottom: 1px solid #d1d5db;
            }

            .progress-archive-wrapper .prem-card {
                border: 1.5px solid #cbd5e1;
            }

            /* ── Archive Stats Cards ── */
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
                gap: 10px;
                border: 1.5px solid #e2e8f0;
                box-shadow: 0 1px 4px rgba(0,0,0,0.06);
                position: relative;
                overflow: hidden;
                transition: transform .18s, box-shadow .18s;
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

            .archive-stat-card--teal::before  { background: linear-gradient(90deg,#14b8a6,#0d9488); }
            .archive-stat-card--green::before { background: linear-gradient(90deg,#22c55e,#16a34a); }
            .archive-stat-card--blue::before  { background: linear-gradient(90deg,#3b82f6,#2563eb); }
            .archive-stat-card--orange::before{ background: linear-gradient(90deg,#f97316,#ea580c); }
            .archive-stat-card--red::before   { background: linear-gradient(90deg,#ef4444,#dc2626); }

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

            /* teal */
            .archive-stat-icon--teal  { background: #ccfbf1; color: #0d9488; }
            /* green */
            .archive-stat-icon--green { background: #dcfce7; color: #16a34a; }
            /* blue */
            .archive-stat-icon--blue  { background: #dbeafe; color: #2563eb; }
            /* orange */
            .archive-stat-icon--orange{ background: #ffedd5; color: #ea580c; }
            /* red */
            .archive-stat-icon--red   { background: #fee2e2; color: #dc2626; }

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
            .archive-stat-card--green.archive-stat-card--active {
                border-color: #22c55e;
                box-shadow: 0 0 0 3px rgba(34,197,94,0.18), 0 6px 20px rgba(34,197,94,0.15);
                background: #f0fdf4;
            }
            .archive-stat-card--blue.archive-stat-card--active {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59,130,246,0.18), 0 6px 20px rgba(59,130,246,0.15);
                background: #eff6ff;
            }
            .archive-stat-card--orange.archive-stat-card--active {
                border-color: #f97316;
                box-shadow: 0 0 0 3px rgba(249,115,22,0.18), 0 6px 20px rgba(249,115,22,0.15);
                background: #fff7ed;
            }
            .archive-stat-card--red.archive-stat-card--active {
                border-color: #ef4444;
                box-shadow: 0 0 0 3px rgba(239,68,68,0.18), 0 6px 20px rgba(239,68,68,0.15);
                background: #fef2f2;
            }
            .archive-stat-card--active .archive-stat-count {
                color: #0f172a;
            }

            /* ── Pagination Styles ── */
            .archive-pagination-bar {
                align-items: center;
                justify-content: space-between;
                padding: 16px 20px;
                background-color: #f8fafc;
                border-top: 1px solid #e2e8f0;
            }
            .archive-pagination-bar:not(.hidden) {
                display: flex;
            }
            .archive-pagination-info {
                font-size: 13px;
                color: #64748b;
                font-weight: 500;
            }
            .archive-pagination-controls {
                display: flex;
                align-items: center;
                gap: 6px;
            }
            .arch-page-btn {
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
            .arch-page-btn:hover:not(:disabled) {
                background: #f8fafc;
                border-color: #cbd5e1;
                color: #334155;
            }
            .arch-page-active {
                background: #14b8a6 !important;
                border-color: #14b8a6 !important;
                color: #fff !important;
            }
            .arch-page-prev, .arch-page-next {
                color: #14b8a6;
                border-color: #ccfbf1;
            }
            .arch-page-prev:hover:not(:disabled), .arch-page-next:hover:not(:disabled) {
                background: #f0fdfb;
                border-color: #99f6e4;
                color: #0d9488;
            }
            .arch-page-btn:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }
            .arch-page-ellipsis {
                color: #94a3b8;
                font-weight: 600;
                padding: 0 4px;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    setTimeout(function () {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        setTimeout(function () {
                            alert.remove();
                        }, 500);
                    }, 3000);
                }
            });
        </script>
    </x-slot>

</x-pdc_admin.layout>