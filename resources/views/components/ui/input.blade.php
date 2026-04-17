@props(['type' => 'text', 'error' => false])

<input
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 shadow-[0_1px_0_rgba(15,23,42,0.02)] transition-all duration-200 placeholder:text-slate-400 hover:border-slate-300 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100' . ($error ? ' border-rose-400 focus:border-rose-500 focus:ring-rose-100' : ''),
    ]) }}
/>
