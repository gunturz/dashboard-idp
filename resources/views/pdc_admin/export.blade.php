<x-pdc_admin.layout title="Export – PDC Admin" :user="$user">

    <x-slot name="styles">
        <style>
            /* ── Page header ── */
            .export-header {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 36px;
            }
            .export-header svg {
                width: 28px;
                height: 28px;
                color: #2e3746;
            }
            .export-header h2 {
                font-size: 1.5rem;
                font-weight: 800;
                color: #2e3746;
            }
            .export-divider {
                height: 2px;
                background: linear-gradient(90deg, #e2e8f0 0%, transparent 100%);
                margin-bottom: 28px;
            }

            /* ── Filter Bar ── */
            .export-filters {
                display: flex;
                gap: 16px;
                margin-bottom: 32px;
                flex-wrap: wrap;
            }
            .export-filters .filter-search {
                flex: 1 1 340px;
                min-width: 200px;
            }
            .export-filters .filter-select {
                flex: 0 1 200px;
                min-width: 160px;
            }
            .filter-input {
                width: 100%;
                border: 2px solid #14b8a6;
                border-radius: 10px;
                padding: 10px 16px;
                font-size: 0.875rem;
                color: #475569;
                outline: none;
                transition: border-color 0.2s, box-shadow 0.2s;
                background: white;
            }
            .filter-input::placeholder {
                color: #9ca3af;
                font-weight: 500;
            }
            .filter-input:focus {
                border-color: #0d9488;
                box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.12);
            }
            .filter-select-el {
                width: 100%;
                border: 1.5px solid #e2e8f0;
                border-radius: 10px;
                padding: 10px 36px 10px 16px;
                font-size: 0.875rem;
                color: #475569;
                outline: none;
                background: white;
                appearance: none;
                background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394a3b8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E');
                background-repeat: no-repeat;
                background-position: right 0.75rem top 50%;
                background-size: 0.65rem auto;
                cursor: pointer;
                transition: border-color 0.2s;
            }
            .filter-select-el:focus {
                border-color: #14b8a6;
                box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
            }

            /* ── Group section ── */
            .export-group {
                margin-bottom: 40px;
            }
            .export-group-title {
                font-size: 1.15rem;
                font-weight: 800;
                color: #1e293b;
                text-align: center;
                margin-bottom: 4px;
            }
            .export-group-count {
                font-size: 0.7rem;
                color: #94a3b8;
                text-align: center;
                font-weight: 600;
                letter-spacing: 2px;
                text-transform: uppercase;
                margin-bottom: 16px;
            }

            /* ── Table ── */
            .export-table-wrap {
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                overflow: hidden;
                background: white;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            }
            .export-table {
                width: 100%;
                border-collapse: collapse;
            }
            .export-table th {
                background: #f8fafc;
                font-size: 0.85rem;
                font-weight: 700;
                color: #1e293b;
                padding: 14px 20px;
                text-align: center;
                border-bottom: 1px solid #e2e8f0;
            }
            .export-table th:first-child {
                text-align: left;
                padding-left: 28px;
            }
            .export-table td {
                padding: 18px 20px;
                vertical-align: middle;
                border-bottom: 1px solid #f1f5f9;
            }
            .export-table tbody tr:last-child td {
                border-bottom: none;
            }
            .export-table tbody tr {
                transition: background 0.15s;
            }
            .export-table tbody tr:hover {
                background: #f8fffe;
            }

            /* ── Talent cell ── */
            .talent-cell {
                display: flex;
                align-items: center;
                gap: 14px;
                padding-left: 8px;
            }
            .talent-avatar {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e2e8f0;
                flex-shrink: 0;
                box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            }
            .talent-avatar-placeholder {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 1rem;
                color: #0284c7;
                flex-shrink: 0;
                border: 2px solid #e2e8f0;
                box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            }
            .talent-info .talent-name {
                font-weight: 700;
                color: #1e293b;
                font-size: 0.9rem;
                display: block;
                line-height: 1.3;
            }
            .talent-info .talent-dept {
                font-size: 0.78rem;
                color: #64748b;
                font-style: italic;
                display: block;
                margin-top: 2px;
            }

            /* ── Export PDF Button ── */
            .btn-export-pdf {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: #ef4444;
                color: white;
                font-size: 0.8rem;
                font-weight: 700;
                padding: 8px 22px;
                border-radius: 8px;
                border: none;
                cursor: pointer;
                transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
                box-shadow: 0 2px 6px rgba(239, 68, 68, 0.25);
                text-decoration: none;
            }
            .btn-export-pdf:hover {
                background: #dc2626;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            }
            .btn-export-pdf:active {
                transform: scale(0.97);
            }

            /* ── Action column center ── */
            .action-col {
                text-align: center;
            }

            /* ── Empty state ── */
            .export-empty {
                background: white;
                padding: 48px;
                border-radius: 14px;
                border: 2px dashed #e2e8f0;
                text-align: center;
                color: #94a3b8;
                font-size: 0.95rem;
            }

            /* ── Responsive ── */
            @media (max-width: 768px) {
                .export-filters {
                    flex-direction: column;
                }
                .export-filters .filter-search,
                .export-filters .filter-select {
                    flex: 1 1 100%;
                }
                .export-table th:first-child {
                    padding-left: 16px;
                }
                .talent-cell {
                    padding-left: 0;
                }
                .export-group-title {
                    font-size: 1rem;
                }
            }
        </style>
    </x-slot>

    {{-- Page Header --}}
    <div class="export-header animate-title">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>
        <h2>Export</h2>
    </div>


    {{-- Filter Bar --}}
    <div class="export-filters">
        <div class="filter-search relative">
            <input type="text" id="searchTalent" placeholder="Cari Nama Talent" onkeyup="filterExport()"
                class="peer w-full border border-slate-200 rounded-lg py-2.5 pl-4 pr-10 text-sm text-[#2e3746] placeholder-gray-400 outline-none focus:border-[#14b8a6] focus:ring-1 focus:ring-[#14b8a6] transition-colors bg-white shadow-sm">
            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 peer-focus:text-[#14b8a6] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        <div class="filter-select relative">
            <select id="filterJabatan" class="w-full border border-slate-200 rounded-lg py-2.5 px-4 text-sm text-[#2e3746] outline-none focus:border-[#14b8a6] focus:ring-1 focus:ring-[#14b8a6] bg-white appearance-none transition-colors shadow-sm" style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;" onchange="filterExport()">
                <option value="">Semua Jabatan</option>
                @foreach ($positions as $pos)
                    <option value="{{ $pos->id }}">{{ $pos->position_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-select relative">
            <select id="filterPerusahaan" class="w-full border border-slate-200 rounded-lg py-2.5 px-4 text-sm text-[#2e3746] outline-none focus:border-[#14b8a6] focus:ring-1 focus:ring-[#14b8a6] bg-white appearance-none transition-colors shadow-sm" style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;" onchange="filterExport()">
                <option value="">Semua Perusahaan</option>
                @foreach ($companies as $comp)
                    <option value="{{ $comp->id }}">{{ $comp->nama_company }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Grouped Talent Sections --}}
    <div id="exportSections">
        @forelse ($groupedData as $key => $group)
            <div class="export-group" data-position-id="{{ $group['targetPosition']->id ?? '' }}"
                data-company-id="{{ $group['company']->id ?? '' }}">

                <h3 class="export-group-title">
                    {{ $group['targetPosition']->position_name ?? 'Unassigned' }}
                    – {{ $group['company']->nama_company ?? 'Unknown' }}
                </h3>
                <p class="export-group-count">
                    {{ count($group['talents']) }} TALENT
                </p>

                <div class="export-table-wrap">
                    <table class="export-table">
                        <thead>
                            <tr>
                                <th style="width: 70%;">Talent</th>
                                <th style="width: 30%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($group['talents'] as $talent)
                                <tr class="talent-row" data-name="{{ strtolower($talent->nama) }}">
                                    <td>
                                        <div class="talent-cell">
                                            @if ($talent->foto)
                                                <img src="{{ asset('storage/' . $talent->foto) }}"
                                                    alt="{{ $talent->nama }}" class="talent-avatar">
                                            @else
                                                <div class="talent-avatar-placeholder">
                                                    {{ strtoupper(substr($talent->nama, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="talent-info">
                                                <span class="talent-name">{{ $talent->nama }}</span>
                                                <p class="text-xs text-gray-500 italic mt-1">{{ $talent->position->position_name ?? '-' }} &rarr; {{ $talent->promotion_plan->targetPosition->position_name ?? '?' }}</p>
                                                <span class="talent-dept">
                                                    {{ optional($talent->department)->nama_department ?? '-' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="action-col">
                                        <a href="#" class="btn-export-pdf"
                                            onclick="alert('Export PDF untuk {{ $talent->nama }} (coming soon)')">
                                            Export PDF
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="export-empty">
                <p>Belum ada data talent yang terdaftar.</p>
            </div>
        @endforelse
    </div>

    <x-slot name="scripts">
        <script>
            function filterExport() {
                const search = document.getElementById('searchTalent').value.toLowerCase().trim();
                const jabatan = document.getElementById('filterJabatan').value;
                const perusahaan = document.getElementById('filterPerusahaan').value;

                document.querySelectorAll('.export-group').forEach(group => {
                    const posId = group.getAttribute('data-position-id');
                    const compId = group.getAttribute('data-company-id');

                    // Company / Position filter
                    let groupVisible = true;
                    if (jabatan && posId !== jabatan) groupVisible = false;
                    if (perusahaan && compId !== perusahaan) groupVisible = false;

                    if (!groupVisible) {
                        group.style.display = 'none';
                        return;
                    }

                    // Name search within rows
                    let visibleCount = 0;
                    group.querySelectorAll('.talent-row').forEach(row => {
                        const name = row.getAttribute('data-name');
                        if (search && !name.includes(search)) {
                            row.style.display = 'none';
                        } else {
                            row.style.display = '';
                            visibleCount++;
                        }
                    });

                    // Update count text
                    const countEl = group.querySelector('.export-group-count');
                    if (countEl) countEl.textContent = visibleCount + ' TALENT';

                    group.style.display = visibleCount > 0 ? '' : 'none';
                });
            }
        </script>
    </x-slot>

</x-pdc_admin.layout>
