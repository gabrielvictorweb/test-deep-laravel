@extends('layouts.dashboard')

@section('title', 'Meu perfil')

@section('content')
    @php
        $prefilledName = old('name', $registeredUser->name ?? data_get(auth()->user(), 'name'));
        $prefilledEmail = old('email', $registeredUser->email ?? data_get(auth()->user(), 'email'));

        $hasKnownAvatar =
            (is_string($registeredUser->avatar_path ?? null) && $registeredUser->avatar_path !== '')
            || (is_string($registeredUser->avatar_url ?? null) && $registeredUser->avatar_url !== '')
            || (is_string(data_get(auth()->user(), 'avatar_url')) && data_get(auth()->user(), 'avatar_url') !== '')
            || (is_string(data_get(auth()->user(), 'picture')) && data_get(auth()->user(), 'picture') !== '');

        $currentAvatar = $hasKnownAvatar && Route::has('profile.avatar')
            ? route('profile.avatar')
            : null;
    @endphp

    <div class="space-y-6">
        <section class="relative overflow-hidden rounded-4xl border border-[#e6e1d5] bg-[#fffefb]/95 shadow-[0_1px_2px_rgba(15,23,42,0.05),0_28px_72px_-44px_rgba(15,23,42,0.7)] backdrop-blur page-enter stagger-2">
            <div class="relative h-36 overflow-hidden bg-linear-to-br from-teal-500 via-cyan-500 to-orange-400">
                <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(at_top_left,rgba(255,255,255,0.4),transparent_50%)]"></div>
                <div class="pointer-events-none absolute -right-10 -bottom-10 h-40 w-40 rounded-full bg-white/20 blur-2xl"></div>
            </div>

            <div class="relative -mt-16 px-6 pb-8 sm:px-10">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div class="flex items-end gap-4">
                        <div class="relative h-24 w-24 shrink-0 overflow-hidden rounded-3xl border-4 border-white bg-linear-to-br from-sky-200 to-indigo-200 shadow-lg" id="avatar-preview-container">
                            @if (is_string($currentAvatar) && $currentAvatar !== '')
                                <img id="avatar-preview" src="{{ $currentAvatar }}" alt="Foto de perfil" class="h-full w-full object-cover" />
                            @else
                                <div id="avatar-placeholder" class="flex h-full w-full items-center justify-center text-2xl font-bold text-slate-700">
                                    {{ strtoupper(substr((string) $prefilledName, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="pb-1">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-500">Perfil</p>
                            <h2 class="heading-font mt-1 text-3xl font-extrabold tracking-tight text-slate-900">{{ $prefilledName }}</h2>
                            <p class="text-sm text-slate-500">{{ $prefilledEmail }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 border-t border-[#ebe5d9] pt-8">
                    <h3 class="heading-font text-xl font-bold tracking-tight text-slate-900">Editar dados pessoais</h3>
                    <p class="mt-1 text-sm text-slate-500">Os campos já vêm pré-preenchidos. Alterações também são sincronizadas com o Auth0.</p>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-4 md:grid-cols-2">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nome</label>
                            <x-ui.input id="name" name="name" value="{{ $prefilledName }}" required />
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                            <x-ui.input id="email" name="email" type="email" value="{{ $prefilledEmail }}" required />
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Nova senha <span class="font-normal text-slate-400">(opcional)</span></label>
                            <x-ui.input id="password" name="password" type="password" placeholder="Deixe em branco para manter" />
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Confirmar nova senha</label>
                            <x-ui.input id="password_confirmation" name="password_confirmation" type="password" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="avatar" class="mb-2 block text-sm font-semibold text-slate-700">Foto de perfil</label>
                            <input id="avatar" name="avatar" type="file" accept="image/*" class="hidden" />
                            <label for="avatar" class="group flex cursor-pointer flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-[#d6cebd] bg-[#faf7f0] px-4 py-8 text-sm font-semibold text-slate-600 transition hover:border-teal-400 hover:bg-teal-50/50 hover:text-teal-700">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-500 shadow-sm transition group-hover:text-sky-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M12 3v13M7 8l5-5 5 5" />
                                    </svg>
                                </span>
                                Selecionar nova imagem
                                <span class="text-xs font-normal text-slate-500">PNG, JPG até 10MB</span>
                            </label>
                        </div>

                        <div class="md:col-span-2 flex justify-end pt-2">
                            <x-ui.button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                Salvar alterações
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        const avatarInput = document.getElementById('avatar');
        const previewContainer = document.getElementById('avatar-preview-container');

        avatarInput?.addEventListener('change', (event) => {
            const [file] = event.target.files ?? [];

            if (!file) {
                return;
            }

            const url = URL.createObjectURL(file);
            previewContainer.innerHTML = `<img src="${url}" alt="Pré-visualização" class="h-full w-full object-cover" />`;
        });
    </script>
@endsection
