<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Dashboard')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=sora:400,500,600,700,800|manrope:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Manrope', sans-serif;
                background-color: #f6f7f4;
                background-image:
                    radial-gradient(at 12% 2%, rgba(14, 165, 233, 0.20) 0px, transparent 42%),
                    radial-gradient(at 88% 0%, rgba(245, 158, 11, 0.18) 0px, transparent 40%),
                    radial-gradient(at 50% 98%, rgba(20, 184, 166, 0.16) 0px, transparent 45%);
                background-attachment: fixed;
            }

            body::before {
                content: '';
                position: fixed;
                inset: 0;
                pointer-events: none;
                background-image:
                    linear-gradient(rgba(15, 23, 42, 0.04) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(15, 23, 42, 0.04) 1px, transparent 1px);
                background-size: 28px 28px;
                mask-image: radial-gradient(ellipse at center, black 34%, transparent 76%);
                -webkit-mask-image: radial-gradient(ellipse at center, black 34%, transparent 76%);
                z-index: 0;
            }

            .grain {
                position: fixed;
                inset: 0;
                pointer-events: none;
                opacity: 0.12;
                background-image: radial-gradient(rgba(15, 23, 42, 0.25) 0.6px, transparent 0.6px);
                background-size: 3px 3px;
                mix-blend-mode: soft-light;
                z-index: 0;
            }

            .heading-font {
                font-family: 'Sora', sans-serif;
                letter-spacing: -0.02em;
            }

            .page-enter {
                animation: pageEnter 360ms cubic-bezier(0.2, 0.8, 0.2, 1) both;
            }

            .stagger-1 { animation-delay: 40ms; }
            .stagger-2 { animation-delay: 100ms; }
            .stagger-3 { animation-delay: 160ms; }

            @keyframes pageEnter {
                from {
                    opacity: 0;
                    transform: translateY(12px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </head>
    <body class="min-h-screen text-slate-800 antialiased selection:bg-cyan-200/70">
        <div class="grain"></div>

        <div class="relative mx-auto flex min-h-screen w-full max-w-screen-2xl gap-6 px-4 py-6 sm:px-6 lg:px-8">
            <aside class="hidden w-72 shrink-0 md:block">
                <div class="sticky top-6">
                    <x-ui.sidebar />
                </div>
            </aside>

            <div class="min-w-0 flex-1">
                <div class="mb-4 rounded-2xl border border-slate-200/70 bg-white/80 p-3 shadow-sm backdrop-blur md:hidden page-enter">
                    <details class="group">
                        <summary class="flex cursor-pointer items-center justify-between rounded-xl bg-slate-100/90 px-4 py-2.5 text-sm font-semibold text-slate-700">
                            <span class="inline-flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M3 12h18M3 18h18" />
                                </svg>
                                Menu
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 shrink-0 transition group-open:rotate-180">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
                            </svg>
                        </summary>

                        <div class="pt-3">
                            <x-ui.sidebar mobile="true" />
                        </div>
                    </details>
                </div>

                @if (session('success'))
                    <div class="page-enter stagger-1 mb-4 flex items-start gap-3 rounded-2xl border border-emerald-200/70 bg-emerald-50/80 px-4 py-3 text-sm text-emerald-800 shadow-sm backdrop-blur">
                        <span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-500/10 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        </span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="page-enter stagger-1 mb-4 flex items-start gap-3 rounded-2xl border border-amber-200/70 bg-amber-50/80 px-4 py-3 text-sm text-amber-800 shadow-sm backdrop-blur">
                        <span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-amber-500/10 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        </span>
                        <span>{{ session('warning') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="page-enter stagger-1 mb-4 rounded-2xl border border-rose-200/70 bg-rose-50/80 px-4 py-3 text-sm text-rose-800 shadow-sm backdrop-blur">
                        <p class="mb-2 font-semibold">Corrija os erros abaixo:</p>
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <main class="page-enter relative">@yield('content')</main>
            </div>
        </div>
    </body>
</html>
