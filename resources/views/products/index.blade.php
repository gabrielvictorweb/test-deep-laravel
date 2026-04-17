@extends('layouts.dashboard')

@section('title', 'Gerenciar produtos')

@section('content')
    <div class="space-y-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-5">
                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Inventário</p>
                <h1 class="mt-2 text-2xl font-bold text-slate-900 sm:text-3xl">Meus produtos</h1>
                <p class="mt-2 text-sm text-slate-600">Cadastre, atualize e remova itens com upload de imagem.</p>
            </div>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nome do produto</label>
                    <x-ui.input id="name" name="name" value="{{ old('name') }}" placeholder="Ex: Fone Bluetooth" required />
                    @error('name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="mb-2 block text-sm font-medium text-slate-700">Preço (R$)</label>
                    <x-ui.input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" placeholder="0,00" required />
                    @error('price')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="mb-2 block text-sm font-medium text-slate-700">Descrição</label>
                    <x-ui.textarea id="description" name="description" placeholder="Descreva o produto...">{{ old('description') }}</x-ui.textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="image" class="mb-2 block text-sm font-medium text-slate-700">Imagem</label>
                    <input id="image" name="image" type="file" accept="image/*" class="hidden" />
                    <label for="image" class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-4 py-6 text-sm font-semibold text-slate-600 transition hover:border-sky-300 hover:bg-sky-50 hover:text-sky-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4.5 w-4.5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18" />
                        </svg>
                        Selecionar imagem
                    </label>
                    @error('image')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <x-ui.button type="submit">Cadastrar produto</x-ui.button>
                </div>
            </form>
        </section>

        <section class="space-y-3">
            @forelse ($products as $product)
                <x-ui.card class="overflow-hidden p-4 sm:p-5">
                    <div class="grid gap-4 md:grid-cols-[120px_1fr]">
                        <div class="aspect-square overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                            @if ($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                            @else
                                <div class="flex h-full w-full items-center justify-center text-xs text-slate-500">Sem imagem</div>
                            @endif
                        </div>

                        <div>
                            <div class="mb-3 flex flex-wrap items-start justify-between gap-2">
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">{{ $product->name }}</h3>
                                    <p class="mt-1 text-sm text-slate-600">{{ $product->description }}</p>
                                </div>
                                <span class="rounded-full bg-sky-50 px-3 py-1 text-sm font-semibold text-sky-700">
                                    R$ {{ number_format((float) $product->price, 2, ',', '.') }}
                                </span>
                            </div>

                            <details class="group rounded-xl border border-slate-200 bg-slate-50/70 p-3">
                                <summary class="cursor-pointer text-sm font-semibold text-slate-700">Editar produto</summary>

                                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="mt-4 grid gap-3 md:grid-cols-2">
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
                                        <label for="image-{{ $product->id }}" class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border-2 border-dashed border-slate-300 bg-white px-4 py-4 text-xs font-semibold text-slate-600 transition hover:border-sky-300 hover:bg-sky-50 hover:text-sky-700">
                                            Selecionar nova imagem
                                        </label>
                                    </div>

                                    <div class="md:col-span-2 flex flex-wrap gap-2">
                                        <x-ui.button type="submit">Salvar alterações</x-ui.button>
                                        <x-ui.button type="button" variant="outline" onclick="this.closest('details').removeAttribute('open')">Cancelar</x-ui.button>
                                    </div>
                                </form>
                            </details>

                            <div class="mt-3 flex justify-end">
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Deseja realmente remover este produto?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-ui.button type="submit" variant="danger" size="sm">Excluir</x-ui.button>
                                </form>
                            </div>
                        </div>
                    </div>
                </x-ui.card>
            @empty
                <x-ui.card class="p-10 text-center">
                    <p class="text-base font-semibold text-slate-700">Nenhum produto cadastrado ainda.</p>
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
