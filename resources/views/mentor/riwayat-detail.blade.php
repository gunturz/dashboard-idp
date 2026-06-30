<x-mentor.layout title="Detail Logbook" :user="$user" :notifications="$notifications">
    <div class="fade-up">
        {{-- ── Page Header ── --}}
        <div class="page-header animate-title mb-4">
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
                <h1 class="page-header-title text-slate-800">Detail Logbook -
                    {{ $activity->type->type_name ?? 'Aktivitas' }}</h1>
                <p class="page-header-sub text-slate-500">Tinjau informasi mendalam mengenai aktivitas pengembangan
                    talent.</p>
            </div>
        </div>

        <div class="prem-card border border-slate-200 shadow-xl shadow-slate-200/50 p-6"
            style="background-color: #f1f5f9 !important;">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Row 1 --}}
                @if ($activity->type_idp == 1 || $activity->type_idp == 2)
                    <div class="p-5 bg-white rounded-xl border border-slate-200">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-[15px] font-extrabold text-black tracking-normal">Mentor</span>
                        </div>
                        <div class="text-[15px] text-slate-800 font-medium leading-relaxed break-words">
                            {{ $activity->verifier->nama ?? '-' }}</div>
                    </div>
                @elseif ($activity->type_idp == 3)
                    <div class="p-5 bg-white rounded-xl border border-slate-200">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-[15px] font-extrabold text-black tracking-normal">Sumber</span>
                        </div>
                        <div class="text-[15px] text-slate-800 font-medium leading-relaxed break-words">
                            {{ $activity->activity ?? '-' }}</div>
                    </div>
                @endif

                <div class="p-5 bg-white rounded-xl border border-slate-200">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-[15px] font-extrabold text-black tracking-normal">Tema</span>
                    </div>
                    <div class="text-[15px] text-slate-800 font-medium leading-relaxed break-words">
                        {{ $activity->theme ?? '-' }}</div>
                </div>

                <div class="p-5 bg-white rounded-xl border border-slate-200">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-[15px] font-extrabold text-black tracking-normal">Tanggal Pelaksanaan</span>
                    </div>
                    <div class="text-[15px] text-slate-800 font-medium leading-relaxed break-words">
                        {{ \Carbon\Carbon::parse($activity->activity_date)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}
                    </div>
                </div>

                {{-- Row 2 --}}
                <div class="p-5 bg-white rounded-xl border border-slate-200">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-[15px] font-extrabold text-black tracking-normal">Update Terakhir</span>
                    </div>
                    <div class="text-[15px] text-slate-800 font-medium leading-relaxed break-words">
                        {{ $activity->updated_at ? \Carbon\Carbon::parse($activity->updated_at)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}
                    </div>
                </div>

                @if ($activity->type_idp == 1 || $activity->type_idp == 2)
                    <div class="p-5 bg-white rounded-xl border border-slate-200">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-[15px] font-extrabold text-black tracking-normal">Lokasi</span>
                        </div>
                        <div class="text-[15px] text-slate-800 font-medium leading-relaxed break-words">
                            {{ $activity->location ?? '-' }}
                        </div>
                    </div>
                @elseif ($activity->type_idp == 3)
                    <div class="p-5 bg-white rounded-xl border border-slate-200">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-[15px] font-extrabold text-black tracking-normal">Platform</span>
                        </div>
                        <div class="text-[15px] text-slate-800 font-medium leading-relaxed break-words">
                            {{ $activity->platform ?? '-' }}
                        </div>
                    </div>
                @endif

                <div class="p-5 bg-white rounded-xl border border-slate-200">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-[15px] font-extrabold text-black tracking-normal">Dokumentasi</span>
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
                                <a href="{{ route('files.preview', ['path' => $dp]) }}" target="_blank"
                                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[12px] font-semibold text-teal-600 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50/50 shadow-sm transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                        </path>
                                    </svg>
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
                    <div class="p-5 bg-white rounded-xl border border-slate-200 md:col-span-3">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-[15px] font-extrabold text-black tracking-normal">Aktivitas</span>
                        </div>
                        <div class="text-[15px] text-slate-800 font-medium leading-relaxed break-words">
                            {{ $activity->activity ?? '-' }}</div>
                    </div>
                @endif

                @if ($activity->type_idp != 3)
                    <div class="p-5 bg-white rounded-xl border border-slate-200 md:col-span-3">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-[15px] font-extrabold text-black tracking-normal">Deskripsi</span>
                        </div>
                        <div class="text-[15px] text-slate-800 leading-relaxed font-medium break-words">
                            {{ $activity->description ?? '-' }}
                        </div>
                    </div>
                @endif

                @if ($activity->type_idp == 2)
                    <div class="p-5 bg-white rounded-xl border border-slate-200 md:col-span-3">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-[15px] font-extrabold text-black tracking-normal">Action Plan</span>
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
                <div class="mt-3 flex justify-end gap-4 pt-3 border-t border-slate-100">
                    <button type="button" onclick="openConfirmModal('Rejected')"
                        class="inline-flex items-center gap-2 px-8 py-3.5 bg-red-500 text-white font-black text-sm rounded-xl hover:bg-red-600 hover:shadow-lg hover:shadow-red-500/30 transition-all duration-300 transform hover:-translate-y-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reject
                    </button>
                    <button type="button" onclick="openConfirmModal('Approved')"
                        class="inline-flex items-center gap-2 px-8 py-3.5 bg-[#14b8a6] text-white font-black text-sm rounded-xl hover:bg-teal-600 hover:shadow-lg hover:shadow-teal-500/30 transition-all duration-300 transform hover:-translate-y-1">
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
            class="hidden fixed inset-0 z-[100] flex items-center justify-center transition-opacity opacity-0"
            style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
            <div class="bg-white rounded-[28px] shadow-2xl w-[calc(100%-2.5rem)] sm:w-full max-w-[400px] p-6 sm:p-8 text-center transform scale-90 transition-transform duration-400 ease-out"
                id="confirmModalContent">
                <div id="modalIconContainer"
                    class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-900 mb-6 shadow-xl shadow-slate-900/20">
                    <svg id="modalIconSvg" xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h3 class="text-2xl font-black text-slate-900 mb-3 tracking-tight">Konfirmasi Validasi</h3>
                <p class="text-[14px] text-slate-500 leading-relaxed mb-8 font-medium">
                    Apakah Anda yakin ingin <span id="modalActionText"
                        class="font-black text-slate-900 underline decoration-teal-400 decoration-2">...</span>
                    aktivitas ini?
                    <br><span class="text-slate-400 text-[12px] italic mt-2 block">Keputusan ini akan langsung tercatat
                        di logbook talent.</span>
                </p>

                <form id="confirmActionForm" method="POST"
                    action="{{ url('/mentor/validasi/' . $activity->id . '/status') }}">
                    @csrf
                    <input type="hidden" name="status" id="actionStatusInput" value="">
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" onclick="closeConfirmModal()"
                            class="w-full bg-slate-100 text-slate-500 font-black py-3.5 rounded-2xl hover:bg-slate-200 transition-all duration-200">
                            Batal
                        </button>
                        <button type="submit" id="confirmSubmitBtn"
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
                    const iconContainer = document.getElementById('modalIconContainer');
                    const iconSvg = document.getElementById('modalIconSvg');
                    const submitBtn = document.getElementById('confirmSubmitBtn');

                    inputStatus.value = status;
                    actionText.textContent = status === 'Approved' ? 'Approve' : 'Reject';

                    // Reset classes
                    iconContainer.className = "mx-auto flex h-20 w-20 items-center justify-center rounded-full mb-6 shadow-xl";
                    submitBtn.className = "w-full text-white font-black py-3.5 rounded-2xl transition-all duration-200";

                    if (status === 'Approved') {
                        iconContainer.classList.add('bg-[#14b8a6]', 'shadow-teal-500/30');
                        submitBtn.classList.add('bg-[#14b8a6]', 'hover:bg-teal-600', 'hover:shadow-lg', 'hover:shadow-teal-500/30');
                        iconSvg.innerHTML =
                            `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />`;
                    } else {
                        iconContainer.classList.add('bg-red-500', 'shadow-red-500/30');
                        submitBtn.classList.add('bg-red-500', 'hover:bg-red-600', 'hover:shadow-lg', 'hover:shadow-red-500/30');
                        iconSvg.innerHTML =
                            `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />`;
                    }

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
