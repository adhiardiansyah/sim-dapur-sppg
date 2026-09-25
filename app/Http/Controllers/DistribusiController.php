<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\Produksi;
use App\Models\Sekolah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DistribusiController extends Controller
{
    public function index(): View
    {
        return view('distribusi.index', [
            'distribusi' => Distribusi::with(['produksi.jadwal.menu', 'sekolah', 'petugas'])
                ->orderByDesc('id')->paginate(15),
            'bolehKelola' => auth()->user()->role === 'kepala_sppg',
            'bolehKirim' => auth()->user()->role === 'petugas',
        ]);
    }

    public function create(): View
    {
        return view('distribusi.create', [
            'produksi' => Produksi::with('jadwal.menu')
                ->whereIn('status', ['berjalan', 'selesai'])
                ->orderByRaw("CASE WHEN status = 'berjalan' THEN 0 ELSE 1 END")
                ->orderByDesc('id')->get(),
            'sekolah' => Sekolah::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'produksi_id' => ['required', 'exists:produksi,id'],
            'sekolah_id' => ['required', 'exists:sekolah,id'],
            'jumlah_porsi' => ['required', 'integer', 'min:1'],
        ], ['required' => ':attribute wajib diisi.']);

        Distribusi::create($data + ['status' => 'dijadwalkan']);

        return redirect()->route('distribusi.index')->with('sukses', 'Jadwal distribusi berhasil ditambahkan.');
    }

    public function kirim(Distribusi $distribusi): RedirectResponse
    {
        if ($distribusi->status !== 'dijadwalkan') {
            return back()->with('sukses', 'Pengiriman ini sudah diproses.');
        }
        $distribusi->update([
            'status' => 'dikirim',
            'jam_berangkat' => now()->format('H:i:s'),
            'petugas_id' => auth()->id(),
        ]);

        return back()->with('sukses', 'Status pengiriman diperbarui: dikirim.');
    }

    public function terima(Distribusi $distribusi): RedirectResponse
    {
        if ($distribusi->status !== 'dikirim') {
            return back()->with('sukses', 'Tandai dikirim terlebih dahulu.');
        }
        $distribusi->update([
            'status' => 'diterima',
            'jam_tiba' => now()->format('H:i:s'),
        ]);

        return back()->with('sukses', 'Status pengiriman diperbarui: diterima sekolah.');
    }

    public function destroy(Distribusi $distribusi): RedirectResponse
    {
        if ($distribusi->status !== 'dijadwalkan') {
            return back()->with('sukses', 'Hanya jadwal berstatus dijadwalkan yang dapat dihapus.');
        }
        $distribusi->delete();

        return back()->with('sukses', 'Jadwal distribusi dihapus.');
    }
}
