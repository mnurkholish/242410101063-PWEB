@extends('layouts.app')

@section('title', 'Edit Layanan - PitStop')

@section('content')
    @php
        $buttonClass =
            'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 px-4 py-3 text-center font-extrabold transition hover:-translate-y-0.5';
    @endphp

    <section class="px-[5%] py-10">
        <div class="mx-auto grid w-[min(900px,100%)] gap-6">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Master data bengkel</p>
                <h1 class="mt-1 text-3xl font-black leading-tight text-slate-800">Edit Layanan</h1>
            </div>

            <section
                class="rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)] sm:p-8">
                <form action="{{ route('admin.layanan.update', $layanan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('layanan._form', ['layanan' => $layanan])

                    <div class="mt-6 flex flex-wrap gap-3">
                        <button type="submit"
                            class="{{ $buttonClass }} bg-blue-600 text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] hover:bg-blue-950">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.layanan.index') }}"
                            class="{{ $buttonClass }} bg-slate-200 text-blue-950 hover:bg-slate-300">
                            Kembali
                        </a>
                    </div>
                </form>
            </section>
        </div>
    </section>
@endsection
