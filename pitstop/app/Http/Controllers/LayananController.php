<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim((string) $request->input('keyword', ''));

        $query = Layanan::query()
            ->aktif()
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query
                        ->where('nama', 'like', "%{$keyword}%")
                        ->orWhere('estimasi_harga', 'like', "%{$keyword}%");
                });
            })
            ->latest();

        if ($request->expectsJson()) {
            return response()->json([
                'layanans' => $query->get()->map(fn (Layanan $layanan): array => $this->formatLayanan($layanan)),
            ]);
        }

        return view('layanan.index', [
            'layanans' => $query->paginate(10)->withQueryString(),
        ]);
    }

    private function formatLayanan(Layanan $layanan): array
    {
        return [
            'nama' => $layanan->nama,
            'deskripsi' => $layanan->deskripsi ?? 'Belum ada deskripsi.',
            'estimasiHarga' => $layanan->estimasi_harga,
            'estimasiDurasi' => $layanan->estimasi_durasi,
            'status' => 'Aktif',
            'statusClass' => 'status-selesai',
            'dibuat' => $layanan->created_at?->format('d M Y'),
            'gambarUrl' => $layanan->gambar && Storage::disk('public')->exists($layanan->gambar)
                ? Storage::url($layanan->gambar)
                : asset('img/pitstop-logo.png'),
            'showUrl' => route('layanan.show', $layanan),
            'editUrl' => null,
            'deleteUrl' => null,
        ];
    }


    public function show(Layanan $layanan)
    {
        abort_unless($layanan->is_active, 404);

        return view('layanan.show', compact('layanan'));
    }

}
