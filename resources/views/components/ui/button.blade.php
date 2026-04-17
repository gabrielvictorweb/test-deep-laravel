@props([
    'variant' => 'default',
    'type' => 'button',
    'size' => 'md',
])

@php
    $base = 'group relative inline-flex items-center justify-center gap-2 rounded-2xl font-semibold tracking-tight transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white disabled:cursor-not-allowed disabled:opacity-50';

    $sizes = [
        'sm' => 'px-3.5 py-2 text-xs',
        'md' => 'px-4.5 py-2.5 text-sm',
        'lg' => 'px-6 py-3.5 text-base',
    ];

    $styles = [
        'default' => 'bg-linear-to-br from-cyan-500 via-sky-500 to-blue-600 text-white shadow-[0_1px_0_rgba(255,255,255,0.26)_inset,0_14px_26px_-14px_rgba(2,132,199,0.75)] hover:-translate-y-0.5 hover:shadow-[0_1px_0_rgba(255,255,255,0.26)_inset,0_20px_30px_-14px_rgba(2,132,199,0.85)] active:translate-y-0 active:brightness-95 focus-visible:ring-cyan-300',
        'outline' => 'border border-slate-300 bg-white/95 text-slate-700 shadow-sm hover:border-slate-400 hover:bg-slate-50 active:bg-slate-100 focus-visible:ring-slate-300',
        'danger' => 'bg-linear-to-br from-rose-500 to-red-600 text-white shadow-[0_1px_0_rgba(255,255,255,0.26)_inset,0_14px_26px_-14px_rgba(225,29,72,0.78)] hover:-translate-y-0.5 hover:shadow-[0_1px_0_rgba(255,255,255,0.26)_inset,0_20px_30px_-14px_rgba(225,29,72,0.86)] active:translate-y-0 focus-visible:ring-rose-300',
        'ghost' => 'bg-transparent text-slate-600 hover:bg-slate-100/90 hover:text-slate-900 active:bg-slate-200 focus-visible:ring-slate-300',
    ];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($styles[$variant] ?? $styles['default'])]) }}>
    {{ $slot }}
</button>
