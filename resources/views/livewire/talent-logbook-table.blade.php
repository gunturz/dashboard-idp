<div>
    @if(session('success'))
        <div class="mb-6 px-5 py-3.5 bg-green-50 border border-green-300 text-green-700 text-sm font-semibold rounded-xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Tab Navigation --}}
    <div class="flex gap-1.5 p-1.5 bg-[#f9fafb] border border-[#e2e8f0] rounded-full w-fit mb-8 shadow-inner overflow-x-auto relative">
        <button wire:click="setTab('exposure')"
            class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $activeTab === 'exposure' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}">
            Exposure
        </button>
        <button wire:click="setTab('mentoring')"
            class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $activeTab === 'mentoring' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}">
            Mentoring
        </button>
        <button wire:click="setTab('learning')"
            class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 whitespace-nowrap {{ $activeTab === 'learning' ? 'bg-[#0f172a] text-white shadow-sm' : 'text-[#64748b] hover:bg-[#cbd5e1] hover:text-[#0f172a]' }}">
            Learning
        </button>
    </div>

    {{-- Content Table --}}
    <div class="log-table-container custom-scrollbar overflow-x-auto mb-12 relative" style="min-height: 200px;">

        <table class="pdc-log-table w-full">
            <thead>
                <tr>
                    @if($activeTab === 'learning')
                        <th>Sumber</th>
                    @else
                        <th>Mentor</th>
                    @endif
                    <th>Tema</th>
                    <th>Tanggal Pengiriman/Update</th>
                    <th>Tanggal Pelaksanaan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr>
                        <td class="text-center font-medium">
                            @if($activeTab === 'learning')
                                {{ $item['sumber'] }}
                            @else
                                {{ $item['mentor'] }}
                            @endif
                        </td>
                        <td class="text-center font-bold text-[#1e293b] w-48">
                            {{ \Illuminate\Support\Str::limit($item['tema'], 35) }}
                        </td>
                        <td class="text-center whitespace-nowrap">
                            {{ $item['tanggal_update'] ? date('d F Y', strtotime($item['tanggal_update'])) : '-' }}
                        </td>
                        <td class="text-center whitespace-nowrap">
                            {{ date('d F Y', strtotime($item['tanggal'])) }}
                        </td>
                        <td class="text-center whitespace-nowrap w-32">
                            @if($activeTab === 'learning')
                                <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Verified
                                </span>
                            @else
                                @if (in_array($item['status'], ['Approve', 'Approved']))
                                    <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                        {{ $item['status'] ?: 'Pending' }}
                                    </span>
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('talent.logbook.detail', $item['id']) }}"
                                    class="flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100"
                                    title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg> Detail
                                </a>
                                @if(!$trainingDone)
                                <a href="{{ optional($user->promotion_plan)->is_locked ? '#' : route('talent.idp_monitoring.edit', $item['id']) }}"
                                    class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-blue-100 transition-colors' }}"
                                    title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button type="button"
                                    wire:click="openDeleteModal({{ $item['id'] }})"
                                    class="flex items-center justify-center w-8 h-8 rounded-full bg-red-50 text-red-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-red-100 transition-colors' }}"
                                    title="Hapus"
                                    {{ optional($user->promotion_plan)->is_locked ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 px-6 text-center text-gray-400">
                            Belum ada aktivitas {{ ucfirst($activeTab) }} yang dicatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Delete Confirmation Modal --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm transition-opacity"
            wire:click.self="$set('showDeleteModal', false)">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 transform transition-transform duration-300">
                <div class="flex flex-col items-center text-center">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Aktivitas?</h3>
                    <p class="text-sm text-gray-500 mb-6 w-11/12 mx-auto">
                        Apakah Anda yakin ingin menghapus data logbook ini? Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <div class="flex gap-3 w-full mt-2">
                        <button type="button" wire:click="$set('showDeleteModal', false)"
                            class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                            Batal
                        </button>
                        <button wire:click="deleteLogbook"
                            class="flex-1 px-4 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 shadow-sm shadow-red-200 transition-all">
                            Yakin, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
