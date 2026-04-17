@props([
    'variant' => 'default',
    'type' => 'button',
    'size' => 'md',
])

@php
    $base = 'group relative inline-flex items-center justify-center gap-2 rounded-xl font-semibold tracking-tight transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white disabled:opacity-50 disabled:cursor-not-allowed';

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $styles = [
        'default' => 'bg-gradient-to-b from-sky-500 to-sky-600 text-white shadow-[0_1px_0_rgba(255,255,255,0.25)_inset,0_6px_16px_-6px_rgba(2,132,199,0.55)] hover:from-sky-500 hover:to-sky-700 hover:shadow-[0_1px_0_rgba(255,255,255,0.25)_inset,0_8px_22px_-6px_rgba(2,132,199,0.65)] active:from-sky-600 active:to-sky-800 focus-visible:ring-sky-300',
        'outline' => 'border border-slate-300 bg-white text-slate-700 shadow-sm hover:border-slate-400 hover:bg-slate-50 active:bg-slate-100 focus-visible:ring-slate-300',
        'danger' => 'bg-gradient-to-b from-rose-500 to-rose-600 text-white shadow-[0_1px_0_rgba(255,255,255,0.25)_inset,0_6px_16px_-6px_rgba(225,29,72,0.55)] hover:from-rose-500 hover:to-rose-700 active:from-rose-600 active:to-rose-800 focus-visible:ring-rose-300',
        'ghost' => 'bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900 active:bg-slate-200 focus-visible:ring-slate-300',
    ];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($styles[$variant] ?? $styles['default'])]) }}>
    {{ $slot }}
</button>
