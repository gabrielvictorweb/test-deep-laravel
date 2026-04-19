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
        <section class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm sm:p-10">

            <div class="relative flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">
                        Bem-vindo, {{ $displayName }}
                    </h1>
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
                        Um painel pensado para produtividade: cadastre produtos, ajuste sua conta e acompanhe operações com uma interface limpa e profissional.
                    </p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-cyan-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-300">
                            Criar produto
                        </a>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:ring-4 focus:ring-slate-200">
                            Configurar perfil
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid gap-4 lg:grid-cols-3">
            <x-ui.card class="p-6">
                <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">Conta atual</p>
                <h3 class="mt-2 truncate text-lg font-bold text-slate-900">{{ $displayEmail }}</h3>
                <p class="mt-2 text-sm text-slate-600">Seu acesso está pronto para operar no painel de gestão.</p>
            </x-ui.card>

            <x-ui.card class="p-6">
                <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">Catálogo</p>
                <h3 class="mt-2 text-lg font-bold text-slate-900">Produtos centralizados</h3>
                <p class="mt-2 text-sm text-slate-600">Mantenha preço, descrição e imagem de cada item sempre atualizados.</p>
                <a href="{{ route('products.index') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-cyan-700 hover:text-cyan-800">
                    Abrir módulo
                    <span>></span>
                </a>
            </x-ui.card>

            <x-ui.card class="p-6">
                <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">Perfil</p>
                <h3 class="mt-2 text-lg font-bold text-slate-900">Dados pessoais</h3>
                <p class="mt-2 text-sm text-slate-600">Nome, e-mail, senha e avatar sincronizados com o fluxo autenticado.</p>
                <a href="{{ route('profile.edit') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-cyan-700 hover:text-cyan-800">
                    Atualizar dados
                    <span>></span>
                </a>
            </x-ui.card>
        </div>

        <x-ui.card class="p-6 sm:p-8">
            <div class="mb-6 flex items-end justify-between">
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-slate-900">Fluxos rapidos</h2>
                    <p class="mt-1 text-sm text-slate-500">Ações que você mais usa no dia a dia.</p>
                </div>
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <a href="{{ route('products.create') }}" class="group flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-4 transition hover:border-cyan-200 hover:bg-cyan-50/40">
                    <div class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-cyan-50 text-cyan-700 ring-1 ring-cyan-200/70">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="block text-sm font-semibold text-slate-900">Cadastrar produto</span>
                        <span class="block text-xs text-slate-500">Adicionar um novo item ao inventário</span>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" class="group flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-4 transition hover:border-cyan-200 hover:bg-cyan-50/40">
                    <div class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-cyan-50 text-cyan-700 ring-1 ring-cyan-200/70">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="block text-sm font-semibold text-slate-900">Editar perfil</span>
                        <span class="block text-xs text-slate-500">Atualizar seus dados e foto</span>
                    </div>
                </a>
            </div>
        </x-ui.card>
    </div>
@endsection
