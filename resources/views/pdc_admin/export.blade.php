<x-pdc_admin.layout title="Progress Archive – PDC Admin" :user="$user">

    <div class="px-2 pb-10">
        <div class="flex items-center gap-3 mb-6 mt-2 relative">
            <svg class="w-8 h-8 text-slate-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3.75v5.25m-3-3 3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"></path>
            </svg>
            <h1 class="text-[1.3rem] font-bold text-slate-800">Progress Archive</h1>
        </div>

        <!-- Filter Bar -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="relative w-full">
                <input type="text" id="searchInput" placeholder="Cari Nama" class="w-full rounded-lg border border-slate-300 shadow-sm pl-4 pr-10 py-2.5 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 bg-white text-sm" onkeyup="filterTalents()">
                <div class="absolute right-3 top-2.5 text-teal-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
            
            <select id="companyFilter" class="w-full rounded-lg border border-slate-300 py-2.5 shadow-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 bg-white text-slate-600 text-sm appearance-none bg-no-repeat bg-[right_0.5rem_center] bg-[length:1.5em_1.5em]" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%2314b8a6%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E'); padding-right: 2.5rem;" onchange="filterTalents()">
                <option value="">Semua Perusahaan</option>
                @php
                    $uniqueCompanies = collect();
                    foreach ($groupedData as $group) {
                        if (isset($group['company']) && $group['company']) {
                            $uniqueCompanies->push($group['company']->nama_company);
                        }
                    }
                    $uniqueCompanies = $uniqueCompanies->unique()->sortBy(function($name) {
                        if (strpos($name, 'PT. Tiga Serangkai Inti Corpora') !== false) return 1;
                        if (strpos($name, 'PT. Tiga Serangkai Pustaka Mandiri') !== false) return 2;
                        return 3 . '-' . $name;
                    })->values();
                @endphp
                @foreach($uniqueCompanies as $comp)
                    <option value="{{ $comp }}">{{ $comp }}</option>
                @endforeach
            </select>

            <select id="periodFilter" class="w-full rounded-lg border border-slate-300 py-2.5 shadow-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 bg-white text-slate-600 text-sm appearance-none bg-no-repeat bg-[right_0.5rem_center] bg-[length:1.5em_1.5em]" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%2314b8a6%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E'); padding-right: 2.5rem;" onchange="filterTalents()">
                <option value="">Semua Periode</option>
                <!-- Add dynamic options if needed -->
            </select>

            <select id="departmentFilter" class="w-full rounded-lg border border-slate-300 py-2.5 shadow-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 bg-white text-slate-600 text-sm appearance-none bg-no-repeat bg-[right_0.5rem_center] bg-[length:1.5em_1.5em]" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%2314b8a6%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E'); padding-right: 2.5rem;" onchange="filterTalents()">
                <option value="">Semua Departemen</option>
                @php
                    $uniqueDepartments = collect();
                    foreach ($groupedData as $group) {
                        foreach ($group['talents'] as $talent) {
                            if (isset($talent->department) && $talent->department) {
                                $uniqueDepartments->push($talent->department->nama_department);
                            }
                        }
                    }
                    $uniqueDepartments = $uniqueDepartments->unique()->sort();
                @endphp
                @foreach($uniqueDepartments as $dept)
                    <option value="{{ $dept }}">{{ $dept }}</option>
                @endforeach
            </select>
        </div>

        <div class="w-full max-w-5xl mx-auto" id="allTalentsList">
            <div id="empty-state" class="hidden text-center text-slate-500 py-10 bg-white rounded-xl shadow-sm border border-slate-200 mb-6">
                Tidak ada talent yang sesuai dengan pencarian Anda.
            </div>

            @php 
                $totalTalents = 0; 
                // Group data sort specifically for the view
                $sortedGroupedData = collect($groupedData)->sortBy(function($group) {
                    $name = $group['company']->nama_company ?? '';
                    if (strpos($name, 'PT. Tiga Serangkai Inti Corpora') !== false) return 1;
                    if (strpos($name, 'PT. Tiga Serangkai Pustaka Mandiri') !== false) return 2;
                    return 3 . '-' . $name;
                });
            @endphp
            @foreach ($sortedGroupedData as $compId => $group)
                @php $compName = $group['company']->nama_company ?? 'Unknown Company'; @endphp
                @if(count($group['talents']) > 0)
                    <div class="company-section bg-white rounded-[20px] shadow border border-slate-200 p-6 sm:p-8 mb-10" data-company-section="{{ $compName }}">
                        <h2 class="text-lg font-bold text-center text-[#313B4D] mb-6 pb-4 border-b border-slate-200">
                            {{ $compName }}
                        </h2>
                        @foreach ($group['talents'] as $talent)
                    @php
                        $totalTalents++;
                        $startDate = optional($talent->promotion_plan)->start_date ? \Carbon\Carbon::parse($talent->promotion_plan->start_date)->translatedFormat('d F Y') : '-';
                        $dueDate = optional($talent->promotion_plan)->target_date ? \Carbon\Carbon::parse($talent->promotion_plan->target_date)->translatedFormat('d F Y') : '-';
                        
                        $deptName = $talent->department->nama_department ?? '-';
                    @endphp
                        
                    <div class="talent-card bg-[#F8F9FA] sm:bg-white rounded-[20px] shadow-sm border border-slate-200 p-6 mb-6 transition-all" data-name="{{ strtolower($talent->nama) }}" data-department="{{ $deptName }}" data-company="{{ $compName }}">
                        <div class="flex flex-col lg:flex-row justify-between gap-6 pb-6 border-b border-slate-200 bg-white rounded-xl p-4 sm:p-0 sm:bg-transparent shadow-sm sm:shadow-none sm:border-b-accent">
                            
                            <!-- Left side user info -->
                            <div class="flex-1">
                                <table class="w-full text-sm">
                                    <tbody>
                                        <tr>
                                            <td class="py-2.5 text-[#1e293b] font-bold w-40 align-top">Nama</td>
                                            <td class="py-2.5 text-slate-600 align-top">{{ $talent->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2.5 text-[#1e293b] font-bold align-top">Perusahaan</td>
                                            <td class="py-2.5 text-slate-600 align-top">{{ $compName }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2.5 text-[#1e293b] font-bold align-top">Departemen</td>
                                            <td class="py-2.5 text-slate-600 align-top">{{ $deptName }}</td>
                                        </tr>
                                            <tr>
                                                <td class="py-2.5 text-[#1e293b] font-bold align-top">Posisi yang dituju</td>
                                                <td class="py-2.5 text-slate-600 align-top">{{ optional($talent->promotion_plan)->targetPosition->position_name ?? '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Right side action links bg-transparent -->
                                <div class="flex-1 lg:max-w-md ml-auto">
                                    <table class="w-full text-sm">
                                        <tbody>
                                            <tr>
                                                <td class="py-2.5 text-[#1e293b] font-bold align-middle pr-4">Progress Talent</td>
                                                <td class="py-2.5 text-right w-36 align-middle">
                                                    <a href="{{ route('pdc_admin.detail.talent', $talent->id) }}" class="inline-block px-4 py-1.5 border border-slate-300 text-slate-600 rounded-lg text-xs hover:bg-slate-50 transition-colors bg-white w-full text-center">Lihat Detail</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2.5 text-[#1e293b] font-bold align-middle pr-4">Finance Validation</td>
                                                <td class="py-2.5 text-right align-middle">
                                                    <a href="{{ route('pdc_admin.finance_validation') }}" class="inline-block px-4 py-1.5 border border-slate-300 text-slate-600 rounded-lg text-xs hover:bg-slate-50 transition-colors bg-white w-full text-center">Lihat Detail</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2.5 text-[#1e293b] font-bold align-middle pr-4">Panelis Review</td>
                                                <td class="py-2.5 text-right align-middle">
                                                    <a href="{{ route('pdc_admin.panelis_review.detail', $talent->id) }}" class="inline-block px-4 py-1.5 border border-slate-300 text-slate-600 rounded-lg text-xs hover:bg-slate-50 transition-colors bg-white w-full text-center">Lihat Detail</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <!-- Bottom -->
                            <div class="mt-4 flex flex-col sm:flex-row justify-between items-center sm:items-end gap-4 px-2 sm:px-0">
                                <!-- Dates pill -->
                                <div class="bg-[#313B4D] rounded-xl px-8 py-3 w-full sm:w-auto min-w-[320px]">
                                    <div class="flex justify-between items-center mb-1.5">
                                        <span class="text-white font-semibold text-[0.8rem]">Start Date</span>
                                        <span class="text-slate-200 text-[0.8rem]">{{ $startDate }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-white font-semibold text-[0.8rem]">Due Date</span>
                                        <span class="text-slate-200 text-[0.8rem]">{{ $dueDate }}</span>
                                    </div>
                                </div>

                                <!-- Export button -->
                                <a href="{{ route('pdc_admin.export_pdf', $talent->id) }}" class="bg-[#EE5353] hover:bg-[#d94444] text-white px-10 py-2.5 rounded-lg font-semibold transition-colors w-full sm:w-auto text-center shadow-sm text-[0.85rem]">
                                    Export
                                </a>
                            </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach

            @if($totalTalents === 0)
                <div class="text-center text-slate-500 py-10 bg-white rounded-xl shadow-sm border border-slate-200 mt-6">
                    Belum ada data progress archive.
                </div>
            @endif
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function filterTalents() {
                const searchTxt = document.getElementById('searchInput').value.toLowerCase();
                const compVal = document.getElementById('companyFilter').value;
                const deptVal = document.getElementById('departmentFilter').value;
                
                let visibleCount = 0;

                document.querySelectorAll('.company-section').forEach(section => {
                    const sectionComp = section.getAttribute('data-company-section');
                    let sectionHasVisibleTalent = false;

                    // If company filter is active and does not match the section's company
                    if (compVal !== '' && sectionComp !== compVal) {
                        section.style.display = 'none';
                        return; // Skip to next section
                    }

                    const cards = section.querySelectorAll('.talent-card');
                    cards.forEach(card => {
                        const name = card.getAttribute('data-name') || '';
                        const dept = card.getAttribute('data-department') || '';
                        
                        const matchName = name.includes(searchTxt);
                        const matchDept = deptVal === '' || dept === deptVal;

                        if (matchName && matchDept) {
                            card.style.display = 'block';
                            sectionHasVisibleTalent = true;
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Hide the section completely if all its cards are filtered out
                    section.style.display = sectionHasVisibleTalent ? 'block' : 'none';
                });
                
                const emptyState = document.getElementById('empty-state');
                if (emptyState) {
                    emptyState.style.display = visibleCount === 0 && document.querySelectorAll('.talent-card').length > 0 ? 'block' : 'none';
                }
            }

            // Init filters on load
            document.addEventListener('DOMContentLoaded', filterTalents);
        </script>
        <style>
            .hide-scroll::-webkit-scrollbar {
                display: none;
            }
            .hide-scroll {
                -ms-overflow-style: none;  /* IE and Edge */
                scrollbar-width: none;  /* Firefox */
            }
            /* Add subtle border color to match design */
            .border-slate-200 {
                border-color: #e2e8f0;
            }
            .bg-\\[\\#F8F9FA\\] {
                background-color: #F8F9FA;
            }
            .border-b-accent {
                border-bottom: 2px solid #e2e8f0;
            }
        </style>
    </x-slot>

</x-pdc_admin.layout>
