<div class="navbar-outer">

    {{-- ── Left: Hamburger + Logo ── --}}
    <div class="flex items-center gap-3 flex-shrink-0">

        {{-- Mobile hamburger --}}
        @if (!($hideSidebar ?? false))
            <button
                class="flex-shrink-0 lg:hidden w-9 h-9 flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 transition-colors"
                onclick="toggleMobileSidebar()" aria-label="Menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        @endif

        {{-- Logo + Title --}}
        <a href="{{ route('pdc_admin.dashboard') }}"
            class="flex items-center gap-3 hover:opacity-90 transition-opacity">
            {{-- Logo box --}}
            <div
                class="hidden sm:flex items-center justify-center w-11 h-11 lg:w-12 lg:h-12 bg-white rounded-xl shadow-md flex-shrink-0 ring-2 ring-white/20">
                <img src="{{ asset('asset/logo ts.png') }}" alt="Logo" class="w-8 h-8 lg:w-9 lg:h-9 object-contain">
            </div>

            {{-- Brand text --}}
            <div class="hidden sm:block">
                <div class="flex items-center gap-2">
                    <h1 class="text-white font-extrabold text-lg lg:text-xl leading-tight tracking-wide">Individual
                        Development Plan</h1>
                </div>
            </div>

            {{-- Mobile-only short title --}}
            <h1 class="text-white font-bold text-base sm:hidden">IDP Admin</h1>
        </a>
    </div>

    {{-- ── Right: Actions ── --}}
    <div class="flex items-center gap-2 ml-auto flex-shrink-0">

        {{-- Notification Bell --}}
        <div class="hidden lg:relative lg:block" id="bell-wrapper">
            @php
                $rawNotif = \App\Models\AppNotification::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->get();
                $unreadNotifications = $rawNotif->where('is_read', false)->map(function ($n) {
                    return [
                        'title' => $n->title,
                        'desc' => $n->desc,
                        'time' => $n->created_at->diffForHumans(),
                    ];
                });
                $unreadCount = $unreadNotifications->count();
                $displayCount = $unreadCount > 99 ? '99+' : $unreadCount;
                $hasUnreadNotif = $unreadCount > 0;
            @endphp
            <button id="bell-btn" onclick="toggleDropdown('bell-dropdown', 'bell-btn')" aria-label="Notifikasi"
                class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-105 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path
                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                    <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                </svg>
                {{-- Notification Count Badge (red with bounce effect & ping) --}}
                @if ($hasUnreadNotif)
                    @php
                        $unreadCount = $unreadNotifications->count();
                        $displayCount = $unreadCount > 99 ? '99+' : $unreadCount;
                    @endphp
                    <span
                        class="absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-[#0f172a] animate-bounce"
                        style="animation-duration: 2s;" id="bell-red-badge">
                        {{ $displayCount }}
                    </span>
                    <span
                        class="absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] rounded-full bg-red-500 animate-ping opacity-40"></span>
                @endif
            </button>

            {{-- Bell Dropdown --}}
            <div id="bell-dropdown"
                class="dropdown-panel hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                <div class="px-5 py-3.5 bg-gradient-to-r from-[#0f172a] to-[#38475a] flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#14b8a6]" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                            <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                        </svg>
                        <span class="text-sm font-bold text-white">Notifikasi</span>
                    </div>
                    <form action="{{ route('pdc_admin.notifikasi.markAllRead') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit"
                            class="text-[11px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full hover:bg-[#14b8a6]/25 transition-colors">
                            Tandai semua
                        </button>
                    </form>
                </div>

                @if ($hasUnreadNotif)
                    <ul class="divide-y divide-gray-50 max-h-60 overflow-y-auto" id="pdc-bell-list">
                        @foreach ($unreadNotifications->take(2) as $notif)
                            <li class="px-4 py-3 flex items-start gap-3 hover:bg-gray-50 transition-colors cursor-pointer"
                                onclick="window.location='{{ route('pdc_admin.notifikasi') }}'">
                                <div
                                    class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">{!! $notif['title'] !!}
                                    </p>
                                    <p class="text-xs text-gray-500 truncate">{!! $notif['desc'] ?? $notif['time'] !!}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center py-10 text-center px-4" id="pdc-bell-empty-state">
                        <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <p class="text-gray-500 font-semibold text-sm">Tidak ada notifikasi</p>
                        <p class="text-gray-400 text-xs mt-1">Anda sudah up to date!</p>
                    </div>
                @endif

                <div class="px-5 py-3 border-t border-gray-100 text-center">
                    <a href="{{ route('pdc_admin.notifikasi') }}"
                        class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">
                        Lihat semua notifikasi →
                    </a>
                </div>
            </div>

            @if(session()->pull('pdc_admin_just_logged_in', false) && config('app.env') !== 'testing' && $hasUnreadNotif)
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        setTimeout(function () {
                            const bellDropdown = document.getElementById('bell-dropdown');
                            if (bellDropdown && bellDropdown.classList.contains('hidden')) {
                                bellDropdown.classList.remove('hidden');

                                // Siapkan state untuk efek menyusut ke arah lonceng
                                bellDropdown.style.transformOrigin = 'top right';
                                bellDropdown.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                                bellDropdown.style.transform = 'scale(1)';
                                bellDropdown.style.opacity = '1';

                                setTimeout(function () {
                                    if (!bellDropdown.classList.contains('hidden')) {
                                        // Trigger efek tersedot (menyusut ekstrem) ke arah lonceng (top right)
                                        bellDropdown.style.transform = 'scale(0)';
                                        bellDropdown.style.opacity = '0';

                                        setTimeout(function () {
                                            bellDropdown.classList.add('hidden');
                                            bellDropdown.style = ''; // Bersihkan style agar tombol aslinya tidak terganggu
                                        }, 500);
                                    }
                                }, 5000);
                            }
                        }, 200);
                    });
                </script>
            @endif

        </div>

        {{-- ─── Reverb Real-time Listener (PDC Admin only) ──────────────── --}}
        @auth
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const handleIncomingNotification = function (data) {
                        const notificationData = {
                            ...data,
                            __pdcHandled: true,
                        };

                        window.dispatchEvent(new CustomEvent('app-notification-received', {
                            detail: notificationData
                        }));
                        // 1. Update badge counter
                        pdcUpdateBadge();

                        document.dispatchEvent(new CustomEvent('pdc:notification-received', {
                            detail: notificationData
                        }));

                        // 2. Tampilkan toast realtime
                        pdcShowToast(notificationData.title, notificationData.desc);
                    };

                    function initPdcRealtimeNotifications() {
                        if (typeof window.Echo === 'undefined') {
                            return false;
                        }

                        const channelName = 'pdc-admin.{{ auth()->id() }}|user-notifications.{{ auth()->id() }}';
                        if (window.__pdcNotificationChannelsInitialized === channelName) {
                            return true;
                        }

                        window.Echo.private('pdc-admin.{{ auth()->id() }}')
                            .listen('.notification.new', handleIncomingNotification);

                        window.Echo.private('user-notifications.{{ auth()->id() }}')
                            .listen('.notification.created', handleIncomingNotification);

                        window.__pdcNotificationChannelsInitialized = channelName;
                        return true;
                    }

                    if (!initPdcRealtimeNotifications()) {
                        let retryCount = 0;
                        const retryTimer = setInterval(function () {
                            retryCount++;

                            if (initPdcRealtimeNotifications() || retryCount >= 20) {
                                clearInterval(retryTimer);
                            }
                        }, 500);
                    }

                    window.addEventListener('load', initPdcRealtimeNotifications);

                    // ── Badge updater ──────────────────────────────────────────────
                    function pdcUpdateBadge() {
                        let badge = document.getElementById('bell-red-badge');
                        let pingEl = badge ? badge.nextElementSibling : null;
                        let mobileIndicatorHost = document.querySelector('#profile-btn .relative');
                        let mobileMenuLinkBadge = document.querySelector('#profile-dropdown [data-mobile-unread-badge]');
                        let mobileMenuLinkPill = document.querySelector('#profile-dropdown [data-mobile-unread-pill]');

                        function nextBadgeCountFromElement(element) {
                            let current = parseInt((element?.textContent || '').trim(), 10) || 0;
                            let next = current + 1;
                            return next > 99 ? '99+' : String(next);
                        }

                        if (mobileIndicatorHost && !mobileIndicatorHost.querySelector('.mobile-trigger-notif-dot')) {
                            let dot = document.createElement('span');
                            dot.className = 'mobile-trigger-notif-dot absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-[#0f172a] lg:hidden';
                            dot.textContent = '1';
                            mobileIndicatorHost.appendChild(dot);
                        } else if (mobileIndicatorHost) {
                            mobileIndicatorHost.querySelector('.mobile-trigger-notif-dot').textContent = nextBadgeCountFromElement(mobileIndicatorHost.querySelector('.mobile-trigger-notif-dot'));
                        }

                        if (mobileMenuLinkBadge) {
                            mobileMenuLinkBadge.textContent = nextBadgeCountFromElement(mobileMenuLinkBadge);
                        } else {
                            let iconContainer = document.querySelector('#profile-dropdown a[href*="notifikasi"] .relative') || document.querySelector('#mobile-menu-dropdown a[href*="notifikasi"] .relative');
                            if (iconContainer) {
                                let badge = document.createElement('span');
                                badge.className = 'absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-white lg:hidden';
                                badge.setAttribute('data-mobile-unread-badge', '');
                                badge.textContent = '1';
                                iconContainer.appendChild(badge);
                            }
                        }

                        if (mobileMenuLinkPill) {
                            let current = parseInt((mobileMenuLinkPill.textContent || '').trim(), 10) || 0;
                            let next = current + 1;
                            mobileMenuLinkPill.textContent = `${next > 99 ? '99+' : next} Baru`;
                        } else {
                            let navLink = document.querySelector('#profile-dropdown a[href*="notifikasi"]') || document.querySelector('#mobile-menu-dropdown a[href*="notifikasi"]');
                            if (navLink) {
                                let pill = document.createElement('span');
                                pill.className = 'ml-auto bg-[#f97316] text-white text-[11px] font-bold px-2 py-0.5 rounded-full lg:hidden';
                                pill.setAttribute('data-mobile-unread-pill', '');
                                pill.textContent = '1 Baru';
                                navLink.appendChild(pill);
                            }
                        }

                        if (badge) {
                            let current = parseInt(badge.textContent.trim()) || 0;
                            let next = current + 1;
                            badge.textContent = next > 99 ? '99+' : next;
                        } else {
                            // Badge belum ada (sebelumnya semua sudah dibaca) — buat baru
                            let bellBtn = document.getElementById('bell-btn');
                            if (!bellBtn) return;

                            let newBadge = document.createElement('span');
                            newBadge.id = 'bell-red-badge';
                            newBadge.className = 'absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-[#0f172a] animate-bounce';
                            newBadge.style.animationDuration = '2s';
                            newBadge.textContent = '1';
                            bellBtn.appendChild(newBadge);

                            let ping = document.createElement('span');
                            ping.className = 'absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] rounded-full bg-red-500 animate-ping opacity-40';
                            bellBtn.appendChild(ping);
                        }
                    }

                    // ── Toast popup realtime ───────────────────────────────────────
                    function pdcShowToast(title, desc) {
                        // Container
                        let container = document.getElementById('pdc-rt-toast-container');
                        if (!container) {
                            container = document.createElement('div');
                            container.id = 'pdc-rt-toast-container';
                            container.style.cssText = 'position:fixed;left:12px;right:12px;bottom:12px;z-index:9999;display:flex;flex-direction:column-reverse;align-items:flex-end;gap:10px;pointer-events:none;';
                            document.body.appendChild(container);
                        }

                        let toast = document.createElement('div');
                        toast.style.cssText = [
                            'pointer-events:auto',
                            'display:flex',
                            'align-items:flex-start',
                            'gap:12px',
                            'background:#fff',
                            'border:1px solid #e2e8f0',
                            'border-left:4px solid #ef4444',
                            'border-radius:14px',
                            'padding:14px 18px',
                            'box-shadow:0 10px 40px rgba(0,0,0,.13)',
                            'width:min(100%,360px)',
                            'min-width:0',
                            'max-width:100%',
                            'position:relative',
                            'overflow:hidden',
                            'opacity:0',
                            'transform:translateX(40px) scale(.96)',
                            'transition:opacity .35s ease,transform .35s ease'
                        ].join(';');

                        toast.innerHTML = `
                                    <div style="flex-shrink:0;width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#fee2e2,#fecaca);display:flex;align-items:center;justify-content:center;">
                                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='#dc2626' style='width:20px;height:20px;'>
                                            <path d='M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z'/>
                                        </svg>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <div style="font-size:.85rem;font-weight:700;color:#1e293b;margin-bottom:3px;">🔴 ${title}</div>
                                        <div style="font-size:.78rem;color:#64748b;line-height:1.5;">${desc}</div>
                                    </div>
                                    <div style="position:absolute;bottom:0;left:0;height:3px;background:linear-gradient(90deg,#ef4444,#f87171);width:100%;transform-origin:left;animation:pdcBarShrink 5s linear forwards;border-radius:0 0 0 14px;"></div>
                                `;

                        // Inject keyframes once
                        if (!document.getElementById('pdc-toast-style')) {
                            let s = document.createElement('style');
                            s.id = 'pdc-toast-style';
                            s.textContent = '@keyframes pdcBarShrink{from{transform:scaleX(1)}to{transform:scaleX(0)}}';
                            document.head.appendChild(s);
                        }

                        container.appendChild(toast);
                        requestAnimationFrame(() => {
                            requestAnimationFrame(() => {
                                toast.style.opacity = '1';
                                toast.style.transform = 'translateX(0) scale(1)';
                            });
                        });

                        // Auto-dismiss after 5s
                        setTimeout(function () {
                            toast.style.opacity = '0';
                            toast.style.transform = 'translateX(40px) scale(.96)';
                            setTimeout(() => toast.remove(), 400);
                        }, 5000);
                    }
                });
            </script>
        @endauth

        @auth
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let pdcBellPopupTimeout = null;
                    let pdcBellCleanupTimeout = null;

                    document.addEventListener('pdc:notification-received', function (event) {
                        const data = event.detail || {};
                        pdcInsertRealtimeNotification(data.title || 'Notifikasi Baru', data.desc || '');
                        pdcShowBellPopup();
                    });

                    window.addEventListener('app-notification-received', function (event) {
                        const data = event.detail || {};

                        if (data.__pdcHandled) {
                            return;
                        }

                        pdcUpdateBadge();
                        pdcInsertRealtimeNotification(data.title || 'Notifikasi Baru', data.desc || '');
                        pdcShowBellPopup();
                        pdcShowToast(data.title || 'Notifikasi Baru', data.desc || '');
                    });

                    function pdcInsertRealtimeNotification(title, desc) {
                        const dropdown = document.getElementById('bell-dropdown');
                        if (!dropdown) return;

                        const emptyState = document.getElementById('pdc-bell-empty-state');
                        if (emptyState) {
                            emptyState.remove();
                        }

                        let list = document.getElementById('pdc-bell-list');
                        if (!list) {
                            list = document.createElement('ul');
                            list.id = 'pdc-bell-list';
                            list.className = 'divide-y divide-gray-50 max-h-60 overflow-y-auto';

                            const footer = dropdown.querySelector('.px-5.py-3.border-t');
                            if (footer) {
                                dropdown.insertBefore(list, footer);
                            } else {
                                dropdown.appendChild(list);
                            }
                        }

                        const item = document.createElement('li');
                        item.className = 'px-4 py-3 flex items-start gap-3 hover:bg-gray-50 transition-colors cursor-pointer';
                        item.onclick = function () {
                            window.location = '{{ route('pdc_admin.notifikasi') }}';
                        };
                        item.innerHTML = `
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate"></p>
                                        <p class="text-xs text-gray-500 truncate"></p>
                                    </div>
                                `;

                        const titleEl = item.querySelector('p.text-sm');
                        const descEl = item.querySelector('p.text-xs');

                        if (titleEl) titleEl.innerHTML = title;
                        if (descEl) descEl.innerHTML = desc;

                        list.prepend(item);

                        while (list.children.length > 2) {
                            list.removeChild(list.lastElementChild);
                        }

                        // -- Mobile dedicated notif-dropdown --
                        const mobileNotifDropdown = document.getElementById('mobile-notif-dropdown');
                        if (!mobileNotifDropdown) return;

                        const mobileEmpty = document.getElementById('pdc_admin-mobile-notif-empty');
                        if (mobileEmpty) mobileEmpty.style.display = 'none';

                        const mobileList = document.getElementById('pdc_admin-mobile-notif-list');
                        if (!mobileList) return;

                        const mobileItem = document.createElement('li');
                        mobileItem.className = 'px-4 py-3.5 flex items-start gap-3 hover:bg-gray-50 transition-colors cursor-pointer';
                        mobileItem.onclick = function () { window.location = '{{ route('pdc_admin.notifikasi') }}'; };
                        mobileItem.innerHTML = `
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 mt-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[13px] font-semibold text-gray-800 leading-snug"></p>
                                        <p class="mt-0.5 text-[11px] text-gray-500 leading-relaxed"></p>
                                        <p class="mt-1 text-[10px] text-[#14b8a6] font-medium">Baru saja</p>
                                    </div>
                                `;
                        const mobileTitleEl = mobileItem.querySelectorAll('p')[0];
                        const mobileDescEl = mobileItem.querySelectorAll('p')[1];
                        if (mobileTitleEl) mobileTitleEl.innerHTML = title;
                        if (mobileDescEl) mobileDescEl.innerHTML = desc;

                        mobileList.prepend(mobileItem);
                        while (mobileList.children.length > 5) mobileList.removeChild(mobileList.lastElementChild);
                    }

                    function pdcShowBellPopup() {
                        const isMobileActive = window.matchMedia('(max-width: 1023px)').matches;
                        // Mobile: buka panel notifikasi khusus
                        const bellDropdown = document.getElementById(isMobileActive ? 'mobile-notif-dropdown' : 'bell-dropdown');
                        if (!bellDropdown) return;

                        clearTimeout(pdcBellPopupTimeout);
                        clearTimeout(pdcBellCleanupTimeout);

                        document.querySelectorAll('.dropdown-panel').forEach(el => {
                            el.classList.add('hidden');
                            el.style.display = 'none';
                        });

                        bellDropdown.classList.remove('hidden');
                        bellDropdown.style.display = '';
                        bellDropdown.style.transformOrigin = 'top right';
                        bellDropdown.style.transition = 'opacity .35s ease, transform .35s cubic-bezier(0.22, 1, 0.36, 1)';
                        bellDropdown.style.opacity = '0';
                        bellDropdown.style.transform = isMobileActive ? 'translateY(-8px) scale(.98)' : 'scale(0.82) translateY(-10px)';

                        requestAnimationFrame(function () {
                            requestAnimationFrame(function () {
                                bellDropdown.style.opacity = '1';
                                bellDropdown.style.transform = 'translateY(0) scale(1)';
                            });
                        });

                        pdcBellPopupTimeout = setTimeout(function () {
                            bellDropdown.style.opacity = '0';
                            bellDropdown.style.transform = isMobileActive ? 'translateY(-8px) scale(.98)' : 'scale(0.86) translateY(-8px)';

                            pdcBellCleanupTimeout = setTimeout(function () {
                                bellDropdown.classList.add('hidden');
                                bellDropdown.style.display = 'none';
                                bellDropdown.style.transition = '';
                                bellDropdown.style.transformOrigin = '';
                                bellDropdown.style.opacity = '';
                                bellDropdown.style.transform = '';
                            }, 350);
                        }, 4500);
                    }

                    window.addEventListener('notifikasi-marked-read', function () {
                        let badge = document.getElementById('bell-red-badge');
                        if (badge) badge.remove();

                        let bellBtn = document.getElementById('bell-btn');
                        if (bellBtn) {
                            let ping = bellBtn.querySelector('.animate-ping');
                            if (ping) ping.remove();
                        }

                        // Mobile badges
                        document.querySelectorAll('.mobile-trigger-notif-dot, [data-mobile-unread-badge], [data-mobile-unread-pill], .bg-\\[\\#14b8a6\\].w-2.h-2').forEach(el => el.remove());
                    });
                });
            </script>
        @endauth




        {{-- Profile --}}
        <div class="relative" id="profile-wrapper">
            <button id="profile-btn" onclick="toggleDropdown('profile-dropdown', 'profile-btn')" aria-label="Profil"
                class="flex items-center gap-1.5 p-1.5 lg:gap-2.5 lg:pl-1 lg:pr-3 lg:py-1 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition-all hover:scale-105 active:scale-95">

                {{-- Avatar with initials --}}
                @php
                    $nama = $user->nama ?? ($user->name ?? 'U');
                    $parts = explode(' ', trim($nama));
                    $initials = strtoupper(
                        substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''),
                    );
                @endphp
                <div class="relative">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-extrabold text-white flex-shrink-0"
                        style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);">
                        {{ $initials }}
                    </div>
                    @if ($hasUnreadNotif)
                        <span
                            class="mobile-trigger-notif-dot absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-[#0f172a] lg:hidden">{{ $displayCount }}</span>
                    @endif
                </div>

                {{-- Name + Role (desktop only) --}}
                <div class="hidden lg:block text-left">
                    <p class="text-white text-sm font-semibold leading-tight max-w-[120px] truncate">
                        {{ $nama }}
                    </p>
                    <p class="text-[#94a3b8] text-[10px] font-medium leading-tight">PDC Admin</p>
                </div>

                {{-- Chevron (desktop only) --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white/60 hidden lg:block flex-shrink-0"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
                {{-- Mobile: hanya chevron kecil --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white/70 flex-shrink-0 lg:hidden"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- Profile Dropdown --}}
            {{-- Profile Dropdown: ukuran kecil di mobile --}}
            <div id="profile-dropdown"
                class="dropdown-panel hidden absolute right-0 mt-3 w-[290px] max-w-[calc(100vw-1rem)] lg:w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                {{-- Header --}}
                <div class="px-4 py-4 bg-gradient-to-br from-[#0f172a] to-[#38475a]">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center font-extrabold text-white flex-shrink-0 text-sm"
                            style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); box-shadow: 0 4px 12px rgba(20,184,166,0.4);">
                            {{ $initials }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-sm font-bold text-white truncate">
                                {{ $user->nama ?? ($user->name ?? '-') }}
                            </p>
                            <p class="text-xs text-[#94a3b8] truncate mt-0.5">{{ $user->email ?? '-' }}</p>
                            <span
                                class="inline-block mt-1 text-[10px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2 py-0.5 rounded-full">PDC
                                Admin</span>
                        </div>
                    </div>
                </div>

                {{-- Menu Items --}}
                <ul class="py-1.5">
                    <li>
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                            <div
                                class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-[#0f172a] flex items-center justify-center transition-colors flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-3.5 w-3.5 text-gray-500 group-hover:text-white transition-colors"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span>Lihat Profil</span>
                        </a>
                    </li>
                    {{-- Notifikasi – hanya tampil di mobile (lg ke atas pakai bell) --}}
                    <li class="lg:hidden">
                        <a href="{{ route('pdc_admin.notifikasi') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                            <div
                                class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-[#0f172a] flex items-center justify-center transition-colors flex-shrink-0 relative">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-3.5 w-3.5 text-gray-500 group-hover:text-white transition-colors"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                                    <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                </svg>
                                @if ($hasUnreadNotif)
                                    <span data-mobile-unread-badge
                                        class="absolute -top-1.5 -right-1.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1.5 text-[10px] font-bold text-white shadow ring-2 ring-white lg:hidden">{{ $displayCount }}</span>
                                @endif
                            </div>
                            <span>Notifikasi</span>
                            @if ($hasUnreadNotif)
                                <span data-mobile-unread-pill
                                    class="ml-auto bg-[#f97316] text-white text-[11px] font-bold px-2 py-0.5 rounded-full lg:hidden">{{ $displayCount }}
                                    Baru</span>
                            @endif
                        </a>
                    </li>
                    <li class="mx-3 border-t border-gray-100 my-1"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors group">
                                <div
                                    class="w-7 h-7 rounded-lg bg-red-50 group-hover:bg-red-500 flex items-center justify-center transition-colors flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-3.5 w-3.5 text-red-500 group-hover:text-white transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        {{-- -- Mobile Notif Dropdown (realtime, dedicated) -- --}}
        <div id="mobile-notif-dropdown"
            class="dropdown-panel hidden fixed top-[72px] left-3 right-3 w-auto sm:absolute sm:top-auto sm:left-auto sm:right-0 sm:mt-3 sm:w-[340px] bg-white rounded-[1.25rem] shadow-[0_20px_50px_-12px_rgba(0,0,0,0.25)] border border-gray-100 overflow-hidden z-50 sm:origin-top-right">
            <div class="px-5 py-4 bg-gradient-to-r from-[#0f172a] to-[#38475a] flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#14b8a6]" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                        <path d="M10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>
                    <span class="text-[13px] font-bold text-white">Notifikasi Baru</span>
                </div>
                <a href="{{ route('pdc_admin.notifikasi') }}"
                    class="text-[11px] font-semibold text-[#14b8a6] bg-[#14b8a6]/15 px-2.5 py-0.5 rounded-full hover:bg-[#14b8a6]/25 transition-colors">Lihat
                    Semua</a>
            </div>
            <ul id="pdc_admin-mobile-notif-list" class="divide-y divide-gray-50 max-h-64 overflow-y-auto"></ul>
            <div id="pdc_admin-mobile-notif-empty" class="flex flex-col items-center py-8 text-center px-4">
                <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <p class="text-gray-500 font-semibold text-sm">Tidak ada notifikasi baru</p>
            </div>
            <div class="px-5 py-3 border-t border-gray-100 text-center">
                <a href="{{ route('pdc_admin.notifikasi') }}"
                    class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">Lihat semua
                    notifikasi &#x2192;</a>
            </div>
        </div>
    </div>
</div>