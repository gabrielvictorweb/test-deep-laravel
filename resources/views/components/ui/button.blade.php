@props([
    'variant' => 'default',
    'type' => 'button',
    'size' => 'md',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-lg font-semibold transition focus:outline-none focus:ring-4 disabled:cursor-not-allowed disabled:opacity-60';

    $sizes = [
        'sm' => 'px-3 py-2 text-xs',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $styles = [
        'default' => 'bg-cyan-600 text-white hover:bg-cyan-700 focus:ring-cyan-300',
        'outline' => 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 focus:ring-slate-200',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-700 focus:ring-rose-300',
        'ghost' => 'bg-transparent text-slate-700 hover:bg-slate-100 focus:ring-slate-200',
    ];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($styles[$variant] ?? $styles['default'])]) }}>
    {{ $slot }}
</button>
