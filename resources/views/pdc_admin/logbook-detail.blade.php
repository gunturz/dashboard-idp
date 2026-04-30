<x-pdc_admin.layout title="Detail Logbook" :user="$user">
    <div class="w-full">
        {{-- ── Page Header ── --}}
        <div class="page-header animate-title mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="page-header-icon shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zM12.75 12a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V18a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V12z" clip-rule="evenodd" />
                        <path d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963 5.23 5.23 0 00-3.434-1.279h-1.875a.375.375 0 01-.375-.375V5.25z" />
                    </svg>
                </div>
                <div>
                    <h1 class="page-header-title">Detail Logbook - {{ $activity->type->nama_type ?? 'Aktivitas' }}</h1>
                    <p class="page-header-sub">Lihat detail aktivitas logbook yang disubmit oleh talent.</p>
                </div>
            </div>
            
            <a href="javascript:history.back()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-600 font-bold text-sm rounded-lg hover:bg-slate-50 transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="prem-card p-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($activity->type_idp == 1 || $activity->type_idp == 2)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Mentor</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ $activity->verifier->nama ?? '-' }}</div>
                </div>
                @endif

                @if($activity->type_idp == 3)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Sumber</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ $activity->activity ?? '-' }}</div>
                </div>
                @endif

                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Tema</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ $activity->theme ?? '-' }}</div>
                </div>

                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Tanggal Pengiriman/Update</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ $activity->updated_at ? \Carbon\Carbon::parse($activity->updated_at)->format('d F Y') : '-' }}</div>
                </div>

                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Tanggal Pelaksanaan</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ \Carbon\Carbon::parse($activity->activity_date)->format('d F Y') }}</div>
                </div>

                @if($activity->type_idp == 1 || $activity->type_idp == 2)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Lokasi</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ $activity->location ?? '-' }}</div>
                </div>
                @endif

                @if($activity->type_idp == 3)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Platform</span>
                    <div class="text-[15px] text-gray-800 font-medium whitespace-pre-wrap">{{ $activity->platform ?? '-' }}</div>
                </div>
                @endif

                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-2">Dokumentasi</span>
                    @php
                        $dPaths = []; $dNames = [];
                        if($activity->document_path){
                            if(str_starts_with($activity->document_path, '["')) {
                                $dPaths = json_decode($activity->document_path, true);
                                $dNames = explode(', ', $activity->file_name ?? '');
                            } else {
                                $dPaths = [$activity->document_path]; $dNames = [$activity->file_name ?? 'Dokumen'];
                            }
                        }
                    @endphp
                    @if(count($dPaths) > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($dPaths as $di => $dp)
                                <a href="{{ asset('storage/'.$dp) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[12px] font-semibold text-teal-600 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50/50 shadow-sm transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    {{ $dNames[$di] ?? 'File ' . ($di+1) }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <span class="text-[13px] text-gray-400 font-medium whitespace-nowrap">- Tidak ada file</span>
                    @endif
                </div>

                @if($activity->type_idp == 1)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm md:col-span-2">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Aktivitas</span>
                    <div class="text-[15px] text-gray-800 font-medium break-words">{{ $activity->activity ?? '-' }}</div>
                </div>
                @endif

                @if($activity->type_idp != 3)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm md:col-span-2">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Deskripsi</span>
                    <div class="text-[15px] text-gray-800 leading-relaxed font-medium break-words">{{ $activity->description ?? '-' }}</div>
                </div>
                @endif

                @if($activity->type_idp == 2)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm md:col-span-2">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Action Plan</span>
                    <div class="text-[15px] text-gray-800 leading-relaxed font-medium break-words">{{ $activity->action_plan ?? '-' }}</div>
                </div>
                @endif


            </div>
        </div>
    </div>
</x-pdc_admin.layout>
