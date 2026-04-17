@extends('layouts.public-auth')

@section('title', 'Cadastro de usuario')

@section('content')
    <div class="mb-8">
        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Novo usuário</p>
        <h1 class="mt-2 text-3xl font-bold text-slate-900">Criar conta</h1>
        <p class="mt-2 text-sm text-slate-600">
            Faça um cadastro público com foto de perfil e comece a gerenciar seus produtos.
        </p>
    </div>

    @if ($registeredUser)
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-6">
            <div class="flex items-start gap-3">
                <svg class="mt-1 h-5 w-5 shrink-0 text-emerald-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                <div>
                    <h3 class="font-medium text-emerald-900">Usuário já cadastrado</h3>
                    <p class="mt-1 text-sm text-emerald-800">
                        <strong>Nome:</strong> {{ $registeredUser->name }}<br>
                        <strong>Email:</strong> {{ $registeredUser->email }}
                    </p>
                    <a href="{{ route('products.index') }}" class="mt-4 inline-flex rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-sky-700">
                        Ir para meus produtos →
                    </a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Name -->
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
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
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
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
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
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
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

            <!-- Avatar -->
            <div>
                <label for="avatar" class="mb-2 block text-sm font-semibold text-slate-700">
                    Foto de perfil
                    <span class="text-slate-500">(opcional)</span>
                </label>
                <div class="flex items-center gap-4">
                    <input
                        id="avatar"
                        name="avatar"
                        type="file"
                        accept="image/*"
                        class="hidden"
                    />
                    <label for="avatar" class="w-full cursor-pointer rounded-lg border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-8 text-center transition hover:border-sky-300 hover:bg-sky-50">
                        <svg class="mx-auto h-8 w-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <p class="mt-2 text-sm font-medium text-slate-700">Clique para enviar imagem</p>
                        <p class="text-xs text-slate-500">PNG, JPG até 10MB</p>
                    </label>
                </div>
                @error('avatar')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="pt-2">
                <x-ui.button type="submit" size="lg" class="w-full">
                    Criar minha conta
                </x-ui.button>
            </div>

            <!-- Info -->
            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-xs text-slate-600">
                <p class="mb-2 font-medium text-slate-800">Como funciona:</p>
                <ul class="list-inside list-disc space-y-1 text-slate-600">
                    <li>Cada conta autenticada possui um usuário local vinculado</li>
                    <li>Seus produtos serão associados automaticamente ao seu perfil</li>
                    <li>Na listagem, você visualiza apenas seus produtos</li>
                </ul>
            </div>
        </form>
    @endif
@endsection
