<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Dashboard')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Space Grotesk', sans-serif;
                background:
                    radial-gradient(circle at 0% 0%, #e0f2fe 0%, transparent 35%),
                    radial-gradient(circle at 100% 0%, #dbeafe 0%, transparent 30%),
                    linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            }

            .fade-in {
                animation: fadeIn 220ms ease-out both;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(8px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </head>
    <body class="min-h-screen text-slate-800">
        <div class="mx-auto flex min-h-screen w-full max-w-screen-2xl gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <aside class="hidden w-72 shrink-0 md:block">
                <div class="sticky top-4">
                    <x-ui.sidebar />
                </div>
            </aside>

            <div class="min-w-0 flex-1">
                <div class="mb-4 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm md:hidden">
                    <details class="group">
                        <summary class="flex cursor-pointer items-center justify-between rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-700">
                            <span class="inline-flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M3 12h18M3 18h18" />
                                </svg>
                                Menu
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 shrink-0 transition group-open:rotate-180">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
                            </svg>
                        </summary>

                        <div class="pt-3">
                            <x-ui.sidebar mobile="true" />
                        </div>
                    </details>
                </div>

                @if (session('success'))
                    <div class="fade-in mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('warning'))
                    <div class="fade-in mb-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                        {{ session('warning') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="fade-in mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        <p class="mb-2 font-semibold">Corrija os erros abaixo:</p>
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <main class="fade-in">@yield('content')</main>
            </div>
        </div>
    </body>
</html>
