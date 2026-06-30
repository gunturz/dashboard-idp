<x-finance.layout title="Permintaan Validasi" :user="$user">
    <div class="mb-8">
        {{-- ── Page Header ── --}}
        <div class="dash-header animate-title">
            <div class="dash-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <div class="dash-header-title">Permintaan Validasi</div>
                <div class="dash-header-sub">Review dan validasi dokumen project talent</div>
            </div>
        </div>
        {{-- Livewire Component --}}
        <livewire:finance-validasi-table />
    </div>

    {{-- Custom Confirmation Modal (Mentor Design Style) --}}
    <div id="finance-confirm-modal"
        class="hidden fixed inset-0 z-[100] flex items-center justify-center transition-opacity opacity-0"
        style="background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
        <div class="bg-white rounded-[28px] shadow-2xl w-[calc(100%-2.5rem)] sm:w-full max-w-[400px] p-6 sm:p-8 text-center transform scale-90 transition-transform duration-400 ease-out border border-slate-100"
            id="confirmModalContent">
            <div id="confirm-modal-icon-container"
                class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-900 mb-6 shadow-xl shadow-slate-900/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h3 class="text-2xl font-black text-slate-900 mb-3 tracking-tight">Konfirmasi Validasi</h3>
            <p class="text-[14px] text-slate-500 leading-relaxed mb-8 font-medium">
                Apakah Anda yakin ingin <span id="modalActionText" class="font-black text-slate-900">...</span> project
                <span id="modalProjectTitle" class="font-black text-slate-900">...</span> dari <span
                    id="modalTalentName" class="font-black text-slate-900">...</span>?
                <br><span class="text-slate-400 text-[12px] italic mt-2 block">Keputusan ini akan dikirim ke PDC Admin
                    untuk persetujuan akhir.</span>
            </p>

            <div class="grid grid-cols-2 gap-4">
                <button type="button" onclick="hideConfirmModal()"
                    class="w-full bg-slate-100 text-slate-500 font-black py-3.5 rounded-2xl hover:bg-slate-200 transition-all duration-200">
                    Batal
                </button>
                <button type="button" id="confirm-modal-submit-btn" onclick="submitDecision()"
                    class="w-full text-white font-black py-3.5 rounded-2xl transition-all duration-200">
                    Konfirmasi
                </button>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            #confirmModalContent {
                width: 93%
            }
        }
    </style>

    {{-- Script for Accordion & Modal Behavior --}}
    <script>
        function toggleAccordion(contentId, iconId) {
            const content = document.getElementById(contentId);
            const icon = document.getElementById(iconId);

            if (content.classList.contains('max-h-0')) {
                // Expanding
                content.classList.remove('max-h-0', 'opacity-0', 'pb-0', 'pt-0');
                content.classList.add('max-h-[1000px]', 'opacity-100', 'pb-6', 'pt-5', 'border-t');
                icon.classList.add('rotate-180');
            } else {
                // Collapsing
                content.classList.add('max-h-0', 'opacity-0', 'pb-0', 'pt-0');
                content.classList.remove('max-h-[1000px]', 'opacity-100', 'pb-6', 'pt-5', 'border-t');
                icon.classList.remove('rotate-180');
            }
        }

        let targetFormId = null;
        let decisionValue = null;

        function showConfirmModal(event, formId, decision, talentName, projectTitle) {
            event.preventDefault();

            targetFormId = formId;
            decisionValue = decision;

            const actionText = document.getElementById('modalActionText');
            const projectTitleSpan = document.getElementById('modalProjectTitle');
            const talentNameSpan = document.getElementById('modalTalentName');
            const submitBtn = document.getElementById('confirm-modal-submit-btn');
            const iconContainer = document.getElementById('confirm-modal-icon-container');

            projectTitleSpan.textContent = `"${projectTitle}"`;
            talentNameSpan.textContent = talentName;

            if (decision === 'Approved') {
                actionText.textContent = 'Approve';
                actionText.className = 'font-black text-[#14b8a6]';
                submitBtn.className =
                    'w-full bg-[#14b8a6] text-white font-black py-3.5 rounded-2xl hover:bg-teal-600 hover:shadow-lg hover:shadow-teal-500/30 transition-all duration-200';
                iconContainer.className =
                    'mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-[#14b8a6] mb-6 shadow-xl shadow-teal-500/20';
                iconContainer.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                `;
            } else {
                actionText.textContent = 'Reject';
                actionText.className = 'font-black text-red-500';
                submitBtn.className =
                    'w-full bg-red-500 text-white font-black py-3.5 rounded-2xl hover:bg-red-600 hover:shadow-lg hover:shadow-red-500/30 transition-all duration-200';
                iconContainer.className =
                    'mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-red-500 mb-6 shadow-xl shadow-red-500/20';
                iconContainer.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                `;
            }

            const modal = document.getElementById('finance-confirm-modal');
            const modalContent = document.getElementById('confirmModalContent');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-90');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function hideConfirmModal() {
            const modal = document.getElementById('finance-confirm-modal');
            const modalContent = document.getElementById('confirmModalContent');

            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-90');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 400);
        }

        function submitDecision() {
            if (targetFormId && decisionValue) {
                const form = document.getElementById(targetFormId);

                // Add hidden input for decision
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'finance_decision';
                hiddenInput.value = decisionValue;
                form.appendChild(hiddenInput);

                form.submit();
            }
        }
    </script>
</x-finance.layout>