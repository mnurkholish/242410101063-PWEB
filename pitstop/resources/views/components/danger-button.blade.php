<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 bg-red-600 px-4 py-3 text-center text-sm font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-100']) }}>
    {{ $slot }}
</button>
