@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'min-h-[46px] w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-3 text-slate-800 shadow-sm outline-none transition focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100']) }}>
