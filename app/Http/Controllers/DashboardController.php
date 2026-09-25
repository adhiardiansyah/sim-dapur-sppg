<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\JadwalMenu;
use App\Models\Penerima;
use App\Models\Sekolah;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $jadwalHariIni = JadwalMenu::with(['menu', 'produksi'])
            ->whereDate('tanggal', today())
            ->orderBy('id')
            ->get();

        return view('dashboard', [
            'jumlahSekolah' => Sekolah::where('aktif', true)->count(),
            'jumlahPenerima' => Penerima::where('aktif', true)->count(),
            'jumlahBahan' => BahanBaku::count(),
            'bahanRendah' => BahanBaku::whereColumn('stok', '<=', 'stok_minimum')
                ->orderBy('stok')->limit(5)->get(),
            'jadwalHariIni' => $jadwalHariIni,
        ]);
    }
}
