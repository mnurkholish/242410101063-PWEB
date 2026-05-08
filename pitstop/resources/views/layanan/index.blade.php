@extends('layouts.app')

@section('title', 'Data Layanan - PitStop')

@section('content')
    @php
        $buttonClass =
            'inline-flex min-h-[42px] items-center justify-center rounded-lg border-0 px-4 py-3 text-center font-extrabold transition hover:-translate-y-0.5';
    @endphp

    <section class="px-[5%] py-10">
        <div class="mx-auto grid w-[min(1200px,100%)] gap-6">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.12em] text-amber-500">Master data bengkel</p>
                    <h1 class="mt-1 text-3xl font-black leading-tight text-slate-800">Daftar Layanan</h1>
                    <p class="mt-2 max-w-2xl text-sm font-bold text-slate-500">
                        Kelola nama layanan, estimasi harga, durasi pengerjaan, gambar, dan status aktif.
                    </p>
                </div>
                <a href="{{ route('layanan.create') }}"
                    class="{{ $buttonClass }} bg-blue-600 text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] hover:bg-blue-950">
                    Tambah Layanan
                </a>
            </div>

            <section
                class="rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)] sm:p-8">
                <div class="w-full overflow-x-auto md:[-webkit-overflow-scrolling:touch]">
                    <table class="w-full min-w-225 border-collapse">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">Layanan</th>
                                <th class="text-center align-middle">Harga</th>
                                <th class="text-center align-middle">Durasi</th>
                                <th class="text-center align-middle">Status</th>
                                <th class="text-center align-middle">Dibuat</th>
                                <th class="text-center align-middle">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($layanans as $layanan)
                                @php
                                    $gambarUrl = $layanan->gambar && \Illuminate\Support\Facades\Storage::disk('public')->exists($layanan->gambar)
                                        ? \Illuminate\Support\Facades\Storage::url($layanan->gambar)
                                        : asset('img/pitstop-logo.png');
                                @endphp
                                <tr>
                                    <td data-label="Layanan">
                                        <div class="flex items-center gap-3 text-left">
                                            <div
                                                class="grid h-14 w-14 shrink-0 place-items-center overflow-hidden rounded-lg bg-blue-50 text-xs font-black text-blue-700">
                                                <img src="{{ $gambarUrl }}" alt="{{ $layanan->nama }}"
                                                    class="h-full w-full object-cover">
                                            </div>
                                            <div class="min-w-0">
                                                <strong class="text-blue-950">{{ $layanan->nama }}</strong>
                                                <div class="muted line-clamp-2">
                                                    {{ $layanan->deskripsi ?? 'Belum ada deskripsi.' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Harga">Rp{{ number_format($layanan->estimasi_harga, 0, ',', '.') }}</td>
                                    <td data-label="Durasi">{{ $layanan->estimasi_durasi }} menit</td>
                                    <td data-label="Status">
                                        <span
                                            class="status-badge {{ $layanan->is_active ? 'status-selesai' : 'status-menunggu' }}">
                                            {{ $layanan->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td data-label="Dibuat">{{ $layanan->created_at?->format('d M Y') }}</td>
                                    <td data-label="Aksi" class="align-middle">
                                        <div
                                            class="action-group flex flex-wrap md:flex-nowrap items-center justify-center gap-2">
                                            <a class="btn-action btn-edit"
                                                href="{{ route('layanan.show', $layanan) }}">Detail</a>
                                            <a class="btn-action btn-status"
                                                href="{{ route('layanan.edit', $layanan) }}">Edit</a>
                                            <form class="formHapusLayanan"
                                                action="{{ route('layanan.destroy', $layanan) }}" method="POST"
                                                data-nama="{{ $layanan->nama }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-action btn-delete" type="submit">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-slate-500">
                                        Belum ada data layanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    {{ $layanans->links() }}
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
