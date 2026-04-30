<x-mentor.layout title="Detail Logbook" :user="$user" :notifications="$notifications">
    <div class="w-full">
        {{-- ── Page Header ── --}}
        <div class="page-header animate-title mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="page-header-icon bg-[#0f172a] text-white shadow-lg shadow-slate-900/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zM12.75 12a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V18a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V12z"
                            clip-rule="evenodd" />
                        <path
                            d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963 5.23 5.23 0 00-3.434-1.279h-1.875a.375.375 0 01-.375-.375V5.25z" />
                    </svg>
                </div>
                <div>
                    <h1 class="page-header-title text-slate-800">Detail Logbook - {{ $activity->type->type_name ?? 'Aktivitas' }}</h1>
                    <p class="page-header-sub text-slate-500">Tinjau informasi mendalam mengenai aktivitas pengembangan talent.</p>
                </div>
            </div>
        </div>

        <div class="prem-card border border-slate-200 shadow-xl shadow-slate-200/50 p-8 bg-slate-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Row 1 --}}
                @if ($activity->type_idp == 1 || $activity->type_idp == 2)
                    <div class="p-6 bg-white rounded-2xl border border-slate-200 border-l-4 border-l-transparent transition-all group hover:border-l-teal-500">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-slate-50 rounded-lg text-slate-400 group-hover:text-teal-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span class="text-[15px] font-extrabold text-slate-600 tracking-normal">Mentor</span>
                        </div>
                        <div class="text-[15px] text-slate-800 font-bold whitespace-pre-wrap leading-snug">{{ $activity->verifier->nama ?? '-' }}</div>
                    </div>
                @elseif ($activity->type_idp == 3)
                    <div class="p-6 bg-white rounded-2xl border border-slate-200 border-l-4 border-l-transparent transition-all group hover:border-l-teal-500">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-slate-50 rounded-lg text-slate-400 group-hover:text-teal-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20l-7-7m0 0l-7 7m7-7V4" />
                                </svg>
                            </div>
                            <span class="text-[15px] font-extrabold text-slate-600 tracking-normal">Sumber</span>
                        </div>
                        <div class="text-[15px] text-slate-800 font-bold whitespace-pre-wrap leading-snug">{{ $activity->activity ?? '-' }}</div>
                    </div>
                @endif

                <div class="p-6 bg-white rounded-2xl border border-slate-200 border-l-4 border-l-transparent transition-all group hover:border-l-teal-500">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-slate-50 rounded-lg text-slate-400 group-hover:text-teal-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <span class="text-[15px] font-extrabold text-slate-600 tracking-normal">Tema</span>
                    </div>
                    <div class="text-[15px] text-slate-800 font-bold whitespace-pre-wrap leading-snug">{{ $activity->theme ?? '-' }}</div>
                </div>

                <div class="p-6 bg-white rounded-2xl border border-slate-200 border-l-4 border-l-transparent transition-all group hover:border-l-teal-500">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-slate-50 rounded-lg text-slate-400 group-hover:text-teal-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z" />
                            </svg>
                        </div>
                        <span class="text-[15px] font-extrabold text-slate-600 tracking-normal">Tanggal Pelaksanaan</span>
                    </div>
                    <div class="text-[15px] text-slate-800 font-bold leading-snug">
                        {{ \Carbon\Carbon::parse($activity->activity_date)->format('d F Y') }}
                    </div>
                </div>

                {{-- Row 2 --}}
                <div class="p-6 bg-white rounded-2xl border border-slate-200 border-l-4 border-l-transparent transition-all group hover:border-l-teal-500">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-slate-50 rounded-lg text-slate-400 group-hover:text-teal-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <span class="text-[15px] font-extrabold text-slate-600 tracking-normal">Update Terakhir</span>
                    </div>
                    <div class="text-[15px] text-slate-800 font-bold leading-snug">
                        {{ $activity->updated_at ? \Carbon\Carbon::parse($activity->updated_at)->format('d F Y, H:i') : '-' }}
                    </div>
                </div>

                @if ($activity->type_idp == 1 || $activity->type_idp == 2)
                    <div class="p-6 bg-white rounded-2xl border border-slate-200 border-l-4 border-l-transparent transition-all group hover:border-l-teal-500">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-slate-50 rounded-lg text-slate-400 group-hover:text-teal-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="text-[15px] font-extrabold text-slate-600 tracking-normal">Lokasi</span>
                        </div>
                        <div class="text-[15px] text-slate-800 font-bold leading-snug">
                            {{ $activity->location ?? '-' }}
                        </div>
                    </div>
                @elseif ($activity->type_idp == 3)
                    <div class="p-6 bg-white rounded-2xl border border-slate-200 border-l-4 border-l-transparent transition-all group hover:border-l-teal-500">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-slate-50 rounded-lg text-slate-400 group-hover:text-teal-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-[15px] font-extrabold text-slate-600 tracking-normal">Platform</span>
                        </div>
                        <div class="text-[15px] text-slate-800 font-bold leading-snug">
                            {{ $activity->platform ?? '-' }}
                        </div>
                    </div>
                @endif

                <div class="p-6 bg-white rounded-2xl border border-slate-200 border-l-4 border-l-transparent transition-all group hover:border-l-teal-500">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-2 bg-slate-50 rounded-lg text-slate-400 group-hover:text-teal-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                        </div>
                        <span class="text-[15px] font-extrabold text-slate-600 tracking-normal">Dokumentasi</span>
                    </div>
                    @php
                        $dPaths = [];
                        $dNames = [];
                        if ($activity->document_path) {
                            if (str_starts_with($activity->document_path, '["')) {
                                $dPaths = json_decode($activity->document_path, true);
                                $dNames = explode(', ', $activity->file_name ?? '');
                            } else {
                                $dPaths = [$activity->document_path];
                                $dNames = [$activity->file_name ?? 'Dokumen'];
                            }
                        }
                    @endphp
                    @if (count($dPaths) > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach ($dPaths as $di => $dp)
                                <a href="{{ asset('storage/' . $dp) }}" target="_blank"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-[12px] font-black text-teal-600 hover:text-white hover:bg-teal-500 hover:border-teal-500 shadow-sm transition-all duration-300">
                                    {{ $dNames[$di] ?? 'File ' . ($di + 1) }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <span class="text-[13px] text-slate-400 font-bold italic">- Tidak ada file terlampir</span>
                    @endif
                </div>

                {{-- Full width sections --}}
                @if ($activity->type_idp == 1)
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 border-l-4 border-l-transparent md:col-span-3 transition-all group hover:border-l-teal-500">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-slate-50 rounded-lg text-slate-400 group-hover:text-teal-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span class="text-[15px] font-extrabold text-slate-600 tracking-normal">Aktivitas</span>
                        </div>
                        <div class="text-[15px] text-slate-800 font-medium leading-relaxed break-words">{{ $activity->activity ?? '-' }}</div>
                    </div>
                @endif

                @if ($activity->type_idp != 3)
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 border-l-4 border-l-transparent md:col-span-3 transition-all group hover:border-l-teal-500">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-slate-50 rounded-lg text-slate-400 group-hover:text-teal-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <span class="text-[15px] font-extrabold text-slate-600 tracking-normal">Deskripsi</span>
                        </div>
                        <div class="text-[15px] text-slate-800 leading-relaxed font-medium break-words italic">
                            "{{ $activity->description ?? '-' }}"
                        </div>
                    </div>
                @endif

                @if ($activity->type_idp == 2)
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 border-l-4 border-l-transparent md:col-span-3 transition-all group hover:border-l-teal-500">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-slate-50 rounded-lg text-slate-400 group-hover:text-teal-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <span class="text-[15px] font-extrabold text-slate-600 tracking-normal">Action Plan</span>
                        </div>
                        <div class="text-[15px] text-slate-800 leading-relaxed font-medium break-words">
                            {{ $activity->action_plan ?? '-' }}
                        </div>
                    </div>
                @endif
            </div>

            @php
                // Check if current user is authorized to validate
                $isAuthorizedValidator = $activity->type_idp == 3 ? true : $user->id === $activity->verify_by;
            @endphp

            @if (
                $isAuthorizedValidator &&
                    ($activity->status === 'Pending' || $activity->status === null || $activity->status === ''))
                <div class="mt-12 flex justify-end gap-4 pt-8 border-t border-slate-100">
                    <button type="button" onclick="openConfirmModal('Rejected')"
                        class="inline-flex items-center gap-2 px-8 py-3.5 border-2 border-red-500 text-red-500 bg-white font-black text-sm rounded-xl hover:bg-red-500 hover:text-white hover:shadow-lg hover:shadow-red-500/20 transition-all duration-300 transform hover:-translate-y-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reject
                    </button>
                    <button type="button" onclick="openConfirmModal('Approved')"
                        class="inline-flex items-center gap-2 px-8 py-3.5 border-2 border-emerald-500 text-emerald-600 bg-white font-black text-sm rounded-xl hover:bg-emerald-500 hover:text-white hover:shadow-lg hover:shadow-emerald-500/20 transition-all duration-300 transform hover:-translate-y-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Approve
                    </button>
                </div>
            @endif
        </div>
    </div>

    @if (
        $isAuthorizedValidator &&
            ($activity->status === 'Pending' || $activity->status === null || $activity->status === ''))
        {{-- Modal Confirm Action --}}
        <div id="confirmModal"
            class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-[#0f172a]/60 backdrop-blur-md transition-opacity opacity-0"
            style="transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
            <div class="bg-white rounded-[28px] shadow-2xl w-full max-w-[400px] p-8 text-center transform scale-90 transition-transform duration-400 ease-out"
                id="confirmModalContent">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-900 mb-6 shadow-xl shadow-slate-900/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                
                <h3 class="text-2xl font-black text-slate-900 mb-3 tracking-tight">Konfirmasi Validasi</h3>
                <p class="text-[14px] text-slate-500 leading-relaxed mb-8 font-medium">
                    Apakah Anda yakin ingin <span id="modalActionText" class="font-black text-slate-900 underline decoration-teal-400 decoration-2">...</span> aktivitas ini? 
                    <br><span class="text-slate-400 text-[12px] italic mt-2 block">Keputusan ini akan langsung tercatat di logbook talent.</span>
                </p>

                <form id="confirmActionForm" method="POST" action="{{ url('/mentor/validasi/' . $activity->id . '/status') }}">
                    @csrf
                    <input type="hidden" name="status" id="actionStatusInput" value="">
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" onclick="closeConfirmModal()"
                            class="w-full bg-slate-100 text-slate-500 font-black py-3.5 rounded-2xl hover:bg-slate-200 transition-all duration-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="w-full bg-[#14b8a6] text-white font-black py-3.5 rounded-2xl hover:bg-teal-600 hover:shadow-lg hover:shadow-teal-500/30 transition-all duration-200">
                            Konfirmasi
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
                        modalContent.classList.remove('scale-90');
                        modalContent.classList.add('scale-100');
                    }, 10);
                }

                function closeConfirmModal() {
                    const modal = document.getElementById('confirmModal');
                    const modalContent = document.getElementById('confirmModalContent');
                    modal.classList.add('opacity-0');
                    modalContent.classList.remove('scale-100');
                    modalContent.classList.add('scale-90');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                    }, 400);
                }
            </script>
        </x-slot>
    @endif
</x-mentor.layout>
