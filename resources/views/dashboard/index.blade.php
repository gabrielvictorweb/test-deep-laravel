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
        <section class="relative overflow-hidden rounded-4xl border border-[#e6e1d5] bg-[#fffefb]/95 p-7 shadow-[0_1px_2px_rgba(15,23,42,0.05),0_28px_72px_-44px_rgba(15,23,42,0.7)] sm:p-10 page-enter stagger-1">
            <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-cyan-200/25 blur-3xl"></div>
            <div class="pointer-events-none absolute -left-20 bottom-0 h-60 w-60 rounded-full bg-orange-200/25 blur-3xl"></div>

            <div class="relative flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-teal-200/80 bg-teal-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-teal-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Workspace online
                    </span>

                    <h1 class="heading-font mt-4 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">
                        Bem-vindo, {{ $displayName }}
                    </h1>
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
                        Um painel pensado para produtividade: cadastre produtos, ajuste sua conta e acompanhe operações com uma interface limpa e profissional.
                    </p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 rounded-2xl border border-[#d9d2c1] bg-[#fffdf9] px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-[#c8bfa9] hover:bg-white">
                            Criar produto
                        </a>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 rounded-2xl border border-[#d9d2c1] bg-[#fffdf9] px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-[#c8bfa9] hover:bg-white">
                            Configurar perfil
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid gap-4 lg:grid-cols-3 page-enter stagger-2">
            <x-ui.card class="p-6">
                <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">Conta atual</p>
                <h3 class="mt-2 truncate text-lg font-bold text-slate-900">{{ $displayEmail }}</h3>
                <p class="mt-2 text-sm text-slate-600">Seu acesso está pronto para operar no painel de gestão.</p>
            </x-ui.card>

            <x-ui.card class="p-6">
                <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">Catálogo</p>
                <h3 class="mt-2 text-lg font-bold text-slate-900">Produtos centralizados</h3>
                <p class="mt-2 text-sm text-slate-600">Mantenha preço, descrição e imagem de cada item sempre atualizados.</p>
                <a href="{{ route('products.index') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-teal-700 hover:text-teal-800">
                    Abrir módulo
                    <span>></span>
                </a>
            </x-ui.card>

            <x-ui.card class="p-6">
                <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">Perfil</p>
                <h3 class="mt-2 text-lg font-bold text-slate-900">Dados pessoais</h3>
                <p class="mt-2 text-sm text-slate-600">Nome, e-mail, senha e avatar sincronizados com o fluxo autenticado.</p>
                <a href="{{ route('profile.edit') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-teal-700 hover:text-teal-800">
                    Atualizar dados
                    <span>></span>
                </a>
            </x-ui.card>
        </div>

        <x-ui.card class="p-6 sm:p-8 page-enter stagger-3">
            <div class="mb-6 flex items-end justify-between">
                <div>
                    <h2 class="heading-font text-xl font-bold tracking-tight text-slate-900">Fluxos rapidos</h2>
                    <p class="mt-1 text-sm text-slate-500">Ações que você mais usa no dia a dia.</p>
                </div>
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <a href="{{ route('products.index') }}" class="group flex items-center gap-4 rounded-2xl border border-[#e5dfd3] bg-[#fffefb] p-4 transition hover:-translate-y-0.5 hover:border-teal-200 hover:shadow-lg">
                    <div class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-teal-50 text-teal-700 ring-1 ring-teal-200/70">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="block text-sm font-semibold text-slate-900">Cadastrar produto</span>
                        <span class="block text-xs text-slate-500">Adicionar um novo item ao inventário</span>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" class="group flex items-center gap-4 rounded-2xl border border-[#e5dfd3] bg-[#fffefb] p-4 transition hover:-translate-y-0.5 hover:border-orange-200 hover:shadow-lg">
                    <div class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-orange-700 ring-1 ring-orange-200/70">
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
