<x-panelis.layout title="Review Panelis – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
            /* ── Review Card ── */
            .review-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                overflow: hidden;
                margin-bottom: 28px;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
                transition: box-shadow 0.2s;
            }
            .review-card:hover {
                box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            }

            /* ── Card Header ── */
            .review-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 20px 24px;
                border-bottom: 1px solid #f1f5f9;
                flex-wrap: wrap;
                gap: 12px;
                cursor: pointer;
            }

            .talent-header-info {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .talent-avatar {
                width: 52px;
                height: 52px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e2e8f0;
                flex-shrink: 0;
                box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            }

            .talent-avatar-placeholder {
                width: 52px;
                height: 52px;
                border-radius: 50%;
                background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 1.1rem;
                color: #0284c7;
                flex-shrink: 0;
                border: 2px solid #e2e8f0;
                box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            }

            .talent-meta .talent-name {
                font-weight: 700;
                font-size: 1rem;
                color: #1e293b;
                display: block;
            }
            .talent-meta .talent-detail {
                font-size: 0.78rem;
                color: #64748b;
                display: block;
                margin-top: 2px;
            }
            .talent-meta .talent-detail em {
                background: #fef3c7;
                color: #92400e;
                padding: 1px 8px;
                border-radius: 4px;
                font-style: normal;
                font-weight: 600;
                font-size: 0.72rem;
            }
            .talent-meta .talent-date {
                font-size: 0.72rem;
                color: #94a3b8;
                display: block;
                margin-top: 2px;
            }

            .badge-pending {
                display: inline-flex;
                align-items: center;
                padding: 5px 16px;
                border: 2px solid #fbbf24;
                border-radius: 20px;
                font-size: 0.78rem;
                font-weight: 700;
                color: #92400e;
                background: #fffbeb;
                white-space: nowrap;
            }

            .header-right {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .toggle-arrow {
                width: 28px;
                height: 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #14b8a6;
                transition: transform 0.3s ease;
            }
            .toggle-arrow.rotated {
                transform: rotate(180deg);
            }

            /* ── Card Body ── */
            .review-card-body {
                padding: 0 24px 24px 24px;
                display: none;
            }
            .review-card-body.open {
                display: block;
            }

            /* ── Assessment Table ── */
            .assessment-table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #d1d5db;
                border-radius: 12px;
                overflow: hidden;
                margin-top: 16px;
            }

            .assessment-table th {
                background: #f1f5f9;
                font-size: 0.8rem;
                font-weight: 700;
                color: #1e293b;
                padding: 12px 16px;
                text-align: left;
                border-bottom: 2px solid #cbd5e1;
                border-right: 1px solid #d1d5db;
            }
            .assessment-table th:last-child {
                border-right: none;
                text-align: center;
            }

            .assessment-table td {
                padding: 12px 16px;
                font-size: 0.88rem;
                color: #334155;
                border-bottom: 1px solid #d1d5db;
                border-right: 1px solid #e5e7eb;
                vertical-align: middle;
            }
            .assessment-table td:last-child {
                border-right: none;
                text-align: center;
            }

            .assessment-table tbody tr:last-child td {
                border-bottom: 1px solid #d1d5db;
            }

            .score-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 36px;
                border-radius: 8px;
                background: #14b8a6;
                color: white;
                font-weight: 700;
                font-size: 0.9rem;
                box-shadow: 0 2px 6px rgba(20, 184, 166, 0.3);
            }

            .score-badge.high {
                background: #0d9488;
            }
            .score-badge.medium {
                background: #14b8a6;
            }
            .score-badge.low {
                background: #f59e0b;
            }

            /* ── Comment Section ── */
            .comment-section {
                margin-top: 24px;
            }
            .comment-label {
                font-weight: 700;
                color: #1e293b;
                font-size: 0.9rem;
                margin-bottom: 10px;
            }
            .comment-textarea {
                width: 100%;
                border: 1.5px solid #e2e8f0;
                border-radius: 10px;
                padding: 14px 16px;
                font-size: 0.85rem;
                color: #334155;
                resize: vertical;
                min-height: 100px;
                outline: none;
                transition: border-color 0.2s;
            }
            .comment-textarea::placeholder {
                color: #94a3b8;
            }
            .comment-textarea:focus {
                border-color: #14b8a6;
                box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
            }

            /* ── Readiness Indicator ── */
            .readiness-section {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-top: 20px;
                padding: 12px 16px;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                background: #f8fafc;
            }
            .readiness-dot {
                width: 20px;
                height: 20px;
                border-radius: 4px;
                flex-shrink: 0;
            }
            .readiness-dot.green { background: #22c55e; }
            .readiness-dot.yellow { background: #f59e0b; }
            .readiness-dot.red { background: #ef4444; }
            .readiness-text {
                font-size: 0.85rem;
                color: #334155;
            }
            .readiness-text strong {
                font-weight: 700;
            }
            .readiness-text span {
                color: #64748b;
                font-size: 0.78rem;
            }

            /* ── Score Input ── */
            .score-section {
                display: flex;
                align-items: center;
                gap: 16px;
                margin-top: 20px;
            }
            .score-label {
                font-weight: 700;
                color: #1e293b;
                font-size: 0.9rem;
                white-space: nowrap;
            }
            .score-input {
                flex: 1;
                border: 1.5px solid #e2e8f0;
                border-radius: 10px;
                padding: 10px 16px;
                font-size: 0.85rem;
                color: #334155;
                outline: none;
                transition: border-color 0.2s;
            }
            .score-input::placeholder {
                color: #94a3b8;
            }
            .score-input:focus {
                border-color: #14b8a6;
                box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
            }

            /* ── Action Buttons ── */
            .action-buttons {
                display: flex;
                justify-content: center;
                gap: 16px;
                margin-top: 24px;
                flex-wrap: wrap;
            }
            .btn-preview {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 10px 32px;
                border: 2px solid #e2e8f0;
                border-radius: 10px;
                background: white;
                color: #334155;
                font-size: 0.85rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
            }
            .btn-preview:hover {
                border-color: #14b8a6;
                color: #0d9488;
                background: #f0fdfa;
            }
            .btn-edit {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 10px 32px;
                border: none;
                border-radius: 10px;
                background: #94a3b8;
                color: white;
                font-size: 0.85rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
            }
            .btn-edit:hover {
                background: #64748b;
            }
            .btn-penilaian {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 10px 32px;
                border: none;
                border-radius: 10px;
                background: #343E4E;
                color: white;
                font-size: 0.85rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
            }
            .btn-penilaian:hover {
                background: #1e293b;
            }

            .empty-review-text {
                color: #14b8a6;
                text-align: center;
                font-size: 0.85rem;
                font-weight: 500;
                padding: 16px 0;
            }

            /* ── Responsive ── */
            @media (max-width: 768px) {
                .review-card-header {
                    padding: 16px;
                }
                .review-card-body {
                    padding: 0 16px 16px 16px;
                }
                .talent-avatar, .talent-avatar-placeholder {
                    width: 42px;
                    height: 42px;
                }
                .action-buttons {
                    flex-direction: column;
                }
                .btn-preview, .btn-edit, .btn-penilaian {
                    width: 100%;
                    justify-content: center;
                }
                .score-section {
                    flex-direction: column;
                    align-items: flex-start;
                }
            }
        </style>
    </x-slot>

    {{-- Page Title --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <h2 class="text-2xl font-extrabold text-[#0f172a] animate-title">Permintaan Penilaian</h2>
    </div>

    {{-- Livewire Component (search + cards + pagination) --}}
    <livewire:panelis-review-table />

    <x-slot name="scripts">
        <script>
            function toggleReviewCard(id) {
                const body  = document.getElementById('body-'  + id);
                const arrow = document.getElementById('arrow-' + id);
                if (!body || !arrow) return;
                body.classList.toggle('open');
                arrow.classList.toggle('rotated');
            }
        </script>
    </x-slot>

</x-panelis.layout>
