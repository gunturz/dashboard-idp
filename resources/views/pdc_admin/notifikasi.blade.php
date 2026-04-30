<x-pdc_admin.layout title="Notifikasi – Individual Development Plan" :user="$user">

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
        </style>
    </x-slot>

    {{-- ── Livewire Component – menggantikan loop blade statis ── --}}
    <div class="px-6 pb-8">
        <div class="mx-auto w-full animate-title" style="max-width: 960px;">
            <livewire:pdc-admin-notifikasi-list />
        </div>
    </div>

</x-pdc_admin.layout>
