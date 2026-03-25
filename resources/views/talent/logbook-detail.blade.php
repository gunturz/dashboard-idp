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
        </style>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 pt-4 pb-6 fade-up">

        {{-- Back Link --}}
        <div class="mb-2">
            <a href="{{ route('talent.dashboard') }}"
                class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-[#0d9488] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
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
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Mentor</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Tema</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Tanggal</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Lokasi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Aktivitas</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Deskripsi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Dokumentasi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Status</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center min-w-[150px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($exposureData as $data)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap border-r border-gray-100">{{ $data['mentor'] }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100">{{ $data['tema'] }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100 text-left">{{ $data['lokasi'] }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100 text-left">{{ $data['aktivitas'] }}</td>
                                <td class="px-6 py-4 text-gray-500 border-r border-gray-100 text-left">
                                    {{ $data['deskripsi'] ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-emerald-600 font-medium border-r border-gray-100">
                                    @if(!empty($data['file_paths']))
                                        <div class="flex flex-col gap-1">
                                            @foreach($data['file_paths'] as $fi => $fp)
                                            <a href="{{ asset('storage/' . $fp) }}" target="_blank"
                                                class="flex items-center gap-1 px-2 py-1 rounded-md text-xs border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition-colors max-w-[160px]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                <span class="truncate" title="{{ $data['file_names'][$fi] ?? 'Dokumen' }}">{{ \Illuminate\Support\Str::limit($data['file_names'][$fi] ?? 'Dokumen', 18) }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1 px-2 py-1 rounded-md text-xs border border-gray-200 text-gray-400 max-w-[160px]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            Tidak ada
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-left">
                                    @if($data['status'] === 'Approve')
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Approve
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 font-bold px-3 py-1 rounded-full text-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                            {{ $data['status'] }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-l border-gray-100">
                                    <div class="flex items-center justify-center gap-3">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('talent.idp_monitoring.edit', $data['id']) }}" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        {{-- Delete Button --}}
                                        <form action="{{ route('talent.idp_monitoring.destroy', $data['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data logbook ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus">
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
                                <td colspan="9" class="px-6 py-8 text-left text-gray-500">Belum ada aktivitas Exposure yang dicatat.</td>
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
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Mentor</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Tema</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Tanggal</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Lokasi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Deskripsi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Action Plan</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Dokumentasi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Status</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center min-w-[150px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($mentoringData as $data)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap border-r border-gray-100">{{ $data['mentor'] }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100">{{ $data['tema'] }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100 text-left">{{ $data['lokasi'] }}</td>
                                <td class="px-6 py-4 text-gray-500 border-r border-gray-100 text-left">
                                    {{ $data['deskripsi'] ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-medium border-r border-gray-100">
                                    {{ $data['action_plan'] ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-emerald-600 font-medium border-r border-gray-100">
                                    @if(!empty($data['file_paths']))
                                        <div class="flex flex-col gap-1">
                                            @foreach($data['file_paths'] as $fi => $fp)
                                            <a href="{{ asset('storage/' . $fp) }}" target="_blank"
                                                class="flex items-center gap-1 px-2 py-1 rounded-md text-xs border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition-colors max-w-[160px]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                <span class="truncate" title="{{ $data['file_names'][$fi] ?? 'Dokumen' }}">{{ \Illuminate\Support\Str::limit($data['file_names'][$fi] ?? 'Dokumen', 18) }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1 px-2 py-1 rounded-md text-xs border border-gray-200 text-gray-400 max-w-[160px]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            Tidak ada
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-left">
                                    @if($data['status'] === 'Approve')
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Approve
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 font-bold px-3 py-1 rounded-full text-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                            {{ $data['status'] }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-l border-gray-100">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('talent.idp_monitoring.edit', $data['id']) }}" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('talent.idp_monitoring.destroy', $data['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data logbook ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus">
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
                                <td colspan="9" class="px-6 py-8 text-left text-gray-500">Belum ada aktivitas Mentoring yang dicatat.</td>
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
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Sumber</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Tema</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Tanggal</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Platform</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Dokumentasi</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-left min-w-[220px]">Status</th>
                                <th class="px-6 py-4 font-bold text-[#3d4f62] whitespace-nowrap text-center min-w-[150px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($learningData as $data)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap border-r border-gray-100">{{ $data['sumber'] }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100">{{ $data['tema'] }}</td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap border-r border-gray-100">{{ date('d M Y', strtotime($data['tanggal'])) }}</td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100 text-left">{{ $data['platform'] }}</td>
                                <td class="px-6 py-4 text-emerald-600 font-medium border-r border-gray-100">
                                    @if(!empty($data['file_paths']))
                                        <div class="flex flex-col gap-1">
                                            @foreach($data['file_paths'] as $fi => $fp)
                                            <a href="{{ asset('storage/' . $fp) }}" target="_blank"
                                                class="flex items-center gap-1 px-2 py-1 rounded-md text-xs border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition-colors max-w-[160px]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                <span class="truncate" title="{{ $data['file_names'][$fi] ?? 'Dokumen' }}">{{ \Illuminate\Support\Str::limit($data['file_names'][$fi] ?? 'Dokumen', 18) }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1 px-2 py-1 rounded-md text-xs border border-gray-200 text-gray-400 max-w-[160px]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            Tidak ada
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-left">
                                    @if($data['status'] === 'Approve')
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Approve
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-orange-500 font-bold px-3 py-1 rounded-full text-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                                            {{ $data['status'] }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-l border-gray-100">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('talent.idp_monitoring.edit', $data['id']) }}" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('talent.idp_monitoring.destroy', $data['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data logbook ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus">
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

    </x-talent.layout>
