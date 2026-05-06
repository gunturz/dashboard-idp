<x-mentor.layout title="Riwayat Penilaian – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            .custom-scrollbar::-webkit-scrollbar { 
                height: 8px; 
            }
            .custom-scrollbar::-webkit-scrollbar-track { 
                background: #f8fafc; 
                border-radius: 10px; 
            }
            .custom-scrollbar::-webkit-scrollbar-thumb { 
                background: #0d9488; 
                border-radius: 10px;
                border: 2px solid #f8fafc;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { 
                background: #0f766e; 
            }

            .log-table-container {
                background: white;
                border-radius: 16px;
                border: 1px solid #e2e8f0;
                overflow: hidden;
                position: relative;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }

            .pdc-log-table {
                width: 100%;
                border-collapse: collapse;
            }

            .pdc-log-table th {
                padding: 12px 16px;
                background: #f1f5f9;
                font-weight: 700;
                color: #1e293b;
                font-size: 0.75rem;
                text-align: center;
                border-bottom: 2px solid #cbd5e1;
                border-right: 1px solid #d1d5db;
            }

            .pdc-log-table th:last-child {
                border-right: none;
            }

            .pdc-log-table td {
                padding: 12px 16px;
                color: #334155;
                font-size: 0.82rem;
                border-bottom: 1px solid #d1d5db;
                border-right: 1px solid #e5e7eb;
                vertical-align: middle;
                text-align: center;
            }

            .pdc-log-table td:last-child {
                border-right: none;
            }

            .pdc-log-table tr:last-child td {
                border-bottom: 1px solid #d1d5db;
            }

            .pdc-log-table tr:hover td {
                background: #f8fafc;
            }

            @media (max-width: 767px) {
                main { padding: 16px !important; }
            }
        </style>
    </x-slot>

    {{-- ── Page Header ── --}}
    <div class="page-header animate-title">
        <div class="page-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <h1 class="page-header-title">Riwayat Penilaian</h1>
            <p class="page-header-sub">Arsip seluruh penilaian talent yang telah diselesaikan</p>
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
            <select id="filter-perusahaan" class="min-w-[180px] bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all" onchange="filterRiwayat()">
                <option value="">Semua Perusahaan</option>
                @php $companies = $completedTalents->pluck('company.nama_company','company_id')->filter()->unique(); @endphp
                @foreach($companies as $cId => $cName)
                    <option value="{{ $cId }}">{{ $cName }}</option>
                @endforeach
            </select>

            <select id="filter-departemen" class="min-w-[180px] bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all" onchange="filterRiwayat()">
                <option value="">Semua Departemen</option>
                @php $depts = $completedTalents->pluck('department.nama_department','department_id')->filter()->unique(); @endphp
                @foreach($depts as $dId => $dName)
                    <option value="{{ $dId }}">{{ $dName }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="log-table-container custom-scrollbar overflow-x-auto">
        <table class="pdc-log-table w-full" id="riwayat-table">
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
            @forelse($completedTalents as $talent)
                @php
                    $plan       = $talent->promotion_plan;
                    $startDate  = $plan?->start_date;
                    $targetDate = $plan?->target_date;
                    $posName    = $talent->position?->position_name ?? '-';
                    $targetPos  = $plan?->targetPosition?->position_name ?? '?';
                    $compName   = $talent->company?->nama_company ?? '-';
                    $deptName   = $talent->department?->nama_department ?? '-';
                @endphp
                <tr class="riwayat-row-item" 
                    data-name="{{ strtolower($talent->nama) }}" 
                    data-perusahaan="{{ $talent->company_id }}"
                    data-departemen="{{ $talent->department_id }}">
                    {{-- Talent --}}
                    <td>
                        <div class="flex items-center gap-3 justify-center">
                            <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}"
                                 class="w-10 h-10 rounded-full object-cover border-2 border-slate-100 shadow-sm flex-shrink-0">
                            <div class="text-left">
                                <span class="block font-bold text-[#1e293b] text-sm">{{ $talent->nama }}</span>
                                <span class="block text-xs text-gray-500 italic mt-0.5">{{ $posName }} – {{ $targetPos }}</span>
                            </div>
                        </div>
                    </td>

                    {{-- Perusahaan --}}
                    <td class="font-medium text-[#1e293b]">{{ $compName }}</td>

                    {{-- Departemen --}}
                    <td>{{ $deptName }}</td>

                    {{-- Start Date --}}
                    <td class="whitespace-nowrap">{{ $startDate ? $startDate->translatedFormat('d F Y') : '-' }}</td>

                    {{-- Due Date --}}
                    <td class="whitespace-nowrap">{{ $targetDate ? $targetDate->translatedFormat('d F Y') : '-' }}</td>

                    {{-- Aksi --}}
                    <td>
                        <a href="{{ route('mentor.riwayat.logbook', $talent->id) }}"
                            class="inline-flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Lihat Logbook
                        </a>
                    </td>
                </tr>
            @empty
                <tr id="empty-row">
                    <td colspan="6">
                        <div class="py-12 flex flex-col items-center justify-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="font-medium">Belum ada talent yang menyelesaikan penilaian panelis.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            
            {{-- Hidden empty row for JS filtering --}}
            <tr id="js-empty-row" class="hidden">
                <td colspan="6">
                    <div class="py-12 flex flex-col items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
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
                const perusahaan = document.getElementById('filter-perusahaan').value;
                const departemen = document.getElementById('filter-departemen').value;
                
                const rows = document.querySelectorAll('.riwayat-row-item');
                let visibleCount = 0;

                rows.forEach(row => {
                    const rowName = row.getAttribute('data-name') || '';
                    const rowPerusahaan = row.getAttribute('data-perusahaan') || '';
                    const rowDepartemen = row.getAttribute('data-departemen') || '';

                    const matchName = rowName.includes(searchTxt);
                    const matchPerusahaan = perusahaan === '' || rowPerusahaan === perusahaan;
                    const matchDepartemen = departemen === '' || rowDepartemen === departemen;

                    if (matchName && matchPerusahaan && matchDepartemen) {
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
        </script>
    </x-slot>
</x-mentor.layout>
