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

    {{-- ── Page Header ── --}}
    <div class="page-header animate-title">
        <div class="page-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
        </div>
        <div>
            <div class="page-header-title">Notifikasi</div>
            <div class="page-header-sub">Semua pemberitahuan aktivitas sistem</div>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('pdc_admin.dashboard') }}" class="btn-prem btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z" clip-rule="evenodd"/></svg>
                Kembali
            </a>
            <form action="{{ route('pdc_admin.notifikasi.markAllRead') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn-prem btn-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                    Tandai Semua Dibaca
                </button>
            </form>
        </div>
    </div>

    {{-- ── Notifications ── --}}
    <div class="prem-card" style="max-width: 860px; margin: 0 auto 20px;">
        <div class="prem-card-header">
            <span class="prem-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd"/></svg>
                Semua Notifikasi
            </span>
            @php $unreadCount = collect($notifications)->where('is_read', false)->count(); @endphp
            @if($unreadCount > 0)
                <span class="badge badge-teal">{{ $unreadCount }} belum dibaca</span>
            @else
                <span class="badge badge-gray">Semua sudah dibaca</span>
            @endif
        </div>

        <div style="padding: 16px 20px; display: flex; flex-direction: column; gap: 10px;">
            @forelse ($notifications as $notif)
                <div class="notif-item {{ !$notif['is_read'] ? 'unread' : '' }} type-{{ $notif['type'] ?? 'info' }}" style="padding-left: 24px;">
                    <div class="notif-icon ni-{{ $notif['type'] ?? 'info' }}">
                        @if (($notif['type'] ?? '') === 'success')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif (($notif['type'] ?? '') === 'warning')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:10px; margin-bottom:4px;">
                            <h3 style="font-weight:700; color:#1e293b; font-size:.9rem; margin:0; flex:1;">{!! $notif['title'] !!}</h3>
                            @if ($notif['badge'] ?? false)
                                <span class="badge badge-teal" style="flex-shrink:0;">{{ $notif['badge'] }}</span>
                            @endif
                            @if (!$notif['is_read'])
                                <div class="notif-unread-dot"></div>
                            @endif
                        </div>
                        <p style="font-size:.83rem; color:#475569; margin:0 0 6px; line-height:1.6;">{!! $notif['desc'] !!}</p>
                        <div class="notif-time">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $notif['time'] }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-prem" style="border:none; padding:48px 20px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                    <h3>Tidak Ada Notifikasi</h3>
                    <p>Anda sudah up to date! Tidak ada pemberitahuan baru.</p>
                </div>
            @endforelse
        </div>
    </div>

</x-pdc_admin.layout>
