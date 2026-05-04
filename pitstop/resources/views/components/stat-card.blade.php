@props([
    'judul',
    'nilai',
    'ikon' => '#',
    'warna' => 'blue',
    'id' => null,
])

@php
    $colorClass = match ($warna) {
        'amber' => 'border-amber-200 bg-amber-50 text-amber-600',
        'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-600',
        'red' => 'border-red-200 bg-red-50 text-red-600',
        'slate' => 'border-slate-200 bg-slate-50 text-slate-600',
        default => 'border-blue-100 bg-blue-50 text-blue-600',
    };
@endphp

<div {{ $attributes->merge(['class' => "flex items-center gap-4 rounded-lg border p-4 {$colorClass}"]) }}>
    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-lg bg-white text-xs font-black">
        {{ $ikon }}
    </span>
    <div>
        <h3 class="text-sm font-bold text-slate-500">{{ $judul }}</h3>
        <p @if ($id) id="{{ $id }}" @endif class="text-2xl font-black text-slate-800">{{ $nilai }}</p>
    </div>
</div>
