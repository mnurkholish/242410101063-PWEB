@extends('layouts.admin')

@section('title', 'Data Layanan - PitStop')
@section('page-title', 'Kelola Layanan')

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
                <a href="{{ route('admin.layanan.create') }}"
                    class="{{ $buttonClass }} bg-blue-600 text-white shadow-[0_12px_24px_rgba(23,105,224,0.22)] hover:bg-blue-950">
                    Tambah Layanan
                </a>
            </div>

            <section
                class="rounded-lg border border-slate-200/90 bg-white p-5 shadow-[0_18px_45px_rgba(14,43,82,0.10)] sm:p-8">
                <form id="layananSearchForm" class="mb-5 grid gap-3 md:grid-cols-[minmax(0,1fr)_auto]"
                    action="{{ route('admin.layanan.search') }}" method="POST">
                    @csrf
                    <div class="grid gap-1.5">
                        <label class="text-sm font-extrabold text-slate-800" for="layananSearchInput">Cari Layanan</label>
                        <input
                            class="min-h-[46px] w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-3 text-slate-800 outline-none transition focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            type="search" id="layananSearchInput" name="keyword"
                            placeholder="Nama, harga, durasi, atau status" autocomplete="off">
                    </div>
                    <button
                        class="self-end inline-flex min-h-[46px] items-center justify-center rounded-lg border-0 bg-blue-600 px-4 py-3 text-center font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-blue-950"
                        type="submit">
                        Cari
                    </button>
                    <p id="layananSearchStatus" class="hidden text-sm font-bold text-slate-500 md:col-span-2" role="status">
                        Mencari data layanan...
                    </p>
                </form>

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
                        <tbody id="layananSearchResults">
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
                                                href="{{ route('admin.layanan.show', $layanan) }}">Detail</a>
                                            <a class="btn-action btn-status"
                                                href="{{ route('admin.layanan.edit', $layanan) }}">Edit</a>
                                            <form class="formHapusLayanan"
                                                action="{{ route('admin.layanan.destroy', $layanan) }}" method="POST"
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
                                    <td colspan="6" class="text-center text-slate-500">Belum ada data layanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-5" id="layananPagination">
                    {{ $layanans->links() }}
                </div>
            </section>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const form = document.querySelector('#layananSearchForm');
        const input = document.querySelector('#layananSearchInput');
        const tbody = document.querySelector('#layananSearchResults');
        const status = document.querySelector('#layananSearchStatus');
        const pagination = document.querySelector('#layananPagination');
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const csrf = `@csrf`;
        const methodDelete = `@method('DELETE')`;
        const esc = (value) => String(value ?? '').replace(/[&<>"']/g, (char) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        }[char]));

        const row = (layanan) => `
            <tr>
                <td data-label="Layanan">
                    <div class="flex items-center gap-3 text-left">
                        <div class="grid h-14 w-14 shrink-0 place-items-center overflow-hidden rounded-lg bg-blue-50 text-xs font-black text-blue-700">
                            <img src="${esc(layanan.gambarUrl)}" alt="${esc(layanan.nama)}" class="h-full w-full object-cover">
                        </div>
                        <div class="min-w-0">
                            <strong class="text-blue-950">${esc(layanan.nama)}</strong>
                            <div class="muted line-clamp-2">${esc(layanan.deskripsi)}</div>
                        </div>
                    </div>
                </td>
                <td data-label="Harga">Rp${Number(layanan.estimasiHarga).toLocaleString('id-ID')}</td>
                <td data-label="Durasi">${esc(layanan.estimasiDurasi)} menit</td>
                <td data-label="Status"><span class="status-badge ${esc(layanan.statusClass)}">${esc(layanan.status)}</span></td>
                <td data-label="Dibuat">${esc(layanan.dibuat)}</td>
                <td data-label="Aksi" class="align-middle">
                    <div class="action-group flex flex-wrap md:flex-nowrap items-center justify-center gap-2">
                        <a class="btn-action btn-edit" href="${esc(layanan.showUrl)}">Detail</a>
                        <a class="btn-action btn-status" href="${esc(layanan.editUrl)}">Edit</a>
                        <form class="formHapusLayanan" action="${esc(layanan.deleteUrl)}" method="POST" data-nama="${esc(layanan.nama)}">
                            ${csrf}${methodDelete}
                            <button class="btn-action btn-delete" type="submit">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>`;

        const searchLayanan = async () => {
            status.classList.remove('hidden');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                    body: JSON.stringify({ keyword: input.value }),
                });
                const data = await response.json();
                tbody.innerHTML = data.layanans.length
                    ? data.layanans.map(row).join('')
                    : '<tr><td colspan="6" class="text-center text-slate-500">Data layanan tidak ditemukan.</td></tr>';
                pagination.classList.add('hidden');
            } catch (error) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-red-600">Pencarian gagal. Coba ulangi lagi.</td></tr>';
            } finally {
                status.classList.add('hidden');
            }
        };

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            searchLayanan();
        });

        input.addEventListener('input', () => {
            clearTimeout(input.searchTimeout);
            input.searchTimeout = setTimeout(searchLayanan, 300);
        });

        document.addEventListener('submit', (event) => {
            const deleteForm = event.target.closest('.formHapusLayanan');

            if (!deleteForm) return;

            event.preventDefault();
            Swal.fire({
                title: 'Yakin?',
                text: `Hapus layanan ${deleteForm.dataset.nama}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => result.isConfirmed && deleteForm.submit());
        });
    </script>
@endpush
