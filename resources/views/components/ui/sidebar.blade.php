@props([
    'mobile' => false,
])

@php
    $item = 'group relative flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200';
    $active = 'bg-gradient-to-r from-sky-50 to-indigo-50 text-sky-700 shadow-[0_1px_0_rgba(255,255,255,0.8)_inset] ring-1 ring-sky-200/70';
    $inactive = 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900';

    $displayName = (string) (data_get(auth()->user(), 'name') ?? data_get(auth()->user(), 'nickname') ?? 'Usuário');
    $displayEmail = (string) (data_get(auth()->user(), 'email') ?? 'email@example.com');
    $avatarUrl = Route::has('profile.avatar')
        ? route('profile.avatar')
        : (data_get(auth()->user(), 'avatar_url') ?? data_get(auth()->user(), 'picture'));
@endphp

<aside {{ $attributes->merge(['class' => ($mobile ? 'w-full' : 'h-[calc(100vh-3rem)]') . ' flex flex-col overflow-hidden rounded-2xl border border-slate-200/70 bg-white/85 shadow-[0_1px_2px_rgba(15,23,42,0.04),0_18px_40px_-20px_rgba(15,23,42,0.18)] backdrop-blur-xl']) }}>
    <div class="border-b border-slate-200/70 px-4 py-5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <span class="relative inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-sky-500 to-indigo-500 text-white shadow-[0_1px_0_rgba(255,255,255,0.25)_inset,0_6px_16px_-6px_rgba(79,70,229,0.55)]">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7h-6v7H4a1 1 0 0 1-1-1v-10.5Z" />
                </svg>
            </span>

            <span class="min-w-0">
                <span class="block truncate text-sm font-bold tracking-tight text-slate-900">Painel</span>
                <span class="block truncate text-xs text-slate-500">Gestão de produtos</span>
            </span>
        </a>
    </div>

    <div class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
        <p class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-400">Navegação</p>

        <a href="{{ route('dashboard') }}" class="{{ $item }} {{ request()->routeIs('dashboard') ? $active : $inactive }}">
            @if (request()->routeIs('dashboard'))
                <span class="absolute left-0 top-1/2 h-5 w-[3px] -translate-y-1/2 rounded-r-full bg-gradient-to-b from-sky-500 to-indigo-500"></span>
            @endif
            <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white text-sky-600 shadow-sm' : 'text-slate-500 group-hover:text-slate-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10Zm10 8h8v-6h-8v6Zm0-10h8V3h-8v8ZM3 21h8v-6H3v6Z" />
                </svg>
            </span>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('products.index') }}" class="{{ $item }} {{ request()->routeIs('products.*') ? $active : $inactive }}">
            @if (request()->routeIs('products.*'))
                <span class="absolute left-0 top-1/2 h-5 w-[3px] -translate-y-1/2 rounded-r-full bg-gradient-to-b from-sky-500 to-indigo-500"></span>
            @endif
            <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ request()->routeIs('products.*') ? 'bg-white text-sky-600 shadow-sm' : 'text-slate-500 group-hover:text-slate-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a1 1 0 0 0-.53-.88l-7.5-4a1 1 0 0 0-.94 0l-7.5 4A1 1 0 0 0 4 8v8a1 1 0 0 0 .53.88l7.5 4a1 1 0 0 0 .94 0l7.5-4A1 1 0 0 0 21 16Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.27 7.5 12 12l7.73-4.5M12 22V12" />
                </svg>
            </span>
            <span>Produtos</span>
        </a>

        <a href="{{ route('profile.edit') }}" class="{{ $item }} {{ request()->routeIs('profile.*') ? $active : $inactive }}">
            @if (request()->routeIs('profile.*'))
                <span class="absolute left-0 top-1/2 h-5 w-[3px] -translate-y-1/2 rounded-r-full bg-gradient-to-b from-sky-500 to-indigo-500"></span>
            @endif
            <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ request()->routeIs('profile.*') ? 'bg-white text-sky-600 shadow-sm' : 'text-slate-500 group-hover:text-slate-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </span>
            <span>Meu perfil</span>
        </a>
    </div>

    <div class="border-t border-slate-200/70 p-3">
        <div class="mb-2 flex items-center gap-3 rounded-xl bg-gradient-to-br from-slate-50 to-slate-100/60 p-2.5 ring-1 ring-slate-200/60">
            <div class="relative h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gradient-to-br from-sky-200 to-indigo-200 ring-2 ring-white">
                @if (is_string($avatarUrl) && $avatarUrl !== '')
                    <img
                        src="{{ $avatarUrl }}"
                        alt="Avatar"
                        class="h-full w-full object-cover"
                        onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden'); this.nextElementSibling.classList.add('flex');"
                    />
                    <div class="hidden h-full w-full items-center justify-center text-sm font-bold text-slate-700">{{ strtoupper(substr($displayName, 0, 1)) }}</div>
                @else
                    <div class="flex h-full w-full items-center justify-center text-sm font-bold text-slate-700">{{ strtoupper(substr($displayName, 0, 1)) }}</div>
                @endif
                <span class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full bg-emerald-400 ring-2 ring-white"></span>
            </div>

            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-slate-900">{{ $displayName }}</p>
                <p class="truncate text-xs text-slate-500">{{ $displayEmail }}</p>
            </div>
        </div>

        @if (Route::has('logout'))
            <a href="{{ route('logout') }}" class="{{ $item }} {{ $inactive }}">
                <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-500 group-hover:text-rose-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16 17 5-5-5-5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12H9" />
                    </svg>
                </span>
                <span class="group-hover:text-rose-600">Sair</span>
            </a>
        @endif
    </div>
</aside>
