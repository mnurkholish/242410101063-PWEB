<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 bg-blue-600 px-4 py-3 text-center text-sm font-extrabold text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] transition hover:-translate-y-0.5 hover:bg-blue-950 focus:outline-none focus:ring-4 focus:ring-blue-100']) }}>
    {{ $slot }}
</button>
