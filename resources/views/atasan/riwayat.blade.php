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
                border: 1px solid #d1d5db;
                border-radius: 12px;
                overflow: hidden;
                background: #fff;
            }

            .riwayat-table {
                width: 100%;
                border-collapse: collapse;
            }

            .riwayat-table thead tr {
                background: #f1f5f9;
            }

            .riwayat-table th {
                padding: 14px 16px;
                text-align: center;
                font-size: 0.875rem;
                font-weight: 700;
                color: #1e293b;
                border-bottom: 1px solid #d1d5db;
                border-right: 1px solid #d1d5db;
                white-space: nowrap;
            }

            .riwayat-table th:last-child { border-right: none; }

            .riwayat-table tbody tr {
                border-bottom: 1px solid #e2e8f0;
                transition: background 0.15s;
            }

            .riwayat-table tbody tr:last-child { border-bottom: none; }

            .riwayat-table tbody tr:hover { background: #f8fafc; }

            .riwayat-table td {
                padding: 16px;
                font-size: 0.875rem;
                color: #475569;
                text-align: center;
                border-right: 1px solid #e2e8f0;
                vertical-align: middle;
            }

            .riwayat-table td:last-child { border-right: none; }

            /* Talent name cell */
            .talent-name {
                font-weight: 700;
                color: #1e293b;
                display: block;
                text-align: left;
            }

            .talent-position {
                font-size: 0.775rem;
                color: #64748b;
                font-style: italic;
                display: block;
                text-align: left;
            }

            .riwayat-table td:first-child {
                text-align: left;
            }

            /* Lihat Detail button */
            .btn-detail {
                display: inline-block;
                padding: 7px 18px;
                background: #f1f5f9;
                border: 1px solid #d1d5db;
                border-radius: 7px;
                font-size: 0.8rem;
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

    <div class="riwayat-wrapper">

        {{-- ── Page Title ─────────────────────────────── --}}
        <div class="page-title">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
            </svg>
            <h1>Riwayat Penilaian</h1>
        </div>

        {{-- ── Filter Bar ──────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row items-center gap-4 mb-6">

            {{-- Cari Nama --}}
            <div class="relative w-full sm:w-[35%]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input
                    type="text"
                    placeholder="Cari Nama"
                    autocomplete="off"
                    id="live-search-input"
                    class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                    oninput="filterRiwayat()"
                >
            </div>

            {{-- Semua Periode --}}
            <div class="relative w-full sm:w-[21%]">
                <select id="filter-periode" class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent bg-white appearance-none transition-all" style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;" onchange="filterRiwayat()">
                    <option value="">Semua Periode</option>
                    @foreach($periodeOptions as $opt)
                        <option value="{{ $opt }}">{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Semua Perusahaan --}}
            <div class="relative w-full sm:w-[21%]">
                <select id="filter-perusahaan" class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent bg-white appearance-none transition-all" style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;" onchange="filterRiwayat()">
                    <option value="">Semua Perusahaan</option>
                    @foreach($perusahaanOptions as $opt)
                        <option value="{{ $opt }}">{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Semua Departemen --}}
            <div class="relative w-full sm:w-[21%]">
                <select id="filter-departemen" class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent bg-white appearance-none transition-all" style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;" onchange="filterRiwayat()">
                    <option value="">Semua Departemen</option>
                    @foreach($departemenOptions as $opt)
                        <option value="{{ $opt }}">{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- ── Table ───────────────────────────────────── --}}
        <div class="table-wrapper">
            <table class="riwayat-table">
                <thead>
                    <tr>
                        <th>Talent</th>
                        <th>Perusahaan</th>
                        <th>Departemen</th>
                        <th>Start Date</th>
                        <th>Due Date</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="riwayat-tbody">
                    @forelse($talents as $talent)
                        @php
                            $plan       = $talent->promotion_plan;
                            $startDate  = $plan?->start_date;
                            $targetDate = $plan?->target_date;
                            $posName    = $talent->position?->position_name ?? '-';
                            $targetPos  = $plan?->targetPosition?->position_name ?? '?';
                            $compName   = $talent->company?->nama_company ?? '-';
                            $deptName   = $talent->department?->nama_department ?? '-';
                            
                            $periodeLabel = '';
                            if ($startDate && $targetDate) {
                                $periodeLabel = $startDate->format('Y') . ' – ' . $targetDate->format('Y');
                            }
                        @endphp
                        <tr class="riwayat-row-item" 
                            data-name="{{ strtolower($talent->nama) }}" 
                            data-periode="{{ $periodeLabel }}"
                            data-perusahaan="{{ $compName }}"
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
                            <td>
                                <a href="{{ route('atasan.monitoring.detail', $talent->id) }}" class="btn-detail">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr id="empty-row">
                            <td colspan="6">
                                <div class="empty-state">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p>Tidak ada data talent yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    
                    {{-- Hidden empty row for JS filtering --}}
                    <tr id="js-empty-row" class="hidden">
                        <td colspan="6">
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p>Tidak ada data yang sesuai dengan filter.</p>
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

            {{-- Auto-open bell notif setelah beri nilai --}}
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
