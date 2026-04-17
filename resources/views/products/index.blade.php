@extends('layouts.dashboard')

@section('title', 'Gerenciar produtos')

@section('content')
    <div class="space-y-6">
        <section class="relative overflow-hidden rounded-3xl border border-slate-200/70 bg-white/90 p-6 shadow-[0_1px_2px_rgba(15,23,42,0.04),0_20px_50px_-20px_rgba(15,23,42,0.12)] backdrop-blur sm:p-8">
            <div class="pointer-events-none absolute -right-20 -top-20 h-56 w-56 rounded-full bg-gradient-to-br from-emerald-100/60 to-sky-100/60 blur-3xl"></div>

            <div class="relative">
                <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200/70 bg-emerald-50/80 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-emerald-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3"><path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a1 1 0 0 0-.53-.88l-7.5-4a1 1 0 0 0-.94 0l-7.5 4A1 1 0 0 0 4 8v8a1 1 0 0 0 .53.88l7.5 4a1 1 0 0 0 .94 0l7.5-4A1 1 0 0 0 21 16Z" /></svg>
                            Inventário
                        </span>
                        <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Meus produtos</h1>
                        <p class="mt-2 text-sm text-slate-600">Cadastre, atualize e remova itens com upload de imagem.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200/70 bg-gradient-to-br from-slate-50 to-white px-4 py-3 text-center">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">Total</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900">{{ $products->total() ?? $products->count() }}</p>
                    </div>
                </div>

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-5 md:grid-cols-2">
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nome do produto</label>
                        <x-ui.input id="name" name="name" value="{{ old('name') }}" placeholder="Ex: Fone Bluetooth" required />
                        @error('name')
                            <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="mb-2 block text-sm font-semibold text-slate-700">Preço (R$)</label>
                        <x-ui.input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" placeholder="0,00" required />
                        @error('price')
                            <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Descrição</label>
                        <x-ui.textarea id="description" name="description" placeholder="Descreva o produto...">{{ old('description') }}</x-ui.textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="image" class="mb-2 block text-sm font-semibold text-slate-700">Imagem</label>
                        <input id="image" name="image" type="file" accept="image/*" class="hidden" />
                        <label for="image" class="group flex cursor-pointer flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-slate-300 bg-white px-4 py-8 text-sm font-semibold text-slate-600 transition hover:border-sky-400 hover:bg-sky-50/50 hover:text-sky-700">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-500 transition group-hover:bg-sky-100 group-hover:text-sky-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M12 3v13M7 8l5-5 5 5" />
                                </svg>
                            </span>
                            <span>Selecionar imagem</span>
                            <span class="text-xs font-normal text-slate-500">PNG, JPG até 10MB</span>
                        </label>
                        @error('image')
                            <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <x-ui.button type="submit" class="w-full sm:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" /></svg>
                            Cadastrar produto
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </section>

        <section class="space-y-3">
            @forelse ($products as $product)
                <x-ui.card class="p-4 sm:p-5">
                    <div class="grid gap-5 md:grid-cols-[140px_1fr]">
                        <div class="aspect-square overflow-hidden rounded-2xl border border-slate-200/70 bg-gradient-to-br from-slate-50 to-slate-100">
                            @if ($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
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
                                <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-gradient-to-r from-sky-100 to-indigo-100 px-3 py-1.5 text-sm font-bold text-sky-800 ring-1 ring-sky-200/70">
                                    R$ {{ number_format((float) $product->price, 2, ',', '.') }}
                                </span>
                            </div>

                            <details class="group mt-4 rounded-2xl border border-slate-200/70 bg-slate-50/50 transition open:bg-white open:shadow-sm">
                                <summary class="flex cursor-pointer items-center justify-between gap-2 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 transition hover:text-slate-900">
                                    <span class="inline-flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z" />
                                        </svg>
                                        Editar produto
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 transition group-open:rotate-180"><path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" /></svg>
                                </summary>

                                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="grid gap-3 border-t border-slate-200/70 p-4 md:grid-cols-2">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700">Nome</label>
                                        <x-ui.input name="name" value="{{ $product->name }}" required />
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-slate-700">Preço</label>
                                        <x-ui.input name="price" type="number" step="0.01" min="0" value="{{ number_format((float) $product->price, 2, '.', '') }}" required />
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="mb-2 block text-sm font-medium text-slate-700">Descrição</label>
                                        <x-ui.textarea name="description">{{ $product->description }}</x-ui.textarea>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="mb-2 block text-sm font-medium text-slate-700">Nova imagem (opcional)</label>
                                        <input name="image" type="file" accept="image/*" class="hidden" id="image-{{ $product->id }}" />
                                        <label for="image-{{ $product->id }}" class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border-2 border-dashed border-slate-300 bg-white px-4 py-4 text-xs font-semibold text-slate-600 transition hover:border-sky-400 hover:bg-sky-50/50 hover:text-sky-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M12 3v13M7 8l5-5 5 5" /></svg>
                                            Selecionar nova imagem
                                        </label>
                                    </div>

                                    <div class="md:col-span-2 flex flex-wrap gap-2 pt-1">
                                        <x-ui.button type="submit">Salvar alterações</x-ui.button>
                                        <x-ui.button type="button" variant="outline" onclick="this.closest('details').removeAttribute('open')">Cancelar</x-ui.button>
                                    </div>
                                </form>
                            </details>

                            <div class="mt-3 flex justify-end">
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
                    <div class="mx-auto mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-slate-100 to-slate-200/60 text-slate-500 ring-1 ring-slate-200/70">
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
            <div class="pt-2">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
