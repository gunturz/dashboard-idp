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
                font-size: 0.75rem;
                font-weight: 700;
                color: #475569;
                border-bottom: 1px solid #e2e8f0;
                white-space: nowrap;
                text-transform: capitalize;
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
                font-size: 0.82rem;
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
                text-align: center;
            }

            .talent-position {
                font-size: 0.78rem;
                color: #64748b;
                font-style: italic;
                display: block;
                text-align: center;
                margin-top: 2px;
            }

            /* Lihat Detail button */
            .btn-detail {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 20px;
                background: #14b8a6;
                border: none;
                border-radius: 12px;
                font-size: 0.813rem;
                font-weight: 700;
                color: #ffffff;
                text-decoration: none;
                transition: all 0.2s;
                white-space: nowrap;
            }

            .btn-detail svg {
                width: 16px;
                height: 16px;
                stroke-width: 2.5;
            }

            .btn-detail:hover {
                background: #0d9488;
                color: #ffffff;
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

            /* ── Dropdown Filter Styles ── */
            .filter-select {
                width: 100%;
                background-color: white;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 10px 32px 10px 16px;
                font-size: 0.875rem;
                color: #334155;
                outline: none;
                transition: all 0.2s;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 12px center;
                background-size: 16px;
            }

            .filter-select:focus {
                border-color: #14b8a6;
                box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.12);
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

    <div class="flex flex-col sm:flex-row items-center gap-4 mb-6">
        {{-- Cari Nama --}}
        <div class="relative w-full sm:flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" id="live-search-input" placeholder="Cari Nama Talent…"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                oninput="filterRiwayat()">
        </div>

        {{-- Filters --}}
        <div class="relative w-full sm:w-48">
            <select id="filter-periode" class="filter-select" onchange="filterRiwayat()">
                <option value="">Semua Periode</option>
                @foreach($periodeOptions as $opt)
                    <option value="{{ $opt }}">{{ $opt }}</option>
                @endforeach
            </select>
        </div>

        <div class="relative w-full sm:w-56">
            <select id="filter-perusahaan" class="filter-select" onchange="filterRiwayat()">
                <option value="">Semua Perusahaan</option>
                @foreach($perusahaanOptions as $opt)
                    <option value="{{ $opt }}">{{ $opt }}</option>
                @endforeach
            </select>
        </div>

        <div class="relative w-full sm:w-56">
            <select id="filter-departemen" class="filter-select" onchange="filterRiwayat()">
                <option value="">Semua Departemen</option>
                @foreach($departemenOptions as $opt)
                    <option value="{{ $opt }}">{{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div
        class="log-table-container custom-scrollbar overflow-x-auto border border-slate-200 rounded-xl bg-white shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="py-4 px-6 text-sm font-bold text-slate-700 tracking-wider text-center"
                        style="min-width: 200px;">Talent</th>
                    <th class="py-4 px-6 text-sm font-bold text-slate-700 tracking-wider text-center">Perusahaan</th>
                    <th class="py-4 px-6 text-sm font-bold text-slate-700 tracking-wider text-center">Departemen</th>
                    <th class="py-4 px-6 text-sm font-bold text-slate-700 tracking-wider text-center">Start Date</th>
                    <th class="py-4 px-6 text-sm font-bold text-slate-700 tracking-wider text-center">Due Date</th>
                    <th class="py-4 px-6 text-sm font-bold text-slate-700 tracking-wider text-center">Aksi</th>
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
                    <tr class="riwayat-row-item border-b border-gray-100 hover:bg-slate-50/50 transition duration-150"
                        data-name="{{ strtolower($talent->nama) }}" data-periode="{{ $periodeLabel }}"
                        data-perusahaan="{{ $compName }}" data-departemen="{{ $deptName }}">
                        {{-- Talent --}}
                        <td class="py-4 px-6 text-center text-sm">
                            <span class="talent-name font-bold text-slate-800 block">{{ $talent->nama }}</span>
                            <span class="talent-position text-xs text-gray-400 italic font-medium block mt-1">{{ $posName }}
                                – {{ $targetPos }}</span>
                        </td>

                        {{-- Perusahaan --}}
                        <td class="py-4 px-6 text-center text-sm font-bold text-slate-800">{{ $compName }}</td>

                        {{-- Departemen --}}
                        <td class="py-4 px-6 text-center text-sm font-semibold text-slate-600">{{ $deptName }}</td>

                        {{-- Start Date --}}
                        <td class="py-4 px-6 text-center text-sm font-medium text-slate-800 whitespace-nowrap">
                            {{ $startDate ? $startDate->translatedFormat('d F Y') : '-' }}
                        </td>

                        {{-- Due Date --}}
                        <td class="py-4 px-6 text-center text-sm font-medium text-slate-800 whitespace-nowrap">
                            {{ $targetDate ? $targetDate->translatedFormat('d F Y') : '-' }}
                        </td>

                        {{-- Aksi --}}
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('atasan.riwayat.detail', $talent->id) }}"
                                class="btn-detail inline-flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr id="empty-row">
                        <td colspan="6">
                            <div class="py-12 flex flex-col items-center justify-center text-gray-400">
                                <p class="font-medium">Tidak ada data talent yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse

                {{-- Hidden empty row for JS filtering --}}
                <tr id="js-empty-row" class="hidden">
                    <td colspan="6">
                        <div class="py-12 flex flex-col items-center justify-center text-gray-400">
                            <p class="font-medium">Tidak ada data yang sesuai dengan filter.</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
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