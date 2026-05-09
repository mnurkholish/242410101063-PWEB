<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $layanans = Layanan::latest()->paginate(10);

        return view('layanan.index', compact('layanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Layanan $layanan)
    {
        return view('layanan.show', compact('layanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layanan $layanan)
    {
        return view('layanan.edit', compact('layanan'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan)
    {
        $this->deleteGambar($layanan->gambar);

        $layanan->delete();

        return redirect()
            ->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
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
