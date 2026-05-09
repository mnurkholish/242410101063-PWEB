<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Layanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function home()
    {
        return view('index', [
            'layanans' => Layanan::aktif()->orderBy('nama')->get(),
            'bookings' => auth()->check() && ! auth()->user()->isAdmin()
                ? $this->userBookings()
                : [],
        ]);
    }

    public function index()
    {
        return view('dashboard', [
            'bookings' => $this->userBookings(),
        ]);
    }

    public function bookings()
    {
        return view('bookings.index', [
            'bookings' => $this->userBookings(),
        ]);
    }

    public function admin()
    {
        return view('admin.dashboard', [
            'totalLayanan' => Layanan::count(),
            'layananAktif' => Layanan::where('is_active', true)->count(),
            'totalBooking' => Booking::count(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomorPlat' => ['required', 'string'],
            'jenisKendaraan' => ['required', 'string'],
            'merekKendaraan' => ['required', 'string'],
            'tanggalService' => ['required', 'date'],
            'jamService' => ['required', 'date_format:H:i'],
            'slot' => ['required', Rule::in(['A', 'B', 'C'])],
            'layanan_id' => ['required', 'array', 'min:1'],
            'layanan_id.*' => ['integer', 'exists:layanans,id'],
        ]);

        $layanans = Layanan::query()
            ->aktif()
            ->whereIn('id', $validated['layanan_id'])
            ->get();

        if ($layanans->count() !== count(array_unique($validated['layanan_id']))) {
            return back()
                ->withErrors(['layanan_id' => 'Pilih layanan yang masih aktif.'])
                ->withInput();
        }

        $startTime = Carbon::parse($validated['tanggalService'].' '.$validated['jamService']);
        $totalDurasi = $layanans->sum('estimasi_durasi');

        $booking = DB::transaction(function () use ($validated, $layanans, $startTime, $totalDurasi): Booking {
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'slot' => $validated['slot'],
                'start_time' => $startTime,
                'end_time' => $startTime->copy()->addMinutes($totalDurasi),
                'jenis_kendaraan' => $validated['jenisKendaraan'],
                'merek_kendaraan' => $validated['merekKendaraan'],
                'nomor_plat' => strtoupper($validated['nomorPlat']),
                'total_estimasi_harga' => $layanans->sum('estimasi_harga'),
                'total_estimasi_durasi' => $totalDurasi,
                'status' => 'pending',
            ]);

            $booking->layanans()->attach($layanans->pluck('id'));

            return $booking;
        });

        return redirect()
            ->route('dashboard')
            ->with('success', 'Booking PS-'.str_pad((string) $booking->id, 3, '0', STR_PAD_LEFT).' berhasil disimpan.');
    }

    private function userBookings(): array
    {
        return Booking::query()
            ->with(['layanans', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get()
            ->map(fn (Booking $booking): array => [
                'kodeBooking' => 'PS-'.str_pad((string) $booking->id, 3, '0', STR_PAD_LEFT),
                'namaPelanggan' => $booking->user?->name ?? auth()->user()?->name,
                'nomorPlat' => $booking->nomor_plat,
                'jenisKendaraan' => $booking->jenis_kendaraan,
                'merekKendaraan' => $booking->merek_kendaraan,
                'jenisService' => $booking->layanans->pluck('nama')->all(),
                'tanggalService' => $booking->start_time?->format('Y-m-d'),
                'jamService' => $booking->start_time?->format('H:i'),
                'estimasiBiaya' => $booking->total_estimasi_harga,
                'estimasiDurasi' => $booking->total_estimasi_durasi,
                'statusBooking' => $this->statusLabel($booking->status),
            ])
            ->all();
    }

    private function statusLabel(string $status): string
    {
        return match ($status) {
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => 'Menunggu',
        };
    }

}
