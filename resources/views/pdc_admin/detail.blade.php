<x-pdc_admin.layout title="Detail Progress Talent – Individual Development Plan" :user="$user" :hideSidebar="true">
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

            .modal-title { font-size: 1.25rem; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
            .modal-subtitle { font-size: 1rem; font-weight: 700; color: #475569; margin-bottom: 24px; }

            .alert-info-modal {
                background: #f0fdfa;
                border: 1px solid #5eead4;
                border-radius: 8px;
                padding: 12px;
                display: flex;
                gap: 12px;
                margin-bottom: 24px;
            }
            .alert-info-modal span { font-size: 0.75rem; color: #0d9488; line-height: 1.4; }

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
                width: 20px; height: 20px; border-radius: 4px; border: 2px solid #cbd5e1;
                cursor: pointer; accent-color: #2e3746;
            }
            .gap-name-modal { flex: 1; font-weight: 700; color: #334155; font-size: 0.875rem; }
            .gap-score-modal { font-size: 0.75rem; color: #94a3b8; font-weight: 600; }
            .gap-value-badge {
                padding: 4px 8px; background: #f8fafc; border-radius: 6px;
                font-size: 0.75rem; font-weight: 800; color: #1e293b; min-width: 32px; text-align: center;
            }

            /* Priority Colors */
            .gap-select-item.priority-1 { border-color: #ef4444; border-width: 2px; }
            .gap-select-item.priority-1 input { accent-color: #ef4444; }
            .gap-select-item.priority-2 { border-color: #f97316; border-width: 2px; }
            .gap-select-item.priority-2 input { accent-color: #f97316; }
            .gap-select-item.priority-3 { border-color: #3b82f6; border-width: 2px; }
            .gap-select-item.priority-3 input { accent-color: #3b82f6; }

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
                color: #2e3746;
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
            .textarea-label { font-size: 0.75rem; font-weight: 800; color: #1e293b; margin-bottom: 8px; display: block; text-transform: uppercase; }
            .modal-textarea {
                width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px; font-size: 0.8125rem;
                min-height: 100px; resize: none; margin-bottom: 24px; color: #475569;
            }
            .modal-textarea::placeholder { color: #cbd5e1; }

            .modal-footer { display: flex; gap: 12px; justify-content: flex-end; }
            .btn-modal { padding: 10px 24px; border-radius: 10px; font-size: 0.875rem; font-weight: 700; transition: all 0.2s; }
            .btn-reset-auto { background: #f3f4f6; color: #4b5563; }
            .btn-cancel { background: #fef3c7; color: #92400e; }
            .btn-save { background: #22c55e; color: white; flex: 1; }
            .btn-save:hover { background: #16a34a; }

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

            .nav-tabs {
                display: flex;
                gap: 12px;
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
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                cursor: pointer;
                transition: all 0.2s;
            }
            .tab-item:hover { background: #f1f5f9; }
            .tab-item.active {
                background: #f1f5f9;
                border-color: #94a3b8;
                color: #1e293b;
            }

            .section-title {
                display: flex;
                align-items: center;
                gap: 12px;
                font-size: 1.25rem;
                font-weight: 800;
                color: #1e293b;
                margin-top: 40px;
                margin-bottom: 24px;
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
            .btn-reject { border: 1.5px solid #ef4444; color: #ef4444; background: white; }
            .btn-approve { border: 1.5px solid #22c55e; color: #22c55e; background: white; }
            .btn-reject:hover { background: #ef4444; color: white; }
            .btn-approve:hover { background: #22c55e; color: white; }

            .btn-audit {
                background: #2e3746;
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
            .btn-pilih-aksi:hover { background: #d97706; }
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
            .status-modal-desc strong { color: #1e293b; }
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
            .btn-status-reject:hover { background: #dc2626; }
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
            .btn-status-approve:hover { background: #16a34a; }
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
            .btn-status-batal:hover { background: #e2e8f0; }

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
            .pill:hover { background: #cbd5e1; color: #1e293b; }
            .pill.active {
                background: #2e3746;
                color: white;
                box-shadow: 0 2px 12px rgba(46,55,70,0.22);
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
                background: #2e3746;
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
            .gap-item.prio-1 { border: 1.5px solid #b91c1c; color: #991b1b; background: #fef2f2; }
            .gap-item.prio-2 { border: 1.5px solid #c2410c; color: #9a3412; background: #fff7ed; }
            .gap-item.prio-3 { border: 1.5px solid #1d4ed8; color: #1e40af; background: #eff6ff; }
            .gap-number {
                width: 24px; height: 24px; border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                color: white; font-size: 0.75rem; margin-right: 12px;
                font-weight: 800;
            }
            .gap-item.prio-1 .gap-number { background: #b91c1c; }
            .gap-item.prio-2 .gap-number { background: #c2410c; }
            .gap-item.prio-3 .gap-number { background: #1d4ed8; }

            .heatmap-container {
                background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;
            }
            .heatmap-table { width: 100%; border-collapse: collapse; font-size: 0.8125rem; }
            .heatmap-table th, .heatmap-table td { border: 1px solid #e2e8f0; padding: 8px 12px; text-align: center; }
            .heatmap-table .th-main { background: #f8fafc; font-weight: 700; color: #1e293b; }
            .heatmap-table .th-sub { font-size: 0.65rem; font-weight: 700; color: #475569; text-transform: uppercase; background: #f8fafc; }
            .heatmap-table .td-left { text-align: left; font-weight: 600; color: #334155; }
            .gap-badge { display: block; width: 100%; height: 100%; padding: 4px; border-radius: 4px; font-weight: 700; color: white; }
            .gap-none { background-color: #f1f5f9; color: #64748b; }
            .gap-ok { background-color: #cbd5e1; color: #1e293b; }
            .gap-small { background-color: #f97316; color: white; }
            .gap-large { background-color: #ef4444; color: white; }
            .legend { display: flex; gap: 16px; font-size: 0.65rem; font-weight: 700; color: #64748b; margin-bottom: 12px; text-transform: uppercase; }
            .legend-item { display: flex; align-items: center; gap: 4px; }
            .legend-box { width: 12px; height: 12px; border-radius: 2px; }


            .mobile-nav-select { display: none; width: 100%; margin-top: 12px; }

            /* --- Responsive --- */
            @media (max-width: 768px) {
                .nav-tabs {
                    display: none;
                }
                .mobile-nav-select {
                    display: block;
                }
                .tab-item {
                    padding: 6px 12px;
                    font-size: 0.75rem;
                    white-space: nowrap;
                    flex-shrink: 0;
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
                .flex.justify-between.items-center.mb-10 {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 16px;
                }
                .btn-back {
                    align-self: flex-start;
                }
            }
        </style>
    </x-slot>

    {{-- Modal pilih GAP --}}
    <div id="gap-modal" class="modal-overlay" onclick="closeModalOnOutside(event)">
        <div class="modal-content">
            <h3 class="modal-title">Pilih 3 GAP Prioritas IDP</h3>
            <p id="modal-talent-name" class="modal-subtitle">Nama Talent</p>

            <div class="alert-info-modal">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Sistem menampilkan Top 3 GAP terbesar otomatis. PDC dapat mengubah sesuai konteks strategis.</span>
            </div>

            <div id="modal-gap-list" class="gap-selection-list">
                <!-- Will be populated by JS -->
            </div>

            <label class="textarea-label">Alasan Mengesampingkan</label>
            <textarea class="modal-textarea" placeholder="cth: Leadership diprioritaskan karena kandidat akan acting sebagai PIC proyek..."></textarea>

            <div class="modal-footer">
                <button class="btn-modal btn-reset-auto flex items-center gap-2" onclick="resetGapToAuto()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset Auto
                </button>
                <button class="btn-modal btn-cancel" onclick="closeGapModal()">Batal</button>
                <button class="btn-modal btn-save" id="btn-save-gap" onclick="saveTopGaps(this)">Simpan</button>
            </div>
        </div>
    </div>

    {{-- Header Navigation --}}
    <div class="flex justify-between items-center mb-10">
        <a href="{{ route('pdc_admin.progress_talent') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
            </svg>
            <span class="text-[#2e3746]">Kembali</span>
        </a>

        <div class="nav-tabs">
            <div class="tab-item active" onclick="switchSection('kompetensi', this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Kompetensi
            </div>
            <div class="tab-item" onclick="switchSection('idp', this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                    <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                </svg>
                IDP
            </div>
            <div class="tab-item" onclick="switchSection('project', this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                </svg>
                Project Improvement
            </div>
            <div class="tab-item" onclick="switchSection('logbook', this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                </svg>
                Logbook
            </div>
        </div>

        <div class="mobile-nav-select relative">
            <select onchange="handleNavSelect(this)" id="mobile-nav-dropdown" class="w-full bg-slate-50 border border-slate-300 text-slate-800 text-[15px] rounded-xl py-3.5 pl-4 pr-10 font-bold shadow-[0_2px_4px_rgba(0,0,0,0.03)] focus:outline-none focus:ring-2 focus:ring-[#2e3746] focus:bg-white appearance-none cursor-pointer transition-all">
                <option value="kompetensi">Kompetensi</option>
                <option value="idp">IDP</option>
                <option value="project">Project Improvement</option>
                <option value="logbook">Logbook</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                <svg class="h-6 w-6 text-[#475569]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Main Header --}}
    <div class="text-center mb-12">
        <h2 class="text-2xl font-extrabold text-[#1e293b]">{{ $targetPosition->position_name }} - {{ $company->nama_company }}</h2>
        <p class="text-xs font-bold text-gray-400 mt-1 uppercase">{{ $talents->count() }} TALENT</p>
    </div>

    {{-- ================================= SECTION: KOMPETENSI ================================= --}}
    <div id="section-kompetensi">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z" clip-rule="evenodd" />
            </svg>
            TOP 3 GAP Kompetensi
        </div>

    <div class="talent-gap-grid">
        @foreach ($talents as $talent)
            @php
                $details = optional($talent->assessmentSession)->details;
                $gaps = collect();
                if ($details) {
                    $overrides = $details->filter(function($d) {
                        return str_starts_with($d->notes ?? '', 'priority_');
                    })->sortBy(function($d) {
                        return (int) explode('|', str_replace('priority_', '', $d->notes))[0];
                    });
                    if ($overrides->count() > 0) {
                        $gaps = $overrides->values();
                    } else {
                        $gaps = $details->sortBy('gap_score')->take(3)->values();
                    }
                }
            @endphp
                <div class="talent-card">
                    <div class="talent-header">
                        <div class="talent-info">
                            <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" class="talent-photo" alt="{{ $talent->nama }}">
                            <div class="talent-meta">
                                <h4>{{ $talent->nama }}</h4>
                                <p>{{ optional($talent->position)->position_name ?? 'Officer' }} - {{ optional($talent->department)->nama_department ?? '-' }}</p>
                            </div>
                        </div>
                        <button class="btn-pilih-gap"
                            data-talent-name="{{ $talent->nama }}"
                            data-idx="{{ $loop->index }}"
                            onclick="openGapModal(this.dataset.talentName, allTalentGaps[this.dataset.idx])">Pilih 3 GAP</button>
                    </div>

                    <div class="mb-4 text-xs font-bold text-gray-500">
                        <p>MENTOR : 
                            @php
                                $mIds = optional($talent->promotion_plan)->mentor_ids ?? [];
                                if (!empty($mIds)) {
                                    $mNames = \App\Models\User::whereIn('id', $mIds)->pluck('nama')->toArray();
                                    echo strtoupper(implode(', ', $mNames)) ?: '-';
                                } else {
                                    echo strtoupper($talent->mentor->nama ?? '-');
                                }
                            @endphp
                        </p>
                        <p>ATASAN : {{ strtoupper($talent->atasan->nama ?? '-') }}</p>
                    </div>

                    <span class="top-gap-label">TOP 3 GAP</span>
                    @forelse($gaps as $index => $gap)
                        <div class="gap-item prio-{{ $index + 1 }}">
                            <div class="flex items-center">
                                <span class="gap-number">{{ $index + 1 }}</span>
                                {{ $gap->competence->name }}
                            </div>
                            <span>{{ number_format($gap->gap_score, 1) }}</span>
                        </div>
                    @empty
                        @for ($i = 1; $i <= 3; $i++)
                            <div class="gap-item" style="border: 1px solid #e2e8f0; background: #f8fafc; color: #94a3b8;">
                                <div class="flex items-center">
                                    <span class="gap-number" style="background: #cbd5e1;">{{ $i }}</span>
                                    -
                                </div>
                                <span>0</span>
                            </div>
                        @endfor
                    @endforelse
                </div>
            @endforeach
        </div>

        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.546 3.75 3.75 0 0 1 3.255 3.718Z" clip-rule="evenodd" />
            </svg>
            Heatmap Kompetensi
        </div>

        <div class="legend">
            <span>Keterangan GAP</span>
            <div class="legend-item"><div class="legend-box" style="background: #f1f5f9; border: 1px solid #e2e8f0;"></div> Sesuai Standar (0)</div>
            <div class="legend-item"><div class="legend-box" style="background: #f97316;"></div> Gap Kecil (-0.1 s/d -1.5)</div>
            <div class="legend-item"><div class="legend-box" style="background: #ef4444;"></div> Gap Besar (< -1.5)</div>
        </div>

        <div class="heatmap-container overflow-x-auto">
            <table class="heatmap-table">
                <thead>
                    <tr>
                        <th rowspan="2" class="th-main w-[250px]">KOMPETENSI</th>
                        <th rowspan="2" class="th-main w-[80px]">STANDAR</th>
                        @foreach ($talents as $talent)
                            <th colspan="4" class="th-main">{{ strtoupper($talent->nama) }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($talents as $talent)
                            <th class="th-sub">Skor Talent</th>
                            <th class="th-sub">Skor Atasan</th>
                            <th class="th-sub">Final Score</th>
                            <th class="th-sub">GAP</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($competencies as $comp)
                        @php $standard = $standards[$comp->id] ?? 0; @endphp
                        <tr>
                            <td class="td-left">{{ $comp->name }}</td>
                            <td>{{ $standard }}</td>
                            @foreach ($talents as $talent)
                                @php
                                    $detail = $talent->assessmentSession ? $talent->assessmentSession->details->firstWhere('competence_id', $comp->id) : null;
                                    $scoreTalent = $detail->score_talent ?? 0;
                                    $scoreAtasan = $detail->score_atasan ?? 0;
                                    $gap = $detail->gap_score ?? 0;
                                    $finalScore = ($scoreTalent + $scoreAtasan) / 2;
                                    $cls = 'gap-ok';
                                    if ($gap == 0) $cls = 'gap-none';
                                    elseif ($gap < -1.5) $cls = 'gap-large';
                                    elseif ($gap < 0) $cls = 'gap-small';
                                @endphp
                                <td>{{ $scoreTalent ?: '-' }}</td>
                                <td>{{ $scoreAtasan ?: '-' }}</td>
                                <td>{{ $finalScore ?: '-' }}</td>
                                <td class="p-1"><span class="gap-badge {{ $cls }}">{{ $gap == 0 ? '0' : number_format($gap, 1) }}</span></td>
                            @endforeach
                        </tr>
                    @endforeach
                    {{-- Nilai Rata-rata --}}
                    <tr class="font-bold bg-gray-50">
                        <td class="td-left">Nilai Rata-Rata</td>
                        <td>{{ number_format($standards->avg() ?: 0, 1) }}</td>
                        @foreach ($talents as $talent)
                            @php
                                $avgSelf = optional(optional($talent->assessmentSession)->details)->avg('score_talent') ?: 0;
                                $avgAtasan = optional(optional($talent->assessmentSession)->details)->avg('score_atasan') ?: 0;
                                $avgGap = optional(optional($talent->assessmentSession)->details)->avg('gap_score') ?: 0;
                            @endphp
                            <td>{{ number_format($avgSelf, 1) }}</td>
                            <td>{{ number_format($avgAtasan, 1) }}</td>
                            <td>{{ number_format(($avgSelf + $avgAtasan) / 2, 1) }}</td>
                            <td class="p-1">
                                @php
                                    $cls = 'gap-ok';
                                    if ($avgGap == 0) $cls = 'gap-none';
                                    elseif ($avgGap < -1.5) $cls = 'gap-large';
                                    elseif ($avgGap < 0) $cls = 'gap-small';
                                @endphp
                                <span class="gap-badge {{ $cls }}">{{ number_format($avgGap, 1) }}</span>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================================= SECTION: IDP ================================= --}}
    <div id="section-idp" class="hidden">
        {{-- SECTION TITLE --}}
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
            </svg>
            IDP Monitoring
        </div>
        @foreach ($talents as $talent)
            <div class="idp-card-container">
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" class="w-14 h-14 rounded-full" alt="">
                    <div>
                        <h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                        <p class="text-xs text-gray-400 italic">{{ optional($talent->position)->position_name }} - {{ optional($talent->department)->nama_department }}</p>
                    </div>
                </div>

                <div class="donut-container">
                    @php
                        $exposureCount = $talent->idpActivities->where('type_idp', 1)->count();
                        $mentoringCount = $talent->idpActivities->where('type_idp', 2)->count();
                        $learningCount = $talent->idpActivities->where('type_idp', 3)->count();
                        
                        $charts = [
                            ['label' => 'Exposure', 'done' => min($exposureCount, 6), 'total' => 6, 'color' => '#334155'],
                            ['label' => 'Mentoring', 'done' => min($mentoringCount, 6), 'total' => 6, 'color' => '#f59e0b'],
                            ['label' => 'Learning', 'done' => min($learningCount, 6), 'total' => 6, 'color' => '#0d9488']
                        ];
                        $r = 38; $circ = 2 * M_PI * $r;
                    @endphp

                    @foreach($charts as $chart)
                        @php $pct = $chart['done'] / $chart['total']; $filled = $pct * $circ; $empty = $circ - $filled; @endphp
                        <div class="flex flex-col items-center gap-3">
                            <div class="relative w-48 h-48 drop-shadow-sm">
                                <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="#f1f5f9" stroke-width="10" />
                                    <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="{{ $chart['color'] }}" stroke-width="10" stroke-linecap="round" stroke-dasharray="{{ number_format($filled, 2) }} {{ number_format($empty, 2) }}" style="transition: stroke-dasharray 0.8s ease;" />
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span class="text-3xl font-extrabold" style="color: #1e293b">{{ $chart['done'] }}/{{ $chart['total'] }}</span>
                                    <span class="text-sm font-bold text-gray-400 mt-[-4px]">{{ round($pct * 100) }}%</span>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 px-5 py-1.5 rounded-[10px] shadow-sm">
                                <span class="text-sm font-bold text-gray-800">{{ $chart['label'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modal Update Status Project Improvement --}}
    <div id="update-status-modal" class="modal-overlay" onclick="closeStatusModalOnOutside(event)">
        <div class="modal-content" style="max-width:480px; padding: 40px 36px 32px;" onclick="event.stopPropagation()">
            <div class="status-modal-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="status-modal-title">Update Status?</h3>
            <p class="status-modal-desc">Pilih status untuk Project Improvemen <strong id="status-modal-talent-name">-</strong>.<br>Tindakan ini akan langsung memperbarui sistem pada Talent</p>
            <div class="status-modal-actions">
                <button class="btn-status-reject" onclick="submitProjectStatus('Rejected')">Reject</button>
                <button class="btn-status-approve" onclick="submitProjectStatus('Verified')">Approve</button>
            </div>
            <button class="btn-status-batal" onclick="closeUpdateStatusModal()">Batal</button>
            <form id="update-status-form" method="POST" style="display:none;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" id="status-input-value">
            </form>
        </div>
    </div>

    {{-- ================================= SECTION: PROJECT IMPROVEMENT ================================= --}}
    <div id="section-project" class="hidden">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
            </svg>
            Project Improvement
        </div>

        @foreach ($talents as $talent)
            <div class="bg-white border text-center border-gray-200 rounded-2xl p-6 mb-20 shadow-sm">
                <div class="flex justify-between items-center mb-16">
                    <div class="flex items-center gap-4 text-left">
                        <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" class="w-14 h-14 rounded-full" alt="">
                        <div>
                            <h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                            <p class="text-xs text-gray-400 italic">{{ optional($talent->position)->position_name }} - {{ optional($talent->department)->nama_department }}</p>
                        </div>
                    </div>
                    @php
                        $latestProject = $talent->improvementProjects->first();
                        $projId = $latestProject ? $latestProject->id : 'null';
                        $projTitle = $latestProject ? addslashes($latestProject->title) : '';
                        $projFileUrl = $latestProject ? asset('storage/' . $latestProject->document_path) : '';
                        $isSentToFinance = $latestProject && !empty($latestProject->feedback);
                        $projStatus = $latestProject ? $latestProject->status : null;
                        $alreadyActed = in_array($projStatus, ['Verified', 'Rejected']);
                    @endphp
                    <div class="flex items-center gap-3">
                        @if($isSentToFinance)
                            <button class="btn-audit opacity-50 cursor-not-allowed" disabled>Validasi Finance</button>
                        @else
                            <button class="btn-audit" onclick="openFinanceModal('{{ $talent->nama }}', '{{ optional($talent->department)->nama_department }}', '{{ optional($talent->promotion_plan->targetPosition)->position_name }}', '{{ optional($talent->company)->nama_company }}', {{ $projId }}, '{{ $projTitle }}', '{{ $projFileUrl }}')">Validasi Finance</button>
                        @endif
                        @if($alreadyActed)
                            <button class="btn-sudah-dipilih" disabled>Sudah Dipilih</button>
                        @else
                            <button class="btn-pilih-aksi" onclick="openUpdateStatusModal('{{ $talent->nama }}', {{ $projId }})">Pilih Aksi</button>
                        @endif
                    </div>
                </div>

                <table class="pdc-custom-table">
                    <thead>
                        <tr>
                            <th class="w-1/2">Judul Project Improvement</th>
                            <th>File</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($talent->improvementProjects as $proj)
                            <tr>
                                <td class="font-bold">{{ $proj->title }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $proj->document_path) }}" class="text-blue-500 underline uppercase font-bold text-xs" target="_blank">Lihat File</a>
                                </td>
                                <td>
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="w-2 h-2 rounded-full {{ $proj->status === 'Verified' ? 'bg-green-500' : 'bg-orange-500' }}"></div>
                                        <span class="font-bold">{{ $proj->status === 'Verified' ? 'Approve' : ($proj->status ?: 'Pending') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-gray-400 py-8">Belum ada project improvement yang diunggah.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>

    {{-- ================================= SECTION: LOGBOOK ================================= --}}
    <div id="section-logbook" class="hidden">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
            </svg>
            LogBook
        </div>

        <div class="filter-pills">
            <div class="pill active" onclick="filterLog(1, this)">Exposure</div>
            <div class="pill" onclick="filterLog(2, this)">Mentoring</div>
            <div class="pill" onclick="filterLog(3, this)">Learning</div>
        </div>

        @foreach ($talents as $talent)
            <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-20 shadow-sm">
                <div class="flex items-center gap-4 mb-16">
                    <img src="{{ $talent->foto ? asset('storage/' . $talent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($talent->nama) . '&background=random' }}" class="w-14 h-14 rounded-full" alt="">
                    <div>
                        <h4 class="text-lg font-extrabold text-[#1e293b]">{{ $talent->nama }}</h4>
                        <p class="text-xs text-gray-400 italic">{{ optional($talent->position)->position_name }} - {{ optional($talent->department)->nama_department }}</p>
                    </div>
                </div>

                {{-- Logbook Content Area --}}
                <div class="logbook-content-wrapper" data-talent-id="{{ $talent->id }}">
                    
                    {{-- EXPOSURE TABLE --}}
                    <div class="log-table-type exposure-table" data-type="1">
                        <div class="log-table-container custom-scrollbar overflow-x-auto">
                            <table class="pdc-log-table w-full">
                                <thead>
                                    <tr>
                                        <th>Mentor</th>
                                        <th>Tema</th>
                                        <th>Tanggal Pengiriman/Update</th>
                                        <th>Tanggal Pelaksanaan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $expActivities = $talent->idpActivities->where('type_idp', 1); @endphp
                                    @forelse($expActivities as $act)
                                        <tr>
                                            <td class="text-center font-medium">{{ $act->verifier->nama ?? '-' }}</td>
                                            <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($act->theme, 35) }}</td>
                                            <td class="text-center whitespace-nowrap">{{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->format('d F Y') : '-' }}</td>
                                            <td class="text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</td>
                                            <td class="text-center whitespace-nowrap w-32">
                                                @if(in_array($act->status, ['Approve', 'Approved']))
                                                    <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $act->status ?: 'Pending' }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('pdc_admin.logbook.detail', $act->id) }}" class="flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100" title="Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg> 
                                                        Detail
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="py-12 px-6 text-gray-400">Belum ada aktivitas Exposure yang dicatat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- MENTORING TABLE --}}
                    <div class="log-table-type mentoring-table hidden" data-type="2">
                        <div class="log-table-container custom-scrollbar overflow-x-auto">
                            <table class="pdc-log-table w-full">
                                <thead>
                                    <tr>
                                        <th>Mentor</th>
                                        <th>Tema</th>
                                        <th>Tanggal Pengiriman</th>
                                        <th>Tanggal Pelaksanaan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $menActivities = $talent->idpActivities->where('type_idp', 2); @endphp
                                    @forelse($menActivities as $act)
                                        <tr>
                                            <td class="text-center font-medium">{{ $act->verifier->nama ?? '-' }}</td>
                                            <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($act->theme, 35) }}</td>
                                            <td class="text-center whitespace-nowrap">{{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->format('d F Y') : '-' }}</td>
                                            <td class="text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</td>
                                            <td class="text-center whitespace-nowrap w-32">
                                                @if(in_array($act->status, ['Approve', 'Approved']))
                                                    <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $act->status ?: 'Pending' }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('pdc_admin.logbook.detail', $act->id) }}" class="flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100" title="Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg> 
                                                        Detail
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="py-12 px-6 text-gray-400">Belum ada aktivitas Mentoring yang dicatat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- LEARNING TABLE --}}
                    <div class="log-table-type learning-table hidden" data-type="3">
                        <div class="log-table-container custom-scrollbar overflow-x-auto">
                            <table class="pdc-log-table w-full">
                                <thead>
                                    <tr>
                                        <th>Sumber</th>
                                        <th>Tema</th>
                                        <th>Tanggal Pengiriman</th>
                                        <th>Tanggal Pelaksanaan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $leaActivities = $talent->idpActivities->where('type_idp', 3); @endphp
                                    @forelse($leaActivities as $act)
                                        <tr>
                                            <td class="text-center font-medium">{{ $act->activity }}</td>
                                            <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($act->theme, 35) }}</td>
                                            <td class="text-center whitespace-nowrap">{{ $act->updated_at ? \Carbon\Carbon::parse($act->updated_at)->format('d F Y') : '-' }}</td>
                                            <td class="text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($act->activity_date)->format('d F Y') }}</td>
                                            <td class="text-center whitespace-nowrap w-32">
                                                <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Verified
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('pdc_admin.logbook.detail', $act->id) }}" class="flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100" title="Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg> 
                                                        Detail
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="py-12 px-6 text-gray-400">Belum ada aktivitas Learning yang dicatat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    @php
        $allTalentGapsData = $talents->map(function($talent) use ($standards) {
            // Always return a proper object even if no assessment
            if (!$talent->assessmentSession) {
                return [
                    'talent_id' => $talent->id,
                    'reason' => '',
                    'gaps' => []
                ];
            }

            $details = $talent->assessmentSession->details;
            $overrides = $details->filter(function($d) {
                return str_starts_with($d->notes ?? '', 'priority_');
            })->sortBy(function($d) {
                return (int) explode('|', str_replace('priority_', '', $d->notes))[0];
            });

            $reasonOverride = '';
            $selectedIds = [];
            
            if ($overrides->count() > 0) {
                $parts = explode('|', $overrides->first()->notes, 2);
                $reasonOverride = $parts[1] ?? '';
                $selectedIds = $overrides->pluck('competence_id')->toArray();
            } else {
                $selectedIds = $details->sortBy('gap_score')->take(3)->pluck('competence_id')->toArray();
            }

            return [
                'talent_id' => $talent->id,
                'reason' => $reasonOverride,
                'gaps' => $details->map(function($d) use ($standards, $selectedIds) {
                    $pIndex = array_search($d->competence_id, $selectedIds);
                    return [
                        'id'       => $d->competence_id,
                        'name'     => $d->competence->name,
                        'score'    => ($d->score_talent + $d->score_atasan) / 2,
                        'standard' => $standards[$d->competence_id] ?? 0,
                        'gap'      => (float)$d->gap_score,
                        'selected' => $pIndex !== false,
                        'priority' => $pIndex !== false ? $pIndex + 1 : 999
                    ];
                })->sortBy('gap')->values()->toArray()
            ];
        })->values()->toArray();
    @endphp

    <script>
        const allTalentGaps = {!! json_encode($allTalentGapsData) !!};
        let currentTalentEditId = null;
        const csrfToken = '{{ csrf_token() }}';

        function openGapModal(talentName, talentData) {
            // Guard: jika talentData null/kosong/bukan object, tampilkan pesan
            if (!talentData || Array.isArray(talentData) || !talentData.talent_id) {
                alert('Data kompetensi talent ini belum tersedia. Pastikan talent sudah mengisi penilaian kompetensi.');
                return;
            }

            currentTalentEditId = talentData.talent_id;
            document.getElementById('modal-talent-name').textContent = talentName;
            
            const textarea = document.querySelector('.modal-textarea');
            textarea.value = talentData.reason || '';

            const listContainer = document.getElementById('modal-gap-list');
            listContainer.innerHTML = '';

            if (!talentData.gaps || talentData.gaps.length === 0) {
                listContainer.innerHTML = '<p style="color:#94a3b8;font-size:0.875rem;text-align:center;padding:24px">Belum ada data gap untuk talent ini.</p>';
                document.getElementById('gap-modal').classList.add('active');
                return;
            }

            const mappedGaps = [...talentData.gaps];

            // Sort: selected first by priority, then unselected by gap ascending
            mappedGaps.sort((a, b) => {
                if (a.selected && !b.selected) return -1;
                if (!a.selected && b.selected) return 1;
                if (a.selected && b.selected) return a.priority - b.priority;
                return a.gap - b.gap;
            });

            mappedGaps.forEach((g) => {
                const item = document.createElement('div');
                item.className = 'gap-select-item gap-select-item-card';
                item.dataset.id = g.id;
                item.onclick = function() { toggleCheck(this); };

                const scoreDisplay = (typeof g.score === 'number') ? (g.score % 1 === 0 ? g.score : g.score.toFixed(1)) : g.score;
                const gapDisplay = (typeof g.gap === 'number') ? (g.gap == 0 ? '0' : g.gap.toFixed(1)) : g.gap;

                item.innerHTML = `
                    <input type="checkbox" ${g.selected ? 'checked' : ''} onclick="event.stopPropagation(); updatePriorityStyles();">
                    <div class="gap-name-modal">${g.name}</div>
                    <div class="gap-score-modal">${scoreDisplay}/${g.standard}</div>
                    <div class="gap-value-badge">${gapDisplay}</div>
                `;
                listContainer.appendChild(item);
            });

            document.getElementById('gap-modal').classList.add('active');
            updatePriorityStyles();
        }

        function toggleCheck(item) {
            const checkbox = item.querySelector('input');
            const checkedCount = document.querySelectorAll('#modal-gap-list input:checked').length;
            
            if (!checkbox.checked && checkedCount >= 3) {
                return; // Limit to 3
            }
            
            checkbox.checked = !checkbox.checked;
            updatePriorityStyles();
        }

        function updatePriorityStyles() {
            const items = document.querySelectorAll('.gap-select-item-card');
            let checkedIdx = 0;
            items.forEach(item => {
                const cb = item.querySelector('input');
                item.classList.remove('priority-1', 'priority-2', 'priority-3');
                if (cb.checked) {
                    checkedIdx++;
                    if (checkedIdx <= 3) {
                        item.classList.add('priority-' + checkedIdx);
                    }
                }
            });
        }

        function closeGapModal() {
            document.getElementById('gap-modal').classList.remove('active');
            currentTalentEditId = null;
        }

        async function saveTopGaps(btn) {
            if (!currentTalentEditId) return;
            
            const checkedItems = document.querySelectorAll('.gap-select-item-card input:checked');
            if (checkedItems.length !== 3) {
                alert('Tolong pilih tepat 3 prioritas GAP.');
                return;
            }

            const reason = document.querySelector('.modal-textarea').value.trim();
            const competenceIds = Array.from(checkedItems).map(cb => parseInt(cb.closest('.gap-select-item-card').dataset.id));

            btn.textContent = 'Menyimpan...';
            btn.disabled = true;

            try {
                const response = await fetch('/pdc-admin/top-gaps/' + currentTalentEditId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        competence_ids: competenceIds,
                        reason: reason
                    })
                });
                
                const result = await response.json();
                if (result.success) {
                    window.location.reload();
                } else {
                    alert('Gagal menyimpan Top 3 GAP: ' + (result.message || 'Unknown error'));
                    btn.textContent = 'Simpan';
                    btn.disabled = false;
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan sistem.');
                btn.textContent = 'Simpan';
                btn.disabled = false;
            }
        }

        function resetGapToAuto() {
            const items = Array.from(document.querySelectorAll('.gap-select-item-card'));
            
            // Sort by gap value ascending (most negative first)
            items.sort((a, b) => {
                const gapA = parseFloat(a.querySelector('.gap-value-badge').textContent);
                const gapB = parseFloat(b.querySelector('.gap-value-badge').textContent);
                return gapA - gapB;
            });
            
            items.forEach((item, idx) => {
                item.querySelector('input').checked = (idx < 3);
            });
            document.querySelector('.modal-textarea').value = '';
            
            updatePriorityStyles();
        }

        function closeModalOnOutside(e) {
            if (e.target.id === 'gap-modal') closeGapModal();
        }

        function switchSection(targetId, el) {
            // Hide all sections
            document.getElementById('section-kompetensi').classList.add('hidden');
            document.getElementById('section-idp').classList.add('hidden');
            document.getElementById('section-project').classList.add('hidden');
            document.getElementById('section-logbook').classList.add('hidden');

            // Show target section
            document.getElementById('section-' + targetId).classList.remove('hidden');

            // Update active tab
            document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
            if (el) {
                el.classList.add('active');
            } else {
                let tab = Array.from(document.querySelectorAll('.tab-item')).find(t => t.getAttribute('onclick').includes("'" + targetId + "'"));
                if(tab) tab.classList.add('active');
            }

            // Sync dropdown
            const dropdown = document.getElementById('mobile-nav-dropdown');
            if (dropdown) dropdown.value = targetId;
        }

        function handleNavSelect(selectElement) {
            switchSection(selectElement.value, null);
        }

        function filterLog(typeId, el) {
            // Update active pill
            document.querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
            el.classList.add('active');

            // Find all tables for all talents
            document.querySelectorAll('.log-table-type').forEach(tableDiv => {
                if (tableDiv.getAttribute('data-type') == typeId) {
                    tableDiv.classList.remove('hidden');
                } else {
                    tableDiv.classList.add('hidden');
                }
            });
        }

        // --- FINANCE MODAL FUNCTIONS ---
        function openFinanceModal(talentName, deptName, posName, companyName, projId, projTitle, projFileUrl) {
            document.getElementById('fin-talent-name').textContent = talentName || '-';
            document.getElementById('fin-dept-name').textContent = deptName || '-';
            document.getElementById('fin-pos-name').textContent = posName || '-';
            document.getElementById('fin-company-name').textContent = companyName || '-';
            
            document.getElementById('finance-proj-id').value = projId;
            document.getElementById('finance-proj-title').value = projTitle;
            document.getElementById('finance-proj-file').href = projFileUrl;
            
            document.getElementById('finance-modal').classList.add('active');
        }

        function closeFinanceModal() {
            document.getElementById('finance-modal').classList.remove('active');
        }

        // Close on backdrop
        window.onclick = function(event) {
            const gapModal = document.getElementById('gap-modal');
            const financeModal = document.getElementById('finance-modal');
            const statusModal = document.getElementById('update-status-modal');
            if (event.target == gapModal) closeGapModal();
            if (event.target == financeModal) closeFinanceModal();
            if (event.target == statusModal) closeUpdateStatusModal();
        }

        // --- UPDATE STATUS MODAL FUNCTIONS ---
        let currentProjectId = null;

        function openUpdateStatusModal(talentName, projId) {
            if (!projId || projId === 'null') {
                alert('Talent ini belum memiliki project improvement.');
                return;
            }
            currentProjectId = projId;
            document.getElementById('status-modal-talent-name').textContent = talentName;
            document.getElementById('update-status-modal').classList.add('active');
        }

        function closeUpdateStatusModal() {
            document.getElementById('update-status-modal').classList.remove('active');
            currentProjectId = null;
        }

        function closeStatusModalOnOutside(event) {
            if (event.target.id === 'update-status-modal') closeUpdateStatusModal();
        }

        function submitProjectStatus(status) {
            if (!currentProjectId) return;
            const form = document.getElementById('update-status-form');
            form.action = '/pdc-admin/finance-validation/' + currentProjectId;
            document.getElementById('status-input-value').value = status;
            form.submit();
        }
    </script>

    {{-- ================================= MODAL: FINANCE VALIDATION ================================= --}}
    <div id="finance-modal" class="modal-overlay @if($errors->any()) active @endif">
        <div class="modal-content finance-modal-content" style="max-height: 95vh; overflow-y: auto;">
            <div class="finance-header">
                <div class="flex items-center gap-3">
                    <div class="bg-gray-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-[#1e293b]">Kirim Permintaan Validasi Finance</h3>
                </div>
                <button onclick="closeFinanceModal()" class="text-gray-400 hover:text-gray-600 p-2 border border-gray-100 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('pdc_admin.finance.request') }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" id="finance-proj-id">

                <div class="finance-body">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Ada input yang terlewat:</span>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="finance-alert">
                        <div class="bg-yellow-100 p-2 rounded-lg shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <p class="finance-alert-text">Sistem secara otomatis mengirim catatan kepada finance untuk segera direview. Harap isi pada catatan sesuai dengan kebutuhan Anda.</p>
                    </div>

                    <div class="finance-form-grid">
                        <div>
                            <label class="finance-field-label">Talent</label>
                            <div id="fin-talent-name" class="finance-readonly-box">Rudi Santiago</div>
                        </div>
                        <div>
                            <label class="finance-field-label">Perusahaan</label>
                            <div id="fin-company-name" class="finance-readonly-box">PT. Tiga Serangkai Pustaka Mandiri</div>
                        </div>
                        <div>
                            <label class="finance-field-label">Departemen</label>
                            <div id="fin-dept-name" class="finance-readonly-box">Human Resource</div>
                        </div>
                        <div>
                            <label class="finance-field-label">Posisi yang dituju</label>
                            <div id="fin-pos-name" class="finance-readonly-box">Manager</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div>
                            <label class="finance-field-label">Judul Project Improvement</label>
                            <input type="text" id="finance-proj-title" class="finance-input bg-gray-50 border-gray-200 text-gray-500 font-semibold cursor-not-allowed" readonly placeholder="Masukkan judul project...">
                        </div>
                        <div>
                            <label class="finance-field-label">Lampiran</label>
                            <div class="finance-input bg-gray-50 border-gray-200 flex items-center px-3 py-[9px]">
                                <a id="finance-proj-file" href="#" target="_blank" class="text-blue-600 hover:underline font-semibold flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z" clip-rule="evenodd" />
                                    </svg>
                                    Lihat File
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col h-full">
                            <label class="text-[#2e3746] font-extrabold text-sm md:text-base mb-3 tracking-wide uppercase">Catatan</label>
                            <textarea name="notes" required class="w-full rounded-xl border border-gray-300 px-4 py-3 text-[13px] text-gray-500 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 resize-none flex-grow min-h-[130px]" placeholder="cth: Pada slide ke 17 apakah sudah memenuhi standar kriteria untuk melakukan bisnis. . ."></textarea>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[#2e3746] font-extrabold text-sm md:text-base mb-3 tracking-wide uppercase">Kirim Kepada</label>
                            <div class="relative">
                                <select name="assigned_finance_id" required class="w-full appearance-none rounded-xl border border-gray-300 bg-white px-4 py-3 text-[13px] text-gray-500 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 pr-10">
                                    <option value="" disabled selected>Pilih email finance yang terdaftar</option>
                                    @foreach($financeUsers as $finUser)
                                        <option value="{{ $finUser->id }}" class="text-gray-700">{{ $finUser->email }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-teal-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="finance-footer">
                    <button type="button" onclick="closeFinanceModal()" class="btn-finance-cancel">Batal</button>
                    <button type="submit" class="btn-finance-submit" onclick="this.innerHTML='Mengirim...';">Kirim</button>
                </div>
            </form>
        </div>
    </div>


</x-pdc_admin.layout>
