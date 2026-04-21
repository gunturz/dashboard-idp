<x-talent.layout title="Riwayat Program IDP – Individual Development Plan" :user="$user" :notifications="$notifications">
    <div class="w-full px-4 lg:px-6 pt-5 pb-6 flex-grow">
        {{-- Back Link --}}
        <div class="mb-5">
            <a href="{{ route('talent.dashboard') }}"
                class="px-4 py-2 border border-[#e2e8f0] rounded-lg bg-white text-[#475569] font-medium text-[0.875rem] flex items-center gap-2 transition-all duration-200 hover:bg-[#f8fafc] hover:border-[#cbd5e1] w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        {{-- Page Header --}}
        <div class="page-header animate-title">
            <div class="page-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <div class="page-header-title">Riwayat Program IDP</div>
                <div class="page-header-sub">Ringkasan seluruh perjalanan dan pencapaian pengembangan Anda</div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="prem-card">
                <div class="p-6">
                    <div class="section-title">Daftar Sesi Assessment</div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 font-bold">Periode Program</th>
                                    <th class="px-6 py-4 font-bold">Tanggal Selesai</th>
                                    <th class="px-6 py-4 font-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($sessions as $session)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800">{{ $session->period }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ date('d F Y', strtotime($session->created_at)) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="#" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-50 text-teal-600 font-bold rounded-lg hover:bg-teal-100 transition-colors border border-teal-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                            <p>Belum ada riwayat program yang tercatat.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-talent.layout>
