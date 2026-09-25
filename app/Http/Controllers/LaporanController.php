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
        [$jenis, $dari, $sampai] = $this->parameter($request);

        return view('laporan.index', $this->data($jenis, $dari, $sampai) + [
            'jenis' => $jenis,
            'jenisLabel' => self::JENIS[$jenis],
            'dari' => $dari,
            'sampai' => $sampai,
        ]);
    }

    /**
     * Halaman cetak: tampilan dokumen bersih (tanpa navigasi) yang
     * otomatis membuka dialog cetak.
     */
    public function cetak(Request $request): View
    {
        [$jenis, $dari, $sampai] = $this->parameter($request);

        return view('laporan.cetak', $this->data($jenis, $dari, $sampai) + [
            'jenis' => $jenis,
            'jenisLabel' => self::JENIS[$jenis],
            'dari' => $dari,
            'sampai' => $sampai,
        ]);
    }

    private function parameter(Request $request): array
    {
        $jenis = $request->input('jenis', 'produksi');
        if (! array_key_exists($jenis, self::JENIS)) {
            $jenis = 'produksi';
        }

        return [$jenis, $request->date('dari') ?? now()->startOfMonth(), $request->date('sampai') ?? now()->endOfMonth()];
    }

    private function data(string $jenis, $dari, $sampai): array
    {
        if ($jenis === 'produksi') {
            return ['produksi' => Produksi::with('jadwal.menu')
                ->whereBetween('tanggal', [$dari, $sampai])->orderBy('tanggal')->get()];
        }

        if ($jenis === 'distribusi') {
            return ['distribusi' => Distribusi::with(['produksi.jadwal.menu', 'sekolah', 'petugas'])
                ->whereHas('produksi', fn ($q) => $q->whereBetween('tanggal', [$dari, $sampai]))
                ->orderBy('id')->get()];
        }

        if ($jenis === 'stok') {
            return ['bahan' => BahanBaku::orderBy('nama')->get()];
        }

        $pengadaan = StokMasuk::with('bahan')
            ->whereBetween('tanggal', [$dari, $sampai])->get();

        return [
            'pengadaan' => $pengadaan,
            'totalPengadaan' => $pengadaan->sum(fn ($s) => (float) $s->jumlah * (float) ($s->harga_satuan ?? 0)),
            'totalPorsi' => (int) Produksi::whereBetween('tanggal', [$dari, $sampai])->sum('porsi_realisasi'),
        ];
    }
}
