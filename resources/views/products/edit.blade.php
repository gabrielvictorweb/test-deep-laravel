@extends('layouts.dashboard')

@section('title', 'Editar produto')

@section('content')
    <div class="space-y-6">
        <section class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="pointer-events-none absolute -right-20 -top-20 h-56 w-56 rounded-full bg-cyan-200/25 blur-3xl"></div>
            <div class="pointer-events-none absolute -left-24 bottom-0 h-56 w-56 rounded-full bg-orange-200/20 blur-3xl"></div>

            <div class="relative">
                <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full border border-cyan-200 bg-cyan-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-cyan-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z" /></svg>
                            Edição de produto
                        </span>
                        <h1 class="mt-3 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Editar produto</h1>
                        <p class="mt-2 text-sm text-slate-600">Atualize informações, remova imagens atuais ou adicione novas imagens.</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Voltar para listagem
                    </a>
                </div>

                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="grid gap-4 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-5 md:grid-cols-2">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nome</label>
                        <x-ui.input id="name" name="name" value="{{ old('name', $product->name) }}" required />
                    </div>

                    <div>
                        <label for="price_mask" class="mb-2 block text-sm font-semibold text-slate-700">Preço (R$)</label>
                        <x-ui.input
                            id="price_mask"
                            type="text"
                            value="{{ old('price') !== null ? number_format((float) old('price'), 2, ',', '.') : number_format((float) $product->price, 2, ',', '.') }}"
                            inputmode="decimal"
                            data-brl-mask
                            data-target-input="price"
                            required
                        />
                        <input id="price" name="price" type="hidden" value="{{ old('price') !== null ? number_format((float) old('price'), 2, '.', '') : number_format((float) $product->price, 2, '.', '') }}" />
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Descrição</label>
                        <x-ui.textarea id="description" name="description">{{ old('description', $product->description) }}</x-ui.textarea>
                    </div>

                    @if ($product->images->isNotEmpty())
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Imagens atuais</label>
                            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                                @foreach ($product->images as $image)
                                    <label class="group relative block cursor-pointer overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <input
                                            type="checkbox"
                                            name="remove_image_ids[]"
                                            value="{{ $image->id }}"
                                            @checked(in_array($image->id, array_map('intval', (array) old('remove_image_ids', [])), true))
                                            class="peer sr-only"
                                        />
                                        <img
                                            src="{{ route('products.gallery-image', [$product, $image]) }}"
                                            alt="Imagem do produto"
                                            class="aspect-square h-full w-full object-cover transition peer-checked:scale-95 peer-checked:opacity-40"
                                            loading="lazy"
                                        />
                                        <span class="pointer-events-none absolute inset-0 hidden items-center justify-center bg-rose-600/75 text-xs font-bold uppercase tracking-wide text-white peer-checked:flex">
                                            Remover
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <p class="mt-2 text-xs text-slate-500">Marque as imagens que deseja remover e salve as alterações.</p>
                        </div>
                    @endif

                    <div class="md:col-span-2">
                        <label for="images-edit" class="mb-2 block text-sm font-semibold text-slate-700">Novas imagens (opcional)</label>
                        <input id="images-edit" name="images[]" type="file" accept="image/*" multiple class="hidden" />
                        <label for="images-edit" class="group flex cursor-pointer flex-col items-center justify-center gap-2 rounded-lg border-2 border-dashed border-slate-300 bg-white px-4 py-8 text-sm font-semibold text-slate-600 transition hover:border-cyan-400 hover:bg-cyan-50/40 hover:text-cyan-700">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-500 transition group-hover:bg-teal-100 group-hover:text-teal-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M12 3v13M7 8l5-5 5 5" />
                                </svg>
                            </span>
                            <span>Selecionar novas imagens</span>
                            <span class="text-xs font-normal text-slate-500">PNG, JPG até 10MB</span>
                        </label>
                        <div id="edit-images-preview" class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-4"></div>
                    </div>

                    <div class="md:col-span-2 flex flex-wrap gap-2">
                        <x-ui.button type="submit">Salvar alterações</x-ui.button>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <script>
        (() => {
            const toDecimal = (maskedValue) => {
                if (!maskedValue) return '';
                const digits = maskedValue.replace(/\D/g, '');
                if (!digits) return '';
                return (Number(digits) / 100).toFixed(2);
            };

            const formatBrl = (rawDigits) => {
                if (!rawDigits) return '';
                const normalizedDigits = rawDigits.replace(/^0+(?=\d)/, '');
                const integerPart = normalizedDigits.slice(0, -2) || '0';
                const cents = normalizedDigits.slice(-2).padStart(2, '0');
                const grouped = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                return `${grouped},${cents}`;
            };

            document.querySelectorAll('[data-brl-mask]').forEach((input) => {
                const targetId = input.getAttribute('data-target-input');
                const target = targetId ? document.getElementById(targetId) : null;

                if (!target) {
                    return;
                }

                const syncHiddenValue = () => {
                    const digits = (input.value || '').replace(/\D/g, '');
                    input.value = formatBrl(digits);
                    target.value = toDecimal(input.value);
                };

                syncHiddenValue();
                input.addEventListener('input', syncHiddenValue);
                input.closest('form')?.addEventListener('submit', syncHiddenValue);
            });

            const input = document.getElementById('images-edit');
            const preview = document.getElementById('edit-images-preview');

            if (!input || !preview) {
                return;
            }

            let selectedFiles = [];
            const supportsDataTransfer = typeof DataTransfer !== 'undefined';

            const status = document.createElement('p');
            status.className = 'mb-2 text-xs font-medium text-slate-500';
            preview.parentElement?.insertBefore(status, preview);

            const syncInputFiles = () => {
                if (!supportsDataTransfer) {
                    return false;
                }

                try {
                    const dataTransfer = new DataTransfer();
                    selectedFiles.forEach((file) => dataTransfer.items.add(file));
                    input.files = dataTransfer.files;
                    return true;
                } catch {
                    return false;
                }
            };

            const renderPreview = () => {
                preview.innerHTML = '';
                status.textContent = selectedFiles.length
                    ? `${selectedFiles.length} imagem(ns) selecionada(s)`
                    : 'Nenhuma imagem nova selecionada';

                selectedFiles.forEach((file, index) => {
                    const imageUrl = URL.createObjectURL(file);
                    const card = document.createElement('div');
                    card.className = 'overflow-hidden rounded-lg border border-slate-200 bg-white';

                    card.innerHTML = `
                        <img src="${imageUrl}" alt="Pré-visualização" class="aspect-square h-full w-full object-cover" />
                        <button type="button" class="js-remove-preview block w-full border-t border-slate-200 bg-rose-50 px-2 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-100" aria-label="Remover imagem selecionada">
                            Remover imagem
                        </button>
                    `;

                    const removeButton = card.querySelector('.js-remove-preview');
                    removeButton?.addEventListener('click', () => {
                        selectedFiles = selectedFiles.filter((_, selectedIndex) => selectedIndex !== index);
                        syncInputFiles();
                        renderPreview();
                    });

                    const imageElement = card.querySelector('img');
                    imageElement?.addEventListener('load', () => {
                        URL.revokeObjectURL(imageUrl);
                    });

                    preview.appendChild(card);
                });
            };

            input.addEventListener('change', (event) => {
                const files = Array.from(event.target.files || []);

                if (!files.length) {
                    return;
                }

                selectedFiles = supportsDataTransfer ? [...selectedFiles, ...files] : files;
                syncInputFiles();
                renderPreview();
            });

            renderPreview();
        })();
    </script>
@endsection
