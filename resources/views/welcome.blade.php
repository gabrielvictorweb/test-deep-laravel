<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Painel de Produtos') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=sora:400,500,600,700,800|manrope:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-linear-to-br from-slate-50 via-white to-cyan-50 text-slate-900 antialiased">
        <div class="mx-auto min-h-screen w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            <main class="grid gap-6 lg:grid-cols-12">
                <section class="space-y-6 lg:col-span-7">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                        <span class="mb-4 inline-flex items-center rounded-md bg-cyan-100 px-2.5 py-1 text-xs font-semibold uppercase tracking-wide text-cyan-800">Interface Flowbite pronta</span>
                        <h1 class="text-4xl font-black leading-tight text-slate-900 sm:text-5xl">Controle seu catalogo com velocidade e clareza</h1>
                        <p class="mt-4 max-w-2xl text-base text-slate-600 sm:text-lg">
                            Landing page montada com componentes e estilos do Flowbite para oferecer uma experiencia moderna e facil de manter.
                        </p>

                    </div>
                </section>

                <section class="lg:col-span-5">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                        @guest
                            <h2 class="text-3xl font-black text-slate-900">Acesse sua conta</h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600">Entre para continuar no dashboard.</p>

                            <div class="mt-6 space-y-3">
                                @if (Route::has('login'))
                                    <a href="{{ route('login') }}" class="inline-flex w-full items-center justify-center rounded-lg bg-cyan-600 px-5 py-3 text-sm font-bold text-white hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-300">
                                        Entrar
                                    </a>
                                @endif
                            </div>
                        @else
                            <h2 class="text-3xl font-black text-slate-900">Bem-vindo de volta</h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600">Seu ambiente esta pronto para continuar no dashboard.</p>

                            <div class="mt-6">
                                <a href="{{ route('dashboard') }}" class="inline-flex w-full items-center justify-center rounded-lg bg-cyan-600 px-5 py-3 text-sm font-bold text-white hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-300">
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
