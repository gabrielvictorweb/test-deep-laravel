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
        <section class="relative overflow-hidden rounded-3xl border border-slate-200/70 bg-gradient-to-br from-white via-white to-sky-50/60 p-8 shadow-[0_1px_2px_rgba(15,23,42,0.04),0_20px_50px_-20px_rgba(79,70,229,0.18)] sm:p-10">
            <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-gradient-to-br from-sky-200/50 to-indigo-300/40 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-20 -left-10 h-48 w-48 rounded-full bg-gradient-to-br from-violet-200/40 to-sky-200/30 blur-3xl"></div>

            <div class="relative flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
                <div class="max-w-3xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-sky-200/70 bg-white/80 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-sky-700 shadow-sm backdrop-blur">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Bem-vindo de volta
                    </span>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                        Olá, <span class="bg-gradient-to-r from-sky-600 to-indigo-600 bg-clip-text text-transparent">{{ $displayName }}</span>
                    </h1>
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-slate-600">
                        Este é seu painel principal. A partir daqui você consegue cadastrar produtos, atualizar seu perfil e acompanhar rapidamente suas ações.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-2">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-b from-sky-500 to-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-[0_1px_0_rgba(255,255,255,0.25)_inset,0_6px_16px_-6px_rgba(2,132,199,0.55)] transition hover:from-sky-500 hover:to-sky-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" /></svg>
                            Novo produto
                        </a>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white/80 px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm backdrop-blur transition hover:border-slate-300 hover:bg-white">
                            Editar perfil
                        </a>
                    </div>
                </div>

                <div class="shrink-0 self-start rounded-2xl border border-sky-200/70 bg-white/80 p-4 shadow-sm backdrop-blur">
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Painel ativo
                    </div>
                    <p class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Auth0</p>
                    <p class="text-xs text-slate-500">Sessão segura</p>
                </div>
            </div>
        </section>

        <div class="grid gap-4 md:grid-cols-3">
            <x-ui.card class="group p-6">
                <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-gradient-to-br from-sky-100 to-indigo-100 opacity-60 blur-2xl transition group-hover:opacity-100"></div>
                <div class="relative">
                    <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-sky-100 to-sky-200/60 text-sky-700 ring-1 ring-sky-200/60">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-500">Conta</p>
                    <h3 class="mt-1 truncate text-base font-semibold text-slate-900">{{ $displayEmail }}</h3>
                    <p class="mt-2 text-sm text-slate-600">Seu acesso Auth0 está ativo.</p>
                </div>
            </x-ui.card>

            <x-ui.card class="group p-6">
                <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 opacity-60 blur-2xl transition group-hover:opacity-100"></div>
                <div class="relative">
                    <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-200/60 text-emerald-700 ring-1 ring-emerald-200/60">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a1 1 0 0 0-.53-.88l-7.5-4a1 1 0 0 0-.94 0l-7.5 4A1 1 0 0 0 4 8v8a1 1 0 0 0 .53.88l7.5 4a1 1 0 0 0 .94 0l7.5-4A1 1 0 0 0 21 16Z" />
                        </svg>
                    </div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-500">Produtos</p>
                    <h3 class="mt-1 text-base font-semibold text-slate-900">Gerenciar inventário</h3>
                    <p class="mt-2 text-sm text-slate-600">Crie e atualize seus itens.</p>
                    <a href="{{ route('products.index') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-sky-700 transition hover:text-sky-800">
                        Acessar
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 transition group-hover:translate-x-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6" /></svg>
                    </a>
                </div>
            </x-ui.card>

            <x-ui.card class="group p-6">
                <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-gradient-to-br from-amber-100 to-orange-100 opacity-60 blur-2xl transition group-hover:opacity-100"></div>
                <div class="relative">
                    <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-amber-100 to-amber-200/60 text-amber-700 ring-1 ring-amber-200/60">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z" />
                        </svg>
                    </div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-500">Perfil</p>
                    <h3 class="mt-1 text-base font-semibold text-slate-900">Editar informações</h3>
                    <p class="mt-2 text-sm text-slate-600">Atualize nome, e-mail e foto.</p>
                    <a href="{{ route('profile.edit') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-sky-700 transition hover:text-sky-800">
                        Acessar
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 transition group-hover:translate-x-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6" /></svg>
                    </a>
                </div>
            </x-ui.card>
        </div>

        <x-ui.card class="p-6 sm:p-8">
            <div class="mb-5 flex items-end justify-between">
                <div>
                    <h2 class="text-lg font-bold tracking-tight text-slate-900">Ações rápidas</h2>
                    <p class="mt-1 text-sm text-slate-500">Acesse rapidamente as principais funcionalidades.</p>
                </div>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <a href="{{ route('products.index') }}" class="group flex items-center gap-4 rounded-2xl border border-slate-200/70 bg-gradient-to-br from-white to-slate-50/50 p-4 transition hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-lg">
                    <div class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-200/60 text-emerald-700 ring-1 ring-emerald-200/60">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="block text-sm font-semibold text-slate-900">Novo produto</span>
                        <span class="block text-xs text-slate-500">Cadastrar um item no inventário</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 shrink-0 text-slate-400 transition group-hover:translate-x-0.5 group-hover:text-slate-600"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6" /></svg>
                </a>

                <a href="{{ route('profile.edit') }}" class="group flex items-center gap-4 rounded-2xl border border-slate-200/70 bg-gradient-to-br from-white to-slate-50/50 p-4 transition hover:-translate-y-0.5 hover:border-sky-200 hover:shadow-lg">
                    <div class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-sky-100 to-sky-200/60 text-sky-700 ring-1 ring-sky-200/60">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="block text-sm font-semibold text-slate-900">Editar perfil</span>
                        <span class="block text-xs text-slate-500">Atualizar dados pessoais e avatar</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 shrink-0 text-slate-400 transition group-hover:translate-x-0.5 group-hover:text-slate-600"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6" /></svg>
                </a>
            </div>
        </x-ui.card>
    </div>
@endsection
