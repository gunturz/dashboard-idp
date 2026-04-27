<x-finance.layout title="Permintaan Validasi" :user="$user">
    <div class="mb-8">
    {{-- ── Page Header ── --}}
    <div class="dash-header animate-title">
        <div class="dash-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <div class="dash-header-title">Permintaan Validasi</div>
            <div class="dash-header-sub">Review dan validasi dokumen project talent</div>
        </div>
        <div class="dash-header-date hidden md:block">
            Hari ini
            <span>{{ now()->translatedFormat('d F Y') }}</span>
        </div>
    </div>
        {{-- Livewire Component --}}
        <livewire:finance-validasi-table />
    </div>

    {{-- Script for Accordion Behavior --}}
    <script>
        function toggleAccordion(contentId, iconId) {
            const content = document.getElementById(contentId);
            const icon = document.getElementById(iconId);

            if (content.classList.contains('max-h-0')) {
                // Expanding
                content.classList.remove('max-h-0', 'opacity-0', 'pb-0', 'pt-0');
                content.classList.add('max-h-[1000px]', 'opacity-100', 'pb-6');
                icon.classList.add('rotate-180');
            } else {
                // Collapsing
                content.classList.add('max-h-0', 'opacity-0', 'pb-0', 'pt-0');
                content.classList.remove('max-h-[1000px]', 'opacity-100', 'pb-6');
                icon.classList.remove('rotate-180');
            }
        }
    </script>
</x-finance.layout>
