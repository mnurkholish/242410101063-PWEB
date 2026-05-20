@extends('layouts.app')

@section('title', 'Preferensi - PitStop')

@section('content')
    @php
        $fieldClass =
            'min-h-[46px] w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-3 text-slate-800 outline-none transition focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-blue-400 dark:focus:bg-slate-950 dark:focus:ring-blue-500/20';
        $labelClass = 'text-sm font-extrabold text-slate-800 dark:text-slate-100';
        $buttonClass =
            'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 bg-blue-600 px-4 py-3 text-center font-extrabold text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] transition hover:-translate-y-0.5 hover:bg-blue-950';
    @endphp

    <section class="px-[5%] py-12">
        <div
            class="mx-auto grid w-[min(720px,100%)] gap-6 rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)] dark:border-slate-800 dark:bg-slate-900 dark:shadow-none sm:p-8">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Pengaturan tampilan</p>
                <h1 class="mt-1 text-2xl font-black leading-tight text-slate-800 dark:text-slate-100">Preferensi</h1>
            </div>

            <form id="preferenceForm" class="grid gap-5">
                <div class="grid gap-2">
                    <label class="{{ $labelClass }}" for="themePreference">Tema</label>
                    <select class="{{ $fieldClass }}" id="themePreference" name="theme">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                        <option value="system">System</option>
                    </select>
                </div>

                <div class="grid gap-2">
                    <label class="{{ $labelClass }}" for="fontSizePreference">Ukuran Font</label>
                    <select class="{{ $fieldClass }}" id="fontSizePreference" name="font_size">
                        <option value="small">Kecil</option>
                        <option value="normal">Normal</option>
                        <option value="large">Besar</option>
                    </select>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="{{ $buttonClass }}">Simpan Preferensi</button>
                    <a href="{{ route('home') }}"
                        class="inline-flex min-h-[42px] items-center justify-center rounded-lg bg-slate-200 px-4 py-3 text-center font-extrabold text-blue-950 transition hover:-translate-y-0.5 hover:bg-slate-300 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </section>
@endsection
