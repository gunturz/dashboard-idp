<x-mentor.layout title="Detail Logbook" :user="$user">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 p-8">
            <div class="flex items-center gap-4 mb-8 border-b border-gray-100 pb-6">
                <a href="javascript:history.back()" class="text-gray-400 hover:text-gray-700 bg-gray-50 hover:bg-gray-200 p-2.5 rounded-full transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-[#1e293b]">Detail Logbook - {{ $activity->type->nama_type ?? 'Aktivitas' }}</h2>
                    <p class="text-gray-500 text-sm mt-1">Lihat detail aktivitas logbook yang disubmit oleh talent.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($activity->type_idp == 1 || $activity->type_idp == 2)
                <div class="p-5 bg-gray-50/80 rounded-xl border border-gray-100">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Mentor</span>
                    <div class="text-[15px] text-gray-800 font-medium">{{ $activity->verifier->nama ?? '-' }}</div>
                </div>
                @endif

                @if($activity->type_idp == 3)
                <div class="p-5 bg-gray-50/80 rounded-xl border border-gray-100">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Sumber</span>
                    <div class="text-[15px] text-gray-800 font-medium">{{ $activity->activity ?? '-' }}</div>
                </div>
                @endif

                <div class="p-5 bg-gray-50/80 rounded-xl border border-gray-100">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Tema</span>
                    <div class="text-[15px] text-gray-800 font-medium">{{ $activity->theme ?? '-' }}</div>
                </div>

                <div class="p-5 bg-gray-50/80 rounded-xl border border-gray-100">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Tgl. Pengiriman/Update</span>
                    <div class="text-[15px] text-gray-800 font-medium">{{ $activity->updated_at ? \Carbon\Carbon::parse($activity->updated_at)->format('d F Y') : '-' }}</div>
                </div>

                <div class="p-5 bg-gray-50/80 rounded-xl border border-gray-100">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Tgl. Pelaksanaan</span>
                    <div class="text-[15px] text-gray-800 font-medium">{{ \Carbon\Carbon::parse($activity->activity_date)->format('d F Y') }}</div>
                </div>

                @if($activity->type_idp == 1 || $activity->type_idp == 2)
                <div class="p-5 bg-gray-50/80 rounded-xl border border-gray-100">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Lokasi</span>
                    <div class="text-[15px] text-gray-800 font-medium">{{ $activity->location ?? '-' }}</div>
                </div>
                @endif

                @if($activity->type_idp == 3)
                <div class="p-5 bg-gray-50/80 rounded-xl border border-gray-100">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Platform</span>
                    <div class="text-[15px] text-gray-800 font-medium">{{ $activity->platform ?? '-' }}</div>
                </div>
                @endif

                <div class="p-5 bg-gray-50/80 rounded-xl border border-gray-100">
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
                <div class="p-5 bg-gray-50/80 rounded-xl border border-gray-100 md:col-span-2">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Aktivitas</span>
                    <div class="text-[15px] text-gray-800 font-medium break-words">{{ $activity->activity ?? '-' }}</div>
                </div>
                @endif

                @if($activity->type_idp != 3)
                <div class="p-5 bg-gray-50/80 rounded-xl border border-gray-100 md:col-span-2">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Deskripsi</span>
                    <div class="text-[15px] text-gray-800 leading-relaxed font-medium break-words">{{ $activity->description ?? '-' }}</div>
                </div>
                @endif

                @if($activity->type_idp == 2)
                <div class="p-5 bg-gray-50/80 rounded-xl border border-gray-100 md:col-span-2">
                    <span class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1.5">Action Plan</span>
                    <div class="text-[15px] text-gray-800 leading-relaxed font-medium break-words">{{ $activity->action_plan ?? '-' }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-mentor.layout>
