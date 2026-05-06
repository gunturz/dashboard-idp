<x-pdc_admin.layout title="Detail Progress Talent – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 5px;
                height: 5px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
            }

            ::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 20px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            /* Custom Scrollbar Styles for LogBook Tables */
            .custom-scrollbar::-webkit-scrollbar {
                height: 8px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f8fafc;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #0d9488;
                border-radius: 10px;
                border: 2px solid #f8fafc;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #0f766e;
            }

            .log-table-container {
                background: white;
                border-radius: 16px;
                border: 1px solid #e2e8f0;
                overflow: hidden;
                position: relative;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }

            .pdc-log-table {
                width: 100%;
                border-collapse: collapse;
            }

            .pdc-log-table th {
                padding: 24px 32px;
                background: #f8fafc;
                font-weight: 800;
                color: #475569;
                font-size: 0.95rem;
                text-align: center;
                white-space: nowrap;
            }

            .pdc-log-table td {
                padding: 32px;
                color: #64748b;
                font-size: 0.9rem;
                border-top: 1px solid #f1f5f9;
            }

            .pdc-log-table tr:hover {
                background: #fafafa;
            }

            /* --- MODAL STYLES --- */
            .modal-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.4);
                backdrop-filter: blur(4px);
                z-index: 100;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s;
            }

            .modal-overlay.active {
                opacity: 1;
                pointer-events: auto;
            }

            .modal-content {
                background: white;
                width: 100%;
                max-width: 500px;
                max-height: 90vh;
                border-radius: 20px;
                padding: 32px;
                overflow-y: auto;
                transform: translateY(20px);
                transition: transform 0.3s;
            }

            .modal-overlay.active .modal-content {
                transform: translateY(0);
            }

            .modal-title {
                font-size: 1.25rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 4px;
            }

            .modal-subtitle {
                font-size: 1rem;
                font-weight: 700;
                color: #475569;
                margin-bottom: 24px;
            }

            .alert-info-modal {
                background: #f0fdfa;
                border: 1px solid #5eead4;
                border-radius: 8px;
                padding: 12px;
                display: flex;
                gap: 12px;
                margin-bottom: 24px;
            }

            .alert-info-modal span {
                font-size: 0.75rem;
                color: #0d9488;
                line-height: 1.4;
            }

            .gap-selection-list {
                display: flex;
                flex-direction: column;
                gap: 12px;
                margin-bottom: 24px;
                max-height: 400px;
                overflow-y: auto;
                padding-right: 8px;
            }

            .gap-select-item {
                display: flex;
                align-items: center;
                gap: 16px;
                padding: 12px 16px;
                border: 1.5px solid #e2e8f0;
                border-radius: 12px;
                cursor: pointer;
                transition: all 0.2s;
            }

            .gap-select-item input[type="checkbox"] {
                width: 20px;
                height: 20px;
                border-radius: 4px;
                border: 2px solid #cbd5e1;
                cursor: pointer;
                accent-color: #0f172a;
            }

            .gap-name-modal {
                flex: 1;
                font-weight: 700;
                color: #334155;
                font-size: 0.875rem;
            }

            .gap-score-modal {
                font-size: 0.75rem;
                color: #94a3b8;
                font-weight: 600;
            }

            .gap-value-badge {
                padding: 4px 8px;
                background: #f8fafc;
                border-radius: 6px;
                font-size: 0.75rem;
                font-weight: 800;
                color: #1e293b;
                min-width: 32px;
                text-align: center;
            }

            /* Priority Colors */
            .gap-select-item.priority-1 {
                border-color: #ef4444;
                border-width: 2px;
            }

            .gap-select-item.priority-1 input {
                accent-color: #ef4444;
            }

            .gap-select-item.priority-2 {
                border-color: #f97316;
                border-width: 2px;
            }

            .gap-select-item.priority-2 input {
                accent-color: #f97316;
            }

            .gap-select-item.priority-3 {
                border-color: #3b82f6;
                border-width: 2px;
            }

            .gap-select-item.priority-3 input {
                accent-color: #3b82f6;
            }

            /* --- FINANCE MODAL STYLES --- */
            .finance-modal-content {
                max-width: 480px;
                padding: 0;
            }

            .finance-header {
                padding: 16px 24px;
                border-bottom: 1px solid #f1f5f9;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .finance-body {
                padding: 20px 24px 16px;
            }

            .finance-alert {
                background: #f0fdfa;
                border: 1px solid #5eead4;
                border-radius: 8px;
                padding: 10px 12px;
                display: flex;
                gap: 10px;
                margin-bottom: 16px;
            }

            .finance-alert-text {
                font-size: 0.75rem;
                color: #0f766e;
                line-height: 1.4;
            }

            .finance-form-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
                margin-bottom: 12px;
            }

            .finance-field-label {
                font-size: 0.7rem;
                font-weight: 800;
                color: #0f172a;
                text-transform: uppercase;
                margin-bottom: 4px;
                display: block;
            }

            .finance-readonly-box {
                background: #f8fafc;
                border: 1.5px solid #e2e8f0;
                border-radius: 8px;
                padding: 7px 12px;
                font-size: 0.8rem;
                font-weight: 700;
                color: #1e293b;
            }

            .finance-input {
                width: 100%;
                background: #ffffff;
                border: 1.5px solid #e2e8f0;
                border-radius: 8px;
                padding: 7px 12px;
                font-size: 0.8rem;
                outline: none;
                transition: border-color 0.2s;
            }

            .finance-input:focus {
                border-color: #0d9488;
            }

            .finance-textarea {
                min-height: 80px;
                resize: none;
            }

            .finance-footer {
                padding: 0 24px 20px;
                display: flex;
                justify-content: flex-end;
                gap: 10px;
            }

            .btn-finance-cancel {
                background: #f5f5f1;
                color: #1e293b;
                font-weight: 700;
                padding: 9px 20px;
                border-radius: 8px;
                font-size: 0.8rem;
                transition: all 0.2s;
            }

            .btn-finance-cancel:hover {
                background: #e7e7e2;
            }

            .btn-finance-submit {
                background: #16c60c;
                color: white;
                font-weight: 700;
                padding: 9px 28px;
                border-radius: 8px;
                font-size: 0.8rem;
                transition: all 0.2s;
            }

            .btn-finance-submit:hover {
                background: #14b00a;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(22, 198, 12, 0.2);
            }

            .textarea-label {
                font-size: 0.75rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 8px;
                display: block;
                text-transform: uppercase;
            }

            .modal-textarea {
                width: 100%;
                border: 1.5px solid #e2e8f0;
                border-radius: 12px;
                padding: 12px;
                font-size: 0.8125rem;
                min-height: 100px;
                resize: none;
                margin-bottom: 24px;
                color: #475569;
            }

            .modal-textarea::placeholder {
                color: #cbd5e1;
            }

            .modal-footer {
                display: flex;
                gap: 12px;
                justify-content: flex-end;
            }

            .btn-modal {
                padding: 10px 24px;
                border-radius: 10px;
                font-size: 0.875rem;
                font-weight: 700;
                transition: all 0.2s;
            }

            .btn-reset-auto {
                background: #f3f4f6;
                color: #4b5563;
            }

            .btn-cancel {
                background: #fef3c7;
                color: #92400e;
            }

            .btn-save {
                background: #22c55e;
                color: white;
                flex: 1;
            }

            .btn-save:hover {
                background: #16a34a;
            }

            /* --- PRE-EXISTING STYLES --- */
            .btn-back {
                padding: 8px 16px;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                background: white;
                color: #475569;
                font-weight: 500;
                font-size: 0.875rem;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: all 0.2s;
            }

            .btn-back:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }

            .pill-nav-wrapper {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 0;
                width: 100%;
            }

            .pill-nav-back {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: #f1f5f9;
                border: 1px solid #d1d5db;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #6b7280;
                cursor: pointer;
                transition: all 0.2s;
                text-decoration: none;
                flex-shrink: 0;
            }

            .pill-nav-back:hover {
                background: #e2e8f0;
                color: #1e293b;
            }

            .pill-nav-tabs {
                display: flex;
                flex: 1;
                background: #e5e7eb;
                border-radius: 9999px;
                padding: 4px;
                gap: 0;
            }

            .pill-tab {
                flex: 1;
                text-align: center;
                padding: 8px 12px;
                border-radius: 9999px;
                font-size: 0.8rem;
                font-weight: 600;
                color: #6b7280;
                cursor: pointer;
                transition: all 0.2s;
                white-space: nowrap;
                background: transparent;
            }

            .pill-tab:hover {
                color: #1e293b;
                background: rgba(255, 255, 255, 0.5);
            }

            .pill-tab.active {
                background: #0f172a;
                color: white;
                font-weight: 700;
                box-shadow: 0 2px 8px rgba(15, 23, 42, 0.22);
            }

            /* Keep old tab-item for mobile compat */
            .nav-tabs {
                display: none;
            }

            .tab-item {
                padding: 8px 16px;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                background: white;
                color: #475569;
                font-weight: 600;
                font-size: 0.875rem;
                display: flex;
                align-items: center;
                gap: 8px;
                cursor: pointer;
                transition: all 0.2s;
            }

            .tab-item.active {
                background: #f1f5f9;
                border-color: #94a3b8;
                color: #1e293b;
            }

            .section-title {
                position: relative;
                padding-left: 14px;
                display: flex;
                align-items: center;
                gap: 12px;
                font-size: 1.25rem;
                font-weight: 800;
                color: #1e293b;
                margin-top: 40px;
                margin-bottom: 24px;
            }
            .section-title::before {
                content: '';
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 4px;
                height: 20px;
                background: linear-gradient(180deg, #14b8a6, #0d9488);
                border-radius: 99px;
            }

            /* --- IDP DONUT CHARTS --- */
            .idp-card-container {
                background: #f8fafc;
                border-radius: 16px;
                padding: 24px;
                border: 1px solid #e2e8f0;
                margin-bottom: 24px;
            }

            .donut-container {
                background: white;
                border-radius: 16px;
                padding: 30px;
                display: flex;
                justify-content: space-around;
                align-items: center;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            }

            .donut-wrapper {
                position: relative;
                width: 160px;
                height: 160px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .donut-text {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
            }

            .donut-label-box {
                margin-top: 15px;
                padding: 4px 20px;
                border: 1px solid #e2e8f0;
                border-radius: 99px;
                font-size: 0.875rem;
                font-weight: 600;
                color: #475569;
            }

            /* --- TABLES --- */
            .pdc-custom-table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid #e2e8f0;
            }

            .pdc-custom-table th {
                background: #f8fafc;
                padding: 12px;
                border: 1px solid #e2e8f0;
                font-size: 0.85rem;
                font-weight: 800;
                color: #1e293b;
            }

            .pdc-custom-table td {
                padding: 12px;
                border: 1px solid #e2e8f0;
                font-size: 0.85rem;
            }

            .btn-status-action {
                padding: 6px 16px;
                border-radius: 6px;
                font-size: 0.75rem;
                font-weight: 700;
                transition: all 0.2s;
            }

            .btn-reject {
                border: 1.5px solid #ef4444;
                color: #ef4444;
                background: white;
            }

            .btn-approve {
                border: 1.5px solid #22c55e;
                color: #22c55e;
                background: white;
            }

            .btn-reject:hover {
                background: #ef4444;
                color: white;
            }

            .btn-approve:hover {
                background: #22c55e;
                color: white;
            }

            .btn-audit {
                background: #0f172a;
                color: white;
                padding: 8px 16px;
                border-radius: 8px;
                font-size: 0.75rem;
                font-weight: 700;
            }

            .btn-pilih-aksi {
                background: #f59e0b;
                color: white;
                padding: 8px 16px;
                border-radius: 8px;
                font-size: 0.75rem;
                font-weight: 700;
                transition: all 0.2s;
            }

            .btn-pilih-aksi:hover {
                background: #d97706;
            }

            .btn-sudah-dipilih {
                background: white;
                color: #94a3b8;
                padding: 8px 16px;
                border-radius: 8px;
                font-size: 0.75rem;
                font-weight: 700;
                border: 1.5px solid #e2e8f0;
                cursor: not-allowed;
            }

            /* Update Status Modal */
            .status-modal-icon {
                width: 72px;
                height: 72px;
                border-radius: 50%;
                background: #fef3c7;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 20px;
            }

            .status-modal-title {
                font-size: 1.35rem;
                font-weight: 800;
                color: #1e293b;
                text-align: center;
                margin-bottom: 12px;
            }

            .status-modal-desc {
                font-size: 0.875rem;
                color: #64748b;
                text-align: center;
                line-height: 1.6;
                margin-bottom: 28px;
            }

            .status-modal-desc strong {
                color: #1e293b;
            }

            .status-modal-actions {
                display: flex;
                gap: 12px;
                margin-bottom: 12px;
            }

            .btn-status-reject {
                flex: 1;
                background: #ef4444;
                color: white;
                font-weight: 700;
                padding: 14px;
                border-radius: 12px;
                font-size: 0.95rem;
                transition: all 0.2s;
            }

            .btn-status-reject:hover {
                background: #dc2626;
            }

            .btn-status-approve {
                flex: 1;
                background: #22c55e;
                color: white;
                font-weight: 700;
                padding: 14px;
                border-radius: 12px;
                font-size: 0.95rem;
                transition: all 0.2s;
            }

            .btn-status-approve:hover {
                background: #16a34a;
            }

            .btn-status-batal {
                width: 100%;
                background: #f1f5f9;
                color: #475569;
                font-weight: 700;
                padding: 14px;
                border-radius: 12px;
                font-size: 0.95rem;
                transition: all 0.2s;
            }

            .btn-status-batal:hover {
                background: #e2e8f0;
            }

            .filter-pills {
                display: flex;
                background: #e2e8f0;
                padding: 4px;
                border-radius: 9999px;
                width: fit-content;
                margin-bottom: 20px;
            }

            .pill {
                padding: 8px 32px;
                border-radius: 9999px;
                font-size: 0.875rem;
                font-weight: 700;
                color: #475569;
                cursor: pointer;
                transition: all 0.2s;
            }

            .pill:hover {
                background: #cbd5e1;
                color: #1e293b;
            }

            .pill.active {
                background: #0f172a;
                color: white;
                box-shadow: 0 2px 12px rgba(15, 23, 42, 0.22);
            }

            /* --- HEATMAP & COMPETENCY --- */
            .talent-gap-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 24px;
                margin-bottom: 48px;
            }

            .talent-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 24px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }

            .talent-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 20px;
            }

            .talent-info {
                display: flex;
                gap: 16px;
            }

            .talent-photo {
                width: 64px;
                height: 64px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #f1f5f9;
            }

            .talent-meta h4 {
                font-size: 1.125rem;
                font-weight: 700;
                color: #1e293b;
            }

            .talent-meta p {
                font-size: 0.75rem;
                color: #64748b;
                font-style: italic;
            }

            .btn-pilih-gap {
                padding: 6px 12px;
                background: #0f172a;
                color: white;
                font-size: 0.75rem;
                font-weight: 600;
                border-radius: 6px;
            }

            .top-gap-label {
                text-align: right;
                font-size: 0.75rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 12px;
                display: block;
            }

            .gap-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 16px;
                border-radius: 99px;
                margin-bottom: 10px;
                font-size: 0.875rem;
                font-weight: 600;
            }

            .gap-item.prio-1 {
                border: 1.5px solid #b91c1c;
                color: #991b1b;
                background: #fef2f2;
            }

            .gap-item.prio-2 {
                border: 1.5px solid #c2410c;
                color: #9a3412;
                background: #fff7ed;
            }

            .gap-item.prio-3 {
                border: 1.5px solid #1d4ed8;
                color: #1e40af;
                background: #eff6ff;
            }

            .gap-number {
                width: 24px;
                height: 24px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 0.75rem;
                margin-right: 12px;
                font-weight: 800;
            }

            .gap-item.prio-1 .gap-number {
                background: #b91c1c;
            }

            .gap-item.prio-2 .gap-number {
                background: #c2410c;
            }

            .gap-item.prio-3 .gap-number {
                background: #1d4ed8;
            }

            .heatmap-container {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                overflow: hidden;
            }

            .heatmap-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.8125rem;
            }

            .heatmap-table th,
            .heatmap-table td {
                border: 1px solid #e2e8f0;
                padding: 8px 12px;
                text-align: center;
            }

            .heatmap-table .th-main {
                background: #f8fafc;
                font-weight: 700;
                color: #1e293b;
            }

            .heatmap-table .th-sub {
                font-size: 0.65rem;
                font-weight: 700;
                color: #475569;
                text-transform: uppercase;
                background: #f8fafc;
            }

            .heatmap-table .td-left {
                text-align: left;
                font-weight: 600;
                color: #334155;
            }

            .gap-badge {
                display: block;
                width: 100%;
                height: 100%;
                padding: 4px;
                border-radius: 4px;
                font-weight: 700;
                color: white;
            }

            .gap-none {
                background-color: #f1f5f9;
                color: #64748b;
            }

            .gap-ok {
                background-color: #cbd5e1;
                color: #1e293b;
            }

            .gap-small {
                background-color: #f97316;
                color: white;
            }

            .gap-large {
                background-color: #ef4444;
                color: white;
            }

            .legend {
                display: flex;
                gap: 16px;
                font-size: 0.65rem;
                font-weight: 700;
                color: #64748b;
                margin-bottom: 12px;
                text-transform: uppercase;
            }

            .legend-item {
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .legend-box {
                width: 12px;
                height: 12px;
                border-radius: 2px;
            }


            .mobile-nav-select {
                display: none;
                width: 100%;
                margin-top: 12px;
            }

            /* Clickable donut label button */
            .donut-label-btn {
                border-radius: 8px;
                padding: 8px 24px;
                font-size: 0.85rem;
                font-weight: 700;
                color: white;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 6px;
                border: none;
            }

            .donut-label-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
                filter: brightness(1.1);
                color: white;
            }

            /* --- Responsive --- */
            @media (max-width: 768px) {
                .pill-nav-tabs {
                    gap: 0;
                }

                .pill-tab {
                    padding: 8px 14px;
                    font-size: 0.78rem;
                }

                .filter-pills {
                    width: 100%;
                    display: flex;
                    justify-content: space-between;
                    padding: 4px;
                }

                .pill {
                    flex: 1;
                    text-align: center;
                    padding: 6px 2px;
                    font-size: 0.75rem;
                    white-space: nowrap;
                }

                .talent-gap-grid {
                    grid-template-columns: 1fr;
                }

                .donut-container {
                    flex-direction: column;
                    gap: 32px;
                }

                .finance-form-grid {
                    grid-template-columns: 1fr;
                }

                .btn-back {
                    align-self: flex-start;
                }
            }
        </style>
    </x-slot>

    {{-- Modal pilih GAP --}}
    
    <livewire:pdc-admin-talent-detail :user="$user" :company="$company" :targetPosition="$targetPosition" :talents="$talents" :competencies="$competencies" :standards="$standards" :financeUsers="$financeUsers" />
</x-pdc_admin.layout>
