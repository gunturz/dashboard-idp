@php $mobileCollapsible = $mobileCollapsible ?? false; @endphp

@if($mobileCollapsible)
    {{-- ===== DESKTOP VIEW (dashboard): 3-column layout ===== --}}
    <div class="hidden md:block bg-[#2e3746] shadow-md py-6 fade-up fade-up-1">
        <div class="flex flex-row items-stretch divide-x divide-white/20">

            <div class="flex items-center gap-5 px-10 flex-shrink-0 w-1/3 justify-center py-2">
                <div class="flex-shrink-0">
                    @if ($user->foto ?? false)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="w-24 h-24 rounded-[10px] object-cover border-2 border-white/30">
                    @else
                        <div class="w-24 h-24 rounded-[10px] bg-white/20 flex items-center justify-center border-2 border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white/70" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div>
                    <p class="text-white font-bold text-base leading-tight">{{ $user->nama ?? $user->name }}</p>
                    <p class="text-white/60 text-xs mt-1">{{ ucfirst($user->role->role_name ?? 'Talent') }}</p>
                </div>
            </div>

            <div class="px-10 w-1/3 flex flex-col pt-3 space-y-3 text-sm">
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Perusahaan</span>
                    <span class="text-white">{{ optional($user->company)->nama_company ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Departemen</span>
                    <span class="text-white">{{ optional($user->department)->nama_department ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Posisi Sekarang</span>
                    <span class="text-white">{{ optional($user->position)->position_name ?? '-' }}</span>
                </div>
            </div>

            <div class="px-10 w-1/3 flex flex-col pt-3 space-y-3 text-sm">
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Mentor</span>
                    <span class="text-white">{{ collect(optional($user->promotion_plan)->mentor_models)->pluck('nama')->join(', ') ?: (optional($user->mentor)->nama ?? '-') }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Atasan</span>
                    <span class="text-white">{{ optional($user->atasan)->nama ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Posisi Dituju</span>
                    <span class="text-white">{{ optional(optional($user->promotion_plan)->targetPosition)->position_name ?? '-' }}</span>
                </div>
            </div>

        </div>
    </div>

    {{-- ===== MOBILE VIEW (dashboard only): compact + collapsible ===== --}}
    <div class="md:hidden bg-[#2e3746] shadow-md fade-up fade-up-1">
        <div class="flex items-center gap-3 px-4 py-3 cursor-pointer" id="mobile-profile-toggle" onclick="toggleMobileProfile()">
            <div class="flex-shrink-0">
                @if ($user->foto ?? false)
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="w-11 h-11 rounded-lg object-cover border-2 border-white/30">
                @else
                    <div class="w-11 h-11 rounded-lg bg-white/20 flex items-center justify-center border-2 border-white/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white/70" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    </div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white font-bold text-sm leading-tight truncate">{{ $user->nama ?? $user->name }}</p>
                <p class="text-white/60 text-xs mt-0.5">{{ ucfirst($user->role->role_name ?? 'Talent') }}</p>
            </div>
            <div class="flex-shrink-0">
                <svg id="mobile-profile-chevron" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/60 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
        <div id="mobile-profile-detail" class="mobile-profile-detail-panel">
            {{-- Group 1: Info Perusahaan --}}
            <div class="px-4 pb-3 pt-2 space-y-2.5 text-sm border-t border-white/10">
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-28 flex-shrink-0">Perusahaan</span>
                    <span class="text-white">{{ optional($user->company)->nama_company ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-28 flex-shrink-0">Departemen</span>
                    <span class="text-white">{{ optional($user->department)->nama_department ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-28 flex-shrink-0">Posisi Sekarang</span>
                    <span class="text-white">{{ optional($user->position)->position_name ?? '-' }}</span>
                </div>
            </div>
            {{-- Group 2: Mentor & Atasan --}}
            <div class="px-4 pb-4 pt-3 space-y-2.5 text-sm border-t border-white/15">
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-28 flex-shrink-0">Mentor</span>
                    <span class="text-white">{{ collect(optional($user->promotion_plan)->mentor_models)->pluck('nama')->join(', ') ?: (optional($user->mentor)->nama ?? '-') }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-28 flex-shrink-0">Atasan</span>
                    <span class="text-white">{{ optional($user->atasan)->nama ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-28 flex-shrink-0">Posisi Dituju</span>
                    <span class="text-white">{{ optional(optional($user->promotion_plan)->targetPosition)->position_name ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

@else
    {{-- ===== ORIGINAL VIEW (logbook, dll): responsive stacked layout ===== --}}
    <div class="bg-[#2e3746] shadow-md py-6 fade-up fade-up-1">
        <div class="flex flex-col md:flex-row items-stretch divide-y md:divide-y-0 md:divide-x divide-white/20">

            <div class="flex items-center gap-5 px-6 md:px-10 flex-shrink-0 w-full md:w-1/3 justify-center py-4 md:py-2">
                <div class="flex-shrink-0">
                    @if ($user->foto ?? false)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="w-24 h-24 rounded-[10px] object-cover border-2 border-white/30">
                    @else
                        <div class="w-24 h-24 rounded-[10px] bg-white/20 flex items-center justify-center border-2 border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white/70" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div>
                    <p class="text-white font-bold text-base leading-tight">{{ $user->nama ?? $user->name }}</p>
                    <p class="text-white/60 text-xs mt-1">{{ ucfirst($user->role->role_name ?? 'Talent') }}</p>
                </div>
            </div>

            <div class="px-6 md:px-10 w-full md:w-1/3 flex flex-col py-4 md:pt-3 space-y-3 text-sm">
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Perusahaan</span>
                    <span class="text-white">{{ optional($user->company)->nama_company ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Departemen</span>
                    <span class="text-white">{{ optional($user->department)->nama_department ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Posisi Sekarang</span>
                    <span class="text-white">{{ optional($user->position)->position_name ?? '-' }}</span>
                </div>
            </div>

            <div class="px-6 md:px-10 w-full md:w-1/3 flex flex-col py-4 md:pt-3 space-y-3 text-sm">
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Mentor</span>
                    <span class="text-white">{{ collect(optional($user->promotion_plan)->mentor_models)->pluck('nama')->join(', ') ?: (optional($user->mentor)->nama ?? '-') }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Atasan</span>
                    <span class="text-white">{{ optional($user->atasan)->nama ?? '-' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-semibold text-white/70 w-32 flex-shrink-0">Posisi Dituju</span>
                    <span class="text-white">{{ optional(optional($user->promotion_plan)->targetPosition)->position_name ?? '-' }}</span>
                </div>
            </div>

        </div>
    </div>
@endif
