<textarea
    {{ $attributes->merge([
        'class' => 'w-full min-h-[130px] resize-y rounded-2xl border border-slate-200/90 bg-white px-4 py-3 text-sm leading-relaxed font-medium text-slate-800 shadow-[0_1px_0_rgba(15,23,42,0.02)] placeholder:text-slate-400 transition-all duration-200 hover:border-slate-300 focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-100/80',
    ]) }}
>{{ $slot }}</textarea>
