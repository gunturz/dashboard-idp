<x-pdc_admin.layout title="Finance Validation – PDC Admin" :user="$user">
    <x-slot name="styles">
        <style>
            /* Summary Cards */
            .stat-card {
                background: white;
                border-radius: 12px;
                padding: 24px;
                text-align: center;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                min-height: 140px;
                border: 2px solid transparent;
            }

            .stat-card .stat-number {
                font-size: 2.5rem;
                font-weight: 800;
                line-height: 1.2;
                margin-bottom: 8px;
                color: #0f172a;
            }

            .stat-card .stat-label {
                font-size: 0.8rem;
                color: #64748b;
                font-weight: 500;
            }

            .card-default {
                border-color: #0d9488;
            }

            .card-default .stat-number {
                color: #0d9488;
            }

            .card-pending {
                border-color: #f59e0b;
            }

            .card-pending .stat-number {
                color: #f59e0b;
            }

            .card-approved {
                border-color: #22c55e;
            }

            .card-approved .stat-number {
                color: #22c55e;
            }

            .card-rejected {
                border-color: #ef4444;
            }

            .card-rejected .stat-number {
                color: #ef4444;
            }

            /* Table */
            .fv-table-wrapper {
                border: 1.5px solid #e2e8f0;
                border-radius: 14px;
                overflow-x: auto;
            }

            .fv-table-title {
                padding: 18px 24px;
                font-size: 1rem;
                font-weight: 700;
                color: #0f172a;
                white-space: nowrap;
            }

            .fv-table {
                width: 100%;
                border-collapse: collapse;
            }

            .fv-table thead tr {
                background: #f8fafc;
                border-top: 1px solid #e2e8f0;
            }

            .fv-table th {
                padding: 14px 20px;
                font-size: 0.85rem;
                font-weight: 700;
                color: #0f172a;
                text-align: center;
                border-right: 1px solid #f1f5f9;
            }

            .fv-table th:last-child {
                border-right: none;
            }

            .fv-table td {
                padding: 16px 20px;
                font-size: 0.875rem;
                color: #475569;
                text-align: center;
                border-top: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
                vertical-align: middle;
            }

            .fv-table td:last-child {
                border-right: none;
            }

            .fv-table tbody tr:hover {
                background: #fafafa;
            }

            /* Status badges */
            .status-dot {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 0.825rem;
                font-weight: 600;
            }

            .status-dot::before {
                content: '';
                width: 9px;
                height: 9px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            .status-approve::before {
                background: #22c55e;
            }

            .status-pending::before {
                background: #f59e0b;
            }

            .status-rejected::before {
                background: #ef4444;
            }

            /* Action buttons */
            .btn-reject {
                padding: 6px 18px;
                border: 1.5px solid #ef4444;
                color: #ef4444;
                background: white;
                border-radius: 8px;
                font-size: 0.8rem;
                font-weight: 600;
                cursor: pointer;
                transition: all .15s;
            }

            .btn-reject:hover {
                background: #fef2f2;
            }

            .btn-approve {
                padding: 6px 18px;
                border: 1.5px solid #22c55e;
                color: #22c55e;
                background: white;
                border-radius: 8px;
                font-size: 0.8rem;
                font-weight: 600;
                cursor: pointer;
                transition: all .15s;
            }

            .btn-approve:hover {
                background: #f0fdf4;
            }

            .file-link {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                font-size: 0.8rem;
                color: #3b82f6;
                text-decoration: none;
                font-weight: 500;
                transition: color .15s;
            }

            .file-link:hover {
                color: #2563eb;
                text-decoration: underline;
            }
        </style>
    </x-slot>

    {{-- ── Page Header ── --}}
    <div class="page-header animate-title">
        <div class="page-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z"/>
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div>
            <div class="page-header-title">Finance Validation</div>
            <div class="page-header-sub">Kelola validasi project improvement talent</div>
        </div>
    </div>

    {{-- Livewire Component --}}
    <livewire:pdc-finance-validation-table />

</x-pdc_admin.layout>
