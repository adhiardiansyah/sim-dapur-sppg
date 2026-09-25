<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Menu;
use App\Models\MenuBahan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuKomposisiController extends Controller
{
    public function store(Request $request, Menu $menu): RedirectResponse
    {
        $data = $request->validate([
            'bahan_id' => ['required', 'exists:bahan_baku,id'],
            'jumlah_per_porsi' => ['required', 'numeric', 'gt:0'],
        ], [
            'required' => ':attribute wajib diisi.',
            'gt' => 'Jumlah per porsi harus lebih dari nol.',
        ]);

        $bahan = BahanBaku::findOrFail($data['bahan_id']);
        MenuBahan::updateOrCreate(
            ['menu_id' => $menu->id, 'bahan_id' => $bahan->id],
            ['jumlah_per_porsi' => $data['jumlah_per_porsi'], 'satuan' => $bahan->satuan]
        );

        return redirect()->route('menu.show', $menu)->with('sukses', 'Komposisi bahan berhasil disimpan.');
    }

    public function destroy(Menu $menu, MenuBahan $komposisi): RedirectResponse
    {
        $komposisi->delete();

        return redirect()->route('menu.show', $menu)->with('sukses', 'Komposisi bahan berhasil dihapus.');
    }
}
