@props([
    'variant' => 'default',
    'type' => 'button',
    'size' => 'md',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-lg font-semibold transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-300 focus-visible:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $styles = [
        'default' => 'bg-sky-600 text-white hover:bg-sky-700 active:bg-sky-800',
        'outline' => 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 active:bg-slate-100',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-700 active:bg-rose-800',
        'ghost' => 'bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900 active:bg-slate-200',
    ];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($styles[$variant] ?? $styles['default'])]) }}>
    {{ $slot }}
</button>
