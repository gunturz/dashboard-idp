<div>
    @if(session()->has('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Toolbar --}}
    <div class="flex toolbar-wrap items-center justify-between gap-4 mb-6">
        <div class="relative w-full sm:w-80">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari nama perusahaan.."
                class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#14b8a6] focus:border-transparent transition-all">
        </div>
        <button wire:click="openAddModal"
            class="flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-[#0f172a] hover:bg-[#1f2937] rounded-xl transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Perusahaan
        </button>
    </div>

    {{-- Main Card --}}
    <div class="prem-card p-4 sm:p-8 w-full mb-10">
        <h3 class="text-lg font-bold text-[#0f172a] mb-6">Daftar Perusahaan</h3>

        {{-- Loading spinner --}}
        <div wire:loading class="text-center py-6">
            <svg class="animate-spin h-5 w-5 text-[#0f172a] mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        <div wire:loading.remove class="space-y-4">
            @forelse($companies as $company)
                <div class="company-row company-item">
                    <span class="company-name">{{ $company->nama_company }}</span>
                    <div class="flex items-center gap-2 company-actions">
                        {{-- Departemen --}}
                        <a href="{{ route('pdc_admin.company.departments', $company->id) }}"
                            class="px-4 py-2 text-sm font-semibold text-white bg-[#14b8a6] hover:bg-[#0d9488] rounded-xl transition-colors shadow-sm text-center flex-1 sm:flex-none whitespace-nowrap">
                            Departemen
                        </a>

                        <div class="w-[1.5px] h-9 bg-gray-200 mx-1 divider-line"></div>

                        {{-- Edit --}}
                        <button type="button"
                            wire:click="openEditModal({{ $company->id }}, '{{ addslashes($company->nama_company) }}')"
                            class="flex items-center justify-center w-10 h-10 bg-[#F4F1EA] hover:bg-[#eadecc] border border-[#e5e1d8] rounded-xl transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#475569]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>

                        {{-- Delete --}}
                        <button type="button"
                            wire:click="openDeleteModal({{ $company->id }}, '{{ addslashes($company->nama_company) }}')"
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

    {{-- ============== MODAL TAMBAH ============== --}}
    @if($showAddModal)
        <div class="fixed inset-0 bg-black/50 z-[100] flex items-center justify-center p-4" wire:click.self="$set('showAddModal', false)">
            <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl p-8">
                <h3 class="text-xl font-black text-[#0f172a] mb-1">Tambah Perusahaan</h3>
                <p class="text-sm text-gray-400 mb-6">Masukkan nama perusahaan baru</p>
                <form wire:submit.prevent="addCompany">
                    <input type="text" wire:model.defer="newCompanyName" placeholder="Nama perusahaan"
                        class="w-full border border-gray-200 rounded-xl py-3 px-4 text-sm text-[#0f172a] placeholder-gray-400 outline-none focus:ring-2 focus:ring-[#14b8a6] mb-1">
                    @error('newCompanyName')<p class="text-sm text-red-500 mb-4">{{ $message }}</p>@enderror
                    <div class="flex gap-3 mt-5">
                        <button type="button" wire:click="$set('showAddModal', false)"
                            class="flex-1 py-3 text-sm font-semibold text-gray-500 bg-[#F4F1EA] hover:bg-[#eadecc] rounded-xl transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 py-3 text-sm font-bold text-white bg-[#14b8a6] hover:bg-[#0d9488] rounded-xl transition-colors shadow-sm">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ============== MODAL EDIT ============== --}}
    @if($showEditModal)
        <div class="fixed inset-0 bg-black/50 z-[100] flex items-center justify-center p-4" wire:click.self="$set('showEditModal', false)">
            <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl p-8">
                <h3 class="text-xl font-black text-[#0f172a] mb-1">Edit Perusahaan</h3>
                <p class="text-sm text-gray-400 mb-6">Ganti nama perusahaan</p>
                <form wire:submit.prevent="updateCompany">
                    <input type="text" wire:model.defer="editingCompanyName" placeholder="Nama perusahaan"
                        class="w-full border border-gray-200 rounded-xl py-3 px-4 text-sm text-[#0f172a] placeholder-gray-400 outline-none focus:ring-2 focus:ring-[#14b8a6] mb-1">
                    @error('editingCompanyName')<p class="text-sm text-red-500 mb-4">{{ $message }}</p>@enderror
                    <div class="flex gap-3 mt-5">
                        <button type="button" wire:click="$set('showEditModal', false)"
                            class="flex-1 py-3 text-sm font-semibold text-gray-500 bg-[#F4F1EA] hover:bg-[#eadecc] rounded-xl transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 py-3 text-sm font-bold text-white bg-[#14b8a6] hover:bg-[#0d9488] rounded-xl transition-colors shadow-sm">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ============== MODAL DELETE ============== --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black/50 z-[100] flex items-center justify-center p-4" wire:click.self="$set('showDeleteModal', false)">
            <div class="bg-white rounded-2xl w-full max-w-sm shadow-2xl p-8 text-center">
                <div class="w-16 h-16 rounded-full bg-[#EF4444] flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2">Hapus Perusahaan?</h3>
                <p class="text-gray-500 text-sm mb-7">
                    Perusahaan <strong>"{{ $deletingCompanyName }}"</strong> akan dihapus secara permanen.
                </p>
                <div class="flex gap-3">
                    <button type="button" wire:click="$set('showDeleteModal', false)"
                        class="flex-1 py-3 text-sm font-semibold text-gray-500 bg-[#F4F1EA] hover:bg-[#eadecc] rounded-xl transition-colors">
                        Batal
                    </button>
                    <button wire:click="deleteCompany"
                        class="flex-1 py-3 text-sm font-bold text-white bg-[#EF4444] hover:bg-[#dc2626] rounded-xl transition-colors shadow-sm">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
