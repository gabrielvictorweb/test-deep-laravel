<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Painel de Produtos') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=sora:400,500,600,700,800|manrope:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --canvas: #f2f4ef;
                --ink: #0f172a;
                --muted: #475569;
                --panel: rgba(255, 255, 255, 0.88);
                --line: rgba(148, 163, 184, 0.26);
                --accent-a: #0284c7;
                --accent-b: #14b8a6;
            }

            body {
                font-family: 'Manrope', sans-serif;
                background: var(--canvas);
                background-image:
                    radial-gradient(at 10% 8%, rgba(2, 132, 199, 0.17) 0px, transparent 45%),
                    radial-gradient(at 90% 6%, rgba(251, 191, 36, 0.16) 0px, transparent 48%),
                    radial-gradient(at 55% 100%, rgba(20, 184, 166, 0.14) 0px, transparent 52%);
                background-attachment: fixed;
            }

            body::before {
                content: '';
                position: fixed;
                inset: 0;
                pointer-events: none;
                background-image:
                    linear-gradient(rgba(15, 23, 42, 0.03) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(15, 23, 42, 0.03) 1px, transparent 1px);
                background-size: 34px 34px;
                mask-image: radial-gradient(ellipse at center, black 35%, transparent 78%);
                -webkit-mask-image: radial-gradient(ellipse at center, black 35%, transparent 78%);
            }

            .noise {
                position: fixed;
                inset: 0;
                pointer-events: none;
                opacity: 0.1;
                background-image: radial-gradient(rgba(15, 23, 42, 0.24) 0.6px, transparent 0.6px);
                background-size: 3px 3px;
                mix-blend-mode: soft-light;
            }

            .heading-font {
                font-family: 'Sora', sans-serif;
                letter-spacing: -0.03em;
            }

            .intro {
                animation: intro 460ms cubic-bezier(0.2, 0.8, 0.2, 1) both;
            }

            .pop {
                animation: pop 520ms cubic-bezier(0.2, 0.8, 0.2, 1) both;
                animation-delay: 120ms;
            }

            @keyframes intro {
                from { opacity: 0; transform: translateY(12px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes pop {
                from { opacity: 0; transform: translateY(18px) scale(0.98); }
                to { opacity: 1; transform: translateY(0) scale(1); }
            }
        </style>
    </head>
    <body class="min-h-screen text-slate-800 antialiased">
        <div class="noise"></div>

        <div class="relative isolate mx-auto flex min-h-screen w-full max-w-7xl items-center px-4 py-10 sm:px-6 lg:px-8">
            <div class="absolute left-0 top-1/2 -z-10 h-60 w-60 -translate-x-1/2 -translate-y-1/2 rounded-full bg-cyan-300/30 blur-3xl"></div>
            <div class="absolute right-0 top-1/4 -z-10 h-56 w-56 translate-x-1/3 rounded-full bg-amber-300/30 blur-3xl"></div>

            <main class="grid w-full gap-6 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                <section class="intro rounded-4xl border border-white/70 bg-(--panel) p-7 shadow-[0_26px_70px_-36px_rgba(15,23,42,0.42)] backdrop-blur sm:p-10 lg:p-12">
                    <p class="mb-5 inline-flex items-center gap-2 rounded-full border border-cyan-200/80 bg-cyan-50/80 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] text-cyan-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Produto digital
                    </p>

                    <h1 class="heading-font text-4xl font-extrabold leading-[0.98] text-(--ink) sm:text-5xl lg:text-6xl">
                        Sua operação comercial
                        <span class="bg-linear-to-r from-cyan-700 via-sky-600 to-teal-600 bg-clip-text text-transparent">em um painel de alto nível</span>
                    </h1>

                    <p class="mt-6 max-w-xl text-base leading-relaxed text-(--muted) sm:text-lg">
                        Controle produtos, fotos e dados com uma interface rápida, elegante e pronta para escala.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">
                        <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1.5 ring-1 ring-slate-200/70">
                            <span class="h-1.5 w-1.5 rounded-full bg-cyan-500"></span>
                            Fluxo intuitivo
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1.5 ring-1 ring-slate-200/70">
                            <span class="h-1.5 w-1.5 rounded-full bg-teal-500"></span>
                            Resposta instantanea
                        </span>
                    </div>
                </section>

                <section class="pop rounded-4xl border border-(--line) bg-white/92 p-6 shadow-[0_22px_60px_-36px_rgba(2,132,199,0.5)] sm:p-8 lg:p-10">
                    <div class="rounded-3xl border border-slate-200/70 bg-slate-50/80 p-5 sm:p-6">
                        @guest
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Acesso</p>
                            <h2 class="heading-font mt-2 text-2xl font-bold text-slate-900">Entrar ou criar conta</h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                                Um unico ponto de entrada para voce comecar agora.
                            </p>

                            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                @if (Route::has('login'))
                                    <a
                                        href="{{ route('login') }}"
                                        class="inline-flex items-center justify-center rounded-2xl bg-linear-to-br from-(--accent-a) via-sky-500 to-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-[0_16px_35px_-18px_rgba(2,132,199,0.85)] transition duration-200 hover:-translate-y-0.5"
                                    >
                                        Entrar
                                    </a>
                                @endif

                                <a
                                    href="{{ route('users.create') }}"
                                    class="inline-flex items-center justify-center rounded-2xl border border-slate-300/90 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition duration-200 hover:border-slate-400 hover:bg-slate-100"
                                >
                                    Cadastrar
                                </a>
                            </div>
                        @else
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Sessao ativa</p>
                            <h2 class="heading-font mt-2 text-2xl font-bold text-slate-900">Bem-vindo de volta</h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                                Continue de onde parou no painel principal.
                            </p>

                            <div class="mt-6">
                                <a
                                    href="{{ route('dashboard') }}"
                                    class="inline-flex w-full items-center justify-center rounded-2xl bg-linear-to-r from-(--accent-a) to-(--accent-b) px-5 py-3 text-sm font-semibold text-white shadow-[0_16px_35px_-18px_rgba(2,132,199,0.85)] transition duration-200 hover:-translate-y-0.5"
                                >
                                    Ir para dashboard
                                </a>
                            </div>
                        @endguest
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
