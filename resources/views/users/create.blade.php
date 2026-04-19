@extends('layouts.public-auth')

@section('title', 'Cadastro de usuario')

@section('content')
    <div class="mb-8 text-center">
        <div class="mx-auto mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-600 text-white shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" />
                <circle cx="9.5" cy="7" r="4" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 8v6M23 11h-6" />
            </svg>
        </div>
        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-cyan-700">Novo usuário</p>
        <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">Criar conta</h1>
        <p class="mt-2 text-sm text-slate-600">
            Faça um cadastro público com foto de perfil e comece a gerenciar seus produtos.
        </p>
    </div>

    @if ($registeredUser)
        <div class="overflow-hidden rounded-xl border border-emerald-200 bg-emerald-50 p-6">
            <div class="flex items-start gap-4">
                <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-white shadow-md">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                </span>
                <div class="flex-1">
                    <h3 class="text-base font-bold text-emerald-900">Usuário já cadastrado</h3>
                    <div class="mt-3 rounded-xl border border-emerald-200/70 bg-white/70 p-4 text-sm">
                        <p><span class="font-semibold text-slate-700">Nome:</span> <span class="text-slate-900">{{ $registeredUser->name }}</span></p>
                        <p class="mt-1"><span class="font-semibold text-slate-700">Email:</span> <span class="text-slate-900">{{ $registeredUser->email }}</span></p>
                    </div>
                    <a href="{{ route('products.index') }}" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-cyan-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-300">
                        Ir para meus produtos
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6" /></svg>
                    </a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
                    Nome completo
                    <span class="text-rose-600">*</span>
                </label>
                <x-ui.input
                    id="name"
                    name="name"
                    value="{{ old('name', $authName) }}"
                    placeholder="Seu nome"
                    required
                />
                @error('name')
                    <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                    Email
                    <span class="text-rose-600">*</span>
                </label>
                <x-ui.input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $authEmail) }}"
                    placeholder="seu@email.com"
                    required
                />
                @error('email')
                    <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">
                        Senha
                        <span class="text-rose-600">*</span>
                    </label>
                    <x-ui.input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Mínimo 8 caracteres"
                        required
                    />
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">
                        Confirmar senha
                        <span class="text-rose-600">*</span>
                    </label>
                    <x-ui.input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        placeholder="Repita sua senha"
                        required
                    />
                </div>
            </div>

            <div>
                <label for="avatar" class="mb-2 block text-sm font-semibold text-slate-700">
                    Foto de perfil
                    <span class="font-normal text-slate-500">(opcional)</span>
                </label>
                <input
                    id="avatar"
                    name="avatar"
                    type="file"
                    accept="image/*"
                    class="hidden"
                />
                <label for="avatar" class="group flex w-full cursor-pointer flex-col items-center justify-center gap-2 rounded-lg border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-8 text-center transition hover:border-cyan-400 hover:bg-cyan-50/50">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white text-slate-500 shadow-sm transition group-hover:text-sky-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M12 3v13M7 8l5-5 5 5" />
                        </svg>
                    </span>
                    <p class="text-sm font-semibold text-slate-700">Clique para enviar imagem</p>
                    <p class="text-xs text-slate-500">PNG, JPG até 10MB</p>
                </label>
                @error('avatar')
                    <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <x-ui.button type="submit" size="lg" class="w-full">
                    Criar minha conta
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6" /></svg>
                </x-ui.button>
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-xs text-slate-600">
                <p class="mb-2 flex items-center gap-1.5 font-semibold text-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 text-sky-600">
                        <circle cx="12" cy="12" r="10" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4M12 8h.01" />
                    </svg>
                    Como funciona
                </p>
                <ul class="space-y-1.5 pl-5">
                    <li class="relative before:absolute before:-left-4 before:top-1.5 before:h-1.5 before:w-1.5 before:rounded-full before:bg-sky-500">Cada conta autenticada possui um usuário local vinculado</li>
                    <li class="relative before:absolute before:-left-4 before:top-1.5 before:h-1.5 before:w-1.5 before:rounded-full before:bg-sky-500">Seus produtos serão associados automaticamente ao seu perfil</li>
                    <li class="relative before:absolute before:-left-4 before:top-1.5 before:h-1.5 before:w-1.5 before:rounded-full before:bg-sky-500">Na listagem, você visualiza apenas seus produtos</li>
                </ul>
            </div>
        </form>
    @endif
@endsection
