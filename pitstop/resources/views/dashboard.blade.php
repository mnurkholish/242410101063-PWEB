@extends('layouts.app')

@section('title', 'Dashboard Pelanggan - PitStop')

@section('content')
    @php
        $buttonClass =
            'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 px-4 py-3 text-center font-extrabold transition hover:-translate-y-0.5';
    @endphp

    <section class="px-[5%] py-10">
        <div class="mx-auto grid w-[min(1180px,100%)] gap-6">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Area pelanggan</p>
                    <h1 class="mt-1 text-3xl font-black leading-tight text-slate-800">Dashboard Pelanggan</h1>
                    <p class="mt-2 max-w-2xl text-sm font-bold text-slate-500">
                        Selamat datang, {{ auth()->user()->name }}. Lihat layanan dan buat booking service kendaraan.
                    </p>
                </div>
                <a href="{{ url('/#booking-section') }}"
                    class="{{ $buttonClass }} bg-blue-600 text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] hover:bg-blue-950">
                    Buat Jadwal
                </a>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <x-stat-card judul="Total Booking" nilai="{{ count($bookings) }}" ikon="#" warna="blue" />
                <x-stat-card judul="Menunggu" nilai="{{ collect($bookings)->where('statusBooking', 'Menunggu')->count() }}" ikon="!" warna="amber" />
                <x-stat-card judul="Selesai" nilai="{{ collect($bookings)->where('statusBooking', 'Selesai')->count() }}" ikon="OK" warna="emerald" />
            </div>

            <section class="rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)] sm:p-8">
                <div class="mb-5">
                    <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Riwayat booking</p>
                    <h2 class="mt-1 text-2xl font-black leading-tight text-slate-800">Booking Terbaru</h2>
                </div>

                <div class="w-full overflow-x-auto">
                    <table class="w-full min-w-225 border-collapse">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Service</th>
                                <th>Jadwal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td data-label="Kode"><strong>{{ $booking['kodeBooking'] }}</strong></td>
                                    <td data-label="Pelanggan">{{ $booking['namaPelanggan'] }}</td>
                                    <td data-label="Kendaraan">
                                        {{ $booking['jenisKendaraan'] }}
                                        <div class="muted">{{ $booking['merekKendaraan'] }}</div>
                                    </td>
                                    <td data-label="Service">{{ implode(', ', $booking['jenisService']) }}</td>
                                    <td data-label="Jadwal">{{ $booking['tanggalService'] }} {{ $booking['jamService'] }} WIB</td>
                                    <td data-label="Status">
                                        <span class="status-badge status-{{ strtolower($booking['statusBooking']) }}">
                                            {{ $booking['statusBooking'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </section>
@endsection
