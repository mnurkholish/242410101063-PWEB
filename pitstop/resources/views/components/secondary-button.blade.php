<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 bg-slate-200 px-4 py-3 text-center text-sm font-extrabold text-blue-950 transition hover:-translate-y-0.5 hover:bg-slate-300 focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:opacity-25']) }}>
    {{ $slot }}
</button>
