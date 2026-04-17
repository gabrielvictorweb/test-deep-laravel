<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Cadastro')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Space Grotesk', sans-serif;
                background-color: #f6f8fc;
                background-image:
                    radial-gradient(at 10% 0%, rgba(125, 211, 252, 0.35) 0px, transparent 45%),
                    radial-gradient(at 90% 10%, rgba(196, 181, 253, 0.30) 0px, transparent 45%),
                    radial-gradient(at 50% 100%, rgba(165, 180, 252, 0.25) 0px, transparent 55%);
                background-attachment: fixed;
            }

            body::before {
                content: '';
                position: fixed;
                inset: 0;
                pointer-events: none;
                background-image:
                    linear-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
                background-size: 32px 32px;
                mask-image: radial-gradient(ellipse at center, black 40%, transparent 75%);
                -webkit-mask-image: radial-gradient(ellipse at center, black 40%, transparent 75%);
            }

            .glow-card {
                position: relative;
                border-radius: 1.5rem;
                background: linear-gradient(#ffffff, #ffffff) padding-box,
                            linear-gradient(135deg, rgba(56, 189, 248, 0.55), rgba(129, 140, 248, 0.55)) border-box;
                border: 1px solid transparent;
                box-shadow:
                    0 1px 0 rgba(255, 255, 255, 0.7) inset,
                    0 1px 2px rgba(15, 23, 42, 0.04),
                    0 20px 50px -20px rgba(79, 70, 229, 0.25);
            }

            .fade-in {
                animation: fadeIn 260ms cubic-bezier(0.2, 0.8, 0.2, 1) both;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to   { opacity: 1; transform: translateY(0); }
            }
        </style>
    </head>
    <body class="min-h-screen text-slate-800 antialiased">
        <div class="relative mx-auto flex min-h-screen w-full max-w-2xl flex-col items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="w-full">
                <div class="mb-8 flex flex-col items-center justify-between gap-4 sm:flex-row sm:gap-2">
                    <a href="/" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition hover:text-slate-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6" />
                        </svg>
                        Voltar
                    </a>
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white/80 px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm backdrop-blur transition hover:border-slate-300 hover:bg-white">
                            Entrar na conta
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6" />
                            </svg>
                        </a>
                    @endif
                </div>

                @if (session('success'))
                    <div class="fade-in mb-4 flex items-start gap-3 rounded-2xl border border-emerald-200/70 bg-emerald-50/80 px-4 py-3 text-sm text-emerald-800 shadow-sm backdrop-blur">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="fade-in mb-4 flex items-start gap-3 rounded-2xl border border-amber-200/70 bg-amber-50/80 px-4 py-3 text-sm text-amber-800 shadow-sm backdrop-blur">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        <span>{{ session('warning') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="fade-in mb-4 rounded-2xl border border-rose-200/70 bg-rose-50/80 px-4 py-3 text-sm text-rose-800 shadow-sm backdrop-blur">
                        <p class="mb-2 font-semibold">Corrija os erros abaixo:</p>
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="glow-card fade-in p-6 sm:p-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
