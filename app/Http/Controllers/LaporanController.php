<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Distribusi;
use App\Models\Produksi;
use App\Models\StokMasuk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public const JENIS = [
        'produksi' => 'Produksi',
        'distribusi' => 'Distribusi',
        'stok' => 'Stok Bahan Baku',
        'anggaran' => 'Realisasi Anggaran',
    ];

    public function index(Request $request): View
    {
        $jenis = $request->input('jenis', 'produksi');
        if (! array_key_exists($jenis, self::JENIS)) {
            $jenis = 'produksi';
        }

        $dari = $request->date('dari') ?? now()->startOfMonth();
        $sampai = $request->date('sampai') ?? now()->endOfMonth();

        $data = [
            'jenis' => $jenis,
            'jenisLabel' => self::JENIS[$jenis],
            'dari' => $dari,
            'sampai' => $sampai,
        ];

        if ($jenis === 'produksi') {
            $data['produksi'] = Produksi::with('jadwal.menu')
                ->whereBetween('tanggal', [$dari, $sampai])
                ->orderBy('tanggal')->get();
        } elseif ($jenis === 'distribusi') {
            $data['distribusi'] = Distribusi::with(['produksi.jadwal.menu', 'sekolah', 'petugas'])
                ->whereHas('produksi', fn ($q) => $q->whereBetween('tanggal', [$dari, $sampai]))
                ->orderBy('id')->get();
        } elseif ($jenis === 'stok') {
            $data['bahan'] = BahanBaku::orderBy('nama')->get();
        } elseif ($jenis === 'anggaran') {
            $pengadaan = StokMasuk::with('bahan')
                ->whereBetween('tanggal', [$dari, $sampai])
                ->get();
            $totalPorsi = Produksi::whereBetween('tanggal', [$dari, $sampai])->sum('porsi_realisasi');
            $data['pengadaan'] = $pengadaan;
            $data['totalPengadaan'] = $pengadaan->sum(fn ($s) => (float) $s->jumlah * (float) ($s->harga_satuan ?? 0));
            $data['totalPorsi'] = (int) $totalPorsi;
        }

        return view('laporan.index', $data);
    }
}
