<x-mentor.layout title="Logbook Mentor – Individual Development Plan" :user="$user">
    <x-slot name="styles">
        <style>
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

            /* ══ MOBILE ONLY — does NOT affect desktop ══ */
            @media (max-width: 767px) {
                .custom-scrollbar { max-width: calc(100vw - 1.5rem); }
                .logbook-container { padding: 16px !important; border-radius: 12px !important; }
                .talent-selector-row { flex-direction: column !important; align-items: flex-start !important; gap: 10px !important; }
                .talent-selector-row select { font-size: 14px !important; }
                .profile-row { gap: 12px !important; margin-bottom: 24px !important; }
                .profile-row img { width: 56px !important; height: 56px !important; }
                .profile-row h3 { font-size: 18px !important; }
            }

            .log-table-container {
                background: white;
                border-radius: 16px;
                border: 1px solid #e2e8f0;
                overflow: hidden;
                position: relative;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }
            .pdc-log-table {
                width: 100%;
                border-collapse: collapse;
            }
            .pdc-log-table th {
                padding: 24px 32px;
                background: #f8fafc;
                font-weight: 800;
                color: #475569;
                font-size: 0.95rem;
                text-align: center;
                white-space: nowrap;
            }
            .pdc-log-table td {
                padding: 32px;
                color: #64748b;
                font-size: 0.9rem;
                border-top: 1px solid #f1f5f9;
            }
            .pdc-log-table tr:hover {
                background: #fafafa;
            }
        </style>
    </x-slot>

    <div class="logbook-container w-full">
        {{-- Talent Selector --}}
        <div class="mb-6 flex items-center gap-6 talent-selector-row">
            <label class="text-[15px] font-bold text-gray-700 whitespace-nowrap">Talent</label>
            <div class="relative w-full max-w-lg">
                <select onchange="window.location.href='?talent_id='+this.value" class="w-full appearance-none border border-[#0d9488] rounded-lg py-2.5 px-4 text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-[#0d9488]/30 transition-shadow">
                    @forelse($mentees as $m)
                        <option value="{{ $m->id }}" {{ ($selectedTalent && $selectedTalent->id == $m->id) ? 'selected' : '' }}>
                            {{ $m->nama }}
                        </option>
                    @empty
                        <option value="">Belum ada mentee</option>
                    @endforelse
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#0d9488]">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <hr class="border-gray-100 mb-8">

        {{-- Talent Profile --}}
        @if($selectedTalent)
        <div class="flex items-center gap-5 mb-10 profile-row">
            <img src="{{ $selectedTalent->foto ? asset('storage/' . $selectedTalent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($selectedTalent->nama) . '&background=random' }}" 
                 class="w-[72px] h-[72px] rounded-full object-cover shadow-sm border-2 border-slate-50">
            <div>
                <h3 class="font-bold text-[22px] text-slate-800 leading-tight mb-0.5">{{ $selectedTalent->nama }}</h3>
                <p class="text-[14px] text-gray-500 font-medium">
                    {{ optional($selectedTalent->position)->position_name ?? '-' }} | <span class="italic">{{ optional($selectedTalent->department)->nama_department ?? '-' }}</span>
                </p>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="flex gap-2 p-1.5 bg-gray-100 rounded-full w-fit mb-8 shadow-inner overflow-x-auto">
            <button id="tab-exposure" onclick="switchTab('exposure')" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 bg-[#2e3746] text-white shadow-sm whitespace-nowrap">Exposure</button>
            <button id="tab-mentoring" onclick="switchTab('mentoring')" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 text-gray-500 hover:text-gray-900 whitespace-nowrap">Mentoring</button>
            <button id="tab-learning" onclick="switchTab('learning')" class="px-6 py-2.5 text-sm font-bold rounded-full transition-all duration-200 text-gray-500 hover:text-gray-900 whitespace-nowrap">Learning</button>
        </div>

        {{-- Exposure Section --}}
        <div id="panel-exposure" class="mb-12">
            <div class="log-table-container custom-scrollbar overflow-x-auto">
                <table class="pdc-log-table w-full">
                    <thead>
                        <tr>
                            <th>Mentor</th>
                            <th>Tema</th>
                            <th>Tanggal Pengiriman/Update</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exposureData as $data)
                        <tr>
                            <td class="text-center font-medium">{{ $data['mentor'] }}</td>
                            <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($data['tema'], 35) }}</td>
                            <td class="text-center whitespace-nowrap">{{ $data['tanggal_update'] ? date('d M Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                            <td class="text-center whitespace-nowrap">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                            <td class="text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('mentor.logbook.detail', $data['id']) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-teal-50 text-teal-600 hover:bg-teal-100 transition-colors" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                        <div class="hidden logbook-detail-html">
                                            <div class="space-y-3 text-left">
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Mentor</span><div class="text-[14px] text-gray-800">{{ $data['mentor'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tema</span><div class="text-[14px] text-gray-800">{{ $data['tema'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal</span><div class="text-[14px] text-gray-800">{{ date('d M Y', strtotime($data['tanggal'])) }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Lokasi</span><div class="text-[14px] text-gray-800">{{ $data['lokasi'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Aktivitas</span><div class="text-[14px] text-gray-800">{{ $data['aktivitas'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Deskripsi</span><div class="text-[14px] text-gray-800">{{ $data['deskripsi'] ?: '-' }}</div></div>
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
                                        @if($data['status'] === 'Pending')
                                            <button onclick="openStatusModal({{ $data['id'] }}, '{{ addslashes($selectedTalent->nama) }}')" class="bg-[#eab308] text-white font-bold px-5 py-2 rounded-full text-[11px] hover:bg-[#ca8a04] transition-colors shadow-sm">
                                                Pilih Aksi
                                            </button>
                                        @else
                                            <span class="inline-flex items-center justify-center border {{ in_array($data['status'], ['Approve', 'Approved']) ? 'border-green-300 text-green-500 bg-green-50' : 'border-red-300 text-red-500 bg-red-50' }} font-bold px-5 py-1.5 rounded-full text-[11px]">
                                                {{ in_array($data['status'], ['Approve', 'Approved']) ? 'Approved' : 'Rejected' }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada aktivitas Exposure diproses.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Mentoring Section --}}
        <div id="panel-mentoring" class="mb-12 hidden">
            <div class="log-table-container custom-scrollbar overflow-x-auto">
                <table class="pdc-log-table w-full">
                    <thead>
                        <tr>
                            <th>Mentor</th>
                            <th>Tema</th>
                            <th>Tanggal Pengiriman/Update</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mentoringData as $data)
                        <tr>
                            <td class="text-center font-medium">{{ $data['mentor'] }}</td>
                            <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($data['tema'], 35) }}</td>
                            <td class="text-center whitespace-nowrap">{{ $data['tanggal_update'] ? date('d M Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                            <td class="text-center whitespace-nowrap">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                            <td class="text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('mentor.logbook.detail', $data['id']) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-teal-50 text-teal-600 hover:bg-teal-100 transition-colors" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                        <div class="hidden logbook-detail-html">
                                            <div class="space-y-3 text-left">
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Mentor</span><div class="text-[14px] text-gray-800">{{ $data['mentor'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tema</span><div class="text-[14px] text-gray-800">{{ $data['tema'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal</span><div class="text-[14px] text-gray-800">{{ date('d M Y', strtotime($data['tanggal'])) }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Lokasi</span><div class="text-[14px] text-gray-800">{{ $data['lokasi'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Deskripsi</span><div class="text-[14px] text-gray-800">{{ $data['deskripsi'] ?: '-' }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Action Plan</span><div class="text-[14px] text-gray-800">{{ $data['action_plan'] ?: '-' }}</div></div>
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
                                        @if($data['status'] === 'Pending')
                                            <button onclick="openStatusModal({{ $data['id'] }}, '{{ addslashes($selectedTalent->nama) }}')" class="bg-[#eab308] text-white font-bold px-5 py-2 rounded-full text-[11px] hover:bg-[#ca8a04] transition-colors shadow-sm">
                                                Pilih Aksi
                                            </button>
                                        @else
                                            <span class="inline-flex items-center justify-center border {{ in_array($data['status'], ['Approve', 'Approved']) ? 'border-green-300 text-green-500 bg-green-50' : 'border-red-300 text-red-500 bg-red-50' }} font-bold px-5 py-1.5 rounded-full text-[11px]">
                                                {{ in_array($data['status'], ['Approve', 'Approved']) ? 'Approved' : 'Rejected' }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada aktivitas Mentoring diproses.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Learning Section --}}
        <div id="panel-learning" class="mb-12 hidden">
            <div class="log-table-container custom-scrollbar overflow-x-auto">
                <table class="pdc-log-table w-full">
                    <thead>
                        <tr>
                            <th>Sumber</th>
                            <th>Tema</th>
                            <th>Tanggal Pengiriman/Update</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($learningData as $data)
                        <tr>
                            <td class="text-center font-medium">{{ $data['sumber'] ?: '-' }}</td>
                            <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($data['tema'], 35) ?: '-' }}</td>
                            <td class="text-center whitespace-nowrap">{{ $data['tanggal_update'] ? date('d M Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                            <td class="text-center whitespace-nowrap">{{ $data['tanggal'] ? date('d M Y', strtotime($data['tanggal'])) : '-' }}</td>
                            <td class="text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('mentor.logbook.detail', $data['id']) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-teal-50 text-teal-600 hover:bg-teal-100 transition-colors" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                        <div class="hidden logbook-detail-html">
                                            <div class="space-y-3 text-left">
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Sumber</span><div class="text-[14px] text-gray-800">{{ $data['sumber'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tema</span><div class="text-[14px] text-gray-800">{{ $data['tema'] }}</div></div>
                                                <div class="p-3 bg-gray-50 rounded-lg"><span class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal</span><div class="text-[14px] text-gray-800">{{ $data['tanggal'] ? date('d M Y', strtotime($data['tanggal'])) : '-' }}</div></div>
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
                                        @if($data['status'] === 'Pending')
                                            <button onclick="openStatusModal({{ $data['id'] }}, '{{ addslashes($selectedTalent->nama) }}')" class="bg-[#eab308] text-white font-bold px-5 py-2 rounded-full text-[11px] hover:bg-[#ca8a04] transition-colors shadow-sm">
                                                Pilih Aksi
                                            </button>
                                        @else
                                            <span class="inline-flex items-center justify-center border {{ in_array($data['status'], ['Approve', 'Approved']) ? 'border-green-300 text-green-500 bg-green-50' : 'border-red-300 text-red-500 bg-red-50' }} font-bold px-5 py-1.5 rounded-full text-[11px]">
                                                {{ in_array($data['status'], ['Approve', 'Approved']) ? 'Approved' : 'Rejected' }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada aktivitas Learning diproses.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        @else
        <div class="text-center py-20">
            <h3 class="text-xl font-bold text-slate-700 mb-2">Pilih Talent</h3>
            <p class="text-gray-500 text-sm">Silakan pilih talent pada menu dropdown di atas untuk melihat logbook.</p>
        </div>
        @endif

    </div>

    <!-- Modal Confirm Aksi -->
    <div id="statusModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm transition-opacity opacity-0">
        <div class="bg-white rounded-[20px] shadow-2xl w-full max-w-[360px] p-7 text-center transform scale-95 transition-transform duration-300" id="statusModalContent">
            <!-- Icon -->
            <div class="mx-auto flex h-[68px] w-[68px] items-center justify-center rounded-full bg-[#eab308] mb-5 shadow-[0_4px_12px_rgba(234,179,8,0.3)]">
                <span class="text-white font-black text-4xl leading-none -mt-1">!</span>
            </div>
            
            <!-- Title & Desc -->
            <h3 class="text-xl font-bold text-[#1e293b] mb-2 tracking-tight">Update Status Tugas?</h3>
            <p class="text-[13px] text-gray-500 leading-relaxed mb-6 font-medium px-2">
                Pilih status untuk tugas <span id="modalTalentName" class="font-bold text-gray-700">Talent</span>. Tindakan ini akan langsung memperbarui logbook sistem.
            </p>
            
            <!-- Action Buttons -->
            <form id="statusModalForm" method="POST" action="">
                @csrf
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <button type="submit" name="status" value="Rejected" class="w-full bg-[#ef4444] text-white font-bold py-2.5 rounded-lg hover:bg-red-600 transition-colors shadow-[0_2px_8px_rgba(239,68,68,0.3)]">
                        Reject
                    </button>
                    <button type="submit" name="status" value="Approved" class="w-full bg-[#10b981] text-white font-bold py-2.5 rounded-lg hover:bg-emerald-600 transition-colors shadow-[0_2px_8px_rgba(16,185,129,0.3)]">
                        Approve
                    </button>
                </div>
            </form>
            
            <!-- Cancel -->
            <button onclick="closeStatusModal()" type="button" class="w-full bg-[#f1f5f9] text-[#64748b] font-bold py-2.5 rounded-lg hover:bg-gray-200 transition-colors">
                Batal
            </button>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            // Base URL for updating status. Route will be built dynamically.
            const baseStatusUrl = "{{ url('/mentor/logbook') }}";

            function openStatusModal(id, talentName) {
                const modal = document.getElementById('statusModal');
                const modalContent = document.getElementById('statusModalContent');
                const form = document.getElementById('statusModalForm');
                const nameSpan = document.getElementById('modalTalentName');

                // Update form action and talent name
                form.action = `${baseStatusUrl}/${id}/status`;
                nameSpan.textContent = talentName;

                // Open modal
                modal.classList.remove('hidden');
                
                // Small trick for transition rendering
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modalContent.classList.remove('scale-95');
                }, 10);
            }

            function closeStatusModal() {
                const modal = document.getElementById('statusModal');
                const modalContent = document.getElementById('statusModalContent');

                modal.classList.add('opacity-0');
                modalContent.classList.add('scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        </script>
    </x-slot>

    <!-- Modal Detail Logbook -->
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
        function switchTab(tab) {
            ['exposure', 'mentoring', 'learning'].forEach(t => {
                const panel = document.getElementById('panel-' + t);
                if (panel) panel.classList.add('hidden');
                const btn = document.getElementById('tab-' + t);
                if (btn) {
                    btn.classList.remove('bg-[#2e3746]', 'text-white', 'shadow-sm');
                    btn.classList.add('text-gray-500', 'hover:text-gray-900');
                }
            });
            const activePanel = document.getElementById('panel-' + tab);
            if (activePanel) activePanel.classList.remove('hidden');
            const activeBtn = document.getElementById('tab-' + tab);
            if (activeBtn) {
                activeBtn.classList.remove('text-gray-500', 'hover:text-gray-900');
                activeBtn.classList.add('bg-[#2e3746]', 'text-white', 'shadow-sm');
            }
            history.replaceState(null, null, '#' + tab);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const hash = window.location.hash.replace('#', '');
            if (['exposure', 'mentoring', 'learning'].includes(hash)) {
                switchTab(hash);
            }
        });
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
    </script>
</x-mentor.layout>
