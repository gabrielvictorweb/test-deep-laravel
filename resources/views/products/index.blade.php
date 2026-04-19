@extends('layouts.dashboard')

@section('title', 'Gerenciar produtos')

@section('content')
    <div class="space-y-6">
        <section class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="pointer-events-none absolute -right-20 -top-20 h-56 w-56 rounded-full bg-cyan-200/25 blur-3xl"></div>
            <div class="pointer-events-none absolute -left-24 bottom-0 h-56 w-56 rounded-full bg-orange-200/20 blur-3xl"></div>

            <div class="relative">
                <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full border border-cyan-200 bg-cyan-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-cyan-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3"><path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a1 1 0 0 0-.53-.88l-7.5-4a1 1 0 0 0-.94 0l-7.5 4A1 1 0 0 0 4 8v8a1 1 0 0 0 .53.88l7.5 4a1 1 0 0 0 .94 0l7.5-4A1 1 0 0 0 21 16Z" /></svg>
                            Inventário
                        </span>
                        <h1 class="mt-3 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Meus produtos</h1>
                        <p class="mt-2 text-sm text-slate-600">Pesquise, atualize e remova itens do seu catálogo.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-center">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">Total</p>
                            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $products->total() ?? $products->count() }}</p>
                        </div>
                        <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-cyan-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" /></svg>
                            Adicionar produto
                        </a>
                    </div>
                </div>

                <form action="{{ route('products.index') }}" method="GET" class="mb-6 grid gap-3 rounded-xl border border-slate-200 bg-white p-4 md:grid-cols-[1fr_auto_auto]">
                    <div>
                        <label for="q" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Buscar por nome</label>
                        <x-ui.input id="q" name="q" value="{{ $searchName ?? '' }}" placeholder="Ex: Cafeteira, Fone, Cadeira" />
                    </div>
                    <input type="hidden" name="per_page" value="{{ request('per_page', 12) }}" />
                    <x-ui.button type="submit" class="w-full self-end md:w-auto">Buscar</x-ui.button>
                    <a href="{{ route('products.index') }}" class="inline-flex w-full items-center justify-center rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 md:w-auto">
                        Limpar
                    </a>
                </form>

            </div>
        </section>

        <section class="space-y-3 page-enter stagger-2">
            @forelse ($products as $product)
                <x-ui.card class="p-4 sm:p-5">
                    <div class="grid gap-5 md:grid-cols-[140px_1fr]">
                        <div class="aspect-square overflow-hidden rounded-2xl border border-[#e6e1d5] bg-linear-to-br from-[#faf7f0] to-[#f2ede2]">
                            @php
                                $galleryCount = $product->images->count();
                                $hasProductImage =
                                    $galleryCount > 0
                                    ||
                                    (is_string($product->image_path ?? null) && $product->image_path !== '')
                                    || (is_string($product->image_url ?? null) && $product->image_url !== '');
                            @endphp

                            @if ($hasProductImage && Route::has('products.image'))
                                <img src="{{ route('products.image', $product) }}" alt="{{ $product->name }}" class="h-full w-full object-cover" loading="lazy" />
                            @else
                                <div class="flex h-full w-full flex-col items-center justify-center gap-2 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-8 w-8">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 15-5-5L5 21" />
                                    </svg>
                                    <span class="text-xs font-medium">Sem imagem</span>
                                </div>
                            @endif
                        </div>

                        <div class="min-w-0">
                            <div class="mb-3 flex flex-wrap items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="text-lg font-bold tracking-tight text-slate-900">{{ $product->name }}</h3>
                                    <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $product->description }}</p>
                                </div>
                                <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-linear-to-r from-cyan-50 to-blue-50 px-3 py-1.5 text-sm font-bold text-cyan-800 ring-1 ring-cyan-200/70">
                                    R$ {{ number_format((float) $product->price, 2, ',', '.') }}
                                </span>
                            </div>

                            @if ($galleryCount > 1)
                                <p class="text-xs font-medium text-slate-500">{{ $galleryCount }} imagens cadastradas</p>
                            @endif

                            <div class="mt-4 flex items-center justify-end gap-2">
                                <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z" />
                                    </svg>
                                    Editar
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Deseja realmente remover este produto?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-ui.button type="submit" variant="danger" size="sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3.5 w-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14Z" /></svg>
                                        Excluir
                                    </x-ui.button>
                                </form>
                            </div>
                        </div>
                    </div>
                </x-ui.card>
            @empty
                <x-ui.card class="p-12 text-center">
                    <div class="mx-auto mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-linear-to-br from-[#f4eee2] to-[#ebe2d1] text-slate-500 ring-1 ring-[#dcd3bf]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-7 w-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a1 1 0 0 0-.53-.88l-7.5-4a1 1 0 0 0-.94 0l-7.5 4A1 1 0 0 0 4 8v8a1 1 0 0 0 .53.88l7.5 4a1 1 0 0 0 .94 0l7.5-4A1 1 0 0 0 21 16Z" />
                        </svg>
                    </div>
                    <p class="text-base font-semibold text-slate-800">Nenhum produto cadastrado ainda.</p>
                    <p class="mt-1 text-sm text-slate-500">Use o formulário acima para cadastrar o primeiro.</p>
                </x-ui.card>
            @endforelse
        </section>

        @if ($products->hasPages())
            <div class="pt-2 page-enter stagger-3">
                {{ $products->links('vendor.pagination.flowbite') }}
            </div>
        @endif
    </div>
@endsection
