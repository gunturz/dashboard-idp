<x-pdc_admin.layout title="Kompetensi – PDC Admin" :user="$user">
    <x-slot name="styles">
        <style>
            /* ── Top Tabs ── */
            .top-tabs {
                display: flex;
                background: #e8ecf0;
                border-radius: 9999px;
                padding: 5px;
                gap: 4px;
                margin-bottom: 16px;
            }

            .top-tab-btn {
                flex: 1;
                padding: 11px 24px;
                border-radius: 9999px;
                border: none;
                font-size: 0.9rem;
                font-weight: 600;
                cursor: pointer;
                transition: all .2s;
                color: #64748b;
                background: transparent;
            }

            .top-tab-btn.active {
                background: #0f172a;
                color: white;
                box-shadow: 0 2px 8px rgba(0,0,0,.18);
            }

            /* ── Sub Tabs ── */
            .sub-tabs {
                display: flex;
                background: #e8ecf0;
                border-radius: 9999px;
                padding: 5px;
                gap: 4px;
                margin-bottom: 24px;
            }

            .sub-tab-btn {
                flex: 1;
                padding: 11px 24px;
                border-radius: 9999px;
                border: none;
                background: transparent;
                font-size: 0.9rem;
                font-weight: 600;
                color: #64748b;
                cursor: pointer;
                transition: all .2s;
            }

            .sub-tab-btn.active {
                background: #0f172a;
                color: white;
                box-shadow: 0 2px 8px rgba(0,0,0,.18);
            }

            /* ── Competency Card ── */
            .comp-card {
                border: 1px solid #dbe4ee;
                border-radius: 20px;
                overflow: hidden;
                margin-bottom: 24px;
                background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
                box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
            }

            .comp-card-title {
                text-align: center;
                font-size: 1.55rem;
                font-weight: 800;
                color: #22324a;
                letter-spacing: -0.02em;
                padding: 22px 24px;
                background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
                border-bottom: 1px solid #e2e8f0;
            }

            .comp-table {
                width: 100%;
                border-collapse: collapse;
            }

            .comp-table thead tr {
                background: linear-gradient(180deg, #f8fbff 0%, #f1f5f9 100%);
            }

            .comp-table th {
                padding: 16px 22px;
                font-size: 0.92rem;
                font-weight: 800;
                color: #334155;
                letter-spacing: 0.01em;
                text-align: center;
                border-right: 1px solid #f1f5f9;
            }

            .comp-table th:first-child { width: 96px; }
            .comp-table th:last-child { border-right: none; }

            .comp-table td {
                padding: 18px 24px;
                font-size: 0.95rem;
                color: #64748b;
                vertical-align: top;
                border-top: 1px solid #f1f5f9;
                border-right: 1px solid #f1f5f9;
                line-height: 1.72;
                background: rgba(255, 255, 255, 0.82);
            }

            .comp-table td:first-child {
                text-align: center;
                font-weight: 800;
                font-size: 1.1rem;
                color: #23324b;
                vertical-align: middle;
                border-right: 1px solid #f1f5f9;
                background: #f8fbff;
            }
            .comp-table td:last-child { border-right: none; }

            .comp-table tbody tr:hover td { background: #f8fbff; }

            .question-text {
                font-size: 1.12rem;
                line-height: 1.8;
                color: #48627f;
                font-weight: 500;
            }

            .question-empty {
                font-size: 1rem;
                color: #94a3b8;
                font-style: italic;
            }

            .question-editor {
                width: 100%;
                min-height: 132px;
                padding: 18px 22px;
                border: none;
                outline: none;
                resize: vertical;
                font-family: inherit;
                font-size: 1.05rem;
                line-height: 1.75;
                color: #334155;
                background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
            }

            .question-editor::placeholder {
                color: #94a3b8;
            }

            /* Edit button */
            .btn-edit-comp {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 9px 20px;
                background: #0f172a;
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 0.82rem;
                font-weight: 700;
                cursor: pointer;
                transition: all .2s;
                box-shadow: 0 8px 18px rgba(15, 23, 42, 0.16);
            }
            .btn-edit-comp:hover { background: #1e2737; }

            .comp-card-footer {
                padding: 16px 22px;
                display: flex;
                justify-content: flex-end;
                background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
                border-top: 1px solid #f1f5f9;
            }

            /* Panel visibility */
            .tab-panel { display: none; }
            .tab-panel.active { display: block; }
            .pos-panel { display: none; }
            .pos-panel.active { display: block; }

            /* Target Score Position table */
            .ts-table {
                width: 100%;
                border-collapse: collapse;
            }
            .ts-table th {
                padding: 14px 10px;
                font-size: 0.85rem;
                font-weight: 700;
                color: #0f172a;
                text-align: center;
                background: #f8fafc;
                border-bottom: 2px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
            }
            .ts-table th:last-child { border-right: none; }
            
            .ts-table td {
                border-bottom: 1px solid #e2e8f0;
                border-right: 1px solid #e2e8f0;
                padding: 0;
                vertical-align: middle;
            }
            .ts-table td:last-child { border-right: none; }

            .ts-comp-name {
                padding: 16px 24px !important;
                font-weight: 500;
                color: #475569;
                text-align: left;
                width: 30%;
            }

            .ts-radio-label {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 100%;
                min-height: 56px;
                font-weight: 700;
                color: #0f172a;
                cursor: pointer;
                transition: background 0.2s, color 0.2s;
            }
            .ts-radio-label:hover { background: #f1f5f9; }
            input[type="radio"]:checked + .ts-radio-label {
                background: #14b8a6;
                color: white;
            }

            .btn-simpan-ts {
                background: #14b8a6;
                color: white;
                font-weight: 700;
                font-size: 0.8rem;
                border: none;
                border-radius: 6px;
                padding: 10px 0;
                width: 100%;
                cursor: pointer;
                transition: background 0.2s;
            }
            .btn-simpan-ts:hover { background: #0d9488; }

            .btn-batal-ts {
                background: #F4F1EA;
                color: #0f172a;
                font-weight: 700;
                font-size: 0.8rem;
                border: none;
                border-radius: 6px;
                padding: 10px 0;
                width: 100%;
                cursor: pointer;
                transition: background 0.2s;
            }
            .btn-batal-ts:hover { background: #eadecc; }

            .btn-edit-ts {
                background: #0f172a;
                color: white;
                font-weight: 700;
                font-size: 0.8rem;
                border: none;
                border-radius: 6px;
                padding: 10px 0;
                width: 100%;
                cursor: pointer;
                transition: background 0.2s;
            }
            .btn-edit-ts:hover { background: #1e2737; }

            .ts-table.view-mode .ts-radio-label {
                pointer-events: none;
                opacity: 0.8;
            }

            /* ── Responsive ── */
            @media (max-width: 768px) {
                .top-tabs, .sub-tabs {
                    flex-direction: column;
                    border-radius: 12px;
                }
                .top-tab-btn, .sub-tab-btn {
                    border-radius: 8px;
                    padding: 8px 16px;
                }
                .comp-table, .ts-table {
                    min-width: 900px;
                }
            }
        </style>
    </x-slot>

    {{-- Page Header --}}
    <div class="page-header animate-title mb-8">
        <div class="page-header-icon shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <div class="page-header-title">Kompetensi</div>
            <div class="page-header-sub">Kelola pertanyaan assessment dan atur Target Score posisi pekerjaan.</div>
        </div>
    </div>

    <livewire:pdc-admin-kompetensi-manager />

    </x-slot>

</x-pdc_admin.layout>
