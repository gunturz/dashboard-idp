<x-mentor.layout title="Detail Logbook" :user="$user" :notifications="$notifications">
    <div class="w-full">
        {{-- ── Page Header ── --}}
        <div class="page-header animate-title mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="page-header-icon shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zM12.75 12a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V18a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V12z" clip-rule="evenodd" />
                        <path d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963 5.23 5.23 0 00-3.434-1.279h-1.875a.375.375 0 01-.375-.375V5.25z" />
                    </svg>
                </div>
                <div>
                    <h1 class="page-header-title">Detail Logbook - {{ $activity->type->type_name ?? 'Aktivitas' }}</h1>
                    <p class="page-header-sub">Lihat detail aktivitas logbook yang disubmit oleh talent.</p>
                </div>
            </div>
        </div>

        <div class="prem-card p-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($activity->type_idp == 1 || $activity->type_idp == 2)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Mentor</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ $activity->verifier->nama ?? '-' }}</div>
                </div>
                @endif

                @if($activity->type_idp == 3)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Sumber</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ $activity->activity ?? '-' }}</div>
                </div>
                @endif

                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Tema</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ $activity->theme ?? '-' }}</div>
                </div>

                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Tanggal Pengiriman/Update</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ $activity->updated_at ? \Carbon\Carbon::parse($activity->updated_at)->format('d F Y') : '-' }}</div>
                </div>

                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Tanggal Pelaksanaan</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ \Carbon\Carbon::parse($activity->activity_date)->format('d F Y') }}</div>
                </div>

                @if($activity->type_idp == 1 || $activity->type_idp == 2)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Lokasi</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ $activity->location ?? '-' }}</div>
                </div>
                @endif

                @if($activity->type_idp == 3)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Platform</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ $activity->platform ?? '-' }}</div>
                </div>
                @endif

                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-2">Dokumentasi</span>
                    @php
                        $dPaths = []; $dNames = [];
                        if($activity->document_path){
                            if(str_starts_with($activity->document_path, '["')) {
                                $dPaths = json_decode($activity->document_path, true);
                                $dNames = explode(', ', $activity->file_name ?? '');
                            } else {
                                $dPaths = [$activity->document_path]; $dNames = [$activity->file_name ?? 'Dokumen'];
                            }
                        }
                    @endphp
                    @if(count($dPaths) > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($dPaths as $di => $dp)
                                <a href="{{ asset('storage/'.$dp) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[12px] font-semibold text-teal-600 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50/50 shadow-sm transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    {{ $dNames[$di] ?? 'File ' . ($di+1) }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <span class="text-[13px] text-gray-400 font-medium whitespace-nowrap">- Tidak ada file</span>
                    @endif
                </div>

                @if($activity->type_idp == 1)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm md:col-span-2">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Aktivitas</span>
                    <div class="text-[15px] text-gray-800 font-medium break-words">{{ $activity->activity ?? '-' }}</div>
                </div>
                @endif

                @if($activity->type_idp != 3)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm md:col-span-2">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Deskripsi</span>
                    <div class="text-[15px] text-gray-800 leading-relaxed font-medium break-words">{{ $activity->description ?? '-' }}</div>
                </div>
                @endif

                @if($activity->type_idp == 2)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm md:col-span-2">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Action Plan</span>
                    <div class="text-[15px] text-gray-800 leading-relaxed font-medium break-words">{{ $activity->action_plan ?? '-' }}</div>
                </div>
                @endif
            </div>

            @php
                // Check if current user is authorized to validate
                $isAuthorizedValidator = ($activity->type_idp == 3) ? true : ($user->id === $activity->verify_by);
            @endphp

            @if($isAuthorizedValidator && ($activity->status === 'Pending' || $activity->status === null || $activity->status === ''))
                <div class="mt-10 flex justify-end gap-3 pt-6 border-t border-slate-100">
                    <button type="button" onclick="openConfirmModal('Rejected')"
                        class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-red-400 text-red-500 bg-white font-bold text-sm rounded-lg hover:bg-red-500 hover:text-white transition-all duration-200 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reject
                    </button>
                    <button type="button" onclick="openConfirmModal('Approved')"
                        class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-emerald-400 text-emerald-600 bg-white font-bold text-sm rounded-lg hover:bg-emerald-500 hover:text-white transition-all duration-200 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Approve
                    </button>
                </div>
            @endif
        </div>
    </div>

    @if($isAuthorizedValidator && ($activity->status === 'Pending' || $activity->status === null || $activity->status === ''))
    {{-- Modal Confirm Action --}}
    <div id="confirmModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm transition-opacity opacity-0" style="transition: opacity 0.3s ease;">
        <div class="bg-white rounded-[20px] shadow-2xl w-full max-w-[360px] p-7 text-center transform scale-95 transition-transform duration-300" id="confirmModalContent">
            <div class="mx-auto flex h-[68px] w-[68px] items-center justify-center rounded-full bg-[#1e293b] mb-5 shadow-sm">
                <span class="text-white font-black text-4xl leading-none -mt-1">?</span>
            </div>
            <h3 class="text-xl font-bold text-[#1e293b] mb-2 tracking-tight">Konfirmasi</h3>
            <p class="text-[13px] text-gray-500 leading-relaxed mb-6 font-medium px-2">
                Apakah Anda yakin ingin <span id="modalActionText" class="font-bold text-gray-700">...</span> tugas ini? Tindakan ini akan langsung memperbarui logbook sistem.
            </p>
            <form id="confirmActionForm" method="POST" action="{{ url('/mentor/validasi/' . $activity->id . '/status') }}">
                @csrf
                <input type="hidden" name="status" id="actionStatusInput" value="">
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <button type="button" onclick="closeConfirmModal()" class="w-full bg-[#f1f5f9] text-[#64748b] font-bold py-2.5 rounded-lg hover:bg-gray-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="w-full bg-[#14b8a6] text-white font-bold py-2.5 rounded-lg hover:bg-teal-600 transition-colors">
                        Ya
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function openConfirmModal(status) {
                const modal = document.getElementById('confirmModal');
                const modalContent = document.getElementById('confirmModalContent');
                const actionText = document.getElementById('modalActionText');
                const inputStatus = document.getElementById('actionStatusInput');

                inputStatus.value = status;
                actionText.textContent = status === 'Approved' ? 'meng-Approve' : 'me-Reject';

                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modalContent.classList.remove('scale-95');
                }, 10);
            }

            function closeConfirmModal() {
                const modal = document.getElementById('confirmModal');
                const modalContent = document.getElementById('confirmModalContent');
                modal.classList.add('opacity-0');
                modalContent.classList.add('scale-95');
                setTimeout(() => { modal.classList.add('hidden'); }, 300);
            }
        </script>
    </x-slot>
    @endif
</x-mentor.layout>
