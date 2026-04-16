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

            /* ── Filter Bar ─────────────────────────────────────── */
            .filter-bar {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 24px;
                width: 100%;
            }

            /* Search box */
            .search-box {
                position: relative;
                flex: 1;           /* ambil sisa ruang bersama dropdown */
                min-width: 0;
            }

            .search-input {
                width: 100%;
                padding: 10px 40px 10px 14px;
                border: 1.5px solid #e2e8f0;
                border-radius: 8px;
                font-size: 0.875rem;
                color: #475569;
                background: #fff;
                outline: none;
                transition: all 0.2s;
                box-sizing: border-box;
            }

            .search-input::placeholder { color: #94a3b8; }

            .search-input:focus {
                border-color: #14b8a6;
            }

            .search-icon {
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
                background: none;
                border: none;
                cursor: pointer;
                padding: 0;
                display: flex;
                transition: color 0.2s;
            }

            .search-input:focus + .search-icon {
                color: #14b8a6;
            }

            /* Dropdown select */
            .filter-select-wrap {
                position: relative;
                flex: 1;           /* sama-sama tumbuh mengisi lebar */
                min-width: 0;
            }

            .filter-select {
                width: 100%;
                appearance: none;
                -webkit-appearance: none;
                padding: 10px 36px 10px 14px;
                border: 1.5px solid #e2e8f0;
                border-radius: 8px;
                font-size: 0.875rem;
                color: #475569;
                background: #fff;
                cursor: pointer;
                outline: none;
                transition: border-color 0.2s;
                box-sizing: border-box;
            }

            .filter-select:focus { border-color: #14b8a6; }

            .filter-select-wrap::after {
                content: '';
                position: absolute;
                right: 13px;
                top: 50%;
                transform: translateY(-50%);
                width: 0;
                height: 0;
                border-left: 5px solid transparent;
                border-right: 5px solid transparent;
                border-top: 6px solid #64748b;
                pointer-events: none;
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
        <form method="GET" action="{{ route('atasan.riwayat') }}" class="filter-bar" id="filter-form">

            {{-- Cari Nama --}}
            <div class="search-box">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari Nama"
                    class="search-input"
                    autocomplete="off"
                    id="search-input"
                >
                <button type="submit" class="search-icon" aria-label="Cari">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>

            {{-- Semua Periode --}}
            <div class="filter-select-wrap">
                <select name="periode" class="filter-select" onchange="document.getElementById('filter-form').submit()">
                    <option value="">Semua Periode</option>
                    @foreach($periodeOptions as $opt)
                        <option value="{{ $opt }}" {{ $filterPeriode === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Semua Perusahaan --}}
            <div class="filter-select-wrap">
                <select name="perusahaan" class="filter-select" onchange="document.getElementById('filter-form').submit()">
                    <option value="">Semua Perusahaan</option>
                    @foreach($perusahaanOptions as $opt)
                        <option value="{{ $opt }}" {{ $filterPerusahaan === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Semua Departemen --}}
            <div class="filter-select-wrap">
                <select name="departemen" class="filter-select" onchange="document.getElementById('filter-form').submit()">
                    <option value="">Semua Departemen</option>
                    @foreach($departemenOptions as $opt)
                        <option value="{{ $opt }}" {{ $filterDepartemen === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

        </form>

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
                <tbody>
                    @forelse($talents as $talent)
                        @php
                            $plan       = $talent->promotion_plan;
                            $startDate  = $plan?->start_date;
                            $targetDate = $plan?->target_date;
                            $posName    = $talent->position?->position_name ?? '-';
                            $targetPos  = $plan?->targetPosition?->position_name ?? '?';
                        @endphp
                        <tr>
                            {{-- Talent --}}
                            <td>
                                <span class="talent-name">{{ $talent->nama }}</span>
                                <span class="talent-position">{{ $posName }} – {{ $targetPos }}</span>
                            </td>

                            {{-- Perusahaan --}}
                            <td>{{ $talent->company?->nama_perusahaan ?? '-' }}</td>

                            {{-- Departemen --}}
                            <td>{{ $talent->department?->nama_department ?? '-' }}</td>

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
                        <tr>
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
                </tbody>
            </table>
        </div>

    </div>

    {{-- Auto-open bell notif setelah beri nilai --}}
    @if(session('open_bell_notif'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    const bellBtn = document.getElementById('bell-btn');
                    if (bellBtn && typeof toggleDropdown === 'function') {
                        toggleDropdown('bell-dropdown', 'bell-btn');
                    }
                }, 100);
            });
        </script>
    @endif

</x-atasan.layout>
