<x-atasan.layout title="Riwayat Penilaian – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* ============================================================
               RIWAYAT PENILAIAN – TABLE LAYOUT
               ============================================================ */

            .riwayat-wrapper {
                max-width: 1200px;
                margin: 0 auto;
            }

            /* ── Page Title ─────────────────────────────────────── */
            .page-title {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 28px;
            }

            .page-title h1 {
                font-size: 1.5rem;
                font-weight: 800;
                color: #1e293b;
                margin: 0;
            }


            /* ── Table ──────────────────────────────────────────── */
            .table-wrapper {
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
                background: #ffffff;
            }

            .highlight-table {
                width: 100%;
                border-collapse: collapse;
            }

            .highlight-table thead tr {
                background: #f8fafc;
            }

            .highlight-table th {
                padding: 12px 16px;
                text-align: left;
                font-size: 0.85rem;
                font-weight: 700;
                color: #475569;
                border-bottom: 1px solid #e2e8f0;
                white-space: nowrap;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }


            .riwayat-table th:last-child {
                border-right: none;
            }

            .riwayat-table tbody tr {
                border-bottom: 1px solid #e2e8f0;
                transition: background 0.15s;
            }

            .riwayat-table tbody tr:last-child {
                border-bottom: none;
            }

            .riwayat-table tbody tr:hover {
                background: #f8fafc;

            }

            .highlight-table td {
                padding: 16px;
                font-size: 0.95rem;
                color: #334155;
                text-align: left;
                vertical-align: middle;
            }

            .riwayat-table td:last-child {
                border-right: none;
            }


            /* Talent name cell */
            .talent-name {
                font-weight: 600;
                color: #1e293b;
                display: block;
                text-align: left;
            }

            .talent-position {
                font-size: 0.85rem;
                color: #64748b;
                font-style: italic;
                display: block;
                text-align: left;
                margin-top: 2px;
            }

            /* Lihat Detail button */
            .btn-detail {
                display: inline-block;
                padding: 7px 18px;
                background: #f1f5f9;
                border: 1px solid #d1d5db;
                border-radius: 7px;
                font-size: 0.9rem;
                font-weight: 600;
                color: #475569;
                text-decoration: none;
                transition: all 0.2s;
                white-space: nowrap;
            }

            .btn-detail:hover {
                background: #e2e8f0;
                border-color: #14b8a6;
                color: #0d9488;
            }

            /* Empty state */
            .empty-state {
                padding: 48px 24px;
                text-align: center;
                color: #94a3b8;
            }

            .empty-state svg {
                width: 48px;
                height: 48px;
                margin: 0 auto 12px;
                display: block;
                color: #cbd5e1;
            }
        </style>
    </x-slot>

    {{-- ── Page Header ── --}}
    <div class="page-header animate-title">
        <div class="page-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <h1 class="page-header-title">Riwayat Penilaian</h1>
            <p class="page-header-sub">Arsip seluruh penilaian talent yang telah Anda selesaikan</p>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-6">
        {{-- Cari Nama --}}
        <div class="relative flex-grow group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="live-search-input" placeholder="Cari Nama Talent…" 
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                oninput="filterRiwayat()">
        </div>

        {{-- Filters --}}
        <div class="flex flex-wrap gap-4">
            <select id="filter-periode" class="min-w-[160px] bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all" onchange="filterRiwayat()">
                <option value="">Semua Periode</option>
                @foreach($periodeOptions as $opt)
                    <option value="{{ $opt }}">{{ $opt }}</option>
                @endforeach
            </select>

            <select id="filter-perusahaan" class="min-w-[180px] bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all" onchange="filterRiwayat()">
                <option value="">Semua Perusahaan</option>
                @foreach($perusahaanOptions as $opt)
                    <option value="{{ $opt }}">{{ $opt }}</option>
                @endforeach
            </select>

            <select id="filter-departemen" class="min-w-[180px] bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all" onchange="filterRiwayat()">
                <option value="">Semua Departemen</option>
                @foreach($departemenOptions as $opt)
                    <option value="{{ $opt }}">{{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="prem-card">
        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-4 mb-8">
                {{-- Cari Nama --}}
                <div class="relative flex-grow group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor"
                        class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 group-focus-within:text-[#14b8a6] transition-colors pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="live-search-input" placeholder="Cari Nama Talent…"
                        class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all shadow-sm"
                        oninput="filterRiwayat()">
                </div>

                {{-- Filters --}}
                <div class="flex flex-wrap gap-4">
                    <select id="filter-periode"
                        class="min-w-[160px] border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white transition-all shadow-sm"
                        onchange="filterRiwayat()">
                        <option value="">Semua Periode</option>
                        @foreach($periodeOptions as $opt)
                            <option value="{{ $opt }}">{{ $opt }}</option>
                        @endforeach
                    </select>

                    <select id="filter-perusahaan"
                        class="min-w-[180px] border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white transition-all shadow-sm"
                        onchange="filterRiwayat()">
                        <option value="">Semua Perusahaan</option>
                        @foreach($perusahaanOptions as $opt)
                            <option value="{{ $opt }}">{{ $opt }}</option>
                        @endforeach
                    </select>

                    <select id="filter-departemen"
                        class="min-w-[180px] border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white transition-all shadow-sm"
                        onchange="filterRiwayat()">
                        <option value="">Semua Departemen</option>
                        @foreach($departemenOptions as $opt)
                            <option value="{{ $opt }}">{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="highlight-table">
                    <thead>
                        <tr>
                            <th style="min-width: 200px;">Talent</th>
                            <th>Perusahaan</th>
                            <th>Departemen</th>
                            <th>Start Date</th>
                            <th>Due Date</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="riwayat-tbody">
                        @forelse($talents as $talent)
                            @php
                                $plan = $talent->promotion_plan;
                                $startDate = $plan?->start_date;
                                $targetDate = $plan?->target_date;
                                $posName = $talent->position?->position_name ?? '-';
                                $targetPos = $plan?->targetPosition?->position_name ?? '?';
                                $compName = $talent->company?->nama_company ?? '-';
                                $deptName = $talent->department?->nama_department ?? '-';

                                $periodeLabel = '';
                                if ($startDate && $targetDate) {
                                    $periodeLabel = $startDate->format('Y') . ' – ' . $targetDate->format('Y');
                                }
                            @endphp
                            <tr class="riwayat-row-item" data-name="{{ strtolower($talent->nama) }}"
                                data-periode="{{ $periodeLabel }}" data-perusahaan="{{ $compName }}"
                                data-departemen="{{ $deptName }}">
                                {{-- Talent --}}
                                <td>
                                    <span class="talent-name">{{ $talent->nama }}</span>
                                    <span class="talent-position">{{ $posName }} – {{ $targetPos }}</span>
                                </td>

                                {{-- Perusahaan --}}
                                <td>{{ $compName }}</td>

                                {{-- Departemen --}}
                                <td>{{ $deptName }}</td>

                                {{-- Start Date --}}
                                <td>
                                    {{ $startDate ? $startDate->translatedFormat('d F Y') : '-' }}
                                </td>

                                {{-- Due Date --}}
                                <td>
                                    {{ $targetDate ? $targetDate->translatedFormat('d F Y') : '-' }}
                                </td>

                                {{-- Aksi --}}
                                <td class="text-center">
                                    <a href="{{ route('atasan.riwayat.detail', $talent->id) }}"
                                        class="btn-prem btn-teal px-4 py-1.5 rounded-lg shadow-sm">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-row">
                                <td colspan="6">
                                    <div class="py-12 flex flex-col items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 opacity-20"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="font-medium">Tidak ada data talent yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                        {{-- Hidden empty row for JS filtering --}}
                        <tr id="js-empty-row" class="hidden">
                            <td colspan="6">
                                <div class="py-12 flex flex-col items-center justify-center text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 opacity-20"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="font-medium">Tidak ada data yang sesuai dengan filter.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <x-slot name="scripts">
            <script>
                function filterRiwayat() {
                    const searchTxt = document.getElementById('live-search-input').value.toLowerCase().trim();
                    const periode = document.getElementById('filter-periode').value;
                    const perusahaan = document.getElementById('filter-perusahaan').value;
                    const departemen = document.getElementById('filter-departemen').value;

                    const rows = document.querySelectorAll('.riwayat-row-item');
                    let visibleCount = 0;

                    rows.forEach(row => {
                        const rowName = row.getAttribute('data-name') || '';
                        const rowPeriode = row.getAttribute('data-periode') || '';
                        const rowPerusahaan = row.getAttribute('data-perusahaan') || '';
                        const rowDepartemen = row.getAttribute('data-departemen') || '';

                        const matchName = rowName.includes(searchTxt);
                        const matchPeriode = periode === '' || rowPeriode === periode;
                        const matchPerusahaan = perusahaan === '' || rowPerusahaan === perusahaan;
                        const matchDepartemen = departemen === '' || rowDepartemen === departemen;

                        if (matchName && matchPeriode && matchPerusahaan && matchDepartemen) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    const emptyRow = document.getElementById('js-empty-row');
                    if (emptyRow) {
                        emptyRow.classList.toggle('hidden', visibleCount > 0);
                    }
                }

                { { --Auto - open bell notif setelah beri nilai-- } }
                @if(session('open_bell_notif'))
                    document.addEventListener('DOMContentLoaded', () => {
                        setTimeout(() => {
                            const bellBtn = document.getElementById('bell-btn');
                            if (bellBtn && typeof toggleDropdown === 'function') {
                                toggleDropdown('bell-dropdown', 'bell-btn');
                            }
                        }, 100);
                    });
                @endif
            </script>
        </x-slot>

</x-atasan.layout>