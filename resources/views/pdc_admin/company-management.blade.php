<x-pdc_admin.layout title="Company Management – PDC Admin" :user="$user">
    <x-slot name="styles">
        <style>
            .company-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: white;
                border: 1.5px solid #e2e8f0;
                border-radius: 14px;
                padding: 16px 24px;
                transition: box-shadow 0.2s, transform 0.1s;
            }

            .company-row:hover {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            }

            .company-name {
                font-size: 1rem;
                font-weight: 700;
                color: #2e3746;
            }

            @media (max-width: 640px) {
                .company-row {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 16px;
                    padding: 20px;
                }

                .toolbar-wrap {
                    flex-direction: column;
                    align-items: stretch;
                }

                .search-container {
                    width: 100% !important;
                }

                .company-actions {
                    width: 100%;
                    justify-content: space-between;
                }
            }
        </style>
    </x-slot>

    <div class="flex items-center gap-3 mb-8 animate-title">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2e3746]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        <h2 class="text-2xl font-black text-[#2e3746]">Company Management</h2>
    </div>

    {{-- Main Card --}}
    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-sm p-4 sm:p-8 max-w-6xl mx-auto mb-10">
        <h3 class="text-lg font-bold text-[#2e3746] mb-6">Daftar Perusahaan</h3>

        {{-- Toolbar --}}
        <div class="flex toolbar-wrap items-center justify-between gap-4 mb-8">
            <div class="relative search-container w-80">
                <input type="text" id="searchCompany" onkeyup="filterCompanies()"
                    placeholder="Cari nama perusahaan.."
                    class="w-full border-2 border-[#14b8a6] rounded-xl py-2.5 pl-4 pr-10 text-sm outline-none focus:ring-1 focus:ring-[#14b8a6]">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#14b8a6]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <button onclick="openAddModal()"
                class="flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-[#2e3746] hover:bg-[#1f2937] rounded-xl transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Perusahaan
            </button>
        </div>

        {{-- Company List --}}
        <div class="space-y-4" id="companyList">
            @forelse($companies as $company)
                <div class="company-row company-item">
                    <span class="company-name">{{ $company->nama_company }}</span>
                    <div class="flex items-center gap-2 company-actions">
                        {{-- Departemen button --}}
                        <a href="{{ route('pdc_admin.company.departments', $company->id) }}"
                            class="px-4 py-2 text-sm font-semibold text-white bg-[#14b8a6] hover:bg-[#0d9488] rounded-xl transition-colors shadow-sm text-center flex-1 sm:flex-none whitespace-nowrap">
                            Departemen
                        </a>

                        {{-- Divider --}}
                        <div class="w-[1.5px] h-9 bg-gray-200 mx-1 divider-line"></div>

                        {{-- Edit button --}}
                        <button type="button"
                            onclick="openEditModal({{ $company->id }}, '{{ addslashes($company->nama_company) }}')"
                            class="flex items-center justify-center w-10 h-10 bg-[#F4F1EA] hover:bg-[#eadecc] border border-[#e5e1d8] rounded-xl transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#475569]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>

                        {{-- Delete button --}}
                        <button type="button"
                            onclick="openDeleteModal({{ $company->id }}, '{{ addslashes($company->nama_company) }}')"
                            class="flex items-center justify-center w-10 h-10 bg-[#EF4444] hover:bg-[#dc2626] rounded-xl transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400 text-sm py-8">Belum ada perusahaan.</p>
            @endforelse
        </div>
    </div>

    {{-- ===================== MODALS ===================== --}}

    {{-- Add Modal --}}
    <div id="addModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl p-8">
            <h3 class="text-xl font-black text-[#2e3746] mb-1">Tambah Perusahaan</h3>
            <p class="text-sm text-gray-400 mb-6">Masukkan nama perusahaan baru</p>
            <form method="POST" action="{{ route('pdc_admin.company.store') }}">
                @csrf
                <input type="text" name="nama_company" placeholder="Nama perusahaan"
                    class="w-full border border-gray-200 rounded-xl py-3 px-4 text-sm text-[#2e3746] placeholder-gray-400 outline-none focus:ring-2 focus:ring-[#14b8a6] mb-6">
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('addModal')"
                        class="flex-1 py-3 text-sm font-semibold text-gray-500 bg-[#F4F1EA] hover:bg-[#eadecc] rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 text-sm font-bold text-white bg-[#22c55e] hover:bg-[#16a34a] rounded-xl transition-colors shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl p-8">
            <h3 class="text-xl font-black text-[#2e3746] mb-1">Edit Perusahaan</h3>
            <p class="text-sm text-gray-400 mb-6">Ganti nama perusahaan</p>
            <form method="POST" id="editForm" action="">
                @csrf
                @method('PUT')
                <input type="text" name="nama_company" id="editInput" placeholder="Nama perusahaan"
                    class="w-full border border-gray-200 rounded-xl py-3 px-4 text-sm text-[#2e3746] placeholder-gray-400 outline-none focus:ring-2 focus:ring-[#14b8a6] mb-6">
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('editModal')"
                        class="flex-1 py-3 text-sm font-semibold text-gray-500 bg-[#F4F1EA] hover:bg-[#eadecc] rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 text-sm font-bold text-white bg-[#22c55e] hover:bg-[#16a34a] rounded-xl transition-colors shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-sm shadow-2xl p-8 text-center">
            <div class="w-16 h-16 rounded-full bg-[#EF4444] flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="text-xl font-black text-gray-900 mb-2">Hapus Perusahaan?</h3>
            <p class="text-gray-500 text-sm mb-7" id="deleteDesc"></p>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('deleteModal')"
                        class="flex-1 py-3 text-sm font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 text-sm font-bold text-white bg-[#EF4444] hover:bg-[#dc2626] rounded-xl transition-colors shadow-sm">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    </div>

    <x-slot name="scripts">
        <script>
            // --- Utility ---
            function openModal(id) {
                const m = document.getElementById(id);
                m.classList.remove('hidden');
                m.style.display = 'flex';
            }
            function closeModal(id) {
                const m = document.getElementById(id);
                m.style.display = 'none';
                m.classList.add('hidden');
            }

            // --- Add ---
            function openAddModal() { openModal('addModal'); }

            // --- Edit ---
            function openEditModal(companyId, companyName) {
                document.getElementById('editInput').value = companyName;
                document.getElementById('editForm').action = '/pdc-admin/company/' + companyId;
                openModal('editModal');
            }

            // --- Delete ---
            function openDeleteModal(companyId, companyName) {
                document.getElementById('deleteDesc').textContent =
                    'Perusahaan "' + companyName + '" akan dihapus secara permanen.';
                document.getElementById('deleteForm').action = '/pdc-admin/company/' + companyId;
                openModal('deleteModal');
            }



            // --- Search filter ---
            function filterCompanies() {
                const q = document.getElementById('searchCompany').value.toLowerCase();
                document.querySelectorAll('.company-item').forEach(row => {
                    const name = row.querySelector('.company-name').innerText.toLowerCase();
                    row.style.display = name.includes(q) ? '' : 'none';
                });
            }
        </script>
    </x-slot>
</x-pdc_admin.layout>
