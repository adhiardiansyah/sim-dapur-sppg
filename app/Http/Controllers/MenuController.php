<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public const KATEGORI = ['sarapan', 'makan_siang', 'snack'];

    public function index(): View
    {
        return view('menu.index', [
            'menu' => Menu::withCount('menuBahan')->orderBy('nama_menu')->get(),
        ]);
    }

    public function create(): View
    {
        return view('menu.form', ['menu' => new Menu()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Menu::create($this->validasi($request));

        return redirect()->route('menu.index')->with('sukses', 'Menu berhasil ditambahkan. Lengkapi komposisi bahan pada halaman detail menu.');
    }

    public function show(Menu $menu): View
    {
        $menu->load(['menuBahan.bahan']);

        return view('menu.show', [
            'menu' => $menu,
            'bahan' => \App\Models\BahanBaku::orderBy('nama')->get(),
        ]);
    }

    public function edit(Menu $menu): View
    {
        return view('menu.form', ['menu' => $menu]);
    }

    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $menu->update($this->validasi($request));

        return redirect()->route('menu.index')->with('sukses', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        if ($menu->jadwal()->exists()) {
            return back()->with('sukses', 'Menu tidak dapat dihapus karena sudah pernah dijadwalkan.');
        }
        $menu->delete();

        return redirect()->route('menu.index')->with('sukses', 'Menu berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama_menu' => ['required', 'string', 'max:150'],
            'kategori_waktu' => ['required', 'in:' . implode(',', self::KATEGORI)],
            'status' => ['required', 'in:aktif,nonaktif'],
        ], ['required' => ':attribute wajib diisi.']);
    }
}
