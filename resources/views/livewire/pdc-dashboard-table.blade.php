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
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari talent..."
                class="search-input"
                id="tableSearchInput"
            />
            <div wire:loading wire:target="search" style="display:flex;align-items:center;">
                <svg style="width:13px;height:13px;animation:spin 1s linear infinite;color:#14b8a6;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle style="opacity:.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path style="opacity:.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </div>
        </div>
    </div>

    @if (count($tableRows) === 0)
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <p>{{ $search ? 'Tidak ada talent yang cocok dengan pencarian.' : 'Belum ada data progress talent' }}</p>
        </div>
    @else
        <div class="table-scroll">
            <table class="highlight-table">
                <thead>
                    <tr>
                        <th>Posisi Dituju</th>
                        <th>Talent</th>
                        <th>Departemen</th>
                        <th>Mentor</th>
                        <th>Atasan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tableRows as $idx => $row)
                        <tr class="table-row {{ $idx % 2 === 0 ? 'row-even' : '' }}">
                            <td>
                                <div class="td-position">{{ $row['position'] }}</div>
                                <div class="td-sub">{{ $row['dept'] }}</div>
                            </td>
                            <td>
                                <div class="td-name">{{ $row['talent'] }}</div>
                                <div class="td-sub">{{ $row['role'] }}</div>
                            </td>
                            <td class="td-muted">{{ $row['dept'] }}</td>
                            <td class="td-muted">{{ $row['mentor'] }}</td>
                            <td class="td-muted">{{ $row['atasan'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<style>
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
