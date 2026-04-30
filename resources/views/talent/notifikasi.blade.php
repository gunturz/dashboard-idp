<x-talent.layout title="Notifikasi - Individual Development Plan" bodyClass="bg-[#ffffff] min-h-screen flex flex-col pt-[80px] relative" :showProfileCard="false" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            .notif-item {
                display: flex; align-items: flex-start; gap: 14px;
                background: #fff; border: 1px solid #e2e8f0;
                border-radius: 16px; padding: 16px 20px;
                transition: transform .2s, box-shadow .2s, border-color .2s;
                position: relative; overflow: hidden;
            }
            .notif-item::before {
                content: ''; position: absolute; left: 0; top: 0; bottom: 0;
                width: 4px; border-radius: 4px 0 0 4px;
            }
            .notif-item:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.07); }
            .notif-item.unread { border-color: #86efac; background: #f0fdf4; }
            .notif-item.unread::before { background: linear-gradient(180deg,#22c55e,#16a34a); }
            .notif-item.type-success::before { background: linear-gradient(180deg,#22c55e,#16a34a); }
            .notif-item.type-info::before { background: linear-gradient(180deg,#3b82f6,#1d4ed8); }
            .notif-item.type-warning::before { background: linear-gradient(180deg,#f59e0b,#d97706); }

            .notif-icon {
                width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
                display: flex; align-items: center; justify-content: center;
            }
            .notif-icon svg { width: 22px; height: 22px; }
            .ni-success { background: linear-gradient(135deg,#dcfce7,#bbf7d0); color: #16a34a; }
            .ni-info    { background: linear-gradient(135deg,#dbeafe,#bfdbfe); color: #2563eb; }
            .ni-warning { background: linear-gradient(135deg,#fef3c7,#fde68a); color: #d97706; }

            .notif-unread-dot {
                width: 9px; height: 9px; border-radius: 50%;
                background: #14b8a6; flex-shrink: 0; margin-top: 6px;
                box-shadow: 0 0 0 3px rgba(20,184,166,.2);
            }

            .notif-time {
                font-size: .72rem; color: #94a3b8; font-weight: 500; margin-top: 4px;
                display: flex; align-items: center; gap: 4px;
            }
            .notif-time svg { width: 12px; height: 12px; }

            .page-header-actions {
                margin-left: auto;
                display: flex;
                align-items: center;
                gap: 8px;
                flex-shrink: 0;
            }

            .prem-card {
                background: #f9fafb;
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
                overflow: hidden;
                margin-bottom: 24px;
            }

            .prem-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 16px 20px;
                border-bottom: 1px solid #e2e8f0;
                gap: 12px;
                flex-wrap: wrap;
            }

            .prem-card-title {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: .9rem;
                font-weight: 700;
                color: #1e293b;
            }

            .prem-card-title svg {
                width: 18px;
                height: 18px;
                color: #14b8a6;
                flex-shrink: 0;
            }

            .btn-prem {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 5px;
                font-size: 0.8rem;
                font-weight: 700;
                padding: 8px 16px;
                border-radius: 10px;
                border: none;
                cursor: pointer;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                text-decoration: none;
                white-space: nowrap;
            }

            .btn-prem:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            }

            .btn-prem svg {
                width: 16px;
                height: 16px;
                flex-shrink: 0;
            }

            .btn-teal {
                background: #14b8a6;
                color: #fff;
                box-shadow: 0 2px 6px rgba(20, 184, 166, 0.25);
            }

            .btn-teal:hover {
                background: #0d9488;
                color: #fff;
            }

            .btn-ghost {
                background: #f1f5f9;
                color: #334155;
                border: 1px solid #e2e8f0;
            }

            .btn-ghost:hover {
                background: #e2e8f0;
                color: #1e293b;
            }

            .btn-blue {
                background: #3b82f6;
                color: #fff;
                box-shadow: 0 2px 6px rgba(59, 130, 246, 0.25);
            }

            .btn-blue:hover {
                background: #2563eb;
                color: #fff;
            }

            .btn-red {
                background: #ef4444;
                color: #fff;
                box-shadow: 0 2px 6px rgba(239, 68, 68, 0.25);
            }

            .btn-red:hover {
                background: #dc2626;
                color: #fff;
            }

            .badge {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                padding: 3px 10px;
                border-radius: 99px;
                font-size: 0.72rem;
                font-weight: 700;
                letter-spacing: .02em;
            }

            .badge-teal {
                background: rgba(20, 184, 166, 0.12);
                color: #0d9488;
                border: 1px solid rgba(20, 184, 166, 0.25);
            }

            .badge-gray {
                background: rgba(100, 116, 139, 0.1);
                color: #475569;
                border: 1px solid rgba(100, 116, 139, 0.2);
            }

            .empty-prem {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 60px 24px;
                text-align: center;
                gap: 12px;
            }

            .empty-prem svg {
                width: 56px;
                height: 56px;
                color: #cbd5e1;
            }

            .empty-prem h3 {
                font-size: 1.05rem;
                font-weight: 700;
                color: #475569;
                margin: 0;
            }

            .empty-prem p {
                font-size: 0.82rem;
                color: #94a3b8;
                margin: 0;
            }
        </style>
    </x-slot>

    <main id="main-content" class="px-6 py-8 min-h-[calc(100vh-80px)]">
        <div class="mx-auto w-full" style="max-width: 960px;">
            <livewire:talent-notifikasi-list />
        </div>
    </main>
</x-talent.layout>
