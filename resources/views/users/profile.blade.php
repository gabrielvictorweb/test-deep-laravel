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
        <x-ui.card class="p-6 sm:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Perfil</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">Editar dados pessoais</h2>
                    <p class="mt-2 text-sm text-slate-600">Os campos já vêm pré-preenchidos. Alterações também são sincronizadas com o Auth0.</p>
                </div>

                <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">
                    <div class="h-14 w-14 overflow-hidden rounded-full border border-slate-200 bg-slate-100" id="avatar-preview-container">
                        @if (is_string($currentAvatar) && $currentAvatar !== '')
                            <img id="avatar-preview" src="{{ $currentAvatar }}" alt="Foto de perfil" class="h-full w-full object-cover" />
                        @else
                            <div id="avatar-placeholder" class="flex h-full w-full items-center justify-center text-xs font-semibold text-slate-500">
                                {{ strtoupper(substr((string) $prefilledName, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-900">{{ $prefilledName }}</p>
                        <p class="text-xs text-slate-500">Foto atual do perfil</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-4 md:grid-cols-2">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nome</label>
                    <x-ui.input id="name" name="name" value="{{ $prefilledName }}" required />
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                    <x-ui.input id="email" name="email" type="email" value="{{ $prefilledEmail }}" required />
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Nova senha (opcional)</label>
                    <x-ui.input id="password" name="password" type="password" placeholder="Deixe em branco para manter" />
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Confirmar nova senha</label>
                    <x-ui.input id="password_confirmation" name="password_confirmation" type="password" />
                </div>

                <div class="md:col-span-2">
                    <label for="avatar" class="mb-2 block text-sm font-medium text-slate-700">Foto de perfil</label>
                    <input id="avatar" name="avatar" type="file" accept="image/*" class="hidden" />
                    <label for="avatar" class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-4 py-6 text-sm font-semibold text-slate-600 transition hover:border-sky-300 hover:bg-sky-50 hover:text-sky-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4.5 w-4.5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18" />
                        </svg>
                        Selecionar nova imagem
                    </label>
                </div>

                <div class="md:col-span-2 pt-2">
                    <x-ui.button type="submit">Salvar alterações</x-ui.button>
                </div>
            </form>
        </x-ui.card>
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
