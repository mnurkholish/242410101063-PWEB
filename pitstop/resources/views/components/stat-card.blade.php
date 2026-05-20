@props([
    'judul',
    'nilai',
    'ikon' => '#',
    'warna' => 'blue',
    'id' => null,
])

@php
    $colorClass = match ($warna) {
        'amber' => 'border-amber-200 bg-amber-50 text-amber-600 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300',
        'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-600 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300',
        'red' => 'border-red-200 bg-red-50 text-red-600 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-300',
        'slate' => 'border-slate-200 bg-slate-50 text-slate-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300',
        default => 'border-blue-100 bg-blue-50 text-blue-600 dark:border-blue-500/30 dark:bg-blue-500/10 dark:text-blue-300',
    };
@endphp

<div {{ $attributes->merge(['class' => "flex items-center gap-4 rounded-lg border p-4 {$colorClass}"]) }}>
    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-lg bg-white text-xs font-black dark:bg-slate-950">
        {{ $ikon }}
    </span>
    <div>
        <h3 class="text-sm font-bold text-slate-500 dark:text-slate-400">{{ $judul }}</h3>
        <p @if ($id) id="{{ $id }}" @endif class="text-2xl font-black text-slate-800 dark:text-slate-100">{{ $nilai }}</p>
    </div>
</div>
