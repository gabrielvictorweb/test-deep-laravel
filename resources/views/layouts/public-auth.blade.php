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
                background:
                    radial-gradient(circle at 0% 0%, #e0f2fe 0%, transparent 35%),
                    radial-gradient(circle at 100% 0%, #ede9fe 0%, transparent 28%),
                    linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            }

            .glow-border {
                position: relative;
                border: 1px solid transparent;
                background: linear-gradient(#ffffff, #ffffff) padding-box,
                            linear-gradient(135deg, #38bdf8, #60a5fa) border-box;
            }
        </style>
    </head>
    <body class="min-h-screen text-slate-800">
        <div class="mx-auto flex min-h-screen w-full max-w-2xl flex-col items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="w-full">
                <!-- Header -->
                <div class="mb-8 flex flex-col items-center justify-between gap-4 sm:flex-row sm:gap-2">
                    <a href="/" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">← Voltar</a>
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="inline-flex rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
                            Entrar na conta
                        </a>
                    @endif
                </div>

                <!-- Alerts -->
                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        <div class="flex items-start gap-2">
                            <svg class="mt-0.5 h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                        <div class="flex items-start gap-2">
                            <svg class="mt-0.5 h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            <span>{{ session('warning') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        <p class="mb-2 font-semibold">Corrija os erros abaixo:</p>
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Content -->
                <div class="glow-border rounded-2xl bg-white p-6 shadow-sm sm:p-8">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
