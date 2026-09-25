<?php

namespace App\Http\Controllers;

use App\Models\JadwalMenu;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalMenuController extends Controller
{
    public function index(): View
    {
        return view('jadwal.index', [
            'jadwal' => JadwalMenu::with(['menu', 'produksi'])
                ->orderByDesc('tanggal')->orderBy('id')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('jadwal.form', [
            'jadwal' => new JadwalMenu(['tanggal' => today()->toDateString(), 'jumlah_porsi' => 100]),
            'menu' => Menu::where('status', 'aktif')->orderBy('nama_menu')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        JadwalMenu::create($this->validasi($request) + ['dibuat_oleh' => auth()->id(), 'status' => 'direncanakan']);

        return redirect()->route('jadwal.index')->with('sukses', 'Perencanaan menu berhasil disimpan.');
    }

    public function edit(JadwalMenu $jadwal): View
    {
        $this->pastikanMasihDirencanakan($jadwal);

        return view('jadwal.form', [
            'jadwal' => $jadwal,
            'menu' => Menu::where('status', 'aktif')->orderBy('nama_menu')->get(),
        ]);
    }

    public function update(Request $request, JadwalMenu $jadwal): RedirectResponse
    {
        $this->pastikanMasihDirencanakan($jadwal);
        $jadwal->update($this->validasi($request));

        return redirect()->route('jadwal.index')->with('sukses', 'Perencanaan menu berhasil diperbarui.');
    }

    public function destroy(JadwalMenu $jadwal): RedirectResponse
    {
        $this->pastikanMasihDirencanakan($jadwal);
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('sukses', 'Perencanaan menu berhasil dihapus.');
    }

    /**
     * F-09: kalkulasi kebutuhan bahan baku otomatis (menu × jumlah porsi)
     * beserta perbandingan terhadap stok tersedia.
     */
    public function kebutuhan(JadwalMenu $jadwal): View
    {
        $jadwal->load('menu.menuBahan.bahan');

        $butuh = $jadwal->menu->menuBahan->map(function ($komposisi) use ($jadwal) {
            $total = (float) $komposisi->jumlah_per_porsi * $jadwal->jumlah_porsi;
            $stok = (float) $komposisi->bahan->stok;

            return (object) [
                'bahan' => $komposisi->bahan,
                'per_porsi' => (float) $komposisi->jumlah_per_porsi,
                'total' => $total,
                'stok' => $stok,
                'cukup' => $stok >= $total,
                'sisa_setelah_produksi' => $stok - $total,
            ];
        });

        return view('jadwal.kebutuhan', [
            'jadwal' => $jadwal,
            'butuh' => $butuh,
            'semuaCukup' => $butuh->every(fn ($b) => $b->cukup),
        ]);
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'tanggal' => ['required', 'date'],
            'menu_id' => ['required', 'exists:menu,id'],
            'jumlah_porsi' => ['required', 'integer', 'min:1'],
        ], [
            'required' => ':attribute wajib diisi.',
            'min' => 'Jumlah porsi minimal 1.',
        ]);
    }

    private function pastikanMasihDirencanakan(JadwalMenu $jadwal): void
    {
        if ($jadwal->status !== 'direncanakan') {
            abort(403, 'Jadwal yang sudah diproduksi tidak dapat diubah atau dihapus.');
        }
    }
}
