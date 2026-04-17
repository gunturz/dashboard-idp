<x-pdc_admin.layout title="Progress Archive – PDC Admin" :user="$user">

    <div class="px-2 pb-10">
        {{-- Page Header --}}
        <div class="flex items-center gap-3 mb-6 mt-2">
            <svg class="w-8 h-8 text-slate-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3.75v5.25m-3-3 3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"></path>
            </svg>
            <h1 class="text-[1.3rem] font-bold text-slate-800">Progress Archive</h1>
        </div>

        {{-- Filter Bar --}}
        <div class="flex flex-col sm:flex-row items-center gap-4 mb-6">
            {{-- Search --}}
            <div class="relative w-full sm:w-[40%]">
                <input type="text" id="searchInput" placeholder="Cari Nama"
                    class="w-full rounded-lg border border-slate-300 shadow-sm pl-4 pr-10 py-2.5 text-sm bg-white focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 placeholder-slate-400"
                    onkeyup="filterTalents()">
                <div class="absolute right-3 top-2.5 text-teal-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            {{-- Period Filter --}}
            <div class="relative w-full sm:w-[30%]">
                <select id="periodFilter"
                    class="w-full rounded-lg border border-slate-300 py-2.5 pl-4 pr-10 text-sm bg-white text-slate-600 appearance-none focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500"
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
                <div class="pointer-events-none absolute right-3 top-3 text-teal-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            {{-- Company Filter --}}
            <div class="relative w-full sm:w-[30%]">
                <select id="companyFilter"
                    class="w-full rounded-lg border border-slate-300 py-2.5 pl-4 pr-10 text-sm bg-white text-slate-600 appearance-none focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500"
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
                <div class="pointer-events-none absolute right-3 top-3 text-teal-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
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

        <div class="overflow-x-auto rounded-xl border border-slate-300 shadow-sm bg-white">
            <table class="min-w-full text-sm" id="archiveTable">
                <thead>
                    <tr class="bg-slate-50 border-b-2 border-slate-300">
                        <th class="px-6 py-4 text-center font-semibold text-slate-700 w-[22%]">Talent</th>
                        <th class="px-6 py-4 text-center font-semibold text-slate-700 w-[22%]">Perusahaan</th>
                        <th class="px-6 py-4 text-center font-semibold text-slate-700 w-[16%]">Start Date</th>
                        <th class="px-6 py-4 text-center font-semibold text-slate-700 w-[16%]">Due Date</th>
                        <th class="px-6 py-4 text-center font-semibold text-slate-700 w-[24%]">Aksi</th>
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
                                <td class="px-6 py-4">
                                    <p class="font-bold text-slate-800">{{ $talent->nama }}</p>
                                    <p class="text-xs text-slate-500 italic mt-0.5">{{ $currentPos }} &rarr; {{ $targetPos }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $compName }}</td>
                                <td class="px-6 py-4 text-center text-slate-600">{{ $startDate }}</td>
                                <td class="px-6 py-4 text-center text-slate-600">{{ $dueDate }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('pdc_admin.export.detail', $talent->id) }}"
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
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
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
            #archiveTable th { letter-spacing: 0.01em; }
            #archiveTable tbody tr:last-child { border-bottom: none; }
            #archiveTable th, #archiveTable td { border-right: 1px solid #cbd5e1; }
            #archiveTable th:last-child, #archiveTable td:last-child { border-right: none; }
        </style>
    </x-slot>

</x-pdc_admin.layout>
