@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col items-center justify-between gap-3 sm:flex-row">
        <span class="text-sm text-slate-600">
            Mostrando
            <span class="font-semibold text-slate-900">{{ $paginator->firstItem() }}</span>
            a
            <span class="font-semibold text-slate-900">{{ $paginator->lastItem() }}</span>
            de
            <span class="font-semibold text-slate-900">{{ $paginator->total() }}</span>
            resultados
        </span>

        <ul class="inline-flex -space-x-px overflow-hidden rounded-lg border border-slate-200 text-sm">
            @if ($paginator->onFirstPage())
                <li>
                    <span class="flex h-9 items-center justify-center border-r border-slate-200 bg-slate-100 px-3 text-slate-400">Anterior</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex h-9 items-center justify-center border-r border-slate-200 bg-white px-3 text-slate-700 transition hover:bg-slate-50 hover:text-cyan-700" aria-label="Pagina anterior">Anterior</a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span class="flex h-9 items-center justify-center border-r border-slate-200 bg-white px-3 text-slate-500">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li aria-current="page">
                                <span class="flex h-9 items-center justify-center border-r border-cyan-600 bg-cyan-600 px-3 font-semibold text-white">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="flex h-9 items-center justify-center border-r border-slate-200 bg-white px-3 text-slate-700 transition hover:bg-slate-50 hover:text-cyan-700" aria-label="Ir para pagina {{ $page }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex h-9 items-center justify-center bg-white px-3 text-slate-700 transition hover:bg-slate-50 hover:text-cyan-700" aria-label="Proxima pagina">Próxima</a>
                </li>
            @else
                <li>
                    <span class="flex h-9 items-center justify-center bg-slate-100 px-3 text-slate-400">Próxima</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
