@props(['type' => 'text', 'error' => false])

<input
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'block w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-cyan-500 focus:ring-cyan-500' . ($error ? ' border-rose-400 focus:border-rose-500 focus:ring-rose-300' : ''),
    ]) }}
/>
