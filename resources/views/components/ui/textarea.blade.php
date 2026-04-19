<textarea
    {{ $attributes->merge([
        'class' => 'block w-full min-h-[130px] resize-y rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-cyan-500 focus:ring-cyan-500',
    ]) }}
>{{ $slot }}</textarea>
