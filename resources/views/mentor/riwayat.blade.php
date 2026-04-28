<x-mentor.layout title="Riwayat Penilaian – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            .riwayat-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.875rem;
            }
            .riwayat-table th {
                background: #f8fafc;
                color: #1e293b;
                font-weight: 700;
                font-size: 0.78rem;
                text-align: center;
                padding: 14px 16px;
                border-bottom: 2px solid #e2e8f0;
                white-space: nowrap;
            }
            .riwayat-table th:first-child { text-align: left; padding-left: 20px; }
            .riwayat-table td {
                padding: 16px 16px;
                color: #475569;
                border-top: 1px solid #f1f5f9;
                text-align: center;
                vertical-align: middle;
            }
            .riwayat-table td:first-child { text-align: left; padding-left: 20px; }
            .riwayat-table tr:hover td { background: #f8fafc; }

            .filter-input, .filter-select {
                height: 40px;
                padding: 0 14px;
                border: 1.5px solid #e2e8f0;
                border-radius: 10px;
                font-size: 0.85rem;
                color: #334155;
                background: white;
                outline: none;
                transition: border-color 0.2s, box-shadow 0.2s;
                font-family: inherit;
            }
            .filter-input:focus, .filter-select:focus {
                border-color: #14b8a6;
                box-shadow: 0 0 0 3px rgba(20,184,166,0.12);
            }
            .filter-select {
                padding-right: 32px;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 10px center;
                background-size: 16px;
            }
            .btn-lihat-detail {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                background: white;
                color: #0f172a;
                font-size: 0.78rem;
                font-weight: 700;
                padding: 6px 14px;
                border-radius: 8px;
                border: 1.5px solid #cbd5e1;
                transition: all 0.2s;
                text-decoration: none;
                white-space: nowrap;
            }
            .btn-lihat-detail:hover {
                background: #0f172a;
                color: white;
                border-color: #0f172a;
            }
        </style>
    </x-slot>

    <div class="w-full">

        {{-- Page Title --}}
        <div class="flex items-center gap-3 mb-7">
            <div class="w-10 h-10 rounded-xl bg-[#0f172a] flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-[#1e293b]">Riwayat</h2>
                <p class="text-sm text-gray-500">Talent yang sudah selesai penilaian panelis</p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="flex flex-wrap items-center gap-3 mb-5">
            {{-- Search --}}
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#94a3b8;pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="search-input" placeholder="Cari Nama…"
                    class="filter-input pl-9 w-52"
                    oninput="filterTable()">
            </div>

            {{-- Perusahaan --}}
            <select id="filter-company" class="filter-select w-48" onchange="filterTable()">
                <option value="">Semua Perusahaan</option>
                @php $companies = $completedTalents->pluck('company.nama_company','company_id')->filter()->unique(); @endphp
                @foreach($companies as $cId => $cName)
                    <option value="{{ $cId }}">{{ $cName }}</option>
                @endforeach
            </select>

            {{-- Departemen --}}
            <select id="filter-dept" class="filter-select w-48" onchange="filterTable()">
                <option value="">Semua Departemen</option>
                @php $depts = $completedTalents->pluck('department.nama_department','department_id')->filter()->unique(); @endphp
                @foreach($depts as $dId => $dName)
                    <option value="{{ $dId }}">{{ $dName }}</option>
                @endforeach
            </select>
        </div>

        {{-- Table --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            @if($completedTalents->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="riwayat-table" id="riwayat-table">
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
                        @foreach($completedTalents as $talent)
                        <tr class="riwayat-row"
                            data-name="{{ strtolower($talent->nama) }}"
                            data-company="{{ $talent->company_id }}"
                            data-dept="{{ $talent->department_id }}">
                            {{-- Talent --}}
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=e2e8f0&color=475569' }}"
                                        class="w-9 h-9 rounded-full object-cover border border-gray-200 flex-shrink-0">
                                    <div class="text-left">
                                        <p class="font-bold text-[14px] text-slate-800 leading-tight">{{ $talent->nama }}</p>
                                        <p class="text-[11px] text-gray-500 italic mt-0.5">
                                            {{ optional($talent->position)->position_name ?? '-' }}  &rarr;
                                            {{ optional($talent->promotion_plan)->targetPosition->position_name ?? '?' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            {{-- Perusahaan --}}
                            <td class="text-sm text-[#475569]">{{ optional($talent->company)->nama_company ?? '-' }}</td>
                            {{-- Departemen --}}
                            <td class="text-sm text-[#475569]">{{ optional($talent->department)->nama_department ?? '-' }}</td>
                            {{-- Start Date --}}
                            <td class="text-sm">
                                {{ optional(optional($talent->promotion_plan)->start_date)?->format('d F Y') ?? '-' }}
                            </td>
                            {{-- Due Date --}}
                            <td class="text-sm">
                                {{ optional(optional($talent->promotion_plan)->target_date)?->format('d F Y') ?? '-' }}
                            </td>
                            {{-- Aksi --}}
                            <td>
                                <a href="{{ route('mentor.riwayat.logbook', $talent->id) }}" class="btn-lihat-detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="py-20 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-gray-500 font-medium text-sm">Belum ada talent yang menyelesaikan penilaian panelis.</p>
            </div>
            @endif
        </div>

        {{-- Empty filtered result message --}}
        <div id="no-results" class="hidden py-8 text-center text-gray-400 text-sm font-medium">
            Tidak ada data yang cocok dengan filter.
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function filterTable() {
                const search  = document.getElementById('search-input').value.toLowerCase().trim();
                const company = document.getElementById('filter-company').value;
                const dept    = document.getElementById('filter-dept').value;

                const rows = document.querySelectorAll('.riwayat-row');
                let visible = 0;

                rows.forEach(row => {
                    const name    = row.dataset.name || '';
                    const rowComp = row.dataset.company || '';
                    const rowDept = row.dataset.dept || '';

                    const ok = (!search || name.includes(search))
                            && (!company || rowComp === company)
                            && (!dept || rowDept === dept);

                    row.style.display = ok ? '' : 'none';
                    if (ok) visible++;
                });

                document.getElementById('no-results').classList.toggle('hidden', visible > 0);
            }
        </script>
    </x-slot>
</x-mentor.layout>
