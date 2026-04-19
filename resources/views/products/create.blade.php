@extends('layouts.dashboard')

@section('title', 'Cadastrar produto')

@section('content')
    <div class="space-y-6">
        <section class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="pointer-events-none absolute -right-20 -top-20 h-56 w-56 rounded-full bg-cyan-200/25 blur-3xl"></div>
            <div class="pointer-events-none absolute -left-24 bottom-0 h-56 w-56 rounded-full bg-orange-200/20 blur-3xl"></div>

            <div class="relative">
                <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full border border-cyan-200 bg-cyan-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-cyan-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3 w-3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" /></svg>
                            Novo produto
                        </span>
                        <h1 class="mt-3 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Cadastrar produto</h1>
                        <p class="mt-2 text-sm text-slate-600">Preencha os dados e adicione imagens antes de salvar.</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Voltar para listagem
                    </a>
                </div>

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-5 md:grid-cols-2">
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
                        <x-ui.input
                            id="price"
                            type="text"
                            value="{{ old('price') !== null ? number_format((float) old('price'), 2, ',', '.') : '' }}"
                            placeholder="0,00"
                            inputmode="decimal"
                            data-brl-mask
                            data-target-input="price_create"
                            required
                        />
                        <input id="price_create" name="price" type="hidden" value="{{ old('price') !== null ? number_format((float) old('price'), 2, '.', '') : '' }}" />
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
                        <label for="images" class="mb-2 block text-sm font-semibold text-slate-700">Imagens</label>
                        <input id="images" name="images[]" type="file" accept="image/*" multiple class="hidden" />
                        <label for="images" class="group flex cursor-pointer flex-col items-center justify-center gap-2 rounded-lg border-2 border-dashed border-slate-300 bg-white px-4 py-8 text-sm font-semibold text-slate-600 transition hover:border-cyan-400 hover:bg-cyan-50/40 hover:text-cyan-700">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-500 transition group-hover:bg-teal-100 group-hover:text-teal-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M12 3v13M7 8l5-5 5 5" />
                                </svg>
                            </span>
                            <span>Selecionar imagens</span>
                            <span class="text-xs font-normal text-slate-500">PNG, JPG até 10MB</span>
                        </label>
                        <div id="create-images-preview" class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-3"></div>
                        @error('images')
                            <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2 flex flex-wrap gap-2">
                        <x-ui.button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" /></svg>
                            Cadastrar produto
                        </x-ui.button>
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

                const integerPart = rawDigits.slice(0, -2) || '0';
                const cents = rawDigits.slice(-2).padStart(2, '0');
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

            const input = document.getElementById('images');
            const preview = document.getElementById('create-images-preview');

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
                        const synced = syncInputFiles();

                        if (!synced) {
                            status.textContent = 'Remocao visual aplicada. Se necessario, selecione novamente os arquivos antes de salvar.';
                        }

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
                const synced = syncInputFiles();

                if (!synced && !supportsDataTransfer) {
                    status.textContent = 'Seu navegador limita a remocao individual antes do envio; selecione novamente para substituir a lista.';
                }

                renderPreview();
            });

            renderPreview();
        })();
    </script>
@endsection
