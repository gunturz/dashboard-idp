<x-pdc_admin.layout title="Progress Archive – PDC Admin" :user="$user">

    <div class="px-2 pb-10">
        {{-- Page Header --}}
        <div class="page-header animate-title mb-8">
            <div class="page-header-icon shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                    <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                    <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087ZM12 10.5a.75.75 0 0 1 .75.75v4.94l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72v-4.94a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <div class="page-header-title">Progress Archive</div>
                <div class="page-header-sub">Arsip rekam jejak pengembangan talent serta kemudahan export data PDF.</div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="flex flex-col sm:flex-row items-center gap-4 mb-6">
            {{-- Search --}}
            <div class="relative w-full sm:w-[40%]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Cari Nama"
                    class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all"
                    oninput="filterTalents()">
            </div>

            {{-- Period Filter --}}
            <div class="relative w-full sm:w-[30%]">
                <select id="periodFilter"
                    class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent bg-white appearance-none transition-all"
                    style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;"
                    onchange="filterTalents()">
                    <option value="">Semua Periode</option>
                    @php
                        $uniquePeriods = collect();
                        foreach ($groupedData as $group) {
                            foreach ($group['talents'] as $t) {
                                $sd = optional($t->promotion_plan)->start_date;
                                $td = optional($t->promotion_plan)->target_date;
                                if ($sd && $td) {
                                    $label = \Carbon\Carbon::parse($sd)->format('Y') . ' – ' . \Carbon\Carbon::parse($td)->format('Y');
                                    $uniquePeriods->push($label);
                                }
                            }
                        }
                        $uniquePeriods = $uniquePeriods->unique()->sort();
                    @endphp
                    @foreach($uniquePeriods as $period)
                        <option value="{{ $period }}">{{ $period }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Company Filter --}}
            <div class="relative w-full sm:w-[30%]">
                <select id="companyFilter"
                    class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-10 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent bg-white appearance-none transition-all"
                    style="background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239ca3af%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat:no-repeat; background-position:right 0.7rem top 50%; background-size:0.65rem auto;"
                    onchange="filterTalents()">
                    <option value="">Semua Perusahaan</option>
                    @php
                        $uniqueCompanies = collect();
                        foreach ($groupedData as $group) {
                            if (isset($group['company']) && $group['company']) {
                                $uniqueCompanies->push($group['company']->nama_company);
                            }
                        }
                        $uniqueCompanies = $uniqueCompanies->unique()->sortBy(function($name) {
                            if (strpos($name, 'PT. Tiga Serangkai Inti Corpora') !== false) return '1';
                            if (strpos($name, 'PT. Tiga Serangkai Pustaka Mandiri') !== false) return '2';
                            return '3-' . $name;
                        })->values();
                    @endphp
                    @foreach($uniqueCompanies as $comp)
                        <option value="{{ $comp }}">{{ $comp }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Table --}}
        @php
            $sortedGroupedData = collect($groupedData)->sortBy(function($group) {
                $name = $group['company']->nama_company ?? '';
                if (strpos($name, 'PT. Tiga Serangkai Inti Corpora') !== false) return '1';
                if (strpos($name, 'PT. Tiga Serangkai Pustaka Mandiri') !== false) return '2';
                return '3-' . $name;
            });
            $totalRows = 0;
        @endphp

        <div class="prem-card overflow-x-auto">
            <table class="prem-table" id="archiveTable" style="width: 100%; table-layout: auto;">
                <thead>
                    <tr>
                        <th style="width: 22%">Talent</th>
                        <th style="width: 22%">Perusahaan</th>
                        <th style="width: 16%">Start Date</th>
                        <th style="width: 16%">Due Date</th>
                        <th style="width: 24%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="archiveTbody">
                    @foreach ($sortedGroupedData as $compId => $group)
                        @php $compName = $group['company']->nama_company ?? '-'; @endphp
                        @foreach ($group['talents'] as $talent)
                            @php
                                $totalRows++;
                                $startDate = optional($talent->promotion_plan)->start_date
                                    ? \Carbon\Carbon::parse($talent->promotion_plan->start_date)->translatedFormat('d F Y')
                                    : '-';
                                $dueDate = optional($talent->promotion_plan)->target_date
                                    ? \Carbon\Carbon::parse($talent->promotion_plan->target_date)->translatedFormat('d F Y')
                                    : '-';
                                $currentPos = $talent->position->position_name ?? '-' ;
                                $targetPos  = optional($talent->promotion_plan)->targetPosition->position_name ?? '-';
                                $periodLabel = '';
                                if (optional($talent->promotion_plan)->start_date && optional($talent->promotion_plan)->target_date) {
                                    $periodLabel = \Carbon\Carbon::parse($talent->promotion_plan->start_date)->format('Y')
                                        . ' – '
                                        . \Carbon\Carbon::parse($talent->promotion_plan->target_date)->format('Y');
                                }
                            @endphp
                            <tr class="archive-row border-b border-slate-300 hover:bg-slate-50 transition-colors"
                                data-name="{{ strtolower($talent->nama) }}"
                                data-company="{{ $compName }}"
                                data-period="{{ $periodLabel }}">
                                <td>
                                    <p class="font-bold text-[#2e3746]">{{ $talent->nama }}</p>
                                    <p class="text-xs text-slate-500 italic mt-0.5">{{ $currentPos }} &rarr; {{ $targetPos }}
                                    </p>
                                </td>
                                <td>{{ $compName }}</td>
                                <td>{{ $startDate }}</td>
                                <td>{{ $dueDate }}</td>
                                <td>
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('pdc_admin.detail.talent', $talent->id) }}"
                                            class="inline-block px-4 py-1.5 border border-slate-300 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-100 transition-colors whitespace-nowrap">
                                            Lihat Detail
                                        </a>
                                        <a href="{{ route('pdc_admin.export_pdf', $talent->id) }}"
                                            class="inline-block px-5 py-1.5 bg-[#EE5353] hover:bg-[#d94444] text-white rounded-lg text-xs font-semibold transition-colors whitespace-nowrap shadow-sm">
                                            Export
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach

                    {{-- Empty state row --}}
                    <tr id="emptyRow" class="hidden">
                        <td colspan="5" class="py-12 text-center text-slate-500 italic">
                            Tidak ada talent yang sesuai dengan pencarian Anda.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if($totalRows === 0)
            <div class="text-center text-slate-500 py-10 bg-white rounded-xl shadow-sm border border-slate-200 mt-6">
                Belum ada data progress archive.
            </div>
        @endif
    </div>

    <x-slot name="scripts">
        <script>
            function filterTalents() {
                const searchTxt = document.getElementById('searchInput').value.toLowerCase().trim();
                const compVal   = document.getElementById('companyFilter').value;
                const periodVal = document.getElementById('periodFilter').value;

                let visibleCount = 0;

                document.querySelectorAll('.archive-row').forEach(row => {
                    const name    = row.getAttribute('data-name')    || '';
                    const comp    = row.getAttribute('data-company')  || '';
                    const period  = row.getAttribute('data-period')   || '';

                    const matchName   = name.includes(searchTxt);
                    const matchComp   = compVal   === '' || comp   === compVal;
                    const matchPeriod = periodVal === '' || period === periodVal;

                    if (matchName && matchComp && matchPeriod) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                const emptyRow = document.getElementById('emptyRow');
                if (emptyRow) {
                    emptyRow.classList.toggle('hidden', visibleCount > 0);
                }
            }

            document.addEventListener('DOMContentLoaded', filterTalents);
        </script>
        <style>
            .archive-row td { vertical-align: middle; }
        </style>
    </x-slot>

</x-pdc_admin.layout>
