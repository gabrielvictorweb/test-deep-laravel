<textarea
    {{ $attributes->merge([
        'class' => 'w-full min-h-[120px] resize-y rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 transition-all duration-200 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200',
    ]) }}
>{{ $slot }}</textarea>
