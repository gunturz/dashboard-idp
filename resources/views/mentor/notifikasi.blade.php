<x-mentor.layout title="Notifikasi – Individual Development Plan" bodyClass="bg-gray-50 min-h-screen flex flex-col pt-[80px]" :showProfileCard="false" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            /* Notification Card Styles */
            .notif-card { background-color: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 1.25rem 1.5rem; display: flex; align-items: flex-start; gap: 1.25rem; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); margin-bottom: 1rem; cursor: pointer; }
            .notif-card:hover { border-color: #cbd5e1; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06); transform: translateY(-2px); }
            .notif-unread { background-color: #f0fdf4; border-color: #86efac; }
            .notif-icon-wrap { flex-shrink: 0; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 10px; }
            .icon-success { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #16a34a; }
            .icon-info { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #2563eb; }
            .icon-warning { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706; }
        </style>
    </x-slot>

    <div class="w-full max-w-4xl mx-auto px-6 pt-10 pb-12 flex-grow fade-up fade-up-1">


        {{-- Back Link --}}
        <div class="mb-4">
            <a href="{{ route('mentor.dashboard') }}"
                class="px-4 py-2 border border-[#e2e8f0] rounded-lg bg-white text-[#475569] font-medium text-[0.875rem] flex items-center gap-2 transition-all duration-200 hover:bg-[#f8fafc] hover:border-[#cbd5e1] w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
                <span class="text-[#2e3746]">Kembali</span>
            </a>
        </div>

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#2e3746]" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <h2 class="text-2xl font-bold text-[#2e3746] animate-title">Notifikasi</h2>
            </div>
            <form action="{{ route('mentor.notifikasi.markAllRead') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm font-semibold text-teal-600 hover:text-teal-700 transition">Tandai semua
                    dibaca</button>
            </form>
        </div>

        {{-- Notifications List --}}
        <div class="space-y-3">
            @forelse ($notifications as $notif)
                <div class="notif-card {{ !$notif['is_read'] ? 'notif-unread' : '' }}">
                    <div class="notif-icon-wrap icon-{{ $notif['type'] }}">
                        @if ($notif['type'] == 'success')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @elseif($notif['type'] == 'info')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @elseif($notif['type'] == 'warning')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="font-bold text-gray-800 text-base">{!! $notif['title'] !!}</h3>
                            @if ($notif['badge'])
                                <span
                                    class="text-xs text-teal-600 font-semibold bg-teal-50 px-2 py-1 rounded-md">{{ $notif['badge'] }}</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mb-2 leading-relaxed">{!! $notif['desc'] !!}</p>
                        <span class="text-xs text-gray-400 font-medium">{{ $notif['time'] }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p class="text-gray-400 text-sm font-medium">Belum ada notifikasi</p>
                </div>
            @endforelse
        </div>

    </div>

    </x-mentor.layout>
