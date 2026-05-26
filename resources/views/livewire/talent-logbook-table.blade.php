<div>
    <div class="fade-up">
        @if (session('success'))
            <div
                class="mb-6 px-5 py-3.5 bg-green-50 border border-green-300 text-green-700 text-sm font-semibold rounded-xl flex items-center gap-3 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Tab Navigation --}}
        <div
            class="flex gap-1.5 p-1.5 bg-[#f9fafb] border border-[#e2e8f0] rounded-full w-fit mb-8 shadow-inner overflow-x-auto relative">
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
        <div class="mb-12 relative">

            {{-- Desktop View (100% Original Code) --}}
            <div class="hidden md:block rounded-xl overflow-hidden border border-gray-200 w-full overflow-x-auto">
                <table class="w-full text-left bg-white min-w-[800px]">
                    <thead class="bg-slate-50 border-b border-gray-200">
                        <tr>
                            @if ($activeTab === 'learning')
                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Sumber</th>
                            @else
                                <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Mentor</th>
                            @endif
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Tema</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Tanggal
                                Pengiriman/Update</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center whitespace-nowrap">Tanggal
                                Pelaksanaan</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Status</th>
                            <th class="py-4 px-6 text-sm font-bold text-slate-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr class="border-b border-gray-100 hover:bg-teal-50/50 transition duration-150">
                                <td class="py-4 px-6 font-bold text-sm text-slate-800 text-center">
                                    @if ($activeTab === 'learning')
                                        {{ $item['sumber'] }}
                                    @else
                                        {{ $item['mentor'] }}
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-sm font-semibold text-slate-800 w-48 text-center">
                                    {{ \Illuminate\Support\Str::limit($item['tema'], 35) }}
                                </td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ $item['tanggal_update'] ? \Carbon\Carbon::parse($item['tanggal_update'])->locale('id')->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center text-sm text-slate-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-4 px-6 text-center w-32">
                                    @if (in_array($item['status'], ['Approve', 'Approved']))
                                        <span
                                            class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                        </span>
                                    @elseif (in_array($item['status'], ['Reject', 'Rejected']))
                                        <span
                                            class="inline-flex items-center gap-1 text-red-600 text-[11px] font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                            {{ $item['status'] ?: 'Pending' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('talent.logbook.detail', $item['id']) }}"
                                            class="inline-flex items-center gap-2 font-bold text-[13px] bg-[#14b8a6] text-white px-4 py-2 rounded-xl hover:bg-[#0d9488] transition-all duration-300 shadow-md shadow-teal-500/20 hover:shadow-lg hover:scale-105"
                                            title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                        @if (!$trainingDone)
                                            <a href="{{ optional($user->promotion_plan)->is_locked ? '#' : route('talent.idp_monitoring.edit', $item['id']) }}"
                                                class="inline-flex items-center justify-center w-[38px] h-[38px] bg-blue-600 text-white rounded-xl shadow-md shadow-blue-500/20 hover:bg-blue-700 hover:shadow-lg hover:scale-105 transition-all duration-300 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <button type="button" wire:click="openDeleteModal({{ $item['id'] }})"
                                                class="inline-flex items-center justify-center w-[38px] h-[38px] bg-red-600 text-white rounded-xl shadow-md shadow-red-500/20 hover:bg-red-700 hover:shadow-lg hover:scale-105 transition-all duration-300 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}"
                                                title="Hapus"
                                                {{ optional($user->promotion_plan)->is_locked ? 'disabled' : '' }}>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
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

            {{-- Mobile View --}}
            <div class="block md:hidden log-table-container custom-scrollbar overflow-x-auto">
                <table class="pdc-log-table w-full" style="min-width: 700px;">
                    <thead>
                        <tr>
                            @if ($activeTab === 'learning')
                                <th style="width: 120px; font-size: 11px; padding: 8px;">Sumber</th>
                            @else
                                <th style="width: 120px; font-size: 11px; padding: 8px;">Mentor</th>
                            @endif
                            <th style="width: 160px; font-size: 11px; padding: 8px;">Tema</th>
                            <th style="width: 130px; font-size: 11px; padding: 8px;">Tanggal Pengiriman/Update</th>
                            <th style="width: 120px; font-size: 11px; padding: 8px;">Tanggal Pelaksanaan</th>
                            <th style="width: 90px; font-size: 11px; padding: 8px;">Status</th>
                            <th style="width: 90px; font-size: 11px; padding: 8px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td class="text-center font-medium text-[11px] p-2">
                                    @if ($activeTab === 'learning')
                                        {{ $item['sumber'] }}
                                    @else
                                        {{ $item['mentor'] }}
                                    @endif
                                </td>
                                <td
                                    class="text-center font-bold text-[#1e293b] text-[11px] p-2 whitespace-normal leading-tight">
                                    {{ \Illuminate\Support\Str::limit($item['tema'], 35) }}
                                </td>
                                <td class="text-center text-[10px] p-2 whitespace-nowrap">
                                    {{ $item['tanggal_update'] ? date('d M Y', strtotime($item['tanggal_update'])) : '-' }}
                                </td>
                                <td class="text-center text-[10px] p-2 whitespace-nowrap">
                                    {{ date('d M Y', strtotime($item['tanggal'])) }}
                                </td>
                                <td class="text-center p-2 whitespace-nowrap">
                                    @if (in_array($item['status'], ['Approve', 'Approved']))
                                        <span
                                            class="inline-flex items-center gap-1 text-green-600 text-[9px] font-bold bg-green-50 px-2 py-0.5 rounded-full border border-green-100">
                                            Approved
                                        </span>
                                    @elseif (in_array($item['status'], ['Reject', 'Rejected']))
                                        <span
                                            class="inline-flex items-center gap-1 text-red-600 text-[9px] font-bold bg-red-50 px-2 py-0.5 rounded-full border border-red-100">
                                            Rejected
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-orange-500 text-[9px] font-bold bg-orange-50 px-2 py-0.5 rounded-full border border-orange-100">
                                            {{ $item['status'] ?: 'Pending' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center p-2">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('talent.logbook.detail', $item['id']) }}"
                                            class="flex items-center justify-center w-6 h-6 rounded bg-teal-50 text-teal-600 hover:bg-teal-100 transition-colors border border-teal-100"
                                            title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        @if (!$trainingDone)
                                            <a href="{{ optional($user->promotion_plan)->is_locked ? '#' : route('talent.idp_monitoring.edit', $item['id']) }}"
                                                class="flex items-center justify-center w-6 h-6 rounded bg-blue-50 text-blue-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-blue-100 transition-colors' }}"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <button type="button" wire:click="openDeleteModal({{ $item['id'] }})"
                                                class="flex items-center justify-center w-6 h-6 rounded bg-red-50 text-red-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-red-100 transition-colors' }}"
                                                title="Hapus"
                                                {{ optional($user->promotion_plan)->is_locked ? 'disabled' : '' }}>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
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
                                <td colspan="6" class="py-12 px-6 text-center text-gray-400 text-xs">
                                    Belum ada aktivitas {{ ucfirst($activeTab) }} yang dicatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center transition-opacity"
            style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);"
            wire:click.self="$set('showDeleteModal', false)">
            <div
                class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 transform transition-transform duration-300">
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
