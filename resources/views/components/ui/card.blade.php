<div {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white/92 shadow-[0_1px_2px_rgba(15,23,42,0.05),0_20px_45px_-24px_rgba(15,23,42,0.32)] backdrop-blur-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-[0_1px_2px_rgba(15,23,42,0.05),0_26px_56px_-24px_rgba(15,23,42,0.38)]']) }}>
    {{ $slot }}
</div>
