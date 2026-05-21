{{-- Livewire: pdc-dashboard-table --}}
<div>
    {{-- Search Box --}}
    <div class="card-header">
        <span class="card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M5.566 4.657A4.505 4.505 0 016.75 4.5h10.5c.41 0 .806.055 1.183.157A3 3 0 0015.75 3h-7.5a3 3 0 00-2.684 1.657zM2.25 12a3 3 0 013-3h13.5a3 3 0 013 3v6a3 3 0 01-3 3H5.25a3 3 0 01-3-3v-6zM5.25 7.5c-.41 0-.806.055-1.184.157A3 3 0 016.75 6h10.5a3 3 0 012.683 1.657A4.505 4.505 0 0018.75 7.5H5.25z" />
            </svg>
            Recent Highlight Progress
        </span>
        <div class="search-box">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari talent..."
                class="search-input" id="tableSearchInput" />
        </div>
    </div>

    @if (count($tableRows) === 0)
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <p>{{ $search ? 'Tidak ada talent yang cocok dengan pencarian.' : 'Belum ada data progress talent' }}</p>
        </div>
    @else
        <div class="overflow-x-auto w-full border border-gray-200">
            <table class="w-full table-auto text-left bg-white">
                <thead class="bg-slate-50 border-b border-gray-200">
                    <tr>
                        <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Posisi Yang
                            Dituju</th>
                        <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Talent</th>
                        <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Departemen
                        </th>
                        <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Mentor</th>
                        <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Atasan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($tableRows as $idx => $row)
                        <tr class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                            <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                <div style="display: inline-block; text-align: center; width: 100%;">
                                    <div class="font-bold text-sm text-slate-800 leading-tight">{{ $row['position'] }}
                                    </div>
                                    <div class="text-xs text-gray-500 font-medium mt-1">{{ $row['dept'] }}</div>
                                </div>
                            </td>
                            <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                <div style="display: inline-block; text-align: center; width: 100%;">
                                    <div class="font-bold text-sm text-slate-800 leading-tight">{{ $row['talent'] }}
                                    </div>
                                    <div class="text-xs text-gray-500 font-medium mt-1">{{ $row['role'] }}</div>
                                </div>
                            </td>
                            <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                <span class="text-sm text-slate-700">{{ $row['dept'] }}</span>
                            </td>
                            <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                <span class="text-sm text-slate-700">{{ $row['mentor'] }}</span>
                            </td>
                            <td class="px-5 py-4" style="text-align:center; vertical-align:middle;">
                                <span class="text-sm text-slate-700">{{ $row['atasan'] }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<style>
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>
