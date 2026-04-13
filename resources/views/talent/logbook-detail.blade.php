<x-talent.layout title="LogBook Detail – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            /* Custom Scrollbar Styles for LogBook Tables */
            .custom-scrollbar::-webkit-scrollbar { 
                height: 8px; 
            }
            .custom-scrollbar::-webkit-scrollbar-track { 
                background: #f8fafc; 
                border-radius: 10px; 
            }
            .custom-scrollbar::-webkit-scrollbar-thumb { 
                background: #0d9488; 
                border-radius: 10px;
                border: 2px solid #f8fafc;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { 
                background: #0f766e; 
            }

            /* Mobile: constrain table containers within viewport */
            @media (max-width: 767px) {
                .custom-scrollbar {
                    max-width: calc(100vw - 1.5rem);
                }
            }
        </style>
    </x-slot>

    <div class="max-w-7xl mx-auto px-3 md:px-6 pt-4 pb-6 fade-up overflow-x-hidden">

        {{-- Back Link --}}
        <div class="mb-2">
            <a href="{{ route('talent.dashboard') }}"
                class="px-4 py-2 border border-[#e2e8f0] rounded-lg bg-white text-[#475569] font-medium text-[0.875rem] flex items-center gap-2 transition-all duration-200 hover:bg-[#f8fafc] hover:border-[#cbd5e1] w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
                <span class="text-[#2e3746]">Kembali</span>
            </a>
        </div>

        <div class="flex items-center gap-3 mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
            </svg>
            <h1 class="text-2xl font-bold text-[#2e3746]">LogBook</h1>
        </div>

        {{-- Exposure Section --}}
        <div class="mb-12">
            <h2 class="text-xl font-bold text-[#3d4f62] mb-4">Exposure</h2>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Mentor</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tema</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tanggal Pengiriman/Update</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tanggal Pelaksanaan</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Status</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($exposureData as $data)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap border-r border-gray-100">{{ $data['mentor'] }}</td>
                                <td class="px-6 py-4 text-gray-600 border-r border-gray-100" style="min-width: 15rem">{{ \Illuminate\Support\Str::limit($data['tema'], 35) }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ $data['tanggal_update'] ? date('d M Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                                <td class="px-6 py-4 text-left border-r border-gray-100">
                                    @if(in_array($data['status'], ['Approve', 'Approved']))
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-bold px-3 py-1 rounded-full text-[11px] bg-emerald-50"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-red-500 font-bold px-3 py-1 rounded-full text-[11px] bg-red-50"><span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> {{ $data['status'] }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-l border-gray-100">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('talent.logbook.item', $data['id']) }}" class="text-teal-500 hover:text-teal-700 transition flex items-center gap-1 font-bold text-xs bg-teal-50 px-3 py-1.5 rounded-lg border border-teal-100" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> Detail
                                        </a>
                                        <div class="hidden logbook-detail-html">
                                            <div class="space-y-3">
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Mentor</span><div class="text-[14px] text-gray-800">{{ $data['mentor'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tema</span><div class="text-[14px] text-gray-800">{{ $data['tema'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal</span><div class="text-[14px] text-gray-800">{{ date('d M Y', strtotime($data['tanggal'])) }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Lokasi</span><div class="text-[14px] text-gray-800">{{ $data['lokasi'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Aktivitas</span><div class="text-[14px] text-gray-800">{{ $data['aktivitas'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Deskripsi</span><div class="text-[14px] text-gray-800">{{ $data['deskripsi'] ?? '-' }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Dokumentasi</span>
                                                    @if(!empty($data['file_paths']))
                                                        <div class="flex flex-col gap-1 mt-1">
                                                            @foreach($data['file_paths'] as $fi => $fp)
                                                            <a href="{{ asset('storage/' . $fp) }}" target="_blank" class="text-xs text-teal-600 hover:underline flex items-center gap-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                            {{ $data['file_names'][$fi] ?? 'Dokumen' }}</a>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-xs text-gray-400">-</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Edit Button --}}
                                        <a href="{{ optional($user->promotion_plan)->is_locked ? '#' : route('talent.idp_monitoring.edit', $data['id']) }}" class="text-blue-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:text-blue-700 transition' }}" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        {{-- Delete Button --}}
                                        <form action="{{ route('talent.idp_monitoring.destroy', $data['id']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="{{ optional($user->promotion_plan)->is_locked ? 'return false;' : 'confirmDeleteLogbook(this)' }}" class="text-red-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed' : 'hover:text-red-700 transition' }}" title="Hapus" {{ optional($user->promotion_plan)->is_locked ? 'disabled' : '' }}>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-6 py-8 text-left text-gray-500">Belum ada aktivitas Exposure yang dicatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Mentoring Section --}}
        <div class="mb-12">
            <h2 class="text-xl font-bold text-[#3d4f62] mb-4">Mentoring</h2>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Mentor</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tema</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tanggal Pengiriman/Update</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tanggal Pelaksanaan</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Status</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($mentoringData as $data)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap border-r border-gray-100">{{ $data['mentor'] }}</td>
                                <td class="px-6 py-4 text-gray-600 border-r border-gray-100" style="min-width: 15rem">{{ \Illuminate\Support\Str::limit($data['tema'], 35) }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ $data['tanggal_update'] ? date('d M Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                                <td class="px-6 py-4 text-left border-r border-gray-100">
                                    @if(in_array($data['status'], ['Approve', 'Approved']))
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-bold px-3 py-1 rounded-full text-[11px] bg-emerald-50"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 font-bold px-3 py-1 rounded-full text-[11px] bg-orange-50"><span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $data['status'] }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-l border-gray-100">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('talent.logbook.item', $data['id']) }}" class="text-teal-500 hover:text-teal-700 transition flex items-center gap-1 font-bold text-xs bg-teal-50 px-3 py-1.5 rounded-lg border border-teal-100" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> Detail
                                        </a>
                                        <div class="hidden logbook-detail-html">
                                            <div class="space-y-3">
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Mentor</span><div class="text-[14px] text-gray-800">{{ $data['mentor'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tema</span><div class="text-[14px] text-gray-800">{{ $data['tema'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal</span><div class="text-[14px] text-gray-800">{{ date('d M Y', strtotime($data['tanggal'])) }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Lokasi</span><div class="text-[14px] text-gray-800">{{ $data['lokasi'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Deskripsi</span><div class="text-[14px] text-gray-800">{{ $data['deskripsi'] ?? '-' }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Action Plan</span><div class="text-[14px] text-gray-800">{{ $data['action_plan'] ?? '-' }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Dokumentasi</span>
                                                    @if(!empty($data['file_paths']))
                                                        <div class="flex flex-col gap-1 mt-1">
                                                            @foreach($data['file_paths'] as $fi => $fp)
                                                            <a href="{{ asset('storage/' . $fp) }}" target="_blank" class="text-xs text-teal-600 hover:underline flex items-center gap-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                            {{ $data['file_names'][$fi] ?? 'Dokumen' }}</a>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-xs text-gray-400">-</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ optional($user->promotion_plan)->is_locked ? '#' : route('talent.idp_monitoring.edit', $data['id']) }}" class="text-blue-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:text-blue-700 transition' }}" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('talent.idp_monitoring.destroy', $data['id']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="{{ optional($user->promotion_plan)->is_locked ? 'return false;' : 'confirmDeleteLogbook(this)' }}" class="text-red-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed' : 'hover:text-red-700 transition' }}" title="Hapus" {{ optional($user->promotion_plan)->is_locked ? 'disabled' : '' }}>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-6 py-8 text-left text-gray-500">Belum ada aktivitas Mentoring yang dicatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Learning Section --}}
        <div class="mb-12">
            <h2 class="text-xl font-bold text-[#3d4f62] mb-4">Learning</h2>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full w-full text-sm text-left table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Sumber</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tema</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tanggal Pengiriman/Update</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Tanggal Pelaksanaan</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left">Status</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($learningData as $data)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap border-r border-gray-100">{{ $data['sumber'] }}</td>
                                <td class="px-6 py-4 text-gray-600 border-r border-gray-100" style="min-width: 15rem">{{ \Illuminate\Support\Str::limit($data['tema'], 35) }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ $data['tanggal_update'] ? date('d M Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                                <td class="px-6 py-4 text-left border-r border-gray-100">
                                    @if(in_array($data['status'], ['Approve', 'Approved']))
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-bold px-3 py-1 rounded-full text-[11px] bg-emerald-50"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 font-bold px-3 py-1 rounded-full text-[11px] bg-orange-50"><span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $data['status'] }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-l border-gray-100">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('talent.logbook.item', $data['id']) }}" class="text-teal-500 hover:text-teal-700 transition flex items-center gap-1 font-bold text-xs bg-teal-50 px-3 py-1.5 rounded-lg border border-teal-100" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> Detail
                                        </a>
                                        <div class="hidden logbook-detail-html">
                                            <div class="space-y-3">
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Sumber</span><div class="text-[14px] text-gray-800">{{ $data['sumber'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tema</span><div class="text-[14px] text-gray-800">{{ $data['tema'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal</span><div class="text-[14px] text-gray-800">{{ date('d M Y', strtotime($data['tanggal'])) }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Platform</span><div class="text-[14px] text-gray-800">{{ $data['platform'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Dokumentasi</span>
                                                    @if(!empty($data['file_paths']))
                                                        <div class="flex flex-col gap-1 mt-1">
                                                            @foreach($data['file_paths'] as $fi => $fp)
                                                            <a href="{{ asset('storage/' . $fp) }}" target="_blank" class="text-xs text-teal-600 hover:underline flex items-center gap-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                            {{ $data['file_names'][$fi] ?? 'Dokumen' }}</a>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-xs text-gray-400">-</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ optional($user->promotion_plan)->is_locked ? '#' : route('talent.idp_monitoring.edit', $data['id']) }}" class="text-blue-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:text-blue-700 transition' }}" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('talent.idp_monitoring.destroy', $data['id']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="{{ optional($user->promotion_plan)->is_locked ? 'return false;' : 'confirmDeleteLogbook(this)' }}" class="text-red-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed' : 'hover:text-red-700 transition' }}" title="Hapus" {{ optional($user->promotion_plan)->is_locked ? 'disabled' : '' }}>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-left text-gray-500">Belum ada aktivitas Learning yang dicatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Generic Logbook Detail Modal -->
    <div id="logbookDetailModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm transition-opacity opacity-0">
        <div class="bg-white rounded-[20px] shadow-2xl w-full max-w-[500px] p-7 transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto" id="logbookDetailModalContent">
            <div class="flex justify-between items-start mb-4 border-b border-gray-100 pb-4">
                <h3 class="text-xl font-bold text-[#1e293b]">Detail Logbook</h3>
                <button onclick="closeLogbookDetailModal()" class="text-gray-400 hover:text-gray-600 bg-gray-50 rounded-full p-2 hover:bg-gray-200 transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="text-sm" id="detailModalBody"></div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <button onclick="closeLogbookDetailModal()" class="w-full bg-[#f1f5f9] text-[#64748b] font-bold py-2.5 rounded-xl hover:bg-gray-200 transition-colors">Tutup</button>
            </div>
        </div>
    </div>
    <script>
        function openLogbookDetail(btn) {
            const htmlContent = btn.nextElementSibling.innerHTML;
            document.getElementById('detailModalBody').innerHTML = htmlContent;
            const modal = document.getElementById('logbookDetailModal');
            const content = document.getElementById('logbookDetailModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => { modal.classList.remove('opacity-0'); content.classList.remove('scale-95'); }, 10);
        }
        function closeLogbookDetailModal() {
            const modal = document.getElementById('logbookDetailModal');
            const content = document.getElementById('logbookDetailModalContent');
            modal.classList.add('opacity-0'); content.classList.add('scale-95');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }

        /* Delete Modal JS */
        let currentDeleteForm = null;

        function confirmDeleteLogbook(btn) {
            currentDeleteForm = btn.closest('form');
            const modal = document.getElementById('deleteLogbookModal');
            const content = document.getElementById('deleteLogbookModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => { modal.classList.remove('opacity-0'); content.classList.remove('scale-95'); }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteLogbookModal');
            const content = document.getElementById('deleteLogbookModalContent');
            modal.classList.add('opacity-0'); content.classList.add('scale-95');
            setTimeout(() => { modal.classList.add('hidden'); currentDeleteForm = null; }, 300);
        }

        document.getElementById('confirmDeleteBtn')?.addEventListener('click', function() {
            if (currentDeleteForm) {
                currentDeleteForm.submit();
            }
        });
    </script>

    <!-- Delete Confirmation Modal -->
    <div id="deleteLogbookModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm transition-opacity opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 transform scale-95 transition-transform duration-300" id="deleteLogbookModalContent">
            <div class="flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Aktivitas?</h3>
                <p class="text-sm text-gray-500 mb-6 w-11/12 mx-auto">Apakah Anda yakin ingin menghapus data logbook ini? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex gap-3 w-full mt-2">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                    <button type="button" id="confirmDeleteBtn" class="flex-1 px-4 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 shadow-sm shadow-red-200 transition-all">Yakin, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</x-talent.layout>
