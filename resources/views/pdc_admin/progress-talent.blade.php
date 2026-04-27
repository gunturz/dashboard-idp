<x-pdc_admin.layout title="Progress Talent - Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            .delete-modal-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.45);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 24px;
                z-index: 60;
            }

            .delete-modal-panel {
                width: 100%;
                max-width: 420px;
                background: white;
                border-radius: 20px;
                box-shadow: 0 24px 60px rgba(15, 23, 42, 0.22);
                border: 1px solid #e2e8f0;
                overflow: hidden;
            }
        </style>
    </x-slot>

    <div class="page-header animate-title">
        <div class="page-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z"/>
                <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z"/>
            </svg>
        </div>
        <div>
            <div class="page-header-title">Progress Talent</div>
            <div class="page-header-sub">Pantau perkembangan seluruh talent aktif</div>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('pdc_admin.development_plan') }}" class="btn-prem btn-dark">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Development Plan
            </a>
        </div>
    </div>

    <livewire:pdc-progress-talent-table />

    <x-slot name="scripts"></x-slot>

</x-pdc_admin.layout>
