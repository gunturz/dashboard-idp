<x-pdc_admin.layout title="Atasan – PDC Admin" :user="$user">

    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2e3746]" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
            </svg>
            <div>
                <h2 class="text-2xl font-bold text-[#2e3746]">Atasan</h2>
                <p class="text-sm text-gray-500">Daftar atasan program IDP.</p>
            </div>
        </div>
        <button class="bg-[#2e3746] text-white px-5 py-2.5 rounded-lg flex items-center gap-2 font-semibold text-sm hover:bg-[#1e2737] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Atasan
        </button>
    </div>

    {{-- Grid Cards --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        @foreach($atasans as $atasan)
            <div class="bg-[#f8fafc] rounded-2xl p-6 border border-[#e2e8f0] flex flex-col justify-between">
                <div>
                    {{-- Header Card --}}
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            @if($atasan->foto)
                                <img src="{{ asset('storage/' . $atasan->foto) }}" alt="{{ $atasan->nama }}" class="w-14 h-14 rounded-full object-cover shadow-sm">
                            @else
                                <div class="w-14 h-14 rounded-full bg-[#e2e8f0] flex items-center justify-center text-[#94a3b8] shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-[#2e3746] text-lg leading-tight">{{ $atasan->nama }}</h3>
                                <p class="text-xs text-gray-500 mt-1 font-medium">{{ $atasan->position->position_name ?? '—' }} - {{ $atasan->department->nama_department ?? '—' }}</p>
                            </div>
                        </div>
                        <span class="px-4 py-1.5 bg-white border border-[#14b8a6] text-[#14b8a6] rounded-full text-xs font-semibold whitespace-nowrap">
                            {{ $atasan->subordinates->count() }} Talent
                        </span>
                    </div>

                    {{-- Tengah --}}
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 font-medium mb-3">Talent yang dibimbing</p>
                        <div class="flex flex-col gap-2">
                            @foreach($atasan->subordinates as $talent)
                                <div class="bg-white border border-[#e2e8f0] rounded-xl px-4 py-3 flex justify-between items-center whitespace-nowrap overflow-hidden text-ellipsis shadow-sm">
                                    <span class="font-bold text-[#2e3746] text-sm overflow-hidden text-ellipsis">{{ $talent->nama }}</span>
                                    <span class="text-xs font-medium text-[#475569] overflow-hidden text-ellipsis pl-4">
                                        {{ $talent->position->position_name ?? '—' }} 
                                        @if($talent->promotion_plan && $talent->promotion_plan->targetPosition)
                                            - {{ $talent->promotion_plan->targetPosition->position_name }}
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                            @if($atasan->subordinates->isEmpty())
                                <div class="text-sm text-gray-400 italic">Belum ada talent.</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Footer Card --}}
                <div class="flex items-center gap-3 text-[#475569]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    <span class="text-sm font-medium">{{ $atasan->email }}</span>
                </div>
            </div>
        @endforeach
    </div>

</x-pdc_admin.layout>
