@if ($paginator->hasPages())
    <nav class="flex items-center gap-1.5" aria-label="Pagination">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 border rounded-lg text-xs font-semibold text-gray-400 bg-gray-50 border-gray-200 cursor-not-allowed">« Prev</span>
        @else
            <button wire:click="previousPage('{{ $paginator->getPageName() }}')" class="px-3 py-1.5 border rounded-lg text-xs font-semibold text-[#14b8a6] bg-white hover:bg-teal-50 border-[#14b8a6] transition-colors">« Prev</button>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-2 py-1.5 text-xs text-gray-500 font-bold">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1.5 border rounded-lg text-xs font-bold text-white bg-[#14b8a6] border-[#14b8a6]">{{ $page }}</span>
                    @else
                        <button wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" class="px-3 py-1.5 border rounded-lg text-xs font-semibold text-[#14b8a6] bg-white hover:bg-teal-50 border-[#14b8a6] transition-colors">{{ $page }}</button>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage('{{ $paginator->getPageName() }}')" class="px-3 py-1.5 border rounded-lg text-xs font-semibold text-[#14b8a6] bg-white hover:bg-teal-50 border-[#14b8a6] transition-colors">Next »</button>
        @else
            <span class="px-3 py-1.5 border rounded-lg text-xs font-semibold text-gray-400 bg-gray-50 border-gray-200 cursor-not-allowed">Next »</span>
        @endif
    </nav>
@endif
