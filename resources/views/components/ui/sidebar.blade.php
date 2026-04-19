@props(['mobile' => false])

@php
    $isMobile = filter_var($mobile, FILTER_VALIDATE_BOOLEAN);
    $userName = auth()->user()?->name ?? 'Usuario';
    $avatarFallback = strtoupper(substr((string) $userName, 0, 1));
    $currentAvatar = Route::has('profile.avatar') ? route('profile.avatar') : null;
@endphp

<aside class="relative w-full {{ $isMobile ? '' : 'max-w-[20rem]' }}">
    <div class="flex w-full flex-col rounded-2xl border border-slate-200 bg-white p-4 text-slate-700 shadow-sm {{ $isMobile ? 'max-h-[65vh] overflow-y-auto' : 'h-[calc(100vh-2rem)]' }}">
        <div class="mb-4 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <div class="flex items-center gap-3">
                <div class="h-12 w-12 shrink-0 overflow-hidden rounded-lg border border-slate-200 bg-white">
                    @if (is_string($currentAvatar) && $currentAvatar !== '')
                        <img
                            src="{{ $currentAvatar }}"
                            alt="Avatar de {{ $userName }}"
                            class="h-full w-full object-cover"
                            loading="lazy"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        />
                        <span class="hidden h-full w-full items-center justify-center text-base font-extrabold text-slate-700">{{ $avatarFallback }}</span>
                    @else
                        <span class="flex h-full w-full items-center justify-center text-base font-extrabold text-slate-700">{{ $avatarFallback }}</span>
                    @endif
                </div>

                <div>
                    <span class="mb-1 inline-flex rounded bg-cyan-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.16em] text-cyan-800">Usuario</span>
                    <p class="text-base font-extrabold leading-tight text-slate-900">{{ $userName }}</p>
                    <p class="mt-1 text-xs text-slate-500">Menu principal</p>
                </div>
            </div>
        </div>

        <nav class="space-y-2 text-sm font-semibold">
            <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 rounded-lg border px-3 py-2.5 transition {{ request()->routeIs('dashboard') ? 'border-cyan-200 bg-cyan-50 text-cyan-800' : 'border-transparent text-slate-700 hover:border-slate-200 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                    <path d="M3 13.5a1.5 1.5 0 011.5-1.5h5.25A1.5 1.5 0 0111.25 13.5v6A1.5 1.5 0 019.75 21H4.5A1.5 1.5 0 013 19.5v-6zm9.75-9A1.5 1.5 0 0114.25 3h5.25A1.5 1.5 0 0121 4.5v9A1.5 1.5 0 0119.5 15h-5.25a1.5 1.5 0 01-1.5-1.5v-9zM12.75 18a1.5 1.5 0 011.5-1.5h5.25A1.5 1.5 0 0121 18v1.5a1.5 1.5 0 01-1.5 1.5h-5.25a1.5 1.5 0 01-1.5-1.5V18zm-9.75-7.5A1.5 1.5 0 014.5 9h5.25a1.5 1.5 0 011.5 1.5v1.5a1.5 1.5 0 01-1.5 1.5H4.5A1.5 1.5 0 013 12v-1.5z" />
                </svg>
                Dashboard
            </a>

            <div class="rounded-lg border px-3 py-2.5 {{ request()->routeIs('products.*') ? 'border-cyan-200 bg-cyan-50 text-cyan-800' : 'border-transparent text-slate-700' }}">
                <a href="{{ route('products.index') }}" class="group flex items-center gap-3 transition {{ request()->routeIs('products.*') ? 'text-cyan-800' : 'text-slate-700 hover:text-slate-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M4.5 3.75a.75.75 0 000 1.5h1.125l1.74 9.276A2.25 2.25 0 009.577 16.5h6.846a2.25 2.25 0 002.212-1.974l.93-7.437A.75.75 0 0018.823 6H7.109l-.222-1.185A2.25 2.25 0 004.675 3H4.5zm5.625 15.75a1.875 1.875 0 113.75 0 1.875 1.875 0 01-3.75 0zm6 0a1.875 1.875 0 113.75 0 1.875 1.875 0 01-3.75 0z" clip-rule="evenodd" />
                    </svg>
                    Produtos
                </a>

                <div class="mt-2 space-y-1 pl-8 text-xs font-semibold">
                    <a href="{{ route('products.index') }}" class="block rounded px-2 py-1.5 transition {{ request()->routeIs('products.index') ? 'bg-cyan-100 text-cyan-800' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                        Lista de produtos
                    </a>
                    <a href="{{ route('products.create') }}" class="block rounded px-2 py-1.5 transition {{ request()->routeIs('products.create') ? 'bg-cyan-100 text-cyan-800' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                        Adicionar produto
                    </a>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" class="group flex items-center gap-3 rounded-lg border px-3 py-2.5 transition {{ request()->routeIs('profile.*') ? 'border-cyan-200 bg-cyan-50 text-cyan-800' : 'border-transparent text-slate-700 hover:border-slate-200 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.75 20.25a8.25 8.25 0 1116.5 0 .75.75 0 01-.75.75H4.5a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                </svg>
                Perfil
            </a>
        </nav>

        <div class="my-4 border-t border-slate-200"></div>

        <div class="rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-700">
            <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500">Resumo</p>
            <p class="mt-1 text-sm font-medium">Acesse rapidamente suas areas principais pelo menu lateral.</p>
        </div>

        @if (Route::has('logout'))
            <a href="{{ route('logout') }}" class="mt-auto inline-flex items-center justify-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2.5 text-sm font-bold text-rose-700 transition hover:bg-rose-100 focus:ring-4 focus:ring-rose-200">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                    <path fill-rule="evenodd" d="M16.72 7.22a.75.75 0 010 1.06L14.56 10.5h5.69a.75.75 0 010 1.5h-5.69l2.16 2.22a.75.75 0 01-1.08 1.04l-3.38-3.5a.75.75 0 010-1.04l3.38-3.5a.75.75 0 011.08 0z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M3.75 4.5A2.25 2.25 0 016 2.25h5.25a.75.75 0 010 1.5H6A.75.75 0 005.25 4.5v15A.75.75 0 006 20.25h5.25a.75.75 0 010 1.5H6a2.25 2.25 0 01-2.25-2.25v-15z" clip-rule="evenodd" />
                </svg>
                Sair
            </a>
        @endif
    </div>
</aside>
