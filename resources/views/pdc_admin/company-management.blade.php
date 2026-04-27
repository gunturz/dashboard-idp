<x-pdc_admin.layout title="Company Management – PDC Admin" :user="$user">
    <x-slot name="styles">
        <style>
            .company-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: white;
                border: 1.5px solid #e2e8f0;
                border-radius: 14px;
                padding: 16px 24px;
                transition: box-shadow 0.2s, transform 0.1s;
            }

            .company-row:hover {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            }

            .company-name {
                font-size: 1rem;
                font-weight: 700;
                color: #0f172a;
            }

            @media (max-width: 640px) {
                .company-row {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 16px;
                    padding: 20px;
                }

                .toolbar-wrap {
                    flex-direction: column;
                    align-items: stretch;
                }

                .search-container {
                    width: 100% !important;
                }

                .company-actions {
                    width: 100%;
                    justify-content: space-between;
                }
            }
        </style>
    </x-slot>

    {{-- Page Header --}}
    <div class="page-header animate-title mb-8">
        <div class="page-header-icon shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                <path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5H15v-18a.75.75 0 0 0 0-1.5H3ZM6.75 19.5v-2.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1-.75-.75ZM6 6.75A.75.75 0 0 1 6.75 6h.75a.75.75 0 0 1 0 1.5h-.75A.75.75 0 0 1 6 6.75ZM6.75 9a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM6 12.75a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 6a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75Zm-.75 3.75A.75.75 0 0 1 10.5 9h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 12a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM16.5 6.75v15h5.25a.75.75 0 0 0 0-1.5H21v-12a.75.75 0 0 0 0-1.5h-4.5Zm1.5 4.5a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Zm.75 2.25a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75v-.008a.75.75 0 0 0-.75-.75h-.008ZM18 17.25a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">Company Management</div>
            <div class="page-header-sub">Kelola daftar perusahaan serta integrasi struktur departemen dalam sistem.</div>
        </div>
    </div>

    <livewire:pdc-company-management />

    <x-slot name="scripts"></x-slot>

</x-pdc_admin.layout>
