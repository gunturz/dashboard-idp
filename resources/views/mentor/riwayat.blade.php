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

    <div class="flex flex-col md:flex-row gap-4 mb-6">
        {{-- Cari Nama --}}
        <div class="relative flex-grow group">
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
        <div class="flex flex-wrap gap-4">
            <select id="filter-perusahaan"
                class="min-w-[180px] bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                onchange="filterRiwayat()">
                <option value="">Semua Perusahaan</option>
                @php $companies = $completedTalents->pluck('company.nama_company','company_id')->filter()->unique(); @endphp
                @foreach ($companies as $cId => $cName)
                    <option value="{{ $cId }}">{{ $cName }}</option>
                @endforeach
            </select>

            <select id="filter-departemen"
                class="min-w-[180px] bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                onchange="filterRiwayat()">
                <option value="">Semua Departemen</option>
                @php $depts = $completedTalents->pluck('department.nama_department','department_id')->filter()->unique(); @endphp
                @foreach ($depts as $dId => $dName)
                    <option value="{{ $dId }}">{{ $dName }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="rounded-xl overflow-hidden border border-gray-200 custom-scrollbar overflow-x-auto">
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
                @forelse($completedTalents as $talent)
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
                @empty
                    <tr id="empty-row">
                        <td colspan="6" class="py-12 px-6 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <p class="font-medium">Belum ada talent yang menyelesaikan penilaian panelis.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse

                {{-- Hidden empty row for JS filtering --}}
                <tr id="js-empty-row" class="hidden">
                    <td colspan="6" class="py-12 px-6 text-center text-gray-400">
                        <div class="flex flex-col items-center justify-center">
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
