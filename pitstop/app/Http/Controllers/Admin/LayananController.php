<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim((string) $request->input('keyword', ''));

        $query = Layanan::query()
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query
                        ->where('nama', 'like', "%{$keyword}%")
                        ->orWhere('estimasi_harga', 'like', "%{$keyword}%")
                        ->orWhere('estimasi_durasi', 'like', "%{$keyword}%");

                    if (in_array(strtolower($keyword), ['aktif', 'active'], true)) {
                        $query->orWhere('is_active', true);
                    }

                    if (in_array(strtolower($keyword), ['nonaktif', 'inactive'], true)) {
                        $query->orWhere('is_active', false);
                    }
                });
            })
            ->latest();

        if ($request->expectsJson()) {
            return response()->json([
                'layanans' => $query->get()->map(fn (Layanan $layanan): array => $this->formatLayanan($layanan)),
            ]);
        }

        return view('admin.layanan.index', [
            'layanans' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('layanan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadGambar($request);
        }

        Layanan::create($validated);

        return redirect()
            ->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function show(Layanan $layanan)
    {
        return view('layanan.show', compact('layanan'));
    }

    public function edit(Layanan $layanan)
    {
        return view('layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $validated = $request->validate($this->rules());

        if ($request->hasFile('gambar')) {
            $this->deleteGambar($layanan->gambar);
            $validated['gambar'] = $this->uploadGambar($request);
        } else {
            unset($validated['gambar']);
        }

        $layanan->update($validated);

        return redirect()
            ->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        $this->deleteGambar($layanan->gambar);
        $layanan->delete();

        return redirect()
            ->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }

    private function formatLayanan(Layanan $layanan): array
    {
        return [
            'nama' => $layanan->nama,
            'deskripsi' => $layanan->deskripsi ?? 'Belum ada deskripsi.',
            'estimasiHarga' => $layanan->estimasi_harga,
            'estimasiDurasi' => $layanan->estimasi_durasi,
            'status' => $layanan->is_active ? 'Aktif' : 'Nonaktif',
            'statusClass' => $layanan->is_active ? 'status-selesai' : 'status-menunggu',
            'dibuat' => $layanan->created_at?->format('d M Y'),
            'gambarUrl' => $this->gambarUrl($layanan),
            'showUrl' => route('admin.layanan.show', $layanan),
            'editUrl' => route('admin.layanan.edit', $layanan),
            'deleteUrl' => route('admin.layanan.destroy', $layanan),
        ];
    }

    private function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'min:3', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'estimasi_harga' => ['required', 'integer', 'min:0'],
            'estimasi_durasi' => ['required', 'integer', 'min:1'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,png', 'max:2048'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    private function gambarUrl(Layanan $layanan): string
    {
        return $layanan->gambar && Storage::disk('public')->exists($layanan->gambar)
            ? Storage::url($layanan->gambar)
            : asset('img/pitstop-logo.png');
    }

    private function deleteGambar(?string $gambar): void
    {
        if ($gambar && Storage::disk('public')->exists($gambar)) {
            Storage::disk('public')->delete($gambar);
        }
    }

    private function uploadGambar(Request $request): string
    {
        $file = $request->file('gambar');
        $filename = Str::uuid().'.'.$file->extension();
        $directory = storage_path('app/public/layanan');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $file->move($directory, $filename);

        return 'layanan/'.$filename;
    }
}
