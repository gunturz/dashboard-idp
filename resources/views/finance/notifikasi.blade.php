    <div class="w-full max-w-4xl mx-auto">

        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('finance.dashboard') }}" class="btn-prem btn-ghost group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 transition-transform group-hover:-translate-x-1">
                    <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

    {{-- ── Page Header ── --}}
    <div class="dash-header animate-title">
        <div class="dash-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </div>
        <div>
            <div class="dash-header-title">Notifikasi</div>
            <div class="dash-header-sub">Informasi terbaru terkait validasi IDP</div>
        </div>
        <form action="{{ route('finance.notifikasi.markAllRead') }}" method="POST" class="ml-auto">
            @csrf
            <button type="submit" class="btn-prem btn-ghost text-xs">
                Tandai semua dibaca
            </button>
        </form>
    </div>

        {{-- Notification List --}}
        <div class="space-y-4">
            @forelse ($notifications as $notif)
                <div class="prem-card !mb-0 p-5 flex items-start gap-5 transition-all hover:shadow-md cursor-pointer {{ !$notif['is_read'] ? 'bg-teal-50/30 border-teal-100' : '' }}">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center
                        @if($notif['type'] === 'success') bg-green-100 text-green-600 @elseif($notif['type'] === 'info') bg-blue-100 text-blue-600 @else bg-amber-100 text-amber-600 @endif">
                        @if ($notif['type'] === 'success')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @elseif ($notif['type'] === 'info')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start mb-1 gap-4">
                            <h3 class="font-bold text-gray-800 text-sm">{!! $notif['title'] !!}</h3>
                            @if (!empty($notif['badge']))
                                <span class="badge badge-teal shrink-0">
                                    {{ $notif['badge'] }}
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-600 mb-2 leading-relaxed">{!! $notif['desc'] !!}</p>
                        <div class="flex items-center gap-2 text-[10px] text-gray-400 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $notif['time'] }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="prem-card">
                    <div class="empty-prem">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <h3>Belum ada notifikasi</h3>
                        <p>Anda akan menerima pemberitahuan di sini.</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>

</x-finance.layout>
