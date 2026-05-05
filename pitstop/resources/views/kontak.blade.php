@extends('layouts.app')

@section('title', 'Kontak PitStop')

@section('content')
    @php
        $fieldClass =
            'min-h-[46px] w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-3 text-slate-800 outline-none transition focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100';
        $labelClass = 'text-sm font-extrabold text-slate-800';
        $buttonClass =
            'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 px-4 py-3 text-center font-extrabold transition hover:-translate-y-0.5';
    @endphp

    <section
        class="relative isolate overflow-hidden bg-[#071933] px-[5%] py-20 text-white after:absolute after:bottom-0 after:right-[5%] after:h-3 after:w-[min(520px,70vw)] after:bg-amber-400 after:content-['']">
        <div
            class="absolute inset-0 -z-10 bg-[linear-gradient(90deg,rgba(7,25,51,0.94),rgba(7,25,51,0.58)),url('https://images.unsplash.com/photo-1632823471565-1ecdf5c0d9e9?auto=format&fit=crop&w=1800&q=80')] bg-cover bg-center">
        </div>
        <div class="grid min-h-[48vh] items-center">
            <div class="max-w-3xl">
                <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-400">Kontak bengkel</p>
                <h1 class="mt-3 max-w-4xl text-4xl font-black leading-[1.04] sm:text-5xl lg:text-7xl">
                    Hubungi PitStop untuk Bantuan Service Kendaraan
                </h1>
                <p class="mt-4 max-w-2xl text-base text-white/90 sm:text-lg">
                    Tim kami siap membantu pertanyaan jadwal, jenis layanan, dan estimasi pengerjaan kendaraan Anda.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto grid w-[min(1180px,90%)] gap-6 py-14 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
        <aside
            class="grid gap-4 rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)]">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Informasi</p>
                <h2 class="mt-1 text-2xl font-black leading-tight text-slate-800">PitStop Service Center</h2>
            </div>
            <div class="grid gap-3 text-sm font-bold text-slate-600">
                <p>Jl. Kalimantan No. 10, Jember</p>
                <p>08.00 - 17.00 WIB</p>
                <p>support@pitstop.test</p>
                <p>0812-0000-2026</p>
            </div>
        </aside>

        <section class="rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)] sm:p-8">
            <div class="mb-5">
                <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Kirim pesan</p>
                <h2 class="mt-1 text-2xl font-black leading-tight text-slate-800">Form Kontak</h2>
            </div>

            <div class="form-feedback" id="kontakFeedback" role="status"></div>

            <form id="kontakForm" class="grid gap-4">
                <div class="grid gap-2">
                    <label class="{{ $labelClass }}" for="namaKontak">Nama</label>
                    <input class="{{ $fieldClass }}" type="text" id="namaKontak" placeholder="Masukkan nama Anda">
                </div>
                <div class="grid gap-2">
                    <label class="{{ $labelClass }}" for="topikKontak">Topik</label>
                    <select class="{{ $fieldClass }}" id="topikKontak">
                        <option value="Booking service">Booking service</option>
                        <option value="Estimasi biaya">Estimasi biaya</option>
                        <option value="Status pengerjaan">Status pengerjaan</option>
                    </select>
                </div>
                <div class="grid gap-2">
                    <label class="{{ $labelClass }}" for="pesanKontak">Pesan</label>
                    <textarea class="{{ $fieldClass }} min-h-32 resize-y" id="pesanKontak" placeholder="Tulis pesan singkat"></textarea>
                </div>
                <button type="submit"
                    class="{{ $buttonClass }} bg-blue-600 text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] hover:bg-blue-950">
                    Kirim Pesan
                </button>
            </form>
        </section>
    </section>
@endsection

@push('scripts')
    <script>
        const kontakForm = document.querySelector('#kontakForm');
        const kontakFeedback = document.querySelector('#kontakFeedback');

        kontakForm?.addEventListener('submit', (event) => {
            event.preventDefault();
            kontakFeedback.textContent =
                'Pesan kontak berhasil disiapkan. Tim PitStop akan segera menghubungi Anda.';
            kontakFeedback.className = 'form-feedback show success';
        });
    </script>
@endpush
