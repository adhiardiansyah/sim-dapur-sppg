<?php

namespace App\Http\Controllers;

use App\Models\JadwalMenu;
use App\Models\Produksi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProduksiController extends Controller
{
    public function index(): View
    {
        return view('produksi.index', [
            'produksi' => Produksi::with('jadwal.menu')
                ->orderByDesc('tanggal')->orderByDesc('id')->paginate(15),
        ]);
    }

    public function create(Request $request): View
    {
        return view('produksi.create', [
            'jadwalTersedia' => JadwalMenu::with('menu')
                ->where('status', 'direncanakan')
                ->orderBy('tanggal')
                ->get(),
            'terpilih' => $request->integer('jadwal_id'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'jadwal_id' => ['required', 'exists:jadwal_menu,id'],
            'porsi_realisasi' => ['required', 'integer', 'min:1'],
            'catatan' => ['nullable', 'string'],
        ], [
            'required' => ':attribute wajib diisi.',
        ]);

        $jadwal = JadwalMenu::with('menu.menuBahan.bahan')->findOrFail($data['jadwal_id']);

        if ($jadwal->status !== 'direncanakan') {
            return back()->withErrors(['jadwal_id' => 'Jadwal ini sudah diproduksi.'])->withInput();
        }

        // UC-11 alur alternatif: cek kecukupan stok sebelum produksi disimpan
        $kurang = [];
        foreach ($jadwal->menu->menuBahan as $komposisi) {
            $butuh = (float) $komposisi->jumlah_per_porsi * $data['porsi_realisasi'];
            $stok = (float) $komposisi->bahan->stok;
            if ($stok < $butuh) {
                $kurang[] = sprintf(
                    '%s (butuh %s %s, stok %s %s)',
                    $komposisi->bahan->nama,
                    number_format($butuh, 3, ',', '.'), $komposisi->bahan->satuan,
                    number_format($stok, 3, ',', '.'), $komposisi->bahan->satuan
                );
            }
        }
        if ($kurang !== []) {
            return back()->withErrors([
                'jadwal_id' => 'Stok tidak cukup: ' . implode('; ', $kurang) . '. Lakukan pengadaan terlebih dahulu.',
            ])->withInput();
        }

        DB::transaction(function () use ($jadwal, $data) {
            Produksi::create([
                'jadwal_id' => $jadwal->id,
                'tanggal' => $jadwal->tanggal,
                'porsi_realisasi' => $data['porsi_realisasi'],
                'status' => 'berjalan',
                'catatan' => $data['catatan'] ?? null,
            ]);

            foreach ($jadwal->menu->menuBahan as $komposisi) {
                $pakai = (float) $komposisi->jumlah_per_porsi * $data['porsi_realisasi'];
                $komposisi->bahan->decrement('stok', $pakai);
            }

            $jadwal->update(['status' => 'diproduksi']);
        });

        return redirect()->route('produksi.index')
            ->with('sukses', 'Produksi berhasil dicatat. Stok bahan telah dikurangi otomatis (F-11).');
    }

    public function selesai(Produksi $produksi): RedirectResponse
    {
        if ($produksi->status !== 'berjalan') {
            return back()->with('sukses', 'Produksi ini sudah selesai.');
        }
        DB::transaction(function () use ($produksi) {
            $produksi->update(['status' => 'selesai']);
            $produksi->jadwal->update(['status' => 'selesai']);
        });

        return redirect()->route('produksi.index')->with('sukses', 'Produksi ditandai selesai.');
    }
}
