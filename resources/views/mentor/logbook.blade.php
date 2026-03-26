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
        </style>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        {{-- Talent Selector --}}
        <div class="mb-6 flex items-center gap-6">
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
        <div class="flex items-center gap-5 mb-10">
            <img src="{{ $selectedTalent->foto ? asset('storage/' . $selectedTalent->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($selectedTalent->nama) . '&background=random' }}" 
                 class="w-[72px] h-[72px] rounded-full object-cover shadow-sm border-2 border-slate-50">
            <div>
                <h3 class="font-bold text-[22px] text-slate-800 leading-tight mb-0.5">{{ $selectedTalent->nama }}</h3>
                <p class="text-[14px] text-gray-500 font-medium">
                    {{ optional($selectedTalent->position)->position_name ?? '-' }} | <span class="italic">{{ optional($selectedTalent->department)->nama_department ?? '-' }}</span>
                </p>
            </div>
        </div>

        {{-- Exposure Section --}}
        <div class="mb-12">
            <div class="bg-[#2e3746] text-white font-semibold py-2 px-8 rounded-full inline-block mb-4 shadow-sm text-[15px]">
                Exposure
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar pb-2">
                    <table class="w-full text-[13px] text-left">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Mentor</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Tema</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Tanggal</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Lokasi</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Aktivitas</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Deskripsi</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Dokumentasi</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($exposureData as $data)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-5 py-3 font-medium text-gray-700 border-r border-gray-100 text-center">{{ $data['mentor'] }}</td>
                                <td class="px-5 py-3 text-gray-700 font-semibold border-r border-gray-100 text-center">{{ $data['tema'] }}</td>
                                <td class="px-5 py-3 text-gray-500 border-r border-gray-100 text-center whitespace-nowrap">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                                <td class="px-5 py-3 text-gray-600 border-r border-gray-100 text-center">{{ $data['lokasi'] }}</td>
                                <td class="px-5 py-3 text-gray-600 border-r border-gray-100 text-center">{{ $data['aktivitas'] }}</td>
                                <td class="px-5 py-3 text-gray-500 border-r border-gray-100 min-w-[150px]">{{ $data['deskripsi'] ?: '-' }}</td>
                                <td class="px-5 py-3 border-r border-gray-100">
                                    @if(!empty($data['file_paths']))
                                        <div class="flex flex-col gap-1 items-center">
                                            @foreach($data['file_paths'] as $fi => $fp)
                                            <a href="{{ asset('storage/' . $fp) }}" target="_blank"
                                                class="flex items-center gap-1.5 px-2 py-1 rounded bg-[#0d9488]/10 text-[#0d9488] font-semibold text-[11px] hover:bg-[#0d9488] hover:text-white transition-colors max-w-[160px] truncate">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                <span class="truncate" title="{{ $data['file_names'][$fi] ?? 'Dokumen' }}">{{ \Illuminate\Support\Str::limit($data['file_names'][$fi] ?? 'Dokumen', 15) }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center text-gray-400 text-xs">-</div>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-center align-middle whitespace-nowrap min-w-[140px]">
                                    @if($data['status'] === 'Pending')
                                        <button onclick="openStatusModal({{ $data['id'] }}, '{{ addslashes($selectedTalent->nama) }}')" class="bg-[#eab308] text-white font-bold px-6 py-2 rounded-full text-xs hover:bg-[#ca8a04] transition-colors shadow-sm w-full">
                                            Pilih Aksi
                                        </button>
                                    @else
                                        <span class="inline-flex items-center justify-center gap-1 border {{ in_array($data['status'], ['Approve', 'Approved']) ? 'border-green-300 text-green-500' : 'border-red-300 text-red-500' }} font-bold px-4 py-2 rounded-full text-[11px] w-full">
                                            {{ in_array($data['status'], ['Approve', 'Approved']) ? 'Approved' : 'Rejected' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada aktivitas Exposure diproses.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Mentoring Section --}}
        <div class="mb-12">
            <div class="bg-[#2e3746] text-white font-semibold py-2 px-8 rounded-full inline-block mb-4 shadow-sm text-[15px]">
                Mentoring
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar pb-2">
                    <table class="w-full text-[13px] text-left">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Mentor</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Tema</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Tanggal</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Lokasi</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Deskripsi</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Action Plan</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Dokumentasi</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Feedback</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($mentoringData as $data)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-5 py-3 font-medium text-gray-700 border-r border-gray-100 text-center">{{ $data['mentor'] }}</td>
                                <td class="px-5 py-3 text-gray-700 font-semibold border-r border-gray-100 text-center">{{ $data['tema'] }}</td>
                                <td class="px-5 py-3 text-gray-500 border-r border-gray-100 text-center whitespace-nowrap">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                                <td class="px-5 py-3 text-gray-600 border-r border-gray-100 text-center">{{ $data['lokasi'] }}</td>
                                <td class="px-5 py-3 text-gray-500 border-r border-gray-100 min-w-[150px]">{{ $data['deskripsi'] ?: '-' }}</td>
                                <td class="px-5 py-3 text-gray-500 border-r border-gray-100 min-w-[150px]">{{ $data['action_plan'] ?: '-' }}</td>
                                <td class="px-5 py-3 border-r border-gray-100">
                                    @if(!empty($data['file_paths']))
                                        <div class="flex flex-col gap-1 items-center">
                                            @foreach($data['file_paths'] as $fi => $fp)
                                            <a href="{{ asset('storage/' . $fp) }}" target="_blank"
                                                class="flex items-center gap-1.5 px-2 py-1 rounded bg-[#0d9488]/10 text-[#0d9488] font-semibold text-[11px] hover:bg-[#0d9488] hover:text-white transition-colors max-w-[160px] truncate">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                <span class="truncate" title="{{ $data['file_names'][$fi] ?? 'Dokumen' }}">{{ \Illuminate\Support\Str::limit($data['file_names'][$fi] ?? 'Dokumen', 15) }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center text-gray-400 text-xs">-</div>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-center align-middle whitespace-nowrap min-w-[140px]">
                                    @if($data['status'] === 'Pending')
                                        <div class="relative w-full dropdown-container">
                                            <button onclick="toggleActionDropdown(this)" class="bg-[#eab308] text-white font-bold px-6 py-2 rounded-full text-xs hover:bg-[#ca8a04] transition-colors shadow-sm w-full">
                                                Pilih Aksi
                                            </button>
                                            <div class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden action-menu">
                                                <form action="{{ route('mentor.logbook.update_status', $data['id']) }}" method="POST">
                                                    @csrf
                                                    <button name="status" value="Approve" class="w-full text-center px-4 py-2 text-[11px] text-green-600 font-bold hover:bg-green-50">Approve</button>
                                                </form>
                                                <div class="border-t border-gray-100"></div>
                                                <form action="{{ route('mentor.logbook.update_status', $data['id']) }}" method="POST">
                                                    @csrf
                                                    <button name="status" value="Reject" class="w-full text-center px-4 py-2 text-[11px] text-red-600 font-bold hover:bg-red-50">Reject</button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center justify-center gap-1 border {{ in_array($data['status'], ['Approve', 'Approved']) ? 'border-green-300 text-green-500' : 'border-red-300 text-red-500' }} font-bold px-4 py-2 rounded-full text-[11px] w-full">
                                            {{ in_array($data['status'], ['Approve', 'Approved']) ? 'Approved' : 'Rejected' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada aktivitas Mentoring diproses.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Learning Section --}}
        <div>
            <div class="bg-[#2e3746] text-white font-semibold py-2 px-8 rounded-full inline-block mb-4 shadow-sm text-[15px]">
                Learning
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar pb-2">
                    <table class="w-full text-[13px] text-left">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Sumber</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Tema</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Tanggal</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Platform</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Aktivitas</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Deskripsi</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Dokumentasi</th>
                                <th class="px-5 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center">Feedback</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($learningData as $data)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-5 py-3 font-medium text-gray-700 border-r border-gray-100 text-center">{{ $data['sumber'] }}</td>
                                <td class="px-5 py-3 text-gray-700 font-semibold border-r border-gray-100 text-center">{{ $data['tema'] }}</td>
                                <td class="px-5 py-3 text-gray-500 border-r border-gray-100 text-center whitespace-nowrap">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                                <td class="px-5 py-3 text-gray-600 border-r border-gray-100 text-center">{{ $data['platform'] }}</td>
                                <td class="px-5 py-3 text-gray-600 border-r border-gray-100 text-center">{{ $data['aktivitas'] ?? '-' }}</td>
                                <td class="px-5 py-3 text-gray-500 border-r border-gray-100 min-w-[150px]">{{ $data['deskripsi'] ?? '-' }}</td>
                                <td class="px-5 py-3 border-r border-gray-100">
                                    @if(!empty($data['file_paths']))
                                        <div class="flex flex-col gap-1 items-center">
                                            @foreach($data['file_paths'] as $fi => $fp)
                                            <a href="{{ asset('storage/' . $fp) }}" target="_blank"
                                                class="flex items-center gap-1.5 px-2 py-1 rounded bg-[#0d9488]/10 text-[#0d9488] font-semibold text-[11px] hover:bg-[#0d9488] hover:text-white transition-colors max-w-[160px] truncate">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                <span class="truncate" title="{{ $data['file_names'][$fi] ?? 'Dokumen' }}">{{ \Illuminate\Support\Str::limit($data['file_names'][$fi] ?? 'Dokumen', 15) }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center text-gray-400 text-xs">-</div>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-center align-middle whitespace-nowrap min-w-[140px]">
                                    @if($data['status'] === 'Pending')
                                        <div class="relative w-full dropdown-container">
                                            <button onclick="toggleActionDropdown(this)" class="bg-[#eab308] text-white font-bold px-6 py-2 rounded-full text-xs hover:bg-[#ca8a04] transition-colors shadow-sm w-full">
                                                Pilih Aksi
                                            </button>
                                            <div class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden action-menu">
                                                <form action="{{ route('mentor.logbook.update_status', $data['id']) }}" method="POST">
                                                    @csrf
                                                    <button name="status" value="Approve" class="w-full text-center px-4 py-2 text-[11px] text-green-600 font-bold hover:bg-green-50">Approve</button>
                                                </form>
                                                <div class="border-t border-gray-100"></div>
                                                <form action="{{ route('mentor.logbook.update_status', $data['id']) }}" method="POST">
                                                    @csrf
                                                    <button name="status" value="Reject" class="w-full text-center px-4 py-2 text-[11px] text-red-600 font-bold hover:bg-red-50">Reject</button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center justify-center gap-1 border {{ in_array($data['status'], ['Approve', 'Approved']) ? 'border-green-300 text-green-500' : 'border-red-300 text-red-500' }} font-bold px-4 py-2 rounded-full text-[11px] w-full">
                                            {{ in_array($data['status'], ['Approve', 'Approved']) ? 'Approved' : 'Rejected' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada aktivitas Learning diproses.</td></tr>
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
</x-mentor.layout>
