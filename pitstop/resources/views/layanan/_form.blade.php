@php
    $fieldClass =
        'min-h-[46px] w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-3 text-slate-800 outline-none transition focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100';
    $labelClass = 'text-sm font-extrabold text-slate-800';
@endphp

<div class="grid gap-4 md:grid-cols-2">
    <div class="form-group grid gap-2 md:col-span-2">
        <label class="{{ $labelClass }}" for="nama">Nama Layanan</label>
        <input class="{{ $fieldClass }}" type="text" id="nama" name="nama"
            value="{{ old('nama', $layanan->nama ?? '') }}" placeholder="Contoh: Ganti Oli" autocomplete="off">
        @error('nama')
            <small class="error-message">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group grid gap-2">
        <label class="{{ $labelClass }}" for="estimasi_harga">Estimasi Harga</label>
        <input class="{{ $fieldClass }}" type="number" id="estimasi_harga" name="estimasi_harga"
            value="{{ old('estimasi_harga', $layanan->estimasi_harga ?? '') }}" min="0" step="1000"
            placeholder="350000">
        @error('estimasi_harga')
            <small class="error-message">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group grid gap-2">
        <label class="{{ $labelClass }}" for="estimasi_durasi">Estimasi Durasi (menit)</label>
        <input class="{{ $fieldClass }}" type="number" id="estimasi_durasi" name="estimasi_durasi"
            value="{{ old('estimasi_durasi', $layanan->estimasi_durasi ?? '') }}" min="1" placeholder="30">
        @error('estimasi_durasi')
            <small class="error-message">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group grid gap-2 md:col-span-2">
        <label class="{{ $labelClass }}" for="gambar">Foto Layanan</label>
        <input class="{{ $fieldClass }} file:mr-4 file:rounded-lg file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-sm file:font-extrabold file:text-white"
            type="file" id="gambar" name="gambar" accept=".jpg,.png,image/jpeg,image/png">
        <small class="text-xs font-bold text-slate-500">Format JPG atau PNG, maksimal 2 MB.</small>
        @if (isset($layanan) && $layanan->gambar)
            <small class="text-xs font-bold text-slate-500">Foto saat ini: {{ $layanan->gambar }}</small>
        @endif
        @error('gambar')
            <small class="error-message">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group grid gap-2 md:col-span-2">
        <label class="{{ $labelClass }}" for="deskripsi">Deskripsi</label>
        <textarea class="{{ $fieldClass }} min-h-32 resize-y" id="deskripsi" name="deskripsi"
            placeholder="Tuliskan detail singkat layanan">{{ old('deskripsi', $layanan->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <small class="error-message">{{ $message }}</small>
        @enderror
    </div>
</div>

<input type="hidden" name="is_active" value="0">
<label
    class="mt-5 flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4 transition hover:border-blue-600 hover:bg-blue-50">
    <input class="mt-1 h-4.5 w-4.5 accent-blue-600" type="checkbox" name="is_active" value="1"
        @checked(old('is_active', $layanan->is_active ?? true))>
    <span class="grid gap-0.5">
        <span class="font-extrabold text-slate-800">Layanan aktif</span>
        <span class="text-sm font-bold text-slate-500">Tampilkan layanan ini untuk dipilih pada proses booking.</span>
    </span>
</label>
@error('is_active')
    <small class="error-message mt-2 block">{{ $message }}</small>
@enderror
