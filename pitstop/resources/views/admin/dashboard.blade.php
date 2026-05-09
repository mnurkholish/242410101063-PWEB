@extends('layouts.app')

@section('title', 'Dashboard Admin - PitStop')

@section('content')
    <section class="px-[5%] py-10">
        <div class="mx-auto grid w-[min(1180px,100%)] gap-6">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Area admin</p>
                <h1 class="mt-1 text-3xl font-black leading-tight text-slate-800">Dashboard Admin</h1>
                <p class="mt-2 max-w-2xl text-sm font-bold text-slate-500">
                    Kelola data layanan, booking, dan kebutuhan operasional PitStop.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <x-stat-card judul="Total Layanan" nilai="{{ $totalLayanan }}" ikon="#" warna="blue" />
                <x-stat-card judul="Layanan Aktif" nilai="{{ $layananAktif }}" ikon="OK" warna="emerald" />
                <x-stat-card judul="Total Booking" nilai="{{ count($bookings) }}" ikon="!" warna="amber" />
            </div>

            <section class="rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)] sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Management</p>
                        <h2 class="mt-1 text-2xl font-black leading-tight text-slate-800">Layanan Bengkel</h2>
                    </div>
                    <a href="{{ route('admin.layanan.index') }}"
                        class="inline-flex min-h-[42px] items-center justify-center rounded-lg bg-blue-600 px-4 py-3 text-center font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-blue-950">
                        Kelola Layanan
                    </a>
                </div>
            </section>
        </div>
    </section>
@endsection
