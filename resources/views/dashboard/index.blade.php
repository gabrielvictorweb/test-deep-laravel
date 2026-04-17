@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    @php
        $displayName = data_get(auth()->user(), 'name')
            ?? data_get(auth()->user(), 'nickname')
            ?? data_get(auth()->user(), 'email')
            ?? 'Usuário autenticado';

        $displayEmail = data_get(auth()->user(), 'email') ?? 'email@example.com';
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div class="max-w-3xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Bem-vindo</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900 sm:text-4xl">{{ $displayName }}</h1>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                        Este é seu painel principal. A partir daqui você consegue cadastrar produtos, atualizar seu perfil e acompanhar rapidamente suas ações.
                    </p>
                </div>

                <div class="inline-flex items-center gap-2 rounded-xl bg-sky-50 px-4 py-3 text-sm font-semibold text-sky-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4.5 w-4.5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18" />
                    </svg>
                    Painel ativo
                </div>
            </div>
        </section>

        <div class="grid gap-4 md:grid-cols-3">
            <x-ui.card class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Conta</p>
                        <h3 class="mt-2 text-base font-semibold text-slate-900">{{ $displayEmail }}</h3>
                        <p class="mt-2 text-sm text-slate-600">Seu acesso Auth0 está ativo.</p>
                    </div>
                    <div class="rounded-xl bg-sky-50 p-2.5 text-sky-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4.5 w-4.5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Produtos</p>
                        <h3 class="mt-2 text-base font-semibold text-slate-900">Gerenciar inventário</h3>
                        <p class="mt-2 text-sm text-slate-600">Crie e atualize seus itens.</p>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-2.5 text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4.5 w-4.5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a1 1 0 0 0-.53-.88l-7.5-4a1 1 0 0 0-.94 0l-7.5 4A1 1 0 0 0 4 8v8a1 1 0 0 0 .53.88l7.5 4a1 1 0 0 0 .94 0l7.5-4A1 1 0 0 0 21 16Z" />
                        </svg>
                    </div>
                </div>
                <a href="{{ route('products.index') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-sky-700 hover:text-sky-800">
                    Acessar →
                </a>
            </x-ui.card>

            <x-ui.card class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Perfil</p>
                        <h3 class="mt-2 text-base font-semibold text-slate-900">Editar informações</h3>
                        <p class="mt-2 text-sm text-slate-600">Atualize nome, e-mail e foto.</p>
                    </div>
                    <div class="rounded-xl bg-amber-50 p-2.5 text-amber-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4.5 w-4.5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-sky-700 hover:text-sky-800">
                    Acessar →
                </a>
            </x-ui.card>
        </div>

        <x-ui.card class="p-6">
            <h2 class="text-lg font-semibold text-slate-900">Ações rápidas</h2>
            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 transition hover:border-slate-300 hover:bg-slate-100">
                    <div class="rounded-lg bg-emerald-100 p-2 text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4.5 w-4.5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">Novo produto</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 transition hover:border-slate-300 hover:bg-slate-100">
                    <div class="rounded-lg bg-sky-100 p-2 text-sky-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4.5 w-4.5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">Editar perfil</span>
                </a>
            </div>
        </x-ui.card>
    </div>
@endsection
