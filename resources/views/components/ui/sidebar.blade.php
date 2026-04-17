@props([
    'mobile' => false,
])

@php
    $item = 'group flex w-full items-center justify-between gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition';
    $active = 'bg-sky-100 text-sky-700 border border-sky-200';
    $inactive = 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 border border-transparent';

    $displayName = (string) (data_get(auth()->user(), 'name') ?? data_get(auth()->user(), 'nickname') ?? 'Usuário');
    $displayEmail = (string) (data_get(auth()->user(), 'email') ?? 'email@example.com');
    $avatarUrl = Route::has('profile.avatar')
        ? route('profile.avatar')
        : (data_get(auth()->user(), 'avatar_url') ?? data_get(auth()->user(), 'picture'));
@endphp

<aside {{ $attributes->merge(['class' => ($mobile ? 'w-full' : 'h-[calc(100vh-2rem)]') . ' flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm']) }}>
    <div class="border-b border-slate-200 px-4 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-sky-100 text-sky-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7h-6v7H4a1 1 0 0 1-1-1v-10.5Z" />
                </svg>
            </span>

            <span class="min-w-0">
                <span class="block truncate text-sm font-semibold text-slate-900">Painel</span>
                <span class="block truncate text-xs text-slate-500">Gestão de produtos</span>
            </span>
        </a>
    </div>

    <div class="flex-1 space-y-2 overflow-y-auto px-3 py-4">
        <a href="{{ route('dashboard') }}" class="{{ $item }} {{ request()->routeIs('dashboard') ? $active : $inactive }}">
            <span class="inline-flex items-center gap-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10Zm10 8h8v-6h-8v6Zm0-10h8V3h-8v8ZM3 21h8v-6H3v6Z" />
                </svg>
                Dashboard
            </span>
        </a>

        <a href="{{ route('products.index') }}" class="{{ $item }} {{ request()->routeIs('products.*') ? $active : $inactive }}">
            <span class="inline-flex items-center gap-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a1 1 0 0 0-.53-.88l-7.5-4a1 1 0 0 0-.94 0l-7.5 4A1 1 0 0 0 4 8v8a1 1 0 0 0 .53.88l7.5 4a1 1 0 0 0 .94 0l7.5-4A1 1 0 0 0 21 16Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.27 7.5 12 12l7.73-4.5M12 22V12" />
                </svg>
                Produtos
            </span>
        </a>

        <a href="{{ route('profile.edit') }}" class="{{ $item }} {{ request()->routeIs('profile.*') ? $active : $inactive }}">
            <span class="inline-flex items-center gap-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                Meu perfil
            </span>
        </a>
    </div>

    <div class="border-t border-slate-200 p-4">
        <div class="mb-3 flex items-center gap-3 rounded-xl bg-slate-50 p-2.5">
            <div class="h-9 w-9 overflow-hidden rounded-full bg-slate-200">
                @if (is_string($avatarUrl) && $avatarUrl !== '')
                    <img
                        src="{{ $avatarUrl }}"
                        alt="Avatar"
                        class="h-full w-full object-cover"
                        onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden'); this.nextElementSibling.classList.add('flex');"
                    />
                    <div class="hidden h-full w-full items-center justify-center text-xs font-semibold text-slate-600">{{ strtoupper(substr($displayName, 0, 1)) }}</div>
                @else
                    <div class="flex h-full w-full items-center justify-center text-xs font-semibold text-slate-600">{{ strtoupper(substr($displayName, 0, 1)) }}</div>
                @endif
            </div>

            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-slate-900">{{ $displayName }}</p>
                <p class="truncate text-xs text-slate-500">{{ $displayEmail }}</p>
            </div>
        </div>

        @if (Route::has('logout'))
            <a href="{{ route('logout') }}" class="{{ $item }} {{ $inactive }}">
                <span class="inline-flex items-center gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16 17 5-5-5-5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12H9" />
                    </svg>
                    Sair
                </span>
            </a>
        @endif
    </div>
</aside>
