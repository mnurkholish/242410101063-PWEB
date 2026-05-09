@extends(request()->routeIs('admin.*') ? 'layouts.admin' : 'layouts.app')

@section('title', $layanan->nama . ' - PitStop')
@section('page-title', 'Detail Layanan')

@section('content')
    @php
        $isAdminArea = request()->routeIs('admin.*');
        $routePrefix = $isAdminArea ? 'admin.' : '';
        $buttonClass =
            'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 px-4 py-3 text-center font-extrabold transition hover:-translate-y-0.5';
        $gambarUrl =
            $layanan->gambar && \Illuminate\Support\Facades\Storage::disk('public')->exists($layanan->gambar)
                ? \Illuminate\Support\Facades\Storage::url($layanan->gambar)
                : asset('img/pitstop-logo.png');
    @endphp

    <section class="px-[5%] py-10">
        <div class="mx-auto grid w-[min(1000px,100%)] gap-6">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Detail layanan</p>
                    <h1 class="mt-1 text-3xl font-black leading-tight text-slate-800">{{ $layanan->nama }}</h1>
                </div>
                <div class="flex flex-wrap gap-3">
                    @if ($isAdminArea)
                        <a href="{{ route('admin.layanan.edit', $layanan) }}"
                            class="{{ $buttonClass }} bg-blue-600 text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] hover:bg-blue-950">
                            Edit Layanan
                        </a>
                    @endif
                    <a href="{{ route($routePrefix . 'layanan.index') }}"
                        class="{{ $buttonClass }} bg-slate-200 text-blue-950 hover:bg-slate-300">
                        Kembali
                    </a>
                </div>
            </div>

            <section
                class="grid overflow-hidden rounded-lg border border-slate-200/90 bg-white shadow-[0_18px_45px_rgba(14,43,82,0.10)] lg:grid-cols-[360px_minmax(0,1fr)]">
                <div class="grid min-h-72 place-items-center bg-blue-50 text-sm font-black text-blue-700">
                    <img src="{{ $gambarUrl }}" alt="{{ $layanan->nama }}" class="h-full w-full object-cover">
                </div>

                <div class="grid gap-5 p-5 sm:p-8">
                    <div>
                        <span class="status-badge {{ $layanan->is_active ? 'status-selesai' : 'status-menunggu' }}">
                            {{ $layanan->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        <p class="mt-4 text-slate-600">{{ $layanan->deskripsi ?? 'Belum ada deskripsi untuk layanan ini.' }}
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-black uppercase tracking-[0.08em] text-slate-500">Estimasi Harga</p>
                            <strong
                                class="mt-1 block text-xl text-blue-950">Rp{{ number_format($layanan->estimasi_harga, 0, ',', '.') }}</strong>
                        </div>
                        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-black uppercase tracking-[0.08em] text-slate-500">Estimasi Durasi</p>
                            <strong class="mt-1 block text-xl text-blue-950">{{ $layanan->estimasi_durasi }} menit</strong>
                        </div>
                        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-black uppercase tracking-[0.08em] text-slate-500">Terakhir Diperbarui</p>
                            <strong
                                class="mt-1 block text-blue-950">{{ $layanan->updated_at?->format('d M Y H:i') }}</strong>
                        </div>
                    </div>

                    @if ($isAdminArea)
                        <form class="formHapusLayanan" action="{{ route('admin.layanan.destroy', $layanan) }}" method="POST"
                            data-nama="{{ $layanan->nama }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn-action btn-delete" type="submit">Hapus Layanan</button>
                        </form>
                    @endif
                </div>
            </section>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.formHapusLayanan').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const nama = this.dataset.nama;
                Swal.fire({
                    title: 'Yakin?',
                    text: `Hapus layanan ${nama}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endpush
