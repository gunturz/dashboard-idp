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

            @media (max-width: 767px) {
                main {
                    padding: 16px !important;
                }
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
            <p class="page-header-sub">Arsip seluruh penilaian talent yang telah diselesaikan</p>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row items-center gap-4 mb-6">
        {{-- Cari Nama --}}
        <div class="relative w-full sm:flex-1 group">
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
        <div class="relative w-full sm:w-56">
            <select id="filter-perusahaan"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent appearance-none transition-all"
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;"
                onchange="filterRiwayat()">
                <option value="">Semua Perusahaan</option>
                @php $companies = $completedTalents->pluck('company.nama_company','company_id')->filter()->unique(); @endphp
                @foreach ($companies as $cId => $cName)
                    <option value="{{ $cId }}">{{ $cName }}</option>
                @endforeach
            </select>
        </div>

        <div class="relative w-full sm:w-56">
            <select id="filter-departemen"
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent appearance-none transition-all"
                style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;"
                onchange="filterRiwayat()">
                <option value="">Semua Departemen</option>
                @php $depts = $completedTalents->pluck('department.nama_department','department_id')->filter()->unique(); @endphp
                @foreach ($depts as $dId => $dName)
                    <option value="{{ $dId }}">{{ $dName }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="rounded-xl overflow-hidden border border-gray-200 custom-scrollbar overflow-x-auto {{ $completedTalents->isEmpty() ? 'hidden' : '' }}" id="riwayatTableContainer">
        <table class="w-full min-w-[900px] table-auto text-left bg-white" id="riwayat-table">
            <thead class="bg-slate-50 border-b border-gray-200">
                <tr>
                    <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Talent</th>
                    <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Perusahaan</th>
                    <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Departemen</th>
                    <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center leading-snug">Start Date</th>
                    <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center leading-snug">Due Date</th>
                    <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="riwayat-tbody">
                @foreach($completedTalents as $talent)
                    @php
                        $plan = $talent->promotion_plan;
                        $startDate = $plan?->start_date;
                        $targetDate = $plan?->target_date;
                        $posName = $talent->position?->position_name ?? '-';
                        $targetPos = $plan?->targetPosition?->position_name ?? '?';
                        $compName = $talent->company?->nama_company ?? '-';
                        $deptName = $talent->department?->nama_department ?? '-';
                    @endphp
                    <tr class="riwayat-row-item border-b border-gray-100 hover:bg-teal-50/50 transition duration-150"
                        data-name="{{ strtolower($talent->nama) }}" data-perusahaan="{{ $talent->company_id }}"
                        data-departemen="{{ $talent->department_id }}">
                        {{-- Talent --}}
                        <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">
                            <div class="flex items-center gap-3 justify-center">
                                <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}"
                                    class="w-10 h-10 rounded-full object-cover border-2 border-slate-100 shadow-sm flex-shrink-0">
                                <div class="text-left">
                                    <span class="block font-bold text-[#1e293b] text-sm">{{ $talent->nama }}</span>
                                    <span class="block text-xs text-gray-500 italic mt-0.5">{{ $posName }} –
                                        {{ $targetPos }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Perusahaan --}}
                        <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">{{ $compName }}</td>

                        {{-- Departemen --}}
                        <td class="py-4 px-6 font-semibold text-slate-800 text-center">{{ $deptName }}</td>

                        {{-- Start Date --}}
                        <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                            {{ $startDate ? $startDate->locale('id')->translatedFormat('d F Y') : '-' }}</td>

                        {{-- Due Date --}}
                        <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                            {{ $targetDate ? $targetDate->locale('id')->translatedFormat('d F Y') : '-' }}</td>

                        {{-- Aksi --}}
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('mentor.riwayat.logbook', $talent->id) }}"
                                class="inline-flex items-center gap-2 font-bold text-[13px] bg-[#14b8a6] text-white px-4 py-2 rounded-xl hover:bg-[#0d9488] transition-all duration-300 shadow-md shadow-teal-500/20 hover:shadow-lg hover:scale-105"
                                title="Lihat Logbook">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat Logbook
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="emptyStateContainer" class="{{ $completedTalents->isEmpty() ? '' : 'hidden' }} mt-8 mb-12">
        <div class="empty-prem" style="border: none; padding: 20px;">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto" style="background:linear-gradient(135deg,#ccfbf1,#99f6e4)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    style="color: #0d9488; width: 32px; height: 32px; margin: 0;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 id="emptyTitle">Belum Ada Data Talent</h3>
            <p id="emptyText">Belum ada talent yang menyelesaikan penilaian panelis.</p>
        </div>
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

                const tableContainer = document.getElementById('riwayatTableContainer');
                const emptyStateContainer = document.getElementById('emptyStateContainer');
                const emptyTitle = document.getElementById('emptyTitle');
                const emptyText = document.getElementById('emptyText');

                if (tableContainer && emptyStateContainer) {
                    if (visibleCount > 0) {
                        tableContainer.classList.remove('hidden');
                        emptyStateContainer.classList.add('hidden');
                    } else {
                        tableContainer.classList.add('hidden');
                        emptyStateContainer.classList.remove('hidden');

                        if (searchTxt || perusahaan || departemen) {
                            emptyTitle.innerHTML = 'Tidak Ditemukan';
                            emptyText.innerHTML = 'Tidak ada data yang sesuai dengan filter.';
                        } else {
                            emptyTitle.innerHTML = 'Belum Ada Data Talent';
                            emptyText.innerHTML = 'Belum ada talent yang menyelesaikan penilaian panelis.';
                        }
                    }
                }
            }
        </script>
    </x-slot>
</x-mentor.layout>
