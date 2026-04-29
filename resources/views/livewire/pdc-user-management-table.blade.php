<div>
    @php
        $roleConfig = [
            'talent'  => ['label' => 'Talent',  'color' => 'teal',   'hex' => '#14b8a6'],
            'mentor'  => ['label' => 'Mentor',  'color' => 'blue',   'hex' => '#3b82f6'],
            'atasan'  => ['label' => 'Atasan',  'color' => 'purple', 'hex' => '#a855f7'],
            'finance' => ['label' => 'Finance', 'color' => 'green',  'hex' => '#22c55e'],
            'panelis' => ['label' => 'Panelis', 'color' => 'amber',  'hex' => '#f59e0b'],
        ];

        $roleIcons = [
            'talent'  => '<path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>',
            'mentor'  => '<path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>',
            'atasan'  => '<path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>',
            'finance' => '<path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>',
            'panelis' => '<path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>',
        ];
    @endphp

    <div class="prem-stat-grid mb-6" style="grid-template-columns: repeat(5, 1fr);">
        @foreach($roleConfig as $key => $cfg)
            <div wire:key="stat-{{ $key }}"
                 wire:click="toggleRole('{{ $key }}')"
                 class="prem-stat clickable prem-stat-{{ $cfg['color'] }} cursor-pointer transition-all select-none
                        {{ $selectedRole === $key ? 'ring-2 ring-offset-1 shadow-lg -translate-y-1' : 'opacity-80 hover:opacity-100' }}"
                 style="{{ $selectedRole === $key ? 'ring-color:' . $cfg['hex'] : '' }}">
                <div class="prem-stat-icon si-{{ $cfg['color'] }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        {!! $roleIcons[$key] !!}
                    </svg>
                </div>
                <div class="prem-stat-value">{{ $counts[$cfg['label']] }}</div>
                <div class="prem-stat-label">{{ $cfg['label'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="md:col-span-2 relative">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama..."
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
        </div>

        <div class="relative">
            <select wire:model.live="company"
                class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white appearance-none transition-all">
                <option value="">Semua Perusahaan</option>
                @foreach($companies as $c)
                    <option value="{{ $c->id }}">{{ $c->nama_company }}</option>
                @endforeach
            </select>
        </div>

        @if($company)
            <div class="relative">
                <select wire:model.live="department"
                    class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] bg-white appearance-none transition-all">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $d)
                        <option value="{{ $d->nama_department }}">{{ $d->nama_department }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>

    <div class="flex flex-col gap-8 relative">
        <div wire:loading.flex class="absolute inset-0 z-10 hidden items-start justify-center pt-20 bg-white/40 backdrop-blur-[1px] rounded-2xl">
            <div class="animate-spin rounded-full h-10 w-10 border-4 border-gray-200 border-b-[#14b8a6]"></div>
        </div>

        @foreach($roleConfig as $roleKey => $cfg)
            @php
                $showRoleTable = isset($usersByRole[$roleKey]) && $usersByRole[$roleKey]->total() > 0;
            @endphp
            <div wire:key="table-wrapper-{{ $roleKey }}" class="{{ $showRoleTable ? 'block' : 'hidden' }}">
                @if($showRoleTable)
                    @php
                        $users = $usersByRole[$roleKey];
                        $showDepartmentAndPosition = !in_array($roleKey, ['finance', 'panelis']);
                        $showMultiRole = !in_array($roleKey, ['finance', 'panelis']);
                        $emptyStateColspan = 4 + ($showDepartmentAndPosition ? 2 : 0) + ($showMultiRole ? 1 : 0);
                    @endphp

                    <div class="border border-[#e2e8f0] rounded-2xl overflow-hidden shadow-sm bg-white">
                        <div class="relative flex items-center justify-center py-3.5 border-b-2"
                             style="border-bottom-color: {{ $cfg['hex'] }}; background: linear-gradient(135deg, {{ $cfg['hex'] }}0d 0%, white 60%);">
                            <div class="absolute left-4 flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg flex items-center justify-center" style="background-color: {{ $cfg['hex'] }}22;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-3.5 h-3.5" style="color: {{ $cfg['hex'] }}">
                                        {!! $roleIcons[$roleKey] !!}
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-400">{{ $users->total() }} pengguna</span>
                            </div>
                            <h3 class="text-sm font-bold tracking-wide" style="color: {{ $cfg['hex'] }}">{{ $cfg['label'] }}</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="um-table w-full">
                                <thead>
                                    <tr class="bg-[#f8fafc]">
                                        <th class="text-xs font-bold text-[#64748b] p-3 uppercase tracking-wide">Email</th>
                                        <th class="text-xs font-bold text-[#64748b] p-3 uppercase tracking-wide">Nama Lengkap</th>
                                        <th class="text-xs font-bold text-[#64748b] p-3 uppercase tracking-wide">Perusahaan</th>
                                        @if($showDepartmentAndPosition)
                                            <th class="text-xs font-bold text-[#64748b] p-3 uppercase tracking-wide">Departemen</th>
                                            <th class="text-xs font-bold text-[#64748b] p-3 uppercase tracking-wide">Posisi saat ini</th>
                                        @endif
                                        @if($showMultiRole)
                                            <th class="text-xs font-bold text-[#64748b] p-3 uppercase tracking-wide">Multi Role</th>
                                        @endif
                                        <th class="text-xs font-bold text-[#64748b] p-3 uppercase tracking-wide">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $u)
                                        <tr wire:key="user-row-{{ $roleKey }}-{{ $u->id }}" class="bg-white hover:bg-gray-50/80 transition-colors">
                                            <td class="px-4 py-3">
                                                <span class="block truncate max-w-[180px] text-sm text-[#475569]" title="{{ $u->email }}">
                                                    {{ $u->email }}
                                                </span>
                                            </td>
                                            <td class="text-sm font-semibold text-[#2e3746] whitespace-nowrap px-4 py-3">{{ $u->nama }}</td>
                                            <td class="text-sm text-[#475569] px-4 py-3">{{ $u->company->nama_company ?? '—' }}</td>
                                            @if($showDepartmentAndPosition)
                                                <td class="text-sm text-[#475569] px-4 py-3">{{ $u->department->nama_department ?? '—' }}</td>
                                                <td class="text-sm text-[#475569] px-4 py-3">{{ $u->position->position_name ?? '—' }}</td>
                                            @endif
                                            @if($showMultiRole)
                                                <td class="px-4 py-3 text-center">
                                                    <button type="button"
                                                        onclick="openRoleModal({{ $u->id }}, {{ $u->roles->pluck('id') }})"
                                                        class="inline-flex items-center justify-center w-9 h-9 bg-[#F5A623] hover:bg-[#e0961e] rounded-lg transition-colors shadow-sm" title="Assign Role">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-white">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            @endif
                                            <td class="px-4 py-3">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button" onclick="openResetPasswordModal({{ $u->id }})"
                                                        class="inline-flex items-center justify-center w-9 h-9 bg-[#F4F1EA] hover:bg-[#eadecc] border border-[#e5e1d8] rounded-lg transition-colors shadow-sm" title="Reset Password">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#475569]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                                        </svg>
                                                    </button>
                                                    <button type="button" onclick="openDeleteModal({{ $u->id }})"
                                                        class="inline-flex items-center justify-center w-9 h-9 bg-[#EF4444] hover:bg-[#dc2626] rounded-lg transition-colors shadow-sm" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ $emptyStateColspan }}" class="py-10 text-center text-sm text-gray-400 italic">
                                                <div class="flex flex-col items-center gap-2">
                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: {{ $cfg['hex'] }}15;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                            class="w-5 h-5" style="color: {{ $cfg['hex'] }}66">
                                                            {!! $roleIcons[$roleKey] !!}
                                                        </svg>
                                                    </div>
                                                    <span>Tidak ada {{ $cfg['label'] }} ditemukan</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($users->hasPages())
                            <div class="px-6 py-4 border-t border-[#e2e8f0] bg-gray-50/50 flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    Menampilkan {{ $users->firstItem() }}&ndash;{{ $users->lastItem() }} dari {{ $users->total() }} pengguna
                                </span>
                                <div class="flex gap-1.5">
                                    {{ $users->links('livewire.pagination-simple') }}
                                </div>
                             </div>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
