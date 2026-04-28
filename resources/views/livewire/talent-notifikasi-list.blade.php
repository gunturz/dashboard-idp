<div wire:poll.10s="loadNotifications">
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
        <div class="page-header-actions" style="margin-top: 30px;">
            @if(count($notifications) > 0)
                @if($unreadCount > 0)
                    <button wire:click="markAllRead" class="btn-prem btn-teal" style="padding: 8px 16px; font-size: 0.85rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                        Tandai Semua Dibaca
                    </button>
                @else
                    @if(!$isEditMode)
                        <button wire:click="toggleEditMode" class="btn-prem btn-ghost" style="padding: 8px 16px; font-size: 0.85rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            Edit
                        </button>
                    @else
                        <button wire:click="selectAll" class="btn-prem btn-blue" style="padding: 8px 16px; font-size: 0.85rem; background: #3b82f6; color: white;">
                            Pilih Semua
                        </button>
                    @endif
                @endif
            @endif
        </div>
    </div>

    <div class="prem-card w-full mb-6">
        <div class="prem-card-header flex justify-between items-center">
            <span class="prem-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd"/></svg>
                Semua Notifikasi
            </span>
            @if($unreadCount > 0)
                <span class="badge badge-teal">{{ $unreadCount }} belum dibaca</span>
            @else
                <span class="badge badge-gray">Semua sudah dibaca</span>
            @endif
        </div>

        <div style="padding: 16px 20px; display: flex; flex-direction: column; gap: 10px;">
            @forelse ($notifications as $notif)
                <label class="notif-item {{ !$notif['is_read'] ? 'unread' : '' }} type-{{ $notif['type'] ?? 'info' }}"
                    style="padding-left: 24px; border-left: 4px solid {{ $notif['accent'] ?? '#3b82f6' }}; border-top: 3px solid {{ $notif['accent'] ?? '#3b82f6' }}; border-radius: 20px; display: flex; align-items: center; gap: 12px; cursor: {{ $isEditMode ? 'pointer' : 'default' }}; margin-bottom: 0;">
                    @if($isEditMode)
                        <div style="flex-shrink: 0; display: flex; align-items: center;">
                            <input type="checkbox" wire:model.live="selectedNotifications" value="{{ $notif['id'] }}"
                                class="w-5 h-5 text-[#14b8a6] bg-gray-100 border-gray-300 rounded focus:ring-[#14b8a6]"
                                style="cursor: pointer;">
                        </div>
                    @endif

                    <div class="notif-icon ni-{{ $notif['type'] ?? 'info' }}"
                        style="background: {{ $notif['icon_bg'] ?? '#dbeafe' }}; color: {{ $notif['icon_color'] ?? '#2563eb' }};">
                        @if ($notif['uses_people_icon'] ?? false)
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10.5 11.25a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Zm-7.5 9a7.5 7.5 0 1 1 15 0 .75.75 0 0 1-.75.75H3.75a.75.75 0 0 1-.75-.75Zm14.58-10.186a3 3 0 1 0-1.16-5.884 5.247 5.247 0 0 1 0 5.884A2.998 2.998 0 0 0 17.58 10.064Zm1.446 2.192a4.483 4.483 0 0 1 2.724 4.119.375.375 0 0 1-.375.375h-2.919a8.24 8.24 0 0 0-1.193-4.494 4.47 4.47 0 0 1 1.763 0Z"/>
                            </svg>
                        @elseif (($notif['type'] ?? '') === 'success')
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
                                <span class="badge" style="flex-shrink:0; background: {{ $notif['badge_bg'] ?? '#eff6ff' }}; color: {{ $notif['badge_color'] ?? '#1d4ed8' }};">{{ $notif['badge'] }}</span>
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
                </label>
            @empty
                <div class="empty-prem" style="border:none; padding:48px 20px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                    <h3>Tidak Ada Notifikasi</h3>
                    <p>Anda sudah up to date! Tidak ada pemberitahuan baru.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="w-full flex justify-start mb-8">
        <a href="{{ route('talent.dashboard') }}" class="btn-prem btn-ghost" style="display: flex; align-items: center; gap: 8px; font-weight: 600; color: #475569; padding: 10px 16px; border-radius: 8px; background: #fff; border: 1px solid #e2e8f0; transition: all 0.2s;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 18px; height: 18px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>
    </div>

    @if($isEditMode)
        <div class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-white px-5 py-3 rounded-full shadow-lg border border-gray-100 animate-title">
            <span class="text-sm font-semibold text-gray-600 mr-2">{{ count($selectedNotifications) }} dipilih</span>
            <button wire:click="toggleEditMode" class="btn-prem btn-ghost" style="padding: 6px 14px; border-radius: 99px;">Batal</button>
            <button wire:click="deleteSelected" class="btn-prem btn-red" style="padding: 6px 14px; border-radius: 99px;" @if(empty($selectedNotifications)) disabled style="opacity: 0.5; cursor: not-allowed;" @endif>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16" /></svg>
                Delete
            </button>
        </div>
    @endif
</div>
