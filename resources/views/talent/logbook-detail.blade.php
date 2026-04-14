<x-talent.layout title="LogBook Detail – Individual Development Plan" :user="$user" :notifications="$notifications">
    <x-slot name="styles">
        <style>
            .custom-scrollbar::-webkit-scrollbar { height: 8px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #0d9488; border-radius: 10px; border: 2px solid #f8fafc; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #0f766e; }
            @media (max-width: 767px) {
                .custom-scrollbar { max-width: calc(100vw - 1.5rem); }
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

    <div class="w-full px-3 md:px-6 pt-4 pb-6 fade-up">

        {{-- Back Link --}}
        <div class="mb-5">
            <a href="{{ route('talent.dashboard') }}"
                class="px-4 py-2 border border-[#e2e8f0] rounded-lg bg-white text-[#475569] font-medium text-[0.875rem] flex items-center gap-2 transition-all duration-200 hover:bg-[#f8fafc] hover:border-[#cbd5e1] w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
                <span class="text-[#2e3746]">Kembali</span>
            </a>
        </div>

        <div class="flex items-center gap-3 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
            </svg>
            <h1 class="text-2xl font-bold text-[#2e3746]">LogBook</h1>
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
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exposureData as $data)
                        <tr>
                            <td class="text-center font-medium">{{ $data['mentor'] }}</td>
                            <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($data['tema'], 35) }}</td>
                            <td class="text-center whitespace-nowrap">{{ $data['tanggal_update'] ? date('d F Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                            <td class="text-center whitespace-nowrap">{{ date('d F Y', strtotime($data['tanggal'])) }}</td>
                            <td class="text-center whitespace-nowrap w-32">
                                @if(in_array($data['status'], ['Approve', 'Approved']))
                                    <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $data['status'] ?: 'Pending' }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('talent.logbook.item', $data['id']) }}" class="flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> Detail
                                    </a>
                                    <a href="{{ optional($user->promotion_plan)->is_locked ? '#' : route('talent.idp_monitoring.edit', $data['id']) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-blue-100 transition-colors' }}" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('talent.idp_monitoring.destroy', $data['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="{{ optional($user->promotion_plan)->is_locked ? 'return false;' : 'confirmDeleteLogbook(this)' }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-red-50 text-red-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-100 transition-colors' }}" title="Hapus" {{ optional($user->promotion_plan)->is_locked ? 'disabled' : '' }}>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas Exposure yang dicatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mentoringData as $data)
                        <tr>
                            <td class="text-center font-medium">{{ $data['mentor'] }}</td>
                            <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($data['tema'], 35) }}</td>
                            <td class="text-center whitespace-nowrap">{{ $data['tanggal_update'] ? date('d F Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                            <td class="text-center whitespace-nowrap">{{ date('d F Y', strtotime($data['tanggal'])) }}</td>
                            <td class="text-center whitespace-nowrap w-32">
                                @if(in_array($data['status'], ['Approve', 'Approved']))
                                    <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-orange-500 text-[11px] font-bold bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> {{ $data['status'] ?: 'Pending' }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('talent.logbook.item', $data['id']) }}" class="flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> Detail
                                    </a>
                                    <a href="{{ optional($user->promotion_plan)->is_locked ? '#' : route('talent.idp_monitoring.edit', $data['id']) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-blue-100 transition-colors' }}" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('talent.idp_monitoring.destroy', $data['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="{{ optional($user->promotion_plan)->is_locked ? 'return false;' : 'confirmDeleteLogbook(this)' }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-red-50 text-red-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-100 transition-colors' }}" title="Hapus" {{ optional($user->promotion_plan)->is_locked ? 'disabled' : '' }}>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas Mentoring yang dicatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($learningData as $data)
                        <tr>
                            <td class="text-center font-medium">{{ $data['sumber'] }}</td>
                            <td class="text-center font-bold text-[#1e293b] w-48">{{ \Illuminate\Support\Str::limit($data['tema'], 35) }}</td>
                            <td class="text-center whitespace-nowrap">{{ $data['tanggal_update'] ? date('d F Y', strtotime($data['tanggal_update'])) : '-' }}</td>
                            <td class="text-center whitespace-nowrap">{{ date('d F Y', strtotime($data['tanggal'])) }}</td>
                            <td class="text-center whitespace-nowrap w-32">
                                <span class="inline-flex items-center gap-1 text-green-600 text-[11px] font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Verified
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('talent.logbook.item', $data['id']) }}" class="flex items-center gap-1.5 font-bold text-xs bg-teal-50 text-teal-600 px-3 py-1.5 rounded-lg hover:bg-teal-100 transition-colors border border-teal-100" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> Detail
                                    </a>
                                    <a href="{{ optional($user->promotion_plan)->is_locked ? '#' : route('talent.idp_monitoring.edit', $data['id']) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-blue-100 transition-colors' }}" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('talent.idp_monitoring.destroy', $data['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="{{ optional($user->promotion_plan)->is_locked ? 'return false;' : 'confirmDeleteLogbook(this)' }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-red-50 text-red-500 {{ optional($user->promotion_plan)->is_locked ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-100 transition-colors' }}" title="Hapus" {{ optional($user->promotion_plan)->is_locked ? 'disabled' : '' }}>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 px-6 text-center text-gray-400">Belum ada aktivitas Learning yang dicatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

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

    <x-slot name="scripts">
        <script>
            function switchTab(tab) {
                ['exposure', 'mentoring', 'learning'].forEach(t => {
                    document.getElementById('panel-' + t).classList.add('hidden');
                    const btn = document.getElementById('tab-' + t);
                    btn.classList.remove('bg-[#2e3746]', 'text-white', 'shadow-sm');
                    btn.classList.add('text-gray-500', 'hover:text-gray-900');
                });
                document.getElementById('panel-' + tab).classList.remove('hidden');
                const activeBtn = document.getElementById('tab-' + tab);
                activeBtn.classList.remove('text-gray-500', 'hover:text-gray-900');
                activeBtn.classList.add('bg-[#2e3746]', 'text-white', 'shadow-sm');
                history.replaceState(null, null, '#' + tab);
            }

            document.addEventListener('DOMContentLoaded', function () {
                const hash = window.location.hash.replace('#', '');
                if (['exposure', 'mentoring', 'learning'].includes(hash)) {
                    switchTab(hash);
                }
            });

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
                if (currentDeleteForm) { currentDeleteForm.submit(); }
            });
        </script>
    </x-slot>
</x-talent.layout>
