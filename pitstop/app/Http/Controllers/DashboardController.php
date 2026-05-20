<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Layanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function home(Request $request)
    {
        $now = now();
        $firstVisit = $request->session()->get('home_first_visit_at', $now->toDateTimeString());

        $request->session()->put('home_first_visit_at', $firstVisit);
        $request->session()->put('home_last_visit_at', $now->toDateTimeString());
        $request->session()->increment('home_visit_count');

        return view('index', [
            'layanans' => Layanan::aktif()->orderBy('nama')->get(),
            'bookings' => auth()->check() && ! auth()->user()->isAdmin()
                ? $this->userBookings()
                : [],
            'visitCount' => $request->session()->get('home_visit_count', 1),
            'firstVisitAt' => $this->formatVisitTime($firstVisit),
            'lastVisitAt' => $this->formatVisitTime($now),
        ]);
    }

    public function resetVisits(Request $request): RedirectResponse
    {
        $request->session()->forget([
            'home_visit_count',
            'home_first_visit_at',
            'home_last_visit_at',
        ]);

        return redirect()->route('home');
    }

    public function index()
    {
        return view('dashboard', [
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

    private function formatVisitTime($time): string
    {
        return Carbon::parse($time)
            ->timezone(config('app.timezone'))
            ->format('d M Y H:i');
    }

}
