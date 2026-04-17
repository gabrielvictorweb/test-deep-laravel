@props(['type' => 'text', 'error' => false])

<input
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 transition-all duration-200 placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200' . ($error ? ' border-rose-400 focus:border-rose-500 focus:ring-rose-200' : ''),
    ]) }}
/>
